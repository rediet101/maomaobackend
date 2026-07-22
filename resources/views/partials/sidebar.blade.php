<aside class="sidebar">
    <div class="sidebar-logo">
        @if (file_exists(public_path('maologo4.png')))
            <img src="/maologo4.png" alt="{{ config('app.name') }}">
        @elseif (file_exists(public_path('logo.png')))
            <img src="/logo.png" alt="{{ config('app.name') }}">
        @elseif (file_exists(public_path('logo.jpg')))
            <img src="/logo.jpg" alt="{{ config('app.name') }}">
        @else
            <div class="sidebar-logo-placeholder">🎂</div>
        @endif
        <div>
            <div class="sidebar-brand-name">MaoMao</div>
            <div class="sidebar-brand-sub">Bakery</div>
        </div>
    </div>
    <nav class="sidebar-nav">
        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard', 'orders.show') ? 'nav-item-active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;flex-shrink:0">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h3a1 1 0 011 1v6a1 1 0 01-1 1h-3a1 1 0 01-1-1v-6z"/>
            </svg>
            Dashboard
        </a>
        <a href="{{ route('custom-orders.index') }}" class="nav-item {{ request()->routeIs('custom-orders.*') ? 'nav-item-active' : '' }}" style="margin-top:4px">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;flex-shrink:0">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/>
            </svg>
            Custom Orders
            @php $pending = \App\Models\CakeOrder::where('status', 'pending')->count(); @endphp
            @if ($pending > 0)
                <span style="margin-left:auto;background:#d4874e;color:#fff;font-size:10px;font-weight:700;padding:1px 7px;border-radius:999px">{{ $pending }}</span>
            @endif
        </a>
        <a href="{{ route('menu-orders.index') }}" class="nav-item {{ request()->routeIs('menu-orders.*') ? 'nav-item-active' : '' }}" style="margin-top:4px">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;flex-shrink:0">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            Menu Orders
        </a>
        <a href="{{ route('menu.index') }}" class="nav-item {{ request()->routeIs('menu.*') ? 'nav-item-active' : '' }}" style="margin-top:4px">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;flex-shrink:0">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
            </svg>
            Menu
        </a>
        <a href="{{ route('contact.index') }}" class="nav-item {{ request()->routeIs('contact.*') ? 'nav-item-active' : '' }}" style="margin-top:4px;position:relative">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;flex-shrink:0">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            Messages
            @php $unread = \App\Models\ContactMessage::where('is_read', false)->count(); @endphp
            @if ($unread > 0)
                <span style="margin-left:auto;background:#d4874e;color:#fff;font-size:10px;font-weight:700;padding:1px 7px;border-radius:999px">{{ $unread }}</span>
            @endif
        </a>
        <a href="{{ route('app-users.index') }}" class="nav-item {{ request()->routeIs('app-users.*') ? 'nav-item-active' : '' }}" style="margin-top:4px">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;flex-shrink:0">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            App Users
        </a>
        <a href="{{ route('profile.show') }}" class="nav-item {{ request()->routeIs('profile.*') ? 'nav-item-active' : '' }}" style="margin-top:4px">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;flex-shrink:0">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            Profile
        </a>
    </nav>
    <div style="padding:16px 24px 0; border-top:1px solid rgba(255,255,255,0.08)">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nav-item" style="width:100%; border:none; background:rgba(234,215,195,0.08); text-align:left; cursor:pointer; font-family:inherit">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;flex-shrink:0">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Logout
            </button>
        </form>
    </div>
    <div class="sidebar-footer" style="border-top:none">{{ now()->format('l, d M Y') }}</div>
</aside>
