<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Message #{{ str_pad($contactMessage->id, 4, '0', STR_PAD_LEFT) }} — {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    @include('partials.layout-styles')
    <style>
        .detail-grid { display: grid; grid-template-columns: 1fr 300px; gap: 20px; align-items: start; }
        @media(max-width:900px) { .detail-grid { grid-template-columns:1fr; } }
        .field-label { font-size:10px; text-transform:uppercase; letter-spacing:0.14em; font-weight:600; color:#a07060; margin-bottom:5px; }
        .field-value { font-size:14px; color:#3b2417; font-weight:500; line-height:1.6; }
        .msg-body { font-size:15px; color:#3b2417; line-height:1.8; white-space:pre-wrap; padding:24px; background:#fdf8f4; border-radius:12px; border:1px solid #EAD7C3; }
        .timeline-item { display:flex; gap:12px; padding:14px 24px; border-bottom:1px solid #f5ede6; }
        .timeline-item:last-child { border-bottom:none; }
        .timeline-dot { width:8px; height:8px; border-radius:50%; background:#5D4037; margin-top:5px; flex-shrink:0; }
        .reply-btn {
            display:inline-flex; align-items:center; gap:8px; text-decoration:none;
            background:#5D4037; color:#EAD7C3; font-size:13px; font-weight:600;
            padding:10px 20px; border-radius:10px; transition:background 0.15s;
        }
        .reply-btn:hover { background:#4a3028; }
    </style>
</head>
<body>
<div class="layout">

    @include('partials.sidebar')

    <div class="content">
        <header class="topbar">
            <div>
                <div class="topbar-title">Message Detail</div>
                <div class="topbar-sub">Full message from {{ $contactMessage->name }}</div>
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
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:28px;flex-wrap:wrap;gap:12px">
                    <div style="display:flex;align-items:center;gap:14px">
                        <a href="{{ route('contact.index') }}" class="back-btn">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                            Back
                        </a>
                        <div>
                            <div style="display:flex;align-items:center;gap:10px">
                                <span class="order-id" style="font-size:13px;padding:4px 12px">#{{ str_pad($contactMessage->id, 4, '0', STR_PAD_LEFT) }}</span>
                                <span style="font-family:'Playfair Display',serif;font-size:22px;color:#3b2417">{{ $contactMessage->subject }}</span>
                            </div>
                            <div style="font-size:12px;color:#a07060;margin-top:3px">Received {{ $contactMessage->created_at->format('D, d M Y \a\t H:i') }}</div>
                        </div>
                    </div>
                    <div style="display:flex;gap:10px;align-items:center">
                        <a href="mailto:{{ $contactMessage->email }}?subject=Re: {{ urlencode($contactMessage->subject) }}" class="reply-btn">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                            Reply via Email
                        </a>
                        <form action="{{ route('contact.destroy', $contactMessage) }}" method="POST" onsubmit="return confirm('Delete this message?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background:#fce4ec;color:#c62828;border:1px solid #f8bbd0;font-size:13px;font-weight:600;padding:10px 18px;border-radius:10px;cursor:pointer">Delete</button>
                        </form>
                    </div>
                </div>

                <div class="detail-grid">

                    {{-- Left — message --}}
                    <div style="display:flex;flex-direction:column;gap:20px">

                        {{-- Sender --}}
                        <div class="card">
                            <div style="display:flex;align-items:center;gap:16px;padding:20px 24px;border-bottom:1px solid #EAD7C3">
                                <div style="width:52px;height:52px;border-radius:50%;background:#5D4037;color:#EAD7C3;display:flex;align-items:center;justify-content:center;font-size:20px;font-weight:700;flex-shrink:0">
                                    {{ strtoupper(substr($contactMessage->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div style="font-family:'Playfair Display',serif;font-size:18px;color:#3b2417">{{ $contactMessage->name }}</div>
                                    <div style="font-size:12px;color:#a07060;margin-top:2px">{{ $contactMessage->email }}</div>
                                </div>
                            </div>
                            <div style="padding:20px 24px">
                                <div class="field-label">Subject</div>
                                <div class="field-value">{{ $contactMessage->subject }}</div>
                            </div>
                        </div>

                        {{-- Message body --}}
                        <div class="card">
                            <div class="card-header">
                                <div class="card-icon">
                                    <svg fill="none" stroke="#5D4037" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                                </div>
                                <span class="card-title">Message</span>
                            </div>
                            <div style="padding:24px">
                                <div class="msg-body">{{ $contactMessage->message }}</div>
                            </div>
                        </div>

                    </div>

                    {{-- Right --}}
                    <div style="display:flex;flex-direction:column;gap:20px">

                        {{-- Info card --}}
                        <div class="card">
                            <div class="card-header">
                                <div class="card-icon">
                                    <svg fill="none" stroke="#5D4037" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <span class="card-title">Details</span>
                            </div>
                            <div style="padding:0">
                                <div style="padding:14px 24px;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid #f5ede6">
                                    <span style="font-size:12px;color:#a07060">Status</span>
                                    @if ($contactMessage->is_read)
                                        <span class="chip chip-dark">Read</span>
                                    @else
                                        <span class="chip chip-brown" style="background:#fdf0e6;color:#d4874e;border-color:#f5d5be">Unread</span>
                                    @endif
                                </div>
                                <div style="padding:14px 24px;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid #f5ede6">
                                    <span style="font-size:12px;color:#a07060">Message ID</span>
                                    <span style="font-family:monospace;font-size:12px;font-weight:700;color:#5D4037">#{{ str_pad($contactMessage->id, 4, '0', STR_PAD_LEFT) }}</span>
                                </div>
                                <div style="padding:14px 24px;display:flex;justify-content:space-between;align-items:center">
                                    <span style="font-size:12px;color:#a07060">Received</span>
                                    <span style="font-size:12px;font-weight:500;color:#3b2417">{{ $contactMessage->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
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
                                    <div style="font-size:12px;color:#a07060">Message received</div>
                                    <div style="font-size:13px;font-weight:500;color:#3b2417;margin-top:1px">{{ $contactMessage->created_at->format('d M Y, H:i') }}</div>
                                </div>
                            </div>
                            @if ($contactMessage->is_read)
                                <div class="timeline-item">
                                    <div class="timeline-dot" style="background:#EAD7C3"></div>
                                    <div>
                                        <div style="font-size:12px;color:#a07060">Marked as read</div>
                                        <div style="font-size:13px;font-weight:500;color:#3b2417;margin-top:1px">{{ $contactMessage->updated_at->format('d M Y, H:i') }}</div>
                                    </div>
                                </div>
                            @endif
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
