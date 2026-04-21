<?php 

namespace App\Controllers;

use App\Models\Order_model;
use App\Models\Product_model;
use CodeIgniter\Controller;

class Dashboard extends BaseController {
    
    public function index() {
        if (!session()->get('logged_in')) {
        return redirect()->to(base_url('/'));
    }

    $db = \Config\Database::connect();
        
        // 1. Today's Total Sales
        $builderSales = $db->table('orders');
        $builderSales->selectSum('total_amount');
        $builderSales->where('DATE(order_date)', date('Y-m-d'));
        $querySales = $builderSales->get()->getRow();
        
        // 2. Recent Transactions with Joined Products
        $builderOrders = $db->table('orders');
        $builderOrders->select('orders.*, GROUP_CONCAT(products.product_name SEPARATOR ", ") as items');
        $builderOrders->join('order_items', 'order_items.order_id = orders.id', 'left');
        $builderOrders->join('products', 'products.id = order_items.product_id', 'left');
        $builderOrders->groupBy('orders.id');
        $builderOrders->orderBy('orders.order_date', 'DESC');
        $builderOrders->limit(10);
        $recentOrders = $builderOrders->get()->getResultArray();
        
        // 3. Trending Items (Best Sellers)
        $builderTrending = $db->table('order_items');
        $builderTrending->select('products.product_name, SUM(order_items.quantity) as total_qty');
        $builderTrending->join('products', 'products.id = order_items.product_id');
        $builderTrending->groupBy('order_items.product_id');
        $builderTrending->orderBy('total_qty', 'DESC');
        $builderTrending->limit(4);
        $trendingItems = $builderTrending->get()->getResultArray();

        // 4. Low Stock Count (Para sa Red Card)
        $builderLowStock = $db->table('products');
        $lowStockCount = $builderLowStock->where('stock <=', 5)->countAllResults();
        
        $data = [
            'total_sales'   => $querySales->total_amount ?? 0,
            'recent_orders' => $recentOrders,
            'trending'      => $trendingItems,
            'low_stock'     => $lowStockCount,
            'title'         => 'Riverside Café | Dashboard Overview'
        ];
        
        return view('dashboard', $data); 
    }
    // Sa loob ng class Dashboard extends BaseController

public function history() {
    if (!session()->get('logged_in')) {
        return redirect()->to(base_url('/'));
    }

    $db = \Config\Database::connect();
    
    // Kunin ang lahat ng orders (Full History)
    $builderOrders = $db->table('orders');
    $builderOrders->select('orders.*, GROUP_CONCAT(products.product_name SEPARATOR ", ") as items');
    $builderOrders->join('order_items', 'order_items.order_id = orders.id', 'left');
    $builderOrders->join('products', 'products.id = order_items.product_id', 'left');
    $builderOrders->groupBy('orders.id');
    $builderOrders->orderBy('orders.order_date', 'DESC');
    // Tinanggal ang ->limit(10) para lumabas lahat
    
    $data = [
        'all_orders' => $builderOrders->get()->getResultArray(),
        'title'      => 'Riverside Café | Transaction History'
    ];

    return view('transaction_history', $data); 
}
}