<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riverside Café | Sign In</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --gold:      #ffc107;
            --gold-dark: #e6ac00;
            --bg:        #0b0b0b;
            --card-bg:   #121212;
            --border:    #222222;
            --muted:     #a0a0a0;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg);
            background-image:
                linear-gradient(rgba(0,0,0,0.85), rgba(0,0,0,0.90)),
                url('<?= base_url("assets/img/river.jpg") ?>');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            color: #fff;
        }

        /* ── Card ── */
        .login-card {
            width: 100%;
            max-width: 400px;
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 40px 35px 35px;
            position: relative;
            overflow: hidden;
            animation: cardIn 0.45s ease-out both;
        }

        /* Gold top accent — same feel as dashboard gold accents */
        .login-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: var(--gold);
            border-radius: 20px 20px 0 0;
        }

        /* ── Brand ── */
        .brand {
            text-align: center;
            margin-bottom: 30px;
        }

        .brand-icon {
            width: 54px;
            height: 54px;
            background: var(--gold);
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 14px;
        }

        .brand-icon i { color: #000; font-size: 22px; }

        .brand-name {
            font-size: 1.45rem;
            font-weight: 700;
            line-height: 1;
            margin-bottom: 6px;
        }

        .brand-name .gold { color: var(--gold); }

        .brand-sub {
            font-size: 0.62rem;
            font-weight: 600;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            color: var(--muted);
        }

        /* ── Flash messages ── */
        .flash-msg {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 10px 14px;
            border-radius: 10px;
            font-size: 0.78rem;
            margin-bottom: 22px;
        }

        .flash-msg.success {
            background: rgba(80, 205, 137, 0.08);
            border: 1px solid rgba(80, 205, 137, 0.25);
            color: #50cd89;
        }

        .flash-msg.error {
            background: rgba(255, 77, 77, 0.08);
            border: 1px solid rgba(255, 77, 77, 0.25);
            color: #ff7f7f;
        }

        /* ── Fields ── */
        .field-group { margin-bottom: 16px; }

        .field-label {
            display: block;
            font-size: 0.62rem;
            font-weight: 600;
            letter-spacing: 1.8px;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 7px;
        }

        .field-wrap { position: relative; }

        .field-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            font-size: 13px;
            pointer-events: none;
            transition: color 0.2s;
        }

        .field-input {
            width: 100%;
            background: #1a1a1a;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 11px 14px 11px 40px;
            color: #fff;
            font-family: 'Poppins', sans-serif;
            font-size: 0.85rem;
            font-weight: 300;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .field-input::placeholder { color: #444; }

        .field-input:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(255, 193, 7, 0.12);
        }

        .field-wrap:focus-within .field-icon { color: var(--gold); }

        /* Password toggle */
        .pwd-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--muted);
            cursor: pointer;
            font-size: 13px;
            padding: 4px;
            line-height: 1;
            transition: color 0.2s;
        }
        .pwd-toggle:hover { color: #fff; }
        .field-input.has-toggle { padding-right: 40px; }

        /* Forgot link */
        .forgot-row {
            text-align: right;
            margin-top: -6px;
            margin-bottom: 25px;
            width: 100%;
        }

        .forgot-link {
            font-size: 0.7rem;
            color: var(--muted);
            text-decoration: none;
            transition: color 0.2s;
            display: inline-block;
        }
        .forgot-link:hover { color: var(--gold); }

        /* Submit — matches .btn-new-trans from dashboard */
        .btn-signin {
            width: 100%;
            background: var(--gold);
            color: #000;
            border: none;
            border-radius: 50px;
            padding: 12px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.78rem;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            cursor: pointer;
            transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
            position: relative;
        }

        .btn-signin:hover {
            background: var(--gold-dark);
            box-shadow: 0 6px 20px rgba(255, 193, 7, 0.25);
            transform: translateY(-1px);
        }

        .btn-signin:active { transform: translateY(0); box-shadow: none; }

        /* Loading */
        .btn-signin .btn-text { transition: opacity 0.2s; }
        .btn-signin .btn-loader { display: none; }
        .btn-signin.loading .btn-text { opacity: 0; }
        .btn-signin.loading .btn-loader {
            display: block;
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
        }

        /* Footer */
        .footer-note {
            text-align: center;
            margin-top: 24px;
            font-size: 0.65rem;
            color: rgba(255, 255, 255, 0.6);
            font-weight: 300;
            line-height: 1.7;
        }

        @keyframes cardIn {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 480px) {
            .login-card { padding: 36px 24px 28px; }
        }

        /* Scrollbar — matches dashboard */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-thumb { background: #333; border-radius: 10px; }
    </style>
</head>
<body>

    <div class="login-card">

        <div class="brand">
            <div class="brand-icon">
                <i class="fas fa-mug-hot"></i>
            </div>
            <div class="brand-name">
                <span class="gold">Riverside</span> Café
            </div>
            <div class="brand-sub">System</div>
        </div>

        <?php if(session()->getFlashdata('msg')): ?>
            <?php
                $msg = session()->getFlashdata('msg');
                $isSuccess = (strpos($msg, 'Successful') !== false);
            ?>
            <div class="flash-msg <?= $isSuccess ? 'success' : 'error' ?>">
                <i class="fas <?= $isSuccess ? 'fa-check-circle' : 'fa-exclamation-circle' ?>"></i>
                <?= $msg ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('auth/loginProcess') ?>" method="POST" id="loginForm" novalidate>
            <?= csrf_field() ?>

            <div class="field-group">
                <label class="field-label" for="email">Email Address</label>
                <div class="field-wrap">
                    <input type="email" id="email" name="email" class="field-input"
                           placeholder="example@gmail.com" autocomplete="email" required>
                    <i class="fas fa-envelope field-icon"></i>
                </div>
            </div>

            <div class="field-group">
                <label class="field-label" for="password">Password</label>
                <div class="field-wrap">
                    <input type="password" id="password" name="password"
                           class="field-input has-toggle"
                           placeholder="••••••" autocomplete="current-password" required>
                    <i class="fas fa-lock field-icon"></i>
                    <button type="button" class="pwd-toggle" id="pwdToggle" aria-label="Toggle password visibility">
                        <i class="fas fa-eye" id="pwdIcon"></i>
                    </button>
                </div>
            </div>

            <div class="forgot-row">
                <a href="<?= base_url('auth/forgot_password') ?>" class="forgot-link">Forgot password?</a>
            </div>

            <button type="submit" class="btn-signin" id="signInBtn">
                <span class="btn-text"><i class="fas fa-sign-in-alt me-2"></i>Sign In</span>
                <span class="btn-loader"><i class="fas fa-circle-notch fa-spin"></i></span>
            </button>
        </form>

        <p class="footer-note">
    © 2026 Riverside Café. All rights reserved.
       </p>

    </div>

    <script>
        const pwdInput = document.getElementById('password');
        const pwdIcon  = document.getElementById('pwdIcon');
        document.getElementById('pwdToggle').addEventListener('click', function() {
            const isHidden = pwdInput.type === 'password';
            pwdInput.type = isHidden ? 'text' : 'password';
            pwdIcon.className = isHidden ? 'fas fa-eye-slash' : 'fas fa-eye';
        });

        document.getElementById('loginForm').addEventListener('submit', function() {
            const btn = document.getElementById('signInBtn');
            btn.classList.add('loading');
            btn.disabled = true;
        });
    </script>

</body>
</html>