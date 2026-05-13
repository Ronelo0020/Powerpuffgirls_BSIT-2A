<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riverside | Sales Heatmap</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root { 
            --bg-dark: #0f0f0f; --card-dark: #161616; --accent-gold: #ffcc4d; 
            --accent-red: #ff4d4d; --text-main: #ffffff; --text-muted: #a0a0a0;
        }
        body { background-color: var(--bg-dark); font-family: 'Poppins', sans-serif; color: var(--text-main); padding: 40px 20px; }
        
        .calendar-wrapper { 
            background: var(--card-dark); border-radius: 24px; border: 1px solid #2a2a2a; 
            padding: 30px; max-width: 1100px; margin: auto; box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        }
        
        .header-section { border-bottom: 1px solid #2a2a2a; margin-bottom: 25px; padding-bottom: 20px; }
        .text-white-muted { color: #ffffff !important; opacity: 0.9; font-size: 0.9rem; }

        .custom-select { 
            background: #252525; color: white; border: 1px solid #333; padding: 10px 18px; 
            border-radius: 12px; outline: none; transition: 0.3s; cursor: pointer;
        }

        .btn-group-custom { background: #252525; padding: 5px; border-radius: 12px; border: 1px solid #333; display: flex; }
        .btn-group-custom .btn { 
            color: var(--text-muted); border: none; border-radius: 8px; 
            padding: 8px 15px; font-weight: 500; transition: 0.3s; flex: 1;
        }
        .btn-group-custom .btn.active { background: var(--accent-gold); color: #000; font-weight: 600; }

        .calendar-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 12px; }
        .day-name { text-align: center; font-weight: 600; color: var(--accent-gold); text-transform: uppercase; font-size: 0.75rem; padding-bottom: 15px; }
        
        .day-box { 
            background: #1e1e1e; border: 1px solid #2a2a2a; min-height: 110px; 
            border-radius: 16px; padding: 12px; transition: 0.3s; display: flex; flex-direction: column; justify-content: space-between;
        }
        .day-box.has-sales { border: 2px solid var(--accent-red); background: rgba(255, 77, 77, 0.05); }
        .day-box.weekly-active { border: 2px solid var(--accent-gold); background: rgba(255, 204, 77, 0.1); }
        .day-box.monthly-active { border: 2px solid #4e73df; background: rgba(78, 115, 223, 0.1); }
        .day-box.empty { opacity: 0.1; }

        .day-num { font-weight: 600; font-size: 1rem; color: var(--text-muted); }
        .sales-amount { 
            background: rgba(0,0,0,0.5); padding: 4px; border-radius: 6px;
            color: var(--accent-gold); font-weight: 700; font-size: 0.8rem; text-align: center;
        }

        .btn-back { 
            color: var(--text-main); text-decoration: none; margin-bottom: 25px; 
            display: inline-flex; align-items: center; padding: 8px 16px;
            background: #1e1e1e; border: 1px solid #333; border-radius: 10px; transition: 0.3s;
        }
        .btn-back:hover { color: var(--accent-gold); transform: translateX(-5px); }
    </style>
</head>
<body>

<a href="<?= base_url('sales') ?>" class="btn-back"><i class="fas fa-arrow-left me-2"></i> Back to Analytics</a>

<div class="calendar-wrapper shadow">
    <div class="header-section d-flex justify-content-between align-items-center">
        <div>
            <h3 class="fw-bold mb-1">Sales Heatmap</h3>
            <p class="text-white-muted mb-0">Track daily, weekly, or monthly revenue performance</p>
        </div>
        <button class="btn btn-primary rounded-pill px-4" onclick="window.print()"><i class="fas fa-download me-2"></i> EXPORT</button>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex gap-2">
            <select class="custom-select" id="monthSelect" onchange="updateCalendar()">
                <?php 
                $months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                foreach($months as $idx => $m) echo "<option value='".($idx+1)."' ".($m=="May"?"selected":"").">$m</option>";
                ?>
            </select>
            <select class="custom-select" id="yearSelect" onchange="updateCalendar()">
                <option value="2026" selected>2026</option>
                <option value="2025">2025</option>
            </select>
        </div>

        <div class="btn-group-custom">
            <button class="btn active" id="dailyBtn" onclick="setFilter('daily')">Daily</button>
            <button class="btn" id="weeklyBtn" onclick="setFilter('weekly')">Weekly</button>
            <button class="btn" id="monthlyBtn" onclick="setFilter('monthly')">Monthly</button>
        </div>
    </div>

    <div class="calendar-grid" id="calendarGrid"></div>
</div>

<script>
    let currentFilter = 'daily';
    const rawSalesData = <?= json_encode($sales_data) ?>;

    function setFilter(type) {
        currentFilter = type;
        ['daily', 'weekly', 'monthly'].forEach(f => {
            document.getElementById(f + 'Btn').classList.toggle('active', f === type);
        });
        updateCalendar();
    }

    function updateCalendar() {
        const month = parseInt(document.getElementById('monthSelect').value);
        const year = parseInt(document.getElementById('yearSelect').value);
        const grid = document.getElementById('calendarGrid');
        grid.innerHTML = '';

        ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'].forEach(d => grid.innerHTML += `<div class="day-name">${d}</div>`);

        const firstDay = new Date(year, month - 1, 1).getDay();
        const daysInMonth = new Date(year, month, 0).getDate();
        let startOffset = (firstDay === 0) ? 6 : firstDay - 1;

        for(let i=0; i<startOffset; i++) grid.innerHTML += `<div class="day-box empty"></div>`;

        for(let d=1; d<=daysInMonth; d++) {
            const dateStr = `${year}-${String(month).padStart(2, '0')}-${String(d).padStart(2, '0')}`;
            const sale = rawSalesData.find(s => s.date === dateStr);
            
            let classes = 'day-box';
            if(sale) {
                if(currentFilter === 'daily') classes += ' has-sales';
                if(currentFilter === 'weekly') classes += ' weekly-active';
                if(currentFilter === 'monthly') classes += ' monthly-active';
            }

            const amount = sale ? `₱${parseFloat(sale.total).toLocaleString()}` : '';
            grid.innerHTML += `<div class="${classes}"><span class="day-num">${d}</span><span class="sales-amount">${amount}</span></div>`;
        }
    }
    document.addEventListener('DOMContentLoaded', updateCalendar);
</script>
</body>
</html>