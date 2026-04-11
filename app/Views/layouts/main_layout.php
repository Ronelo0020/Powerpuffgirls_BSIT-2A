<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riverside Café | <?= $title ?? 'Management' ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root { --riverside-red: #ff4d4d; --sidebar-bg: #212529; --body-bg: #f4f7f6; }
        body { background-color: var(--body-bg); font-family: 'Poppins', sans-serif; display: flex; min-height: 100vh; margin: 0; }
        .sidebar { width: 260px; background: var(--sidebar-bg); padding: 30px 20px; display: flex; flex-direction: column; color: white; position: fixed; height: 100vh; z-index: 1000; }
        .nav-link { color: rgba(255,255,255,0.7); padding: 12px 15px; border-radius: 10px; margin-bottom: 5px; transition: 0.3s; text-decoration: none; display: flex; align-items: center; font-size: 0.9rem; }
        .nav-link:hover, .nav-link.active { background: rgba(255,255,255,0.1); color: var(--riverside-red); }
        .main-content { flex: 1; margin-left: 260px; padding: 30px; width: calc(100% - 260px); }
        .stat-card { background: #fff; border-radius: 15px; border: 1px solid #dee2e6; padding: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.03); transition: 0.2s; }
        .btn-riverside { background: var(--riverside-red); color: white; border-radius: 8px; font-weight: 600; border: none; padding: 8px 16px; }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="mb-5 text-center">
        <h4 class="fw-bold"><span style="color:var(--riverside-red)">Riverside</span> Café</h4>
        <small class="text-muted">Management System</small>
    </div>
    <nav>
        <a href="<?= base_url('dashboard') ?>" class="nav-link <?= (uri_string() == 'dashboard') ? 'active' : '' ?>"><i class="fas fa-chart-pie me-2"></i> Overview</a>
        <a href="<?= base_url('products') ?>" class="nav-link <?= (uri_string() == 'products') ? 'active' : '' ?>"><i class="fas fa-coffee me-2"></i> Inventory</a>
        <a href="<?= base_url('pos') ?>" class="nav-link <?= (uri_string() == 'pos') ? 'active' : '' ?>"><i class="fas fa-cash-register me-2"></i> Barista POS</a>
        <a href="<?= base_url('sales') ?>" class="nav-link <?= (uri_string() == 'sales') ? 'active' : '' ?>"><i class="fas fa-chart-line me-2"></i> Sales Analytics</a>
    </nav>
    <div class="mt-auto border-top border-secondary pt-3">
        <a href="<?= base_url('auth/logout') ?>" class="nav-link text-danger"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
    </div>
</div>

<div class="main-content">
    <?= $this->renderSection('content') ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>