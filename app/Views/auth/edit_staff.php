<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Staff | Riverside Café</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@300;400;500;700&family=DM+Mono&display=swap" rel="stylesheet">
    <style>
        :root { 
            --gold: #e8b84b; 
            --red: #ff4d4d; 
            --glass: rgba(15, 15, 15, 0.85); 
            --border: rgba(255, 255, 255, 0.08);
        }

        body { 
            font-family: 'DM Sans', sans-serif; 
            background: linear-gradient(160deg, rgba(0,0,0,0.95) 0%, rgba(20,10,5,0.9) 100%),
                        url('<?= base_url("assets/img/river.jpg") ?>');
            background-size: cover;
            background-attachment: fixed;
            color: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .glass-shell { 
            background: var(--glass); 
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid var(--border); 
            border-radius: 28px; 
            box-shadow: 0 40px 100px rgba(0,0,0,0.8);
            width: 100%;
            max-width: 600px;
            overflow: hidden;
            animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .accent-bar {
            height: 4px;
            background: linear-gradient(90deg, var(--red), var(--gold));
        }

        .form-control, .form-select {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border);
            color: white !important;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 0.9rem;
            transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .form-control:focus, .form-select:focus {
            background: rgba(255, 255, 255, 0.07);
            border-color: var(--gold);
            box-shadow: 0 0 0 4px rgba(232, 184, 75, 0.1);
        }

        label { 
            font-family: 'DM Mono', monospace;
            color: var(--gold); 
            font-size: 0.7rem; 
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-bottom: 8px;
            display: block;
        }

        .btn-update { 
            background: var(--gold);
            border: none; 
            color: #000; 
            font-weight: 700;
            font-size: 0.85rem;
            letter-spacing: 1px;
            padding: 14px 32px;
            border-radius: 12px;
            transition: 0.3s;
            text-transform: uppercase;
        }

        .btn-update:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(232, 184, 75, 0.2);
            filter: brightness(1.1);
        }

        .avatar-wrap {
            width: 90px; height: 90px;
            background: rgba(255,255,255,0.03);
            border: 1px solid var(--border);
            border-radius: 20px;
            display: flex; align-items: center; justify-content: center;
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem; color: var(--gold);
            overflow: hidden;
            box-shadow: inset 0 0 20px rgba(0,0,0,0.5);
        }

        .section-header {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 30px 0 20px;
        }

        .section-header::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        .back-link {
            color: var(--muted);
            font-family: 'DM Mono', monospace;
            font-size: 0.75rem;
            text-decoration: none;
            transition: 0.3s;
        }

        .back-link:hover { color: var(--red); }
    </style>
</head>
<body>

<div class="glass-shell">
    <div class="accent-bar"></div>
    <div class="p-4 p-md-5">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 style="font-family: 'Playfair Display', serif; font-weight: 700;" class="mb-1">Edit <span style="color: var(--gold);">Profile</span></h2>
                <p style="font-size: 0.85rem; opacity: 0.6;">Managing account for <span class="text-white"><?= esc($staff['name']) ?></span></p>
            </div>
            <div class="avatar-wrap" id="avatar-preview-box">
                <?php if(!empty($staff['profile_pic']) && file_exists(FCPATH . 'uploads/profiles/' . $staff['profile_pic'])): ?>
                    <img src="<?= base_url('uploads/profiles/'.$staff['profile_pic']) ?>" style="width:100%; height:100%; object-fit:cover;">
                <?php else: ?>
                    <span><?= strtoupper(substr($staff['name'], 0, 1)) ?></span>
                <?php endif; ?>
            </div>
        </div>

        <form action="<?= base_url('auth/update/'.$staff['id']) ?>" method="post" enctype="multipart/form-data">
            <div class="section-header">Personal Information</div>
            
            <div class="mb-4">
                <label>Legal Full Name</label>
                <input type="text" name="name" class="form-control" value="<?= esc($staff['name']) ?>" required>
            </div>

            <div class="row g-3">
                <div class="col-md-6 mb-3">
                    <label>Gender Identity</label>
                    <select name="gender" class="form-select" required>
                        <option value="Male" <?= ($staff['gender'] ?? '') == 'Male' ? 'selected' : '' ?>>Male</option>
                        <option value="Female" <?= ($staff['gender'] ?? '') == 'Female' ? 'selected' : '' ?>>Female</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Date of Birth</label>
                    <input type="date" name="birthdate" class="form-control" value="<?= esc($staff['birthdate'] ?? '') ?>" required>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-6 mb-3">
                    <label>Email Address</label>
                    <input type="email" name="email" class="form-control" value="<?= esc($staff['email']) ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Contact Number</label>
                    <input type="text" name="phone" class="form-control" value="<?= esc($staff['phone'] ?? '') ?>">
                </div>
            </div>

            <div class="section-header">Administration</div>
            
            <div class="mb-4">
                <label>Profile Signature (Photo)</label>
                <input type="file" name="profile_pic" class="form-control" accept="image/*" onchange="previewImage(this)">
            </div>

            <div class="row g-3">
                <div class="col-md-6 mb-4">
                    <label>Assigned Role</label>
                    <select name="role" class="form-select">
                        <option value="admin" <?= $staff['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                        <option value="staff" <?= $staff['role'] == 'staff' ? 'selected' : '' ?>>Staff</option>
                    </select>
                </div>
                <div class="col-md-6 mb-4">
                    <label>Duty Shift</label>
                    <select name="duty_day" class="form-select" required>
                        <?php foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday', 'Everyday'] as $day): ?>
                            <option value="<?= $day ?>" <?= ($staff['duty_day'] ?? '') == $day ? 'selected' : '' ?>><?= $day ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <a href="<?= base_url('auth/manage') ?>" class="back-link">
                    <i class="fas fa-chevron-left me-1"></i> Return to Manage
                </a>
                <button type="submit" class="btn-update">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatar-preview-box').innerHTML = `<img src="${e.target.result}" style="width:100%; height:100%; object-fit:cover; animation: fadeIn 0.5s;">`;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

</body>
</html>