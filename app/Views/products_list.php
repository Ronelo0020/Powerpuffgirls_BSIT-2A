<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riverside | Inventory</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        :root { 
            --riverside-red: #ff4d4d; 
            --sidebar-bg: #212529; 
            --body-bg: #f4f7f6; 
        }
        
        body { background-color: var(--body-bg); font-family: 'Poppins', sans-serif; display: flex; min-height: 100vh; margin: 0; }

        /* Sidebar Styling */
        .sidebar { 
            width: 260px; 
            background: var(--sidebar-bg); 
            padding: 30px 20px; 
            display: flex; 
            flex-direction: column; 
            color: white; 
            position: fixed; 
            height: 100vh; 
        }

        .main-content { flex: 1; margin-left: 260px; padding: 40px; width: calc(100% - 260px); }

        .nav-link { 
            color: rgba(255,255,255,0.7); 
            padding: 12px 15px; 
            border-radius: 10px; 
            margin-bottom: 5px; 
            transition: 0.3s; 
            text-decoration: none; 
            display: flex; 
            align-items: center; 
        }
        .nav-link:hover, .nav-link.active { background: rgba(255,255,255,0.1); color: var(--riverside-red); }

        /* Inventory Cards */
        .category-card {
            border: none;
            border-radius: 15px;
            margin-bottom: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            overflow: hidden;
            background: #fff;
        }

        .category-header {
            padding: 20px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            border-left: 6px solid var(--riverside-red);
        }
        .category-header:hover { background: #fafafa; }
        .category-title { font-weight: 600; color: #333; font-size: 1.1rem; margin: 0; }

        .item-row {
            padding: 15px 25px;
            border-top: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .item-name { font-weight: 500; color: #2c3e50; margin-bottom: 2px; }
        .sku-label { font-size: 0.8rem; }

        .price-tag { color: var(--riverside-red); font-weight: 700; font-size: 0.95rem; }
        .stock-indicator { font-size: 0.75rem; font-weight: 600; padding: 4px 10px; border-radius: 20px; }
        
        .btn-action-circle {
            width: 35px; height: 35px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;
            transition: 0.3s; border: 1px solid #eee; background: #fff; color: #666; text-decoration: none;
        }
        .btn-action-circle:hover { background: var(--riverside-red); color: #fff; border-color: var(--riverside-red); }

        .btn-add { background: var(--riverside-red); color: #fff; padding: 10px 20px; border-radius: 12px; font-weight: 600; text-decoration: none; }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="mb-5 text-center">
        <h4 class="fw-bold"><span style="color:var(--riverside-red)">Riverside</span> Café</h4>
        <small class="text-muted">Inventory Admin</small>
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

    <div class="mt-auto border-top border-secondary pt-3">
        <a href="<?= base_url('auth/logout') ?>" class="nav-link text-danger">
            <i class="fas fa-sign-out-alt me-2"></i> Logout
        </a>
    </div>
</div>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold">Menu & Inventory</h2>
            <p class="text-muted">Monitor stocks and manage product details</p>
        </div>
        <a href="<?= base_url('products/add') ?>" class="btn-add">
            <i class="fas fa-plus me-2"></i> Add New Product
        </a>
    </div>

    <div id="menuAccordion">
        <?php 
        $grouped = [];
        foreach($products as $p) { $grouped[$p['category']][] = $p; }

        $i = 0;
        foreach($grouped as $category => $items): 
            $i++; $collapseId = "collapse_" . $i;
        ?>
        <div class="category-card">
            <div class="category-header collapsed" data-bs-toggle="collapse" data-bs-target="#<?= $collapseId ?>">
                <div class="d-flex align-items-center">
                    <i class="fas fa-folder text-muted me-3"></i>
                    <h5 class="category-title"><?= strtoupper($category) ?></h5>
                    <span class="badge bg-light text-dark border ms-3" style="font-size: 0.7rem;"><?= count($items) ?> items</span>
                </div>
                <i class="fas fa-chevron-down text-muted"></i>
            </div>

            <div id="<?= $collapseId ?>" class="collapse" data-bs-parent="#menuAccordion">
                <div class="card-body p-0">
                    <?php foreach($items as $item): ?>
                    <div class="item-row">
                        <div style="flex: 2;">
                            <div class="item-name"><?= $item['product_name'] ?></div>
                            <small class="text-muted sku-label">Stock Keeping Unit: <?= $item['id'] ?></small>
                        </div>
                        
                        <div style="flex: 1;" class="text-center">
                            <span class="price-tag">₱<?= number_format($item['price'], 2) ?></span>
                        </div>

                        <div style="flex: 1;" class="text-center">
                            <?php if($item['stock'] <= 0): ?>
                                <span class="stock-indicator bg-light text-muted border">NOT AVAIL</span>
                            <?php else: ?>
                                <span class="stock-indicator bg-success-subtle text-success"><?= $item['stock'] ?> Units</span>
                            <?php endif; ?>
                        </div>

                        <div style="flex: 1;" class="text-end">
                            <a href="<?= base_url('products/edit/'.$item['id']) ?>" class="btn-action-circle me-1"><i class="fas fa-pen fa-sm"></i></a>
                            <a href="<?= base_url('products/delete/'.$item['id']) ?>" class="btn-action-circle text-danger"><i class="fas fa-trash-alt fa-sm"></i></a>
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