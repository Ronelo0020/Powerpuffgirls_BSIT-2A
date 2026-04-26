<?php 

namespace App\Controllers;

use App\Models\Order_model;

class Sales extends BaseController {

    public function index() {
        // --- SECURITY CHECK ---
        if (session()->get('role') !== 'admin') {
            return redirect()->to(base_url('dashboard'))->with('msg', 'Access denied.');
        }

        $orderModel = model(Order_model::class);

        // 1. Daily Revenue
        $daily = $orderModel->selectSum('total_amount')
                            ->where('DATE(order_date)', date('Y-m-d'))
                            ->first();

        // 2. Overall Revenue (Lifetime Total)
        // Dito natin kukunin ang lahat ng pera na pumasok kahit anong petsa
        $overall = $orderModel->selectSum('total_amount')->first();

        // 3. Monthly Orders
        $monthlyCount = $orderModel->where('MONTH(order_date)', date('m'))
                                   ->where('YEAR(order_date)', date('Y'))
                                   ->countAllResults();

        // 4. Total Transactions (Grand Total count)
        $totalTransactions = $orderModel->countAllResults();

        // 5. Data para sa Chart (Last 7 Days Sales)
        $chartData = $orderModel->select("DATE_FORMAT(order_date, '%D %b') as day, SUM(total_amount) as amount, DATE(order_date) as full_date")
                                ->where('order_date >=', date('Y-m-d', strtotime('-7 days')))
                                ->groupBy('full_date')
                                ->orderBy('full_date', 'ASC')
                                ->findAll();

        $data = [
            'daily_revenue'  => $daily['total_amount'] ?? 0,
            'total_revenue'  => $overall['total_amount'] ?? 0, // NEW: Kabuuang kita
            'monthly_orders' => $monthlyCount,
            'total_orders'   => $totalTransactions,
            'chart_labels'   => array_column($chartData, 'day'),
            'chart_values'   => array_column($chartData, 'amount'),
            'title'          => 'Riverside | Sales Analytics'
        ];

        return view('sales_view', $data);
    }
}