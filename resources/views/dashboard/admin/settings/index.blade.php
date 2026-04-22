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
        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf
            
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

        </form>
    </div>
</div>

<script>
    document.getElementById('primary_color').addEventListener('input', function(e) {
        const color = e.target.value;
        document.getElementById('color_code').value = color;
        // Dynamically update CSS variable for live preview
        document.documentElement.style.setProperty('--primary-color', color);
    });

    document.getElementById('secondary_color').addEventListener('input', function(e) {
        const color = e.target.value;
        document.getElementById('secondary_color_code').value = color;
        document.documentElement.style.setProperty('--secondary-color', color);
    });
</script>
@endsection
