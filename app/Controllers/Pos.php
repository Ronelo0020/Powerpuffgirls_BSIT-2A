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
        // 1. Gamit kita getPost() kay FormData na ang gin-send halin sa JS
        $items = json_decode($this->request->getPost('items'));
        $total_amount = $this->request->getPost('total_amount');
        $payment_method = $this->request->getPost('payment_method');
        $gcash_reference = $this->request->getPost('gcash_reference');

        if (empty($items)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Tray is empty.']);
        }

        $db = \Config\Database::connect();

        // Check if GCash Reference is already used (Prevention is better than try-catch)
        if ($payment_method === 'GCash' && !empty($gcash_reference)) {
            $exists = $db->table('orders')->where('gcash_reference', $gcash_reference)->countAllResults();
            if ($exists > 0) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Reference Number na-gamit na!']);
            }
        }

        $db->transStart(); 

        // --- FILE UPLOAD LOGIC ---
        $screenshotName = null;
        $file = $this->request->getFile('payment_screenshot');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            // I-save ang image sa public/uploads/receipts/
            $screenshotName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/receipts/', $screenshotName);
        }

        // 2. Save to 'orders' table
        $orderData = [
            'user_id'            => session()->get('user_id') ?? 1,
            'total_amount'       => $total_amount,
            'payment_method'     => $payment_method,
            'gcash_reference'    => $gcash_reference ?: null,
            'payment_screenshot' => $screenshotName, 
            'order_date'         => date('Y-m-d H:i:s')
        ];
        
        $db->table('orders')->insert($orderData);
        $orderId = $db->insertID(); 

        // 3. Save items & Update Stocks
        foreach ($items as $item) {
            $db->table('order_items')->insert([
                'order_id'   => $orderId,
                'product_id' => $item->id,
                'quantity'   => $item->qty,
                'price'      => $item->price
            ]);
            
            // Bawasan ang stock sa products table
            $db->table('products')
               ->where('id', $item->id)
               ->set('stock', 'stock - ' . (int)$item->qty, false)
               ->update();
        }

        $db->transComplete(); 

        if ($db->transStatus() === FALSE) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Database failure.']);
        }

        return $this->response->setJSON(['status' => 'success', 'message' => 'Order Pushed!']);
    }
}