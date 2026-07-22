<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }} — {{ config('app.name') }}</title>
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

        .layout { display: flex; min-height: 100vh; }

        /* Sidebar */
        .sidebar {
            width: 240px; min-width: 240px;
            background: #5D4037;
            display: flex; flex-direction: column;
            position: fixed; top: 0; left: 0;
            height: 100vh; z-index: 30;
        }
        .sidebar-logo {
            padding: 28px 24px 24px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            display: flex; align-items: center; gap: 12px;
        }
        .sidebar-logo img { width: 42px; height: 42px; border-radius: 10px; object-fit: cover; }
        .sidebar-logo-placeholder {
            width: 42px; height: 42px; border-radius: 10px;
            background: #EAD7C3;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; flex-shrink: 0;
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
            padding: 16px 32px;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 20;
        }
        .topbar-title { font-family: 'Playfair Display', serif; font-size: 22px; color: #3b2417; }
        .topbar-sub { font-size: 12px; color: #a07060; margin-top: 2px; }
        .avatar {
            width: 36px; height: 36px; border-radius: 50%;
            background: #5D4037; color: #EAD7C3;
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; font-weight: 600;
        }

        /* Back button */
        .back-btn {
            display: inline-flex; align-items: center; gap: 8px;
            text-decoration: none; color: #5D4037;
            font-size: 13px; font-weight: 500;
            padding: 8px 16px; border-radius: 10px;
            background: #fff; border: 1px solid #EAD7C3;
            transition: background 0.15s;
        }
        .back-btn:hover { background: #f5ede6; }

        /* Main layout */
        .page-body { padding: 28px 32px 40px; }
        .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 28px; flex-wrap: wrap; gap: 12px; }
        .page-header-left { display: flex; align-items: center; gap: 14px; }
        .order-badge {
            font-size: 12px; font-weight: 700; font-family: monospace;
            background: #5D4037; color: #EAD7C3;
            padding: 4px 12px; border-radius: 8px;
        }
        .page-title { font-family: 'Playfair Display', serif; font-size: 26px; color: #3b2417; }
        .submitted-at { font-size: 12px; color: #a07060; margin-top: 3px; }

        /* Two column grid */
        .detail-grid { display: grid; grid-template-columns: 1fr 340px; gap: 20px; align-items: start; }
        @media (max-width: 900px) { .detail-grid { grid-template-columns: 1fr; } }

        /* Cards */
        .card {
            background: #fff; border-radius: 16px;
            border: 1px solid #EAD7C3; overflow: hidden;
        }
        .card-header {
            padding: 16px 24px; border-bottom: 1px solid #EAD7C3;
            display: flex; align-items: center; gap: 10px;
        }
        .card-header-icon {
            width: 32px; height: 32px; border-radius: 8px;
            background: #f5ede6;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .card-header-title { font-family: 'Playfair Display', serif; font-size: 15px; color: #3b2417; }
        .card-body { padding: 24px; }

        /* Field rows */
        .field-row { display: flex; flex-direction: column; margin-bottom: 20px; }
        .field-row:last-child { margin-bottom: 0; }
        .field-label {
            font-size: 10px; text-transform: uppercase; letter-spacing: 0.14em;
            font-weight: 600; color: #a07060; margin-bottom: 5px;
        }
        .field-value { font-size: 14px; color: #3b2417; font-weight: 500; line-height: 1.5; }
        .field-value.muted { color: #c9b4a3; font-weight: 400; font-style: italic; }

        /* Two col inside card */
        .field-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }

        /* Customer avatar hero */
        .cust-hero {
            display: flex; align-items: center; gap: 16px;
            padding: 20px 24px; border-bottom: 1px solid #EAD7C3;
        }
        .cust-hero-avatar {
            width: 54px; height: 54px; border-radius: 50%;
            background: #5D4037; color: #EAD7C3;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px; font-weight: 700; flex-shrink: 0;
        }
        .cust-hero-name { font-family: 'Playfair Display', serif; font-size: 18px; color: #3b2417; }
        .cust-hero-email { font-size: 12px; color: #a07060; margin-top: 2px; }

        /* Chips */
        .chip { display: inline-flex; align-items: center; padding: 4px 12px; border-radius: 999px; font-size: 12px; font-weight: 600; }
        .chip-brown { background: #f5ede6; color: #5D4037; border: 1px solid #EAD7C3; }
        .chip-dark  { background: #ede8e4; color: #3b2417; border: 1px solid #d9cdc4; }

        /* Divider */
        .divider { border: none; border-top: 1px solid #EAD7C3; margin: 0; }

        /* Timeline */
        .timeline-item { display: flex; gap: 12px; padding: 14px 24px; border-bottom: 1px solid #f5ede6; }
        .timeline-item:last-child { border-bottom: none; }
        .timeline-dot {
            width: 8px; height: 8px; border-radius: 50%;
            background: #5D4037; margin-top: 5px; flex-shrink: 0;
        }
        .timeline-label { font-size: 12px; color: #a07060; }
        .timeline-value { font-size: 13px; color: #3b2417; font-weight: 500; margin-top: 1px; }

        footer {
            padding: 14px 32px; font-size: 11px; color: #c9b4a3;
            text-align: center; border-top: 1px solid #EAD7C3; background: #fff;
        }
    </style>
</head>
<body>
<div class="layout">

    {{-- Sidebar --}}
    @include('partials.sidebar')

    {{-- Content --}}
    <div class="content">

        {{-- Topbar --}}
        <header class="topbar">
            <div>
                <div class="topbar-title">Order Detail</div>
                <div class="topbar-sub">Full breakdown of the selected order</div>
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

                {{-- Page header --}}
                <div class="page-header">
                    <div class="page-header-left">
                        <a href="{{ route('dashboard') }}" class="back-btn">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Back
                        </a>
                        <div>
                            <div style="display:flex;align-items:center;gap:10px">
                                <span class="order-badge">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
                                <span class="page-title">{{ $order->name }}'s Order</span>
                            </div>
                            <div class="submitted-at">Submitted {{ $order->created_at->format('D, d M Y \a\t H:i') }}</div>
                        </div>
                    </div>
                </div>

                {{-- Detail grid --}}
                <div class="detail-grid">

                    {{-- Left column --}}
                    <div style="display:flex;flex-direction:column;gap:20px">

                        {{-- Customer info --}}
                        <div class="card">
                            <div class="cust-hero">
                                <div class="cust-hero-avatar">{{ strtoupper(substr($order->name, 0, 1)) }}</div>
                                <div>
                                    <div class="cust-hero-name">{{ $order->name }}</div>
                                    <div class="cust-hero-email">{{ $order->email }}</div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="field-grid-2">
                                    <div class="field-row">
                                        <span class="field-label">Phone</span>
                                        <span class="field-value">{{ $order->phone }}</span>
                                    </div>
                                    <div class="field-row">
                                        <span class="field-label">Pickup / Delivery Date</span>
                                        <span class="field-value">{{ $order->pickup_delivery_date->format('D, d M Y') }}</span>
                                    </div>
                                    <div class="field-row">
                                        <span class="field-label">Delivery Type</span>
                                        @if (($order->delivery_type ?? 'self_pickup') === 'driver')
                                            <span class="chip chip-brown" style="margin-top:4px">🚗 Driver Delivery</span>
                                        @else
                                            <span class="chip chip-dark" style="margin-top:4px">🏃 Self Pickup</span>
                                        @endif
                                    </div>
                                    @if (($order->delivery_type ?? 'self_pickup') === 'driver' && $order->delivery_address)
                                        <div class="field-row">
                                            <span class="field-label">Delivery Address</span>
                                            <span class="field-value">{{ $order->delivery_address }}</span>
                                        </div>
                                    @endif
                                </div>

                                {{-- Map --}}
                                @if (($order->delivery_type ?? 'self_pickup') === 'driver' && $order->delivery_address)
                                    <div style="margin-top:16px;border-radius:12px;overflow:hidden;border:1px solid #EAD7C3">
                                        <iframe width="100%" height="240" frameborder="0" style="display:block" referrerpolicy="no-referrer-when-downgrade"
                                            src="https://maps.google.com/maps?q={{ urlencode($order->delivery_address) }}&output=embed&z=15" allowfullscreen></iframe>
                                    </div>
                                    <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($order->delivery_address) }}" target="_blank"
                                        style="display:inline-flex;align-items:center;gap:6px;margin-top:10px;font-size:12px;color:#5D4037;font-weight:600;text-decoration:none;padding:6px 14px;background:#f5ede6;border:1px solid #EAD7C3;border-radius:8px">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:13px;height:13px"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                        Open in Google Maps
                                    </a>
                                @else
                                    <div style="margin-top:16px;border-radius:12px;overflow:hidden;border:1px solid #EAD7C3">
                                        <iframe width="100%" height="240" frameborder="0" style="display:block" referrerpolicy="no-referrer-when-downgrade"
                                            src="https://maps.google.com/maps?q=Bole+Welo+Sefer,+Addis+Ababa,+Ethiopia&output=embed&z=16" allowfullscreen></iframe>
                                    </div>
                                    <a href="https://www.google.com/maps/dir/?api=1&destination=Bole+Welo+Sefer,+Addis+Ababa,+Ethiopia" target="_blank"
                                        style="display:inline-flex;align-items:center;gap:6px;margin-top:10px;font-size:12px;color:#5D4037;font-weight:600;text-decoration:none;padding:6px 14px;background:#f5ede6;border:1px solid #EAD7C3;border-radius:8px">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:13px;height:13px"><path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                                        Get Directions to Bakery
                                    </a>
                                @endif
                            </div>
                        </div>

                        {{-- Order details --}}
                        <div class="card">
                            <div class="card-header">
                                <div class="card-header-icon">
                                    <svg fill="none" stroke="#5D4037" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                                    </svg>
                                </div>
                                <span class="card-header-title">Cake Details</span>
                            </div>
                            <div class="card-body">
                                <div class="field-grid-2" style="margin-bottom:20px">
                                    <div class="field-row" style="margin-bottom:0">
                                        <span class="field-label">Flavour</span>
                                        <span class="chip chip-brown" style="margin-top:4px">{{ $order->flavour }}</span>
                                    </div>
                                    <div class="field-row" style="margin-bottom:0">
                                        <span class="field-label">Size</span>
                                        <span class="chip chip-dark" style="margin-top:4px">{{ $order->size }}</span>
                                    </div>
                                </div>
                                <hr class="divider" style="margin-bottom:20px">
                                <div class="field-row">
                                    <span class="field-label">Design Inspiration</span>
                                    @if ($order->design_inspiration)
                                        <span class="field-value">{{ $order->design_inspiration }}</span>
                                    @else
                                        <span class="field-value muted">No design inspiration provided</span>
                                    @endif
                                </div>
                                <div class="field-row">
                                    <span class="field-label">Additional Notes</span>
                                    @if ($order->additional_notes)
                                        <span class="field-value">{{ $order->additional_notes }}</span>
                                    @else
                                        <span class="field-value muted">No additional notes</span>
                                    @endif
                                </div>
                                <hr class="divider" style="margin:20px 0">
                                <div class="field-row" style="margin-bottom:0">
                                    <span class="field-label">Order Action / Status</span>
                                    <div style="display:flex;align-items:center;gap:12px;margin-top:8px;flex-wrap:wrap">
                                        @if ($order->status === 'preparing')
                                            <span class="chip" style="background:#ede9fe;color:#5b21b6;border:1px solid #c4b5fd;font-size:13px;padding:6px 14px">👩‍🍳 Preparing</span>
                                        @elseif ($order->status === 'ready')
                                            <span class="chip" style="background:#ccfbf1;color:#0f766e;border:1px solid #99f6e4;font-size:13px;padding:6px 14px">✨ Ready</span>
                                        @elseif ($order->status === 'completed')
                                            <span class="chip" style="background:#d1fae5;color:#065f46;border:1px solid #6ee7b7;font-size:13px;padding:6px 14px">🎉 Completed</span>
                                        @elseif ($order->status === 'cancelled')
                                            <span class="chip" style="background:#fee2e2;color:#991b1b;border:1px solid #fca5a5;font-size:13px;padding:6px 14px">❌ Cancelled</span>
                                        @else
                                            <span class="chip" style="background:#fff3cd;color:#856404;border:1px solid #fde68a;font-size:13px;padding:6px 14px">⏳ {{ ucfirst($order->status ?? 'pending') }}</span>
                                        @endif

                                        <form method="POST" action="{{ route('orders.update-status', $order) }}" style="display:inline-flex;gap:10px;flex-wrap:wrap">
                                            @csrf
                                            @if ($order->status === 'pending' || empty($order->status))
                                                <button type="submit" name="status" value="preparing" style="background:#059669;color:#fff;border:none;padding:8px 18px;border-radius:8px;cursor:pointer;font-weight:600;font-size:13px;display:inline-flex;align-items:center;gap:6px">
                                                    ✓ Accept Order
                                                </button>
                                                <button type="submit" name="status" value="cancelled" style="background:#dc2626;color:#fff;border:none;padding:8px 18px;border-radius:8px;cursor:pointer;font-weight:600;font-size:13px;display:inline-flex;align-items:center;gap:6px">
                                                    ✕ Reject Order
                                                </button>
                                            @elseif ($order->status === 'preparing')
                                                <button type="submit" name="status" value="ready" style="background:#0D9488;color:#fff;border:none;padding:8px 18px;border-radius:8px;cursor:pointer;font-weight:600;font-size:13px;display:inline-flex;align-items:center;gap:6px">
                                                    ✨ Mark as Ready
                                                </button>
                                            @elseif ($order->status === 'ready')
                                                <button type="submit" name="status" value="completed" style="background:#059669;color:#fff;border:none;padding:8px 18px;border-radius:8px;cursor:pointer;font-weight:600;font-size:13px;display:inline-flex;align-items:center;gap:6px">
                                                    🎉 Mark as Completed
                                                </button>
                                            @endif
                                        </form>
                                    </div>
                                </div>
                                @if ($order->rating || $order->feedback)
                                    <hr class="divider" style="margin:20px 0">
                                    <div class="field-row" style="margin-bottom:0">
                                        <span class="field-label">Customer Rating & Review</span>
                                        <div style="background:#fdf8f4;padding:14px 16px;border-radius:12px;border:1px solid #EAD7C3;margin-top:6px">
                                            @if ($order->rating)
                                                <div style="font-size:16px;color:#f59e0b;margin-bottom:4px">
                                                    {{ str_repeat('⭐', $order->rating) }}
                                                    <span style="font-size:13px;font-weight:700;color:#5D4037;margin-left:6px">{{ $order->rating }} / 5</span>
                                                </div>
                                            @endif
                                            @if ($order->feedback)
                                                <div style="font-size:13px;color:#3b2417;font-style:italic">"{{ $order->feedback }}"</div>
                                            @else
                                                <div style="font-size:12px;color:#a07060">No written feedback provided.</div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>

                    {{-- Right column --}}
                    <div style="display:flex;flex-direction:column;gap:20px">

                        {{-- Order summary --}}
                        <div class="card">
                            <div class="card-header">
                                <div class="card-header-icon">
                                    <svg fill="none" stroke="#5D4037" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/>
                                    </svg>
                                </div>
                                <span class="card-header-title">Order Summary</span>
                            </div>
                            <div style="padding:0">
                                <div style="padding:16px 24px;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid #f5ede6">
                                    <span style="font-size:12px;color:#a07060">Order ID</span>
                                    <span style="font-family:monospace;font-size:12px;font-weight:700;color:#5D4037">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
                                </div>
                                <div style="padding:16px 24px;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid #f5ede6">
                                    <span style="font-size:12px;color:#a07060">Flavour</span>
                                    <span style="font-size:13px;font-weight:500;color:#3b2417">{{ $order->flavour }}</span>
                                </div>
                                <div style="padding:16px 24px;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid #f5ede6">
                                    <span style="font-size:12px;color:#a07060">Size</span>
                                    <span style="font-size:13px;font-weight:500;color:#3b2417">{{ $order->size }}</span>
                                </div>
                                <div style="padding:16px 24px;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid #f5ede6">
                                    <span style="font-size:12px;color:#a07060">Pickup / Delivery</span>
                                    <span style="font-size:13px;font-weight:500;color:#3b2417">{{ $order->pickup_delivery_date->format('d M Y') }}</span>
                                </div>
                                <div style="padding:16px 24px;display:flex;justify-content:space-between;align-items:center">
                                    <span style="font-size:12px;color:#a07060">Delivery Type</span>
                                    <span style="font-size:13px;font-weight:500;color:#3b2417">
                                        {{ ($order->delivery_type ?? 'self_pickup') === 'driver' ? '🚗 Driver' : '🏃 Self Pickup' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Timeline --}}
                        <div class="card">
                            <div class="card-header">
                                <div class="card-header-icon">
                                    <svg fill="none" stroke="#5D4037" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <span class="card-header-title">Timeline</span>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-dot"></div>
                                <div>
                                    <div class="timeline-label">Order submitted</div>
                                    <div class="timeline-value">{{ $order->created_at->format('d M Y, H:i') }}</div>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-dot" style="background:#EAD7C3"></div>
                                <div>
                                    <div class="timeline-label">Pickup / Delivery due</div>
                                    <div class="timeline-value">{{ $order->pickup_delivery_date->format('d M Y') }}</div>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-dot" style="background:#d9cdc4"></div>
                                <div>
                                    <div class="timeline-label">Last updated</div>
                                    <div class="timeline-value">{{ $order->updated_at->format('d M Y, H:i') }}</div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </main>

        <footer>{{ config('app.name') }} &copy; {{ now()->year }} · All rights reserved</footer>
    </div>

</div>
</body>
</html>
