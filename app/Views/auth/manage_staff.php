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
        :root { 
            --accent-gold: #ffcc4d; 
            --riverside-red: #ff4d4d; 
            --bg-black: #000000; 
            --card-dark: #0a0a0a; 
            --sidebar-bg: #0a0a0a; 
            --text-main: #ffffff;
            --text-muted: #888888;
        }

        body { 
            background-color: var(--bg-black); 
            font-family: 'Poppins', sans-serif; 
            display: flex; 
            min-height: 100vh; 
            margin: 0; 
            color: var(--text-main);
        }

        /* --- SIDEBAR --- */
        .sidebar { 
            width: 260px; 
            background: var(--sidebar-bg); 
            padding: 30px 20px; 
            position: fixed; 
            height: 100vh; 
            border-right: 1px solid #1a1a1a;
        }
        .nav-link { 
            color: var(--text-muted); 
            padding: 12px 15px; 
            border-radius: 10px; 
            text-decoration: none; 
            display: flex; 
            align-items: center; 
            transition: 0.3s; 
        }
        .nav-link.active { 
            background: var(--accent-gold); 
            color: #000 !important; 
            font-weight: 600;
        }

        /* --- MAIN CONTENT --- */
        .main-content { flex: 1; margin-left: 260px; padding: 40px; }
        
        .table-container { 
            background: var(--card-dark); 
            border-radius: 15px; 
            border: 1px solid #222; 
            padding: 25px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.5); 
            margin-bottom: 40px;
        }

        /* --- TABLE STYLING --- */
        .table { 
            color: var(--text-main) !important; 
            background: transparent !important;
            border-color: #222 !important; 
        }
        .table thead th { 
            color: var(--accent-gold); 
            font-size: 0.75rem; 
            letter-spacing: 1px; 
            border-bottom: 2px solid #333;
            background: transparent !important;
        }
        .table tbody td { 
            border-bottom: 1px solid #1a1a1a; 
            padding: 15px 10px; 
            background: transparent !important;
            color: white !important;
        }

        .badge.bg-dark { background-color: #222 !important; border: 1px solid #444; color: white; }
        .badge.bg-light { 
            background-color: rgba(255, 204, 77, 0.1) !important; 
            color: var(--accent-gold) !important; 
            border: 1px solid var(--accent-gold) !important; 
        }
        
        .btn-add { background-color: var(--riverside-red); color: white; border: none; padding: 10px 20px; border-radius: 8px; }
        .action-btn { border: 1px solid #333; padding: 5px 10px; border-radius: 5px; color: var(--accent-gold); transition: 0.2s; }
        .action-btn:hover { background: #222; }
        .delete-btn { color: var(--riverside-red); border-color: #333; }

        .profile-img-container {
            width: 40px; 
            height: 40px; 
            background: #111; 
            border: 1px solid #333; 
            border-radius: 8px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            margin-right: 12px; 
            overflow: hidden;
        }

        .room-title {
            font-size: 1.1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="mb-5 text-center">
        <h4 class="fw-bold"><span style="color:var(--accent-gold)">Riverside</span> Café</h4>
    </div>
    <nav class="d-flex flex-column h-100">
        <a href="<?= base_url('dashboard') ?>" class="nav-link"><i class="fas fa-chart-pie me-3"></i> Overview</a>
        <a href="<?= base_url('products') ?>" class="nav-link"><i class="fas fa-coffee me-3"></i> Menu & Inventory</a>
        <a href="<?= base_url('pos') ?>" class="nav-link"><i class="fas fa-cash-register me-3"></i> Barista POS</a>
        <a href="<?= base_url('sales') ?>" class="nav-link"><i class="fas fa-file-invoice-dollar me-3"></i> Sales Reports</a>
        <hr class="text-secondary opacity-25 mx-3">
        <a href="<?= base_url('auth/manage') ?>" class="nav-link active"><i class="fas fa-users-cog me-3"></i> Manage Users</a>
    </nav>
</div>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-white">User Management</h2>
        <a href="<?= base_url('auth/register') ?>" class="btn-add text-decoration-none">
            <i class="fas fa-plus me-2"></i>Add New Account
        </a>
    </div>

    <div class="table-container" style="border-top: 3px solid var(--accent-gold);">
        <div class="room-title mb-4 text-white">
            <i class="fas fa-user-shield text-warning"></i> Administrators
        </div>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>ADMIN NAME</th>
                        <th>EMAIL</th>
                        <th>POSITION</th>
                        <th class="text-center">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($admins)): foreach($admins as $admin): ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="profile-img-container">
                                    <?php if(!empty($admin['profile_pic']) && file_exists(FCPATH . 'uploads/profiles/' . $admin['profile_pic'])): ?>
                                        <img src="<?= base_url('uploads/profiles/'.$admin['profile_pic']) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                    <?php else: ?>
                                        <span style="color: var(--accent-gold); font-weight: 600;"><?= strtoupper(substr($admin['name'], 0, 1)) ?></span>
                                    <?php endif; ?>
                                </div>
                                <span class="fw-bold"><?= esc($admin['name']) ?></span>
                            </div>
                        </td>
                        <td><?= esc($admin['email']) ?></td>
                        <td><span class="badge bg-warning text-dark">ADMIN</span></td>
                        <td class="text-center">
                            <a href="<?= base_url('auth/edit/'.$admin['id']) ?>" class="action-btn text-decoration-none"><i class="fas fa-edit"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                        <tr><td colspan="4" class="text-center py-4 text-muted">No admins found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="table-container" style="border-top: 3px solid var(--riverside-red);">
        <div class="room-title mb-4 text-white">
            <i class="fas fa-users text-danger"></i> Staff Members
        </div>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>STAFF NAME</th>
                        <th>CONTACT INFO</th>
                        <th>DUTY SCHEDULE</th>
                        <th>POSITION</th>
                        <th class="text-center">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($staff_members)): foreach($staff_members as $staff): ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="profile-img-container">
                                    <?php if(!empty($staff['profile_pic']) && file_exists(FCPATH . 'uploads/profiles/' . $staff['profile_pic'])): ?>
                                        <img src="<?= base_url('uploads/profiles/'.$staff['profile_pic']) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                    <?php else: ?>
                                        <span style="color: var(--accent-gold); font-weight: 600;"><?= strtoupper(substr($staff['name'], 0, 1)) ?></span>
                                    <?php endif; ?>
                                </div>
                                <span class="fw-bold"><?= esc($staff['name']) ?></span>
                            </div>
                        </td>
                        <td>
                            <div style="font-size: 0.85rem;"><i class="far fa-envelope me-2 text-warning"></i><?= esc($staff['email']) ?></div>
                            <div style="font-size: 0.75rem; color: #888;"><i class="fas fa-phone-alt me-2"></i><?= !empty($staff['phone']) ? esc($staff['phone']) : 'N/A' ?></div>
                        </td>
                        <td>
                            <span class="badge bg-light text-uppercase">
                                <i class="far fa-calendar-alt me-2"></i><?= (!empty($staff['duty_day'])) ? esc($staff['duty_day']) : 'Not Set' ?>
                            </span>
                        </td>
                        <td><span class="badge bg-dark">STAFF</span></td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="<?= base_url('auth/edit/'.$staff['id']) ?>" class="action-btn text-decoration-none"><i class="fas fa-edit"></i></a>
                                <a href="<?= base_url('auth/delete/'.$staff['id']) ?>" class="action-btn delete-btn text-decoration-none" onclick="return confirm('Delete this account?')"><i class="fas fa-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                        <tr><td colspan="5" class="text-center py-4 text-muted">No staff found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>