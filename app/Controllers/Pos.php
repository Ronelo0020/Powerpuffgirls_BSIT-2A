<?php 

namespace App\Controllers;

class Pos extends BaseController {

    public function index() {
        $db = \Config\Database::connect();
        
        $data['products'] = $db->table('products')
                               ->where('stock >', 0)
                               ->get()
                               ->getResultArray();

        return view('pos_view', $data);
    }

    public function save_order() {
        $items = json_decode($this->request->getPost('items'));
        $total_amount = $this->request->getPost('total_amount');
        $payment_method = $this->request->getPost('payment_method');
        $gcash_reference = $this->request->getPost('gcash_reference');
        $payment = $this->request->getPost('payment');
        $change_amount = $this->request->getPost('change_amount');

        if (empty($items)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Tray is empty.']);
        }

        $db = \Config\Database::connect();

        // STOCK VALIDATION (Pre-check)
        foreach ($items as $item) {
            $product = $db->table('products')->where('id', $item->id)->get()->getRow();
            
            if (!$product || $product->stock < $item->qty) {
                return $this->response->setJSON([
                    'status' => 'error', 
                    'message' => 'Kulang ang stock para sa: ' . ($product->product_name ?? 'Unknown Item') . 
                                 '. (Current stock: ' . ($product->stock ?? 0) . ')'
                ]);
            }
        }

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
    // Ito ang mag-ge-generate ng random name (e.g., 1715423851_abc123.jpg)
    $screenshotName = $file->getRandomName();
    
    // Ang FCPATH ay tumuturo na sa '...\public\'
    // Kaya idudugtong na lang natin ang folder path mula doon
    $file->move(FCPATH . 'assets/img/payments', $screenshotName);
}

// Siguraduhin na 'payment_screenshot' ang key sa iyong array
$orderData = [
    // ... ibang data
    'payment_screenshot' => $screenshotName, 
    'order_date'         => date('Y-m-d H:i:s')
];

$orderData = [
    'user_id'            => session()->get('user_id') ?? 1,
    'total_amount'       => $total_amount,
    'payment'            => $payment,
    'change_amount'      => $change_amount,
    'payment_method'     => $payment_method,
    'gcash_reference'    => $gcash_reference ?: null,
    'payment_screenshot' => $screenshotName, // Dito mase-save ang random filename
    'order_date'         => date('Y-m-d H:i:s')
];
        
        $db->table('orders')->insert($orderData);
        $orderId = $db->insertID(); 

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

        return $this->response->setJSON([
            'status' => 'success', 
            'message' => 'Order Pushed!',
            'order_id' => $orderId 
        ]);
    }
}