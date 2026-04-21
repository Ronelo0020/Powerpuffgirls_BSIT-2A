<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riverside | Sales Analytics</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        :root { --riverside-red: #ff4d4d; --sidebar-bg: #212529; --body-bg: #f8f9fa; }
        body { background-color: var(--body-bg); font-family: 'Poppins', sans-serif; margin: 0; display: flex; min-height: 100vh; }
        .sidebar { width: 260px; background: var(--sidebar-bg); padding: 30px 20px; display: flex; flex-direction: column; color: white; flex-shrink: 0; }
        .nav-link { color: rgba(255,255,255,0.7); padding: 12px 15px; border-radius: 10px; margin-bottom: 5px; transition: 0.3s; text-decoration: none; display: flex; align-items: center; font-size: 0.9rem; }
        .nav-link.active { background: rgba(255,255,255,0.1); color: var(--riverside-red); }
        .main-content { flex: 1; padding: 30px; overflow-y: auto; }
        .stat-card { background: #fff; border-radius: 15px; border: 1px solid #dee2e6; padding: 25px; box-shadow: 0 4px 12px rgba(0,0,0,0.03); height: 100%; }
        .stat-label { font-size: 0.75rem; text-transform: uppercase; font-weight: 600; color: #6c757d; letter-spacing: 0.5px; }
        .stat-value { font-size: 1.6rem; font-weight: 700; color: #212529; margin-top: 5px; }
        .chart-container { background: white; border-radius: 15px; border: 1px solid #dee2e6; padding: 25px; box-shadow: 0 4px 12px rgba(0,0,0,0.03); }
        .btn-print { border: 1px solid #dee2e6; background: white; color: #495057; font-weight: 600; padding: 8px 20px; border-radius: 8px; transition: 0.3s; }
        
        /* Custom Button Style para sa Legend */
        .chart-toggle-btn { 
            border: 2px solid var(--riverside-red); 
            background: rgba(255, 77, 77, 0.05); 
            color: var(--riverside-red); 
            font-weight: 600; 
            padding: 8px 20px; 
            border-radius: 30px; 
            transition: 0.3s;
            font-size: 0.85rem;
        }
        .chart-toggle-btn:hover { background: var(--riverside-red); color: white; }
        .chart-toggle-btn.hidden-data { opacity: 0.5; background: #e9ecef; border-color: #adb5bd; color: #6c757d; }

        @media print { .sidebar, .btn-print, .chart-toggle-btn { display: none !important; } .main-content { padding: 0; } }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="mb-5 text-center">
        <h4 class="fw-bold"><span style="color:var(--riverside-red)">Riverside</span> Café</h4>
        <small class="text-muted">Analytics Panel</small>
    </div>
    <nav class="d-flex flex-column h-100">
        <a href="<?= base_url('dashboard') ?>" class="nav-link <?= (uri_string() == 'dashboard') ? 'active' : '' ?>">
            <i class="fas fa-chart-pie me-3"></i> Overview
        </a>
        <a href="<?= base_url('products') ?>" class="nav-link <?= (uri_string() == 'products') ? 'active' : '' ?>">
            <i class="fas fa-coffee me-3"></i> Menu & Inventory
        </a>
        <a href="<?= base_url('pos') ?>" class="nav-link <?= (uri_string() == 'pos') ? 'active' : '' ?>">
            <i class="fas fa-cash-register me-3"></i> Barista POS
        </a>

        <?php if (session()->get('role') === 'admin'): ?>
            <a href="<?= base_url('sales') ?>" class="nav-link <?= (uri_string() == 'sales') ? 'active' : '' ?>">
                <i class="fas fa-file-invoice-dollar me-3"></i> Sales Reports
            </a>
            <hr class="text-secondary opacity-25 mx-3">
            <p class="small text-muted px-3 mb-2" style="font-size: 0.65rem; letter-spacing: 1px;">ADMINISTRATION</p>
            <a href="<?= base_url('auth/manage') ?>" class="nav-link <?= (uri_string() == 'auth/manage') ? 'active' : '' ?>">
                <i class="fas fa-users-cog me-3"></i> Manage Staff
            </a>
        <?php endif; ?>
    </nav>
    <div class="mt-auto border-top pt-3">
        <a href="<?= base_url('logout') ?>" class="nav-link text-danger"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
    </div>
</div>

<div class="main-content">
    <div class="d-md-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">Sales Analytics</h2>
            <p class="text-muted small mb-0">Reviewing revenue performance and growth trends.</p>
        </div>
        <button onclick="window.print()" class="btn btn-print shadow-sm">
            <i class="fas fa-print me-2 text-primary"></i> Print Report
        </button>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="stat-card">
                <span class="stat-label">Today's Revenue</span>
                <div class="stat-value text-success">₱<?= number_format($daily_revenue, 2) ?></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <span class="stat-label">Monthly Orders</span>
                <div class="stat-value text-primary"><?= number_format($monthly_orders) ?></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <span class="stat-label">Grand Total Orders</span>
                <div class="stat-value text-dark"><?= number_format($total_orders) ?></div>
            </div>
        </div>
    </div>

    <div class="chart-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h6 class="fw-bold text-uppercase small text-muted mb-0">Revenue History (Last 7 Days)</h6>
            
            <?php if(!empty($chart_values)): ?>
                <button id="toggleRevenue" class="btn chart-toggle-btn shadow-sm">
                    <i class="fas fa-chart-line me-2"></i> Daily Revenue (₱)
                </button>
            <?php endif; ?>
        </div>

        <div style="height: 350px;">
            <?php if(!empty($chart_values)): ?>
                <canvas id="salesChart"></canvas>
            <?php else: ?>
                <div class="d-flex align-items-center justify-content-center h-100 flex-column text-muted">
                    <p>No sales data recorded.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    <?php if(!empty($chart_values)): ?>
    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode($chart_labels) ?>,
            datasets: [{
                label: 'Daily Revenue (₱)',
                data: <?= json_encode($chart_values) ?>,
                borderColor: '#ff4d4d',
                backgroundColor: 'rgba(255, 77, 77, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 5,
                pointBackgroundColor: '#ff4d4d'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false // Tinago natin yung default na square legend
                }
            },
            scales: {
                y: { 
                    beginAtZero: true, 
                    ticks: { callback: function(v) { return '₱' + v.toLocaleString(); } } 
                }
            }
        }
    });

    // Button Logic para sa Toggle
    document.getElementById('toggleRevenue').addEventListener('click', function() {
        const isVisible = salesChart.isDatasetVisible(0);
        if (isVisible) {
            salesChart.hide(0);
            this.classList.add('hidden-data');
            this.innerHTML = '<i class="fas fa-eye-slash me-2"></i> Show Revenue';
        } else {
            salesChart.show(0);
            this.classList.remove('hidden-data');
            this.innerHTML = '<i class="fas fa-chart-line me-2"></i> Daily Revenue (₱)';
        }
    });
    <?php endif; ?>
</script>
</body>
</html>