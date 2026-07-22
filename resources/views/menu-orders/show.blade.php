<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Menu Order #{{ str_pad($menuOrder->id, 4, '0', STR_PAD_LEFT) }} — {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    @include('partials.layout-styles')
    <style>
        .detail-grid { display: grid; grid-template-columns: 1fr 320px; gap: 20px; align-items: start; }
        @media(max-width:900px) { .detail-grid { grid-template-columns: 1fr; } }
        .field-row { margin-bottom: 18px; }
        .field-row:last-child { margin-bottom: 0; }
        .field-label { font-size: 10px; text-transform: uppercase; letter-spacing: 0.14em; font-weight: 600; color: #a07060; margin-bottom: 5px; }
        .field-value { font-size: 14px; color: #3b2417; font-weight: 500; line-height: 1.5; }
        .field-value.muted { color: #c9b4a3; font-weight: 400; font-style: italic; }
        .field-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
        .cust-hero { display: flex; align-items: center; gap: 16px; padding: 20px 24px; border-bottom: 1px solid #EAD7C3; }
        .cust-hero-avatar { width: 52px; height: 52px; border-radius: 50%; background: #5D4037; color: #EAD7C3; display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: 700; flex-shrink: 0; }
        .timeline-item { display: flex; gap: 12px; padding: 14px 24px; border-bottom: 1px solid #f5ede6; }
        .timeline-item:last-child { border-bottom: none; }
        .timeline-dot { width: 8px; height: 8px; border-radius: 50%; background: #5D4037; margin-top: 5px; flex-shrink: 0; }
        .item-img { width: 100%; height: 180px; object-fit: cover; display: block; }
        .item-img-placeholder { width: 100%; height: 180px; background: #f5ede6; display: flex; align-items: center; justify-content: center; font-size: 52px; }
        .price-tag { font-family: 'Playfair Display', serif; font-size: 28px; font-weight: 700; color: #5D4037; }
    </style>
</head>
<body>
<div class="layout">

    @include('partials.sidebar')

    <div class="content">
        <header class="topbar">
            <div>
                <div class="topbar-title">Order Detail</div>
                <div class="topbar-sub">Full breakdown of this menu order</div>
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
                <div style="display:flex;align-items:center;gap:14px;margin-bottom:28px;flex-wrap:wrap">
                    <a href="{{ route('menu-orders.index') }}" class="back-btn">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                        Back
                    </a>
                    <div>
                        <div style="display:flex;align-items:center;gap:10px">
                            <span class="order-id" style="font-size:13px;padding:4px 12px">#{{ str_pad($menuOrder->id, 4, '0', STR_PAD_LEFT) }}</span>
                            <span style="font-family:'Playfair Display',serif;font-size:24px;color:#3b2417">{{ $menuOrder->name }}'s Order</span>
                        </div>
                        <div style="font-size:12px;color:#a07060;margin-top:3px">Submitted {{ $menuOrder->created_at->format('D, d M Y \a\t H:i') }}</div>
                    </div>
                </div>

                <div class="detail-grid">

                    {{-- Left --}}
                    <div style="display:flex;flex-direction:column;gap:20px">

                        {{-- Customer card --}}
                        <div class="card">
                            <div class="cust-hero">
                                <div class="cust-hero-avatar">{{ strtoupper(substr($menuOrder->name, 0, 1)) }}</div>
                                <div>
                                    <div style="font-family:'Playfair Display',serif;font-size:18px;color:#3b2417">{{ $menuOrder->name }}</div>
                                    <div style="font-size:12px;color:#a07060;margin-top:2px">{{ $menuOrder->email }}</div>
                                </div>
                            </div>
                            <div style="padding:24px">
                                <div class="field-grid-2">
                                    <div class="field-row" style="margin-bottom:0">
                                        <div class="field-label">Phone</div>
                                        <div class="field-value">{{ $menuOrder->phone }}</div>
                                    </div>
                                    <div class="field-row" style="margin-bottom:0">
                                        <div class="field-label">Pickup / Delivery</div>
                                        <div class="field-value">{{ $menuOrder->pickup_delivery_date->format('D, d M Y') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Order details card --}}
                        <div class="card">
                            <div class="card-header">
                                <div class="card-icon">
                                    <svg fill="none" stroke="#5D4037" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/></svg>
                                </div>
                                <span class="card-title">Order Details</span>
                            </div>
                            <div style="padding:24px">
                                <div class="field-grid-2" style="margin-bottom:18px">
                                    <div class="field-row" style="margin-bottom:0">
                                        <div class="field-label">Size</div>
                                        <span class="chip chip-dark" style="margin-top:4px;display:inline-flex">{{ $menuOrder->size }}</span>
                                    </div>
                                    <div class="field-row" style="margin-bottom:0">
                                        <div class="field-label">Delivery Type</div>
                                        @if ($menuOrder->delivery_type === 'driver')
                                            <span class="chip chip-brown" style="margin-top:4px;display:inline-flex">🚗 Driver Delivery</span>
                                        @else
                                            <span class="chip chip-dark" style="margin-top:4px;display:inline-flex">🏃 Self Pickup</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="field-grid-2" style="margin-bottom:18px">
                                    <div class="field-row" style="margin-bottom:0">
                                        <div class="field-label">Total Price</div>
                                        <div class="price-tag">ETB {{ number_format($menuOrder->total_price, 2) }}</div>
                                    </div>
                                </div>

                                {{-- Delivery address + map for driver orders --}}
                                @if ($menuOrder->delivery_type === 'driver')
                                    <hr style="border:none;border-top:1px solid #EAD7C3;margin-bottom:18px">
                                    <div class="field-row">
                                        <div class="field-label">Delivery Address</div>
                                        @if ($menuOrder->delivery_address)
                                            <div class="field-value" style="display:flex;align-items:flex-start;gap:8px">
                                                <svg fill="none" stroke="#5D4037" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;flex-shrink:0;margin-top:2px"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                                {{ $menuOrder->delivery_address }}
                                            </div>
                                            {{-- Google Maps embed by address (no API key needed) --}}
                                            <div style="margin-top:14px;border-radius:12px;overflow:hidden;border:1px solid #EAD7C3">
                                                <iframe
                                                    width="100%"
                                                    height="280"
                                                    frameborder="0"
                                                    style="display:block"
                                                    referrerpolicy="no-referrer-when-downgrade"
                                                    src="https://maps.google.com/maps?q={{ urlencode($menuOrder->delivery_address) }}&output=embed&z=15"
                                                    allowfullscreen
                                                ></iframe>
                                            </div>
                                            <a
                                                href="https://www.google.com/maps/search/?api=1&query={{ urlencode($menuOrder->delivery_address) }}"
                                                target="_blank"
                                                style="display:inline-flex;align-items:center;gap:6px;margin-top:10px;font-size:12px;color:#5D4037;font-weight:600;text-decoration:none;padding:6px 14px;background:#f5ede6;border:1px solid #EAD7C3;border-radius:8px"
                                            >
                                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:13px;height:13px"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                                Open in Google Maps
                                            </a>
                                        @else
                                            <div class="field-value muted">No address provided</div>
                                        @endif
                                    </div>
                                @else
                                    {{-- Self pickup — show bakery location --}}
                                    <hr style="border:none;border-top:1px solid #EAD7C3;margin-bottom:18px">
                                    <div class="field-row">
                                        <div class="field-label">Pickup Location</div>
                                        <div class="field-value" style="display:flex;align-items:flex-start;gap:8px;margin-bottom:14px">
                                            <svg fill="none" stroke="#5D4037" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;flex-shrink:0;margin-top:2px"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            Bole Welo Sefer, Addis Ababa
                                        </div>
                                        <div style="border-radius:12px;overflow:hidden;border:1px solid #EAD7C3">
                                            <iframe
                                                width="100%"
                                                height="280"
                                                frameborder="0"
                                                style="display:block"
                                                referrerpolicy="no-referrer-when-downgrade"
                                                src="https://maps.google.com/maps?q=Bole+Welo+Sefer,+Addis+Ababa,+Ethiopia&output=embed&z=16"
                                                allowfullscreen
                                            ></iframe>
                                        </div>
                                        <a
                                            href="https://www.google.com/maps/dir/?api=1&destination=Bole+Welo+Sefer,+Addis+Ababa,+Ethiopia"
                                            target="_blank"
                                            style="display:inline-flex;align-items:center;gap:6px;margin-top:10px;font-size:12px;color:#5D4037;font-weight:600;text-decoration:none;padding:6px 14px;background:#f5ede6;border:1px solid #EAD7C3;border-radius:8px"
                                        >
                                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:13px;height:13px"><path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                                            Get Directions
                                        </a>
                                    </div>
                                @endif
                                <hr style="border:none;border-top:1px solid #EAD7C3;margin-bottom:18px">
                                <div class="field-row">
                                    <div class="field-label">Allergies</div>
                                    @if ($menuOrder->allergies)
                                        <div class="field-value">{{ $menuOrder->allergies }}</div>
                                    @else
                                        <div class="field-value muted">None specified</div>
                                    @endif
                                </div>
                                <div class="field-row">
                                    <div class="field-label">Additional Notes</div>
                                    @if ($menuOrder->additional_notes)
                                        <div class="field-value">{{ $menuOrder->additional_notes }}</div>
                                    @else
                                        <div class="field-value muted">No additional notes</div>
                                    @endif
                                </div>
                                <hr style="border:none;border-top:1px solid #EAD7C3;margin:18px 0">
                                <div class="field-row" style="margin-bottom:0">
                                    <div class="field-label">Order Action / Status</div>
                                    <div style="display:flex;align-items:center;gap:12px;margin-top:8px;flex-wrap:wrap">
                                        @if ($menuOrder->status === 'preparing')
                                            <span class="chip" style="background:#ede9fe;color:#5b21b6;border:1px solid #c4b5fd;font-size:13px;padding:6px 14px">👩‍🍳 Preparing</span>
                                        @elseif ($menuOrder->status === 'ready')
                                            <span class="chip" style="background:#ccfbf1;color:#0f766e;border:1px solid #99f6e4;font-size:13px;padding:6px 14px">✨ Ready</span>
                                        @elseif ($menuOrder->status === 'completed')
                                            <span class="chip" style="background:#d1fae5;color:#065f46;border:1px solid #6ee7b7;font-size:13px;padding:6px 14px">🎉 Completed</span>
                                        @elseif ($menuOrder->status === 'cancelled')
                                            <span class="chip" style="background:#fee2e2;color:#991b1b;border:1px solid #fca5a5;font-size:13px;padding:6px 14px">❌ Cancelled</span>
                                        @else
                                            <span class="chip" style="background:#fff3cd;color:#856404;border:1px solid #fde68a;font-size:13px;padding:6px 14px">⏳ {{ ucfirst($menuOrder->status ?? 'pending') }}</span>
                                        @endif

                                        <form method="POST" action="{{ route('menu-orders.update-status', $menuOrder) }}" style="display:inline-flex;gap:10px;flex-wrap:wrap">
                                            @csrf
                                            @if ($menuOrder->status === 'pending' || empty($menuOrder->status))
                                                <button type="submit" name="status" value="preparing" style="background:#059669;color:#fff;border:none;padding:8px 18px;border-radius:8px;cursor:pointer;font-weight:600;font-size:13px;display:inline-flex;align-items:center;gap:6px">
                                                    ✓ Accept Order
                                                </button>
                                                <button type="submit" name="status" value="cancelled" style="background:#dc2626;color:#fff;border:none;padding:8px 18px;border-radius:8px;cursor:pointer;font-weight:600;font-size:13px;display:inline-flex;align-items:center;gap:6px">
                                                    ✕ Reject Order
                                                </button>
                                            @elseif ($menuOrder->status === 'preparing')
                                                <button type="submit" name="status" value="ready" style="background:#0D9488;color:#fff;border:none;padding:8px 18px;border-radius:8px;cursor:pointer;font-weight:600;font-size:13px;display:inline-flex;align-items:center;gap:6px">
                                                    ✨ Mark as Ready
                                                </button>
                                            @elseif ($menuOrder->status === 'ready')
                                                <button type="submit" name="status" value="completed" style="background:#059669;color:#fff;border:none;padding:8px 18px;border-radius:8px;cursor:pointer;font-weight:600;font-size:13px;display:inline-flex;align-items:center;gap:6px">
                                                    🎉 Mark as Completed
                                                </button>
                                            @endif
                                        </form>
                                    </div>
                                </div>
                                @if ($menuOrder->rating || $menuOrder->feedback)
                                    <hr class="divider" style="margin:20px 0">
                                    <div class="field-row" style="margin-bottom:0">
                                        <div class="field-label">Customer Rating & Review</div>
                                        <div style="background:#fdf8f4;padding:14px 16px;border-radius:12px;border:1px solid #EAD7C3;margin-top:6px">
                                            @if ($menuOrder->rating)
                                                <div style="font-size:16px;color:#f59e0b;margin-bottom:4px">
                                                    {{ str_repeat('⭐', $menuOrder->rating) }}
                                                    <span style="font-size:13px;font-weight:700;color:#5D4037;margin-left:6px">{{ $menuOrder->rating }} / 5</span>
                                                </div>
                                            @endif
                                            @if ($menuOrder->feedback)
                                                <div style="font-size:13px;color:#3b2417;font-style:italic">"{{ $menuOrder->feedback }}"</div>
                                            @else
                                                <div style="font-size:12px;color:#a07060">No written feedback provided.</div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>

                    {{-- Right --}}
                    <div style="display:flex;flex-direction:column;gap:20px">

                        {{-- Item ordered --}}
                        <div class="card">
                            <div class="card-header">
                                <div class="card-icon">🎂</div>
                                <span class="card-title">Item Ordered</span>
                            </div>
                            @if ($menuOrder->menuItem)
                                @if ($menuOrder->menuItem->image)
                                    <img src="{{ asset('storage/'.$menuOrder->menuItem->image) }}" class="item-img" alt="{{ $menuOrder->menuItem->title }}">
                                @else
                                    <div class="item-img-placeholder">🎂</div>
                                @endif
                                <div style="padding:16px 20px">
                                    <div style="font-family:'Playfair Display',serif;font-size:17px;color:#3b2417;margin-bottom:4px">{{ $menuOrder->menuItem->title }}</div>
                                    <div style="font-size:16px;font-weight:700;color:#5D4037">
                                        ETB {{ number_format($menuOrder->total_price, 2) }}
                                        <span style="color:#a07060;font-weight:500;font-size:14px;margin-left:6px">(Quantity: {{ $menuOrder->quantity }})</span>
                                    </div>
                                </div>
                            @else
                                <div style="padding:24px;color:#a07060;font-size:13px">Item no longer available</div>
                            @endif
                        </div>

                        {{-- Timeline --}}
                        <div class="card">
                            <div class="card-header">
                                <div class="card-icon">
                                    <svg fill="none" stroke="#5D4037" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <span class="card-title">Timeline</span>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-dot"></div>
                                <div>
                                    <div style="font-size:12px;color:#a07060">Order placed</div>
                                    <div style="font-size:13px;font-weight:500;color:#3b2417;margin-top:1px">{{ $menuOrder->created_at->format('d M Y, H:i') }}</div>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-dot" style="background:#EAD7C3"></div>
                                <div>
                                    <div style="font-size:12px;color:#a07060">Pickup / Delivery due</div>
                                    <div style="font-size:13px;font-weight:500;color:#3b2417;margin-top:1px">{{ $menuOrder->pickup_delivery_date->format('d M Y') }}</div>
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
