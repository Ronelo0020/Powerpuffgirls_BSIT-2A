<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riverside Café | Registration</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), 
                        url('<?= base_url("assets/img/rs.jpg") ?>'); 
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: 'Inter', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .glass-card {
            background: rgba(25, 25, 25, 0.65); 
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.6);
            color: white;
        }

        .brand-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .brand-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 5px;
            letter-spacing: -1.5px;
        }

        .brand-title .riverside { color: #ff0000; } 
        .brand-title .cafe { color: #ffffff; }

        .sub-text {
            color: #ffffff;
            font-weight: 600;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
        }

        .form-label {
            font-size: 0.65rem;
            font-weight: 800;
            color: #aaaaaa; 
            text-transform: uppercase;
            margin-bottom: 6px;
            display: block;
            letter-spacing: 1px;
        }

        .form-control, .form-select {
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 0.9rem;
            margin-bottom: 18px;
            border: none;
            transition: 0.3s ease;
        }

        .input-white {
            background: #ffffff !important;
            color: #1a1a1a !important;
        }

        .btn-register {
            background-color: #ff0000;
            color: #ffffff;
            border: none;
            border-radius: 12px;
            padding: 14px;
            width: 100%;
            font-weight: 800;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 10px;
            box-shadow: 0 4px 15px rgba(255, 0, 0, 0.3);
            transition: 0.3s;
        }

        .btn-register:hover {
            background-color: #cc0000;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 0, 0, 0.4);
        }

        .footer-text {
            text-align: center;
            margin-top: 25px;
            font-size: 0.85rem;
            color: #999999;
        }

        .footer-text a {
            color: #ffffff; 
            text-decoration: none;
            font-weight: 700;
        }

        .footer-text a:hover { color: #ff0000; }

        .alert-custom {
            background: rgba(255, 0, 0, 0.2);
            border: 1px solid #ff0000;
            color: white;
            font-size: 0.8rem;
            border-radius: 10px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <div class="glass-card">
        <div class="brand-header">
            <div class="brand-title">
                <span class="riverside">Riverside</span><span class="cafe">Café</span>
            </div>
            <div class="sub-text">Staff Registration Panel</div>
        </div>

        <?php if(session()->getFlashdata('msg')): ?>
            <div class="alert alert-custom text-center">
                <?= session()->getFlashdata('msg') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('auth/store') ?>" method="POST">
            <?= csrf_field() ?>

            <div class="mb-1">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control input-white" placeholder="Juan Dela Cruz" required>
            </div>

            <div class="mb-1">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control input-white" placeholder="staff@gmail.com" required>
            </div>

            <div class="mb-1">
                <label class="form-label">Role</label>
                <select name="role" class="form-select input-white" required>
                    <option value="staff" selected>Staff</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <div class="mb-1">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control input-white" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn btn-register">Create Account</button>

            <div class="footer-text">
                Done with setup? <a href="<?= base_url('auth/manage') ?>">Return to Staff Management</a>
            </div>
        </form>
    </div>

</body>
</html>
<!-- // Final update by Irish Ann -->