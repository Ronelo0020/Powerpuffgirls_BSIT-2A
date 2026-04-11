<?php 

namespace App\Controllers;

// Import ang models
use App\Models\Product_model;
use App\Models\Order_model;

class Orders extends BaseController {

    public function pos() {
        // Paagi 1: Gamit ang model helper (Mas safe ini sa CI4 para malikawan ang class not found)
        $productModel = model('Product_model'); 

        // Load tanan nga products para sa Riverside Café Menu
        $products = $productModel->findAll();

        $data = [
            'products' => $products ? $products : [], // Siguraduhon nga indi null ang i-pasa sa view
            'title'    => 'Riverside Café | POS'
        ];

        return view('orders/pos', $data);
    }
}