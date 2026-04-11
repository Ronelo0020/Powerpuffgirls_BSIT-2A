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
        :root { 
            --riverside-red: #ff4d4d; 
            --sidebar-bg: #212529; 
            --body-bg: #f8f9fa; 
        }
        
        body { 
            background-color: var(--body-bg); 
            font-family: 'Poppins', sans-serif; 
            margin: 0; 
            display: flex; 
            min-height: 100vh; 
        }

        /* Sidebar Consistency */
        .sidebar { 
            width: 260px; 
            background: var(--sidebar-bg); 
            padding: 30px 20px; 
            display: flex; 
            flex-direction: column; 
            color: white;
            flex-shrink: 0;
        }

        .nav-link { 
            color: rgba(255,255,255,0.7); 
            padding: 12px 15px; 
            border-radius: 10px; 
            margin-bottom: 5px; 
            transition: 0.3s; 
            text-decoration: none; 
            display: flex; 
            align-items: center;
            font-size: 0.9rem;
        }

        .nav-link.active { 
            background: rgba(255,255,255,0.1); 
            color: var(--riverside-red); 
        }

        /* Main Content Area */
        .main-content { flex: 1; padding: 30px; overflow-y: auto; }

        /* Stat Cards */
        .stat-card { 
            background: #fff; 
            border-radius: 15px; 
            border: 1px solid #dee2e6; 
            padding: 25px; 
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
            height: 100%;
        }

        .stat-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 600;
            color: #6c757d;
            letter-spacing: 0.5px;
        }

        .stat-value { 
            font-size: 1.6rem; 
            font-weight: 700; 
            color: #212529; 
            margin-top: 5px;
        }

        /* Chart Container */
        .chart-container {
            background: white;
            border-radius: 15px;
            border: 1px solid #dee2e6;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        }

        .btn-print {
            border: 1px solid #dee2e6;
            background: white;
            color: #495057;
            font-weight: 600;
            padding: 8px 20px;
            border-radius: 8px;
            transition: 0.3s;
        }

        .btn-print:hover {
            background: #f8f9fa;
            border-color: #ced4da;
        }

        @media print {
            .sidebar, .btn-print { display: none !important; }
            .main-content { padding: 0; }
            .chart-container, .stat-card { box-shadow: none; border: 1px solid #000; }
        }
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
    <a href="<?= base_url('sales') ?>" class="nav-link <?= (uri_string() == 'sales') ? 'active' : '' ?>">
        <i class="fas fa-file-invoice-dollar me-3"></i> Sales Reports
    </a>

    <?php if(session()->get('role') == 'admin'): ?>
        <hr class="text-secondary opacity-25 mx-3">
        <p class="small text-muted px-3 mb-2" style="font-size: 0.65rem; letter-spacing: 1px;">ADMINISTRATION</p>
        <a href="<?= base_url('auth/manage') ?>" class="nav-link <?= (uri_string() == 'auth/manage') ? 'active' : '' ?>">
            <i class="fas fa-users-cog me-3"></i> Manage Staff
        </a>
    <?php endif; ?>

   
</nav>
    <div class="mt-auto border-top pt-3">
        <a href="<?= base_url('auth/logout') ?>" class="nav-link text-danger"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
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
                <small class="text-muted">Total income today</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <span class="stat-label">Monthly Orders</span>
                <div class="stat-value text-primary"><?= number_format($monthly_orders) ?></div>
                <small class="text-muted">Successful transactions this month</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <span class="stat-label">Grand Total Orders</span>
                <div class="stat-value text-dark"><?= number_format($total_orders) ?></div>
                <small class="text-muted">Cumulative order count</small>
            </div>
        </div>
    </div>

    <div class="chart-container">
        <h6 class="fw-bold mb-4 text-uppercase small text-muted">Revenue History (Last 7 Days)</h6>
        <div style="height: 350px;">
            <?php if(!empty($chart_values)): ?>
                <canvas id="salesChart"></canvas>
            <?php else: ?>
                <div class="d-flex align-items-center justify-content-center h-100 flex-column text-muted">
                    <i class="fas fa-folder-open fa-3x mb-3"></i>
                    <p>No sales data recorded for the past 7 days.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    <?php if(!empty($chart_values)): ?>
    const ctx = document.getElementById('salesChart').getContext('2d');
    
    // Create a gradient for the line fill
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(255, 77, 77, 0.2)');
    gradient.addColorStop(1, 'rgba(255, 77, 77, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode($chart_labels) ?>,
            datasets: [{
                label: 'Daily Revenue (₱)',
                data: <?= json_encode($chart_values) ?>,
                borderColor: '#ff4d4d',
                backgroundColor: gradient,
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 6,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#ff4d4d',
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#f0f0f0' },
                    ticks: {
                        callback: function(value) { return '₱' + value.toLocaleString(); }
                    }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
    <?php endif; ?>
</script>

</body>
</html>
<!-- agus -->