<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riverside | Add New Item</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root { --riverside-red: #ff4d4d; --sidebar-bg: #212529; --body-bg: #f8f9fa; }
        body { background-color: var(--body-bg); font-family: 'Poppins', sans-serif; display: flex; min-height: 100vh; margin: 0; }
        .sidebar { width: 260px; background: var(--sidebar-bg); padding: 30px 20px; display: flex; flex-direction: column; color: white; flex-shrink: 0; }
        .nav-link { color: rgba(255,255,255,0.7); padding: 12px 15px; border-radius: 10px; margin-bottom: 5px; transition: 0.3s; text-decoration: none; display: flex; align-items: center; font-size: 0.9rem; }
        .nav-link.active { background: rgba(255,255,255,0.1); color: var(--riverside-red); }
        .main-content { flex: 1; padding: 40px; display: flex; justify-content: center; align-items: flex-start; }
        .form-card { background: white; border-radius: 20px; border: 1px solid #dee2e6; padding: 40px; width: 100%; max-width: 600px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .form-label { font-size: 0.8rem; font-weight: 700; text-transform: uppercase; color: #6c757d; margin-bottom: 8px; }
        .form-control { border: 2px solid #f1f3f5; border-radius: 12px; padding: 12px 15px; transition: 0.3s; font-size: 0.95rem; }
        .form-control:focus { border-color: var(--riverside-red); box-shadow: none; background-color: #fff; }
        
        /* Automation Display Style */
        .category-badge { 
            background: #f8f9fa; 
            border: 2px dashed #dee2e6; 
            border-radius: 12px; 
            padding: 12px 15px; 
            font-size: 0.95rem; 
            color: #adb5bd; 
            transition: 0.3s;
            min-height: 50px;
            display: flex;
            align-items: center;
        }
        .category-detected { 
            border: 2px solid #28a745; 
            background: #f4fff7; 
            color: #28a745; 
            font-weight: 600; 
        }
        
        .btn-save { background: var(--riverside-red); color: white; border: none; padding: 15px; border-radius: 12px; font-weight: 700; transition: 0.3s; box-shadow: 0 8px 20px rgba(255, 77, 77, 0.2); }
        .btn-save:hover { background: #e63939; transform: translateY(-2px); color: white; }
        .icon-box { width: 60px; height: 60px; background: #fff5f5; color: var(--riverside-red); display: flex; align-items: center; justify-content: center; border-radius: 15px; margin: 0 auto 20px; font-size: 1.5rem; }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="mb-5 text-center">
        <h4 class="fw-bold"><span style="color:var(--riverside-red)">Riverside</span> Café</h4>
        <small class="text-muted">Inventory Management</small>
    </div>
    <nav>
        <a href="<?= base_url('dashboard') ?>" class="nav-link"><i class="fas fa-chart-pie me-2"></i> Overview</a>
        <a href="<?= base_url('products') ?>" class="nav-link active"><i class="fas fa-coffee me-2"></i> Menu & Inventory</a>
        <a href="<?= base_url('pos') ?>" class="nav-link"><i class="fas fa-cash-register me-2"></i> Barista POS</a>
        <a href="<?= base_url('sales') ?>" class="nav-link"><i class="fas fa-chart-line me-2"></i> Sales Analytics</a>
    </nav>
</div>

<div class="main-content">
    <div class="form-card">
        <div class="text-center mb-4">
            <div class="icon-box"><i class="fas fa-plus-circle"></i></div>
            <h3 class="fw-bold m-0 text-dark">Add New Item</h3>
            <p class="text-muted small">Category auto-detection is enabled based on product name.</p>
        </div>

        <form action="<?= base_url('products/store') ?>" method="POST">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">Drink/Product Name</label>
                <input type="text" id="product_name" name="product_name" class="form-control" placeholder="e.g. Spanish Latte, Burger, or Pecho" required autocomplete="off">
            </div>

            <div class="mb-3">
                <label class="form-label">Detected Category</label>
                <div id="category_display" class="category-badge">
                    Waiting for product name...
                </div>
                <input type="hidden" id="category_select" name="category" required>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-6">
                    <label class="form-label">Price (₱)</label>
                    <input type="number" step="0.01" name="price" class="form-control" placeholder="0.00" required>
                </div>
                <div class="col-6">
                    <label class="form-label">Initial Stock</label>
                    <input type="number" name="stock" class="form-control" placeholder="Qty" required>
                </div>
            </div>

            <button type="submit" class="btn btn-save w-100 mb-3">
                <i class="fas fa-save me-2"></i> SAVE PRODUCT
            </button>

            <div class="text-center">
                <a href="<?= base_url('products') ?>" class="text-decoration-none text-muted small">
                    <i class="fas fa-times me-1"></i> Cancel and Go Back
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('product_name').addEventListener('input', function() {
    let name = this.value.toLowerCase().trim();
    let categoryInput = document.getElementById('category_select');
    let categoryDisplay = document.getElementById('category_display');
    let detected = "";

    // 1. Listahan ng mga Categories mo sa DB para sa Random Fallback
    const allCategories = [
        "Coffee", "Refreshments", "Snacks", "Hot Coffee", "Combo Meals", 
        "Burgers", "Sandwiches", "Silog Meals", "Combo Snacks", 
        "Favorites", "Special Menu", "Hot Drinks"
    ];

    // 2. Strict Keyword Detection (Priority)
    if (name.includes('latte') || name.includes('cappuccino') || name.includes('brewed') || name.includes('coffee')) {
        detected = "Coffee";
    } 
    else if (name.includes('milo') || name.includes('milk') || name.includes('3 in 1')) {
        detected = "Hot Drinks";
    }
    else if (name.includes('pecho') || name.includes('chicken') || name.includes('porkchop') || name.includes('combo')) {
        detected = "Combo Meals";
    }
    else if (name.includes('burger')) {
        detected = "Burgers";
    }
    else if (name.includes('sandwich') || name.includes('grilled') || name.includes('hotdog')) {
        detected = "Sandwiches";
    }
    else if (name.includes('silog')) {
        detected = "Silog Meals";
    }
    else if (name.includes('iced') || name.includes('water') || name.includes('lemonade') || name.includes('matcha')) {
        detected = "Refreshments";
    }
    else if (name.includes('cookie') || name.includes('bread') || name.includes('cake')) {
        detected = "Snacks";
    }

    // 3. Logic para sa Random Detection kung walang ma-detect
    if (name.length > 3 && detected === "") {
        // Kapag lumampas sa 3 characters at hindi ma-detect, pipili ng random category
        const randomIndex = Math.floor(Math.random() * allCategories.length);
        detected = allCategories[randomIndex];
    }

    // 4. Update UI
    if(detected !== "") {
        categoryInput.value = detected;
        categoryDisplay.innerText = detected;
        categoryDisplay.classList.add('category-detected');
    } else {
        categoryInput.value = "";
        categoryDisplay.innerText = "Waiting for product name...";
        categoryDisplay.classList.remove('category-detected');
    }
});
</script>

</body>
</html>