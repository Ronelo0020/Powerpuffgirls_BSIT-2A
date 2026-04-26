<?php 

namespace App\Controllers;

use App\Models\User_model;

class Auth extends BaseController {

    public function index() {
        return view('login');
    }

    public function register() {
        $session = session();
        if ($session->get('role') != 'admin') {
            return redirect()->to(base_url('dashboard'));
        }
        return view('auth/register'); 
    }

    public function loginProcess() {
        $session = session();
        $model = new User_model();
        
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        
        $user = $model->where('email', $email)->first();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $sessionData = [
                    'user_id'   => $user['id'],
                    'name'      => $user['name'],
                    'email'     => $user['email'],
                    'role'      => $user['role'],
                    'logged_in' => TRUE
                ];
                $session->set($sessionData);
                
                $db = \Config\Database::connect();
                $builder = $db->table('staff_logs');
                
                $logData = [
                    'staff_name' => $user['name'],
                    'login_time' => date('Y-m-d H:i:s'),
                    'status'     => 'On Duty'
                ];
                $builder->insert($logData);
                
                $session->set('current_log_id', $db->insertID());
                
                return redirect()->to(base_url('dashboard'));
            } else {
                return redirect()->back()->with('msg', 'Wrong Password.');
            }
        } else {
            return redirect()->back()->with('msg', 'Email not found.');
        }
    }
public function manage() {
    $session = session();
    if ($session->get('role') != 'admin') {
        return redirect()->to(base_url('dashboard'));
    }

    $model = new User_model();
    
    // Separar nga query para sa Admin kag Staff
    $data['admins'] = $model->where('role', 'admin')->findAll();
    $data['staff_members'] = $model->where('role', 'staff')->orderBy('name', 'ASC')->findAll();

    return view('auth/manage_staff', $data); 
}

    public function logout() {
        $session = session();
        $logId = $session->get('current_log_id');

        if ($logId) {
            $db = \Config\Database::connect();
            $builder = $db->table('staff_logs');
            $log = $builder->where('id', $logId)->get()->getRow();
            
            if ($log) {
                $loginTime = new \DateTime($log->login_time);
                $logoutTime = new \DateTime(date('Y-m-d H:i:s'));
                $interval = $loginTime->diff($logoutTime);
                $duration = $interval->format('%h hrs %i mins');

                $builder->where('id', $logId)->update([
                    'logout_time' => $logoutTime->format('Y-m-d H:i:s'),
                    'duration'    => $duration,
                    'status'      => 'Out'
                ]);
            }
        }

        $session->destroy();
        return redirect()->to(base_url('/'));
    }

    // Pag-save sang bag-o nga staff
    public function store() {
        $model = new User_model();
        $data = [
            'name'     => $this->request->getPost('name'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => $this->request->getPost('role') ?? 'staff',
            'duty_day' => $this->request->getPost('duty_day') 
        ];
        $model->insert($data);
        return redirect()->to(base_url('auth/manage'))->with('msg', 'Staff added!');
    }

    public function edit($id) {
        $model = new User_model();
        $data['staff'] = $model->find($id);
        
        if (!$data['staff']) {
            return redirect()->to('auth/manage')->with('msg', 'Staff not found!');
        }
        
        return view('auth/edit_staff', $data);
    }

    // FIXED: Updated Update Function para sa Image Upload
    public function update($id) {
        $model = new User_model();
        
        // 1. Prepare base data
        $data = [
            'name'     => $this->request->getPost('name'),
            'email'    => $this->request->getPost('email'),
            'role'     => $this->request->getPost('role'),
            'duty_day' => $this->request->getPost('duty_day'),
            'phone'    => $this->request->getPost('phone'),
        ];

        // 2. Handle Image Upload
        $file = $this->request->getFile('profile_pic');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Mag-generate sang random name para indi mag-duplicate
            $newName = $file->getRandomName();
            
            // I-move sa public/uploads/profiles
            if ($file->move(FCPATH . 'uploads/profiles', $newName)) {
                $data['profile_pic'] = $newName;
                
                // (Optional) Delete ang old picture para matinlo ang storage
                $old_data = $model->find($id);
                if (!empty($old_data['profile_pic']) && file_exists(FCPATH . 'uploads/profiles/' . $old_data['profile_pic'])) {
                    unlink(FCPATH . 'uploads/profiles/' . $old_data['profile_pic']);
                }
            }
        }
        
        if ($model->update($id, $data)) {
            return redirect()->to(base_url('auth/manage'))->with('msg', 'Updated Successfully!');
        } else {
            return redirect()->back()->with('msg', 'Update Failed!');
        }
    }

    public function delete($id) {
        $model = new User_model();
        
        // Delete man ang profile pic sa folder kung mag-delete staff
        $staff = $model->find($id);
        if (!empty($staff['profile_pic']) && file_exists(FCPATH . 'uploads/profiles/' . $staff['profile_pic'])) {
            unlink(FCPATH . 'uploads/profiles/' . $staff['profile_pic']);
        }

        $model->delete($id);
        return redirect()->to(base_url('auth/manage'))->with('msg', 'Staff Deleted!');
    }
}