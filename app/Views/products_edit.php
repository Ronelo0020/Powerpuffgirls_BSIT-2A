<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riverside | Edit Menu Item</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root { 
            --riverside-red: #ff4d4d; 
            --riverside-yellow: #ffc107;
            --dark-bg: #121212;
            --card-bg: #1e1e1e;
            --sidebar-bg: #000000;
            --input-bg: #2d2d2d;
            --text-main: #ffffff;
            --text-muted: #b0b0b0;
        }

        body { 
            background-color: var(--dark-bg);
            font-family: 'Poppins', sans-serif; 
            display: flex;
            min-height: 100vh;
            margin: 0;
            color: var(--text-main);
        }

        /* Sidebar */
        .sidebar { 
            width: 260px; 
            background: var(--sidebar-bg); 
            padding: 30px 20px; 
            display: flex; 
            flex-direction: column; 
            flex-shrink: 0;
            border-right: 1px solid #333;
        }

        .nav-link { 
            color: var(--text-muted); 
            padding: 12px 15px; 
            border-radius: 10px; 
            margin-bottom: 5px; 
            transition: 0.3s; 
            text-decoration: none; 
            display: flex; 
            align-items: center;
            font-size: 0.9rem;
        }

        .nav-link:hover { color: var(--text-main); background: #222; }
        .nav-link.active { background: #333; color: var(--riverside-yellow); }

        /* Main Content */
        .main-content { flex: 1; padding: 40px; display: flex; justify-content: center; align-items: flex-start; }

        .form-card {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 600px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.5);
            border: 1px solid #333;
        }

        .form-label {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            color: var(--riverside-yellow);
            margin-bottom: 8px;
            letter-spacing: 1px;
        }

        .form-control, .form-select { 
            background-color: var(--input-bg);
            border: 1px solid #444;
            border-radius: 12px;
            padding: 12px 15px;
            color: white;
            transition: 0.3s;
        }

        .form-control:focus, .form-select:focus { 
            background-color: #333;
            border-color: var(--riverside-yellow);
            box-shadow: none;
            color: white;
        }

        /* Customize File Input */
        input[type="file"]::file-selector-button {
            background: #444;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 5px 10px;
            margin-right: 10px;
            cursor: pointer;
        }

        .btn-update {
            background: var(--riverside-yellow);
            color: #000;
            border: none;
            padding: 15px;
            border-radius: 12px;
            font-weight: 700;
            transition: 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-update:hover {
            background: #e5ac00;
            transform: translateY(-2px);
            color: #000;
        }

        .current-img-preview {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 10px;
            border: 2px solid #444;
        }

        .icon-box-edit {
            width: 60px; height: 60px;
            background: rgba(255, 193, 7, 0.1);
            color: var(--riverside-yellow);
            display: flex; align-items: center; justify-content: center;
            border-radius: 15px; margin: 0 auto 20px;
            font-size: 1.5rem;
        }
        /* Para makita ang "Update item details for..." */
.text-muted.small {
    color: #e0e0e0 !important; /* Light gray/white */
}

/* Para sa Discard Changes link */
.hover-white {
    color: #ffffff !important; /* Pure white */
    opacity: 0.8;
    transition: 0.3s;
}

.hover-white:hover {
    opacity: 1;
    color: var(--riverside-red) !important; /* Mag-red kon i-hover */
    text-decoration: underline;
}
    </style>
</head>
<body>

<div class="sidebar">
    <div class="mb-5 text-center">
        <h4 class="fw-bold"><span style="color:var(--riverside-red)">Riverside</span> <span style="color:white">Café</span></h4>
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
        <div class="mt-auto">
            <a href="<?= base_url('logout') ?>" class="nav-link text-danger">
                <i class="fas fa-sign-out-alt me-3"></i> Logout
            </a>
        </div>
    </nav>
</div>

<div class="main-content">
    <div class="form-card">
        <div class="text-center mb-4">
            <div class="icon-box-edit">
                <i class="fas fa-edit"></i>
            </div>
            <h3 class="fw-bold m-0 text-white">Modify Menu Item</h3>
            <p class="text-muted small">Update item details for <span class="text-warning"><?= $product['product_name'] ?></span></p>
        </div>

        <form action="<?= base_url('products/update/' . $product['id']) ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">Product Name</label>
                <input type="text" name="product_name" class="form-control" value="<?= $product['product_name'] ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Category</label>
                <select name="category" class="form-select" required>
                    <option value="Hot Coffee" <?= $product['category'] == 'Hot Coffee' ? 'selected' : '' ?>>Hot Coffee</option>
                    <option value="Iced Coffee" <?= $product['category'] == 'Iced Coffee' ? 'selected' : '' ?>>Iced Coffee</option>
                    <option value="Non-Coffee" <?= $product['category'] == 'Non-Coffee' ? 'selected' : '' ?>>Non-Coffee</option>
                    <option value="Pastries" <?= $product['category'] == 'Pastries' ? 'selected' : '' ?>>Pastries</option>
                    <option value="Meals" <?= $product['category'] == 'Meals' ? 'selected' : '' ?>>Meals</option>
                </select>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-6">
                    <label class="form-label">Price (₱)</label>
                    <input type="number" step="0.01" name="price" class="form-control" value="<?= $product['price'] ?>" required>
                </div>
                <div class="col-6">
                    <label class="form-label">Current Stock</label>
                    <input type="number" name="stock" class="form-control" value="<?= $product['stock'] ?>" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Update Image</label>
                <div class="d-flex align-items-center gap-3 p-3 mb-2" style="background: rgba(255,255,255,0.05); border-radius: 12px;">
                    <img src="<?= base_url('assets/img/products/' . ($product['image'] ?: 'no-image.png')) ?>" class="current-img-preview">
                    <div class="flex-grow-1">
                        <input type="file" name="product_image" id="product_image" class="form-control" accept="image/*">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-update w-100 mb-3 shadow">
                <i class="fas fa-check-circle me-2"></i> Apply Changes
            </button>

            <div class="text-center">
                <a href="<?= base_url('products') ?>" class="text-decoration-none text-muted small hover-white">
                    <i class="fas fa-times me-1"></i> Discard Changes
                </a>
            </div>
        </form>
    </div>
</div>

</body>
</html>