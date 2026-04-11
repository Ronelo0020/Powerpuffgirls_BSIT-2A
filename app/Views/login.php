<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riverside Café | Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
            background: rgba(25, 25, 25, 0.6); 
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 45px 35px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.6);
            color: white;
            animation: fadeIn 0.6s ease-out;
        }

        .brand-header {
            text-align: center;
            margin-bottom: 35px;
        }

        .brand-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 5px;
            letter-spacing: -1.5px;
        }

        /* Branding: Riverside is RED, Café is WHITE */
        .brand-title .riverside { color: #ff0000; } 
        .brand-title .cafe { color: #ffffff; }

        .sub-text {
            color: #ffffff;
            font-weight: 600;
            font-size: 0.9rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            opacity: 0.9;
        }

        .form-label {
            font-size: 0.65rem;
            font-weight: 800;
            color: #aaaaaa; 
            text-transform: uppercase;
            margin-bottom: 8px;
            display: block;
            letter-spacing: 1px;
        }

        .form-control {
            background: #ffffff !important;
            border: none !important;
            border-radius: 12px;
            padding: 14px 16px;
            color: #1a1a1a !important;
            font-size: 0.95rem;
            margin-bottom: 20px;
            transition: 0.3s;
        }

        .form-control:focus {
            box-shadow: 0 0 0 4px rgba(255, 0, 0, 0.25);
            outline: none;
        }

        .btn-cafe {
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
            transition: 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 0, 0, 0.3);
        }

        .btn-cafe:hover {
            background-color: #cc0000;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 0, 0, 0.4);
        }

        .footer-note {
            text-align: center;
            margin-top: 30px;
            font-size: 0.75rem;
            color: #888888;
            font-style: italic;
        }

        .alert {
            border-radius: 12px;
            font-size: 0.85rem;
            border: none;
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    <div class="glass-card">
        <div class="brand-header">
            <div class="brand-title">
                <span class="riverside">Riverside</span><span class="cafe">Café</span>
            </div>
            <div class="sub-text">Authorized Access Only</div>
        </div>

        <?php if(session()->getFlashdata('msg')): ?>
            <?php 
                $msg = session()->getFlashdata('msg');
                $isSuccess = (strpos($msg, 'Successful') !== false);
                $alertClass = $isSuccess ? 'text-success' : 'text-danger';
            ?>
            <div class="alert bg-white <?= $alertClass ?> py-2 mb-4 text-center fw-bold">
                <i class="fas <?= $isSuccess ? 'fa-check-circle' : 'fa-exclamation-circle' ?> me-1"></i> <?= $msg ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('auth/loginProcess') ?>" method="POST">
            <?= csrf_field() ?>

            <div class="mb-1">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="admin@riverside.com" required>
            </div>

            <div class="mb-1">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn btn-cafe">Sign In</button>

            <div class="footer-note">
                Contact the System Administrator for account issues.
            </div>
        </form>
    </div>

</body>
</html>