@extends('layouts.app')

@section('title', config('app.name') . ' - Premium Shopping Experience')

@section('content')

<!-- Hero Section -->
<section class="relative text-white overflow-hidden py-20 md:py-32" x-data="bgSlider()">
    <!-- Background Image Slider -->
    <div class="absolute inset-0 z-0">
        <template x-for="(img, index) in bgImages" :key="index">
            <div class="absolute inset-0 transition-opacity duration-1000"
                 :class="bgCurrent === index ? 'opacity-100' : 'opacity-0'">
                <img :src="img" alt="" class="w-full h-full object-cover object-center">
            </div>
        </template>
        <div class="absolute inset-0 bg-black/60"></div>
    </div>

    <div class="container mx-auto px-4 py-8 relative z-10">
        <div class="grid md:grid-cols-2 gap-8 items-center">
            <div class="space-y-6">
                <div class="inline-block bg-white/10 backdrop-blur-sm px-3 py-1.5 rounded-full text-xs font-medium">
                    {{ $sections['hero']['badge_text'] ?? '🎉 New Collection 2026' }}
                </div>
                <h1 class="text-4xl md:text-5xl font-display font-bold leading-tight">
                    {{ $sections['hero']['title_prefix'] ?? 'Discover Your' }} <span class="block text-yellow-300">{{ $sections['hero']['title_suffix'] ?? 'Style Today' }}</span>
                </h1>
                <p class="text-lg text-gray-300 leading-relaxed">
                    {{ $sections['hero']['description'] ?? 'Shop the latest trends with unbeatable prices. Quality products, fast delivery, and exceptional service guaranteed.' }}
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="/shop" class="bg-white text-gray-900 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300 shadow-xl hover:shadow-2xl hover:scale-105 transform text-center inline-flex items-center justify-center gap-2">
                        <i class="fas fa-shopping-bag"></i>
                        <span>Shop Now</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Prev / Next + Dot Indicators centered at bottom --}}
    <div class="absolute bottom-5 left-1/2 -translate-x-1/2 z-20 flex items-center gap-3">
        <button @click="prev(); resetAuto()"
                class="w-9 h-9 bg-white/15 hover:bg-white/30 backdrop-blur-sm border border-white/20 rounded-full flex items-center justify-center transition-all duration-200 hover:scale-110">
            <i class="fas fa-chevron-left text-white text-xs"></i>
        </button>

        <div class="flex items-center gap-2">
            <template x-for="(img, index) in bgImages" :key="index">
                <button @click="goTo(index)"
                        class="transition-all duration-300 rounded-full"
                        :class="bgCurrent === index ? 'w-6 h-2.5 bg-white' : 'w-2.5 h-2.5 bg-white/40 hover:bg-white/70'">
                </button>
            </template>
        </div>

        <button @click="next(); resetAuto()"
                class="w-9 h-9 bg-white/15 hover:bg-white/30 backdrop-blur-sm border border-white/20 rounded-full flex items-center justify-center transition-all duration-200 hover:scale-110">
            <i class="fas fa-chevron-right text-white text-xs"></i>
        </button>
    </div>

    <script>
        function bgSlider() {
            return {
                bgCurrent: 0,
                bgImages: [
                    'https://images.unsplash.com/photo-1483985988355-763728e1935b?w=1600&h=900&fit=crop',
                    'https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?w=1600&h=900&fit=crop',
                    'https://images.unsplash.com/photo-1445205170230-053b83016050?w=1600&h=900&fit=crop',
                    'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=1600&h=900&fit=crop'
                ],
                timer: null,
                init() { this.startAuto(); },
                startAuto() {
                    this.timer = setInterval(() => this.next(), 5000);
                },
                resetAuto() {
                    clearInterval(this.timer);
                    this.startAuto();
                },
                next() { this.bgCurrent = (this.bgCurrent + 1) % this.bgImages.length; },
                prev() { this.bgCurrent = (this.bgCurrent - 1 + this.bgImages.length) % this.bgImages.length; },
                goTo(i) { this.bgCurrent = i; this.resetAuto(); }
            }
        }
    </script>
</section>

<script>
    function flashCountdown() {
        return {
            hours: 23,
            minutes: 45,
            seconds: 30,
            init() {
                this.startCountdown();
            },
            startCountdown() {
                setInterval(() => {
                    if (this.seconds > 0) {
                        this.seconds--;
                    } else {
                        this.seconds = 59;
                        if (this.minutes > 0) {
                            this.minutes--;
                        } else {
                            this.minutes = 59;
                            if (this.hours > 0) {
                                this.hours--;
                            } else {
                                // Reset to 24 hours when countdown ends
                                this.hours = 23;
                                this.minutes = 59;
                                this.seconds = 59;
                            }
                        }
                    }
                }, 1000);
            }
        }
    }
</script>

<!-- Categories Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-display font-bold text-gray-900 mb-3">Shop by Category</h2>
            <p class="text-gray-600">Explore our wide range of products</p>
        </div>

        <div class="relative group px-4 md:px-8" id="cat-carousel-wrap">
            <!-- Navigation Buttons -->
            <button id="cat-prev" class="absolute left-0 top-1/2 -translate-y-1/2 z-10 w-10 h-10 md:w-12 md:h-12 bg-white rounded-full shadow-lg flex items-center justify-center border border-slate-100 opacity-100 md:opacity-0 md:group-hover:opacity-100 transition-all duration-300 hover:scale-110 hover:text-white focus:outline-none" style="color:var(--primary-color);" onmouseover="this.style.background='var(--primary-color)';this.style.color='#fff'" onmouseout="this.style.background='';this.style.color='var(--primary-color)'">
                <i class="fas fa-chevron-left text-lg md:text-xl"></i>
            </button>
            <button id="cat-next" class="absolute right-0 top-1/2 -translate-y-1/2 z-10 w-10 h-10 md:w-12 md:h-12 bg-white rounded-full shadow-lg flex items-center justify-center border border-slate-100 opacity-100 md:opacity-0 md:group-hover:opacity-100 transition-all duration-300 hover:scale-110 hover:text-white focus:outline-none" style="color:var(--primary-color);" onmouseover="this.style.background='var(--primary-color)';this.style.color='#fff'" onmouseout="this.style.background='';this.style.color='var(--primary-color)'">
                <i class="fas fa-chevron-right text-lg md:text-xl"></i>
            </button>

            <!-- Carousel Track Wrapper -->
            <div class="overflow-hidden pb-8 pt-4">
                <div id="cat-track" class="flex gap-6" style="transition:transform 0.5s ease-in-out;will-change:transform;cursor:grab;user-select:none;">
                    {{-- filled by JS --}}
                </div>
            </div>
        </div>

        <style>
            .cat-card { flex: none; width: 160px; }
            @@media (min-width: 768px) { .cat-card { width: 200px; } }
        </style>

        <script>
        (function() {
            const cats = {!! json_encode($popularCategories->map(function($c) {
                return [
                    'name'  => $c->name,
                    'image' => $c->image_url,
                    'count' => $c->products_count,
                    'url'   => '/shop?categories%5B%5D=' . $c->id,
                ];
            })->values()) !!};

            document.addEventListener('DOMContentLoaded', () => {
                const track   = document.getElementById('cat-track');
                const prevBtn = document.getElementById('cat-prev');
                const nextBtn = document.getElementById('cat-next');
                if (!track || !cats.length) return;

                // Build tripled list for seamless infinite loop
                const tripled = [...cats, ...cats, ...cats];
                tripled.forEach(cat => {
                    const el = document.createElement('div');
                    el.className = 'cat-card';
                    el.innerHTML = `
                        <a href="${cat.url}" class="group/card cursor-pointer block h-full">
                            <div class="bg-white rounded-2xl p-6 shadow-md hover:shadow-xl transition duration-300 transform hover:-translate-y-2 h-full flex flex-col items-center justify-center border border-slate-50 min-h-[220px]">
                                <div class="w-20 h-20 mx-auto rounded-full flex items-center justify-center mb-4 transition duration-300 overflow-hidden border border-gray-100 shadow-sm bg-gray-50">
                                    <img src="${cat.image}" alt="${cat.name}" class="w-full h-full object-cover">
                                </div>
                                <h3 class="text-center font-semibold text-gray-800 mb-1 line-clamp-1">${cat.name}</h3>
                                <p class="text-center text-sm text-gray-500">${cat.count} items</p>
                            </div>
                        </a>`;
                    track.appendChild(el);
                });

                let offset = cats.length; // start at middle copy
                let cardW  = 0;
                let animating = false;

                function measure() {
                    const card = track.querySelector('.cat-card');
                    if (!card) return;
                    const gap = parseFloat(getComputedStyle(track).gap) || 24;
                    cardW = card.offsetWidth + gap;
                }

                function moveTo(idx, animate) {
                    track.style.transition = animate ? 'transform 0.5s ease-in-out' : 'none';
                    track.style.transform  = `translateX(-${idx * cardW}px)`;
                }

                measure();
                moveTo(offset, false);

                window.addEventListener('resize', () => { measure(); moveTo(offset, false); });

                nextBtn.addEventListener('click', () => {
                    if (animating) return;
                    animating = true;
                    offset++;
                    moveTo(offset, true);
                    setTimeout(() => {
                        if (offset >= cats.length * 2) { offset = cats.length; moveTo(offset, false); }
                        animating = false;
                    }, 520);
                });

                prevBtn.addEventListener('click', () => {
                    if (animating) return;
                    animating = true;
                    offset--;
                    moveTo(offset, true);
                    setTimeout(() => {
                        if (offset < cats.length) { offset = cats.length * 2 - 1; moveTo(offset, false); }
                        animating = false;
                    }, 520);
                });

                // Mouse drag support
                let isDragging = false, dragStartX = 0, dragStartOffset = 0, didDrag = false;

                track.addEventListener('mousedown', (e) => {
                    isDragging = true;
                    didDrag = false;
                    dragStartX = e.clientX;
                    dragStartOffset = offset;
                    track.style.transition = 'none';
                    track.style.cursor = 'grabbing';
                    e.preventDefault();
                });

                window.addEventListener('mousemove', (e) => {
                    if (!isDragging) return;
                    const diff = dragStartX - e.clientX;
                    if (Math.abs(diff) > 5) didDrag = true;
                    track.style.transform = `translateX(-${(dragStartOffset + diff / cardW) * cardW}px)`;
                });

                window.addEventListener('mouseup', (e) => {
                    if (!isDragging) return;
                    isDragging = false;
                    track.style.cursor = 'grab';
                    const diff = dragStartX - e.clientX;
                    const steps = Math.round(diff / cardW);
                    offset = dragStartOffset + steps;
                    if (offset >= cats.length * 2) offset = cats.length;
                    if (offset < cats.length) offset = cats.length * 2 - 1;
                    moveTo(offset, true);
                    setTimeout(() => { animating = false; }, 520);
                });

                // Block click on links after a drag
                track.addEventListener('click', (e) => {
                    if (didDrag) {
                        e.preventDefault();
                        e.stopPropagation();
                        didDrag = false;
                    }
                }, true);

                // Touch drag support
                let touchStartX = 0, touchStartOffset = 0, touchDidDrag = false;
                track.addEventListener('touchstart', (e) => {
                    touchStartX = e.touches[0].clientX;
                    touchStartOffset = offset;
                    touchDidDrag = false;
                    track.style.transition = 'none';
                }, { passive: true });

                track.addEventListener('touchmove', (e) => {
                    const diff = touchStartX - e.touches[0].clientX;
                    if (Math.abs(diff) > 5) touchDidDrag = true;
                    track.style.transform = `translateX(-${(touchStartOffset + diff / cardW) * cardW}px)`;
                }, { passive: true });

                track.addEventListener('touchend', (e) => {
                    const diff = touchStartX - e.changedTouches[0].clientX;
                    const steps = Math.round(diff / cardW);
                    offset = touchStartOffset + steps;
                    if (offset >= cats.length * 2) offset = cats.length;
                    if (offset < cats.length) offset = cats.length * 2 - 1;
                    moveTo(offset, true);
                });

                track.addEventListener('click', (e) => {
                    if (touchDidDrag) {
                        e.preventDefault();
                        e.stopPropagation();
                        touchDidDrag = false;
                    }
                }, true);
            });
        })();
        </script>
    </div>
</section>

<!-- Featured Products Section -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-display font-bold text-gray-900 mb-3">Popular Products</h2>
            <p class="text-gray-600">Handpicked items just for you</p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
            @forelse($dealProducts as $product)
            <a href="{{ route('product.details', $product->slug) }}" class="group cursor-pointer">
                <div class="bg-white rounded-xl shadow-sm hover:shadow-lg transition duration-300 overflow-hidden">
                    <div class="relative overflow-hidden">
                        <img src="{{ $product->primaryImage ? $product->primaryImage->url : asset('images/placeholder.jpg') }}" alt="{{ $product->name }}" class="w-full h-48 object-cover group-hover:scale-110 transition duration-500">
                        @if($product->discount_price)
                        <div class="absolute top-2 right-2 bg-red-500 text-white px-2 py-0.5 rounded-full text-xs font-semibold">
                            SALE
                        </div>
                        @endif
                        <div class="absolute top-2 left-2 opacity-0 group-hover:opacity-100 transition duration-300">
                            <button onclick="event.preventDefault(); toggleWishlist({{ $product->id }})" class="bg-white p-2 rounded-full shadow-lg hover:bg-primary hover:text-white transition">
                                <i class="fas fa-heart text-sm"></i>
                            </button>
                        </div>
                    </div>
                    <div class="p-3">
                        <p class="text-xs text-gray-500 mb-1">{{ $product->category->name ?? 'Category' }}</p>
                        <h3 class="font-semibold text-sm text-gray-800 mb-2 group-hover:text-primary transition line-clamp-2 min-h-[40px]">{{ $product->name }}</h3>
                        <div class="flex items-center mb-2">
                            <div class="flex text-yellow-400 text-xs">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= ($product->rating ?? 4))
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-xs text-gray-500 ml-1">({{ rand(50, 200) }})</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-lg font-bold text-primary">${{ number_format($product->base_price, 2) }}</span>
                            </div>
                            <button onclick="event.preventDefault();" class="bg-gradient-to-r from-primary to-primary/80 text-white p-2 rounded-lg hover:shadow-lg transition">
                                <i class="fas fa-shopping-cart text-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </a>
            @empty
            <p class="col-span-full text-center text-gray-500">No products available</p>
            @endforelse
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('shop') }}" class="bg-gradient-to-r from-primary to-primary/80 text-white px-12 py-4 rounded-lg font-semibold hover:shadow-xl transition duration-300 hover:scale-105 transform inline-block">
                View All Products <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- Promotional Banner Section (Flash Sale) -->
<section class="py-8 text-white relative overflow-hidden" style="background: linear-gradient(to right, var(--primary-color), color-mix(in srgb, var(--primary-color) 80%, black));">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-64 h-64 bg-white rounded-full mix-blend-overlay filter blur-3xl animate-pulse"></div>
        <div class="absolute bottom-0 right-0 w-64 h-64 bg-white rounded-full mix-blend-overlay filter blur-3xl animate-pulse animation-delay-2000"></div>
    </div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6 max-w-6xl mx-auto">
            <!-- Left Content -->
            <div class="flex items-center gap-6 flex-1">
                <!-- Image -->
                <div class="hidden md:block flex-shrink-0">
                    <img src="https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?w=200&h=200&fit=crop" alt="Sale" class="rounded-lg shadow-lg w-32 h-32 object-cover">
                </div>
                
                <!-- Text Content -->
                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        <span class="bg-red-500 text-white px-2 py-1 rounded text-xs font-bold uppercase">⚡ Limited Time</span>
                    </div>
                    <h2 class="text-2xl md:text-3xl font-bold leading-tight">
                        Flash Sale <span class="text-yellow-300">Up to 70% OFF</span>
                    </h2>
                    <p class="text-sm text-gray-100 max-w-md">
                        Don't miss out on our biggest sale of the season!
                    </p>
                </div>
            </div>

            <!-- Right Content - Countdown & Button -->
            <div class="flex items-center gap-4 flex-shrink-0">
                <!-- Countdown Timer -->
                <div class="flex gap-2" x-data="flashCountdown()" x-init="init()">
                    <div class="bg-white/10 backdrop-blur-sm px-3 py-2 rounded-lg text-center min-w-[60px]">
                        <p class="text-xl font-bold" x-text="hours">23</p>
                        <p class="text-[10px] text-gray-200 uppercase">Hours</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm px-3 py-2 rounded-lg text-center min-w-[60px]">
                        <p class="text-xl font-bold" x-text="minutes">45</p>
                        <p class="text-[10px] text-gray-200 uppercase">Mins</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm px-3 py-2 rounded-lg text-center min-w-[60px]">
                        <p class="text-xl font-bold" x-text="seconds">30</p>
                        <p class="text-[10px] text-gray-200 uppercase">Secs</p>
                    </div>
                </div>

                <!-- CTA Button -->
                <a href="/shop" class="bg-yellow-400 hover:bg-yellow-500 text-gray-900 px-6 py-3 rounded-lg font-bold transition duration-300 shadow-lg hover:shadow-xl whitespace-nowrap flex items-center gap-2">
                    <span>Shop Now</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Shop by Brand Section -->
@if($brands->count() > 0)
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-10">
            <h2 class="text-3xl md:text-4xl font-display font-bold text-gray-900 mb-3">Shop by Brand</h2>
            <p class="text-gray-500">Discover products from your favorite brands</p>
        </div>

        {{-- Mobile: horizontal slider | Desktop: 6-col grid --}}
        <div class="relative group" id="brand-carousel-wrap">

            {{-- Prev/Next buttons --}}
            <button id="brand-prev"
                    class="absolute left-0 top-1/2 -translate-y-1/2 z-10 w-9 h-9 bg-white rounded-full shadow-md flex items-center justify-center border border-gray-100
                           opacity-100 md:opacity-0 md:group-hover:opacity-100 transition-all duration-300 focus:outline-none"
                    style="color:var(--primary-color);"
                    onmouseover="this.style.background='var(--primary-color)';this.style.color='#fff'"
                    onmouseout="this.style.background='';this.style.color='var(--primary-color)'">
                <i class="fas fa-chevron-left text-sm"></i>
            </button>
            <button id="brand-next"
                    class="absolute right-0 top-1/2 -translate-y-1/2 z-10 w-9 h-9 bg-white rounded-full shadow-md flex items-center justify-center border border-gray-100
                           opacity-100 md:opacity-0 md:group-hover:opacity-100 transition-all duration-300 focus:outline-none"
                    style="color:var(--primary-color);"
                    onmouseover="this.style.background='var(--primary-color)';this.style.color='#fff'"
                    onmouseout="this.style.background='';this.style.color='var(--primary-color)'">
                <i class="fas fa-chevron-right text-sm"></i>
            </button>

            {{-- Slider track --}}
            <div class="overflow-hidden px-4 md:px-8 py-4">
                <div id="brand-track" class="flex gap-4 md:grid md:gap-5"
                     style="transition:transform 0.5s ease-in-out;will-change:transform;cursor:grab;user-select:none;">
                    @foreach($brands as $brand)
                    <div class="brand-card flex-none">
                        <a href="{{ route('shop') }}?brand={{ $brand->id }}"
                           class="group/card bg-white rounded-2xl p-4 shadow-sm hover:shadow-md border border-gray-100 hover:border-primary/20 transition-all duration-300 flex flex-col items-center gap-2 h-full">
                            <div class="w-14 h-14 rounded-xl bg-gray-50 border border-gray-100 flex items-center justify-center overflow-hidden flex-shrink-0">
                                @if($brand->logo_url)
                                    <img src="{{ $brand->logo_url }}" alt="{{ $brand->name }}"
                                         class="w-full h-full object-cover group-hover/card:scale-105 transition-transform duration-300">
                                @else
                                    <span class="text-lg font-bold text-gray-300">{{ strtoupper(substr($brand->name,0,2)) }}</span>
                                @endif
                            </div>
                            <p class="font-semibold text-gray-700 text-xs group-hover/card:text-primary transition-colors truncate w-full text-center">{{ $brand->name }}</p>
                            <p class="text-[11px] text-gray-400 -mt-1">{{ $brand->products_count }} items</p>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('shop') }}"
               class="inline-flex items-center gap-2 px-8 py-3 bg-primary text-white rounded-xl font-semibold hover:bg-primary/90 transition shadow-sm">
                View All Brands <i class="fas fa-arrow-right text-sm"></i>
            </a>
        </div>
    </div>
</section>

<style>
    .brand-card { width: 130px; }
    @media (min-width: 768px) {
        #brand-track { display: grid !important; grid-template-columns: repeat(6,1fr); transform: none !important; cursor: default !important; }
        .brand-card { width: auto; }
    }
</style>

<script>
(function() {
    document.addEventListener('DOMContentLoaded', () => {
        const track   = document.getElementById('brand-track');
        const prevBtn = document.getElementById('brand-prev');
        const nextBtn = document.getElementById('brand-next');
        if (!track || window.innerWidth >= 768) return;

        let offset = 0, cardW = 0;

        function measure() {
            const card = track.querySelector('.brand-card');
            if (!card) return;
            cardW = card.offsetWidth + parseFloat(getComputedStyle(track).gap || 16);
        }
        function moveTo(idx, animate) {
            track.style.transition = animate ? 'transform 0.5s ease-in-out' : 'none';
            track.style.transform  = `translateX(-${idx * cardW}px)`;
        }

        measure();
        const total = track.querySelectorAll('.brand-card').length;

        nextBtn.addEventListener('click', () => {
            offset = Math.min(offset + 1, total - 2);
            moveTo(offset, true);
        });
        prevBtn.addEventListener('click', () => {
            offset = Math.max(offset - 1, 0);
            moveTo(offset, true);
        });

        // Touch drag
        let tx = 0, to = 0, dragging = false;
        track.addEventListener('touchstart', e => { tx = e.touches[0].clientX; to = offset; track.style.transition='none'; }, {passive:true});
        track.addEventListener('touchmove',  e => { const d = tx - e.touches[0].clientX; track.style.transform=`translateX(-${(to*cardW)+d}px)`; }, {passive:true});
        track.addEventListener('touchend',   e => { const d = tx - e.changedTouches[0].clientX; offset = Math.max(0, Math.min(to + Math.round(d/cardW), total-2)); moveTo(offset,true); });

        window.addEventListener('resize', () => { if(window.innerWidth >= 768) return; measure(); moveTo(offset,false); });
    });
})();
</script>
@endif

<!-- Featured Products Section -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-display font-bold text-gray-900 mb-3">Featured Products</h2>
            <p class="text-gray-600">Discover our handpicked selection of premium products</p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
            @forelse($dealProducts as $product)
            <a href="{{ route('product.details', $product->slug) }}" class="group cursor-pointer">
                <div class="bg-white rounded-xl shadow-sm hover:shadow-lg transition duration-300 overflow-hidden border border-gray-100">
                    <div class="relative overflow-hidden">
                        <img src="{{ $product->primaryImage ? $product->primaryImage->url : asset('images/placeholder.jpg') }}" alt="{{ $product->name }}" class="w-full h-48 object-cover group-hover:scale-110 transition duration-500">
                        @if($product->discount_price)
                        <div class="absolute top-2 right-2 bg-red-500 text-white px-2 py-0.5 rounded-full text-xs font-semibold">
                            SALE
                        </div>
                        @endif
                        <div class="absolute top-2 left-2 opacity-0 group-hover:opacity-100 transition duration-300">
                            <button onclick="event.preventDefault(); toggleWishlist({{ $product->id }})" class="bg-white p-2 rounded-full shadow-lg hover:bg-primary hover:text-white transition">
                                <i class="fas fa-heart text-sm"></i>
                            </button>
                        </div>
                    </div>
                    <div class="p-3">
                        <p class="text-xs text-gray-500 mb-1">{{ $product->category->name ?? 'Category' }}</p>
                        <h3 class="font-semibold text-sm text-gray-800 mb-2 group-hover:text-primary transition line-clamp-2 min-h-[40px]">{{ $product->name }}</h3>
                        <div class="flex items-center mb-2">
                            <div class="flex text-yellow-400 text-xs">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= ($product->rating ?? 4))
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-xs text-gray-500 ml-1">({{ rand(50, 200) }})</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-lg font-bold text-primary">${{ number_format($product->base_price, 2) }}</span>
                            </div>
                            <button onclick="event.preventDefault();" class="bg-gradient-to-r from-primary to-primary/80 text-white p-2 rounded-lg hover:shadow-lg transition">
                                <i class="fas fa-shopping-cart text-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </a>
            @empty
            <p class="col-span-full text-center text-gray-500">No products available</p>
            @endforelse
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('shop') }}" class="bg-gradient-to-r from-primary to-primary/80 text-white px-12 py-4 rounded-lg font-semibold hover:shadow-xl transition duration-300 hover:scale-105 transform inline-block">
                View All Products <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- Customer Feedback Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-display font-bold text-gray-900 mb-3">What Our Customers Say</h2>
            <p class="text-gray-600">Real feedback from our valued customers</p>
        </div>

        {{-- Testimonial Slider --}}
        <div class="relative" x-data="testimonialSlider()">
            <div class="overflow-hidden">
                <div class="flex transition-transform duration-700 ease-in-out"
                     :style="'transform: translateX(-' + (current * 100 / visibleCount) + '%)'">

                    @php
                    $testimonials = [
                        ['img' => 'https://images.unsplash.com/photo-1494790108755-2616b612b786?w=64&h=64&fit=crop&crop=face', 'name' => 'Sarah Johnson',   'text' => '"Amazing quality products and super fast delivery! I\'ve been shopping here for months and never disappointed."'],
                        ['img' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=64&h=64&fit=crop&crop=face', 'name' => 'Michael Chen',    'text' => '"Best online shopping experience ever! The website is easy to navigate, prices are competitive, and quality exceeds expectations."'],
                        ['img' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=64&h=64&fit=crop&crop=face', 'name' => 'Emily Rodriguez', 'text' => '"Incredible variety of products and unbeatable deals! I love the flash sales and the loyalty program. Highly recommend!"'],
                        ['img' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=64&h=64&fit=crop&crop=face', 'name' => 'David Wilson',    'text' => '"Outstanding service and premium quality products. The delivery is always on time and the packaging is excellent."'],
                        ['img' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=64&h=64&fit=crop&crop=face', 'name' => 'Lisa Park',       'text' => '"I\'ve tried many online stores but this one stands out. Great prices, fast shipping, and excellent customer support!"'],
                        ['img' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=64&h=64&fit=crop&crop=face', 'name' => 'James Miller',    'text' => '"Absolutely love this store! The product quality is top-notch and the deals are unbeatable. Will definitely shop again."'],
                    ];
                    @endphp

                    @foreach($testimonials as $t)
                    <div class="flex-shrink-0 px-3"
                         :style="'width: ' + (100 / visibleCount) + '%'">
                        <div class="bg-white rounded-2xl p-6 shadow-md text-center h-full flex flex-col items-center">
                            <div class="w-16 h-16 mx-auto mb-4 rounded-full overflow-hidden border-4 border-primary/20">
                                <img src="{{ $t['img'] }}" alt="{{ $t['name'] }}" class="w-full h-full object-cover">
                            </div>
                            <div class="flex justify-center mb-3 text-yellow-400 text-sm gap-0.5">
                                @for($i=0;$i<5;$i++)<i class="fas fa-star"></i>@endfor
                            </div>
                            <p class="text-gray-600 text-sm leading-relaxed flex-1 mb-4">{{ $t['text'] }}</p>
                            <div>
                                <h4 class="font-semibold text-gray-900 text-sm">{{ $t['name'] }}</h4>
                                <p class="text-xs text-primary">Verified Customer</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Controls --}}
            <div class="flex items-center justify-center gap-3 mt-8">
                <button @click="prev()"
                        class="w-9 h-9 bg-white border border-gray-200 rounded-full shadow-sm flex items-center justify-center text-gray-500 hover:text-primary hover:border-primary transition">
                    <i class="fas fa-chevron-left text-xs"></i>
                </button>
                <div class="flex gap-2">
                    <template x-for="i in totalDots" :key="i">
                        <button @click="goTo(i - 1)"
                                class="rounded-full transition-all duration-300"
                                :class="current === (i - 1) ? 'w-6 h-2.5 bg-primary' : 'w-2.5 h-2.5 bg-gray-300 hover:bg-gray-400'">
                        </button>
                    </template>
                </div>
                <button @click="next()"
                        class="w-9 h-9 bg-white border border-gray-200 rounded-full shadow-sm flex items-center justify-center text-gray-500 hover:text-primary hover:border-primary transition">
                    <i class="fas fa-chevron-right text-xs"></i>
                </button>
            </div>
        </div>
    </div>
</section>

<script>
function testimonialSlider() {
    return {
        current: 0,
        total: 6,
        timer: null,
        get visibleCount() { return window.innerWidth >= 1024 ? 4 : window.innerWidth >= 768 ? 2 : 1; },
        get totalDots() { return Math.ceil(this.total / this.visibleCount); },
        init() {
            this.startAuto();
            window.addEventListener('resize', () => this.$nextTick());
        },
        startAuto() { this.timer = setInterval(() => this.next(), 4000); },
        resetAuto() { clearInterval(this.timer); this.startAuto(); },
        next() { this.current = (this.current + 1) % this.totalDots; },
        prev() { this.current = (this.current - 1 + this.totalDots) % this.totalDots; this.resetAuto(); },
        goTo(i) { this.current = i; this.resetAuto(); },
    }
}
</script>

<!-- Ending Banner Section -->
<section class="py-20 text-white relative overflow-hidden" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-96 h-96 bg-primary rounded-full mix-blend-multiply filter blur-3xl animate-pulse"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-primary rounded-full mix-blend-multiply filter blur-3xl animate-pulse animation-delay-2000"></div>
    </div>
    
    <div class="container mx-auto px-4 text-center relative z-10">
        <div class="max-w-3xl mx-auto">
            <h2 class="text-4xl md:text-5xl font-display font-bold mb-6 leading-tight">
                Ready to Start Your <span class="text-yellow-300">Shopping Journey?</span>
            </h2>
            <p class="text-xl text-gray-300 mb-8 leading-relaxed">
                Join thousands of satisfied customers and discover amazing products at unbeatable prices.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/shop" class="bg-white text-gray-900 px-8 py-4 rounded-lg font-semibold hover:bg-gray-100 transition duration-300 shadow-xl hover:shadow-2xl hover:scale-105 transform inline-flex items-center justify-center gap-3">
                    <i class="fas fa-shopping-bag"></i>
                    <span>Start Shopping Now</span>
                </a>
                <a href="/contact" class="border-2 border-white text-white px-8 py-4 rounded-lg font-semibold hover:bg-white hover:text-gray-900 transition duration-300 inline-flex items-center justify-center gap-3">
                    <i class="fas fa-envelope"></i>
                    <span>Contact Us</span>
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
