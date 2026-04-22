@extends('layouts.dashboard')

@section('title', 'Hero Section')

@section('content')
<div class="p-6 max-w-4xl mx-auto">

    <div class="mb-6">
        <h1 class="text-lg font-bold text-gray-900">Hero Section</h1>
        <p class="text-xs text-gray-500 mt-0.5">Edit the homepage hero slider — text, buttons, and background images.</p>
    </div>

    @if(session('success'))
    <div class="mb-5 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
    @endif

    <form method="POST" action="{{ route('admin.hero.update') }}" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @method('PUT')

        {{-- ── Text Content ── --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h2 class="text-sm font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-pen text-primary text-xs"></i> Text Content
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Badge Text</label>
                    <input type="text" name="badge_text" value="{{ $hero['badge_text'] ?? '' }}"
                           placeholder="e.g. 🎉 New Collection 2026"
                           class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:border-primary focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Title — Line 1</label>
                    <input type="text" name="title_prefix" value="{{ $hero['title_prefix'] ?? '' }}"
                           placeholder="e.g. Discover Your"
                           class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:border-primary focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Title — Line 2 <span class="text-yellow-500">(highlighted)</span></label>
                    <input type="text" name="title_suffix" value="{{ $hero['title_suffix'] ?? '' }}"
                           placeholder="e.g. Style Today"
                           class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:border-primary focus:outline-none">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-gray-600 mb-1">Description</label>
                    <textarea name="description" rows="3"
                              placeholder="Short description below the title..."
                              class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:border-primary focus:outline-none resize-none">{{ $hero['description'] ?? '' }}</textarea>
                </div>
            </div>
        </div>

        {{-- ── CTA Buttons ── --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h2 class="text-sm font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-mouse-pointer text-primary text-xs"></i> CTA Buttons
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-3">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wide">Button 1 — Primary</p>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Label</label>
                        <input type="text" name="button1_text" value="{{ $hero['buttons'][0]['text'] ?? 'Shop Now' }}"
                               class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:border-primary focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">URL</label>
                        <input type="text" name="button1_url" value="{{ $hero['buttons'][0]['url'] ?? '/shop' }}"
                               class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:border-primary focus:outline-none">
                    </div>
                </div>
                <div class="space-y-3">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wide">Button 2 — Secondary</p>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Label</label>
                        <input type="text" name="button2_text" value="{{ $hero['buttons'][1]['text'] ?? 'View Deals' }}"
                               class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:border-primary focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">URL</label>
                        <input type="text" name="button2_url" value="{{ $hero['buttons'][1]['url'] ?? '/deals' }}"
                               class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:border-primary focus:outline-none">
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Slider Background Images ── --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h2 class="text-sm font-semibold text-gray-800 mb-1 flex items-center gap-2">
                <i class="fas fa-images text-primary text-xs"></i> Slider Background Images
            </h2>
            <p class="text-xs text-gray-400 mb-4">Paste image URLs (Unsplash, CDN, etc.) or leave blank to skip that slide. At least 1 required.</p>

            <div class="space-y-3">
                @for($i = 1; $i <= 4; $i++)
                @php $imgVal = $hero['slider_images'][$i-1] ?? ''; @endphp
                <div class="flex items-start gap-3">
                    <span class="mt-2.5 text-xs font-bold text-gray-400 w-5 text-center flex-shrink-0">{{ $i }}</span>
                    <div class="flex-1 space-y-2">
                        <input type="text" name="slider_image_{{ $i }}" value="{{ $imgVal }}"
                               placeholder="https://example.com/image.jpg"
                               class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:border-primary focus:outline-none">
                        @if($imgVal)
                        <div class="h-20 rounded-lg overflow-hidden border border-gray-100">
                            <img src="{{ $imgVal }}" class="w-full h-full object-cover" alt="Slide {{ $i }} preview">
                        </div>
                        @endif
                    </div>
                </div>
                @endfor
            </div>
        </div>

        {{-- ── Stats ── --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h2 class="text-sm font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-chart-bar text-primary text-xs"></i> Stats Bar
            </h2>
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Happy Customers</label>
                    <input type="text" name="stats_happy_customers" value="{{ $hero['stats_happy_customers'] ?? '50K+' }}"
                           class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:border-primary focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Products</label>
                    <input type="text" name="stats_products" value="{{ $hero['stats_products'] ?? '1000+' }}"
                           class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:border-primary focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Rating</label>
                    <input type="text" name="stats_rating" value="{{ $hero['stats_rating'] ?? '4.9★' }}"
                           class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:border-primary focus:outline-none">
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-2">
            <a href="{{ route('dashboard') }}" class="px-5 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-600 hover:bg-gray-50 transition">Cancel</a>
            <button type="submit" class="px-6 py-2.5 bg-primary text-white rounded-xl text-sm font-semibold hover:bg-primary/90 transition shadow-sm">
                <i class="fas fa-save mr-1.5"></i> Save Changes
            </button>
        </div>
    </form>
</div>
@endsection
