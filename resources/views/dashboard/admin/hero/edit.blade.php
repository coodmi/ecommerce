@extends('layouts.dashboard')

@section('title', 'Hero Section')

@section('content')
<div class="p-6">

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
            <p class="text-xs text-gray-400 mb-4">Device থেকে ছবি আপলোড করুন। JPG, PNG, WEBP — সর্বোচ্চ 4MB। সর্বনিম্ন ১টি ছবি দিতে হবে।</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @for($i = 1; $i <= 4; $i++)
                @php $imgVal = $hero['slider_images'][$i-1] ?? ''; @endphp
                <div class="space-y-2">
                    <p class="text-xs font-semibold text-gray-500">Slide {{ $i }}</p>

                    {{-- Upload Box --}}
                    <label for="file_upload_{{ $i }}"
                           class="flex flex-col items-center justify-center gap-2 h-32 border-2 border-dashed border-gray-200 rounded-xl cursor-pointer hover:border-primary hover:bg-primary/5 transition group relative"
                           id="upload_label_{{ $i }}">

                        {{-- Show current image as background if exists --}}
                        @if($imgVal)
                        <img src="{{ $imgVal }}" id="preview_img_{{ $i }}"
                             class="absolute inset-0 w-full h-full object-cover rounded-xl opacity-60" alt="">
                        <div class="relative z-10 flex flex-col items-center gap-1">
                            <i class="fas fa-camera text-white text-lg drop-shadow"></i>
                            <span class="text-xs text-white font-medium drop-shadow">পরিবর্তন করুন</span>
                        </div>
                        @else
                        <img src="" id="preview_img_{{ $i }}"
                             class="absolute inset-0 w-full h-full object-cover rounded-xl opacity-60 hidden" alt="">
                        <div id="upload_placeholder_{{ $i }}" class="flex flex-col items-center gap-1">
                            <i class="fas fa-cloud-upload-alt text-gray-300 group-hover:text-primary text-2xl transition"></i>
                            <span class="text-xs text-gray-400 group-hover:text-primary transition">ছবি আপলোড করুন</span>
                        </div>
                        <div id="upload_done_{{ $i }}" class="hidden flex-col items-center gap-1">
                            <i class="fas fa-check-circle text-green-500 text-2xl"></i>
                            <span class="text-xs text-green-600 font-medium" id="file_name_{{ $i }}"></span>
                        </div>
                        @endif
                    </label>

                    <input type="file" id="file_upload_{{ $i }}" name="slider_image_file_{{ $i }}"
                           accept="image/jpeg,image/png,image/gif,image/webp"
                           class="hidden"
                           onchange="previewHeroImage(this, {{ $i }})">

                    {{-- Remove button if image exists --}}
                    @if($imgVal)
                    <input type="hidden" name="slider_image_keep_{{ $i }}" id="keep_{{ $i }}" value="1">
                    <button type="button" onclick="clearHeroImage({{ $i }})"
                            class="w-full text-xs text-red-400 hover:text-red-600 transition flex items-center justify-center gap-1 py-1">
                        <i class="fas fa-trash-alt"></i> ছবি সরান
                    </button>
                    @else
                    <input type="hidden" name="slider_image_keep_{{ $i }}" id="keep_{{ $i }}" value="0">
                    @endif
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

@push('scripts')
<script>
function previewHeroImage(input, index) {
    const file = input.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function(e) {
        const img = document.getElementById('preview_img_' + index);
        const placeholder = document.getElementById('upload_placeholder_' + index);
        const done = document.getElementById('upload_done_' + index);
        const nameEl = document.getElementById('file_name_' + index);

        // Show image preview inside the upload box
        img.src = e.target.result;
        img.classList.remove('hidden');

        // Hide placeholder, show done state
        if (placeholder) placeholder.classList.add('hidden');
        if (done) {
            done.classList.remove('hidden');
            done.classList.add('flex');
        }
        if (nameEl) nameEl.textContent = file.name;

        // Mark as keep
        document.getElementById('keep_' + index).value = '1';
    };
    reader.readAsDataURL(file);
}

function clearHeroImage(index) {
    // Clear file input
    const fileInput = document.getElementById('file_upload_' + index);
    if (fileInput) fileInput.value = '';

    // Hide preview image
    const img = document.getElementById('preview_img_' + index);
    if (img) { img.src = ''; img.classList.add('hidden'); }

    // Show placeholder again
    const placeholder = document.getElementById('upload_placeholder_' + index);
    if (placeholder) placeholder.classList.remove('hidden');

    const done = document.getElementById('upload_done_' + index);
    if (done) { done.classList.add('hidden'); done.classList.remove('flex'); }

    // Mark as remove
    document.getElementById('keep_' + index).value = '0';

    // Hide remove button
    const btn = document.querySelector('[onclick="clearHeroImage(' + index + ')"]');
    if (btn) btn.classList.add('hidden');
}
</script>
@endpush
