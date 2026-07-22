<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Custom Orders — {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    @include('partials.layout-styles')
</head>
<body>
<div class="layout">

    @include('partials.sidebar')

    <div class="content">
        <header class="topbar">
            <div>
                <div class="topbar-title">Custom Orders</div>
                <div class="topbar-sub">Custom cake orders placed by customers</div>
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

                {{-- Stats --}}
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <svg fill="none" stroke="#5D4037" stroke-width="2" viewBox="0 0 24 24" style="width:18px;height:18px"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/></svg>
                        </div>
                        <div class="stat-number">{{ $orders->total() }}</div>
                        <div class="stat-label">Total Orders</div>
                    </div>
                    <div class="stat-card dark">
                        <div class="stat-icon">
                            <svg fill="none" stroke="#EAD7C3" stroke-width="2" viewBox="0 0 24 24" style="width:18px;height:18px"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div class="stat-number">{{ \App\Models\CakeOrder::whereDate('created_at', today())->count() }}</div>
                        <div class="stat-label">Today</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <svg fill="none" stroke="#5D4037" stroke-width="2" viewBox="0 0 24 24" style="width:18px;height:18px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="stat-number">{{ \App\Models\CakeOrder::where('status', 'pending')->count() }}</div>
                        <div class="stat-label">Pending</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <svg fill="none" stroke="#5D4037" stroke-width="2" viewBox="0 0 24 24" style="width:18px;height:18px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="stat-number" style="font-size:22px">
                            ETB {{ number_format(\App\Models\CakeOrder::whereMonth('created_at', now()->month)->whereNotNull('price')->sum('price'), 2) }}
                        </div>
                        <div class="stat-label">Revenue This Month</div>
                    </div>
                </div>

                {{-- Table --}}
                <div class="table-card">
                    <div class="table-card-header">
                        <div>
                            <div style="font-family:'Playfair Display',serif;font-size:17px;color:#3b2417">All Custom Orders</div>
                            <div style="font-size:12px;color:#a07060;margin-top:2px">
                                Showing {{ $orders->firstItem() ?? 0 }}–{{ $orders->lastItem() ?? 0 }} of {{ $orders->total() }}
                            </div>
                        </div>
                        <div style="display:flex;align-items:center;gap:16px">
                            <form method="GET" action="{{ url()->current() }}" style="display:flex;gap:8px">
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name, email, phone…" style="padding:6px 12px;border-radius:6px;border:1px solid #EAD7C3;font-size:13px;outline:none;">
                                <button type="submit" style="background:#5D4037;color:#fff;border:none;padding:6px 12px;border-radius:6px;cursor:pointer;font-size:13px;font-weight:500;">Filter</button>
                                @if (request('search'))
                                    <a href="{{ url()->current() }}" style="display:flex;align-items:center;padding:6px 12px;color:#a07060;text-decoration:none;font-size:13px;font-weight:500;">Clear</a>
                                @endif
                            </form>
                        </div>
                    </div>

                    @if ($orders->isEmpty())
                        <div class="empty">
                            <div style="font-size:52px;margin-bottom:16px">🎂</div>
                            <div style="font-family:'Playfair Display',serif;font-size:20px;color:#3b2417">No custom orders yet</div>
                            <div style="font-size:13px;color:#a07060;margin-top:6px">Custom cake orders placed by customers will appear here.</div>
                        </div>
                    @else
                        <div class="table-wrap">
                            <table>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Customer</th>
                                        <th>Flavour</th>
                                        <th>Size</th>
                                        <th>Phone</th>
                                        <th>Pickup / Delivery</th>
                                        <th>Delivery Type</th>
                                        <th>Status</th>
                                        <th>Price</th>
                                        <th>Submitted</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr onclick="window.location='{{ route('custom-orders.show', $order) }}'" style="cursor:pointer">
                                            <td><span class="order-id">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span></td>
                                            <td>
                                                <div style="display:flex;align-items:center;gap:10px">
                                                    <div class="cust-avatar">{{ strtoupper(substr($order->name, 0, 1)) }}</div>
                                                    <div>
                                                        <div style="font-weight:600;color:#3b2417">{{ $order->name }}</div>
                                                        <div style="font-size:11px;color:#a07060">{{ $order->email }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span style="display:inline-flex;align-items:center;gap:4px">
                                                    🎂 {{ $order->flavour }}
                                                </span>
                                            </td>
                                            <td><span class="chip chip-dark">{{ $order->size }}</span></td>
                                            <td>{{ $order->phone }}</td>
                                            <td style="white-space:nowrap">
                                                <div style="display:flex;align-items:center;gap:6px">
                                                    <svg fill="none" stroke="#5D4037" stroke-width="2" viewBox="0 0 24 24" style="width:12px;height:12px;flex-shrink:0"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                    {{ $order->pickup_delivery_date->format('d M Y') }}
                                                </div>
                                            </td>
                                            <td>
                                                @if ($order->delivery_type === 'driver')
                                                    <span class="chip chip-brown">🚗 Driver</span>
                                                @else
                                                    <span class="chip chip-dark">🏃 Self Pickup</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($order->status === 'pending')
                                                    <span class="chip" style="background:#fff3cd;color:#856404;border:1px solid #fde68a">⏳ Pending</span>
                                                @elseif ($order->status === 'preparing')
                                                    <span class="chip" style="background:#ede9fe;color:#5b21b6;border:1px solid #c4b5fd">👩‍🍳 Preparing</span>
                                                @elseif ($order->status === 'ready')
                                                    <span class="chip" style="background:#ccfbf1;color:#0f766e;border:1px solid #99f6e4">✨ Ready</span>
                                                @elseif ($order->status === 'confirmed')
                                                    <span class="chip" style="background:#d1fae5;color:#065f46;border:1px solid #6ee7b7">✅ Confirmed</span>
                                                @elseif ($order->status === 'completed')
                                                    <span class="chip" style="background:#ede9fe;color:#5b21b6;border:1px solid #c4b5fd">🎉 Completed</span>
                                                @elseif ($order->status === 'cancelled')
                                                    <span class="chip" style="background:#fee2e2;color:#991b1b;border:1px solid #fca5a5">❌ Cancelled</span>
                                                @else
                                                    <span class="chip chip-dark">{{ ucfirst($order->status) }}</span>
                                                @endif
                                            </td>
                                            <td style="font-weight:700;color:#5D4037;white-space:nowrap">
                                                @if ($order->price !== null)
                                                    ETB {{ number_format($order->price, 2) }}
                                                @else
                                                    <span style="color:#c9b4a3;font-weight:400;font-style:italic">TBD</span>
                                                @endif
                                            </td>
                                            <td style="white-space:nowrap">
                                                <div style="font-size:12px;font-weight:500;color:#4a3020">{{ $order->created_at->format('d M Y') }}</div>
                                                <div style="font-size:11px;color:#a07060">{{ $order->created_at->format('H:i') }}</div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if ($orders->hasPages())
                            <div style="padding:14px 20px;border-top:1px solid #EAD7C3;background:#fdf8f4">{{ $orders->links() }}</div>
                        @endif
                    @endif
                </div>

            </div>
        </main>

        <footer>{{ config('app.name') }} &copy; {{ now()->year }} · All rights reserved</footer>
    </div>

</div>
</body>
</html>
