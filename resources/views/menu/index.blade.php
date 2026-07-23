<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Menu — {{ config('app.name') }}</title>
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

        .layout { display: flex; min-height: 100vh; }
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

        .content { margin-left: 240px; flex: 1; min-width: 0; display: flex; flex-direction: column; }
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

        /* Flash */
        .flash {
            padding: 12px 18px; border-radius: 10px; font-size: 13px; font-weight: 500;
            margin-bottom: 20px; display: flex; align-items: center; gap: 10px;
            background: #e8f5e9; color: #2e7d32; border: 1px solid #c8e6c9;
        }

        /* Page header */
        .page-hdr { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; flex-wrap: wrap; gap: 12px; }
        .page-hdr-title { font-family: 'Playfair Display', serif; font-size: 26px; color: #3b2417; }
        .btn-primary {
            display: inline-flex; align-items: center; gap: 8px;
            background: #5D4037; color: #EAD7C3; font-size: 13px; font-weight: 600;
            padding: 10px 20px; border-radius: 10px; text-decoration: none; border: none; cursor: pointer;
            transition: background 0.15s;
        }
        .btn-primary:hover { background: #4a3028; }

        /* Grid */
        .menu-grid {
            display: grid; gap: 20px;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        }

        /* Card */
        .menu-card {
            background: #fff; border-radius: 16px; border: 1px solid #EAD7C3;
            overflow: hidden; display: flex; flex-direction: column;
        }
        .menu-card-img {
            width: 100%; height: 200px; object-fit: cover; display: block;
            background: #f5ede6;
        }
        .menu-card-img-placeholder {
            width: 100%; height: 200px; background: #f5ede6;
            display: flex; align-items: center; justify-content: center;
            font-size: 48px; color: #EAD7C3;
        }
        .menu-card-body { padding: 18px 20px; flex: 1; display: flex; flex-direction: column; }
        .menu-card-title { font-family: 'Playfair Display', serif; font-size: 17px; color: #3b2417; margin-bottom: 8px; }
        .menu-card-desc {
            font-size: 13px; color: #6b4a30; line-height: 1.6; flex: 1;
            overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;
        }
        .menu-card-desc * { font-size: 13px !important; }
        .menu-card-footer {
            padding: 12px 20px; border-top: 1px solid #f5ede6;
            display: flex; align-items: center; justify-content: space-between;
        }
        .badge-available { font-size: 11px; font-weight: 600; padding: 3px 10px; border-radius: 999px; background: #e8f5e9; color: #2e7d32; border: 1px solid #c8e6c9; }
        .badge-unavailable { font-size: 11px; font-weight: 600; padding: 3px 10px; border-radius: 999px; background: #fce4ec; color: #c62828; border: 1px solid #f8bbd0; }
        .card-actions { display: flex; gap: 8px; }
        .btn-edit {
            font-size: 12px; font-weight: 500; padding: 5px 12px; border-radius: 8px;
            background: #f5ede6; color: #5D4037; border: 1px solid #EAD7C3; text-decoration: none;
            transition: background 0.12s;
        }
        .btn-edit:hover { background: #EAD7C3; }
        .btn-delete {
            font-size: 12px; font-weight: 500; padding: 5px 12px; border-radius: 8px;
            background: #fce4ec; color: #c62828; border: 1px solid #f8bbd0; cursor: pointer;
            transition: background 0.12s;
        }
        .btn-delete:hover { background: #f8bbd0; }

        /* Empty */
        .empty { padding: 80px 20px; text-align: center; background: #fff; border-radius: 16px; border: 1px solid #EAD7C3; }
        .empty-emoji { font-size: 52px; margin-bottom: 16px; }
        .empty-title { font-family: 'Playfair Display', serif; font-size: 20px; color: #3b2417; }
        .empty-sub { font-size: 13px; color: #a07060; margin-top: 6px; margin-bottom: 20px; }

        footer { padding: 14px 32px; font-size: 11px; color: #c9b4a3; text-align: center; border-top: 1px solid #EAD7C3; background: #fff; }
    </style>
</head>
<body>
<div class="layout">

    @include('partials.sidebar')

    <div class="content">
        <header class="topbar">
            <div>
                <div class="topbar-title">Menu</div>
                <div class="topbar-sub">Manage your cake offerings</div>
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
            <div class="page-body">

                @if (session('success'))
                    <div class="flash">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;flex-shrink:0"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        {{ session('success') }}
                    </div>
                @endif

                <div class="page-hdr">
                    <div class="page-hdr-title">All Menu Items</div>
                    <div style="display:flex; align-items:center; gap:16px;">
                        <form method="GET" action="{{ url()->current() }}" style="display:flex; gap:8px;">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..." style="padding:6px 12px; border-radius:6px; border:1px solid #EAD7C3; font-size:13px; outline:none;">
                            <button type="submit" style="background:#5D4037; color:#fff; border:none; padding:6px 12px; border-radius:6px; cursor:pointer; font-size:13px; font-weight:500;">Filter</button>
                            @if(request('search'))
                                <a href="{{ url()->current() }}" style="display:flex; align-items:center; padding:6px 12px; color:#a07060; text-decoration:none; font-size:13px; font-weight:500;">Clear</a>
                            @endif
                        </form>
                        <a href="{{ route('menu.create') }}" class="btn-primary">
                            <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                            Add Menu Item
                        </a>
                    </div>
                </div>

                @if ($items->isEmpty())
                    <div class="empty">
                        <div class="empty-emoji">🍰</div>
                        <div class="empty-title">No menu items yet</div>
                        <div class="empty-sub">Add your first cake to get started.</div>
                        <a href="{{ route('menu.create') }}" class="btn-primary" style="display:inline-flex">
                            <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                            Add Menu Item
                        </a>
                    </div>
                @else
                    <div class="menu-grid">
                        @foreach ($items as $item)
                            <div class="menu-card">
                                @if ($item->image)
                                    <img src="{{ $item->imageUrl() }}" alt="{{ $item->title }}" class="menu-card-img">
                                @else
                                    <div class="menu-card-img-placeholder">🎂</div>
                                @endif

                                <div class="menu-card-body">
                                    <div class="menu-card-title">{{ $item->title }}</div>
                                    <div style="font-family:'Playfair Display',serif;font-size:18px;font-weight:700;color:#5D4037;margin-bottom:8px">
                                        ETB {{ number_format($item->price, 2) }}
                                    </div>
                                    <div class="menu-card-desc">{!! $item->description !!}</div>
                                </div>

                                <div class="menu-card-footer">
                                    <span class="{{ $item->is_available ? 'badge-available' : 'badge-unavailable' }}">
                                        {{ $item->is_available ? 'Available' : 'Currently Unavailable' }}
                                    </span>
                                    <div class="card-actions">
                                        <a href="{{ route('menu.edit', $item) }}" class="btn-edit">Edit</a>
                                        <form action="{{ route('menu.destroy', $item) }}" method="POST" onsubmit="return confirm('Delete this item?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if ($items->hasPages())
                        <div style="margin-top:24px">{{ $items->links() }}</div>
                    @endif
                @endif

            </div>
        </main>

        <footer>{{ config('app.name') }} &copy; {{ now()->year }} · All rights reserved</footer>
    </div>

</div>
</body>
</html>
