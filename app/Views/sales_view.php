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
            --sidebar-dark: #000000;
            --bg-dark: #121212;
            --card-dark: #1a1a1a;
            --accent-gold: #ffcc4d; 
            --text-main: #ffffff;
            --text-muted: #b3b3b3;
        }

        body { 
            background-color: var(--bg-dark); 
            font-family: 'Poppins', sans-serif; 
            margin: 0; 
            display: flex; 
            height: 100vh; /* Para fix ang sidebar height */
            overflow: hidden;
            color: var(--text-main); 
        }

        /* --- SIDEBAR --- */
        .sidebar { 
            width: 260px; 
            background: var(--sidebar-dark); 
            padding: 30px 20px; 
            display: flex; 
            flex-direction: column; 
            border-right: 1px solid #333; 
            flex-shrink: 0; 
        }
        .nav-link { 
            color: var(--text-muted); 
            padding: 12px 15px; 
            border-radius: 10px; 
            margin-bottom: 5px; 
            transition: 0.3s; 
            text-decoration: none; 
            display: flex; 
            align-items: center; 
            font-size: 0.9rem; 
        }
        .nav-link:hover { color: white; background: rgba(255,255,255,0.05); }
        .nav-link.active { background: var(--accent-gold); color: black; font-weight: 600; }

        /* --- MAIN CONTENT --- */
        .main-content { flex: 1; padding: 30px; overflow-y: auto; }
        
        .stat-card { 
            background: var(--card-dark); 
            border-radius: 20px; 
            border: 1px solid #333; 
            padding: 25px; 
            height: 100%;
        }
        .stat-label { font-size: 0.70rem; text-transform: uppercase; font-weight: 600; color: var(--text-muted); letter-spacing: 1px; }
        .stat-value { font-size: 1.6rem; font-weight: 700; color: var(--text-main); margin-top: 5px; }

        .chart-container { 
            background: var(--card-dark); 
            border-radius: 20px; 
            border: 1px solid #333; 
            padding: 30px; 
            margin-top: 20px;
        }

        .btn-print { border: 1px solid #444; background: #1a1a1a; color: white; padding: 10px 25px; border-radius: 12px; transition: 0.3s; }
        .btn-print:hover { border-color: var(--accent-gold); color: var(--accent-gold); }

        @media print { .sidebar, .btn-print { display: none !important; } .main-content { padding: 0; } }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="mb-5 text-center">
        <h4 class="fw-bold"><span style="color:var(--accent-gold)">Riverside</span> Café</h4>
        <small class="text-white text-uppercase" style="font-size: 0.65rem; letter-spacing: 1px; opacity: 0.6;">Management System</small>
    </div>
    
    <nav class="d-flex flex-column h-100">
        <a href="<?= base_url('dashboard') ?>" class="nav-link"><i class="fas fa-th-large me-3"></i> Dashboard</a>
        <a href="<?= base_url('products') ?>" class="nav-link"><i class="fas fa-coffee me-3"></i> Menu & Inventory</a>
        <a href="<?= base_url('pos') ?>" class="nav-link"><i class="fas fa-cash-register me-3"></i> Barista POS</a>
        <a href="<?= base_url('sales') ?>" class="nav-link active"><i class="fas fa-chart-line me-3"></i> Sales Analytics</a>
        <a href="<?= base_url('auth/manage') ?>" class="nav-link <?= (uri_string() == 'auth/manage') ? 'active' : '' ?>">
                <i class="fas fa-users me-3"></i> Manage Staff
            </a>
        
        <div class="mt-auto">
            <a href="<?= base_url('logout') ?>" class="nav-link text-danger"><i class="fas fa-sign-out-alt me-3"></i> Logout</a>
        </div>
    </nav>
</div>

<div class="main-content">
    <div class="d-md-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold mb-0 text-white">Sales Analytics</h2>
            <p style="color: var(--text-muted);" class="small mb-0">Track your business growth and revenue performance.</p>
        </div>
        <button onclick="window.print()" class="btn btn-print shadow-sm">
            <i class="fas fa-print me-2"></i> Print Report
        </button>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <span class="stat-label">Daily Revenue</span>
                <div class="stat-value text-success">₱<?= number_format($daily_revenue, 2) ?></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card" style="border-left: 4px solid var(--accent-gold);">
                <span class="stat-label" style="color: var(--accent-gold);">Total Revenue</span>
                <div class="stat-value">₱<?= number_format($total_revenue ?? 0, 2) ?></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <span class="stat-label">Monthly Orders</span>
                <div class="stat-value"><?= number_format($monthly_orders) ?></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <span class="stat-label">Lifetime Orders</span>
                <div class="stat-value"><?= number_format($total_orders) ?></div>
            </div>
        </div>
    </div>

   <div class="chart-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h6 class="fw-bold text-uppercase small text-white mb-0" style="letter-spacing: 1px; opacity: 0.9;">
            Revenue Growth (7 Days)
        </h6>
        
        <?php if(!empty($chart_values)): ?>
            <span class="badge bg-dark border border-secondary text-warning">
                <i class="fas fa-chart-line me-1"></i> Live Data
            </span>
        <?php endif; ?>
    </div>

    <div style="height: 350px; position: relative;">
        <?php if(!empty($chart_values)): ?>
            <canvas id="salesChart"></canvas>
        <?php else: ?>
            <div class="d-flex flex-column align-items-center justify-content-center h-100 opacity-25">
                <i class="fas fa-folder-open fa-3x mb-3 text-white"></i>
                <p class="text-white">No sales data available for the last 7 days.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Gamit ang PHP check para indi mag-run ang script kung wala sing data
    <?php if(!empty($chart_values)): ?>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('salesChart').getContext('2d');
            
            // Premium Gold Gradient
            const goldGradient = ctx.createLinearGradient(0, 0, 0, 400);
            goldGradient.addColorStop(0, 'rgba(255, 204, 77, 0.3)');
            goldGradient.addColorStop(1, 'rgba(255, 204, 77, 0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: <?= json_encode($chart_labels) ?>,
                    datasets: [{
                        label: 'Revenue (₱)',
                        data: <?= json_encode($chart_values) ?>,
                        borderColor: '#ffcc4d',
                        backgroundColor: goldGradient,
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 5,
                        pointBackgroundColor: '#ffcc4d',
                        pointBorderColor: '#121212',
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            backgroundColor: '#1a1a1a',
                            titleColor: '#ffcc4d',
                            bodyColor: '#fff',
                            borderColor: '#333',
                            borderWidth: 1
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(255, 255, 255, 0.05)' },
                            ticks: { 
                                color: '#b3b3b3',
                                callback: function(value) { return '₱' + value.toLocaleString(); }
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: '#b3b3b3' }
                        }
                    }
                }
            });
        });
    <?php endif; ?>
</script>
</body>
</html>