<?php 

namespace App\Models;
use CodeIgniter\Model;

class User_model extends Model {
    protected $table      = 'users';
    protected $primaryKey = 'id';

    // FIX: Gindugangan sang 'profile_pic' para ma-save ang image filename
    protected $allowedFields = ['name', 'username', 'email', 'password', 'role', 'duty_day', 'phone', 'profile_pic', 'created_at', 'updated_at'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Ginagamit ini para mag-fetch sang staff list lang
     */
    public function getStaffMembers() {
        return $this->where('role', 'staff')
                    ->orderBy('name', 'ASC')
                    ->findAll();
    }

    /**
     * Check kon existing na ang username
     */
    public function checkUsername($username) {
        return $this->where('username', $username)->first();
    }
}