<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riverside | Barista POS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        :root { --riverside-red: #ff4d4d; --sidebar-bg: #212529; --body-bg: #f4f7f6; }
        body { background-color: var(--body-bg); font-family: 'Poppins', sans-serif; display: flex; height: 100vh; overflow: hidden; margin: 0; }
        
        /* Sidebar */
        .sidebar { width: 260px; background: var(--sidebar-bg); padding: 30px 20px; display: flex; flex-direction: column; color: white; flex-shrink: 0; }
        .nav-link { color: rgba(255,255,255,0.7); padding: 12px 15px; border-radius: 10px; margin-bottom: 5px; transition: 0.3s; text-decoration: none; display: flex; align-items: center; font-size: 0.9rem; }
        .nav-link.active { background: rgba(255,255,255,0.1); color: var(--riverside-red); }

        /* Main Content */
        .main-content { flex: 1; display: flex; flex-direction: column; padding: 25px; overflow: hidden; }
        
        /* Search Bar */
        .search-container { position: relative; margin-bottom: 20px; }
        .search-input { padding: 12px 20px 12px 45px; border-radius: 15px; border: 1px solid #ddd; width: 100%; box-shadow: 0 4px 10px rgba(0,0,0,0.03); outline: none; }
        .search-icon { position: absolute; left: 18px; top: 50%; transform: translateY(-50%); color: #aaa; }

        /* Product Grid */
        .product-grid { overflow-y: auto; flex: 1; padding-right: 5px; }
        .product-card { 
            background: white; border-radius: 20px; border: 1px solid #eee; overflow: hidden; 
            transition: 0.3s; cursor: pointer; height: 100%; display: flex; flex-direction: column; 
        }
        .product-card:hover { transform: translateY(-5px); border-color: var(--riverside-red); box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
        .img-wrapper { height: 130px; background: #f9f9f9; overflow: hidden; display: flex; align-items: center; justify-content: center; }
        .product-img { width: 100%; height: 100%; object-fit: cover; }

        /* Order Panel */
        .order-panel { width: 400px; background: white; border-left: 1px solid #dee2e6; display: flex; flex-direction: column; padding: 25px; }
        .cart-container { flex: 1; overflow-y: auto; margin-bottom: 15px; min-height: 150px; }
        .cart-item { background: #f8f9fa; border-radius: 12px; padding: 12px; margin-bottom: 10px; display: flex; justify-content: space-between; align-items: center; border: 1px solid #f0f0f0; }

        .btn-check:checked + .btn-outline-danger { background-color: var(--riverside-red); color: white; }
        .btn-checkout { background: var(--riverside-red); color: white; border: none; padding: 15px; border-radius: 12px; font-weight: 700; width: 100%; transition: 0.3s; box-shadow: 0 10px 20px rgba(255, 77, 77, 0.2); }
        
        .qr-container { background: #f8f9fa; border-radius: 15px; padding: 15px; border: 2px dashed #007bff; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-thumb { background: #eee; border-radius: 10px; }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="mb-5 text-center">
        <h4 class="fw-bold"><span style="color:var(--riverside-red)">Riverside</span> Café</h4>
        <small class="text-muted text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Barista Terminal</small>
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
    <a href="<?= base_url('sales') ?>" class="nav-link <?= (uri_string() == 'sales') ? 'active' : '' ?>">
        <i class="fas fa-file-invoice-dollar me-3"></i> Sales Reports
    </a>

    <?php if(session()->get('role') == 'admin'): ?>
        <hr class="text-secondary opacity-25 mx-3">
        <p class="small text-muted px-3 mb-2" style="font-size: 0.65rem; letter-spacing: 1px;">ADMINISTRATION</p>
        <a href="<?= base_url('auth/manage') ?>" class="nav-link <?= (uri_string() == 'auth/manage') ? 'active' : '' ?>">
            <i class="fas fa-users-cog me-3"></i> Manage Staff
        </a>
    <?php endif; ?>

    <div class="mt-auto">
        <hr class="text-secondary opacity-25 mx-3">
        <a href="<?= base_url('logout') ?>" class="nav-link text-danger">
            <i class="fas fa-sign-out-alt me-3"></i> Logout
        </a>
    </div>
</nav>
</div>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">Punch Order</h2>
            <p class="text-muted small mb-0">Select items to add to tray</p>
        </div>
        <div class="text-end">
            <span class="badge bg-white text-dark border p-2 px-3 shadow-sm rounded-pill">
                <i class="fas fa-clock me-2 text-danger"></i> <?= date('h:i A') ?>
            </span>
        </div>
    </div>

    <div class="search-container">
        <i class="fas fa-search search-icon"></i>
        <input type="text" id="searchInput" class="search-input" placeholder="Search menu..." onkeyup="filterProducts()">
    </div>

    <div class="product-grid">
        <div class="row g-3" id="productContainer">
            <?php if(!empty($products)): foreach($products as $p): ?>
            <div class="col-6 col-md-4 col-lg-3 product-card-item" data-name="<?= strtolower($p['product_name']) ?>">
                <div class="product-card shadow-sm" onclick="addToCart('<?= $p['id'] ?>', '<?= addslashes($p['product_name']) ?>', <?= $p['price'] ?>)">
                    <div class="img-wrapper">
                        <?php if(!empty($p['image'])): ?>
                            <img src="<?= base_url('assets/img/products/'.$p['image']) ?>" class="product-img">
                        <?php else: ?>
                            <i class="fas fa-mug-hot text-light fa-3x"></i>
                        <?php endif; ?>
                    </div>
                    <div class="p-3 text-center">
                        <h6 class="fw-bold text-dark mb-1" style="font-size: 0.85rem;"><?= $p['product_name'] ?></h6>
                        <p class="text-danger fw-bold small mb-0">₱<?= number_format($p['price'], 2) ?></p>
                        <small class="text-muted" style="font-size: 0.65rem;">Stock: <?= $p['stock'] ?></small>
                    </div>
                </div>
            </div>
            <?php endforeach; endif; ?>
        </div>
    </div>
</div>

<div class="order-panel">
    <h5 class="fw-bold mb-4 border-bottom pb-3"><i class="fas fa-shopping-basket me-2 text-danger"></i> Current Order</h5>
    
    <div id="cart-items" class="cart-container text-center py-5">
        <i class="fas fa-receipt fa-3x text-light mb-3"></i>
        <p class="text-muted">Tray is empty.</p>
    </div>

    <div class="payment-section border-top pt-3">
        <label class="form-label small fw-bold text-muted mb-2">PAYMENT METHOD</label>
        <div class="row g-2 mb-3">
            <div class="col-6">
                <input type="radio" class="btn-check" name="payment_method" id="pay_cash" value="Cash" checked>
                <label class="btn btn-outline-danger w-100 py-2 rounded-3" for="pay_cash">Cash</label>
            </div>
            <div class="col-6">
                <input type="radio" class="btn-check" name="payment_method" id="pay_gcash" value="GCash">
                <label class="btn btn-outline-primary w-100 py-2 rounded-3" for="pay_gcash">GCash</label>
            </div>
        </div>

        <div id="cash-input-group">
            <label class="form-label small fw-bold text-muted">AMOUNT TENDERED</label>
            <input type="number" id="cash-amount" class="form-control mb-2" placeholder="₱ 0.00">
            <div class="d-flex justify-content-between">
                <small class="text-muted">Change:</small>
                <small id="change-amount" class="fw-bold text-success">₱ 0.00</small>
            </div>
        </div>

        <div id="gcash-input-group" style="display: none;">
            <label class="form-label small fw-bold text-muted">GCASH REFERENCE (13-digit)</label>
            <input type="text" id="gcash-reference" class="form-control mb-2" maxlength="13" placeholder="Reference No.">
            
            <label class="form-label small fw-bold text-muted">RECEIPT SCREENSHOT</label>
            <input type="file" id="gcash-ss" class="form-control form-control-sm" accept="image/*">
        </div>

        <div class="order-footer mt-4 pt-3 border-top">
            <div class="d-flex justify-content-between mb-3">
                <span class="h5 fw-bold">Total</span>
                <span id="total-price" class="h5 fw-bold text-danger">₱ 0.00</span>
            </div>
            <button class="btn-checkout" onclick="checkout()">COMPLETE ORDER</button>
        </div>
    </div>
</div>

<div class="modal fade" id="gcashModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content text-center p-4" style="border-radius: 20px;">
            <h6 class="fw-bold mb-3">Scan to Pay</h6>
            <div class="qr-container mb-3">
                <img src="<?= base_url('assets/img/gcash_qr.jpg') ?>" class="img-fluid rounded shadow-sm">
            </div>
            <p class="fw-bold mb-0 text-primary">RO***O D.</p>
            <button type="button" class="btn btn-dark w-100 mt-4 rounded-pill" data-bs-dismiss="modal">Proceed</button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    let cart = [];

    function filterProducts() {
        let input = document.getElementById('searchInput').value.toLowerCase();
        let items = document.getElementsByClassName('product-card-item');
        for (let i = 0; i < items.length; i++) {
            items[i].style.display = items[i].getAttribute('data-name').includes(input) ? "" : "none";
        }
    }

    function addToCart(id, name, price) {
        const item = cart.find(i => i.id === id);
        if (item) item.qty++; else cart.push({ id, name, price, qty: 1 });
        updateCartUI();
    }

    function updateCartUI() {
        const cartDiv = document.getElementById('cart-items');
        const totalDisplay = document.getElementById('total-price');
        if (cart.length === 0) {
            cartDiv.innerHTML = '<i class="fas fa-receipt fa-3x text-light mb-3"></i><p class="text-muted">Tray is empty.</p>';
            totalDisplay.innerText = "₱ 0.00"; return;
        }
        let html = ''; let total = 0;
        cart.forEach((item, index) => {
            total += (item.price * item.qty);
            html += `<div class="cart-item text-start"><div><div class="fw-bold small">${item.name}</div><div class="text-danger small">₱${item.price} x ${item.qty}</div></div><button class="btn btn-sm text-danger" onclick="removeFromCart(${index})"><i class="fas fa-trash"></i></button></div>`;
        });
        cartDiv.innerHTML = html;
        totalDisplay.innerText = "₱ " + total.toLocaleString(undefined, {minimumFractionDigits: 2});
        calculateChange();
    }

    function removeFromCart(i) {
        if (cart[i].qty > 1) cart[i].qty--; else cart.splice(i, 1);
        updateCartUI();
    }

    function calculateChange() {
        const total = cart.reduce((s, i) => s + (i.price * i.qty), 0);
        const tendered = parseFloat(document.getElementById('cash-amount').value) || 0;
        const change = tendered - total;
        document.getElementById('change-amount').innerText = "₱ " + (change >= 0 ? change.toFixed(2) : "0.00");
    }

    document.getElementById('cash-amount').addEventListener('input', calculateChange);

    document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const isCash = this.value === 'Cash';
            document.getElementById('cash-input-group').style.display = isCash ? 'block' : 'none';
            document.getElementById('gcash-input-group').style.display = isCash ? 'none' : 'block';
            if (!isCash) new bootstrap.Modal(document.getElementById('gcashModal')).show();
        });
    });

    async function checkout() {
        if (cart.length === 0) return alert("Pili anay kape.");
        
        const method = document.querySelector('input[name="payment_method"]:checked').value;
        const gcashRef = document.getElementById('gcash-reference').value.trim();
        const gcashSS = document.getElementById('gcash-ss').files[0];
        const total = cart.reduce((s, i) => s + (i.price * i.qty), 0);
        
        if (method === 'GCash') {
            if (gcashRef.length < 13) return alert("Input exact 13-digit Reference!");
            if (!gcashSS) return alert("Upload screenshot!");
        }

        let formData = new FormData();
        formData.append('items', JSON.stringify(cart));
        formData.append('total_amount', total);
        formData.append('payment_method', method);
        formData.append('gcash_reference', gcashRef);
        if (gcashSS) formData.append('payment_screenshot', gcashSS);

        try {
            const res = await fetch('<?= base_url("pos/save_order") ?>', {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            const data = await res.json();
            if (data.status === 'success') { alert("Order Saved!"); window.location.reload(); } 
            else alert(data.message);
        } catch (e) { alert("Error connecting to server."); }
    }
</script>
</body>
</html>