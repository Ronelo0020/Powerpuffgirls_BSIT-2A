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
        :root { 
            --accent-gold: #ffcc4d; 
            --riverside-red: #ff4d4d; 
            --bg-black: #000000; 
            --card-dark: #0a0a0a; 
            --sidebar-bg: #0a0a0a; 
            --text-main: #ffffff;
        }

        body { 
            background-color: var(--bg-black); 
            font-family: 'Poppins', sans-serif; 
            display: flex; 
            min-height: 100vh; 
            margin: 0; 
            color: var(--text-main);
        }

        .sidebar { 
            width: 260px; 
            background: var(--sidebar-bg); 
            padding: 30px 20px; 
            border-right: 1px solid #1a1a1a;
            flex-shrink: 0; 
        }
        .nav-link { 
            color: rgba(255,255,255,0.6); 
            padding: 12px 15px; 
            border-radius: 10px; 
            margin-bottom: 5px; 
            transition: 0.3s; 
            text-decoration: none; 
            display: flex; 
            align-items: center; 
            font-size: 0.9rem; 
        }
        .nav-link.active { 
            background: var(--accent-gold); 
            color: #000 !important; 
            font-weight: 600; 
        }

        .main-content { flex: 1; padding: 40px; display: flex; justify-content: center; align-items: flex-start; }
        
        .form-card { 
            background: var(--card-dark); 
            border-radius: 20px; 
            border: 1px solid #222; 
            padding: 40px; 
            width: 100%; 
            max-width: 600px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.5); 
        }

        .form-label { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: var(--accent-gold); margin-bottom: 8px; }
        
        .form-control { 
            background-color: #1a1a1a !important; 
            border: 1px solid #333 !important; 
            border-radius: 12px; 
            padding: 12px 15px; 
            font-size: 0.95rem; 
            color: #ffffff !important; 
        }

        .form-control::placeholder { color: rgba(255, 255, 255, 0.5) !important; }

        .form-control:focus { 
            border-color: var(--accent-gold) !important; 
            box-shadow: none; 
            background-color: #1a1a1a !important; 
            color: #ffffff !important;
        }
        
        .category-badge { 
            background: #111; 
            border: 2px dashed #333; 
            border-radius: 12px; 
            padding: 12px 15px; 
            font-size: 0.95rem; 
            color: #666; 
            transition: 0.3s;
            min-height: 50px;
            display: flex;
            align-items: center;
        }
        .category-detected { 
            border: 2px solid var(--accent-gold); 
            background: rgba(255, 204, 77, 0.1); 
            color: var(--accent-gold); 
            font-weight: 600; 
        }
        
        .btn-save { 
            background: var(--riverside-red); 
            color: white; 
            border: none; 
            padding: 15px; 
            border-radius: 12px; 
            font-weight: 700; 
            transition: 0.3s; 
        }
        .btn-save:hover { background: #e63939; transform: translateY(-2px); color: white; }
        
        .icon-box { 
            width: 60px; 
            height: 60px; 
            background: rgba(255, 77, 77, 0.1); 
            color: var(--riverside-red); 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            border-radius: 15px; 
            margin: 0 auto 20px; 
            font-size: 1.5rem; 
        }

        #preview_container {
            margin-top: 15px;
            text-align: center;
            display: none;
        }
        #image_preview {
            max-width: 150px;
            border-radius: 15px;
            border: 2px solid var(--accent-gold);
            padding: 5px;
        }

        .text-muted { color: #888 !important; }

        /* FLASH MESSAGE STYLING */
        .alert-riverside-success {
            background: rgba(40, 167, 69, 0.1);
            border: 1px solid rgba(40, 167, 69, 0.2);
            color: #28a745;
            border-radius: 12px;
            font-size: 0.9rem;
        }
        .alert-riverside-error {
            background: rgba(220, 53, 69, 0.1);
            border: 1px solid rgba(220, 53, 69, 0.2);
            color: #ff4d4d;
            border-radius: 12px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="mb-5 text-center">
        <h4 class="fw-bold"><span style="color:var(--accent-gold)">Riverside</span> Café</h4>
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
            <div class="icon-box"><i class="fas fa-mug-hot"></i></div>
            <h3 class="fw-bold m-0 text-white">Add New Item</h3>
            <p class="text-muted small">Category auto-detection is enabled based on product name.</p>
        </div>

        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-riverside-success border-0 shadow-sm mb-4 d-flex align-items-center p-3">
                <i class="fas fa-check-circle me-3"></i>
                <div><?= session()->getFlashdata('success') ?></div>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-riverside-error border-0 shadow-sm mb-4 d-flex align-items-center p-3">
                <i class="fas fa-exclamation-circle me-3"></i>
                <div><?= session()->getFlashdata('error') ?></div>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('products/store') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">Drink/Product Name</label>
                <input type="text" id="product_name" name="product_name" class="form-control" placeholder="e.g. Spanish Latte, Burger" required autocomplete="off">
            </div>

            <div class="mb-3">
                <label class="form-label">Detected Category</label>
                <div id="category_display" class="category-badge">
                    Waiting for product name...
                </div>
                <input type="hidden" id="category_select" name="category" required>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-6">
                    <label class="form-label">Price (₱)</label>
                    <input type="number" step="0.01" name="price" class="form-control" placeholder="0.00" required>
                </div>
                <div class="col-6">
                    <label class="form-label">Initial Stock</label>
                    <input type="number" name="stock" class="form-control" placeholder="Qty" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Product Image</label>
                <input type="file" name="product_image" id="product_image" class="form-control" accept="image/*" required onchange="previewFile()">
                
                <div id="preview_container" class="mt-3">
                    <small class="text-muted d-block mb-2">Selected Product Preview:</small>
                    <img src="" id="image_preview" alt="Image Preview" style="max-width: 100%; border-radius: 10px; display: none;">
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
// Image Preview Function
function previewFile() {
    const preview = document.getElementById('image_preview');
    const file = document.getElementById('product_image').files[0];
    const container = document.getElementById('preview_container');
    const reader = new FileReader();

    reader.onloadend = function () {
        preview.src = reader.result;
        preview.style.display = 'block';
        container.style.display = "block";
    }

    if (file) {
        reader.readAsDataURL(file);
    } else {
        preview.src = "";
        container.style.display = "none";
    }
}

const _0xBlocked = "ZndjayxwdXNzeXxwZW5pc3xiaXRjaHxhc3Nob2xlfHRpdGV8cHVraXxiaWxhdHxoZWFkfGZvb3R8YXJtfGxlZ3xoYW5kfGZpbmdlcnxleWV8bm9zZXxtb3V0aHx0b25ndWV8YmFja3xjaGVzdHxza2lufGJvbmV8Ymxvb2R8YnJhaW58aGVhcnR8bGl2ZXJ8bHVuZ3xzaGl0fGRpY2t8bmlycmV8dmlhZ3JhfHNleHxvcmd5fGJvYnN8dmFnaW5hfGFudXN8dGVzdGljbGVzfG9yZ2FzbXxlcmVjdGlvbnxwdWJpY3x0aGlnaHx3cmlzdHxlbGJvd3xrbmVlfHNob3VsZGVyfGZhY2V8bmVjaw==";

document.getElementById('product_name').addEventListener('input', function() {
    let rawWords = this.value.split(' ');
    this.value = rawWords.filter(w => w.length > 0)
        .map(w => w.charAt(0).toUpperCase() + w.slice(1).toLowerCase())
        .join(' ');

    let name = this.value.toLowerCase().trim();
    let categoryInput = document.getElementById('category_select');
    let categoryDisplay = document.getElementById('category_display');
    let btnSave = document.querySelector('.btn-save');
    let detected = "";

    let cleanName = name.replace(/\b\d+(ml|oz|kg|g|ltr|pcs|pc)\b/g, '').trim();

    const forbiddenList = atob(_0xBlocked).split('|');
    if (forbiddenList.some(word => word !== "" && cleanName.includes(word)) && cleanName.length > 0) {
        categoryDisplay.innerText = "⚠️ SYSTEM REJECT: INVALID CONTENT";
        categoryDisplay.classList.remove('category-detected');
        categoryDisplay.style.color = "#ff4d4d";
        btnSave.disabled = true;
        return;
    }

    const priorityMap = [
        { cat: "Combo Meals", keys: ['chicken', 'pork', 'steak', 'liempo', 'inasal', 'sisig', 'bbq', 'meal', 'fried rice'] },
        { cat: "Silog Meals", keys: ['silog', 'tapa', 'longganisa', 'tocino', 'bangus', 'hotsilog'] },
        { cat: "Coffee", keys: ['espresso', 'americano', 'latte', 'cappuccino', 'mocha', 'spanish latte', 'cold brew', 'frappe', 'nescafe', 'kape'] },
        { cat: "Refreshments", keys: ['coke', 'soda', 'milktea', 'juice', 'shake', 'lemonade', 'iced tea'] },
        { cat: "Hot Drinks", keys: ['milo', 'hot chocolate', 'tea', 'herbal', 'bear brand'] },
        { cat: "Special Menu", keys: ['pasta', 'spaghetti', 'carbonara', 'noodles', 'batchoy', 'soup'] },
        { cat: "Sandwiches", keys: ['sandwich', 'clubhouse', 'toast', 'bread'] },
        { cat: "Burgers", keys: ['burger', 'patty'] },
        { cat: "Favorites", keys: ['fries', 'lumpia', 'pizza', 'nachos', 'waffle'] }
    ];

    for (let item of priorityMap) {
        if (item.keys.some(key => cleanName.includes(key))) {
            detected = item.cat;
            break; 
        }
    }

    if (cleanName.length >= 3) {
        if (detected !== "") {
            categoryInput.value = detected;
            categoryDisplay.innerText = "✅ " + detected;
            categoryDisplay.style.color = "#ffcc4d";
            btnSave.disabled = false;
        } else {
            categoryInput.value = "Uncategorized";
            categoryDisplay.innerText = "⚠️ Item not recognized. Please check the name";
            categoryDisplay.style.color = "#ff4d4d";
            btnSave.disabled = true; 
        }
        categoryDisplay.classList.add('category-detected');
    } else {
        categoryDisplay.innerText = "Waiting for product name...";
        categoryDisplay.style.color = "#888";
        categoryDisplay.classList.remove('category-detected');
        categoryInput.value = "";
        btnSave.disabled = true;
    }
});
</script>

</body>
</html>