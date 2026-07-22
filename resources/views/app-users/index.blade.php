<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>App Users — {{ config('app.name') }}</title>
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
                <div class="topbar-title">App Users</div>
                <div class="topbar-sub">Everyone who has logged into the app</div>
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
                            <svg fill="none" stroke="#5D4037" stroke-width="2" viewBox="0 0 24 24" style="width:18px;height:18px"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div class="stat-number">{{ $users->total() }}</div>
                        <div class="stat-label">Total Users</div>
                    </div>
                    <div class="stat-card dark">
                        <div class="stat-icon">
                            <svg fill="none" stroke="#EAD7C3" stroke-width="2" viewBox="0 0 24 24" style="width:18px;height:18px"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div class="stat-number">{{ \App\Models\AppUser::whereDate('created_at', today())->count() }}</div>
                        <div class="stat-label">New Today</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <svg fill="none" stroke="#5D4037" stroke-width="2" viewBox="0 0 24 24" style="width:18px;height:18px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="stat-number">{{ \App\Models\AppUser::whereDate('last_seen_at', today())->count() }}</div>
                        <div class="stat-label">Active Today</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <svg fill="none" stroke="#5D4037" stroke-width="2" viewBox="0 0 24 24" style="width:18px;height:18px"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                        </div>
                        <div class="stat-number">{{ \App\Models\AppUser::whereMonth('created_at', now()->month)->count() }}</div>
                        <div class="stat-label">This Month</div>
                    </div>
                </div>

                {{-- Table --}}
                <div class="table-card" style="margin-top:24px">
                    <div class="table-card-header">
                        <div>
                            <div style="font-family:'Playfair Display',serif;font-size:17px;color:#3b2417">All Users</div>
                            <div style="font-size:12px;color:#a07060;margin-top:2px">
                                Showing {{ $users->firstItem() ?? 0 }}–{{ $users->lastItem() ?? 0 }} of {{ $users->total() }}
                            </div>
                        </div>
                        <div style="display:flex; align-items:center; gap:16px;">
                            <form method="GET" action="{{ url()->current() }}" style="display:flex; gap:8px;">
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..." style="padding:6px 12px; border-radius:6px; border:1px solid #EAD7C3; font-size:13px; outline:none;">
                                <button type="submit" style="background:#5D4037; color:#fff; border:none; padding:6px 12px; border-radius:6px; cursor:pointer; font-size:13px; font-weight:500;">Filter</button>
                                @if(request('search'))
                                    <a href="{{ url()->current() }}" style="display:flex; align-items:center; padding:6px 12px; color:#a07060; text-decoration:none; font-size:13px; font-weight:500;">Clear</a>
                                @endif
                            </form>

                        </div>
                    </div>

                    @if ($users->isEmpty())
                        <div class="empty">
                            <div style="font-size:52px;margin-bottom:16px">👤</div>
                            <div style="font-family:'Playfair Display',serif;font-size:20px;color:#3b2417">No users yet</div>
                            <div style="font-size:13px;color:#a07060;margin-top:6px">Users will appear here once they log into the app.</div>
                        </div>
                    @else
                        <div class="table-wrap">
                            <table>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Last Seen</th>
                                        <th>Joined</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr style="cursor:default">
                                            <td><span class="order-id">#{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</span></td>
                                            <td>
                                                <div style="display:flex;align-items:center;gap:10px">
                                                    @if ($user->avatar)
                                                        <img src="{{ asset('storage/'.$user->avatar) }}" style="width:32px;height:32px;border-radius:50%;object-fit:cover;flex-shrink:0;border:2px solid #EAD7C3">
                                                    @else
                                                        <div class="cust-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                                                    @endif
                                                    <div style="font-weight:600;color:#3b2417">{{ $user->name }}</div>
                                                </div>
                                            </td>
                                            <td style="color:#4a3020">{{ $user->phone }}</td>
                                            <td>
                                                @if ($user->last_seen_at)
                                                    <div style="font-size:12px;font-weight:500;color:#4a3020">{{ $user->last_seen_at->format('d M Y') }}</div>
                                                    <div style="font-size:11px;color:#a07060">{{ $user->last_seen_at->diffForHumans() }}</div>
                                                @else
                                                    <span class="muted">—</span>
                                                @endif
                                            </td>
                                            <td style="white-space:nowrap">
                                                <div style="font-size:12px;font-weight:500;color:#4a3020">{{ $user->created_at->format('d M Y') }}</div>
                                                <div style="font-size:11px;color:#a07060">{{ $user->created_at->format('H:i') }}</div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if ($users->hasPages())
                            <div style="padding:14px 20px;border-top:1px solid #EAD7C3;background:#fdf8f4">{{ $users->links() }}</div>
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
