<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Messages — {{ config('app.name') }}</title>
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
                <div class="topbar-title">Messages</div>
                <div class="topbar-sub">Contact messages from your website</div>
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

                {{-- Stats --}}
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <svg fill="none" stroke="#5D4037" stroke-width="2" viewBox="0 0 24 24" style="width:18px;height:18px"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <div class="stat-number">{{ $messages->total() }}</div>
                        <div class="stat-label">Total Messages</div>
                    </div>
                    <div class="stat-card dark">
                        <div class="stat-icon">
                            <svg fill="none" stroke="#EAD7C3" stroke-width="2" viewBox="0 0 24 24" style="width:18px;height:18px"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        </div>
                        <div class="stat-number">{{ \App\Models\ContactMessage::where('is_read', false)->count() }}</div>
                        <div class="stat-label">Unread</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <svg fill="none" stroke="#5D4037" stroke-width="2" viewBox="0 0 24 24" style="width:18px;height:18px"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="stat-number">{{ \App\Models\ContactMessage::where('is_read', true)->count() }}</div>
                        <div class="stat-label">Read</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <svg fill="none" stroke="#5D4037" stroke-width="2" viewBox="0 0 24 24" style="width:18px;height:18px"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div class="stat-number">{{ \App\Models\ContactMessage::whereDate('created_at', today())->count() }}</div>
                        <div class="stat-label">Today</div>
                    </div>
                </div>

                {{-- Table --}}
                <div class="table-card">
                    <div class="table-card-header">
                        <div>
                            <div style="font-family:'Playfair Display',serif;font-size:17px;color:#3b2417">All Messages</div>
                            <div style="font-size:12px;color:#a07060;margin-top:2px">
                                Showing {{ $messages->firstItem() ?? 0 }}–{{ $messages->lastItem() ?? 0 }} of {{ $messages->total() }}
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

                    @if ($messages->isEmpty())
                        <div class="empty">
                            <div style="font-size:52px;margin-bottom:16px">✉️</div>
                            <div style="font-family:'Playfair Display',serif;font-size:20px;color:#3b2417">No messages yet</div>
                            <div style="font-size:13px;color:#a07060;margin-top:6px">Contact form submissions will appear here.</div>
                        </div>
                    @else
                        <div class="table-wrap">
                            <table>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>From</th>
                                        <th>Subject</th>
                                        <th>Preview</th>
                                        <th>Status</th>
                                        <th>Received</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($messages as $msg)
                                        <tr onclick="window.location='{{ route('contact.show', $msg) }}'" style="{{ !$msg->is_read ? 'background:#fffbf8' : '' }}">
                                            <td><span class="order-id">#{{ str_pad($msg->id, 4, '0', STR_PAD_LEFT) }}</span></td>
                                            <td>
                                                <div style="display:flex;align-items:center;gap:10px">
                                                    <div class="cust-avatar">{{ strtoupper(substr($msg->name, 0, 1)) }}</div>
                                                    <div>
                                                        <div style="font-weight:{{ !$msg->is_read ? '700' : '500' }};color:#3b2417">{{ $msg->name }}</div>
                                                        <div style="font-size:11px;color:#a07060">{{ $msg->email }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="font-weight:{{ !$msg->is_read ? '600' : '400' }};color:#3b2417;max-width:180px">
                                                {{ $msg->subject }}
                                            </td>
                                            <td style="max-width:200px;color:#6b4a30">
                                                <span style="display:block;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                                                    {{ Str::limit($msg->message, 60) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($msg->is_read)
                                                    <span class="chip chip-dark">Read</span>
                                                @else
                                                    <span class="chip chip-brown" style="background:#fdf0e6;color:#d4874e;border-color:#f5d5be">Unread</span>
                                                @endif
                                            </td>
                                            <td style="white-space:nowrap">
                                                <div style="font-size:12px;font-weight:500;color:#4a3020">{{ $msg->created_at->format('d M Y') }}</div>
                                                <div style="font-size:11px;color:#a07060">{{ $msg->created_at->format('H:i') }}</div>
                                            </td>
                                            <td onclick="event.stopPropagation()">
                                                <form action="{{ route('contact.destroy', $msg) }}" method="POST" onsubmit="return confirm('Delete this message?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" style="background:#fce4ec;color:#c62828;border:1px solid #f8bbd0;font-size:11px;font-weight:600;padding:4px 10px;border-radius:8px;cursor:pointer">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if ($messages->hasPages())
                            <div style="padding:14px 20px;border-top:1px solid #EAD7C3;background:#fdf8f4">{{ $messages->links() }}</div>
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
