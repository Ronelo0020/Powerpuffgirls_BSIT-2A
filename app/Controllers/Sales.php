<?php 

namespace App\Controllers;

use App\Models\Order_model;

class Sales extends BaseController {

    public function index() {
        // --- SECURITY CHECK (PINANATILI KO ITO) ---
        if (session()->get('role') !== 'admin') {
            return redirect()->to(base_url('dashboard'))->with('msg', 'Access denied.');
        }

        $orderModel = model(Order_model::class);

        // 1. Daily Revenue (Original Logic)
        $daily = $orderModel->selectSum('total_amount')
                            ->where('DATE(order_date)', date('Y-m-d'))
                            ->first();

        // 2. Overall Revenue (Original Logic)
        $overall = $orderModel->selectSum('total_amount')->first();

        // 3. Monthly Orders (Original Logic)
        $monthlyCount = $orderModel->where('MONTH(order_date)', date('m'))
                                   ->where('YEAR(order_date)', date('Y'))
                                   ->countAllResults();

        // 4. Total Transactions (Original Logic)
        $totalTransactions = $orderModel->countAllResults();

        // 5. Initial Data para sa Chart (Inayos lang para maging dynamic)
        $chartData = $this->_fetchRevenueData('daily');

        $data = [
            'daily_revenue'  => $daily['total_amount'] ?? 0,
            'total_revenue'  => $overall['total_amount'] ?? 0,
            'monthly_orders' => $monthlyCount,
            'total_orders'   => $totalTransactions,
            'chart_labels'   => $chartData['labels'],
            'chart_values'   => $chartData['values'],
            'title'          => 'Riverside | Sales Analytics'
        ];

        return view('sales_view', $data);
    }

    // NEW: AJAX Endpoint (Para sa filter buttons at clickable card)
    public function get_filtered_data($type) {
        if (session()->get('role') !== 'admin') {
            return $this->response->setStatusCode(403);
        }

        $data = $this->_fetchRevenueData($type);
        return $this->response->setJSON($data);
    }

    // Private helper para walang duplicate na code
    private function _fetchRevenueData($type) {
        $orderModel = model(Order_model::class);
        $labels = [];
        $values = [];

        if ($type == 'daily') {
            // Pinanatili ang iyong 7-day query logic
            $results = $orderModel->select("DATE_FORMAT(order_date, '%b %d') as label, SUM(total_amount) as amount, DATE(order_date) as full_date")
                                  ->where('order_date >=', date('Y-m-d', strtotime('-6 days')))
                                  ->groupBy('full_date')
                                  ->orderBy('full_date', 'ASC')
                                  ->findAll();
        } 
        elseif ($type == 'weekly') {
            // Last 5 Weeks
            $results = $orderModel->select("CONCAT('Week ', WEEK(order_date, 1)) as label, SUM(total_amount) as amount, WEEK(order_date, 1) as week_num")
                                  ->where('order_date >=', date('Y-m-d', strtotime('-5 weeks')))
                                  ->groupBy('week_num')
                                  ->orderBy('order_date', 'ASC')
                                  ->findAll();
        } 
        elseif ($type == 'monthly') {
            // Last 6 Months
            $results = $orderModel->select("DATE_FORMAT(order_date, '%M') as label, SUM(total_amount) as amount, MONTH(order_date) as month_num")
                                  ->where('order_date >=', date('Y-m-d', strtotime('-6 months')))
                                  ->groupBy('month_num')
                                  ->orderBy('order_date', 'ASC')
                                  ->findAll();
        } 
        elseif ($type == 'yearly') {
            // Last 3 Years
            $results = $orderModel->select("YEAR(order_date) as label, SUM(total_amount) as amount")
                                  ->groupBy('label')
                                  ->orderBy('label', 'ASC')
                                  ->findAll();
        }

        if ($results) {
            foreach ($results as $row) {
                $labels[] = $row['label'];
                $values[] = (float)$row['amount'];
            }
        }

        return ['labels' => $labels, 'values' => $values];
    }
}