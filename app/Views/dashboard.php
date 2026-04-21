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
        :root { --riverside-red: #ff4d4d; --sidebar-bg: #212529; --body-bg: #f4f7f6; }
        body { background-color: var(--body-bg); font-family: 'Poppins', sans-serif; display: flex; height: 100vh; overflow: hidden; margin: 0; }
        
        /* Sidebar - Same as POS View */
        .sidebar { width: 260px; background: var(--sidebar-bg); padding: 30px 20px; display: flex; flex-direction: column; color: white; flex-shrink: 0; }
        .nav-link { color: rgba(255,255,255,0.7); padding: 12px 15px; border-radius: 10px; margin-bottom: 5px; transition: 0.3s; text-decoration: none; display: flex; align-items: center; font-size: 0.9rem; }
        .nav-link:hover, .nav-link.active { background: rgba(255,255,255,0.1); color: var(--riverside-red); }

        /* Main Content */
        .main-content { flex: 1; padding: 30px; overflow-y: auto; }

        /* Dashboard Components */
        .stat-card { 
            background: #fff; border-radius: 15px; border: 1px solid #dee2e6; padding: 20px; 
            box-shadow: 0 4px 10px rgba(0,0,0,0.02); height: 100%; 
        }
        .stat-value { font-size: 1.8rem; font-weight: 700; color: #212529; }
        .text-label { font-size: 0.75rem; text-transform: uppercase; font-weight: 600; color: #6c757d; letter-spacing: 0.5px; }

        .content-container { background: #fff; border-radius: 15px; border: 1px solid #dee2e6; padding: 25px; box-shadow: 0 4px 10px rgba(0,0,0,0.02); }
        
        /* Table Styling from Reference */
        .order-id-highlight { color: #ffc107; font-weight: 600; }
        .badge-paid { background-color: transparent; color: #212529; border: 1px solid #dee2e6; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; }
        
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-thumb { background: #eee; border-radius: 10px; }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="mb-5 text-center">
        <h4 class="fw-bold"><span style="color:var(--riverside-red)">Riverside</span> Café</h4>
        <small class="text-muted text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Admin Terminal</small>
    </div>
    <nav class="d-flex flex-column h-100">
        <a href="<?= base_url('dashboard') ?>" class="nav-link active">
            <i class="fas fa-chart-pie me-3"></i> Overview
        </a>
        <a href="<?= base_url('products') ?>" class="nav-link">
            <i class="fas fa-coffee me-3"></i> Menu & Inventory
        </a>
        <a href="<?= base_url('pos') ?>" class="nav-link">
            <i class="fas fa-cash-register me-3"></i> Barista POS
        </a>

        <?php if(session()->get('role') == 'admin'): ?>
            <a href="<?= base_url('sales') ?>" class="nav-link">
                <i class="fas fa-file-invoice-dollar me-3"></i> Sales Reports
            </a>
            <hr class="text-secondary opacity-25 mx-3">
            <p class="small text-muted px-3 mb-2" style="font-size: 0.65rem; letter-spacing: 1px;">ADMINISTRATION</p>
            <a href="<?= base_url('auth/manage') ?>" class="nav-link">
                <i class="fas fa-users-cog me-3"></i> Manage Staff
            </a>
        <?php endif; ?>

        <div class="mt-auto">
            <hr class="text-secondary opacity-25 mx-3">
            <a href="<?= base_url('logout') ?>" class="nav-link text-danger">
                <i class="fas fa-sign-out-alt me-3"></i> Logout
            </a>
        </div>
    </nav>
</div>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold mb-0">Dashboard Overview</h2>
            <p class="text-muted small">System monitoring for Riverside Café</p>
        </div>
        <a href="<?= base_url('pos') ?>" class="btn btn-danger rounded-pill px-4 shadow-sm" style="background-color: var(--riverside-red);">
            + New Transaction
        </a>
    </div>

    <div class="row g-4 mb-5">
    <div class="col-md-<?= ($low_stock > 0) ? '3' : '4' ?>">
        <div class="stat-card">
            <p class="text-label mb-2">TOTAL SALES TODAY</p>
            <div class="stat-value">₱<?= number_format($total_sales, 2) ?></div>
        </div>
    </div>

    <div class="col-md-<?= ($low_stock > 0) ? '3' : '4' ?>">
        <div class="stat-card">
            <p class="text-label mb-2">ORDERS SERVED</p>
            <div class="stat-value text-success"><?= count($recent_orders) ?></div>
        </div>
    </div>

    <?php if($low_stock > 0): ?>
    <div class="col-md-3">
        <div class="stat-card border-danger shadow-none">
            <p class="text-label mb-2 text-danger">LOW STOCK ALERTS</p>
            <div class="stat-value text-danger"><?= sprintf("%02d", $low_stock) ?></div>
            <p class="text-muted small mt-1 mb-0" style="font-size: 0.7rem;">Items with stock ≤ 5</p>
        </div>
    </div>
    <?php endif; ?>

    <div class="col-md-<?= ($low_stock > 0) ? '3' : '4' ?>">
        <div class="stat-card">
            <p class="text-label mb-2">SYSTEM STATUS</p>
            <div class="stat-value text-primary">Operational</div>
        </div>
    </div>
</div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="content-container">
                <div class="d-flex justify-content-between align-items-center mb-4">
    <h6 class="fw-bold text-uppercase small mb-0">Recent Transactions</h6>
    <a href="<?= base_url('dashboard/history') ?>" class="text-decoration-none small fw-bold" style="color: #ffc107;">
        View Full History <i class="fas fa-chevron-right ms-1" style="font-size: 0.7rem;"></i>
    </a>
</div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr class="text-muted small border-bottom">
                                <th class="pb-3">ORDER ID</th>
                                <th class="pb-3">TIME</th>
                                <th class="pb-3">ITEMS</th>
                                <th class="pb-3">AMOUNT</th>
                                <th class="pb-3 text-center">STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
   <?php if(!empty($recent_orders)): 
    $top_orders = array_slice($recent_orders, 0, 5); // Kukuha lang ng index 0 hanggang 4
    foreach($top_orders as $order): ?>
    <tr>
        <td class="order-id-highlight">#<?= sprintf("%03d", $order['id']) ?></td>
        <td class="text-muted small"><?= date('h:i A', strtotime($order['order_date'])) ?></td>
        
        <td class="fw-semibold small text-dark">
            <?= !empty($order['items']) ? esc($order['items']) : '<span class="text-muted italic">No items found</span>' ?>
        </td>
        
        <td class="fw-bold text-dark">₱<?= number_format($order['total_amount'], 2) ?></td>
        <td class="text-center"><span class="badge badge-paid">Paid</span></td>
    </tr>
    <?php endforeach; else: ?>
        <tr><td colspan="5" class="text-center py-4 text-muted small">No recent transactions.</td></tr>
    <?php endif; ?>
</tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="content-container h-100">
                <h6 class="fw-bold mb-4 text-uppercase small">Trending Products</h6>
                
                <?php if(!empty($trending)): 
    $top_trending = array_slice($trending, 0, 5); // Limit sa 5 items
    foreach($top_trending as $item): ?>
                <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                    <div>
                        <span class="d-block fw-bold" style="font-size: 0.85rem;"><?= $item['product_name'] ?></span>
                        <small class="text-muted" style="font-size: 0.75rem;">Popular item</small>
                    </div>
                    <span class="badge bg-light text-dark border px-2 py-1 small" style="font-size: 0.7rem;">
                        <?= $item['total_qty'] ?> Sold
                    </span>
                </div>
                <?php endforeach; else: ?>
                    <p class="text-center text-muted py-5 small">No data for trending products.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>