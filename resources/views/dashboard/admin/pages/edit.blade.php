@extends('layouts.dashboard')

@section('content')
<div class="px-6 py-6">
    <div class="mb-6">
        <a href="{{ route('admin.pages.index') }}" class="text-slate-500 hover:text-slate-700 transition flex items-center gap-2 text-sm font-medium mb-2">
            <i class="fas fa-arrow-left"></i> Back to Pages
        </a>
        <h1 class="text-2xl font-bold text-slate-800">Edit Page: {{ $page->name }}</h1>
        <p class="text-slate-500 text-sm mt-1">Update content and styling for {{ $page->name }} page.</p>
    </div>

    <form action="{{ route('admin.pages.update', $page->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        @if($page->slug === 'home')
            <!-- Home Page Specific Sections -->
            @php
                $hero = $page->sections->where('key', 'hero')->first();
                $heroContent = $hero ? $hero->content : [];

                $categories = $page->sections->where('key', 'categories')->first();
                $categoriesContent = $categories ? $categories->content : [];

                $featuredProducts = $page->sections->where('key', 'featured_products')->first();
                $featuredProductsContent = $featuredProducts ? $featuredProducts->content : [];

                $flashSale = $page->sections->where('key', 'flash_sale')->first();
                $flashSaleContent = $flashSale ? $flashSale->content : [];

                $features = $page->sections->where('key', 'features')->first();
                $featuresContent = $features ? $features->content : [];

                $testimonials = $page->sections->where('key', 'testimonials')->first();
                $testimonialsContent = $testimonials ? $testimonials->content : [];
                
                $newsletter = $page->sections->where('key', 'newsletter')->first();
                $newsletterContent = $newsletter ? $newsletter->content : [];
            @endphp
            
            <!-- Hero Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                    <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                        <i class="fas fa-home"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Home Hero Section</h2>
                        <p class="text-xs text-slate-500">Main landing section</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Badge Text</label>
                            <input type="text" name="section_hero_badge_text" value="{{ $heroContent['badge_text'] ?? '' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Title Prefix</label>
                            <input type="text" name="section_hero_title_prefix" value="{{ $heroContent['title_prefix'] ?? '' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Title Suffix (Highlighted)</label>
                            <input type="text" name="section_hero_title_suffix" value="{{ $heroContent['title_suffix'] ?? '' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 text-sm">
                        </div>
                    </div>
                    <div class="space-y-4">
                         <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Description</label>
                            <textarea name="section_hero_description" rows="4" class="w-full px-4 py-2 rounded-lg border border-slate-200 text-sm">{{ $heroContent['description'] ?? '' }}</textarea>
                        </div>
                        
                        <!-- Buttons Config -->
                        <div class="grid grid-cols-2 gap-4 border-t border-slate-100 pt-4">
                            <div class="col-span-2">
                                <label class="block text-xs font-bold uppercase text-slate-400 mb-2">Button 1 (Primary)</label>
                                <div class="grid grid-cols-2 gap-2">
                                    <input type="text" name="section_hero_button1_text" value="{{ $heroContent['buttons'][0]['text'] ?? 'Shop Now' }}" placeholder="Text" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm">
                                    <input type="text" name="section_hero_button1_url" value="{{ $heroContent['buttons'][0]['url'] ?? '/shop' }}" placeholder="URL" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm">
                                </div>
                            </div>
                            <div class="col-span-2">
                                <label class="block text-xs font-bold uppercase text-slate-400 mb-2">Button 2 (Secondary)</label>
                                <div class="grid grid-cols-2 gap-2">
                                    <input type="text" name="section_hero_button2_text" value="{{ $heroContent['buttons'][1]['text'] ?? 'Watch Video' }}" placeholder="Text" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm">
                                    <input type="text" name="section_hero_button2_url" value="{{ $heroContent['buttons'][1]['url'] ?? '#' }}" placeholder="URL" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 pt-6 border-t border-slate-100">
                    <h3 class="text-sm font-semibold text-slate-700 mb-4">Stats</h3>
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Happy Customers</label>
                            <input type="text" name="section_hero_stats_happy_customers" value="{{ $heroContent['stats_happy_customers'] ?? '50K+' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Products</label>
                            <input type="text" name="section_hero_stats_products" value="{{ $heroContent['stats_products'] ?? '1000+' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Rating</label>
                            <input type="text" name="section_hero_stats_rating" value="{{ $heroContent['stats_rating'] ?? '4.9★' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 text-sm">
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t border-slate-100">
                    <h3 class="text-sm font-semibold text-slate-700 mb-4">Hero Image & Offer Badge</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <label class="block text-sm font-medium text-slate-700 mb-1">Hero Image</label>
                            <div class="space-y-3">
                                <div id="hero-image-preview-container" class="{{ isset($heroContent['image']) && $heroContent['image'] ? '' : 'hidden' }} relative w-full h-32 bg-slate-100 rounded-lg overflow-hidden group border border-slate-200">
                                    <img id="hero-image-preview" 
                                         src="{{ isset($heroContent['image']) && $heroContent['image'] ? (filter_var($heroContent['image'], FILTER_VALIDATE_URL) ? $heroContent['image'] : asset('storage/' . $heroContent['image'])) : '' }}" 
                                         alt="Hero Image Preview" 
                                         class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <span class="text-white text-xs font-medium">Image Preview</span>
                                    </div>
                                </div>
                                
                                <input type="file" 
                                       name="section_hero_image" 
                                       accept="image/*" 
                                       onchange="previewImage(this, 'hero-image-preview', 'hero-image-preview-container')"
                                       class="w-full px-4 py-2 rounded-lg border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 transition">
                                <p class="text-xs text-slate-500">Upload a new image to replace the current one.</p>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Offer Label</label>
                            <input type="text" name="section_hero_offer_label" value="{{ $heroContent['offer_label'] ?? 'Special Offer' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Offer Text</label>
                            <input type="text" name="section_hero_offer_text" value="{{ $heroContent['offer_text'] ?? '50% OFF' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 text-sm">
                        </div>
                    </div>
                </div>

                <!-- Slider Background Images -->
                <div class="mt-6 pt-6 border-t border-slate-100">
                    <h3 class="text-sm font-semibold text-slate-700 mb-1">Slider Background Images</h3>
                    <p class="text-xs text-slate-400 mb-4">Enter image URLs for the hero background slider (one per field). Use full URLs or upload to storage and paste the path.</p>
                    <div class="space-y-3">
                        @for($si = 1; $si <= 4; $si++)
                        <div class="flex items-center gap-3">
                            <span class="text-xs font-bold text-slate-400 w-6 text-center">{{ $si }}</span>
                            <input type="text"
                                   name="section_hero_slider_image_{{ $si }}"
                                   value="{{ $heroContent['slider_images'][$si-1] ?? '' }}"
                                   placeholder="https://... or leave blank to skip"
                                   class="flex-1 px-3 py-2 rounded-lg border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                        </div>
                        @endfor
                    </div>
                </div>


            </div>

            <!-- Categories Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                    <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600">
                        <i class="fas fa-th-large"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Categories Section</h2>
                        <p class="text-xs text-slate-500">Customize the categories section header</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Section Title</label>
                        <input type="text" name="section_categories_title" value="{{ $categoriesContent['title'] ?? 'Shop by Category' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Section Description</label>
                        <input type="text" name="section_categories_description" value="{{ $categoriesContent['description'] ?? 'Explore our wide range of products' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 text-sm">
                    </div>
                </div>
                <div class="mt-4 p-4 bg-blue-50 rounded-lg border border-blue-100">
                    <p class="text-sm text-blue-700"><i class="fas fa-info-circle mr-2"></i>Category items are managed from the <a href="{{ route('admin.categories.index') }}" class="underline font-semibold">Categories</a> section. Mark categories as "Popular" to show them here.</p>
                </div>
            </div>

            <!-- Featured Products Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                    <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center text-green-600">
                        <i class="fas fa-star"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Featured Products Section</h2>
                        <p class="text-xs text-slate-500">Customize the featured products section header</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Section Title</label>
                        <input type="text" name="section_featured_products_title" value="{{ $featuredProductsContent['title'] ?? 'Featured Products' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Section Description</label>
                        <input type="text" name="section_featured_products_description" value="{{ $featuredProductsContent['description'] ?? 'Handpicked items just for you' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 text-sm">
                    </div>
                </div>
                <div class="mt-4 p-4 bg-green-50 rounded-lg border border-green-100">
                    <p class="text-sm text-green-700"><i class="fas fa-info-circle mr-2"></i>Featured products are managed from <a href="{{ route('admin.products.index') }}" class="underline font-semibold">Products</a>. Mark products as "Deal Product" to show them here.</p>
                </div>
            </div>

            <!-- Flash Sale / Banner Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                    <div class="w-10 h-10 rounded-lg bg-pink-100 flex items-center justify-center text-pink-600">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Flash Sale Section</h2>
                        <p class="text-xs text-slate-500">Manage promotional flash sale content</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                     <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Badge Text</label>
                            <input type="text" name="section_flash_sale_badge_text" value="{{ $flashSaleContent['badge_text'] ?? '' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Title</label>
                            <input type="text" name="section_flash_sale_title" value="{{ $flashSaleContent['title'] ?? '' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Discount Highlight</label>
                            <input type="text" name="section_flash_sale_discount" value="{{ $flashSaleContent['discount'] ?? '' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 text-sm">
                        </div>
                    </div>
                    <div class="space-y-4">
                         <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Description</label>
                            <textarea name="section_flash_sale_description" rows="3" class="w-full px-4 py-2 rounded-lg border border-slate-200 text-sm">{{ $flashSaleContent['description'] ?? '' }}</textarea>
                        </div>
                         <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Upload Image</label>
                            <div class="space-y-3">
                                <div id="flash-sale-image-preview-container" class="{{ isset($flashSaleContent['image']) && $flashSaleContent['image'] ? '' : 'hidden' }} relative h-32 w-full bg-slate-100 rounded-lg overflow-hidden group border border-slate-200">
                                     <img id="flash-sale-image-preview" 
                                          src="{{ isset($flashSaleContent['image']) && $flashSaleContent['image'] ? (filter_var($flashSaleContent['image'], FILTER_VALIDATE_URL) ? $flashSaleContent['image'] : asset('storage/' . $flashSaleContent['image'])) : '' }}" 
                                          alt="Flash Sale Preview" 
                                          class="w-full h-full object-cover">
                                     <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                         <span class="text-white text-xs font-medium">Image Preview</span>
                                     </div>
                                </div>
                                <input type="file" 
                                       name="section_flash_sale_image" 
                                       accept="image/*"
                                       onchange="previewImage(this, 'flash-sale-image-preview', 'flash-sale-image-preview-container')"
                                       class="w-full px-4 py-2 rounded-lg border border-slate-200 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 transition">
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-span-2 border-t border-slate-100 pt-4 mt-2">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="text-sm font-bold text-slate-700 mb-3">Countdown Timer</h4>
                                <div class="grid grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-xs font-medium text-slate-500 mb-1">Hours</label>
                                        <input type="number" name="section_flash_sale_time_hours" value="{{ $flashSaleContent['time_hours'] ?? '23' }}" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-500 mb-1">Minutes</label>
                                        <input type="number" name="section_flash_sale_time_minutes" value="{{ $flashSaleContent['time_minutes'] ?? '45' }}" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-500 mb-1">Seconds</label>
                                        <input type="number" name="section_flash_sale_time_seconds" value="{{ $flashSaleContent['time_seconds'] ?? '30' }}" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm">
                                    </div>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-700 mb-3">Action Button</h4>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-medium text-slate-500 mb-1">Button Text</label>
                                        <input type="text" name="section_flash_sale_button_text" value="{{ $flashSaleContent['button_text'] ?? 'Shop Sale Now' }}" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-500 mb-1">Button URL</label>
                                        <input type="text" name="section_flash_sale_button_url" value="{{ $flashSaleContent['button_url'] ?? '/shop' }}" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Features Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                    <div class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center text-indigo-600">
                        <i class="fas fa-star"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Features Section</h2>
                        <p class="text-xs text-slate-500">Manage value proposition cards</p>
                    </div>
                </div>
                
                <div class="mb-6">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Section Title</label>
                    <input type="text" name="section_features_title" value="{{ $featuresContent['title'] ?? 'Why Shop With Us' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 text-sm">
                </div>

                <div id="features-container" class="grid grid-cols-1 md:grid-cols-2 gap-6" data-count="{{ count($featuresContent['items'] ?? []) > 0 ? count($featuresContent['items'] ?? []) : 6 }}">
                    @php 
                        $featureCount = count($featuresContent['items'] ?? []) > 0 ? count($featuresContent['items'] ?? []) : 6;
                    @endphp
                    @for ($i = 0; $i < $featureCount; $i++)
                        @php 
                            $item = $featuresContent['items'][$i] ?? []; 
                            $index = $i + 1;
                        @endphp
                        <div class="feature-item relative group bg-slate-50 p-4 rounded-xl border border-slate-100">
                            <button type="button" class="remove-feature-btn absolute top-2 right-2 text-slate-400 hover:text-red-500 opacity-0 group-hover:opacity-100 transition-opacity p-1">
                                <i class="fas fa-times"></i>
                            </button>
                            <h4 class="text-xs font-bold uppercase text-slate-400 mb-3">Feature <span class="feature-index">{{ $index }}</span></h4>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-xs font-medium text-slate-600 mb-1">Icon Class</label>
                                    <input type="text" name="section_features_item{{ $index }}_icon" value="{{ $item['icon'] ?? '' }}" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm bg-white">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-600 mb-1">Title</label>
                                    <input type="text" name="section_features_item{{ $index }}_title" value="{{ $item['title'] ?? '' }}" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm bg-white">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-600 mb-1">Description</label>
                                    <textarea name="section_features_item{{ $index }}_description" rows="2" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm bg-white">{{ $item['description'] ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
                
                <div class="mt-4 text-center">
                    <button type="button" id="add-feature-btn" class="bg-indigo-50 text-indigo-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-100 transition">
                        <i class="fas fa-plus mr-1"></i> Add More Feature
                    </button>
                </div>
            </div>

            <script>
                // Add new feature
                document.getElementById('add-feature-btn').addEventListener('click', function() {
                    const container = document.getElementById('features-container');
                    let count = parseInt(container.getAttribute('data-count'));
                    count++;
                    container.setAttribute('data-count', count);
                    
                    const newItem = document.createElement('div');
                    newItem.className = 'feature-item relative group bg-slate-50 p-4 rounded-xl border border-slate-100';
                    newItem.innerHTML = `
                        <button type="button" class="remove-feature-btn absolute top-2 right-2 text-slate-400 hover:text-red-500 opacity-0 group-hover:opacity-100 transition-opacity p-1">
                            <i class="fas fa-times"></i>
                        </button>
                        <h4 class="text-xs font-bold uppercase text-slate-400 mb-3">Feature <span class="feature-index">${count}</span></h4>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1">Icon Class</label>
                                <input type="text" name="section_features_item${count}_icon" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm bg-white">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1">Title</label>
                                <input type="text" name="section_features_item${count}_title" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm bg-white">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1">Description</label>
                                <textarea name="section_features_item${count}_description" rows="2" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm bg-white"></textarea>
                            </div>
                        </div>
                    `;
                    container.appendChild(newItem);
                });

                // Remove feature
                document.getElementById('features-container').addEventListener('click', function(e) {
                    if (e.target.closest('.remove-feature-btn')) {
                        if(confirm('Are you sure you want to remove this feature?')) {
                            e.target.closest('.feature-item').remove();
                        }
                    }
                });
            </script>

            <!-- Testimonials Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                    <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center text-orange-600">
                        <i class="fas fa-comments"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Testimonials Section</h2>
                        <p class="text-xs text-slate-500">Manage customer testimonials</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Section Title</label>
                        <input type="text" name="section_testimonials_title" value="{{ $testimonialsContent['title'] ?? 'What Our Customers Say' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Section Description</label>
                        <input type="text" name="section_testimonials_description" value="{{ $testimonialsContent['description'] ?? 'Real reviews from real customers' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 text-sm">
                    </div>
                </div>

                <div id="testimonials-container" class="grid grid-cols-1 gap-4" data-count="{{ count($testimonialsContent['items'] ?? []) > 0 ? count($testimonialsContent['items'] ?? []) : 3 }}">
                    @php 
                        $testimonialCount = count($testimonialsContent['items'] ?? []) > 0 ? count($testimonialsContent['items'] ?? []) : 3;
                        $defaultTestimonials = [
                            ['name' => 'Sarah Johnson', 'role' => 'Verified Buyer', 'content' => 'Amazing quality and fast delivery!', 'image' => 'https://i.pravatar.cc/100?img=1', 'rating' => 5],
                            ['name' => 'Michael Chen', 'role' => 'Verified Buyer', 'content' => 'Best online shopping experience ever!', 'image' => 'https://i.pravatar.cc/100?img=3', 'rating' => 5],
                            ['name' => 'Emily Rodriguez', 'role' => 'Verified Buyer', 'content' => 'Great prices and authentic products!', 'image' => 'https://i.pravatar.cc/100?img=5', 'rating' => 5],
                        ];
                    @endphp
                    @for ($i = 0; $i < $testimonialCount; $i++)
                        @php 
                            $item = $testimonialsContent['items'][$i] ?? $defaultTestimonials[$i] ?? []; 
                            $index = $i + 1;
                        @endphp
                        <div class="testimonial-item relative group bg-slate-50 p-4 rounded-xl border border-slate-100">
                            <button type="button" class="remove-testimonial-btn absolute top-2 right-2 text-slate-400 hover:text-red-500 opacity-0 group-hover:opacity-100 transition-opacity p-1">
                                <i class="fas fa-times"></i>
                            </button>
                            <h4 class="text-xs font-bold uppercase text-slate-400 mb-3">Testimonial <span class="testimonial-index">{{ $index }}</span></h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-3">
                                    <div>
                                        <label class="block text-xs font-medium text-slate-600 mb-1">Customer Name</label>
                                        <input type="text" name="section_testimonials_item{{ $index }}_name" value="{{ $item['name'] ?? '' }}" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm bg-white">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-600 mb-1">Role/Title</label>
                                        <input type="text" name="section_testimonials_item{{ $index }}_role" value="{{ $item['role'] ?? 'Verified Buyer' }}" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm bg-white">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-600 mb-1">Rating (1-5)</label>
                                        <input type="number" name="section_testimonials_item{{ $index }}_rating" value="{{ $item['rating'] ?? 5 }}" min="1" max="5" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm bg-white">
                                    </div>
                                </div>
                                <div class="space-y-3">
                                    <div>
                                        <label class="block text-xs font-medium text-slate-600 mb-1">Image URL</label>
                                        <input type="text" name="section_testimonials_item{{ $index }}_image" value="{{ $item['image'] ?? '' }}" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm bg-white">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-600 mb-1">Testimonial Content</label>
                                        <textarea name="section_testimonials_item{{ $index }}_content" rows="3" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm bg-white">{{ $item['content'] ?? '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
                
                <div class="mt-4 text-center">
                    <button type="button" id="add-testimonial-btn" class="bg-orange-50 text-orange-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-orange-100 transition">
                        <i class="fas fa-plus mr-1"></i> Add More Testimonial
                    </button>
                </div>
            </div>

            <script>
                // Add new testimonial
                document.getElementById('add-testimonial-btn')?.addEventListener('click', function() {
                    const container = document.getElementById('testimonials-container');
                    let count = parseInt(container.getAttribute('data-count'));
                    count++;
                    container.setAttribute('data-count', count);
                    
                    const newItem = document.createElement('div');
                    newItem.className = 'testimonial-item relative group bg-slate-50 p-4 rounded-xl border border-slate-100';
                    newItem.innerHTML = `
                        <button type="button" class="remove-testimonial-btn absolute top-2 right-2 text-slate-400 hover:text-red-500 opacity-0 group-hover:opacity-100 transition-opacity p-1">
                            <i class="fas fa-times"></i>
                        </button>
                        <h4 class="text-xs font-bold uppercase text-slate-400 mb-3">Testimonial <span class="testimonial-index">${count}</span></h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-xs font-medium text-slate-600 mb-1">Customer Name</label>
                                    <input type="text" name="section_testimonials_item${count}_name" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm bg-white">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-600 mb-1">Role/Title</label>
                                    <input type="text" name="section_testimonials_item${count}_role" value="Verified Buyer" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm bg-white">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-600 mb-1">Rating (1-5)</label>
                                    <input type="number" name="section_testimonials_item${count}_rating" value="5" min="1" max="5" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm bg-white">
                                </div>
                            </div>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-xs font-medium text-slate-600 mb-1">Image URL</label>
                                    <input type="text" name="section_testimonials_item${count}_image" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm bg-white">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-600 mb-1">Testimonial Content</label>
                                    <textarea name="section_testimonials_item${count}_content" rows="3" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm bg-white"></textarea>
                                </div>
                            </div>
                        </div>
                    `;
                    container.appendChild(newItem);
                });

                // Remove testimonial
                document.getElementById('testimonials-container')?.addEventListener('click', function(e) {
                    if (e.target.closest('.remove-testimonial-btn')) {
                        if(confirm('Are you sure you want to remove this testimonial?')) {
                            e.target.closest('.testimonial-item').remove();
                        }
                    }
                });
            </script>

@elseif($page->slug === 'categories')
            <!-- Categories Page Specific Sections -->
            @php
                $hero = $page->sections->where('key', 'hero')->first();
                $heroContent = $hero ? $hero->content : [];

                $banner = $page->sections->where('key', 'banner')->first();
                $bannerContent = $banner ? $banner->content : [];
            @endphp

            <!-- Hero Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                    <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                        <i class="fas fa-star"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Hero Section</h2>
                        <p class="text-xs text-slate-500">Main top section of the page</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Badge Text</label>
                            <input type="text" name="section_hero_badge_text" value="{{ $heroContent['badge_text'] ?? '' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-primary transition-all text-sm" placeholder="e.g. 1000+ Premium Products">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Title Prefix</label>
                            <input type="text" name="section_hero_title_prefix" value="{{ $heroContent['title_prefix'] ?? '' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-primary transition-all text-sm" placeholder="e.g. Explore Our">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Title Suffix (Highlighted)</label>
                            <input type="text" name="section_hero_title_suffix" value="{{ $heroContent['title_suffix'] ?? '' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-primary transition-all text-sm" placeholder="e.g. Amazing Categories">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Button Text</label>
                            <input type="text" name="section_hero_button_text" value="{{ $heroContent['button_text'] ?? '' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-primary transition-all text-sm" placeholder="e.g. Start Shopping">
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Description</label>
                            <textarea name="section_hero_description" rows="4" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-primary transition-all text-sm" placeholder="Enter hero description text">{{ $heroContent['description'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Stats Labels -->
                <div class="mt-6 pt-6 border-t border-slate-100">
                    <h3 class="text-sm font-semibold text-slate-700 mb-4 flex items-center gap-2">
                        <i class="fas fa-chart-bar text-purple-500"></i> Stats Section Labels
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Categories Label</label>
                            <input type="text" name="section_hero_stats_categories_label" value="{{ $heroContent['stats_categories_label'] ?? 'Categories' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-primary transition-all text-sm" placeholder="Categories">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Products Label</label>
                            <input type="text" name="section_hero_stats_products_label" value="{{ $heroContent['stats_products_label'] ?? 'Products' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-primary transition-all text-sm" placeholder="Products">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Support Label</label>
                            <input type="text" name="section_hero_stats_support_label" value="{{ $heroContent['stats_support_label'] ?? 'Support' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-primary transition-all text-sm" placeholder="Support">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Banner Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                    <div class="w-10 h-10 rounded-lg bg-pink-100 flex items-center justify-center text-pink-600">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Banner / CTA Section</h2>
                        <p class="text-xs text-slate-500">Call to action section above footer</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Title</label>
                            <input type="text" name="section_banner_title" value="{{ $bannerContent['title'] ?? '' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-pink-500/20 focus:border-pink-500 transition-all text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Button Text</label>
                            <input type="text" name="section_banner_button_text" value="{{ $bannerContent['button_text'] ?? '' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-pink-500/20 focus:border-pink-500 transition-all text-sm">
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Description</label>
                            <textarea name="section_banner_description" rows="4" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-pink-500/20 focus:border-pink-500 transition-all text-sm">{{ $bannerContent['description'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

        @elseif($page->slug === 'deals')
            <!-- Deals Page Specific Sections -->
            @php
                $hero = $page->sections->where('key', 'hero')->first();
                $heroContent = $hero ? $hero->content : [];

                $lightningDeals = $page->sections->where('key', 'lightning_deals')->first();
                $lightningDealsContent = $lightningDeals ? $lightningDeals->content : [];

                $topDeals = $page->sections->where('key', 'top_deals')->first();
                $topDealsContent = $topDeals ? $topDeals->content : [];

                $categoryDeals = $page->sections->where('key', 'category_deals')->first();
                $categoryDealsContent = $categoryDeals ? $categoryDeals->content : [];

                $newsletter = $page->sections->where('key', 'newsletter')->first();
                $newsletterContent = $newsletter ? $newsletter->content : [];
            @endphp

            <!-- Hero Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                    <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center text-red-600">
                        <i class="fas fa-fire"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Deals Page Hero</h2>
                        <p class="text-xs text-slate-500">Manage the hero banner section of the deals page</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Badge Text</label>
                            <input type="text" name="section_hero_badge_text" value="{{ $heroContent['badge_text'] ?? 'Limited Time Only' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Main Title</label>
                            <input type="text" name="section_hero_title" value="{{ $heroContent['title'] ?? 'Super Hot Deals' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all text-sm">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Description</label>
                        <textarea name="section_hero_description" rows="4" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all text-sm">{{ $heroContent['description'] ?? 'Unbeatable prices on your favorite items.' }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Lightning Deals Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                    <div class="w-10 h-10 rounded-lg bg-yellow-100 flex items-center justify-center text-yellow-600">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Lightning Deals Section</h2>
                        <p class="text-xs text-slate-500">Configure the lightning deals countdown section</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Section Title</label>
                            <input type="text" name="section_lightning_deals_title" value="{{ $lightningDealsContent['title'] ?? 'Lightning Fast Deals' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-yellow-500/20 focus:border-yellow-500 transition-all text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Subtitle</label>
                            <input type="text" name="section_lightning_deals_subtitle" value="{{ $lightningDealsContent['subtitle'] ?? 'Offers expire soon • Limited quantities' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-yellow-500/20 focus:border-yellow-500 transition-all text-sm">
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Countdown Duration (Hours)</label>
                            <input type="number" name="section_lightning_deals_countdown_hours" value="{{ $lightningDealsContent['countdown_hours'] ?? 24 }}" min="1" max="168" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-yellow-500/20 focus:border-yellow-500 transition-all text-sm">
                            <p class="text-xs text-slate-400 mt-1">The countdown timer duration in hours (1-168)</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Deals Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                    <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center text-orange-600">
                        <i class="fas fa-star"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Top Deals Section</h2>
                        <p class="text-xs text-slate-500">Configure the top deals of the day section</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Section Title</label>
                        <input type="text" name="section_top_deals_title" value="{{ $topDealsContent['title'] ?? 'TOP DEALS OF THE DAY' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Description</label>
                        <input type="text" name="section_top_deals_description" value="{{ $topDealsContent['description'] ?? 'Our most popular discounted items, updated daily.' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all text-sm">
                    </div>
                </div>
            </div>

            <!-- Category Deals Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                    <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center text-purple-600">
                        <i class="fas fa-th-large"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Deals by Category Section</h2>
                        <p class="text-xs text-slate-500">Configure the category deals carousel section</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Section Title</label>
                        <input type="text" name="section_category_deals_title" value="{{ $categoryDealsContent['title'] ?? 'Deals by Category' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Subtitle</label>
                        <input type="text" name="section_category_deals_subtitle" value="{{ $categoryDealsContent['subtitle'] ?? 'Discover amazing offers in every category' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all text-sm">
                    </div>
                </div>
            </div>

            <!-- Newsletter/CTA Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                    <div class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center text-emerald-600">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Newsletter / CTA Section</h2>
                        <p class="text-xs text-slate-500">Configure the call-to-action section at the bottom</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Title</label>
                            <input type="text" name="section_newsletter_title" value="{{ $newsletterContent['title'] ?? 'DON\'T MISS THE NEXT DEAL!' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Description</label>
                            <textarea name="section_newsletter_description" rows="3" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all text-sm">{{ $newsletterContent['description'] ?? 'Be the first to know about our exclusive limited-time discounts.' }}</textarea>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Button Text</label>
                            <input type="text" name="section_newsletter_button_text" value="{{ $newsletterContent['button_text'] ?? 'Shop Now' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Button URL</label>
                            <input type="text" name="section_newsletter_button_url" value="{{ $newsletterContent['button_url'] ?? '/shop' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all text-sm">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dynamic Content Notice -->
            <div class="bg-amber-50 rounded-2xl border border-amber-200 p-6">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center text-amber-600 flex-shrink-0">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-amber-800">Dynamic Content Notice</h3>
                        <p class="text-sm text-amber-700 mt-1">
                            The products shown on the Deals page are managed directly from the <strong>Products</strong> and <strong>Categories</strong> management pages.
                        </p>
                        <ul class="text-sm text-amber-700 mt-2 list-disc list-inside space-y-1">
                            <li>Mark products as "Deal Product" to show them in the Top Deals and Lightning Deals sections.</li>
                            <li>Mark categories as "Deal Category" to group deals by those categories.</li>
                        </ul>
                        <div class="mt-4 flex gap-3">
                            <a href="{{ route('admin.products.index') }}" class="text-xs bg-amber-600 text-white px-3 py-1.5 rounded-lg font-bold hover:bg-amber-700 transition">Go to Products</a>
                            <a href="{{ route('admin.categories.index') }}" class="text-xs bg-white text-amber-600 px-3 py-1.5 rounded-lg font-bold border border-amber-300 hover:bg-amber-50 transition">Go to Categories</a>
                        </div>
                    </div>
                </div>
            </div>


        @elseif($page->slug === 'about-us')
            <!-- About Us Page Specific Sections -->
            @php
                $hero = $page->sections->where('key', 'hero')->first();
                $heroContent = $hero ? $hero->content : [];

                $stats = $page->sections->where('key', 'stats')->first();
                $statsContent = $stats ? $stats->content : [];

                $story = $page->sections->where('key', 'story')->first();
                $storyContent = $story ? $story->content : [];

                $values = $page->sections->where('key', 'values')->first();
                $valuesContent = $values ? $values->content : [];

                $team = $page->sections->where('key', 'team')->first();
                $teamContent = $team ? $team->content : [];

                $whyChooseUs = $page->sections->where('key', 'why_choose_us')->first();
                $whyChooseUsContent = $whyChooseUs ? $whyChooseUs->content : [];

                $cta = $page->sections->where('key', 'cta')->first();
                $ctaContent = $cta ? $cta->content : [];
            @endphp

            <!-- Hero Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                    <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600">
                        <i class="fas fa-star"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Hero Section</h2>
                        <p class="text-xs text-slate-500">Main banner with animated background</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Badge Text</label>
                            <input type="text" name="section_hero_badge_text" value="{{ $heroContent['badge_text'] ?? '' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm" placeholder="e.g. ABOUT ECOM ALPHA">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Main Title</label>
                            <input type="text" name="section_hero_title" value="{{ $heroContent['title'] ?? '' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm" placeholder="e.g. We Make Shopping">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Subtitle (Highlighted)</label>
                            <input type="text" name="section_hero_subtitle" value="{{ $heroContent['subtitle'] ?? '' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm" placeholder="e.g. Simple & Joyful">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Description</label>
                            <textarea name="section_hero_description" rows="4" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm" placeholder="Enter hero description">{{ $heroContent['description'] ?? '' }}</textarea>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <!-- Button 1 -->
                        <div class="border border-slate-200 rounded-lg p-4 bg-slate-50">
                            <h3 class="text-sm font-semibold text-slate-700 mb-3 flex items-center gap-2">
                                <i class="fas fa-link text-blue-500"></i> Primary Button
                            </h3>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-xs font-medium text-slate-600 mb-1">Button Text</label>
                                    <input type="text" name="section_hero_button1_text" value="{{ $heroContent['buttons'][0]['text'] ?? '' }}" class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm" placeholder="e.g. Start Shopping">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-600 mb-1">Button URL</label>
                                    <input type="text" name="section_hero_button1_url" value="{{ $heroContent['buttons'][0]['url'] ?? '' }}" class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm" placeholder="e.g. /shop">
                                </div>
                            </div>
                        </div>

                        <!-- Button 2 -->
                        <div class="border border-slate-200 rounded-lg p-4 bg-slate-50">
                            <h3 class="text-sm font-semibold text-slate-700 mb-3 flex items-center gap-2">
                                <i class="fas fa-link text-purple-500"></i> Secondary Button
                            </h3>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-xs font-medium text-slate-600 mb-1">Button Text</label>
                                    <input type="text" name="section_hero_button2_text" value="{{ $heroContent['buttons'][1]['text'] ?? '' }}" class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-primary transition-all text-sm" placeholder="e.g. Contact Us">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-600 mb-1">Button URL</label>
                                    <input type="text" name="section_hero_button2_url" value="{{ $heroContent['buttons'][1]['url'] ?? '' }}" class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-primary transition-all text-sm" placeholder="e.g. /contact">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                    <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center text-green-600">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Stats Section</h2>
                        <p class="text-xs text-slate-500">Display key statistics and achievements</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Section Title</label>
                        <input type="text" name="section_stats_title" value="{{ $statsContent['title'] ?? '' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:border-green-500 transition-all text-sm" placeholder="e.g. Our Impact in Numbers">
                    </div>

                    <!-- Stats Items Repeater -->
                    <div x-data="{ items: {{ json_encode($statsContent['stats'] ?? []) }} }">
                        <label class="block text-sm font-medium text-slate-700 mb-3">Stats Items</label>

                        <div class="space-y-3">
                            <template x-for="(item, index) in items" :key="index">
                                <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 relative group transition-all hover:border-green-200">
                                    <button type="button" @click="items.splice(index, 1)" class="absolute -top-2 -right-2 w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-200 shadow-sm border border-red-200">
                                        <i class="fas fa-times text-xs"></i>
                                    </button>

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-500 mb-1 uppercase tracking-wider">Number</label>
                                            <input type="text" :name="'section_stats_stats[' + index + '][number]'" x-model="item.number" class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-green-500/20 focus:border-green-500 text-sm" placeholder="e.g. 10K+">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-500 mb-1 uppercase tracking-wider">Label</label>
                                            <input type="text" :name="'section_stats_stats[' + index + '][label]'" x-model="item.label" class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-green-500/20 focus:border-green-500 text-sm" placeholder="e.g. Happy Customers">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-500 mb-1 uppercase tracking-wider">Icon (FontAwesome)</label>
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                                    <i :class="'fas ' + (item.icon || 'fa-chart-line')"></i>
                                                </div>
                                                <input type="text" :name="'section_stats_stats[' + index + '][icon]'" x-model="item.icon" class="w-full pl-10 pr-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-green-500/20 focus:border-green-500 text-sm" placeholder="e.g. fa-users">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <button type="button" @click="items.push({number: '', label: '', icon: 'fa-chart-line'})" class="mt-4 flex items-center gap-2 text-sm font-bold text-green-600 hover:text-green-700 transition-colors bg-green-50 px-4 py-2 rounded-lg border border-green-100 hover:border-green-200">
                            <i class="fas fa-plus-circle"></i> Add New Stat
                        </button>
                    </div>
                </div>
            </div>

            <!-- Story Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                    <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Story Section</h2>
                        <p class="text-xs text-slate-500">Tell your company's journey</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Title</label>
                            <input type="text" name="section_story_title" value="{{ $storyContent['title'] ?? '' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-primary transition-all text-sm" placeholder="e.g. Our Journey">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Subtitle</label>
                            <input type="text" name="section_story_subtitle" value="{{ $storyContent['subtitle'] ?? '' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-primary transition-all text-sm" placeholder="e.g. How It All Started">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Content</label>
                            <textarea name="section_story_content" rows="6" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-primary transition-all text-sm" placeholder="Enter your story">{{ $storyContent['content'] ?? '' }}</textarea>
                        </div>
                    </div>

                    <!-- Features Repeater -->
                    <div x-data="{ items: {{ json_encode($storyContent['features'] ?? []) }} }">
                        <label class="block text-sm font-medium text-slate-700 mb-3">Key Features</label>

                        <div class="space-y-3 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                            <template x-for="(item, index) in items" :key="index">
                                <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 relative group transition-all hover:border-purple-200">
                                    <button type="button" @click="items.splice(index, 1)" class="absolute -top-2 -right-2 w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-200 shadow-sm border border-red-200 z-10">
                                        <i class="fas fa-times text-xs"></i>
                                    </button>

                                    <div class="space-y-3">
                                        <div class="flex gap-4">
                                            <div class="flex-1">
                                                <label class="block text-xs font-semibold text-slate-500 mb-1 uppercase tracking-wider">Feature Title</label>
                                                <input type="text" :name="'section_story_features[' + index + '][title]'" x-model="item.title" class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-purple-500/20 focus:border-primary text-sm" placeholder="e.g. Innovation First">
                                            </div>
                                            <div class="w-1/3">
                                                <label class="block text-xs font-semibold text-slate-500 mb-1 uppercase tracking-wider">Icon</label>
                                                <div class="relative">
                                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                                        <i :class="'fas ' + (item.icon || 'fa-star')"></i>
                                                    </div>
                                                    <input type="text" :name="'section_story_features[' + index + '][icon]'" x-model="item.icon" class="w-full pl-9 pr-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-purple-500/20 focus:border-primary text-sm" placeholder="fa-icon">
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-500 mb-1 uppercase tracking-wider">Description</label>
                                            <textarea rows="2" :name="'section_story_features[' + index + '][description]'" x-model="item.description" class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-purple-500/20 focus:border-primary text-sm" placeholder="Short description..."></textarea>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <button type="button" @click="items.push({title: '', description: '', icon: 'fa-star'})" class="mt-4 w-full flex items-center justify-center gap-2 text-sm font-bold text-primary hover:text-primary/80 transition-colors bg-primary/10 px-4 py-2 rounded-lg border border-primary/20 hover:border-primary/30">
                            <i class="fas fa-plus-circle"></i> Add New Feature
                        </button>
                    </div>
                </div>
            </div>
            </div>

            <!-- Values Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                    <div class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center text-indigo-600">
                        <i class="fas fa-heart"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Values Section</h2>
                        <p class="text-xs text-slate-500">Showcase your core values</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Title</label>
                            <input type="text" name="section_values_title" value="{{ $valuesContent['title'] ?? '' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all text-sm" placeholder="e.g. Our Core Values">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Subtitle</label>
                            <input type="text" name="section_values_subtitle" value="{{ $valuesContent['subtitle'] ?? '' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all text-sm" placeholder="e.g. What Drives Us Every Day">
                        </div>
                    </div>

                    <!-- Values Repeater -->
                    <div x-data="{ items: {{ json_encode($valuesContent['values'] ?? []) }} }">
                        <label class="block text-sm font-medium text-slate-700 mb-3">Core Values</label>

                        <div class="space-y-3 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                            <template x-for="(item, index) in items" :key="index">
                                <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 relative group transition-all hover:border-indigo-200">
                                    <button type="button" @click="items.splice(index, 1)" class="absolute -top-2 -right-2 w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-200 shadow-sm border border-red-200 z-10">
                                        <i class="fas fa-times text-xs"></i>
                                    </button>

                                    <div class="space-y-3">
                                        <div class="flex gap-4">
                                            <div class="flex-1">
                                                <label class="block text-xs font-semibold text-slate-500 mb-1 uppercase tracking-wider">Value Title</label>
                                                <input type="text" :name="'section_values_values[' + index + '][title]'" x-model="item.title" class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm" placeholder="e.g. Integrity">
                                            </div>
                                            <div class="w-1/3">
                                                <label class="block text-xs font-semibold text-slate-500 mb-1 uppercase tracking-wider">Icon</label>
                                                <div class="relative">
                                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                                        <i :class="'fas ' + (item.icon || 'fa-heart')"></i>
                                                    </div>
                                                    <input type="text" :name="'section_values_values[' + index + '][icon]'" x-model="item.icon" class="w-full pl-9 pr-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm" placeholder="fa-icon">
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-500 mb-1 uppercase tracking-wider">Description</label>
                                            <textarea rows="2" :name="'section_values_values[' + index + '][description]'" x-model="item.description" class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm" placeholder="Briefly explain this value..."></textarea>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <button type="button" @click="items.push({title: '', description: '', icon: 'fa-heart'})" class="mt-4 w-full flex items-center justify-center gap-2 text-sm font-bold text-indigo-600 hover:text-indigo-700 transition-colors bg-indigo-50 px-4 py-2 rounded-lg border border-indigo-100 hover:border-indigo-200">
                            <i class="fas fa-plus-circle"></i> Add New Value
                        </button>
                    </div>
                </div>
            </div>

            <!-- Team Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                    <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center text-orange-600">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Team Section</h2>
                        <p class="text-xs text-slate-500">Introduce your team members</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Title</label>
                            <input type="text" name="section_team_title" value="{{ $teamContent['title'] ?? '' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all text-sm" placeholder="e.g. Meet Our Team">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Subtitle</label>
                            <input type="text" name="section_team_subtitle" value="{{ $teamContent['subtitle'] ?? '' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all text-sm" placeholder="e.g. The People Behind Our Success">
                        </div>
                    </div>

                    <!-- Team Repeater -->
                    <div x-data="{ items: {{ json_encode($teamContent['members'] ?? []) }} }">
                        <label class="block text-sm font-medium text-slate-700 mb-3">Team Members</label>

                        <div class="space-y-4 max-h-[500px] overflow-y-auto pr-2 custom-scrollbar">
                            <template x-for="(item, index) in items" :key="index">
                                <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 relative group transition-all hover:border-orange-200">
                                    <button type="button" @click="items.splice(index, 1)" class="absolute -top-2 -right-2 w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-200 shadow-sm border border-red-200 z-10">
                                        <i class="fas fa-times text-xs"></i>
                                    </button>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="space-y-3">
                                            <div>
                                                <label class="block text-xs font-semibold text-slate-500 mb-1 uppercase tracking-wider">Full Name</label>
                                                <input type="text" :name="'section_team_members[' + index + '][name]'" x-model="item.name" class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 text-sm" placeholder="e.g. John Doe">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold text-slate-500 mb-1 uppercase tracking-wider">Position</label>
                                                <input type="text" :name="'section_team_members[' + index + '][position]'" x-model="item.position" class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 text-sm" placeholder="e.g. Founder & CEO">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold text-slate-500 mb-1 uppercase tracking-wider">Bio</label>
                                                <textarea rows="2" :name="'section_team_members[' + index + '][bio]'" x-model="item.bio" class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 text-sm" placeholder="Member bio..."></textarea>
                                            </div>
                                        </div>
                                        <div class="space-y-3">
                                            <div>
                                                <label class="block text-xs font-semibold text-slate-500 mb-1 uppercase tracking-wider">Profile Image URL</label>
                                                <input type="text" :name="'section_team_members[' + index + '][image]'" x-model="item.image" class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 text-sm" placeholder="Image URL">
                                            </div>
                                            <div class="grid grid-cols-2 gap-2">
                                                <div>
                                                    <label class="block text-xs font-semibold text-slate-500 mb-1 uppercase tracking-wider">Twitter</label>
                                                    <input type="text" :name="'section_team_members[' + index + '][social][twitter]'" x-model="item.social.twitter" class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 text-sm" placeholder="#">
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-semibold text-slate-500 mb-1 uppercase tracking-wider">LinkedIn</label>
                                                    <input type="text" :name="'section_team_members[' + index + '][social][linkedin]'" x-model="item.social.linkedin" class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 text-sm" placeholder="#">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <button type="button" @click="items.push({name: '', position: '', bio: '', image: '', social: {twitter: '#', linkedin: '#'}})" class="mt-4 w-full flex items-center justify-center gap-2 text-sm font-bold text-orange-600 hover:text-orange-700 transition-colors bg-orange-50 px-4 py-2 rounded-lg border border-orange-100 hover:border-orange-200">
                            <i class="fas fa-plus-circle"></i> Add Team Member
                        </button>
                    </div>
                </div>
            </div>

            <!-- Why Choose Us Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                    <div class="w-10 h-10 rounded-lg bg-teal-100 flex items-center justify-center text-teal-600">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Why Choose Us Section</h2>
                        <p class="text-xs text-slate-500">Highlight your unique advantages</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Title</label>
                            <input type="text" name="section_why_choose_us_title" value="{{ $whyChooseUsContent['title'] ?? '' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all text-sm" placeholder="e.g. Why Choose Us">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Subtitle</label>
                            <input type="text" name="section_why_choose_us_subtitle" value="{{ $whyChooseUsContent['subtitle'] ?? '' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all text-sm" placeholder="e.g. What Makes Us Different">
                        </div>
                    </div>

                    <!-- Reasons Repeater -->
                    <div x-data="{ items: {{ json_encode($whyChooseUsContent['reasons'] ?? []) }} }">
                        <label class="block text-sm font-medium text-slate-700 mb-3">Unique Selling Points</label>

                        <div class="space-y-3 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                            <template x-for="(item, index) in items" :key="index">
                                <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 relative group transition-all hover:border-teal-200">
                                    <button type="button" @click="items.splice(index, 1)" class="absolute -top-2 -right-2 w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-200 shadow-sm border border-red-200 z-10">
                                        <i class="fas fa-times text-xs"></i>
                                    </button>

                                    <div class="space-y-3">
                                        <div class="flex gap-4">
                                            <div class="flex-1">
                                                <label class="block text-xs font-semibold text-slate-500 mb-1 uppercase tracking-wider">Reason Title</label>
                                                <input type="text" :name="'section_why_choose_us_reasons[' + index + '][title]'" x-model="item.title" class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 text-sm" placeholder="e.g. Best Quality">
                                            </div>
                                            <div class="w-1/3">
                                                <label class="block text-xs font-semibold text-slate-500 mb-1 uppercase tracking-wider">Icon</label>
                                                <div class="relative">
                                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                                        <i :class="'fas ' + (item.icon || 'fa-gem')"></i>
                                                    </div>
                                                    <input type="text" :name="'section_why_choose_us_reasons[' + index + '][icon]'" x-model="item.icon" class="w-full pl-9 pr-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 text-sm" placeholder="fa-gem">
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-500 mb-1 uppercase tracking-wider">Description</label>
                                            <textarea rows="2" :name="'section_why_choose_us_reasons[' + index + '][description]'" x-model="item.description" class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 text-sm" placeholder="Briefly explain this reason..."></textarea>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <button type="button" @click="items.push({title: '', description: '', icon: 'fa-gem'})" class="mt-4 w-full flex items-center justify-center gap-2 text-sm font-bold text-teal-600 hover:text-teal-700 transition-colors bg-teal-50 px-4 py-2 rounded-lg border border-teal-100 hover:border-teal-200">
                            <i class="fas fa-plus-circle"></i> Add New Reason
                        </button>
                    </div>
                </div>
            </div>

            <!-- CTA Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                    <div class="w-10 h-10 rounded-lg bg-pink-100 flex items-center justify-center text-pink-600">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">CTA Section</h2>
                        <p class="text-xs text-slate-500">Call to action at the bottom</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Title</label>
                            <input type="text" name="section_cta_title" value="{{ $ctaContent['title'] ?? '' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-pink-500/20 focus:border-pink-500 transition-all text-sm" placeholder="e.g. Ready to Get Started?">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Description</label>
                            <textarea name="section_cta_description" rows="4" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-pink-500/20 focus:border-pink-500 transition-all text-sm" placeholder="Enter CTA description">{{ $ctaContent['description'] ?? '' }}</textarea>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <!-- Button 1 -->
                        <div class="border border-slate-200 rounded-lg p-4 bg-slate-50">
                            <h3 class="text-sm font-semibold text-slate-700 mb-3 flex items-center gap-2">
                                <i class="fas fa-link text-pink-500"></i> Primary Button
                            </h3>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-xs font-medium text-slate-600 mb-1">Button Text</label>
                                    <input type="text" name="section_cta_button1_text" value="{{ $ctaContent['buttons'][0]['text'] ?? '' }}" class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-pink-500/20 focus:border-pink-500 transition-all text-sm" placeholder="e.g. Shop Now">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-600 mb-1">Button URL</label>
                                    <input type="text" name="section_cta_button1_url" value="{{ $ctaContent['buttons'][0]['url'] ?? '' }}" class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-pink-500/20 focus:border-pink-500 transition-all text-sm" placeholder="e.g. /shop">
                                </div>
                            </div>
                        </div>

                        <!-- Button 2 -->
                        <div class="border border-slate-200 rounded-lg p-4 bg-slate-50">
                            <h3 class="text-sm font-semibold text-slate-700 mb-3 flex items-center gap-2">
                                <i class="fas fa-link text-purple-500"></i> Secondary Button
                            </h3>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-xs font-medium text-slate-600 mb-1">Button Text</label>
                                    <input type="text" name="section_cta_button2_text" value="{{ $ctaContent['buttons'][1]['text'] ?? '' }}" class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-primary transition-all text-sm" placeholder="e.g. Contact Us">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-600 mb-1">Button URL</label>
                                    <input type="text" name="section_cta_button2_url" value="{{ $ctaContent['buttons'][1]['url'] ?? '' }}" class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-primary transition-all text-sm" placeholder="e.g. /contact">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @elseif($page->slug === 'contact-us')
            <!-- Contact Us Page Specific Sections -->
            @php
                $hero = $page->sections->where('key', 'hero')->first();
                $heroContent = $hero ? $hero->content : [];

                $contactInfo = $page->sections->where('key', 'contact_info')->first();
                $contactInfoContent = $contactInfo ? $contactInfo->content : [];

                $formArea = $page->sections->where('key', 'form_area')->first();
                $formAreaContent = $formArea ? $formArea->content : [];

                $sidebar = $page->sections->where('key', 'sidebar')->first();
                $sidebarContent = $sidebar ? $sidebar->content : [];

                $map = $page->sections->where('key', 'map')->first();
                $mapContent = $map ? $map->content : [];

                $cta = $page->sections->where('key', 'cta')->first();
                $ctaContent = $cta ? $cta->content : [];
            @endphp

            <!-- Hero Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                    <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                        <i class="fas fa-headset"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Hero Section</h2>
                        <p class="text-xs text-slate-500">Top banner and quick stats</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Badge Text</label>
                            <input type="text" name="section_hero_badge_text" value="{{ $heroContent['badge_text'] ?? '' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-primary transition-all text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Title Prefix</label>
                            <input type="text" name="section_hero_title_prefix" value="{{ $heroContent['title_prefix'] ?? '' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-primary transition-all text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Title Suffix (Highlighted)</label>
                            <input type="text" name="section_hero_title_suffix" value="{{ $heroContent['title_suffix'] ?? '' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-primary transition-all text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Description</label>
                            <textarea name="section_hero_description" rows="3" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-primary transition-all text-sm">{{ $heroContent['description'] ?? '' }}</textarea>
                        </div>
                    </div>

                    <!-- Hero Stats Repeater -->
                    <div x-data="{ items: {{ json_encode($heroContent['stats'] ?? []) }} }">
                        <label class="block text-sm font-medium text-slate-700 mb-3">Quick Contact Stats</label>
                        <div class="space-y-3">
                            <template x-for="(item, index) in items" :key="index">
                                <div class="bg-slate-50 border border-slate-200 rounded-xl p-3 relative group">
                                    <button type="button" @click="items.splice(index, 1)" class="absolute -top-2 -right-2 w-6 h-6 rounded-full bg-red-100 text-red-600 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-200">
                                        <i class="fas fa-times text-xs"></i>
                                    </button>
                                    <div class="grid grid-cols-2 gap-3">
                                        <input type="text" :name="'section_hero_stats[' + index + '][value]'" x-model="item.value" class="w-full px-3 py-1.5 rounded border border-slate-200 text-sm" placeholder="Value (e.g. 24/7)">
                                        <input type="text" :name="'section_hero_stats[' + index + '][label]'" x-model="item.label" class="w-full px-3 py-1.5 rounded border border-slate-200 text-sm" placeholder="Label (e.g. Support)">
                                    </div>
                                </div>
                            </template>
                        </div>
                        <button type="button" @click="items.push({value: '', label: ''})" class="mt-3 text-xs font-bold text-primary hover:text-primary/80 bg-primary/10 px-3 py-1.5 rounded-lg border border-primary/20">
                            + Add Stat
                        </button>
                    </div>
                </div>
            </div>

            <!-- Contact Methods Cards -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                    <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600">
                        <i class="fas fa-address-card"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Contact Methods</h2>
                        <p class="text-xs text-slate-500">Phone, Email, Address cards</p>
                    </div>
                </div>

                <div x-data="{ items: {{ json_encode($contactInfoContent['cards'] ?? []) }} }">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <template x-for="(item, index) in items" :key="index">
                            <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 relative group">
                                <button type="button" @click="items.splice(index, 1)" class="absolute -top-2 -right-2 w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-200 z-10 shadow-sm border border-red-200">
                                    <i class="fas fa-times text-xs"></i>
                                </button>

                                <div class="space-y-3">
                                    <div class="flex gap-3">
                                        <div class="flex-1">
                                            <label class="text-xs text-slate-500 font-semibold uppercase">Title</label>
                                            <input type="text" :name="'section_contact_info_cards[' + index + '][title]'" x-model="item.title" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm" placeholder="Title">
                                        </div>
                                        <div class="w-1/3">
                                            <label class="text-xs text-slate-500 font-semibold uppercase">Icon</label>
                                            <input type="text" :name="'section_contact_info_cards[' + index + '][icon]'" x-model="item.icon" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm" placeholder="fa-icon">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="text-xs text-slate-500 font-semibold uppercase">Main Info</label>
                                        <input type="text" :name="'section_contact_info_cards[' + index + '][info]'" x-model="item.info" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm" placeholder="e.g. +880 123...">
                                    </div>
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label class="text-xs text-slate-500 font-semibold uppercase">Sub Info</label>
                                            <input type="text" :name="'section_contact_info_cards[' + index + '][subinfo]'" x-model="item.subinfo" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm" placeholder="e.g. Mon-Fri">
                                        </div>
                                        <div>
                                            <label class="text-xs text-slate-500 font-semibold uppercase">Color</label>
                                            <select :name="'section_contact_info_cards[' + index + '][color]'" x-model="item.color" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm">
                                                <option value="blue">Blue</option>
                                                <option value="purple">Purple</option>
                                                <option value="pink">Pink</option>
                                                <option value="green">Green</option>
                                                <option value="orange">Orange</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="text-xs text-slate-500 font-semibold uppercase">Link URL</label>
                                        <input type="text" :name="'section_contact_info_cards[' + index + '][link]'" x-model="item.link" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm" placeholder="tel:...">
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                    <button type="button" @click="items.push({title: 'New Method', icon: 'fa-phone', color: 'blue', link: '#'})" class="mt-4 w-full py-2 bg-blue-50 text-blue-600 font-bold rounded-lg border border-blue-100 hover:bg-blue-100 transition">
                        + Add Contact Method
                    </button>
                </div>
            </div>

            <!-- Form Area & Sidebar -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Form Area -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                        <div class="w-10 h-10 rounded-lg bg-pink-100 flex items-center justify-center text-pink-600">
                            <i class="fas fa-envelope-open-text"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-slate-800">Form Section</h2>
                            <p class="text-xs text-slate-500">Headings for the contact form</p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Badge Text</label>
                            <input type="text" name="section_form_area_badge" value="{{ $formAreaContent['badge'] ?? '' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-pink-500/20 focus:border-pink-500 transition-all text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Title</label>
                            <input type="text" name="section_form_area_title" value="{{ $formAreaContent['title'] ?? '' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-pink-500/20 focus:border-pink-500 transition-all text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Description</label>
                            <textarea name="section_form_area_description" rows="3" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-pink-500/20 focus:border-pink-500 transition-all text-sm">{{ $formAreaContent['description'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Sidebar (FAQ, Hours, Socials) -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                        <div class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center text-indigo-600">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-slate-800">Sidebar Info</h2>
                            <p class="text-xs text-slate-500">FAQ, Hours, Socials</p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <!-- FAQ -->
                        <div class="border-b border-slate-100 pb-4">
                            <h3 class="text-sm font-bold text-slate-800 mb-3">FAQ Card</h3>
                            <div class="space-y-3">
                                <input type="text" name="section_sidebar_faq_title" value="{{ $sidebarContent['faq_title'] ?? '' }}" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm" placeholder="Title">
                                <textarea name="section_sidebar_faq_desc" rows="2" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm" placeholder="Description">{{ $sidebarContent['faq_desc'] ?? '' }}</textarea>
                                <div class="grid grid-cols-2 gap-3">
                                    <input type="text" name="section_sidebar_faq_link_text" value="{{ $sidebarContent['faq_link_text'] ?? '' }}" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm" placeholder="Link Text">
                                    <input type="text" name="section_sidebar_faq_link_url" value="{{ $sidebarContent['faq_link_url'] ?? '' }}" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm" placeholder="Link URL">
                                </div>
                            </div>
                        </div>

                        <!-- Hours -->
                        <div class="border-b border-slate-100 pb-4" x-data="{ items: {{ json_encode($sidebarContent['hours'] ?? []) }} }">
                            <h3 class="text-sm font-bold text-slate-800 mb-3">Office Hours</h3>
                            <input type="text" name="section_sidebar_hours_title" value="{{ $sidebarContent['hours_title'] ?? '' }}" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm mb-3" placeholder="Section Title">

                            <div class="space-y-2 mb-3">
                                <template x-for="(item, index) in items" :key="index">
                                    <div class="flex gap-2 items-center">
                                        <input type="text" :name="'section_sidebar_hours[' + index + '][day]'" x-model="item.day" class="w-1/3 px-2 py-1.5 rounded border border-slate-200 text-xs" placeholder="Day">
                                        <input type="text" :name="'section_sidebar_hours[' + index + '][time]'" x-model="item.time" class="flex-1 px-2 py-1.5 rounded border border-slate-200 text-xs" placeholder="Time">
                                        <button type="button" @click="items.splice(index, 1)" class="text-red-500 hover:text-red-700 px-1"><i class="fas fa-times"></i></button>
                                    </div>
                                </template>
                            </div>
                            <button type="button" @click="items.push({day: '', time: ''})" class="text-xs text-blue-600 hover:underline">+ Add Hours</button>
                            <textarea name="section_sidebar_hours_note" rows="2" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm mt-3" placeholder="Note (e.g. Email support 24/7)">{{ $sidebarContent['hours_note'] ?? '' }}</textarea>
                        </div>

                        <!-- Socials -->
                        <div x-data="{ items: {{ json_encode($sidebarContent['socials'] ?? []) }} }">
                            <h3 class="text-sm font-bold text-slate-800 mb-3">Social Media</h3>
                            <input type="text" name="section_sidebar_social_title" value="{{ $sidebarContent['social_title'] ?? '' }}" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm mb-2" placeholder="Title">
                            <textarea name="section_sidebar_social_desc" rows="2" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm mb-3" placeholder="Description">{{ $sidebarContent['social_desc'] ?? '' }}</textarea>

                            <div class="space-y-2">
                                <template x-for="(item, index) in items" :key="index">
                                    <div class="flex gap-2 items-center">
                                        <input type="text" :name="'section_sidebar_socials[' + index + '][icon]'" x-model="item.icon" class="w-24 px-2 py-1.5 rounded border border-slate-200 text-xs" placeholder="Icon">
                                        <input type="text" :name="'section_sidebar_socials[' + index + '][url]'" x-model="item.url" class="flex-1 px-2 py-1.5 rounded border border-slate-200 text-xs" placeholder="URL">
                                        <button type="button" @click="items.splice(index, 1)" class="text-red-500 hover:text-red-700 px-1"><i class="fas fa-times"></i></button>
                                    </div>
                                </template>
                            </div>
                             <button type="button" @click="items.push({icon: 'fab fa-facebook', url: '#'})" class="text-xs text-blue-600 hover:underline mt-2">+ Add Social</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Map Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                    <div class="w-10 h-10 rounded-lg bg-teal-100 flex items-center justify-center text-teal-600">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Map Section</h2>
                        <p class="text-xs text-slate-500">Address and Map details</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Badge</label>
                            <input type="text" name="section_map_badge" value="{{ $mapContent['badge'] ?? '' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Title</label>
                            <input type="text" name="section_map_title" value="{{ $mapContent['title'] ?? '' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 text-sm">
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Description</label>
                            <textarea name="section_map_description" rows="2" class="w-full px-4 py-2 rounded-lg border border-slate-200 text-sm">{{ $mapContent['description'] ?? '' }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Address Details</label>
                            <textarea name="section_map_address" rows="2" class="w-full px-4 py-2 rounded-lg border border-slate-200 text-sm">{{ $mapContent['address'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Map Image Upload -->
                <div class="mt-6 pt-6 border-t border-slate-100 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-3">Map Image / Screenshot</label>
                        <div class="flex items-start gap-4">
                            <div id="map-image-preview-container" class="{{ !empty($mapContent['image']) ? '' : 'hidden' }} relative group shrink-0">
                                <div class="w-24 h-24 rounded-xl overflow-hidden border border-slate-200 shadow-sm">
                                    <img id="map-image-preview" src="{{ !empty($mapContent['image']) ? asset('storage/' . $mapContent['image']) : '' }}" class="w-full h-full object-cover">
                                </div>
                            </div>

                            <div class="flex-1">
                                <div class="bg-slate-50 border border-slate-200 rounded-xl p-3">
                                    <input type="file" name="section_map_image" 
                                           onchange="previewImage(this, 'map-image-preview', 'map-image-preview-container')"
                                           class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 transition-all cursor-pointer">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-3">Embed Map HTML (Google Maps Iframe)</label>
                        <div class="bg-slate-50 border border-slate-200 rounded-xl p-3">
                            <textarea name="section_map_embed_html" rows="3" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-xs focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all" placeholder="Paste <iframe ...></iframe> here">{{ $mapContent['embed_html'] ?? '' }}</textarea>
                            <p class="text-[10px] text-slate-400 mt-2">
                                <i class="fas fa-info-circle text-teal-500"></i>
                                If provided, this will take priority over the static image.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CTA Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                    <div class="w-10 h-10 rounded-lg bg-yellow-100 flex items-center justify-center text-yellow-600">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">CTA Section</h2>
                        <p class="text-xs text-slate-500">Bottom call to action</p>
                    </div>
                </div>
                <!-- Reuse simple fields for title/desc -->
                <div class="space-y-4 mb-4">
                    <input type="text" name="section_cta_title" value="{{ $ctaContent['title'] ?? '' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 text-sm" placeholder="Title">
                    <textarea name="section_cta_description" rows="2" class="w-full px-4 py-2 rounded-lg border border-slate-200 text-sm" placeholder="Description">{{ $ctaContent['description'] ?? '' }}</textarea>
                </div>

                <!-- CTA Buttons Repeater -->
                <div x-data="{ items: {{ json_encode($ctaContent['buttons'] ?? []) }} }">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Buttons</label>
                    <div class="space-y-3">
                        <template x-for="(item, index) in items" :key="index">
                            <div class="bg-slate-50 p-3 rounded-lg border border-slate-200 grid grid-cols-2 md:grid-cols-4 gap-3">
                                <input type="text" :name="'section_cta_buttons[' + index + '][text]'" x-model="item.text" class="w-full px-2 py-1.5 rounded border text-xs" placeholder="Text">
                                <input type="text" :name="'section_cta_buttons[' + index + '][url]'" x-model="item.url" class="w-full px-2 py-1.5 rounded border text-xs" placeholder="URL">
                                <input type="text" :name="'section_cta_buttons[' + index + '][icon]'" x-model="item.icon" class="w-full px-2 py-1.5 rounded border text-xs" placeholder="Icon">
                                <div class="flex gap-2 items-center">
                                    <select :name="'section_cta_buttons[' + index + '][style]'" x-model="item.style" class="w-full px-2 py-1.5 rounded border text-xs">
                                        <option value="primary">Primary</option>
                                        <option value="secondary">Secondary</option>
                                    </select>
                                    <button type="button" @click="items.splice(index, 1)" class="text-red-500"><i class="fas fa-times"></i></button>
                                </div>
                            </div>
                        </template>
                    </div>
                     <button type="button" @click="items.push({text: 'Button', url: '#', style: 'primary'})" class="mt-2 text-xs text-blue-600 hover:underline">+ Add Button</button>
                </div>
            </div>

        @elseif($page->slug === 'header')
            <!-- Header Page Specific Sections -->
            @php
                $topBar = $page->sections->where('key', 'top_bar')->first();
                $topBarContent = $topBar ? $topBar->content : [];

                $navigation = $page->sections->where('key', 'navigation')->first();
                $navigationContent = $navigation ? $navigation->content : [];

                $brand = $page->sections->where('key', 'brand')->first();
                $brandContent = $brand ? $brand->content : [];
            @endphp

            <!-- Brand & Logo -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                    <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600">
                        <i class="fas fa-flag"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Brand Config</h2>
                        <p class="text-xs text-slate-500">Logo and branding settings</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Header Logo</label>
                        <div class="space-y-3">
                            <div id="header-logo-preview-container" class="{{ isset($brandContent['logo']) && $brandContent['logo'] ? '' : 'hidden' }} relative w-full h-20 bg-slate-100 rounded-lg overflow-hidden group border border-slate-200">
                                <img id="header-logo-preview" 
                                     src="{{ isset($brandContent['logo']) && $brandContent['logo'] ? asset('storage/' . $brandContent['logo']) : '' }}" 
                                     alt="Header Logo Preview" 
                                     class="w-full h-full object-contain">
                            </div>
                            <input type="file" 
                                   name="section_brand_logo" 
                                   accept="image/*" 
                                   onchange="previewImage(this, 'header-logo-preview', 'header-logo-preview-container')"
                                   class="w-full px-4 py-2 rounded-lg border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 transition">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Logo Height (Tailwind class, e.g. 14 for h-14)</label>
                        <input type="text" name="section_brand_logo_height" value="{{ $brandContent['logo_height'] ?? '14' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 text-sm" placeholder="e.g. 14">
                    </div>
                </div>
            </div>

            <!-- Top Bar Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                    <div class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center text-indigo-600">
                        <i class="fas fa-bars"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Top Bar Info</h2>
                        <p class="text-xs text-slate-500">Contact and announcements at the very top</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Phone</label>
                        <input type="text" name="section_top_bar_phone" value="{{ $topBarContent['phone'] ?? '' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                        <input type="text" name="section_top_bar_email" value="{{ $topBarContent['email'] ?? '' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Announcement Text</label>
                        <input type="text" name="section_top_bar_announcement" value="{{ $topBarContent['announcement'] ?? '' }}" class="w-full px-4 py-2 rounded-lg border border-slate-200 text-sm">
                    </div>
                </div>
            </div>

            <!-- Navigation Menu -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6" x-data="{ items: {{ json_encode($navigationContent['items'] ?? []) }} }">
                <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                    <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center text-green-600">
                        <i class="fas fa-compass"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Navigation Menu</h2>
                        <p class="text-xs text-slate-500">Main header links</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <template x-for="(item, index) in items" :key="index">
                        <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 relative group hover:border-green-200 transition-all">
                            <button type="button" @click="items.splice(index, 1)" class="absolute -top-2 -right-2 w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-200 shadow-sm border border-red-200 z-10">
                                <i class="fas fa-times text-xs"></i>
                            </button>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 mb-1 uppercase tracking-wider">Link Name</label>
                                    <input type="text" :name="'section_navigation_item' + (index + 1) + '_name'" x-model="item.name" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm" placeholder="e.g. Home">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 mb-1 uppercase tracking-wider">URL Path</label>
                                    <input type="text" :name="'section_navigation_item' + (index + 1) + '_url'" x-model="item.url" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm" placeholder="e.g. /shop">
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <button type="button" @click="items.push({name: '', url: ''})" class="mt-6 w-full py-3 bg-green-50 text-green-600 font-bold rounded-xl border border-green-100 hover:bg-green-100 hover:border-green-200 transition-all flex items-center justify-center gap-2">
                    <i class="fas fa-plus-circle"></i> Add Menu Item
                </button>
            </div>

        @elseif($page->slug === 'footer')
            <!-- Footer Content Sections -->
            @php
                $companyInfo = $page->sections->where('key', 'company_info')->first();
                $companyInfoContent = $companyInfo ? $companyInfo->content : [];

                $quickLinks = $page->sections->where('key', 'quick_links')->first();
                $quickLinksContent = $quickLinks ? $quickLinks->content : [];

                $customerService = $page->sections->where('key', 'customer_service')->first();
                $customerServiceContent = $customerService ? $customerService->content : [];

                $policies = $page->sections->where('key', 'policies')->first();
                $policiesContent = $policies ? $policies->content : [];

                $contactInfo = $page->sections->where('key', 'contact_info')->first();
                $contactInfoContent = $contactInfo ? $contactInfo->content : [];

                $newsletter = $page->sections->where('key', 'newsletter')->first();
                $newsletterContent = $newsletter ? $newsletter->content : [];

                $bottomFooter = $page->sections->where('key', 'bottom_footer')->first();
                $bottomFooterContent = $bottomFooter ? $bottomFooter->content : [];
            @endphp

            <!-- Company Info & Socials -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                    <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600">
                        <i class="fas fa-building"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Company Info & Social Links</h2>
                        <p class="text-xs text-slate-500">Logo description and social media icons</p>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Footer Logo</label>
                            <div class="space-y-3">
                                <div id="footer-logo-preview-container" class="{{ isset($companyInfoContent['logo']) && $companyInfoContent['logo'] ? '' : 'hidden' }} relative w-full h-20 bg-slate-100 rounded-lg overflow-hidden group border border-slate-200">
                                    <img id="footer-logo-preview" 
                                         src="{{ isset($companyInfoContent['logo']) && $companyInfoContent['logo'] ? asset('storage/' . $companyInfoContent['logo']) : '' }}" 
                                         alt="Footer Logo Preview" 
                                         class="w-full h-full object-contain">
                                </div>
                                <input type="file" 
                                       name="section_company_info_logo" 
                                       accept="image/*" 
                                       onchange="previewImage(this, 'footer-logo-preview', 'footer-logo-preview-container')"
                                       class="w-full px-4 py-2 rounded-lg border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 transition">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Company Description</label>
                            <textarea name="section_company_info_description" rows="5" class="w-full px-4 py-2 rounded-lg border border-slate-200 text-sm">{{ $companyInfoContent['description'] ?? '' }}</textarea>
                        </div>
                    </div>

                    <div x-data="{ items: {{ json_encode($companyInfoContent['items'] ?? []) }} }">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Social Links</label>
                        <div class="space-y-3">
                            <template x-for="(item, index) in items" :key="index">
                                <div class="bg-slate-50 p-3 rounded-lg border border-slate-200 grid grid-cols-1 md:grid-cols-4 gap-3">
                                    <input type="text" :name="'section_company_info_item' + (index + 1) + '_name'" x-model="item.name" class="w-full px-3 py-2 rounded-lg border text-xs" placeholder="Name (e.g. Facebook)">
                                    <input type="text" :name="'section_company_info_item' + (index + 1) + '_url'" x-model="item.url" class="w-full px-3 py-2 rounded-lg border text-xs" placeholder="URL">
                                    <input type="text" :name="'section_company_info_item' + (index + 1) + '_icon'" x-model="item.icon" class="w-full px-3 py-2 rounded-lg border text-xs" placeholder="Icon (e.g. fab fa-facebook)">
                                    <div class="flex justify-end items-center">
                                        <button type="button" @click="items.splice(index, 1)" class="text-red-500 hover:text-red-700 p-2">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>
                        <button type="button" @click="items.push({name: '', url: '', icon: ''})" class="mt-3 text-sm text-blue-600 font-medium hover:underline flex items-center gap-1">
                            <i class="fas fa-plus-circle"></i> Add Social Link
                        </button>
                    </div>
                </div>
            </div>

            <!-- Footer Columns -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Quick Links -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6" x-data="{ items: {{ json_encode($quickLinksContent['items'] ?? []) }} }">
                    <h3 class="text-md font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-link text-blue-500"></i> Quick Links
                    </h3>
                    <div class="space-y-3">
                        <template x-for="(item, index) in items" :key="index">
                            <div class="bg-slate-50 p-3 rounded-lg border border-slate-200 space-y-2">
                                <input type="text" :name="'section_quick_links_item' + (index + 1) + '_name'" x-model="item.name" class="w-full px-3 py-1.5 rounded border text-xs" placeholder="Link Name">
                                <div class="flex gap-2">
                                    <input type="text" :name="'section_quick_links_item' + (index + 1) + '_url'" x-model="item.url" class="w-full px-3 py-1.5 rounded border text-xs" placeholder="URL">
                                    <button type="button" @click="items.splice(index, 1)" class="text-red-500 p-1"><i class="fas fa-times"></i></button>
                                </div>
                            </div>
                        </template>
                    </div>
                    <button type="button" @click="items.push({name: '', url: ''})" class="mt-3 text-xs text-blue-600 hover:underline">+ Add Link</button>
                </div>

                <!-- Customer Service -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6" x-data="{ items: {{ json_encode($customerServiceContent['items'] ?? []) }} }">
                    <h3 class="text-md font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-headset text-green-500"></i> Customer Service
                    </h3>
                    <div class="space-y-3">
                        <template x-for="(item, index) in items" :key="index">
                            <div class="bg-slate-50 p-3 rounded-lg border border-slate-200 space-y-2">
                                <input type="text" :name="'section_customer_service_item' + (index + 1) + '_name'" x-model="item.name" class="w-full px-3 py-1.5 rounded border text-xs" placeholder="Link Name">
                                <div class="flex gap-2">
                                    <input type="text" :name="'section_customer_service_item' + (index + 1) + '_url'" x-model="item.url" class="w-full px-3 py-1.5 rounded border text-xs" placeholder="URL">
                                    <button type="button" @click="items.splice(index, 1)" class="text-red-500 p-1"><i class="fas fa-times"></i></button>
                                </div>
                            </div>
                        </template>
                    </div>
                    <button type="button" @click="items.push({name: '', url: ''})" class="mt-3 text-xs text-blue-600 hover:underline">+ Add Link</button>
                </div>

                <!-- Policies -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6" x-data="{ items: {{ json_encode($policiesContent['items'] ?? []) }} }">
                    <h3 class="text-md font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-shield-alt text-purple-500"></i> Policies
                    </h3>
                    <div class="space-y-3">
                        <template x-for="(item, index) in items" :key="index">
                            <div class="bg-slate-50 p-3 rounded-lg border border-slate-200 space-y-2">
                                <input type="text" :name="'section_policies_item' + (index + 1) + '_name'" x-model="item.name" class="w-full px-3 py-1.5 rounded border text-xs" placeholder="Link Name">
                                <div class="flex gap-2">
                                    <input type="text" :name="'section_policies_item' + (index + 1) + '_url'" x-model="item.url" class="w-full px-3 py-1.5 rounded border text-xs" placeholder="URL">
                                    <button type="button" @click="items.splice(index, 1)" class="text-red-500 p-1"><i class="fas fa-times"></i></button>
                                </div>
                            </div>
                        </template>
                    </div>
                    <button type="button" @click="items.push({name: '', url: ''})" class="mt-3 text-xs text-blue-600 hover:underline">+ Add Link</button>
                </div>
            </div>

            <!-- Contact & Newsletter -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Contact Info -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <h3 class="text-md font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-address-book text-orange-500"></i> Contact Details
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-1">Title</label>
                            <input type="text" name="section_contact_info_title" value="{{ $contactInfoContent['title'] ?? '' }}" class="w-full px-3 py-2 rounded-lg border text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-1">Email</label>
                            <input type="text" name="section_contact_info_email" value="{{ $contactInfoContent['email'] ?? '' }}" class="w-full px-3 py-2 rounded-lg border text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-1">Phone</label>
                            <input type="text" name="section_contact_info_phone" value="{{ $contactInfoContent['phone'] ?? '' }}" class="w-full px-3 py-2 rounded-lg border text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-1">Business Hours</label>
                            <input type="text" name="section_contact_info_hours" value="{{ $contactInfoContent['hours'] ?? '' }}" class="w-full px-3 py-2 rounded-lg border text-sm">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-medium text-slate-600 mb-1">Address</label>
                            <textarea name="section_contact_info_address" rows="2" class="w-full px-3 py-2 rounded-lg border text-sm">{{ $contactInfoContent['address'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Newsletter -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <h3 class="text-md font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-envelope-open-text text-indigo-500"></i> Newsletter Section
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-1">Newsletter Title</label>
                            <input type="text" name="section_newsletter_title" value="{{ $newsletterContent['title'] ?? '' }}" class="w-full px-3 py-2 rounded-lg border text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-1">Newsletter Description</label>
                            <textarea name="section_newsletter_description" rows="3" class="w-full px-3 py-2 rounded-lg border text-sm">{{ $newsletterContent['description'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Footer -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <h3 class="text-md font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-copyright text-slate-500"></i> Bottom Footer (Copyright & Credits)
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Copyright Text</label>
                        <input type="text" name="section_bottom_footer_copyright_text" value="{{ $bottomFooterContent['copyright_text'] ?? '' }}" class="w-full px-3 py-2 rounded-lg border text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Developer Credits Name</label>
                        <input type="text" name="section_bottom_footer_developer_name" value="{{ $bottomFooterContent['developer_name'] ?? '' }}" class="w-full px-3 py-2 rounded-lg border text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Developer Credits Text</label>
                        <input type="text" name="section_bottom_footer_credit_text" value="{{ $bottomFooterContent['credit_text'] ?? '' }}" class="w-full px-3 py-2 rounded-lg border text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Developer Website URL</label>
                        <input type="text" name="section_bottom_footer_developer_url" value="{{ $bottomFooterContent['developer_url'] ?? '' }}" class="w-full px-3 py-2 rounded-lg border text-sm">
                    </div>
                </div>
            </div>

        @elseif(in_array($page->slug, ['privacy-policy', 'terms-conditions', 'refund-policy']))
            @php
                $heroSection = $page->sections->where('key', 'hero')->first();
                $heroContent = $heroSection ? $heroSection->content : [];
                $policySections = $page->sections->where('key', 'sections')->first();
                $policyContent = $policySections ? ($policySections->content ?? []) : [];
            @endphp

            <!-- Hero -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                    <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                        <i class="fas fa-heading"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Hero Section</h2>
                        <p class="text-xs text-slate-500">Page title and subtitle shown at the top</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Page Title</label>
                        <input type="text" name="section_hero_title" value="{{ $heroContent['title'] ?? '' }}"
                               class="w-full px-4 py-2 rounded-lg border border-slate-200 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Subtitle</label>
                        <input type="text" name="section_hero_subtitle" value="{{ $heroContent['subtitle'] ?? '' }}"
                               class="w-full px-4 py-2 rounded-lg border border-slate-200 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                    </div>
                </div>
            </div>

            <!-- Policy Sections -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                    <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                        <i class="fas fa-list-ul"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Policy Sections</h2>
                        <p class="text-xs text-slate-500">Each section has a title and body text</p>
                    </div>
                </div>

                <div id="policy-sections" class="space-y-4">
                    @foreach($policyContent as $i => $section)
                    <div class="policy-section border border-slate-200 rounded-xl p-4 bg-slate-50">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-sm font-semibold text-slate-600">Section {{ $i + 1 }}</span>
                            <button type="button" onclick="this.closest('.policy-section').remove()"
                                    class="text-red-400 hover:text-red-600 transition text-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1">Title</label>
                                <input type="text" name="policy_sections[{{ $i }}][title]" value="{{ $section['title'] ?? '' }}"
                                       class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1">Body</label>
                                <textarea name="policy_sections[{{ $i }}][body]" rows="3"
                                          class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none resize-none">{{ $section['body'] ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <button type="button" onclick="addPolicySection()"
                        class="mt-4 flex items-center gap-2 px-4 py-2 border-2 border-dashed border-slate-300 rounded-xl text-slate-500 hover:border-primary hover:text-primary transition text-sm w-full justify-center">
                    <i class="fas fa-plus"></i> Add Section
                </button>
            </div>

            <script>
            let sectionCount = {{ count($policyContent) }};
            function addPolicySection() {
                const container = document.getElementById('policy-sections');
                const div = document.createElement('div');
                div.className = 'policy-section border border-slate-200 rounded-xl p-4 bg-slate-50';
                div.innerHTML = `
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-sm font-semibold text-slate-600">Section ${sectionCount + 1}</span>
                        <button type="button" onclick="this.closest('.policy-section').remove()" class="text-red-400 hover:text-red-600 transition text-sm">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-1">Title</label>
                            <input type="text" name="policy_sections[${sectionCount}][title]" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-1">Body</label>
                            <textarea name="policy_sections[${sectionCount}][body]" rows="3" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none resize-none"></textarea>
                        </div>
                    </div>`;
                container.appendChild(div);
                sectionCount++;
            }
            </script>

        @else
            <!-- Generic Editor for other pages -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="text-center py-12">
                     <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-code text-slate-400 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-slate-900">Content Editor</h3>
                    <p class="text-slate-500 mt-1">This page does not have a specific editor layout yet.</p>
                </div>
            </div>
        @endif

        <div class="flex items-center justify-end gap-4">
            <button type="button" onclick="history.back()" class="px-6 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-semibold hover:bg-slate-50 transition-colors">Cancel</button>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-linear-to-r from-purple-600 to-pink-600 text-white font-bold hover:shadow-lg hover:shadow-purple-500/30 hover:scale-105 active:scale-95 transition-all transform">Save Changes</button>
        </div>
    </form>
</div>

    <script>
        function previewImage(input, imgId, containerId) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.getElementById(imgId);
                    const container = document.getElementById(containerId);
                    if (img) img.src = e.target.result;
                    if (container) container.classList.remove('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
