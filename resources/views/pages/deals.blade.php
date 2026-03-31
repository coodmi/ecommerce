@extends('layouts.app')

@section('title', 'Hot Deals - Ecom Alpha')

@section('content')
<div class="bg-gray-50 min-h-screen" x-data="dealsPage()">
    <!-- Hero Banner -->
    <div class="relative bg-linear-to-r from-primary to-primary/80 py-12 overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-white rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-yellow-300 rounded-full blur-3xl"></div>
        </div>
        <div class="container mx-auto px-4 relative z-10 text-center text-white">
            <span class="inline-block px-4 py-1.5 bg-yellow-400 text-primary rounded-full text-xs font-bold uppercase tracking-widest mb-4 animate-bounce">
                {{ $sections['hero']['badge_text'] ?? 'Limited Time Only' }}
            </span>
            <h1 class="text-4xl md:text-6xl font-display font-black mb-4 uppercase italic tracking-tighter">
                {{ $sections['hero']['title'] ?? 'Super Hot Deals' }}
            </h1>
            <p class="text-xl text-red-100 max-w-2xl mx-auto font-medium">
                {{ $sections['hero']['description'] ?? 'Unbeatable prices on your favorite items. Grab them before they\'re gone!' }}
            </p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-12 space-y-20">

        <!-- Lightning Fast Deals Section -->
        <section>
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10 pb-8 border-b border-gray-100">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-yellow-100 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-bolt text-yellow-600 text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-display font-black text-gray-900 uppercase tracking-tight">
                            {{ $sections['lightning_deals']['title'] ?? 'Lightning Fast Deals' }}
                        </h2>
                        <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest mt-1">{{ $sections['lightning_deals']['subtitle'] ?? 'Offers expire soon • Limited quantities' }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 bg-white px-5 py-3 rounded-2xl border border-gray-100 shadow-sm" x-init="initCountdown()">
                    <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Ending In:</span>
                    <div class="flex items-center gap-3">
                        <div class="flex flex-col items-center">
                            <span class="text-xl font-black text-gray-900 leading-none" x-text="countdown.hours">00</span>
                            <span class="text-[8px] text-gray-400 font-bold mt-1">HRS</span>
                        </div>
                        <span class="text-gray-300 font-bold mb-4">:</span>
                        <div class="flex flex-col items-center">
                            <span class="text-xl font-black text-gray-900 leading-none" x-text="countdown.minutes">00</span>
                            <span class="text-[8px] text-gray-400 font-bold mt-1">MIN</span>
                        </div>
                        <span class="text-gray-300 font-bold mb-4">:</span>
                        <div class="flex flex-col items-center">
                            <span class="text-xl font-black text-primary leading-none" x-text="countdown.seconds">00</span>
                            <span class="text-[8px] text-primary/80 font-bold mt-1">SEC</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($lightningDeals as $product)
                <div @click="window.location='{{ route('product.details', $product->slug) }}'"
                     class="group bg-white rounded-3xl shadow-sm hover:shadow-2xl transition duration-500 overflow-hidden border border-gray-100 flex flex-col h-full transform hover:-translate-y-2 cursor-pointer">
                    <div class="relative aspect-square overflow-hidden bg-gray-100">
                        <img src="{{ $product->primaryImage ? $product->primaryImage->url : asset('images/placeholder.jpg') }}"
                             alt="{{ $product->name }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition duration-700">

                        <!-- Badges -->
                        <div class="absolute top-4 left-4 flex flex-col gap-2">
                            <span class="bg-primary text-white px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider shadow-lg">
                                Save 40%
                            </span>
                        </div>

                        <!-- Quick Actions -->
                        <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center gap-3">
                            <button @click.stop="window.location='{{ route('product.details', $product->slug) }}'"
                                    class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-gray-900 hover:bg-yellow-400 hover:text-white transition transform hover:scale-110 shadow-xl">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button @click.stop="window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'success', message: 'Added to wishlist!' } }))"
                                    class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-gray-900 hover:bg-primary hover:text-white transition transform hover:scale-110 shadow-xl">
                                <i class="fas fa-heart"></i>
                            </button>
                        </div>
                    </div>

                    <div class="p-5 flex flex-col flex-1">
                        <span class="text-xs font-bold text-primary uppercase tracking-widest mb-1">{{ $product->category->name }}</span>
                        <h3 class="text-lg font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-primary transition-colors">
                            {{ $product->name }}
                        </h3>

                        <div class="mt-auto pt-4 border-t border-gray-50">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <span class="text-2xl font-black text-gray-900">${{ $product->base_price }}</span>
                                    <span class="text-sm text-gray-400 line-through ml-2">${{ number_format($product->base_price * 1.4, 2) }}</span>
                                </div>
                                <div class="flex items-center text-yellow-400 text-xs">
                                    <i class="fas fa-star"></i>
                                    <span class="ml-1 text-gray-600 font-bold">{{ $product->rating ?? '4.5' }}</span>
                                </div>
                            </div>

                            <button @click.stop="addToCart({{ $product->id }})"
                                    class="w-full py-3 bg-gray-900 text-white rounded-2xl font-bold hover:bg-primary transition duration-300 flex items-center justify-center gap-2 shadow-lg active:scale-95">
                                <i class="fas fa-shopping-cart text-sm"></i>
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-12 text-center bg-white rounded-3xl border border-dashed border-gray-300">
                    <p class="text-gray-500">No lightning deals available at the moment.</p>
                </div>
                @endforelse
            </div>
        </section>

        <!-- Top Deals of the Day Section -->
        <section>
            <div class="text-center mb-12">
                <h2 class="text-4xl font-display font-black text-gray-900 mb-4 tracking-tight">{{ $sections['top_deals']['title'] ?? 'TOP DEALS OF THE DAY' }}</h2>
                <div class="w-24 h-1.5 bg-linear-to-r from-primary to-primary/80 mx-auto rounded-full mb-4"></div>
                <p class="text-gray-600 max-w-xl mx-auto">{{ $sections['top_deals']['description'] ?? 'Our most popular discounted items, updated daily for your shopping pleasure.' }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($topDeals as $product)
                <div @click="window.location='{{ route('product.details', $product->slug) }}'"
                     class="group flex items-center gap-6 bg-white p-4 rounded-3xl shadow-sm hover:shadow-xl transition duration-500 border border-gray-100 cursor-pointer">
                    <div class="relative w-32 h-32 md:w-40 md:h-40 flex-shrink-0 rounded-2xl overflow-hidden bg-gray-50">
                        <img src="{{ $product->primaryImage ? $product->primaryImage->url : asset('images/placeholder.jpg') }}"
                             alt="{{ $product->name }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                         <div class="absolute top-2 left-2 px-2 py-0.5 bg-orange-500 text-white text-[10px] font-black rounded uppercase">
                             HOT
                         </div>
                    </div>

                    <div class="flex-1 min-w-0">
                        <h3 class="text-lg font-bold text-gray-900 line-clamp-2 mb-1 group-hover:text-primary transition-colors">
                            {{ $product->name }}
                        </h3>

                        <!-- Rating -->
                        <div class="flex items-center mb-2">
                           <div class="flex text-yellow-400 text-[10px]">
                               @php $rating = (float)($product->rating ?? 0); @endphp
                               @for($i = 1; $i <= 5; $i++)
                                   @if($i <= $rating)
                                       <i class="fas fa-star"></i>
                                   @elseif($i - 0.5 <= $rating)
                                       <i class="fas fa-star-half-alt"></i>
                                   @else
                                       <i class="far fa-star text-gray-200"></i>
                                   @endif
                               @endfor
                           </div>
                           <span class="text-[9px] text-gray-400 font-bold ml-1.5">({{ number_format($rating, 1) }})</span>
                        </div>

                        <div class="flex items-center gap-2 mb-3">
                            <span class="text-xl font-black text-primary">${{ $product->base_price }}</span>
                            <span class="text-sm text-gray-400 line-through">${{ number_format($product->base_price * 1.3, 2) }}</span>
                        </div>
                        <div class="flex items-center gap-3">
                           <button @click.stop="window.location='{{ route('product.details', $product->slug) }}'"
                                   class="flex-1 py-2 bg-gray-50 hover:bg-primary/5 text-gray-900 hover:text-primary rounded-xl text-sm font-bold transition-colors">
                                Detail
                           </button>
                           <button @click.stop="addToCart({{ $product->id }})"
                                   class="w-10 h-10 bg-gray-900 text-white rounded-xl flex items-center justify-center hover:bg-primary transition shadow-lg active:scale-90">
                               <i class="fas fa-plus text-xs"></i>
                           </button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-12 text-center bg-white rounded-3xl border border-dashed border-gray-300">
                    <p class="text-gray-500">No top deals found today.</p>
                </div>
                @endforelse
            </div>
        </section>

        <!-- Deals by Category Carousel Section -->
        @if($dealCategories->count() > 0)
        <section class="pt-20 border-t border-gray-200" x-data="categoryCarousel({{ $dealCategories->count() }})">
            <div class="text-center mb-12">
                <h2 class="text-4xl md:text-5xl font-display font-black text-gray-900 mb-4 tracking-tight uppercase">{{ $sections['category_deals']['title'] ?? 'Deals by Category' }}</h2>
                <div class="w-24 h-1.5 bg-linear-to-r from-primary to-primary/80 mx-auto rounded-full mb-4"></div>
                <p class="text-gray-500 font-medium max-w-2xl mx-auto uppercase tracking-widest text-sm">{{ $sections['category_deals']['subtitle'] ?? 'Discover amazing offers in every category' }}</p>
            </div>

            <div class="relative group/carousel px-12">
                <!-- Carousel Track Container -->
                <div class="overflow-hidden">
                    <div class="flex transition-transform duration-700 ease-out gap-6"
                         :style="`transform: translateX(-${currentIndex * (100 / itemsPerPage)}%)`"
                         style="scroll-snap-type: x mandatory;">

                        @foreach($dealCategories as $category)
                        <div class="flex-none"
                             :style="`width: calc(${100 / itemsPerPage}% - ${(gap * (itemsPerPage - 1)) / itemsPerPage}px)`">
                            <a href="{{ route('shop', ['categories' => [$category->id]]) }}" class="group block text-center space-y-4 py-8">
                                <div class="relative mx-auto w-32 h-32 md:w-40 md:h-40 rounded-full overflow-hidden border-4 border-white shadow-lg group-hover:shadow-2xl transition-all duration-500 transform group-hover:scale-110 group-hover:rotate-3 shadow-red-500/5 group-hover:shadow-red-500/20">
                                    <img src="{{ $category->image_url }}"
                                         alt="{{ $category->name }}"
                                         class="w-full h-full object-cover grayscale-[30%] group-hover:grayscale-0 transition-all duration-500">
                                    <div class="absolute inset-0 bg-gradient-to-t from-primary/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                        <div class="text-white text-[10px] font-black uppercase tracking-widest bg-black/40 px-3 py-1.5 rounded-full backdrop-blur-md border border-white/20">
                                            BROWSE
                                        </div>
                                    </div>
                                </div>
                                <div class="space-y-1">
                                    <h3 class="text-base font-display font-bold text-gray-900 group-hover:text-primary transition-colors uppercase tracking-tight line-clamp-1">{{ $category->name }}</h3>
                                    <span class="inline-block text-[10px] font-black bg-primary/10 text-primary px-2 py-0.5 rounded-full uppercase tracking-tighter">
                                        {{ $category->products_count ?? $category->products->count() }} DEALS
                                    </span>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Navigation Arrows (Side Aligned) -->
                <button @click="prev()"
                        class="absolute left-0 top-1/2 -translate-y-1/2 w-12 h-12 bg-white rounded-full shadow-xl flex items-center justify-center text-gray-400 hover:text-primary border border-gray-100 transition-all duration-300 transform -translate-x-1/2 group-hover/carousel:translate-x-0 !opacity-0 group-hover/carousel:!opacity-100 z-20"
                        :class="currentIndex === 0 ? 'pointer-events-none opacity-20' : ''">
                    <i class="fas fa-arrow-left"></i>
                </button>
                <button @click="next()"
                        class="absolute right-0 top-1/2 -translate-y-1/2 w-12 h-12 bg-white rounded-full shadow-xl flex items-center justify-center text-gray-400 hover:text-red-600 border border-gray-100 transition-all duration-300 transform translate-x-1/2 group-hover/carousel:translate-x-0 !opacity-0 group-hover/carousel:!opacity-100 z-20"
                        :class="currentIndex + itemsPerPage >= totalItems ? 'pointer-events-none opacity-20' : ''">
                    <i class="fas fa-arrow-right"></i>
                </button>
            </div>

            <!-- Indicators -->
            <div class="flex justify-center gap-3 mt-4">
                <template x-for="i in Math.ceil(Math.max(1, (totalItems - itemsPerPage) / 3) + 1)" :key="i">
                    @if($dealCategories->count() > 3)
                    <button @click="currentIndex = Math.min((i - 1) * 3, totalItems - itemsPerPage)"
                            class="h-1.5 rounded-full transition-all duration-500"
                            :class="Math.floor(currentIndex / 3) === (i - 1) ? 'w-12 bg-primary shadow-lg shadow-primary/50' : 'w-3 bg-gray-200'"></button>
                    @endif
                </template>
            </div>
        </section>
        @endif
    </div>

    <!-- Newsletter / CTA -->
    <div class="bg-gray-900 py-20 mt-12 overflow-hidden relative">
        <!-- Decorative blobs -->
        <div class="absolute top-1/2 left-0 -translate-y-1/2 -translate-x-1/4 w-96 h-96 bg-primary opacity-20 blur-[100px] pointer-events-none"></div>
        <div class="absolute top-1/2 right-0 -translate-y-1/2 translate-x-1/4 w-96 h-96 bg-primary/80 opacity-20 blur-[100px] pointer-events-none"></div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-3xl mx-auto text-center border-2 border-dashed border-primary/30 p-12 rounded-[50px]">
                <h2 class="text-3xl md:text-5xl font-display font-black text-white mb-6">{{ $sections['newsletter']['title'] ?? 'DON\'T MISS THE NEXT DEAL!' }}</h2>
                <p class="text-gray-400 text-lg mb-8 font-medium">{{ $sections['newsletter']['description'] ?? 'Be the first to know about our exclusive limited-time discounts and upcoming sales events.' }}</p>

                <button onclick="window.location.href='{{ $sections['newsletter']['button_url'] ?? route('shop') }}'"
                        class="mt-6 w-full sm:w-auto px-10 py-4 bg-linear-to-r from-yellow-400 to-orange-500 text-primary font-black rounded-2xl hover:from-orange-500 hover:to-yellow-400 transition transform hover:scale-105 active:scale-95 shadow-xl shadow-yellow-500/20">
                    <i class="fas fa-shopping-bag mr-2"></i>{{ $sections['newsletter']['button_text'] ?? 'Shop Now' }}
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function dealsPage() {
    return {
        countdown: {
            hours: '23',
            minutes: '59',
            seconds: '59'
        },
        initCountdown() {
            // Set end time based on dynamic countdown hours from admin
            let countdownHours = {{ $sections['lightning_deals']['countdown_hours'] ?? 24 }};
            let endTime = new Date();
            endTime.setHours(endTime.getHours() + countdownHours);

            setInterval(() => {
                let now = new Date().getTime();
                let distance = endTime.getTime() - now;

                if (distance < 0) {
                    distance = 24 * 60 * 60 * 1000; // Reset for demo purposes
                    endTime = new Date();
                    endTime.setHours(endTime.getHours() + 24);
                }

                let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                let seconds = Math.floor((distance % (1000 * 60)) / 1000);

                this.countdown.hours = hours.toString().padStart(2, '0');
                this.countdown.minutes = minutes.toString().padStart(2, '0');
                this.countdown.seconds = seconds.toString().padStart(2, '0');
            }, 1000);
        },
        addToCart(productId) {
            fetch(`/cart/add/${productId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ quantity: 1 })
            })
            .then(async res => {
                const data = await res.json();
                if (!res.ok) throw new Error(data.message || 'Server error');
                return data;
            })
            .then(data => {
                if(data.success) {
                    window.location.href = data.redirect || '{{ route('cart.index') }}';
                }
            })
            .catch(err => {
                window.dispatchEvent(new CustomEvent('toast', {
                    detail: { type: 'error', message: err.message || 'Failed to add product' }
                }));
            });
        }
    }
}

function categoryCarousel(total) {
    return {
        currentIndex: 0,
        totalItems: total,
        itemsPerPage: 6,
        gap: 32,
        init() {
            this.updateItemsPerPage();
            window.addEventListener('resize', () => this.updateItemsPerPage());
        },
        updateItemsPerPage() {
            if (window.innerWidth < 640) this.itemsPerPage = 1;
            else if (window.innerWidth < 1024) this.itemsPerPage = 2;
            else this.itemsPerPage = 3;
        },
        next() {
            if (this.currentIndex + 3 < this.totalItems) {
                this.currentIndex += 3;
            } else if (this.currentIndex < this.totalItems - this.itemsPerPage) {
                this.currentIndex = this.totalItems - this.itemsPerPage;
            } else {
                this.currentIndex = 0;
            }
        },
        prev() {
            if (this.currentIndex - 3 >= 0) {
                this.currentIndex -= 3;
            } else if (this.currentIndex > 0) {
                this.currentIndex = 0;
            } else {
                this.currentIndex = Math.max(0, this.totalItems - this.itemsPerPage);
            }
        }
    }
}
</script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap');

    .font-display {
        font-family: 'Outfit', sans-serif;
    }

    [x-cloak] { display: none !important; }

    /* Custom Scrollbar for better UX */
    ::-webkit-scrollbar {
        width: 8px;
    }
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    ::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 10px;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: #cbd5e1;
    }
</style>
@endsection
