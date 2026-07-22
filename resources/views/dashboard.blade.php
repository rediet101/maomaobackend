<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Orders Dashboard — {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        * { box-sizing: border-box; }
        html, body { margin: 0; padding: 0; overflow-x: hidden; }
        body { font-family: 'Inter', sans-serif; background: #f5ede6; min-height: 100vh; }
        .font-display { font-family: 'Playfair Display', serif; }

        /* Layout */
        .layout { display: flex; min-height: 100vh; }
        .sidebar {
            width: 240px;
            min-width: 240px;
            background: #5D4037;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0;
            height: 100vh;
            z-index: 30;
        }
        .content {
            margin-left: 240px;
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
        }

        /* Sidebar */
        .sidebar-logo {
            padding: 28px 24px 24px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .sidebar-logo img {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            object-fit: cover;
        }
        .sidebar-logo-placeholder {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: #EAD7C3;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }
        .sidebar-brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 18px;
            color: #EAD7C3;
            line-height: 1.2;
        }
        .sidebar-brand-sub {
            font-size: 10px;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: #a07060;
            margin-top: 2px;
        }
        .sidebar-nav {
            padding: 20px 16px;
            flex: 1;
        }
        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 500;
            color: #EAD7C3;
            background: rgba(234,215,195,0.15);
            text-decoration: none;
        }
        .nav-item-active { background: #EAD7C3 !important; color: #5D4037 !important; font-weight: 600 !important; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .sidebar-footer {
            padding: 16px 24px;
            border-top: 1px solid rgba(255,255,255,0.08);
            font-size: 11px;
            color: #a07060;
        }

        /* Topbar */
        .topbar {
            background: #fff;
            border-bottom: 1px solid #EAD7C3;
            padding: 16px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 20;
        }
        .topbar-title {
            font-family: 'Playfair Display', serif;
            font-size: 22px;
            color: #3b2417;
        }
        .topbar-sub {
            font-size: 12px;
            color: #a07060;
            margin-top: 2px;
        }
        .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #5D4037;
            color: #EAD7C3;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 600;
        }

        /* Stats */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            padding: 28px 32px 0;
        }
        @media (max-width: 1100px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
        .stat-card {
            background: #fff;
            border-radius: 16px;
            padding: 22px 20px;
            border: 1px solid #EAD7C3;
        }
        .stat-card.dark {
            background: #5D4037;
            border-color: transparent;
        }
        .stat-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: #f5ede6;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 14px;
        }
        .stat-card.dark .stat-icon { background: rgba(255,255,255,0.12); }
        .stat-icon svg { width: 18px; height: 18px; color: #5D4037; stroke: #5D4037; }
        .stat-card.dark .stat-icon svg { stroke: #EAD7C3; }
        .stat-number {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            font-weight: 700;
            color: #3b2417;
            line-height: 1;
        }
        .stat-card.dark .stat-number { color: #fff; }
        .stat-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            font-weight: 600;
            color: #a07060;
            margin-top: 6px;
        }

        /* Table card */
        .table-card {
            margin: 24px 32px 32px;
            background: #fff;
            border-radius: 16px;
            border: 1px solid #EAD7C3;
            overflow: hidden;
        }
        .table-card-header {
            padding: 18px 24px;
            border-bottom: 1px solid #EAD7C3;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fff;
        }
        .table-card-title {
            font-family: 'Playfair Display', serif;
            font-size: 17px;
            color: #3b2417;
        }
        .table-card-sub { font-size: 12px; color: #a07060; margin-top: 2px; }


        /* Table */
        .table-wrap { overflow-x: auto; width: 100%; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        thead tr { background: #fdf8f4; border-bottom: 1px solid #EAD7C3; }
        th {
            padding: 10px 16px;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.14em;
            font-weight: 600;
            color: #a07060;
            white-space: nowrap;
            text-align: left;
        }
        tbody tr { border-bottom: 1px solid #f5ede6; transition: background 0.12s; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: #fdf8f4; }
        td { padding: 14px 16px; color: #4a3020; vertical-align: middle; }

        /* Chips */
        .chip {
            display: inline-flex;
            align-items: center;
            padding: 3px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 600;
            white-space: nowrap;
        }
        .chip-brown { background: #f5ede6; color: #5D4037; border: 1px solid #EAD7C3; }
        .chip-dark  { background: #ede8e4; color: #3b2417; border: 1px solid #d9cdc4; }

        /* Order ID */
        .order-id {
            font-family: monospace;
            font-size: 11px;
            background: #f5ede6;
            color: #a07060;
            padding: 2px 8px;
            border-radius: 6px;
        }

        /* Customer cell */
        .cust-avatar {
            width: 32px; height: 32px;
            border-radius: 50%;
            background: #5D4037;
            color: #EAD7C3;
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 700;
            flex-shrink: 0;
        }
        .cust-name { font-weight: 600; color: #3b2417; font-size: 13px; }
        .cust-email { font-size: 11px; color: #a07060; margin-top: 1px; }

        /* Truncated cell */
        .truncate-cell {
            max-width: 140px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            color: #6b4a30;
        }
        .muted { color: #c9b4a3; }

        /* Empty state */
        .empty { padding: 80px 20px; text-align: center; }
        .empty-emoji { font-size: 52px; margin-bottom: 16px; }
        .empty-title { font-family: 'Playfair Display', serif; font-size: 20px; color: #3b2417; }
        .empty-sub { font-size: 13px; color: #a07060; margin-top: 6px; }

        /* Pagination */
        .pagination-wrap {
            padding: 14px 20px;
            border-top: 1px solid #EAD7C3;
            background: #fdf8f4;
        }

        /* Notification items */
        @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:0.3} }
        @keyframes slideIn { from{opacity:0;transform:translateY(-8px)} to{opacity:1;transform:translateY(0)} }
        .notif-item { display:flex;align-items:flex-start;gap:12px;padding:14px 20px;border-bottom:1px solid #f5ede6;cursor:pointer;transition:background 0.12s;animation:slideIn 0.3s ease; text-decoration:none; }
        .notif-item:last-child { border-bottom:none; }
        .notif-item:hover { background:#fdf8f4; }
        .notif-avatar { width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;flex-shrink:0; }
        .notif-avatar.new { background:#5D4037;color:#EAD7C3; }
        .notif-avatar.alert { background:#fff3cd;color:#856404; }
        .notif-title { font-size:13px;font-weight:600;color:#3b2417; }
        .notif-body { font-size:12px;color:#6b4a30;margin-top:2px;line-height:1.4; }
        .notif-time { font-size:11px;color:#a07060;margin-top:4px; }
        .alert-item { display:flex;align-items:flex-start;gap:10px;padding:14px 20px;border-bottom:1px solid #f5ede6;cursor:pointer;transition:background 0.12s; text-decoration:none; }
        .alert-item:last-child { border-bottom:none; }
        .alert-item:hover { background:#fffbf5; }
        .alert-item.today { background:#fff8e1; border-left:3px solid #f59e0b; }
        .alert-item.tomorrow { background:#fdf3e7; border-left:3px solid #d4874e; }
        .alert-badge { font-size:10px;font-weight:700;padding:2px 8px;border-radius:999px;white-space:nowrap; }
        .alert-badge.today { background:#f59e0b;color:#fff; }
        .alert-badge.soon { background:#EAD7C3;color:#5D4037; }
            padding: 14px 32px;
            font-size: 11px;
            color: #c9b4a3;
            text-align: center;
            border-top: 1px solid #EAD7C3;
            background: #fff;
        }
    </style>
</head>
<body>
<div class="layout">

    {{-- Sidebar --}}
    @include('partials.sidebar')

    {{-- ── Main ── --}}
    <div class="content">

        {{-- Topbar --}}
        <header class="topbar">
            <div>
                <div class="topbar-title">Welcome to the maomao backery managment </div>
                <div class="topbar-sub">Track and manage all incoming cake orders</div>
            </div>
            <div style="display:flex;align-items:center;gap:12px">
                <div style="text-align:right">
                    <div style="font-size:13px;font-weight:600;color:#3b2417">Admin</div>
                    <div style="font-size:11px;color:#a07060">{{ config('app.name') }}</div>
                </div>
                <div class="avatar">A</div>
            </div>
        </header>

        <main style="flex:1">

            {{-- Stats --}}
            <div class="stats-grid">

                <div class="stat-card">
                    <div class="stat-icon">
                        <svg fill="none" stroke="#5D4037" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/></svg>
                    </div>
                    <div class="stat-number">{{ \App\Models\CakeOrder::count() }}</div>
                    <div class="stat-label">Custom Orders</div>
                </div>

                <div class="stat-card dark">
                    <div class="stat-icon">
                        <svg fill="none" stroke="#EAD7C3" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    </div>
                    <div class="stat-number">{{ \App\Models\MenuOrder::count() }}</div>
                    <div class="stat-label">Menu Orders</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <svg fill="none" stroke="#5D4037" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <div class="stat-number">{{ \App\Models\MenuItem::count() }}</div>
                    <div class="stat-label">Cakes on Menu</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <svg fill="none" stroke="#5D4037" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div class="stat-number">{{ \App\Models\AppUser::count() }}</div>
                    <div class="stat-label">Total Customers</div>
                </div>

            </div>

            {{-- Two column layout: notifications + upcoming pickups --}}
            <div style="display:grid;grid-template-columns:1fr 340px;gap:20px;margin:24px 32px 32px">

                {{-- Live Notifications Feed --}}
                <div style="background:#fff;border-radius:16px;border:1px solid #EAD7C3;overflow:hidden">
                    <div style="padding:18px 24px;border-bottom:1px solid #EAD7C3;display:flex;align-items:center;justify-content:space-between">
                        <div>
                            <div style="font-family:'Playfair Display',serif;font-size:17px;color:#3b2417">Live Order Notifications</div>
                            <div style="font-size:12px;color:#a07060;margin-top:2px">New orders from the last 24 hours</div>
                        </div>
                       
                    </div>

                    <div id="notif-feed" style="max-height:480px;overflow-y:auto">
                        <div style="padding:60px 20px;text-align:center;color:#a07060" id="notif-empty">
                            <div style="font-size:40px;margin-bottom:12px">🔔</div>
                            <div style="font-size:14px;font-weight:500;color:#3b2417">Loading notifications…</div>
                        </div>
                    </div>
                </div>

                {{-- Upcoming Pickups --}}
                <div style="background:#fff;border-radius:16px;border:1px solid #EAD7C3;overflow:hidden;align-self:start">
                    <div style="padding:18px 24px;border-bottom:1px solid #EAD7C3">
                        <div style="font-family:'Playfair Display',serif;font-size:17px;color:#3b2417">⏰ Pickup Alerts</div>
                        <div style="font-size:12px;color:#a07060;margin-top:2px">Orders due in the next 3 days</div>
                    </div>
                    <div id="alert-feed" style="max-height:480px;overflow-y:auto">
                        <div style="padding:40px 20px;text-align:center;color:#a07060" id="alert-empty">
                            <div style="font-size:32px;margin-bottom:8px">✅</div>
                            <div style="font-size:13px">No upcoming pickups</div>
                        </div>
                    </div>
                </div>

            </div>

        </main>

        <footer>{{ config('app.name') }} &copy; {{ now()->year }} · All rights reserved</footer>
    </div>

</div>
<script>
const seenIds = new Set();

function buildNotifItem(n) {
    const isAlert = n.type === 'pickup_alert';
    const avatarClass = isAlert ? 'alert' : 'new';
    const avatarBg = isAlert ? 'background:#fff3cd;color:#856404' : 'background:#5D4037;color:#EAD7C3';
    return `
        <a href="${n.link}" class="notif-item" style="display:flex;align-items:flex-start;gap:12px;padding:14px 20px;border-bottom:1px solid #f5ede6;cursor:pointer;transition:background 0.12s;animation:slideIn 0.3s ease;text-decoration:none">
            <div style="width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;flex-shrink:0;${avatarBg}">${n.avatar}</div>
            <div style="flex:1;min-width:0">
                <div style="font-size:13px;font-weight:600;color:#3b2417">${n.title}</div>
                <div style="font-size:12px;color:#6b4a30;margin-top:2px;line-height:1.4">${n.body}</div>
                <div style="font-size:11px;color:#a07060;margin-top:4px">${n.time_human}</div>
            </div>
            ${isAlert ? '' : '<span style="width:8px;height:8px;background:#5D4037;border-radius:50%;flex-shrink:0;margin-top:4px"></span>'}
        </a>`;
}

function buildAlertItem(n) {
    const isToday = n.days_left === 0;
    const isTomorrow = n.days_left === 1;
    const bg = isToday ? 'background:#fff8e1;border-left:3px solid #f59e0b' : 'background:#fdf3e7;border-left:3px solid #d4874e';
    const badgeBg = isToday ? 'background:#f59e0b;color:#fff' : 'background:#EAD7C3;color:#5D4037';
    const label = isToday ? 'TODAY' : isTomorrow ? 'TOMORROW' : `${n.days_left} DAYS`;
    return `
        <a href="${n.link}" style="display:flex;align-items:flex-start;gap:10px;padding:14px 20px;border-bottom:1px solid #f5ede6;cursor:pointer;transition:background 0.12s;text-decoration:none;${bg}">
            <div style="width:32px;height:32px;border-radius:50%;background:#5D4037;color:#EAD7C3;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;flex-shrink:0">${n.avatar}</div>
            <div style="flex:1;min-width:0">
                <div style="font-size:12px;font-weight:600;color:#3b2417;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">${n.body}</div>
                <span style="display:inline-block;margin-top:4px;font-size:10px;font-weight:700;padding:2px 8px;border-radius:999px;${badgeBg}">${label}</span>
            </div>
        </a>`;
}

async function fetchNotifications() {
    try {
        const res = await fetch('/api/notifications');
        const data = await res.json();
        const all = data.notifications;

        const newOnes = all.filter(n => n.type === 'new_order' && !seenIds.has(n.id));
        const alerts  = all.filter(n => n.type === 'pickup_alert');
        const existing = all.filter(n => n.type === 'new_order' && seenIds.has(n.id));

        // Play sound + show browser notification for truly new ones
        newOnes.forEach(n => {
            seenIds.add(n.id);
            if (Notification.permission === 'granted') {
                new Notification(n.title, { body: n.body, icon: '/maologo4.png' });
            }
        });

        // Render notifications feed
        const feed = document.getElementById('notif-feed');
        const allNew = all.filter(n => n.type === 'new_order');
        if (allNew.length === 0) {
            feed.innerHTML = `<div style="padding:60px 20px;text-align:center;color:#a07060"><div style="font-size:40px;margin-bottom:12px">🔔</div><div style="font-size:14px;font-weight:500;color:#3b2417">No new orders in the last 24h</div></div>`;
        } else {
            // Prepend new, keep existing below
            const newHtml = newOnes.map(buildNotifItem).join('');
            const existingHtml = existing.map(n => buildNotifItem(n).replace('animation:slideIn 0.3s ease', '')).join('');
            if (newOnes.length > 0) {
                feed.innerHTML = newHtml + existingHtml;
            }
        }

        // Update count badge
        const countEl = document.getElementById('notif-count');
        if (allNew.length > 0) {
            countEl.textContent = allNew.length;
            countEl.style.display = 'inline-block';
        }

        // Render alerts
        const alertFeed = document.getElementById('alert-feed');
        if (alerts.length === 0) {
            alertFeed.innerHTML = `<div style="padding:40px 20px;text-align:center;color:#a07060"><div style="font-size:32px;margin-bottom:8px">✅</div><div style="font-size:13px">No upcoming pickups</div></div>`;
        } else {
            alertFeed.innerHTML = alerts.map(buildAlertItem).join('');
        }

    } catch(e) {
        console.error('Notification fetch failed', e);
    }
}

// Request browser notification permission
if (Notification.permission === 'default') {
    Notification.requestPermission();
}

// Initial load + poll every 30 seconds
fetchNotifications();
setInterval(fetchNotifications, 30000);
</script>
</body>
</html>