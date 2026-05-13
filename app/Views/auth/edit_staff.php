<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Staff | Riverside Café</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root { 
            --accent-gold: #ffcc4d; 
            --riverside-red: #ff4d4d; 
            --bg-dark: #050505; 
            --card-dark: #0d0d0d; 
            --text-main: #ffffff;
        }

        body { 
            font-family: 'Poppins', sans-serif; 
            background: radial-gradient(circle at center, #1a0a0a 0%, var(--bg-dark) 100%); 
            color: var(--text-main);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }

        .card { 
            background-color: var(--card-dark); 
            border: 1px solid #222; 
            border-radius: 20px; 
            box-shadow: 0 20px 50px rgba(0,0,0,0.7);
            width: 100%;
            max-width: 550px;
            overflow: hidden;
        }

        .card-header-accent {
            height: 5px;
            background: linear-gradient(90deg, var(--riverside-red), var(--accent-gold));
        }

        .form-control, .form-select {
            background-color: #151515;
            border: 1px solid #2a2a2a;
            color: white !important;
            border-radius: 10px;
            padding: 12px;
            transition: 0.3s;
        }

        .form-control:focus, .form-select:focus {
            background-color: #1a1a1a;
            border-color: var(--accent-gold);
            box-shadow: 0 0 0 0.25rem rgba(255, 204, 77, 0.1);
        }

        label { color: var(--accent-gold); margin-bottom: 8px; font-size: 0.85rem; font-weight: 500; }

        .btn-save { 
            background: linear-gradient(135deg, var(--riverside-red) 0%, #cc3333 100%);
            border: none; 
            color: white; 
            font-weight: 600;
            padding: 12px 30px;
            border-radius: 10px;
            transition: 0.3s;
        }

        .edit-avatar-container {
            width: 80px; height: 80px;
            background: #111;
            border: 2px dashed #444;
            border-radius: 15px;
            display: flex; align-items: center; justify-content: center;
            font-size: 2rem; color: var(--accent-gold);
            overflow: hidden;
        }

        .section-title {
            border-left: 3px solid var(--riverside-red);
            padding-left: 10px;
            margin-bottom: 20px;
            font-size: 1.1rem;
            font-weight: 600;
            color: #ffffff;
        }

        .text-muted-white { color: #bbb !important; }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center p-3">
        <div class="card shadow-lg">
            <div class="card-header-accent"></div>
            <div class="card-body p-4 p-md-5">
                <div class="d-flex align-items-center justify-content-between mb-5">
                    <div>
                        <h3 class="fw-bold mb-1 text-white">Update Profile</h3>
                        <p class="text-muted-white small mb-0">Modifying account for <span class="text-white fw-bold"><?= esc($staff['name']) ?></span></p>
                    </div>
                    <div class="edit-avatar-container" id="avatar-preview-box">
                        <?php if(!empty($staff['profile_pic']) && file_exists(FCPATH . 'uploads/profiles/' . $staff['profile_pic'])): ?>
                            <img src="<?= base_url('uploads/profiles/'.$staff['profile_pic']) ?>" style="width:100%; height:100%; object-fit:cover;">
                        <?php else: ?>
                            <span><?= strtoupper(substr($staff['name'], 0, 1)) ?></span>
                        <?php endif; ?>
                    </div>
                </div>

                <form action="<?= base_url('auth/update/'.$staff['id']) ?>" method="post" enctype="multipart/form-data">
                    <div class="section-title">Basic Information</div>
                    
                    <div class="mb-4">
                        <label>FULL NAME</label>
                        <input type="text" name="name" class="form-control" value="<?= esc($staff['name']) ?>" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label>GENDER</label>
                            <select name="gender" class="form-select" required>
                                <option value="Male" <?= ($staff['gender'] ?? '') == 'Male' ? 'selected' : '' ?>>Male</option>
                                <option value="Female" <?= ($staff['gender'] ?? '') == 'Female' ? 'selected' : '' ?>>Female</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label>BIRTHDATE</label>
                            <input type="date" name="birthdate" class="form-control" value="<?= esc($staff['birthdate'] ?? '') ?>" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label>EMAIL ADDRESS</label>
                            <input type="email" name="email" class="form-control" value="<?= esc($staff['email']) ?>" required>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label>CONTACT NO.</label>
                            <input type="text" name="phone" class="form-control" value="<?= esc($staff['phone'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="section-title">System & Media</div>
                    <div class="mb-4">
                        <label>CHANGE PROFILE PICTURE</label>
                        <input type="file" name="profile_pic" class="form-control" accept="image/*" onchange="previewImage(this)">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label>SYSTEM ROLE</label>
                            <select name="role" class="form-select">
                                <option value="admin" <?= $staff['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                                <option value="staff" <?= $staff['role'] == 'staff' ? 'selected' : '' ?>>Staff</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label>DUTY SCHEDULE</label>
                            <select name="duty_day" class="form-select" required>
                                <?php foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday', 'Everyday'] as $day): ?>
                                    <option value="<?= $day ?>" <?= ($staff['duty_day'] ?? '') == $day ? 'selected' : '' ?>><?= $day ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <a href="<?= base_url('auth/manage') ?>" class="text-muted-white small text-decoration-none"><i class="fas fa-arrow-left me-1"></i> Back</a>
                        <button type="submit" class="btn-save shadow">UPDATE PROFILE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('avatar-preview-box').innerHTML = `<img src="${e.target.result}" style="width:100%; height:100%; object-fit:cover;">`;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>