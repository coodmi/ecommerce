@extends('layouts.dashboard')

@section('title', 'Add New Brand')

@section('content')
<div class="p-6">
    <div class="flex items-center space-x-4 mb-8">
        <a href="{{ route('admin.brands.index') }}" class="w-10 h-10 flex items-center justify-center bg-white rounded-xl shadow-sm text-gray-600 hover:text-purple-600 transition-all">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-3xl font-display font-bold text-gray-900">Add New Brand</h1>
            <p class="text-gray-600 mt-1">Create a new brand for your products</p>
        </div>
    </div>

    <div class="max-w-4xl">
        <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 p-8">
                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Basic Info -->
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-black text-slate-900 uppercase tracking-widest mb-2">Brand Name</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                   class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-500 transition-all font-bold placeholder:text-slate-300"
                                   placeholder="e.g. Nike, Apple, Samsung" required>
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-center space-x-4 p-4 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/30 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                            </label>
                            <span class="text-sm font-bold text-slate-700 uppercase tracking-wider">Brand is Active</span>
                        </div>
                    </div>

                    <!-- Logo Upload -->
                    <div x-data="{ logoPreview: null }">
                        <label class="block text-sm font-black text-slate-900 uppercase tracking-widest mb-2">Brand Logo</label>
                        <div class="relative group">
                            <div class="w-full aspect-square rounded-[2rem] bg-slate-50 border-2 border-dashed border-slate-200 flex flex-col items-center justify-center overflow-hidden transition-all group-hover:border-purple-300">
                                <template x-if="!logoPreview">
                                    <div class="flex flex-col items-center">
                                        <div class="w-16 h-16 bg-white rounded-2xl shadow-sm flex items-center justify-center mb-4 text-slate-400 group-hover:text-purple-600 transition-colors">
                                            <i class="fas fa-image text-2xl"></i>
                                        </div>
                                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest text-center px-4">Click to upload logo<br><span class="text-[10px] lowercase font-medium">Recommended: 400x400 PNG</span></p>
                                    </div>
                                </template>
                                <template x-if="logoPreview">
                                    <img :src="logoPreview" class="w-full h-full object-contain p-8">
                                </template>
                                <input type="file" name="logo" class="absolute inset-0 opacity-0 cursor-pointer"
                                       @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => { logoPreview = e.target.result }; reader.readAsDataURL(file); }">
                            </div>
                            @error('logo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="mt-10 flex justify-end">
                    <button type="submit" class="px-10 py-4 bg-slate-900 text-white rounded-2xl font-black uppercase tracking-[0.2em] shadow-2xl shadow-slate-200 hover:bg-slate-800 transition-all duration-300 transform hover:scale-[1.02] active:scale-[0.98]">
                        <i class="fas fa-save mr-2"></i>Create Brand
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
