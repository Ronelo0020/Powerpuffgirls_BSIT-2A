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
        :root { --sidebar-dark: #000000; --bg-dark: #121212; --card-dark: #1a1a1a; --accent-gold: #ffcc4d; --text-main: #ffffff; --text-muted: #b3b3b3; }
        body { background-color: var(--bg-dark); font-family: 'Poppins', sans-serif; display: flex; height: 100vh; overflow: hidden; color: var(--text-main); }
        
        .sidebar { width: 260px; background: var(--sidebar-dark); padding: 30px 20px; display: flex; flex-direction: column; border-right: 1px solid #333; flex-shrink: 0; }
        .nav-link { color: var(--text-muted); padding: 12px 15px; border-radius: 10px; margin-bottom: 5px; transition: 0.3s; text-decoration: none; display: flex; align-items: center; font-size: 0.9rem; }
        .nav-link:hover { color: white; background: rgba(255,255,255,0.05); }
        .nav-link.active { background: var(--accent-gold); color: black; font-weight: 600; }

        .main-content { flex: 1; padding: 30px; overflow-y: auto; }
        
        /* Clickable Stats Card */
        .stat-card { background: var(--card-dark); border-radius: 20px; border: 1px solid #333; padding: 25px; height: 100%; transition: 0.3s; }
        .stat-card.clickable:hover { border-color: var(--accent-gold); transform: translateY(-5px); cursor: pointer; }
        
        .stat-label { font-size: 0.70rem; text-transform: uppercase; font-weight: 600; color: var(--text-muted); letter-spacing: 1px; }
        .stat-value { font-size: 1.6rem; font-weight: 700; color: var(--text-main); margin-top: 5px; }

        .chart-container { background: var(--card-dark); border-radius: 20px; border: 1px solid #333; padding: 30px; margin-top: 20px; }
        .btn-print { border: 1px solid #444; background: #1a1a1a; color: white; padding: 10px 25px; border-radius: 12px; transition: 0.3s; }
        .btn-print:hover { border-color: var(--accent-gold); color: var(--accent-gold); }

        @media print { .sidebar, .btn-print, .btn-group { display: none !important; } .main-content { padding: 0; } }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="mb-5 px-3 text-center">
        <h4 class="fw-bold mb-0">
            <span style="color: var(--accent-gold);">Riverside</span> <span style="color: white;">Café</span>
        </h4>
        
        <?php if (session()->get('role') === 'admin'): ?>
            <small class="text-white d-block" style="opacity: 0.6; font-size: 0.75rem; letter-spacing: 1px;">ADMIN TERMINAL</small>
        <?php else: ?>
            <small class="text-white d-block" style="opacity: 0.6; font-size: 0.75rem; letter-spacing: 1px;">STAFF TERMINAL</small>
        <?php endif; ?>
    </div>

    <nav class="d-flex flex-column h-100">
        <a href="<?= base_url('dashboard') ?>" class="nav-link <?= (uri_string() == 'dashboard') ? 'active' : '' ?>">
            <i class="fas fa-th-large me-3"></i> Dashboard
        </a>
        <a href="<?= base_url('products') ?>" class="nav-link <?= (uri_string() == 'products') ? 'active' : '' ?>">
            <i class="fas fa-box me-3"></i> Menu & Inventory
        </a>
        <a href="<?= base_url('pos') ?>" class="nav-link <?= (uri_string() == 'pos') ? 'active' : '' ?>">
            <i class="fas fa-cash-register me-3"></i> Barista POS
        </a>

        <?php if(session()->get('role') == 'admin'): ?>
            <hr class="text-secondary opacity-25 mx-3">
            <a href="<?= base_url('sales') ?>" class="nav-link <?= (uri_string() == 'sales') ? 'active' : '' ?>">
                <i class="fas fa-chart-line me-3"></i> Sales Analytics
            </a>
            <a href="<?= base_url('auth/manage') ?>" class="nav-link <?= (uri_string() == 'auth/manage') ? 'active' : '' ?>">
                <i class="fas fa-users me-3"></i> Manage Staff
            </a>
        <?php endif; ?>
    </nav>
</div>

<div class="main-content">
    <div class="d-md-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold mb-0 text-white">Sales Analytics</h2>
            <p style="color: var(--text-muted);" class="small mb-0">Track business growth and revenue performance.</p>
        </div>
        <button onclick="window.print()" class="btn btn-print shadow-sm"><i class="fas fa-print me-2"></i> Print Report</button>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="stat-card clickable" onclick="updateChart('daily')">
                <span class="stat-label">Daily Revenue</span>
                <div class="stat-value text-success">₱<?= number_format($daily_revenue, 2) ?></div>
            </div>
        </div>
        <div class="col-md-3">
    <div class="stat-card clickable" style="border-left: 4px solid var(--accent-gold);" onclick="updateChart('monthly')">
        <span class="stat-label" style="color: var(--accent-gold);">Total Revenue</span>
        <div class="stat-value">₱<?= number_format($total_revenue ?? 0, 2) ?></div>
        <small class="text-white" style="font-size: 0.6rem; opacity: 0.8;">Click to see monthly trend</small>
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
            <h6 class="fw-bold text-uppercase small text-white mb-0" id="chartTitle">Revenue Growth (Daily)</h6>
            <div class="btn-group btn-group-sm">
                <button type="button" class="btn btn-outline-warning active" id="btn-daily" onclick="updateChart('daily')">Daily</button>
                <button type="button" class="btn btn-outline-warning" id="btn-weekly" onclick="updateChart('weekly')">Weekly</button>
                <button type="button" class="btn btn-outline-warning" id="btn-monthly" onclick="updateChart('monthly')">Monthly</button>
                <button type="button" class="btn btn-outline-warning" id="btn-yearly" onclick="updateChart('yearly')">Yearly</button>
            </div>
        </div>
        <div style="height: 350px;"><canvas id="salesChart"></canvas></div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let salesChart;
    
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('salesChart').getContext('2d');
        const goldGradient = ctx.createLinearGradient(0, 0, 0, 400);
        goldGradient.addColorStop(0, 'rgba(255, 204, 77, 0.3)');
        goldGradient.addColorStop(1, 'rgba(255, 204, 77, 0)');

        salesChart = new Chart(ctx, {
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
                    pointBackgroundColor: '#ffcc4d'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { grid: { color: 'rgba(255, 255, 255, 0.05)' }, ticks: { color: '#b3b3b3', callback: v => '₱' + v.toLocaleString() } },
                    x: { grid: { display: false }, ticks: { color: '#b3b3b3' } }
                }
            }
        });
    });

    function updateChart(type) {
        fetch('<?= base_url('sales/get_filtered_data/') ?>' + type)
            .then(res => res.json())
            .then(data => {
                salesChart.data.labels = data.labels;
                salesChart.data.datasets[0].data = data.values;
                salesChart.update();

                // UI Updates
                document.getElementById('chartTitle').innerText = `Revenue Growth (${type.charAt(0).toUpperCase() + type.slice(1)})`;
                document.querySelectorAll('.btn-group .btn').forEach(b => b.classList.remove('active'));
                document.getElementById('btn-' + type).classList.add('active');
            });
    }
</script>
</body>
</html>