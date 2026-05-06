@extends('layouts.dashboard')

@section('title', 'Site Settings')

@section('content')
<div class="p-6">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-800 font-display">Site Settings</h1>
            <p class="text-slate-500 mt-1">Manage global appearance and behavior</p>
        </div>
    </div>

    <div class="max-w-4xl">
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Site Identity Section -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden mb-6">
                <div class="p-8">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-12 h-12 rounded-2xl bg-blue-500/10 text-blue-600 flex items-center justify-center">
                            <i class="fas fa-globe text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-slate-800">Site Identity</h2>
                            <p class="text-sm text-slate-500">Set your site name, title, and favicon</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Left: text fields -->
                        <div class="space-y-5">
                            <!-- Site Name -->
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">Site Name</label>
                                <p class="text-xs text-slate-500 mb-2">Appears in the browser tab, emails, and throughout the site.</p>
                                <input type="text"
                                       name="site_name"
                                       value="{{ $siteName }}"
                                       placeholder="e.g. Shankhabazar"
                                       class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none text-sm transition">
                            </div>

                            <!-- Site Title / Tagline -->
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">Site Tagline / Title</label>
                                <p class="text-xs text-slate-500 mb-2">Shown after the site name in browser tabs (e.g. "Your Premium Shopping Destination").</p>
                                <input type="text"
                                       name="site_title"
                                       value="{{ $siteTitle }}"
                                       placeholder="e.g. Your Premium Shopping Destination"
                                       class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none text-sm transition">
                                <p class="text-xs text-slate-400 mt-1">
                                    <i class="fas fa-eye mr-1"></i>
                                    Browser tab will show: <strong id="titlePreview">{{ $siteName }} - {{ $siteTitle }}</strong>
                                </p>
                            </div>
                        </div>

                        <!-- Right: favicon -->
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Favicon</label>
                            <p class="text-xs text-slate-500 mb-3">The small icon shown in browser tabs. Recommended: 32×32px PNG or ICO.</p>

                            <div class="flex items-start gap-5">
                                <!-- Current favicon preview -->
                                <div class="flex-shrink-0">
                                    <div class="w-20 h-20 rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50 flex items-center justify-center overflow-hidden" id="faviconPreviewWrap">
                                        @if($favicon)
                                            <img src="{{ asset('storage/' . $favicon) }}" alt="Favicon" class="w-12 h-12 object-contain" id="faviconPreview">
                                        @else
                                            <i class="fas fa-image text-slate-300 text-2xl" id="faviconPlaceholder"></i>
                                        @endif
                                    </div>
                                    <p class="text-[10px] text-slate-400 text-center mt-1">Current</p>
                                </div>

                                <!-- Upload -->
                                <div class="flex-1">
                                    <label for="favicon_input"
                                           class="flex flex-col items-center justify-center w-full h-20 border-2 border-dashed border-slate-200 rounded-2xl cursor-pointer hover:border-primary hover:bg-primary/5 transition-all">
                                        <i class="fas fa-cloud-upload-alt text-slate-400 text-xl mb-1"></i>
                                        <span class="text-xs text-slate-500 font-medium">Click to upload</span>
                                        <span class="text-[10px] text-slate-400">PNG, JPG, ICO, SVG (max 512KB)</span>
                                    </label>
                                    <input type="file" id="favicon_input" name="favicon" accept=".png,.jpg,.jpeg,.ico,.svg,.webp" class="hidden"
                                           onchange="previewFavicon(event)">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-6 bg-slate-50 flex justify-end">
                    <button type="submit" class="bg-primary text-white px-8 py-3 rounded-xl font-bold shadow-lg hover:bg-primary/90 transition">
                        <i class="fas fa-check-circle mr-2"></i>Save All Settings
                    </button>
                </div>
            </div>

            <!-- Appearance Section -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-8 border-b border-slate-50">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-12 h-12 rounded-2xl bg-primary/10 text-primary flex items-center justify-center">
                            <i class="fas fa-palette text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-slate-800">Visual Settings</h2>
                            <p class="text-sm text-slate-500">Customize the look and feel of your platform</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <!-- Primary Color -->
                            <div class="mb-8">
                                <label class="block text-sm font-bold text-slate-700 mb-2">Primary Color</label>
                                <p class="text-xs text-slate-500 mb-4">This color will be used for buttons, links, and accents throughout the frontend and dashboard.</p>
                                
                                <div class="flex items-center gap-4">
                                    <div class="relative group">
                                        <input type="color" 
                                               name="primary_color" 
                                               id="primary_color" 
                                               value="{{ $primaryColor }}" 
                                               class="w-20 h-20 rounded-2xl border-4 border-white shadow-lg cursor-pointer transition-transform group-hover:scale-105">
                                        <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-white rounded-full shadow-md flex items-center justify-center pointer-events-none">
                                            <i class="fas fa-eye-dropper text-[10px] text-slate-400"></i>
                                        </div>
                                    </div>
                                    
                                    <div class="flex-1">
                                        <div class="bg-slate-50 rounded-xl p-3 border border-slate-100">
                                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Color Code</p>
                                            <input type="text" 
                                                   id="color_code" 
                                                   value="{{ $primaryColor }}" 
                                                   class="bg-transparent border-none p-0 text-lg font-mono font-bold text-slate-800 focus:ring-0 w-full" 
                                                   oninput="document.getElementById('primary_color').value = this.value">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Secondary Color -->
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Secondary Color</label>
                                <p class="text-xs text-slate-500 mb-4">Used for hover states, active links, and highlights.</p>
                                
                                <div class="flex items-center gap-4">
                                    <div class="relative group">
                                        <input type="color" 
                                               name="secondary_color" 
                                               id="secondary_color" 
                                               value="{{ $secondaryColor }}" 
                                               class="w-20 h-20 rounded-2xl border-4 border-white shadow-lg cursor-pointer transition-transform group-hover:scale-105">
                                        <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-white rounded-full shadow-md flex items-center justify-center pointer-events-none">
                                            <i class="fas fa-eye-dropper text-[10px] text-slate-400"></i>
                                        </div>
                                    </div>
                                    
                                    <div class="flex-1">
                                        <div class="bg-slate-50 rounded-xl p-3 border border-slate-100">
                                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Color Code</p>
                                            <input type="text" 
                                                   id="secondary_color_code" 
                                                   value="{{ $secondaryColor }}" 
                                                   class="bg-transparent border-none p-0 text-lg font-mono font-bold text-slate-800 focus:ring-0 w-full" 
                                                   oninput="document.getElementById('secondary_color').value = this.value">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Live Preview</label>
                            <p class="text-xs text-slate-500 mb-4">Preview how buttons will look with the selected color.</p>
                            
                            <div class="space-y-4">
                                <button type="button" class="w-full bg-primary text-white py-3 rounded-xl font-bold shadow-lg shadow-primary/20 flex items-center justify-center gap-2">
                                    <i class="fas fa-shopping-bag text-sm"></i> Primary Button
                                </button>
                                <div class="flex gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-primary/10 text-primary flex items-center justify-center">
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <div class="flex-1">
                                        <div class="h-2 w-24 bg-primary/20 rounded-full mb-2"></div>
                                        <div class="h-2 w-16 bg-slate-200 rounded-full"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-6 bg-slate-50 flex justify-end">
                    <button type="submit" class="bg-primary text-white px-8 py-3 rounded-xl font-bold shadow-lg hover:bg-primary/90 transition">
                        <i class="fas fa-check-circle mr-2"></i>Save All Settings
                    </button>
                </div>
            </div>

            <!-- Contact Section -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden mt-6">
                <div class="p-8">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-12 h-12 rounded-2xl bg-green-500/10 text-green-600 flex items-center justify-center">
                            <i class="fab fa-whatsapp text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-slate-800">WhatsApp Contact</h2>
                            <p class="text-sm text-slate-500">Set WhatsApp number for floating button</p>
                        </div>
                    </div>

                    <div class="max-w-md space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">WhatsApp Number</label>
                            <p class="text-xs text-slate-500 mb-2">Enter with country code (e.g., 8801234567890)</p>
                            <div class="flex items-center gap-3">
                                <span class="w-10 h-10 bg-[#25D366] rounded-xl flex items-center justify-center flex-shrink-0">
                                    <i class="fab fa-whatsapp text-white text-lg"></i>
                                </span>
                                <input type="text"
                                       name="whatsapp_number"
                                       value="{{ $whatsappNumber }}"
                                       placeholder="8801234567890"
                                       class="flex-1 px-4 py-3 rounded-xl border border-slate-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none text-sm transition">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Call Number</label>
                            <p class="text-xs text-slate-500 mb-2">Phone number for the call button</p>
                            <div class="flex items-center gap-3">
                                <span class="w-10 h-10 bg-blue-500 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-phone text-white text-lg"></i>
                                </span>
                                <input type="text"
                                       name="call_number"
                                       value="{{ $callNumber }}"
                                       placeholder="+8801234567890"
                                       class="flex-1 px-4 py-3 rounded-xl border border-slate-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none text-sm transition">
                            </div>
                        </div>
                        <p class="text-xs text-slate-400">
                            <i class="fas fa-info-circle mr-1"></i>
                            Buttons only appear when numbers are saved
                        </p>
                    </div>
                </div>

                <div class="p-6 bg-slate-50 flex justify-end">
                    <button type="submit" class="bg-primary text-white px-8 py-3 rounded-xl font-bold shadow-lg hover:bg-primary/90 transition">
                        <i class="fas fa-check-circle mr-2"></i>Save All Settings
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>

<script>
    document.getElementById('primary_color').addEventListener('input', function(e) {
        const color = e.target.value;
        document.getElementById('color_code').value = color;
        document.documentElement.style.setProperty('--primary-color', color);
    });

    document.getElementById('secondary_color').addEventListener('input', function(e) {
        const color = e.target.value;
        document.getElementById('secondary_color_code').value = color;
        document.documentElement.style.setProperty('--secondary-color', color);
    });

    // Live title preview
    function updateTitlePreview() {
        const name  = document.querySelector('[name="site_name"]').value || 'Site Name';
        const title = document.querySelector('[name="site_title"]').value || '';
        document.getElementById('titlePreview').textContent = title ? name + ' - ' + title : name;
    }
    document.querySelector('[name="site_name"]')?.addEventListener('input', updateTitlePreview);
    document.querySelector('[name="site_title"]')?.addEventListener('input', updateTitlePreview);

    // Favicon preview
    function previewFavicon(event) {
        const file = event.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function(e) {
            const wrap = document.getElementById('faviconPreviewWrap');
            wrap.innerHTML = '<img src="' + e.target.result + '" class="w-12 h-12 object-contain" id="faviconPreview">';
        };
        reader.readAsDataURL(file);
    }
</script>
@endsection
