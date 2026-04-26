<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Riverside | Inventory' ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        :root { 
            /* Dashboard Dark Theme Colors */
            --riverside-yellow: #ffcc4d; 
            --sidebar-bg: #000000; 
            --body-bg: #0b0b0b; 
            --card-bg: #111111;
            --text-main: #ffffff;
            --text-muted: #a0a0a0;
            --border-color: #222222;
        }
        
        body { 
            background-color: var(--body-bg); 
            font-family: 'Poppins', sans-serif; 
            display: flex; 
            min-height: 100vh; 
            margin: 0; 
            color: var(--text-main);
        }

        /* Sidebar Styling */
        .sidebar { 
            width: 260px; 
            background: var(--sidebar-bg); 
            padding: 30px 20px; 
            display: flex; 
            flex-direction: column; 
            position: fixed; 
            height: 100vh; 
            border-right: 1px solid var(--border-color);
        }

        .main-content { 
            flex: 1; 
            margin-left: 260px; 
            padding: 40px; 
            width: calc(100% - 260px); 
        }

        .nav-link { 
            color: var(--text-muted); 
            padding: 12px 15px; 
            border-radius: 8px; 
            margin-bottom: 5px; 
            transition: 0.3s; 
            text-decoration: none; 
            display: flex; 
            align-items: center; 
            font-weight: 500;
        }
        
        /* Dashboard Yellow Active State */
        .nav-link:hover, .nav-link.active { 
            background: var(--riverside-yellow); 
            color: #000; 
        }

        /* Inventory Cards */
        .category-card {
            border: 1px solid var(--border-color);
            border-radius: 12px;
            margin-bottom: 15px;
            overflow: hidden;
            background: var(--card-bg);
        }

        .category-header {
            padding: 20px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            transition: background 0.2s;
        }
        
        .category-header:hover { background: #1a1a1a; }
        .category-title { font-weight: 600; color: var(--text-main); font-size: 1.1rem; margin: 0; }

        .item-row {
            padding: 15px 25px;
            border-top: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .item-name { font-weight: 500; color: var(--text-main); margin-bottom: 2px; }
        .sku-label { font-size: 0.8rem; color: var(--text-muted); }

        .price-tag { color: var(--riverside-yellow); font-weight: 700; font-size: 0.95rem; }
        
        /* Status Badges */
        .stock-indicator { font-size: 0.75rem; font-weight: 600; padding: 6px 12px; border-radius: 20px; }
        .bg-success-subtle { background: rgba(40, 167, 69, 0.1) !important; color: #28a745 !important; border: 1px solid rgba(40, 167, 69, 0.2); }
        .bg-danger-subtle { background: rgba(220, 53, 69, 0.1) !important; color: #dc3545 !important; border: 1px solid rgba(220, 53, 69, 0.2); }

        /* Action Buttons */
        .btn-action-circle {
            width: 35px; height: 35px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;
            transition: 0.3s; border: 1px solid var(--border-color); background: #222; color: var(--text-muted); text-decoration: none;
        }
        .btn-action-circle:hover { background: var(--riverside-yellow); color: #000; border-color: var(--riverside-yellow); }

        .btn-add { 
            background: var(--riverside-yellow); 
            color: #000; 
            padding: 10px 20px; 
            border-radius: 8px; 
            font-weight: 600; 
            text-decoration: none; 
            transition: 0.3s;
        }
        .btn-add:hover { background: #e6b845; color: #000; }

        .text-muted { color: var(--text-muted) !important; }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="mb-5 px-3">
        <h4 class="fw-bold"><span style="color:var(--riverside-yellow)">Riverside</span> Café</h4>
        <small class="text-muted">Admin Terminal</small>
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

    <div class="mt-auto border-top border-secondary pt-3">
        <a href="<?= base_url('logout') ?>" class="nav-link text-danger">
            <i class="fas fa-sign-out-alt me-3"></i> Logout 
        </a>
    </div>
</div>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold">Menu & Inventory</h2>
            <p class="text-muted">Precision management for Riverside Café's product lineup.</p>
        </div>
        <a href="<?= base_url('products/add') ?>" class="btn-add shadow-sm">
            <i class="fas fa-plus me-2"></i> Add New Item
        </a>
    </div>

    <div id="menuAccordion">
        <?php 
        $grouped = [];
        if(!empty($products)) {
            foreach($products as $p) { $grouped[$p['category']][] = $p; }
        }

        $i = 0;
        foreach($grouped as $category => $items): 
            $i++; $collapseId = "collapse_" . $i;
        ?>
        <div class="category-card">
            <div class="category-header collapsed" data-bs-toggle="collapse" data-bs-target="#<?= $collapseId ?>">
                <div class="d-flex align-items-center">
                    <i class="fas fa-folder text-muted me-3"></i>
                    <h5 class="category-title"><?= strtoupper($category) ?></h5>
                    <span class="badge bg-dark text-muted border border-secondary ms-3" style="font-size: 0.7rem;"><?= count($items) ?> items</span>
                </div>
                <i class="fas fa-chevron-down text-muted"></i>
            </div>

            <div id="<?= $collapseId ?>" class="collapse" data-bs-parent="#menuAccordion">
                <div class="card-body p-0">
                    <?php foreach($items as $item): ?>
                    <div class="item-row">
                        <div style="flex: 2;">
                            <div class="item-name"><?= $item['product_name'] ?></div>
                            <small class="sku-label">ID: #<?= $item['id'] ?></small>
                        </div>
                        
                        <div style="flex: 1;" class="text-center">
                            <span class="price-tag">₱<?= number_format($item['price'], 2) ?></span>
                        </div>

                        <div style="flex: 1;" class="text-center">
                            <?php if($item['stock'] <= 0): ?>
                                <span class="stock-indicator bg-danger-subtle">OUT OF STOCK</span>
                            <?php elseif($item['stock'] <= 5): ?>
                                <span class="stock-indicator bg-danger text-white">
                                    <i class="fas fa-exclamation-triangle me-1"></i> <?= $item['stock'] ?> LOW STOCK
                                </span>
                            <?php else: ?>
                                <span class="stock-indicator bg-success-subtle">
                                    <?= $item['stock'] ?> UNITS
                                </span>
                            <?php endif; ?>
                        </div>

                        <div style="flex: 1;" class="text-end">
                            <a href="<?= base_url('products/edit/'.$item['id']) ?>" class="btn-action-circle me-1"><i class="fas fa-pen fa-sm"></i></a>
                            <a href="<?= base_url('products/delete/'.$item['id']) ?>" class="btn-action-circle text-danger" onclick="return confirm('Are you sure?')"><i class="fas fa-trash-alt fa-sm"></i></a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>