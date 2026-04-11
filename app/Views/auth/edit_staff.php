<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Staff | Riverside Café</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f8f9fa; }
        .card { border: none; border-radius: 15px; }
        .btn-danger { background-color: #ff4d4d; border: none; }
        .btn-danger:hover { background-color: #e63939; }
    </style>
</head>
<body class="p-5">
    <div class="container">
        <div class="card mx-auto shadow-sm" style="max-width: 500px;">
            <div class="card-body p-4">
                <h4 class="fw-bold mb-1">Edit Staff Member</h4>
                <p class="text-muted small mb-4">Update schedule and account details.</p>

                <form action="<?= base_url('auth/update/'.$staff['id']) ?>" method="post">
                    
                    <div class="mb-3">
                        <label class="small fw-bold">Full Name</label>
                        <input type="text" name="name" class="form-control" value="<?= esc($staff['name']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="small fw-bold">Email Address</label>
                        <input type="email" name="email" class="form-control" value="<?= esc($staff['email']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="small fw-bold">System Access (Role)</label>
                        <select name="role" class="form-select">
                            <option value="admin" <?= $staff['role'] == 'admin' ? 'selected' : '' ?>>Admin (Full Access)</option>
                            <option value="staff" <?= $staff['role'] == 'staff' ? 'selected' : '' ?>>Staff (POS Only)</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="small fw-bold text-danger"><i class="fas fa-calendar-alt"></i> Assigned Duty Day</label>
                        <select name="duty_day" class="form-select" required style="border: 1px solid #ff4d4d;">
                            <?php 
                                $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday', 'Everyday'];
                                foreach($days as $day): 
                            ?>
                                <option value="<?= $day ?>" <?= (isset($staff['duty_day']) && $staff['duty_day'] == $day) ? 'selected' : '' ?>>
                                    <?= $day ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text mt-1" style="font-size: 0.7rem;">
                            The staff will appear as "On Duty" only on the selected day.
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center pt-2">
                        <a href="<?= base_url('auth/manage') ?>" class="text-decoration-none text-muted small">Go Back</a>
                        <div>
                            <button type="submit" class="btn btn-danger px-4 fw-bold">Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
<!-- // Final update by Irish Ann -->