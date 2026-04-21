<?php 

namespace App\Controllers;

use App\Models\Order_model;

class Sales extends BaseController {

    public function index() {
        // --- SECURITY CHECK ---
        // Sinisiguro nito na Admin lang ang makaka-access sa logic na ito.
        if (session()->get('role') !== 'admin') {
            return redirect()->to(base_url('dashboard'))->with('msg', 'Access denied.');
        }

        $orderModel = model(Order_model::class);

        // 1. Daily Revenue
        // Gumamit tayo ng selectSum para mas malinis ang calculation ng total
        $daily = $orderModel->selectSum('total_amount')
                            ->where('DATE(order_date)', date('Y-m-d'))
                            ->first();

        // 2. Monthly Orders
        // Binibilang ang lahat ng successful transactions ngayong buwan
        $monthlyCount = $orderModel->where('MONTH(order_date)', date('m'))
                                   ->where('YEAR(order_date)', date('Y'))
                                   ->countAllResults();

        // 3. Total Transactions (Grand Total)
        $totalTransactions = $orderModel->countAllResults();

        // 4. Data para sa Chart (Last 7 Days Sales)
        // FIX: Inayos ang GROUP BY sa DATE(order_date) para hindi mag-merge ang sales 
        // kung sakaling magka-record sa parehong araw pero magkaibang taon.
        $chartData = $orderModel->select("DATE_FORMAT(order_date, '%D %b') as day, SUM(total_amount) as amount, DATE(order_date) as full_date")
                                ->where('order_date >=', date('Y-m-d', strtotime('-7 days'))) // FIX: Kukuha lang ng huling 7 araw
                                ->groupBy('full_date')
                                ->orderBy('full_date', 'ASC')
                                ->findAll();

        $data = [
            'daily_revenue'  => $daily['total_amount'] ?? 0,
            'monthly_orders' => $monthlyCount,
            'total_orders'   => $totalTransactions, // Variable name changed to be more accurate
            'chart_labels'   => array_column($chartData, 'day'),
            'chart_values'   => array_column($chartData, 'amount'),
            'title'          => 'Riverside | Sales Analytics'
        ];

        return view('sales_view', $data);
    }
}