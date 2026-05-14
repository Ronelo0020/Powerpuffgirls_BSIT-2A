<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riverside | Transaction History</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --gold: #ffcc4d;
            --gold-dim: rgba(255, 204, 77, 0.12);
            --gold-border: rgba(255, 204, 77, 0.25);
            --red: #e02020;
            --red-glow: rgba(224, 32, 32, 0.3);
            --bg: #060605;
            --surface: #0d0d0b;
            --surface-2: #131310;
            --border: rgba(255,255,255,0.07);
            --border-hover: rgba(255, 204, 77, 0.35);
            --text: #e8e4dc;
            --text-muted: rgba(255,255,255,0.35);
            --green: #2ed573;
            --green-dim: rgba(46, 213, 115, 0.1);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background-color: var(--bg);
            font-family: 'DM Sans', sans-serif;
            color: var(--text);
            display: flex;
            min-height: 100vh;
        }

        /* ═══════════════════════════════
           SIDEBAR
        ═══════════════════════════════ */
        .sidebar {
            width: 250px;
            background: var(--surface);
            border-right: 1px solid var(--border);
            padding: 28px 16px;
            flex-shrink: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            position: sticky;
            top: 0;
            height: 100vh;
        }

        .sidebar-brand {
            text-align: center;
            padding: 0 10px 24px;
            border-bottom: 1px solid var(--border);
            margin-bottom: 24px;
        }

        .sidebar-logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            font-weight: 900;
            letter-spacing: -0.5px;
            line-height: 1.1;
        }

        .sidebar-logo .r { color: var(--gold); }
        .sidebar-logo .c { color: #fff; }

        .sidebar-role {
            display: inline-block;
            margin-top: 8px;
            font-size: 0.6rem;
            font-weight: 700;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            color: var(--text-muted);
            background: rgba(255,255,255,0.05);
            border: 1px solid var(--border);
            padding: 3px 10px;
            border-radius: 20px;
        }

        .nav-link {
            color: rgba(255,255,255,0.5);
            padding: 11px 14px;
            border-radius: 10px;
            margin-bottom: 4px;
            transition: all 0.2s;
            text-decoration: none;
            display: flex;
            align-items: center;
            font-size: 0.85rem;
            font-weight: 500;
            gap: 12px;
        }

        .nav-link i {
            width: 18px;
            text-align: center;
            font-size: 0.9rem;
        }

        .nav-link:hover {
            background: rgba(255,255,255,0.05);
            color: rgba(255,255,255,0.8);
        }

        .nav-link.active {
            background: var(--gold-dim);
            color: var(--gold);
            font-weight: 600;
            border: 1px solid var(--gold-border);
        }

        .sidebar-footer {
            margin-top: auto;
            padding-top: 20px;
            border-top: 1px solid var(--border);
            font-size: 0.7rem;
            color: var(--text-muted);
            text-align: center;
        }

        /* ═══════════════════════════════
           MAIN CONTENT
        ═══════════════════════════════ */
        .main-content {
            flex: 1;
            padding: 36px 44px;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ── Back Button ── */
        .back-btn {
            background: transparent;
            color: rgba(255,255,255,0.45);
            text-decoration: none;
            padding: 8px 16px 8px 12px;
            border-radius: 9px;
            border: 1px solid var(--border);
            font-weight: 500;
            font-size: 0.8rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 32px;
            transition: all 0.2s;
            letter-spacing: 0.5px;
        }

        .back-btn:hover {
            background: rgba(255,255,255,0.05);
            color: #fff;
            border-color: rgba(255,255,255,0.2);
        }

        .back-btn i { transition: transform 0.2s; font-size: 0.75rem; }
        .back-btn:hover i { transform: translateX(-3px); }

        /* ── Page Header ── */
        .history-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 32px;
            padding-bottom: 24px;
            border-bottom: 1px solid var(--border);
        }

        .page-title {
            font-family: 'Playfair Display', serif;
            font-weight: 900;
            font-size: 2rem;
            color: #fff;
            letter-spacing: -0.5px;
            line-height: 1.1;
        }

        .page-title span { color: var(--gold); }

        .page-sub {
            margin-top: 6px;
            font-size: 0.82rem;
            color: var(--text-muted);
            font-weight: 400;
        }

        /* ── Stats Box ── */
        .stats-row {
            display: flex;
            gap: 14px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 16px 22px;
            flex: 1;
            transition: border-color 0.2s;
        }

        .stat-card:hover { border-color: var(--gold-border); }

        .stat-label {
            font-size: 0.6rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--text-muted);
            margin-bottom: 6px;
        }

        .stat-value {
            font-family: 'Playfair Display', serif;
            font-size: 1.9rem;
            font-weight: 700;
            color: #fff;
            line-height: 1;
        }

        .stat-value.gold { color: var(--gold); }

        /* ── Column Labels ── */
        .label-row {
            display: grid;
            grid-template-columns: 80px 160px 1fr 130px 100px;
            padding: 0 24px 12px;
            font-size: 0.58rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--text-muted);
        }

        /* ── Transaction Cards ── */
        .transaction-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .transaction-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 18px 24px;
            display: grid;
            grid-template-columns: 80px 160px 1fr 130px 100px;
            align-items: center;
            transition: all 0.2s ease;
            animation: cardIn 0.4s both;
        }

        .transaction-card:hover {
            border-color: var(--gold-border);
            background: var(--surface-2);
            transform: translateX(3px);
        }

        @keyframes cardIn {
            from { opacity: 0; transform: translateY(8px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Stagger cards */
        .transaction-card:nth-child(1)  { animation-delay: 0.04s; }
        .transaction-card:nth-child(2)  { animation-delay: 0.08s; }
        .transaction-card:nth-child(3)  { animation-delay: 0.12s; }
        .transaction-card:nth-child(4)  { animation-delay: 0.16s; }
        .transaction-card:nth-child(5)  { animation-delay: 0.20s; }
        .transaction-card:nth-child(6)  { animation-delay: 0.24s; }
        .transaction-card:nth-child(7)  { animation-delay: 0.28s; }
        .transaction-card:nth-child(8)  { animation-delay: 0.32s; }

        /* ── Cell Styles ── */
        .order-id {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--gold);
            background: var(--gold-dim);
            border: 1px solid var(--gold-border);
            padding: 4px 10px;
            border-radius: 7px;
            display: inline-block;
            letter-spacing: 0.5px;
        }

        .timestamp .date {
            font-size: 0.85rem;
            font-weight: 600;
            color: rgba(255,255,255,0.85);
            display: block;
            margin-bottom: 2px;
        }

        .timestamp .time {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        .items-cell {
            font-size: 0.83rem;
            color: rgba(255,255,255,0.65);
            padding: 0 18px;
            border-left: 2px solid rgba(255,255,255,0.06);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .items-cell i { color: rgba(255,255,255,0.2); margin-right: 6px; }

        .amount {
            font-family: 'Playfair Display', serif;
            font-size: 1.15rem;
            font-weight: 700;
            color: #fff;
        }

        .amount .currency {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-muted);
            vertical-align: super;
            margin-right: 2px;
        }

        .status-pill {
            background: var(--green-dim);
            color: var(--green);
            border: 1px solid rgba(46, 213, 115, 0.3);
            border-radius: 30px;
            padding: 5px 12px;
            font-size: 0.62rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        /* ── Empty State ── */
        .empty-state {
            text-align: center;
            padding: 80px 40px;
            background: var(--surface);
            border: 1px dashed rgba(255,255,255,0.1);
            border-radius: 18px;
        }

        .empty-icon {
            font-size: 2.5rem;
            color: rgba(255,255,255,0.1);
            margin-bottom: 16px;
        }

        .empty-state p {
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.08); border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.14); }

        /* ── Responsive ── */
        @media (max-width: 1024px) {
            .main-content { padding: 24px 20px; }
            .label-row,
            .transaction-card { grid-template-columns: 70px 140px 1fr 110px 90px; }
        }

        @media (max-width: 768px) {
            .sidebar { display: none; }
            .main-content { padding: 20px 16px; }
            .label-row { display: none; }
            .transaction-card {
                grid-template-columns: 1fr 1fr;
                grid-template-rows: auto auto auto;
                gap: 8px;
            }
            .items-cell { grid-column: 1 / -1; border-left: none; padding: 0; }
        }
    </style>
</head>
<body>

<!-- ═══════════ SIDEBAR ═══════════ -->
<div class="sidebar">
    <div class="sidebar-brand">
        <div class="sidebar-logo">
            <span class="r">Riverside</span><span class="c"> Café</span>
        </div>
        <?php if (session()->get('role') === 'admin'): ?>
            <span class="sidebar-role">Admin</span>
        <?php else: ?>
            <span class="sidebar-role">Staff</span>
        <?php endif; ?>
    </div>

    <nav>
        
        <a href="#" class="nav-link active">
            <i class="fas fa-history"></i> Transaction History
        </a>
    </nav>

    <div class="sidebar-footer">
        ☕ Riverside Café
    </div>
</div>

<!-- ═══════════ MAIN CONTENT ═══════════ -->
<div class="main-content">

    <a href="<?= base_url('dashboard') ?>" class="back-btn">
        <i class="fas fa-arrow-left"></i> Return to Dashboard
    </a>

    <!-- Header -->
    <div class="history-header">
        <div>
            <h1 class="page-title"><span>Transaction</span> History</h1>
            <p class="page-sub">Complete log of all completed café transactions</p>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-label">Total Orders</div>
            <div class="stat-value gold"><?= count($all_orders) ?></div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Total Revenue</div>
            <div class="stat-value">₱<?= number_format(array_sum(array_column($all_orders, 'total_amount')), 2) ?></div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Status</div>
            <div class="stat-value" style="font-size: 1rem; color: var(--green); padding-top: 6px;">
                <i class="fas fa-circle" style="font-size: 0.5rem; vertical-align: middle; margin-right: 6px;"></i> All Paid
            </div>
        </div>
    </div>

    <!-- Column Labels -->
    <div class="label-row">
        <div>Ref</div>
        <div>Timestamp</div>
        <div style="padding-left: 18px;">Order Summary</div>
        <div>Total</div>
        <div>Status</div>
    </div>

    <!-- Transaction List -->
    <div class="transaction-list">
        <?php if(!empty($all_orders)): ?>
            <?php foreach($all_orders as $order): ?>
            <div class="transaction-card">

                <div>
                    <span class="order-id">#<?= sprintf("%03d", $order['id']) ?></span>
                </div>

                <div class="timestamp">
                    <span class="date"><?= date('M d, Y', strtotime($order['order_date'])) ?></span>
                    <span class="time"><i class="far fa-clock me-1"></i><?= date('h:i A', strtotime($order['order_date'])) ?></span>
                </div>

                <div class="items-cell">
                    <i class="fas fa-receipt"></i><?= $order['items'] ?: 'General Order' ?>
                </div>

                <div class="amount">
                    <span class="currency">₱</span><?= number_format($order['total_amount'], 2) ?>
                </div>

                <div>
                    <span class="status-pill">
                        <i class="fas fa-check-circle"></i> Paid
                    </span>
                </div>

            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-icon"><i class="fas fa-receipt"></i></div>
                <p>No transaction logs available yet.</p>
            </div>
        <?php endif; ?>
    </div>

</div>

</body>
</html>