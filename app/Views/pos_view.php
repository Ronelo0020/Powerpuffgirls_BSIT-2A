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
        :root { 
            --sidebar-dark: #000000;
            --bg-dark: #121212;
            --card-dark: #1a1a1a;
            --accent-gold: #ffcc4d; 
            --text-main: #ffffff;
            --text-muted: #b3b3b3;
        }
        
        body { background-color: var(--bg-dark); font-family: 'Poppins', sans-serif; display: flex; height: 100vh; overflow: hidden; margin: 0; color: var(--text-main); }
        
        .sidebar { width: 260px; background: var(--sidebar-dark); padding: 30px 20px; display: flex; flex-direction: column; border-right: 1px solid #333; flex-shrink: 0; }
        .nav-link { color: var(--text-muted); padding: 12px 15px; border-radius: 10px; margin-bottom: 5px; transition: 0.3s; text-decoration: none; display: flex; align-items: center; font-size: 0.9rem; }
        .nav-link:hover { color: white; background: rgba(255,255,255,0.05); }
        .nav-link.active { background: var(--accent-gold); color: black; font-weight: 600; }

        .main-content { flex: 1; display: flex; flex-direction: column; padding: 25px; overflow: hidden; }
        .section-label { color: var(--accent-gold); font-size: 0.75rem; letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 15px; display: block; font-weight: 600; }

        .search-container { position: relative; margin-bottom: 25px; }
        .search-input { background: var(--card-dark); border: 1px solid #333; color: white !important; padding: 12px 20px 12px 50px; border-radius: 15px; width: 100%; outline: none; }
        .search-icon { position: absolute; left: 20px; top: 50%; transform: translateY(-50%); color: var(--accent-gold); }

        .product-grid { overflow-y: auto; flex: 1; padding-right: 5px; }
        .product-card { background: var(--card-dark); border-radius: 20px; border: 1px solid #333; overflow: hidden; transition: 0.3s; cursor: pointer; height: 100%; display: flex; flex-direction: column; }
        .product-card:hover { transform: translateY(-5px); border-color: var(--accent-gold); }
        .img-wrapper { height: 150px; background: #252525; overflow: hidden; display: flex; align-items: center; justify-content: center; border-bottom: 1px solid #333; }
        .product-img { width: 100%; height: 100%; object-fit: cover; }

        .order-panel { width: 400px; background: var(--sidebar-dark); border-left: 1px solid #333; display: flex; flex-direction: column; padding: 25px; }
        .cart-container { flex: 1; overflow-y: auto; margin-bottom: 15px; min-height: 150px; }
        .cart-item { background: #1a1a1a; border-radius: 12px; padding: 12px; margin-bottom: 10px; display: flex; justify-content: space-between; align-items: center; border: 1px solid #333; border-left: 4px solid var(--accent-gold); color: white; }

        .btn-checkout { background: var(--accent-gold); color: black; border: none; padding: 15px; border-radius: 12px; font-weight: 700; width: 100%; transition: 0.3s; }
        .btn-checkout:hover { background: #e6b800; transform: scale(1.02); }

        .form-control { background-color: #1a1a1a !important; border: 1px solid #333 !important; color: white !important; }
        .form-control::placeholder { color: #666; }

        #printableReceipt { background: #fff; padding: 10px; font-family: 'Courier New', Courier, monospace; font-size: 13px; color: #000; }
        .receipt-header h5 { letter-spacing: 2px; margin-bottom: 2px; }
        .receipt-dashed { border-top: 1px dashed #000; margin: 8px 0; }
        .receipt-item-row { margin-bottom: 3px; display: flex; justify-content: space-between; }
        
        @media print {
            body * { visibility: hidden; }
            #receiptModal, #receiptModal * { visibility: visible; }
            #printableReceipt { position: absolute; left: 0; top: 0; width: 100%; }
            .modal-footer, .btn-close { display: none !important; }
        }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="mb-5 px-3 text-center">
        <h4 class="fw-bold mb-0">
            <span style="color: var(--accent-gold);">Riverside</span> <span style="color: white;">Café</span>
        </h4>
        
        <?php if (session()->get('role') === 'admin'): ?>
            <small class="text-white d-block" style="opacity: 0.6; font-size: 0.75rem; letter-spacing: 1px;">ADMIN TERMINAL</small>
        <?php else: ?>
            <small class="text-white d-block" style="opacity: 0.6; font-size: 0.75rem; letter-spacing: 1px;">STAFF TERMINAL</small>
        <?php endif; ?>
    </div>

    <nav class="d-flex flex-column h-100">
        <a href="<?= base_url('dashboard') ?>" class="nav-link <?= (uri_string() == 'dashboard') ? 'active' : '' ?>">
            <i class="fas fa-th-large me-3"></i> Overview
        </a>
        <a href="<?= base_url('products') ?>" class="nav-link <?= (uri_string() == 'products') ? 'active' : '' ?>">
            <i class="fas fa-box me-3"></i> Menu & Inventory
        </a>
        <a href="<?= base_url('pos') ?>" class="nav-link <?= (uri_string() == 'pos') ? 'active' : '' ?>">
            <i class="fas fa-cash-register me-3"></i> Barista POS
        </a>

        <?php if(session()->get('role') == 'admin'): ?>
            <hr class="text-secondary opacity-25 mx-3">
            <a href="<?= base_url('sales') ?>" class="nav-link <?= (uri_string() == 'sales') ? 'active' : '' ?>">
                <i class="fas fa-chart-line me-3"></i> Sales Reports
            </a>
            <a href="<?= base_url('auth/manage') ?>" class="nav-link <?= (uri_string() == 'auth/manage') ? 'active' : '' ?>">
                <i class="fas fa-users me-3"></i> Manage Staff
            </a>
        <?php endif; ?>
    </nav>
</div>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0 text-white">Punch Order</h2>
            <p style="color: var(--text-muted);" class="small mb-0">Select items to add to tray</p>
        </div>
        <div class="text-end">
            <span class="badge bg-dark text-white border border-secondary p-2 px-3 shadow-sm rounded-pill">
                <i class="fas fa-clock me-2 text-warning"></i> <?= date('h:i A') ?>
            </span>
        </div>
    </div>

    <div class="search-container">
        <i class="fas fa-search search-icon"></i>
        <input type="text" id="searchInput" class="search-input" placeholder="Search menu..." onkeyup="filterProducts()">
    </div>

    <span class="section-label">Available Menu</span>
    <div class="product-grid">
        <div class="row g-3" id="productContainer">
            <?php if(!empty($products)): foreach($products as $p): ?>
            <div class="col-6 col-md-4 col-lg-3 product-card-item" data-name="<?= strtolower($p['product_name']) ?>">
                <div class="product-card shadow-sm" onclick="addToCart('<?= $p['id'] ?>', '<?= addslashes($p['product_name']) ?>', <?= $p['price'] ?>)">
                    <div class="img-wrapper">
                       <img src="<?= base_url('assets/img/products/'.$p['image']) ?>" 
     class="product-img" 
     onerror="console.log('Failed to load: <?= base_url('assets/img/products/') ?>' + '<?= $p['image'] ?>'); this.src='<?= base_url('assets/img/no-image.png') ?>';">
                    </div>
                    <div class="p-3 text-center">
                        <h6 class="fw-bold text-white mb-1" style="font-size: 0.85rem;"><?= $p['product_name'] ?></h6>
                        <p class="text-warning fw-bold small mb-0">₱<?= number_format($p['price'], 2) ?></p>
                        <small style="color: var(--text-muted); font-size: 0.65rem;">Stock: <?= $p['stock'] ?></small>
                    </div>
                </div>
            </div>
            <?php endforeach; endif; ?>
        </div>
    </div>
</div>

<div class="order-panel">
    <h5 class="fw-bold mb-4 border-bottom border-secondary pb-3 text-white"><i class="fas fa-shopping-basket me-2 text-warning"></i> Current Order</h5>
    <div id="cart-items" class="cart-container text-center py-5">
        <i class="fas fa-receipt fa-3x text-secondary mb-3" style="opacity: 0.3;"></i>
        <p class="text-muted">Tray is empty.</p>
    </div>

    <div class="payment-section border-top border-secondary pt-3">
        <label class="section-label mb-2" style="font-size: 0.65rem;">Payment Method</label>
        <div class="row g-2 mb-3">
            <div class="col-6">
                <input type="radio" class="btn-check" name="payment_method" id="pay_cash" value="Cash" checked>
                <label class="btn btn-outline-secondary w-100 py-2 rounded-3 text-white" for="pay_cash">Cash</label>
            </div>
            <div class="col-6">
                <input type="radio" class="btn-check" name="payment_method" id="pay_gcash" value="GCash">
                <label class="btn btn-outline-primary w-100 py-2 rounded-3 text-white" for="pay_gcash">GCash</label>
            </div>
        </div>

        <div id="cash-input-group">
            <label class="small fw-bold text-white mb-1">AMOUNT TENDERED</label>
            <input type="number" id="cash-amount" class="form-control mb-2" placeholder="₱ 0.00">
            <div class="d-flex justify-content-between">
                <small style="color: var(--text-muted);">Change:</small>
                <small id="change-amount" class="fw-bold text-success">₱ 0.00</small>
            </div>
        </div>

        <div id="gcash-input-group" style="display: none;">
            <label class="small fw-bold text-white mb-1">REFERENCE NO.</label>
            <input type="text" id="gcash-reference" class="form-control mb-2" maxlength="13" placeholder="Reference Number">
            <label class="small fw-bold text-white mb-1">UPLOAD PROOF</label>
            <input type="file" id="gcash-ss" class="form-control form-control-sm mb-2" accept="image/*">
        </div>

        <div class="order-footer mt-4 pt-3 border-top border-secondary">
            <div class="d-flex justify-content-between mb-3">
                <span class="h5 fw-bold text-white">Total</span>
                <span id="total-price" class="h5 fw-bold text-warning">₱ 0.00</span>
            </div>
            <button class="btn-checkout" onclick="checkout()">COMPLETE ORDER</button>
        </div>
    </div>
</div>

<div class="modal fade" id="gcashModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content bg-dark text-center p-4 border-secondary" style="border-radius: 20px;">
            <h6 class="fw-bold mb-3 text-white">Scan GCash QR</h6>
            <img src="<?= base_url('assets/img/payments/gcash_qr.jpg') ?>" class="img-fluid rounded mb-3 border border-secondary" onerror="this.src='https://placehold.co/300x400?text=GCash+QR+Code'">
            <button type="button" class="btn btn-warning w-100 rounded-pill" data-bs-dismiss="modal">Proceed to Details</button>
        </div>
    </div>
</div>

<div class="modal fade" id="receiptModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 15px; overflow: hidden;">
            <div class="modal-body p-4" id="printableReceipt">
                <div class="text-center receipt-header">
                    <h5 class="fw-bold mb-0">RIVERSIDE CAFÉ</h5>
                    <p class="small mb-0" style="font-size: 10px;">KABANKALAN CITY, NEGROS OCC.</p>
                    <p class="small mb-0" style="font-size: 10px;" id="receiptDateText"></p>
                </div>
                <div class="receipt-dashed"></div>
                <div id="receiptItemsList"></div>
                <div class="receipt-dashed"></div>
                <div class="receipt-item-row"><span>Subtotal</span><span id="receiptSubtotalText">₱0.00</span></div>
                <div class="receipt-item-row fw-bold" style="font-size: 16px;"><span>TOTAL</span><span id="receiptTotalText">₱0.00</span></div>
                <div class="receipt-dashed"></div>
                <div class="receipt-item-row"><span class="receipt-label">Tendered</span><span id="receiptPaymentText">₱0.00</span></div>
                <div class="receipt-item-row"><span class="receipt-label">Change</span><span id="receiptChangeText" class="fw-bold">₱0.00</span></div>
                <div class="text-center mt-4">
                    <p class="small mb-1 fw-bold">ORDER ID: <span id="receiptOrderIDText"></span></p>
                    <p class="mb-0" style="font-size: 9px;">THANK YOU! COME AGAIN</p>
                </div>
            </div>
           <div class="modal-footer border-0 p-3 bg-light">
   <div class="row w-100 g-2 mt-2">
    <div class="col-12">
        <button type="button" class="btn btn-outline-dark btn-sm w-100 py-2" onclick="resetPOS()">NEW ORDER</button>
    </div>
    <div class="col-12">
        <button type="button" class="btn btn-warning btn-sm w-100 py-2" onclick="printReceipt()">PRINT RECEIPT</button>
    </div>
</div>
</div>
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
            cartDiv.innerHTML = '<i class="fas fa-receipt fa-3x text-secondary mb-3" style="opacity: 0.3;"></i><p class="text-muted">Tray is empty.</p>';
            totalDisplay.innerText = "₱ 0.00"; return;
        }
        let html = ''; let total = 0;
        cart.forEach((item, index) => {
            total += (item.price * item.qty);
            html += `<div class="cart-item text-start"><div><div class="fw-bold small">${item.name}</div><div class="text-warning small">₱${item.price} x ${item.qty}</div></div><button class="btn btn-sm text-danger" onclick="removeFromCart(${index})"><i class="fas fa-trash"></i></button></div>`;
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
            if (!isCash) {
                new bootstrap.Modal(document.getElementById('gcashModal')).show();
            }
        });
    });
async function checkout() {
    if (cart.length === 0) return alert("Select products first.");
    
    const method = document.querySelector('input[name="payment_method"]:checked').value;
    const total = cart.reduce((s, i) => s + (i.price * i.qty), 0);
    
    let formData = new FormData();
    formData.append('items', JSON.stringify(cart));
    formData.append('total_amount', total);
    formData.append('payment_method', method);

    let payValue = 0;

    if (method === 'Cash') {
        const tendered = parseFloat(document.getElementById('cash-amount').value) || 0;
        if (tendered < total) return alert("Insufficient cash!");
        
        payValue = tendered;
        formData.append('payment', tendered);
        formData.append('change_amount', tendered - total);
    } else {
        // GCash Logic
        const refNo = document.getElementById('gcash-reference').value;
        const fileInput = document.getElementById('gcash-ss');
        
        if (!refNo) return alert("Please enter GCash Reference Number.");
        
        payValue = total; // Sa GCash, saktong total ang bayad
        formData.append('payment', total);
        formData.append('change_amount', 0);
        formData.append('gcash_reference', refNo);
    
        if (fileInput.files.length > 0) {
            formData.append('payment_screenshot', fileInput.files[0]);
        }
    }

    try {
        const res = await fetch('<?= base_url("pos/save_order") ?>', { 
            method: 'POST', 
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        const data = await res.json();
        
        if (data.status === 'success') {
            // I-populate ang Receipt Modal
            document.getElementById('receiptDateText').innerText = new Date().toLocaleString();
            document.getElementById('receiptOrderIDText').innerText = data.order_id;
            document.getElementById('receiptTotalText').innerText = "₱" + total.toFixed(2);
            document.getElementById('receiptSubtotalText').innerText = "₱" + total.toFixed(2);
            document.getElementById('receiptPaymentText').innerText = "₱" + payValue.toFixed(2);
            document.getElementById('receiptChangeText').innerText = "₱" + (payValue - total).toFixed(2);

            let itemsHtml = '';
            cart.forEach(item => {
                itemsHtml += `<div class="receipt-item-row"><span>${item.qty} x ${item.name}</span><span>₱${(item.price * item.qty).toFixed(2)}</span></div>`;
            });
            document.getElementById('receiptItemsList').innerHTML = itemsHtml;
            
            // Ipakita ang Receipt
            new bootstrap.Modal(document.getElementById('receiptModal')).show();
        } else { 
            alert(data.message); 
        }
    } catch (e) { 
        console.error(e);
        alert("Error saving order. Check console."); 
    }
}
function resetPOS() {
    console.log("New Order trigger!");
    
    try {
        // 1. Linisin ang cart
        cart = [];
        
        // 2. I-update ang UI Sidebar
        if (typeof updateCartUI === "function") {
            updateCartUI();
        }

        // 3. Isara ang Modal
        const modalEl = document.getElementById('receiptModal');
        if (modalEl) {
            const modalInstance = bootstrap.Modal.getInstance(modalEl);
            if (modalInstance) {
                modalInstance.hide();
            }
        }

        // 4. Force Reload para sa panibagong Order ID at malinis na inputs
        // Ito ang pinakasiguradong paraan para mag-reset ang POS
        setTimeout(() => {
            window.location.reload();
        }, 100);

    } catch (err) {
        console.error("Reset Error:", err);
        window.location.reload();
    }
}
  function printReceipt() {
    const receiptData = {
        date: document.getElementById('receiptDateText').innerText,
        orderId: document.getElementById('receiptOrderIDText').innerText,
        items: document.getElementById('receiptItemsList').innerHTML,
        total: document.getElementById('receiptTotalText').innerText,
        tendered: document.getElementById('receiptPaymentText').innerText,
        change: document.getElementById('receiptChangeText').innerText
    };

    const virtualPrinter = window.open('', '_blank', 'height=800,width=500');

    virtualPrinter.document.write(`
        <html>
            <head>
                <title>Riverside Café - Official Receipt</title>
                <style>
                    body { 
                        background-color: #333; 
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        padding: 40px 20px;
                        font-family: 'Courier New', Courier, monospace;
                        margin: 0;
                    }
                    .paper {
                        background: white;
                        width: 380px;
                        padding: 40px 30px;
                        box-shadow: 0 10px 30px rgba(0,0,0,0.5);
                        color: black;
                        position: relative;
                    }
                    /* Improvement: Logo Placeholder */
                    .logo-container { text-align: center; margin-bottom: 10px; }
                    .logo-placeholder { 
                        font-size: 40px; 
                        font-weight: bold; 
                        border: 3px solid black; 
                        display: inline-block; 
                        padding: 5px 15px;
                        margin-bottom: 10px;
                    }
                    
                    .text-center { text-align: center; }
                    .dashed { border-top: 2px dashed #000; margin: 15px 0; }
                    .row { display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 16px; }
                    .total-row { font-size: 24px; font-weight: bold; margin-top: 10px; border-top: 1px solid black; padding-top: 10px; }
                    
                    .header h2 { margin: 0; font-size: 26px; text-transform: uppercase; letter-spacing: 2px; }
                    .header p { margin: 3px 0; font-size: 13px; color: #333; }
                    
                    .items-table { width: 100%; margin: 20px 0; }
                    
                    .no-print { 
                        margin-bottom: 20px;
                        padding: 12px 25px; 
                        background: #ffc107; 
                        border: none; 
                        cursor: pointer; 
                        font-weight: bold; 
                        border-radius: 50px;
                        box-shadow: 0 4px 10px rgba(0,0,0,0.3);
                        font-family: sans-serif;
                    }
                    .no-print:hover { background: #e0a800; }

                    @media print {
                        .no-print { display: none; }
                        body { background: white; padding: 0; }
                        .paper { box-shadow: none; width: 100%; padding: 10px; }
                    }
                </style>
            </head>
            <body>
                <button class="no-print" onclick="window.print()">🖨️ PRINT ACTUAL RECEIPT</button>
                
                <div class="paper">
                    <div class="logo-container">
                        <div class="logo-placeholder">RC</div>
                    </div>
                    
                    <div class="text-center header">
                        <h2>RIVERSIDE CAFÉ</h2>
                        <p>Burgos Street, Brgy. 8, Kabankalan City</p>
                        <p>Negros Occidental, Philippines</p>
                        <p style="margin-top:10px; font-weight:bold;">${receiptData.date}</p>
                    </div>

                    <div class="dashed"></div>
                    
                    <div class="items">
                        ${receiptData.items}
                    </div>

                    <div class="dashed"></div>

                    <div class="row"><span>Subtotal</span><span>${receiptData.total}</span></div>
                    <div class="row total-row">
                        <span>TOTAL</span>
                        <span>${receiptData.total}</span>
                    </div>

                    <div class="dashed"></div>

                    <div class="row"><span>Cash Tendered:</span><span>${receiptData.tendered}</span></div>
                    <div class="row"><span>Change Due:</span><span>${receiptData.change}</span></div>

                    <div class="dashed"></div>

                    <div class="text-center" style="margin-top: 30px;">
                        <p style="font-size: 18px; font-weight: bold; margin-bottom: 5px;">ORDER ID: #${receiptData.orderId}</p>
                        <p style="font-size: 12px;">Visit us: facebook.com/RiversidecafeKabankalan</p>
                        <p style="font-size: 14px; margin-top: 15px; font-style: italic;">THANK YOU! COME AGAIN</p>
                    </div>
                </div>
            </body>
        </html>
    `);

    virtualPrinter.document.close();
}
</script>
</body>
</html>