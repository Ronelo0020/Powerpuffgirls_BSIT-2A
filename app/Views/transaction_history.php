<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riverside | Transaction History</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root { 
            --accent-gold: #ffcc4d; 
            --riverside-red: #ff4d4d; 
            --bg-black: #000000; 
            --card-dark: #0a0a0a; 
            --text-muted: #888888;
        }

        body { 
            background-color: var(--bg-black); 
            font-family: 'Poppins', sans-serif; 
            color: #e0e0e0; 
            margin: 0;
            display: flex;
        }

        /* Sidebar */
        .sidebar { 
            width: 260px; 
            background: #0a0a0a; 
            padding: 30px 20px; 
            border-right: 1px solid #1a1a1a;
            flex-shrink: 0;
            min-height: 100vh;
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

        .main-content { 
            flex: 1; 
            padding: 40px; 
            min-height: 100vh; 
            max-width: 1300px; 
        }
        
        /* THE VISIBLE BACK BUTTON */
        .back-btn { 
            background: rgba(255, 204, 77, 0.1);
            color: var(--accent-gold); 
            text-decoration: none; 
            padding: 10px 20px;
            border-radius: 12px;
            border: 1px solid var(--accent-gold);
            font-weight: 600;
            font-size: 0.85rem;
            display: inline-flex; 
            align-items: center; 
            margin-bottom: 30px;
            transition: all 0.3s ease;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .back-btn i { transition: transform 0.3s ease; }

        .back-btn:hover { 
            background: var(--riverside-red); 
            color: white; 
            border-color: var(--riverside-red);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 77, 77, 0.3);
        }

        .back-btn:hover i { transform: translateX(-5px); }

        /* Header */
        .history-header { 
            margin-bottom: 40px; 
            border-bottom: 1px solid #1a1a1a; 
            padding-bottom: 20px; 
        }
        .page-title { font-weight: 700; font-size: 2.2rem; color: #fff; }
        .page-title span { color: var(--accent-gold); }
        
        .record-count-box { 
            background: linear-gradient(45deg, #111, #050505);
            border: 1px solid #222;
            padding: 12px 25px; 
            border-radius: 15px; 
            text-align: right;
        }

        /* Table Labels */
        .label-row {
            display: grid;
            grid-template-columns: 0.8fr 1.5fr 3fr 1.2fr 0.8fr;
            padding: 0 30px 15px 30px;
            color: var(--accent-gold);
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        /* Cards */
        .transaction-list { display: flex; flex-direction: column; gap: 12px; }
        
        .transaction-card {
            background: var(--card-dark);
            border: 1px solid #1a1a1a;
            border-radius: 18px;
            padding: 22px 30px;
            display: grid;
            grid-template-columns: 0.8fr 1.5fr 3fr 1.2fr 0.8fr;
            align-items: center;
            transition: all 0.3s ease;
        }
        
        .transaction-card:hover {
            border-color: var(--accent-gold);
            background: #111;
        }

        .order-id { 
            color: var(--accent-gold); 
            font-weight: 700; 
            font-family: 'Courier New', monospace; 
            font-size: 1.1rem; 
            background: rgba(255, 204, 77, 0.1);
            padding: 5px 10px;
            border-radius: 8px;
            display: inline-block;
        }

        .timestamp .date { color: #fff; font-weight: 500; display: block; }
        .timestamp span { font-size: 0.85rem; color: var(--text-muted); }

        .items-list { color: #ddd; font-size: 0.9rem; border-left: 2px solid #222; padding-left: 15px; }

        .amount { font-weight: 800; font-size: 1.3rem; color: #fff; }
        
        .status-pill {
            background: rgba(46, 213, 115, 0.1);
            color: #2ed573;
            border: 1px solid #2ed573;
            border-radius: 30px;
            padding: 6px 12px;
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
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
        <hr class="text-secondary opacity-25 mx-3">
        
        <a href="#" class="nav-link active">
            <i class="fas fa-history me-3"></i> Transaction History
        </a>
    </nav>
</div>

<div class="main-content">
    <!-- VISIBLE RETURN BUTTON -->
    <a href="<?= base_url('dashboard') ?>" class="back-btn">
        <i class="fas fa-arrow-left me-2"></i> Return
    </a>

    <div class="history-header d-flex justify-content-between align-items-end">
        <div>
            <h1 class="page-title"><span>Riverside</span> History</h1>
            <p style="color: var(--text-muted); font-size: 0.9rem;">Logs of all completed café transactions.</p>
        </div>
        <div class="record-count-box">
            <span style="color: var(--accent-gold); font-size: 0.7rem; font-weight: 700; text-transform: uppercase; display: block;">Total Orders</span>
            <span class="fw-bold fs-3 text-white"><?= count($all_orders) ?></span>
        </div>
    </div>

    <div class="label-row">
        <div>Ref</div>
        <div>Timestamp</div>
        <div>Orders Summary</div>
        <div>Total</div>
        <div class="text-center">Status</div>
    </div>

    <div class="transaction-list">
        <?php if(!empty($all_orders)): ?>
            <?php foreach($all_orders as $order): ?>
            <div class="transaction-card">
                <div class="order-id">#<?= sprintf("%03d", $order['id']) ?></div>
                <div class="timestamp">
                    <span class="date"><?= date('M d, Y', strtotime($order['order_date'])) ?></span>
                    <span><i class="far fa-clock me-1"></i> <?= date('h:i A', strtotime($order['order_date'])) ?></span>
                </div>
                <div class="items-list text-truncate">
                    <i class="fas fa-receipt me-2" style="color: #444;"></i>
                    <?= $order['items'] ?: 'General Order' ?>
                </div>
                <div class="amount">₱<?= number_format($order['total_amount'], 2) ?></div>
                <div class="text-center">
                    <span class="status-pill"><i class="fas fa-check-circle me-1"></i> Paid</span>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="text-center p-5 border border-secondary rounded">
                <p class="text-muted">No transaction logs available.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>