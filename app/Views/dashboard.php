<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Riverside | Dashboard</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        :root { 
            --riverside-red: #ff4d4d; 
            --riverside-gold: #ffc107; 
            --sidebar-bg: #000000; 
            --body-bg: #0b0b0b; 
            --container-bg: #121212; 
            --text-main: #ffffff;
            --text-muted: #a0a0a0;
        }

        body { 
            background-color: var(--body-bg); 
            font-family: 'Poppins', sans-serif; 
            display: flex; 
            height: 100vh; 
            overflow: hidden; 
            margin: 0; 
            color: var(--text-main); 
        }
        
        .sidebar { width: 260px; background: var(--sidebar-bg); padding: 30px 20px; display: flex; flex-direction: column; flex-shrink: 0; border-right: 1px solid #222; }
        .nav-link { color: var(--text-muted); padding: 12px 15px; border-radius: 12px; margin-bottom: 8px; transition: 0.3s; text-decoration: none; display: flex; align-items: center; font-size: 0.9rem; }
        .nav-link:hover { background: rgba(255,255,255,0.05); color: #fff; }
        .nav-link.active { background: var(--riverside-gold); color: #000; font-weight: 600; }

        .main-content { flex: 1; padding: 35px; overflow-y: auto; }

        /* Welcome Alert Styling */
        .welcome-alert {
            background: rgba(255, 193, 7, 0.1);
            border: 1px solid rgba(255, 193, 7, 0.2);
            border-left: 4px solid var(--riverside-gold);
            border-radius: 15px;
            animation: slideDown 0.5s ease-out;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .stat-card { 
            background: var(--container-bg); 
            border-radius: 20px; 
            border: 1px solid #222; 
            padding: 25px; 
            height: 100%; 
        }
        .stat-value { font-size: 1.8rem; font-weight: 700; color: #fff; }
        .text-label { font-size: 0.7rem; text-transform: uppercase; font-weight: 600; color: var(--text-muted); letter-spacing: 1.2px; }

        .content-container { 
            background: var(--container-bg); 
            border-radius: 20px; 
            border: 1px solid #222; 
            padding: 30px; 
            margin-bottom: 20px;
        }
        
        .table { color: #fff !important; margin-bottom: 0; }
        .table thead th { 
            background: transparent !important; 
            border-bottom: 1px solid #333 !important; 
            color: var(--text-muted) !important; 
            font-size: 0.75rem; 
            padding: 15px;
            border-top: none;
        }
        .table tbody td { 
            padding: 18px 15px; 
            border-bottom: 1px solid #1a1a1a !important; 
            vertical-align: middle; 
            background: transparent !important;
            color: #ffffff !important;
        }
        
        .order-id-highlight { color: var(--riverside-gold) !important; font-weight: 700; font-family: monospace; }
        
        .badge-paid { 
            background: rgba(80, 205, 137, 0.1); 
            color: #50cd89; 
            border: 1px solid rgba(80, 205, 137, 0.3); 
            padding: 6px 16px; 
            border-radius: 8px; 
            font-size: 0.7rem; 
        }

        .btn-new-trans { background: var(--riverside-gold); border: none; padding: 12px 25px; font-weight: 600; color: #000; border-radius: 50px; }

        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-thumb { background: #333; border-radius: 10px; }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="mb-5 text-center">
        <h4 class="fw-bold m-0"><span style="color:var(--riverside-gold)">Riverside</span> Café</h4>
        <small style="color: var(--text-muted); font-size: 0.65rem; letter-spacing: 2px;">
            <?= (session()->get('role') == 'admin') ? 'ADMIN' : 'STAFF'; ?>
        </small>
    </div>
    <nav class="d-flex flex-column h-100">
        <a href="<?= base_url('dashboard') ?>" class="nav-link <?= (uri_string() == 'dashboard') ? 'active' : '' ?>">
            <i class="fas fa-th-large me-3"></i> Dashboard
        </a>
        <a href="<?= base_url('products') ?>" class="nav-link <?= (uri_string() == 'products') ? 'active' : '' ?>">
            <i class="fas fa-coffee me-3"></i> Menu & Inventory
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

        <div class="mt-auto">
            <a href="<?= base_url('logout') ?>" class="nav-link text-danger">
                <i class="fas fa-sign-out-alt me-3"></i> Logout
            </a>
        </div>
    </nav>
</div>

<div class="main-content">

   <?php if (session()->get('role')): ?>
    <div class="alert welcome-alert alert-dismissible fade show mb-4 py-3" role="alert">
        <div class="d-flex align-items-center">
            <div class="me-3">
                <i class="fas fa-user-shield fa-2x" style="color: var(--riverside-gold);"></i>
            </div>
            <div>
                <h5 class="m-0 fw-bold text-white">
                    Hello, <?= (session()->get('role') == 'admin') ? 'Admin' : ' Staff'; ?>!
                </h5>
                <p class="m-0 small" style="color: rgba(255,255,255,0.8);">
                    Logged in as <?= session()->get('role'); ?>. <span class="text-warning">Kape anay kita!</span>
                </p>
            </div>
            <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
<?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold mb-1">Kapehan Overview</h2>
            <p style="color: var(--text-muted); font-size: 0.85rem;">Maayong adlaw! Narito ang performance ng shop mo.</p>
        </div>
        <a href="<?= base_url('pos') ?>" class="btn btn-new-trans shadow-sm"><i class="fas fa-plus me-2"></i> New Transaction</a>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="stat-card">
                <p class="text-label mb-2">Total Sales</p>
                <div class="stat-value" style="color: var(--riverside-gold);">₱<?= number_format($total_sales ?? 0, 2) ?></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <p class="text-label mb-2">Orders Today</p>
                <div class="stat-value"><?= count($recent_orders ?? []) ?> <span style="font-size: 0.8rem; font-weight: 300;">Cups</span></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <p class="text-label mb-2 text-warning">Stock Alert</p>
                <div class="stat-value text-warning"><?= sprintf("%02d", $low_stock ?? 0) ?></div>
                <p class="text-white small mt-1 mb-0" style="font-size: 0.65rem; opacity: 0.8;">Restock needed</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <p class="text-label mb-2">Status</p>
                <div class="stat-value text-info" style="font-size: 1.4rem;">Operational</div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="content-container">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="fw-bold text-uppercase small mb-0" style="color: var(--text-muted);"><i class="far fa-clock me-2"></i> Recent Transactions</h6>
                    <a href="<?= base_url('dashboard/history') ?>" class="text-decoration-none small" style="color: var(--riverside-gold);">View All</a>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>ORDER ID</th>
                                <th>TIME</th>
                                <th>ITEMS</th>
                                <th>AMOUNT</th>
                                <th class="text-center">STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($recent_orders)): 
                                $top_five_orders = array_slice($recent_orders, 0, 5);
                                foreach($top_five_orders as $order): 
                            ?>
                            <tr>
                                <td class="order-id-highlight">#<?= sprintf("%03d", $order['id']) ?></td>
                                <td class="small text-muted"><?= date('h:i A', strtotime($order['order_date'])) ?></td>
                                <td class="small"><?= !empty($order['items']) ? esc($order['items']) : 'Coffee Order' ?></td>
                                <td class="fw-bold">₱<?= number_format($order['total_amount'], 2) ?></td>
                                <td class="text-center"><span class="badge badge-paid">Paid</span></td>
                            </tr>
                            <?php endforeach; else: ?>
                                <tr><td colspan="5" class="text-center py-5 text-muted small">No recent orders found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="content-container h-100">
                <h6 class="fw-bold mb-4 text-uppercase small" style="color: var(--text-muted);"><i class="fas fa-fire me-2"></i> Trending</h6>
                <?php if(!empty($trending)): 
                    foreach(array_slice($trending, 0, 5) as $item): 
                ?>
                <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom border-dark">
                    <div>
                        <span class="d-block fw-bold small"><?= $item['product_name'] ?></span>
                        <small class="text-warning" style="font-size: 0.6rem;">BEST SELLER</small>
                    </div>
                    <span class="badge bg-dark border border-secondary"><?= $item['total_qty'] ?> Sold</span>
                </div>
                <?php endforeach; endif; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>