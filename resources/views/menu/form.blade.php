<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $item ? 'Edit' : 'Add' }} Menu Item — {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.snow.css" rel="stylesheet">
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
        .page-body { padding: 28px 32px 40px; max-width: 860px; }

        /* Buttons */
        .back-btn {
            display: inline-flex; align-items: center; gap: 8px; text-decoration: none;
            color: #5D4037; font-size: 13px; font-weight: 500;
            padding: 8px 16px; border-radius: 10px; background: #fff; border: 1px solid #EAD7C3;
            transition: background 0.15s;
        }
        .back-btn:hover { background: #f5ede6; }
        .btn-primary {
            display: inline-flex; align-items: center; gap: 8px;
            background: #5D4037; color: #EAD7C3; font-size: 14px; font-weight: 600;
            padding: 11px 24px; border-radius: 10px; border: none; cursor: pointer;
            transition: background 0.15s;
        }
        .btn-primary:hover { background: #4a3028; }

        /* Page header */
        .page-hdr { display: flex; align-items: center; gap: 14px; margin-bottom: 28px; }
        .page-hdr-title { font-family: 'Playfair Display', serif; font-size: 26px; color: #3b2417; }

        /* Form card */
        .form-card { background: #fff; border-radius: 16px; border: 1px solid #EAD7C3; overflow: hidden; margin-bottom: 20px; }
        .form-card-header { padding: 16px 24px; border-bottom: 1px solid #EAD7C3; display: flex; align-items: center; gap: 10px; }
        .form-card-icon { width: 32px; height: 32px; border-radius: 8px; background: #f5ede6; display: flex; align-items: center; justify-content: center; }
        .form-card-title { font-family: 'Playfair Display', serif; font-size: 15px; color: #3b2417; }
        .form-card-body { padding: 24px; }

        /* Fields */
        .field { margin-bottom: 20px; }
        .field:last-child { margin-bottom: 0; }
        .field label { display: block; font-size: 11px; text-transform: uppercase; letter-spacing: 0.12em; font-weight: 600; color: #a07060; margin-bottom: 7px; }
        .field input[type="text"],
        .field input[type="number"],
        .field input[type="file"] {
            width: 100%; padding: 10px 14px; border-radius: 10px;
            border: 1px solid #EAD7C3; font-size: 14px; color: #3b2417;
            font-family: 'Inter', sans-serif; background: #fff;
            outline: none; transition: border-color 0.15s;
        }
        .field input[type="text"]:focus { border-color: #5D4037; }
        .field-error { font-size: 12px; color: #c62828; margin-top: 5px; }

        /* Toggle */
        .toggle-wrap { display: flex; align-items: center; gap: 10px; }
        .toggle-wrap input[type="checkbox"] { width: 18px; height: 18px; accent-color: #5D4037; cursor: pointer; }
        .toggle-wrap label { font-size: 14px; color: #3b2417; font-weight: 500; text-transform: none; letter-spacing: 0; }

        /* Image preview */
        .img-preview-wrap { margin-top: 12px; }
        .img-preview {
            width: 160px; height: 120px; object-fit: cover;
            border-radius: 10px; border: 1px solid #EAD7C3; display: block;
        }
        .img-preview-label { font-size: 11px; color: #a07060; margin-top: 6px; }

        /* Quill overrides */
        .ql-container { font-family: 'Inter', sans-serif; font-size: 14px; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px; border-color: #EAD7C3 !important; }
        .ql-toolbar { border-top-left-radius: 10px; border-top-right-radius: 10px; border-color: #EAD7C3 !important; background: #fdf8f4; }
        .ql-editor { min-height: 180px; color: #3b2417; }

        footer { padding: 14px 32px; font-size: 11px; color: #c9b4a3; text-align: center; border-top: 1px solid #EAD7C3; background: #fff; }
    </style>
</head>
<body>
<div class="layout">

    @include('partials.sidebar')

    <div class="content">
        <header class="topbar">
            <div>
                <div class="topbar-title">{{ $item ? 'Edit Menu Item' : 'Add Menu Item' }}</div>
                <div class="topbar-sub">{{ $item ? 'Update the details below' : 'Fill in the details to add a new cake' }}</div>
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

                <div class="page-hdr">
                    <a href="{{ route('menu.index') }}" class="back-btn">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                        Back
                    </a>
                    <span class="page-hdr-title">{{ $item ? 'Edit: '.$item->title : 'New Menu Item' }}</span>
                </div>

                <form
                    action="{{ $item ? route('menu.update', $item) : route('menu.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                >
                    @csrf
                    @if ($item)
                        @method('PUT')
                    @endif

                    {{-- Details card --}}
                    <div class="form-card">
                        <div class="form-card-header">
                            <div class="form-card-icon">
                                <svg fill="none" stroke="#5D4037" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </div>
                            <span class="form-card-title">Details</span>
                        </div>
                        <div class="form-card-body">

                            <div class="field">
                                <label for="title">Title</label>
                                <input type="text" id="title" name="title" value="{{ old('title', $item?->title) }}" placeholder="e.g. Chocolate Fudge Cake">
                                @error('title') <div class="field-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="field">
                                <label for="price">Price (ETB)</label>
                                <input type="number" id="price" name="price" value="{{ old('price', $item?->price) }}" placeholder="0.00" min="0" step="0.01" style="width:200px">
                                @error('price') <div class="field-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="field">
                                <label>Description</label>
                                <div id="quill-editor">{!! old('description', $item?->description) !!}</div>
                                <input type="hidden" name="description" id="description-input">
                                @error('description') <div class="field-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="field">
                                <div class="toggle-wrap">
                                    <input type="hidden" name="is_available" value="0">
                                    <input type="checkbox" id="is_available" name="is_available" value="1"
                                        {{ old('is_available', $item?->is_available ?? true) ? 'checked' : '' }}>
                                    <label for="is_available">Available on menu</label>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- Image card --}}
                    <div class="form-card">
                        <div class="form-card-header">
                            <div class="form-card-icon">
                                <svg fill="none" stroke="#5D4037" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <span class="form-card-title">Image</span>
                        </div>
                        <div class="form-card-body">
                            <div class="field">
                                <label for="image">{{ $item?->image ? 'Replace Image' : 'Upload Image' }}</label>
                                <input type="file" id="image" name="image" accept="image/*" onchange="previewImage(event)">
                                @error('image') <div class="field-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="img-preview-wrap">
                                @if ($item?->image)
                                    <img id="img-preview" src="{{ $item->imageUrl() }}" class="img-preview" alt="Current image">
                                    <div class="img-preview-label">Current image — upload a new one to replace it</div>
                                @else
                                    <img id="img-preview" src="" class="img-preview" alt="Preview" style="display:none">
                                @endif
                            </div>
                        </div>
                    </div>

                    <div style="display:flex;justify-content:flex-end">
                        <button type="submit" class="btn-primary">
                            <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            {{ $item ? 'Save Changes' : 'Create Menu Item' }}
                        </button>
                    </div>

                </form>

            </div>
        </main>

        <footer>{{ config('app.name') }} &copy; {{ now()->year }} · All rights reserved</footer>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.js"></script>
<script>
    const quill = new Quill('#quill-editor', {
        theme: 'snow',
        placeholder: 'Describe this cake — ingredients, occasion, flavour notes...',
        modules: {
            toolbar: [
                [{ header: [2, 3, false] }],
                ['bold', 'italic', 'underline'],
                [{ list: 'ordered' }, { list: 'bullet' }],
                ['clean']
            ]
        }
    });

    const descInput = document.getElementById('description-input');

    // Helper: get meaningful HTML or empty string
    function getQuillHTML() {
        const html = quill.root.innerHTML;
        return (html === '<p><br></p>' || html.trim() === '') ? '' : html;
    }

    // Pre-populate hidden input on page load (needed for edit forms so validation passes on re-submit)
    descInput.value = getQuillHTML();

    // Sync on every text change so the hidden input is always up to date
    quill.on('text-change', function () {
        descInput.value = getQuillHTML();
    });

    // Also sync on submit as a safety net
    document.querySelector('form').addEventListener('submit', function () {
        descInput.value = getQuillHTML();
    });

    // Image preview
    function previewImage(event) {
        const preview = document.getElementById('img-preview');
        const file = event.target.files[0];
        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        }
    }
</script>
</body>
</html>
