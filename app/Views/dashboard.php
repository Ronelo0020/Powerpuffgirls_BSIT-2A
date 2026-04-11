<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title><?= $title ?? 'Riverside Dashboard' ?></title>
    
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

        /* Sidebar Styling */
        .sidebar { 
            width: 260px; 
            background: var(--sidebar-bg); 
            padding: 30px 20px; 
            display: flex; 
            flex-direction: column; 
            transition: 0.3s; 
            z-index: 1000; 
            color: white;
            position: fixed;
            height: 100vh;
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

        .nav-link:hover, .nav-link.active { 
            background: rgba(255,255,255,0.1); 
            color: var(--riverside-red); 
        }

        .nav-link i { width: 25px; }

        /* Main Content */
        .main-content { 
            flex: 1; 
            margin-left: 260px; 
            padding: 30px; 
            overflow-y: auto; 
        }

        /* Card Styling */
        .stat-card { 
            background: #fff; 
            border-radius: 15px; 
            border: 1px solid #dee2e6; 
            padding: 20px; 
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
            height: 100%;
            transition: transform 0.2s;
        }
        .stat-card:hover { transform: translateY(-3px); }

        .stat-value { 
            font-size: 1.5rem; 
            font-weight: 700; 
            color: #212529; 
        }

        .text-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 600;
            color: #6c757d;
            letter-spacing: 0.5px;
        }

        /* Table Styling */
        .table-container {
            background: #fff;
            border-radius: 15px;
            border: 1px solid #dee2e6;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
            margin-bottom: 25px;
        }

        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-size: 0.8rem;
            text-transform: uppercase;
            color: #495057;
        }

        .btn-riverside {
            background-color: var(--riverside-red);
            color: white;
            border-radius: 8px;
            font-weight: 600;
            padding: 8px 16px;
            border: none;
            transition: 0.3s;
        }
        .btn-riverside:hover { background-color: #e63939; color: white; }

        @media (max-width: 992px) {
            .sidebar { left: -260px; }
            .sidebar.active { left: 0; }
            .main-content { margin-left: 0; }
        }
    </style>
</head>
<body>

<div class="sidebar" id="sidebar">
    <div class="mb-5 text-center">
        <h4 class="fw-bold"><span style="color:var(--riverside-red)">Riverside</span> Café</h4>
        <small class="text-muted">Staff Panel</small>
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

    <div class="mt-auto border-top border-secondary pt-3 px-2">
        <p class="small text-muted mb-2">User: <strong><?= session()->get('name') ?></strong></p>
        <a href="<?= base_url('auth/logout') ?>" class="nav-link text-danger p-0"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
    </div>
</div>

<div class="main-content">
    <div class="d-md-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">Dashboard Overview</h2>
            <p class="text-muted small">System monitoring for Riverside Café</p>
        </div>
        <div class="mt-2 mt-md-0">
            <a href="<?= base_url('pos') ?>" class="btn btn-riverside shadow-sm"><i class="fas fa-plus me-1"></i> New Transaction</a>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <p class="text-label mb-1">Total Sales Today</p>
                <div class="stat-value">₱<?= number_format($total_sales ?? 0, 2) ?></div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <p class="text-label mb-1">Orders Served</p>
                <div class="stat-value text-success"><?= count($recent_orders ?? []) ?></div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <p class="text-label mb-1">Low Stock Alerts</p>
                <div class="stat-value text-danger"><?= sprintf("%02d", $low_stock ?? 0) ?></div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <p class="text-label mb-1">System Status</p>
                <div class="stat-value text-primary" style="font-size: 1.1rem;">Operational</div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="table-container h-100">
                <h6 class="fw-bold mb-4 text-uppercase small" style="letter-spacing: 1px;">Recent Transactions</h6>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Time</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($recent_orders)): foreach($recent_orders as $order): ?>
                            <tr>
                                <td class="fw-bold">#<?= $order['id'] ?></td>
                                <td class="text-muted small"><?= date('h:i A', strtotime($order['order_date'] ?? 'now')) ?></td>
                                <td class="fw-bold text-dark">₱<?= number_format($order['total_amount'], 2) ?></td>
                                <td><span class="badge bg-success-subtle text-success border-0 px-3">Paid</span></td>
                            </tr>
                            <?php endforeach; else: ?>
                            <tr><td colspan="4" class="text-center py-5 text-muted">No transactions today.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="stat-card">
                <h6 class="fw-bold mb-4 text-uppercase small" style="letter-spacing: 1px;">Trending Products</h6>
                <?php if(!empty($trending)): foreach($trending as $item): ?>
                <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                    <div>
                        <span class="d-block small fw-bold text-dark"><?= $item['product_name'] ?></span>
                        <small class="text-muted" style="font-size: 0.7rem;">Popular item</small>
                    </div>
                    <span class="badge bg-light text-dark border"><?= $item['total_qty'] ?> Sold</span>
                </div>
                <?php endforeach; else: ?>
                <p class="text-muted small text-center py-4">No data available.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>