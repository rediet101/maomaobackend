<style>
    * { box-sizing: border-box; }
    html, body { margin: 0; padding: 0; overflow-x: hidden; }
    body { font-family: 'Inter', sans-serif; background: #f5ede6; min-height: 100vh; }

    .layout { display: flex; min-height: 100vh; }

    /* Sidebar */
    .sidebar {
        width: 240px; min-width: 240px; background: #5D4037;
        display: flex; flex-direction: column;
        position: fixed; top: 0; left: 0; height: 100vh; z-index: 30;
    }
    .sidebar-logo {
        padding: 28px 24px 24px; border-bottom: 1px solid rgba(255,255,255,0.1);
        display: flex; align-items: center; gap: 12px;
    }
    .sidebar-logo img { width: 42px; height: 42px; border-radius: 10px; object-fit: cover; }
    .sidebar-logo-placeholder {
        width: 42px; height: 42px; border-radius: 10px; background: #EAD7C3;
        display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0;
    }
    .sidebar-brand-name { font-family: 'Playfair Display', serif; font-size: 18px; color: #EAD7C3; line-height: 1.2; }
    .sidebar-brand-sub { font-size: 10px; letter-spacing: 0.18em; text-transform: uppercase; color: #a07060; margin-top: 2px; }
    .sidebar-nav { padding: 20px 16px; flex: 1; }
    .nav-item {
        display: flex; align-items: center; gap: 10px;
        padding: 10px 14px; border-radius: 10px;
        font-size: 14px; font-weight: 500; color: #EAD7C3;
        background: rgba(234,215,195,0.15); text-decoration: none;
    }
    .nav-item-active { background: #EAD7C3 !important; color: #5D4037 !important; font-weight: 600 !important; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    .sidebar-footer { padding: 16px 24px; border-top: 1px solid rgba(255,255,255,0.08); font-size: 11px; color: #a07060; }

    /* Content */
    .content { margin-left: 240px; flex: 1; min-width: 0; display: flex; flex-direction: column; }

    /* Topbar */
    .topbar {
        background: #fff; border-bottom: 1px solid #EAD7C3;
        padding: 16px 32px; display: flex; align-items: center; justify-content: space-between;
        position: sticky; top: 0; z-index: 20;
    }
    .topbar-title { font-family: 'Playfair Display', serif; font-size: 22px; color: #3b2417; }
    .topbar-sub { font-size: 12px; color: #a07060; margin-top: 2px; }
    .avatar {
        width: 36px; height: 36px; border-radius: 50%; background: #5D4037; color: #EAD7C3;
        display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 600;
    }
    .page-body { padding: 28px 32px 40px; }

    /* Cards */
    .card { background: #fff; border-radius: 16px; border: 1px solid #EAD7C3; overflow: hidden; }
    .card-header { padding: 16px 24px; border-bottom: 1px solid #EAD7C3; display: flex; align-items: center; gap: 10px; }
    .card-icon { width: 32px; height: 32px; border-radius: 8px; background: #f5ede6; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .card-title { font-family: 'Playfair Display', serif; font-size: 15px; color: #3b2417; }

    /* Stat cards */
    .stats-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 16px; margin-bottom: 24px; }
    @media(max-width:1100px) { .stats-grid { grid-template-columns: repeat(2,1fr); } }
    .stat-card { background: #fff; border-radius: 16px; padding: 22px 20px; border: 1px solid #EAD7C3; }
    .stat-card.dark { background: #5D4037; border-color: transparent; }
    .stat-icon { width: 38px; height: 38px; border-radius: 10px; background: #f5ede6; display: flex; align-items: center; justify-content: center; margin-bottom: 14px; }
    .stat-card.dark .stat-icon { background: rgba(255,255,255,0.12); }
    .stat-number { font-family: 'Playfair Display', serif; font-size: 32px; font-weight: 700; color: #3b2417; line-height: 1; }
    .stat-card.dark .stat-number { color: #fff; }
    .stat-label { font-size: 11px; text-transform: uppercase; letter-spacing: 0.12em; font-weight: 600; color: #a07060; margin-top: 6px; }

    /* Table */
    .table-card { background: #fff; border-radius: 16px; border: 1px solid #EAD7C3; overflow: hidden; }
    .table-card-header { padding: 18px 24px; border-bottom: 1px solid #EAD7C3; display: flex; align-items: center; justify-content: space-between; }
    .table-wrap { overflow-x: auto; width: 100%; }
    table { width: 100%; border-collapse: collapse; font-size: 13px; }
    thead tr { background: #fdf8f4; border-bottom: 1px solid #EAD7C3; }
    th { padding: 10px 16px; font-size: 10px; text-transform: uppercase; letter-spacing: 0.14em; font-weight: 600; color: #a07060; white-space: nowrap; text-align: left; }
    tbody tr { border-bottom: 1px solid #f5ede6; transition: background 0.12s; cursor: pointer; }
    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: #fdf8f4; }
    td { padding: 14px 16px; color: #4a3020; vertical-align: middle; }

    /* Chips */
    .chip { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 999px; font-size: 11px; font-weight: 600; white-space: nowrap; }
    .chip-brown { background: #f5ede6; color: #5D4037; border: 1px solid #EAD7C3; }
    .chip-dark  { background: #ede8e4; color: #3b2417; border: 1px solid #d9cdc4; }

    /* Misc */
    .order-id { font-family: monospace; font-size: 11px; background: #f5ede6; color: #a07060; padding: 2px 8px; border-radius: 6px; }
    .cust-avatar { width: 32px; height: 32px; border-radius: 50%; background: #5D4037; color: #EAD7C3; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; flex-shrink: 0; }
    .back-btn { display: inline-flex; align-items: center; gap: 8px; text-decoration: none; color: #5D4037; font-size: 13px; font-weight: 500; padding: 8px 16px; border-radius: 10px; background: #fff; border: 1px solid #EAD7C3; transition: background 0.15s; }
    .back-btn:hover { background: #f5ede6; }
    .flash { padding: 12px 18px; border-radius: 10px; font-size: 13px; font-weight: 500; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; background: #e8f5e9; color: #2e7d32; border: 1px solid #c8e6c9; }
    .empty { padding: 80px 20px; text-align: center; }
    .muted { color: #c9b4a3; }
    footer { padding: 14px 32px; font-size: 11px; color: #c9b4a3; text-align: center; border-top: 1px solid #EAD7C3; background: #fff; }
</style>
