<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riverside Café | Registration</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --red: #e02020;
            --red-dark: #b01515;
            --red-glow: rgba(224, 32, 32, 0.35);
            --glass-bg: rgba(10, 8, 6, 0.72);
            --glass-border: rgba(255, 255, 255, 0.08);
            --input-bg: rgba(255, 255, 255, 0.06);
            --input-border: rgba(255, 255, 255, 0.12);
            --input-focus: rgba(224, 32, 32, 0.4);
            --label-color: rgba(255, 255, 255, 0.45);
            --text-muted: rgba(255, 255, 255, 0.35);
            --cream: #f5ede0;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background: linear-gradient(160deg, rgba(0,0,0,0.82) 0%, rgba(10,4,2,0.78) 100%),
                        url('<?= base_url("assets/img/river.jpg") ?>');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 16px;
        }

        /* Ambient glow orbs */
        body::before {
            content: '';
            position: fixed;
            top: -120px; left: -120px;
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(224,32,32,0.12) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
            z-index: 0;
        }
        body::after {
            content: '';
            position: fixed;
            bottom: -100px; right: -100px;
            width: 350px; height: 350px;
            background: radial-gradient(circle, rgba(224,32,32,0.08) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
            z-index: 0;
        }

        .card-wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 520px;
            animation: slideUp 0.6s cubic-bezier(0.22, 1, 0.36, 1) forwards;
            opacity: 0;
            transform: translateY(24px);
        }

        @keyframes slideUp {
            to { opacity: 1; transform: translateY(0); }
        }

        /* Decorative top accent line */
        .card-wrapper::before {
            content: '';
            display: block;
            height: 3px;
            width: 70px;
            background: linear-gradient(90deg, var(--red), transparent);
            margin: 0 auto 0 30px;
            border-radius: 2px;
            margin-bottom: -1px;
        }

        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(28px);
            -webkit-backdrop-filter: blur(28px);
            border: 1px solid var(--glass-border);
            border-top: 1px solid rgba(255,255,255,0.13);
            border-radius: 20px;
            padding: 36px 40px 32px;
            box-shadow: 
                0 32px 64px rgba(0,0,0,0.7),
                0 0 0 1px rgba(255,255,255,0.04) inset,
                0 1px 0 rgba(255,255,255,0.1) inset;
            color: white;
        }

        /* ── Brand Header ── */
        .brand-header {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 28px;
            padding-bottom: 22px;
            border-bottom: 1px solid rgba(255,255,255,0.07);
        }

        .brand-icon {
            width: 46px; height: 46px;
            background: var(--red);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem;
            box-shadow: 0 4px 20px var(--red-glow);
            flex-shrink: 0;
        }

        .brand-text-block { line-height: 1; }

        .brand-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.75rem;
            font-weight: 900;
            letter-spacing: -0.5px;
            line-height: 1.1;
        }

        .brand-title .riverside { color: var(--red); }
        .brand-title .cafe { color: #ffffff; }

        .brand-sub {
            font-size: 0.72rem;
            font-weight: 500;
            color: var(--label-color);
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-top: 5px;
        }

        /* ── Form Elements ── */
        .form-label {
            font-size: 0.62rem;
            font-weight: 600;
            color: var(--label-color);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 7px;
            display: block;
        }

        .form-control,
        .form-select {
            background: var(--input-bg) !important;
            border: 1px solid var(--input-border) !important;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 0.875rem;
            font-family: 'DM Sans', sans-serif;
            color: #ffffff !important;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
            margin-bottom: 0;
        }

        .form-control::placeholder { color: rgba(255,255,255,0.25); }

        .form-control:focus,
        .form-select:focus {
            background: rgba(255,255,255,0.09) !important;
            border-color: var(--red) !important;
            box-shadow: 0 0 0 3px var(--input-focus) !important;
            outline: none;
            color: #fff !important;
        }

        .form-select option {
            background: #1a1a1a;
            color: #fff;
        }

        /* Date input calendar icon color fix */
        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(1) opacity(0.4);
            cursor: pointer;
        }

        /* File input */
        input[type="file"].form-control {
            padding: 8px 14px;
            color: rgba(255,255,255,0.5) !important;
            cursor: pointer;
        }
        input[type="file"]::file-selector-button {
            background: rgba(224,32,32,0.18);
            border: 1px solid rgba(224,32,32,0.4);
            color: rgba(255,255,255,0.75);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 6px;
            cursor: pointer;
            margin-right: 10px;
            transition: background 0.2s;
        }
        input[type="file"]::file-selector-button:hover {
            background: rgba(224,32,32,0.3);
        }

        /* ── Field groups ── */
        .field-group { margin-bottom: 14px; }
        .field-group .row { --bs-gutter-x: 10px; }

        /* Section divider */
        .section-label {
            font-size: 0.6rem;
            font-weight: 700;
            color: var(--red);
            text-transform: uppercase;
            letter-spacing: 2.5px;
            margin: 18px 0 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(255,255,255,0.07);
        }

        /* ── Submit Button ── */
        .btn-register {
            background: linear-gradient(135deg, var(--red) 0%, #c51a1a 100%);
            color: #ffffff;
            border: none;
            border-radius: 11px;
            padding: 13px;
            width: 100%;
            font-family: 'DM Sans', sans-serif;
            font-weight: 700;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-top: 20px;
            box-shadow: 0 4px 20px var(--red-glow), 0 1px 0 rgba(255,255,255,0.15) inset;
            transition: transform 0.18s, box-shadow 0.18s, background 0.18s;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .btn-register::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(255,255,255,0.08) 0%, transparent 60%);
            border-radius: inherit;
        }

        .btn-register:hover {
            background: linear-gradient(135deg, #f02828 0%, var(--red-dark) 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 28px var(--red-glow);
        }

        .btn-register:active {
            transform: translateY(0);
            box-shadow: 0 2px 12px var(--red-glow);
        }

        /* ── Footer ── */
        .footer-text {
            text-align: center;
            margin-top: 18px;
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .footer-text a {
            color: rgba(255,255,255,0.65);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .footer-text a:hover { color: var(--red); }

        /* ── Alert ── */
        .alert-custom {
            background: rgba(224, 32, 32, 0.15);
            border: 1px solid rgba(224, 32, 32, 0.4);
            color: rgba(255,255,255,0.9);
            font-size: 0.8rem;
            border-radius: 10px;
            padding: 10px 14px;
            margin-bottom: 20px;
            text-align: center;
        }

        /* ── Staggered field animation ── */
        .field-group:nth-child(1) { animation: fadeField 0.5s 0.15s both; }
        .field-group:nth-child(2) { animation: fadeField 0.5s 0.22s both; }
        .field-group:nth-child(3) { animation: fadeField 0.5s 0.29s both; }
        .field-group:nth-child(4) { animation: fadeField 0.5s 0.36s both; }
        .field-group:nth-child(5) { animation: fadeField 0.5s 0.43s both; }
        .field-group:nth-child(6) { animation: fadeField 0.5s 0.50s both; }
        .field-group:nth-child(7) { animation: fadeField 0.5s 0.57s both; }

        @keyframes fadeField {
            from { opacity: 0; transform: translateY(8px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Responsive ── */
        @media (max-width: 480px) {
            .glass-card { padding: 28px 22px 24px; }
            .brand-title { font-size: 1.5rem; }
        }
    </style>
</head>
<body>

    <div class="card-wrapper">
        <div class="glass-card">

            <!-- Brand Header -->
            <div class="brand-header">
                <div class="brand-icon">☕</div>
                <div class="brand-text-block">
                    <div class="brand-title">
                        <span class="riverside">Riverside</span><span class="cafe"> Café</span>
                    </div>
                    <div class="brand-sub">Staff Registration</div>
                </div>
            </div>

            <?php if(session()->getFlashdata('msg')): ?>
                <div class="alert-custom">
                    <?= session()->getFlashdata('msg') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('auth/store') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <!-- Personal Info -->
                <div class="section-label">Personal Info</div>

                <div class="field-group">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Juan Dela Cruz" required>
                </div>

                <div class="field-group">
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-select" required>
                                <option value="" disabled selected>Select</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Birthdate</label>
                            <input type="date" name="birthdate" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="field-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="staff@gmail.com" required>
                </div>

                <!-- Account Setup -->
                <div class="section-label">Account Setup</div>

                <div class="field-group">
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label">Role</label>
                            <select name="role" class="form-select" required>
                                <option value="staff" selected>Staff</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Duty Day</label>
                            <select name="duty_day" class="form-select">
                                <option value="Monday">Monday</option>
                                <option value="Tuesday">Tuesday</option>
                                <option value="Wednesday">Wednesday</option>
                                <option value="Thursday">Thursday</option>
                                <option value="Friday">Friday</option>
                                <option value="Saturday">Saturday</option>
                                <option value="Sunday">Sunday</option>
                                <option value="Everyday">Everyday</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="field-group">
                    <label class="form-label">Profile Picture</label>
                    <input type="file" name="profile_pic" class="form-control" accept="image/*">
                </div>

                <div class="field-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn-register">Create Account</button>

                <div class="footer-text">
                    Done with setup? <a href="<?= base_url('auth/manage') ?>">Return to Staff Management</a>
                </div>

            </form>
        </div>
    </div>

</body>
</html>