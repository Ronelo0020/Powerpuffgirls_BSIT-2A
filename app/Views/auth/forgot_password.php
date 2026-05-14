<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riverside Café | Reset Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { 
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), 
                        url('<?= base_url("assets/img/river.jpg") ?>'); 
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
            padding: 40px; 
            width: 100%; 
            max-width: 400px; 
            text-align: center; 
            box-shadow: 0 25px 50px rgba(0,0,0,0.6);
            color: white;
        }

        .instruction-text {
            color: #ffffff !important;
            font-size: 0.85rem;
            opacity: 0.8;
            font-weight: 400;
            line-height: 1.5;
        }

        .form-label-sm {
            display: block;
            text-align: left;
            font-size: 0.75rem;
            margin-bottom: 5px;
            padding-left: 5px;
            color: rgba(255,255,255,0.8);
        }

        .form-control { 
            background: #ffffff !important; 
            border: none;
            border-radius: 12px; 
            padding: 12px 15px;
            margin-bottom: 15px; 
            color: #1a1a1a !important;
        }

        .btn-reset { 
            background: #ff0000; 
            color: white; 
            border: none; 
            border-radius: 12px; 
            padding: 14px; 
            width: 100%; 
            font-weight: 800; 
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 10px; 
            transition: 0.3s;
            box-shadow: 0 4px 15px rgba(255, 0, 0, 0.3);
        }

        .btn-reset:hover {
            background-color: #cc0000;
            transform: translateY(-2px);
        }

        .back-link {
            color: #ffffff;
            font-size: 0.85rem;
            text-decoration: none;
            font-weight: 600;
            opacity: 0.7;
            transition: 0.3s;
        }

        .back-link:hover {
            opacity: 1;
            color: #ff0000;
        }
    </style>
</head>
<body>

    <div class="glass-card">
        <h3 class="fw-bold mb-2">
            <span style="color: #ff0000;">Secure</span> <span style="color: #fff;">Reset</span>
        </h3>
        
        <p class="instruction-text mb-4">
            Please verify your identity by providing your registered birthdate.
        </p>

       <?php if(session()->getFlashdata('msg')): ?>
    <div class="alert alert-light py-2 small fw-bold text-success border-success">
        <?= session()->getFlashdata('msg') ?>
    </div>
<?php endif; ?>

        <form action="<?= base_url('auth/resetProcess') ?>" method="POST">
            <?= csrf_field() ?>
            
            <input type="email" name="email" class="form-control" placeholder="Your Registered Email" required>
            
            <label class="form-label-sm">Confirm Birthdate:</label>
            <input type="date" name="birthdate" class="form-control" required>
            
            <input type="password" name="new_password" class="form-control" placeholder="New Password" required>
            
            <button type="submit" class="btn btn-reset">UPDATE PASSWORD</button>
        </form>
        
        <div class="mt-4">
            <a href="<?= base_url('auth/login') ?>" class="back-link">Back to Login</a>
        </div>
    </div>

</body>
</html>