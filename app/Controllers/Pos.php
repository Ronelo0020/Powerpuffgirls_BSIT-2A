<?php 

namespace App\Controllers;

class Pos extends BaseController {

    public function index() {
        $db = \Config\Database::connect();
        
        // Naka-select lahat para makuha ang 'image', 'product_name', 'price', at 'stock'
        $data['products'] = $db->table('products')
                               ->where('stock >', 0) // Optional: Para hindi lumabas ang out of stock
                               ->get()
                               ->getResultArray();

        return view('pos_view', $data);
    }
public function save_order() {
        $items = json_decode($this->request->getPost('items'));
        $total_amount = $this->request->getPost('total_amount');
        $payment_method = $this->request->getPost('payment_method');
        $gcash_reference = $this->request->getPost('gcash_reference');
        // Idagdag ang mga ito para sa payment details
        $payment = $this->request->getPost('payment');
        $change_amount = $this->request->getPost('change_amount');

        if (empty($items)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Tray is empty.']);
        }

        $db = \Config\Database::connect();

        if ($payment_method === 'GCash' && !empty($gcash_reference)) {
            $exists = $db->table('orders')->where('gcash_reference', $gcash_reference)->countAllResults();
            if ($exists > 0) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Reference Number na-gamit na!']);
            }
        }

        $db->transStart(); 

        $screenshotName = null;
        $file = $this->request->getFile('payment_screenshot');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $screenshotName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/receipts/', $screenshotName);
        }

        // Siguraduhin na kasama ang payment at change_amount base sa ERD mo
        $orderData = [
            'user_id'            => session()->get('user_id') ?? 1,
            'total_amount'       => $total_amount,
            'payment'            => $payment,
            'change_amount'      => $change_amount,
            'payment_method'     => $payment_method,
            'gcash_reference'    => $gcash_reference ?: null,
            'payment_screenshot' => $screenshotName, 
            'order_date'         => date('Y-m-d H:i:s')
        ];
        
        $db->table('orders')->insert($orderData);
        $orderId = $db->insertID(); // Kinukuha ang Generated ID

        foreach ($items as $item) {
            $db->table('order_items')->insert([
                'order_id'   => $orderId,
                'product_id' => $item->id,
                'quantity'   => $item->qty,
                'price'      => $item->price
            ]);
            
            $db->table('products')
               ->where('id', $item->id)
               ->set('stock', 'stock - ' . (int)$item->qty, false)
               ->update();
        }

        $db->transComplete(); 

        if ($db->transStatus() === FALSE) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Database failure.']);
        }

        // IMPORTANTE: Ibalik ang order_id sa JSON response
        return $this->response->setJSON([
            'status' => 'success', 
            'message' => 'Order Pushed!',
            'order_id' => $orderId // Dito kukunin ng JS ang ID para sa resibo
        ]);
    }
}
