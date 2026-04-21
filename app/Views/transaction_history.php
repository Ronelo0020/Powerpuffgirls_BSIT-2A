<style>
    /* Dark Theme & Typography */
    body { background-color: #0d0d0d; font-family: 'Poppins', sans-serif; color: #e0e0e0; }
    
    .main-content { padding: 40px; min-height: 100vh; }
    
    /* Back Button Styling */
    .back-btn { 
        color: #888; text-decoration: none; transition: 0.3s; font-size: 0.85rem; 
        display: inline-flex; align-items: center; margin-bottom: 25px;
    }
    .back-btn:hover { color: #ff4d4d; transform: translateX(-5px); }

    /* Header Section */
    .history-header { margin-bottom: 40px; }
    .page-title { font-weight: 700; font-size: 2rem; letter-spacing: -0.5px; }
    .record-count-box { 
        background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1);
        padding: 10px 20px; border-radius: 12px; display: inline-block;
    }

    /* Transaction List Styling */
    .transaction-list { display: flex; flex-direction: column; gap: 15px; }
    
    .transaction-card {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 16px;
        padding: 20px 30px;
        display: grid;
        grid-template-columns: 0.8fr 1.5fr 3fr 1.2fr 0.8fr;
        align-items: center;
        transition: all 0.3s ease;
    }
    
    .transaction-card:hover {
        background: rgba(255, 255, 255, 0.07);
        border-color: rgba(255, 77, 77, 0.3);
        transform: translateY(-2px);
    }

    /* Column Styles */
    .order-id { color: #ffc107; font-weight: 600; font-family: 'Courier New', monospace; font-size: 1.1rem; }
    .timestamp { font-size: 0.85rem; color: #aaa; line-height: 1.4; }
    .items-list { color: #eee; font-size: 0.95rem; padding-right: 20px; }
    .amount { font-weight: 700; font-size: 1.2rem; color: #fff; }
    
    .status-pill {
        border: 1px solid rgba(255, 255, 255, 0.4);
        border-radius: 20px;
        padding: 4px 15px;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        text-align: center;
    }

    /* Column Labels */
    .label-row {
        display: grid;
        grid-template-columns: 0.8fr 1.5fr 3fr 1.2fr 0.8fr;
        padding: 0 30px 15px 30px;
        color: #555;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
</style>

<div class="main-content">
    <a href="<?= base_url('dashboard') ?>" class="back-btn">
        <i class="fas fa-chevron-left me-2"></i> Back to Dashboard
    </a>

    <div class="history-header d-flex justify-content-between align-items-end">
        <div>
            <h1 class="page-title">Transaction History</h1>
            <p class="text-muted mb-0">Reviewing all past activities for Riverside Café</p>
        </div>
        <div class="record-count-box">
            <span class="text-muted small d-block">Total Records</span>
            <span class="fw-bold fs-4 text-white"><?= count($all_orders) ?></span>
        </div>
    </div>

    <div class="label-row">
        <div>ID</div>
        <div>Timestamp</div>
        <div>Items Purchased</div>
        <div>Amount</div>
        <div class="text-center">Status</div>
    </div>

    <div class="transaction-list">
        <?php foreach($all_orders as $order): ?>
        <div class="transaction-card">
            <div class="order-id">#<?= sprintf("%03d", $order['id']) ?></div>
            
            <div class="timestamp">
                <span class="d-block text-white"><?= date('M d, Y', strtotime($order['order_date'])) ?></span>
                <span><?= date('h:i A', strtotime($order['order_date'])) ?></span>
            </div>

            <div class="items-list">
                <?= $order['items'] ?: '<span class="text-muted">No items recorded</span>' ?>
            </div>

            <div class="amount">₱<?= number_format($order['total_amount'], 2) ?></div>

            <div class="text-center">
                <span class="status-pill">Paid</span>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>