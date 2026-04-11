<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Manage Staff | Riverside Café</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root { --riverside-red: #ff4d4d; --sidebar-bg: #212529; --body-bg: #f8f9fa; }
        body { background-color: var(--body-bg); font-family: 'Poppins', sans-serif; display: flex; min-height: 100vh; margin: 0; }
        .sidebar { width: 260px; background: var(--sidebar-bg); padding: 30px 20px; color: white; position: fixed; height: 100vh; }
        .nav-link { color: rgba(255,255,255,0.7); padding: 12px 15px; border-radius: 10px; text-decoration: none; display: flex; align-items: center; transition: 0.3s; }
        .nav-link.active { background: rgba(255,255,255,0.1); color: var(--riverside-red); }
        .main-content { flex: 1; margin-left: 260px; padding: 40px; }
        .table-container { background: #fff; border-radius: 15px; border: 1px solid #dee2e6; padding: 25px; box-shadow: 0 4px 12px rgba(0,0,0,0.03); margin-bottom: 30px; }
        
        /* Modal Styling */
        .staff-link { color: #212529; transition: 0.2s; cursor: pointer; }
        .staff-link:hover { color: var(--riverside-red); }
        .modal-content { border-radius: 20px; border: none; }
        .badge-duty { font-size: 0.75rem; }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="mb-5 text-center">
        <h4 class="fw-bold"><span style="color:var(--riverside-red)">Riverside</span> Café</h4>
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

    <div class="mt-auto">
        <hr class="text-secondary opacity-25 mx-3">
        <a href="<?= base_url('logout') ?>" class="nav-link text-danger">
            <i class="fas fa-sign-out-alt me-3"></i> Logout
        </a>
    </div>
</nav>
    
</div>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Staff Management</h2>
        <a href="<?= base_url('auth/register') ?>" class="btn btn-danger px-4">Add New Staff</a>
    </div>

    <div class="table-container">
    <h5 class="fw-bold mb-3">Active Team Members</h5>
    <p class="text-muted small">Click a staff name to view history.</p>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead class="table-light">
                <tr class="small text-secondary">
                    <th>STAFF NAME</th>
                    <th>SCHEDULED DAY</th>
                    <th>ROLE</th>
                    <th class="text-center">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($staff_members)): foreach($staff_members as $staff): ?>
                <tr>
                    <td>
                        <a href="javascript:void(0)" 
                           class="text-decoration-none staff-link fw-bold" 
                           data-bs-toggle="modal" 
                           data-bs-target="#modalStaff<?= $staff['id'] ?>">
                            <?= esc($staff['name']) ?>
                        </a>
                        <br><small class="text-muted"><?= esc($staff['email']) ?></small>
                    </td>
                    <td><span class="badge bg-light text-dark border"><?= $staff['duty_day'] ?? 'Not Set' ?></span></td>
                    <td><span class="badge bg-dark"><?= strtoupper($staff['role']) ?></span></td>
                    <td class="text-center">
                        <a href="<?= base_url('auth/edit/'.$staff['id']) ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                        <a href="<?= base_url('auth/delete/'.$staff['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete?')"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php if(!empty($staff_members)): foreach($staff_members as $staff): ?>
<div class="modal fade" id="modalStaff<?= $staff['id'] ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow border-0" style="border-radius: 15px;">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Duty History: <?= esc($staff['name']) ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="table-responsive">
                    <table class="table table-sm table-hover align-middle">
                        <thead class="table-light text-secondary">
                            <tr>
                                <th>LOGIN</th>
                                <th>LOGOUT</th>
                                <th>DURATION</th>
                                <th>STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $found = false;
                            foreach($duty_logs as $log): 
                                if($log['staff_name'] === $staff['name']): 
                                    $found = true;
                            ?>
                            <tr>
                                <td><?= date('M d, h:i A', strtotime($log['login_time'])) ?></td>
                                <td><?= $log['logout_time'] ? date('h:i A', strtotime($log['logout_time'])) : '---' ?></td>
                                <td class="text-primary fw-bold"><?= $log['duration'] ?? 'Active' ?></td>
                                <td>
                                    <span class="badge rounded-pill <?= $log['status'] == 'On Duty' ? 'bg-success' : 'bg-secondary' ?>">
                                        <?= $log['status'] ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endif; endforeach; ?>
                            
                            <?php if(!$found): ?>
                                <tr><td colspan="4" class="text-center py-4 text-muted">No records found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach; endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<!-- // Final update by Irish Ann -->