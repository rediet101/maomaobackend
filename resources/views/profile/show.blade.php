<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile — {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    @include('partials.layout-styles')
    <style>
        .form-card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #EAD7C3;
            overflow: hidden;
            max-width: 600px;
            margin-top: 24px;
        }
        .form-body {
            padding: 24px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group:last-child {
            margin-bottom: 0;
        }
        .form-group label {
            display: block;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            font-weight: 600;
            color: #a07060;
            margin-bottom: 8px;
        }
        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #EAD7C3;
            border-radius: 8px;
            font-size: 13px;
            color: #3b2417;
            outline: none;
            background: #fff;
            box-sizing: border-box;
        }
        .form-control:focus {
            border-color: #5D4037;
        }
        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #5D4037;
            color: #EAD7C3;
            font-size: 13px;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            transition: background 0.15s;
        }
        .btn-primary:hover {
            background: #4a3028;
            color: #fff;
        }
        .password-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            width: 100%;
        }
        .password-wrapper .form-control {
            padding-right: 40px;
        }
        .toggle-password {
            position: absolute;
            right: 12px;
            background: none;
            border: none;
            cursor: pointer;
            color: #a07060;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            outline: none;
        }
        .toggle-password:hover {
            color: #5D4037;
        }
    </style>
</head>
<body>
<div class="layout">
    @include('partials.sidebar')
    <div class="content">
        <header class="topbar">
            <div>
                <div class="topbar-title">Admin Profile</div>
                <div class="topbar-sub">Manage your account information and password</div>
            </div>
            <div style="display:flex;align-items:center;gap:12px">
                <div style="text-align:right">
                    <div style="font-size:13px;font-weight:600;color:#3b2417">{{ $user->name }}</div>
                    <div style="font-size:11px;color:#a07060">{{ config('app.name') }}</div>
                </div>
                @if ($user->avatar)
                    <img src="{{ asset('storage/'.$user->avatar) }}" style="width:36px;height:36px;border-radius:50%;object-fit:cover;border:2px solid #EAD7C3">
                @else
                    <div class="avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                @endif
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


                <div class="form-card">
                    <div class="table-card-header">
                        <div class="table-card-title">Profile Information</div>
                    </div>
                    <form method="POST" action="{{ route('profile.update') }}" class="form-body" enctype="multipart/form-data">
                        @csrf

                        {{-- Avatar --}}
                        <div class="form-group" style="display:flex;align-items:center;gap:20px;padding-bottom:20px;border-bottom:1px solid #EAD7C3;margin-bottom:20px">
                            <div style="position:relative;flex-shrink:0">
                                @if ($user->avatar)
                                    <img id="avatar-preview" src="{{ asset('storage/'.$user->avatar) }}"
                                        style="width:80px;height:80px;border-radius:50%;object-fit:cover;border:3px solid #EAD7C3">
                                @else
                                    <div id="avatar-placeholder" style="width:80px;height:80px;border-radius:50%;background:#5D4037;color:#EAD7C3;display:flex;align-items:center;justify-content:center;font-family:'Playfair Display',serif;font-size:32px;font-weight:700;flex-shrink:0">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <img id="avatar-preview" src="" style="width:80px;height:80px;border-radius:50%;object-fit:cover;border:3px solid #EAD7C3;display:none">
                                @endif
                                <label for="avatar" style="position:absolute;bottom:0;right:0;width:26px;height:26px;background:#5D4037;border-radius:50%;display:flex;align-items:center;justify-content:center;cursor:pointer;border:2px solid #fff">
                                    <svg fill="none" stroke="#EAD7C3" stroke-width="2.5" viewBox="0 0 24 24" style="width:13px;height:13px">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </label>
                                <input type="file" id="avatar" name="avatar" accept="image/*" style="display:none" onchange="previewAvatar(event)">
                            </div>
                            <div>
                                <div style="font-weight:600;color:#3b2417;font-size:15px">{{ $user->name }}</div>
                                <div style="font-size:12px;color:#a07060;margin-top:2px">{{ $user->email }}</div>
                                <div style="font-size:11px;color:#c9b4a3;margin-top:6px">Click the camera icon to change your photo</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        </div>

                        <hr style="border:none; border-top:1px solid #EAD7C3; margin:24px 0">

                        <div class="table-card-title" style="margin-bottom:16px; font-family:'Playfair Display',serif; font-size:17px; color:#3b2417">Change Password</div>

                        <div class="form-group">
                            <label for="current_password">Current Password</label>
                            <div class="password-wrapper">
                                <input type="password" id="current_password" name="current_password" class="form-control" placeholder="••••••••">
                                <button type="button" class="toggle-password" onclick="togglePasswordVisibility('current_password', this)">
                                    <svg class="eye-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width: 18px; height: 18px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <svg class="eye-slash-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width: 18px; height: 18px; display: none;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.822 7.822L21 21m-2.228-2.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password">New Password</label>
                            <div class="password-wrapper">
                                <input type="password" id="password" name="password" class="form-control" placeholder="••••••••">
                                <button type="button" class="toggle-password" onclick="togglePasswordVisibility('password', this)">
                                    <svg class="eye-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width: 18px; height: 18px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <svg class="eye-slash-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width: 18px; height: 18px; display: none;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.822 7.822L21 21m-2.228-2.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirm New Password</label>
                            <div class="password-wrapper">
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="••••••••">
                                <button type="button" class="toggle-password" onclick="togglePasswordVisibility('password_confirmation', this)">
                                    <svg class="eye-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width: 18px; height: 18px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <svg class="eye-slash-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width: 18px; height: 18px; display: none;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.822 7.822L21 21m-2.228-2.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="btn-primary">Save Changes</button>

                        @if ($errors->any())
                            <div style="margin-top:16px; background:#fdf2f2; color:#b91c1c; border:1px solid #fde8e8; border-radius:10px; padding:12px 16px; font-size:13px;">
                                <ul style="margin:0; padding:0; list-style:none">
                                    @foreach ($errors->all() as $error)
                                        <li style="margin-bottom:4px">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </main>
        <footer>{{ config('app.name') }} &copy; {{ now()->year }} · All rights reserved</footer>
    </div>
</div>
<script>
function togglePasswordVisibility(fieldId, btn) {
    const input = document.getElementById(fieldId);
    const eyeIcon = btn.querySelector('.eye-icon');
    const eyeSlashIcon = btn.querySelector('.eye-slash-icon');
    if (input.type === 'password') {
        input.type = 'text';
        eyeIcon.style.display = 'none';
        eyeSlashIcon.style.display = 'block';
    } else {
        input.type = 'password';
        eyeIcon.style.display = 'block';
        eyeSlashIcon.style.display = 'none';
    }
}

function previewAvatar(event) {
    const file = event.target.files[0];
    if (!file) return;
    const preview = document.getElementById('avatar-preview');
    const placeholder = document.getElementById('avatar-placeholder');
    preview.src = URL.createObjectURL(file);
    preview.style.display = 'block';
    if (placeholder) placeholder.style.display = 'none';
}
</script>
</body>
</html>
