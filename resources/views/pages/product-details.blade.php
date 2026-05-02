@extends('layouts.app')

@section('title', $product->name . ' - ' . config('app.name'))

@section('content')

<!-- Breadcrumb -->
<div class="bg-gray-50 border-b border-gray-100 py-3">
    <div class="container mx-auto px-3 sm:px-4">
        <nav class="flex items-center gap-2 text-xs text-gray-500">
            <a href="/" class="hover:text-primary transition">Home</a>
            <i class="fas fa-chevron-right text-[9px]"></i>
            <a href="{{ route('shop') }}" class="hover:text-primary transition">Shop</a>
            <i class="fas fa-chevron-right text-[9px]"></i>
            <span class="text-gray-800 font-medium truncate max-w-[200px]">{{ $product->name }}</span>
        </nav>
    </div>
</div>

<div class="container mx-auto px-3 sm:px-4 py-5 md:py-12" x-data="productDetails({
    basePrice: {{ $product->base_price }},
    variants: {{ $product->variants->toJson() }},
    colors: {{ $product->colors->toJson() }},
    sizes: {{ $product->sizes->toJson() }}
})">

    <!-- Product Main -->
    <div class="flex flex-col lg:flex-row gap-6 lg:gap-12">

        <!-- Image Gallery -->
        <div class="w-full lg:w-[45%]">
            <div class="lg:sticky lg:top-24">

                {{-- Thumbnails left + main image right (mobile & desktop) --}}
                @if($product->images->count() > 1)
                <div class="flex gap-2">
                    <!-- Vertical thumbnails (left column) -->
                    <div class="flex flex-col gap-2 flex-shrink-0 w-14 lg:w-16">
                        @foreach($product->images as $image)
                        <button @click="activeImage = '{{ $image->url }}'"
                                class="w-14 h-14 lg:w-16 lg:h-16 rounded-lg overflow-hidden border-2 transition-all flex-shrink-0"
                                :class="activeImage === '{{ $image->url }}' ? 'border-primary' : 'border-gray-200 hover:border-gray-300'">
                            <img src="{{ $image->url }}" class="w-full h-full object-cover" alt="">
                        </button>
                        @endforeach
                    </div>

                    <!-- Main Image -->
                    <div class="relative rounded-xl overflow-hidden bg-gray-50 border border-gray-100 flex-1 aspect-square lg:rounded-2xl">
                        <img :src="activeImage"
                             class="w-full h-full object-cover transition-transform duration-500 hover:scale-105"
                             alt="{{ $product->name }}">
                        @if($product->stock_quantity <= 0)
                        <div class="absolute inset-0 bg-white/70 flex items-center justify-center">
                            <span class="bg-red-500 text-white text-xs font-bold px-4 py-2 rounded-full">Out of Stock</span>
                        </div>
                        @endif
                        @if($product->discount_price)
                        <div class="absolute top-3 left-3 bg-red-500 text-white text-xs font-bold px-2.5 py-1 rounded-full">SALE</div>
                        @endif
                    </div>
                </div>

                @else
                {{-- Single image, no thumbnails --}}
                <div class="relative rounded-xl lg:rounded-2xl overflow-hidden bg-gray-50 border border-gray-100 aspect-square">
                    <img :src="activeImage"
                         class="w-full h-full object-cover transition-transform duration-500 hover:scale-105"
                         alt="{{ $product->name }}">
                    @if($product->stock_quantity <= 0)
                    <div class="absolute inset-0 bg-white/70 flex items-center justify-center">
                        <span class="bg-red-500 text-white text-xs font-bold px-4 py-2 rounded-full">Out of Stock</span>
                    </div>
                    @endif
                    @if($product->discount_price)
                    <div class="absolute top-3 left-3 bg-red-500 text-white text-xs font-bold px-2.5 py-1 rounded-full">SALE</div>
                    @endif
                </div>
                @endif

            <!-- Description — desktop only (below thumbnails) -->
            @if($product->description)
            <div class="hidden lg:block mt-5 pt-5 border-t border-gray-100">
                <p class="text-sm text-gray-600 leading-relaxed">
                    {!! nl2br(e($product->description)) !!}
                </p>
            </div>
            @endif

            </div>{{-- end sticky --}}
        </div>{{-- end image column --}}

        <!-- Product Info -->
        <div class="w-full lg:w-[55%]">

            <!-- Category & Stock -->
            <div class="flex items-center gap-3 mb-3">
                <span class="text-xs font-semibold text-primary bg-primary/8 px-3 py-1 rounded-full">
                    {{ $product->category->name ?? 'Uncategorized' }}
                </span>
                @if($product->stock_quantity > 0)
                <span class="text-xs text-emerald-600 font-semibold flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block"></span> In Stock
                </span>
                @else
                <span class="text-xs text-red-500 font-semibold">Out of Stock</span>
                @endif
            </div>

            <!-- Product Name -->
            <h1 class="text-xl md:text-2xl font-bold text-gray-900 leading-snug mb-3">
                {{ $product->name }}
            </h1>

            <!-- Rating -->
            @if($product->rating)
            <div class="flex items-center gap-2 mb-4">
                <div class="flex text-yellow-400 text-xs">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="{{ $i <= $product->rating ? 'fas' : 'far' }} fa-star"></i>
                    @endfor
                </div>
                <span class="text-xs text-gray-500">({{ $product->reviews()->where('status','approved')->count() }} reviews)</span>
            </div>
            @endif

            <!-- Price -->
            <div class="flex items-baseline gap-3 mb-5">
                <span class="text-2xl font-bold text-gray-900" x-text="'$' + currentPrice.toFixed(2)">
                    ${{ number_format($product->base_price, 2) }}
                </span>
                @if($product->discount_price)
                <span class="text-sm text-gray-400 line-through">${{ number_format($product->base_price, 2) }}</span>
                @endif
                <span class="text-xs text-gray-400">tax included</span>
            </div>

            <!-- Options -->
            <div class="space-y-5 mb-6">

                <!-- Colors -->
                @if($product->colors->count() > 0)
                <div>
                    <div class="flex items-center justify-between mb-2.5">
                        <span class="text-xs font-semibold text-gray-700 uppercase tracking-wide">Color</span>
                        <span class="text-xs text-primary font-medium" x-text="selectedColorName"></span>
                    </div>
                    <div class="flex flex-wrap gap-2.5">
                        @foreach($product->colors as $color)
                        <button @click="selectColor({{ $color->id }}, '{{ $color->color_name }}')"
                                class="w-8 h-8 rounded-full border-2 transition-all hover:scale-110 flex items-center justify-center"
                                :class="selectedColor === {{ $color->id }} ? 'border-primary ring-2 ring-primary/20 scale-110' : 'border-gray-200'"
                                style="background-color: {{ $color->color_code }}"
                                title="{{ $color->color_name }}">
                            <i x-show="selectedColor === {{ $color->id }}"
                               class="fas fa-check text-[9px]"
                               :class="'{{ $color->color_code }}' === '#FFFFFF' ? 'text-black' : 'text-white'"></i>
                        </button>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Sizes -->
                @if($product->sizes->count() > 0)
                <div>
                    <div class="mb-2.5">
                        <span class="text-xs font-semibold text-gray-700 uppercase tracking-wide">Size</span>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        @foreach($product->sizes as $size)
                        <button @click="selectSize({{ $size->id }}, '{{ $size->size_name }}')"
                                class="px-4 py-2 border rounded-lg text-xs font-semibold transition-all"
                                :class="selectedSize === {{ $size->id }} ? 'bg-primary text-white border-primary' : 'bg-white text-gray-700 border-gray-200 hover:border-primary/40'">
                            {{ $size->size_name }}
                        </button>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Quantity -->
                <div>
                    <span class="text-xs font-semibold text-gray-700 uppercase tracking-wide mb-2.5 block">Quantity</span>
                    <div class="flex items-center gap-4">
                        <div class="flex items-center border border-gray-200 rounded-lg overflow-hidden">
                            <button @click="quantity > 1 ? quantity-- : null"
                                    class="w-9 h-9 flex items-center justify-center text-gray-500 hover:bg-gray-50 transition">
                                <i class="fas fa-minus text-xs"></i>
                            </button>
                            <span class="w-10 text-center text-sm font-semibold text-gray-900" x-text="quantity">1</span>
                            <button @click="quantity++"
                                    class="w-9 h-9 flex items-center justify-center text-gray-500 hover:bg-gray-50 transition">
                                <i class="fas fa-plus text-xs"></i>
                            </button>
                        </div>
                        @if($product->stock_quantity > 0 && $product->stock_quantity <= 10)
                        <span class="text-xs text-orange-500 font-medium">Only {{ $product->stock_quantity }} left</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-3 mb-6">
                <button @click="addToCart()"
                        :disabled="isAddingToCart"
                        class="flex-1 bg-primary text-white py-3.5 px-6 rounded-xl font-semibold text-sm hover:bg-primary/90 transition flex items-center justify-center gap-2 disabled:opacity-60">
                    <i class="fas" :class="isAddingToCart ? 'fa-spinner fa-spin' : 'fa-bolt'"></i>
                    <span x-text="isAddingToCart ? 'Processing...' : 'Buy Now'"></span>
                </button>
                <button @click="addToWishlist()"
                        class="w-12 h-12 border border-gray-200 rounded-xl flex items-center justify-center text-gray-500 hover:text-red-500 hover:border-red-200 transition flex-shrink-0">
                    <i class="fas fa-heart text-sm"></i>
                </button>
            </div>

            <!-- Description — mobile only (after Buy Now) -->
            @if($product->description)
            <div class="lg:hidden mb-6 pt-5 border-t border-gray-100">
                <p class="text-sm text-gray-600 leading-relaxed">
                    {!! nl2br(e($product->description)) !!}
                </p>
            </div>
            @endif

            <!-- Trust Badges -->
            <div class="grid grid-cols-2 gap-3 pt-5 border-t border-gray-100">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-truck text-xs text-white"></i>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-800">Free Delivery</p>
                        <p class="text-[11px] text-gray-400">Orders over $200</p>
                    </div>
                </div>
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-undo text-xs text-white"></i>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-800">Easy Returns</p>
                        <p class="text-[11px] text-gray-400">30 day policy</p>
                    </div>
                </div>
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-shield-alt text-xs text-white"></i>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-800">Secure Payment</p>
                        <p class="text-[11px] text-gray-400">SSL encrypted</p>
                    </div>
                </div>
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-headset text-xs text-white"></i>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-800">24/7 Support</p>
                        <p class="text-[11px] text-gray-400">Always here to help</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <section class="mt-12 pt-10 border-t border-gray-100" id="reviews">
        <h2 class="text-lg font-bold text-gray-900 mb-6">Customer Reviews</h2>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Summary + Write Review -->
            <div>
                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 mb-4">
                    <div class="flex items-center gap-3 mb-1">
                        <span class="text-4xl font-bold text-gray-900">{{ number_format($product->rating ?? 0, 1) }}</span>
                        <div>
                            <div class="flex text-yellow-400 text-xs mb-1">
                                @php $rating = (float)($product->rating ?? 0); @endphp
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $rating) <i class="fas fa-star"></i>
                                    @elseif($i - 0.5 <= $rating) <i class="fas fa-star-half-alt"></i>
                                    @else <i class="far fa-star text-gray-300"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-xs text-gray-500">{{ $product->reviews()->where('status','approved')->count() }} reviews</span>
                        </div>
                    </div>
                </div>

                @auth
                <div x-data="{ rating: 5, comment: '' }" class="bg-white border border-gray-100 rounded-2xl p-5">
                    <h3 class="text-sm font-semibold text-gray-900 mb-4">Write a Review</h3>
                    <form action="{{ route('reviews.store', $product) }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="rating" :value="rating">
                        <div>
                            <label class="block text-xs text-gray-500 mb-1.5">Your Rating</label>
                            <div class="flex gap-1">
                                <template x-for="i in 5">
                                    <button type="button" @click="rating = i"
                                            class="text-xl transition-transform hover:scale-110"
                                            :class="i <= rating ? 'text-yellow-400' : 'text-gray-200'">
                                        <i class="fas fa-star"></i>
                                    </button>
                                </template>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1.5">Your Review</label>
                            <textarea name="comment" rows="4" x-model="comment" required
                                      placeholder="Share your experience..."
                                      class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:border-primary focus:outline-none resize-none"></textarea>
                        </div>
                        <button type="submit"
                                class="w-full py-2.5 bg-gray-900 text-white rounded-lg text-sm font-semibold hover:bg-gray-800 transition">
                            Submit Review
                        </button>
                    </form>
                </div>
                @else
                <div class="bg-white border border-gray-100 rounded-2xl p-5 text-center">
                    <p class="text-sm text-gray-500 mb-3">Log in to write a review</p>
                    <a href="{{ route('login') }}" class="inline-block px-5 py-2 bg-gray-900 text-white rounded-lg text-xs font-semibold">Login</a>
                </div>
                @endauth
            </div>

            <!-- Reviews List -->
            <div class="lg:col-span-2 space-y-4">
                @forelse($product->reviews()->where('status','approved')->latest()->get() as $review)
                <div class="bg-white border border-gray-100 rounded-xl p-5">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center text-sm font-bold text-gray-500">
                                {{ strtoupper(substr($review->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ $review->user->name }}</p>
                                <p class="text-xs text-gray-400">{{ $review->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                        <div class="flex text-yellow-400 text-xs">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star"></i>
                            @endfor
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 leading-relaxed">{{ $review->comment }}</p>
                </div>
                @empty
                <div class="text-center py-12 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                    <i class="fas fa-comments text-gray-300 text-3xl mb-3 block"></i>
                    <p class="text-sm font-semibold text-gray-700">No reviews yet</p>
                    <p class="text-xs text-gray-400 mt-1">Be the first to review this product</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
    <section class="mt-12 pt-10 border-t border-gray-100">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-gray-900">You May Also Like</h2>
            <a href="{{ route('shop') }}" class="text-xs text-primary font-semibold hover:underline flex items-center gap-1">
                View All <i class="fas fa-arrow-right text-[10px]"></i>
            </a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($relatedProducts as $related)
            <a href="{{ route('product.details', $related->slug) }}" class="group">
                <div class="bg-white rounded-xl border border-gray-100 overflow-hidden hover:shadow-md transition">
                    <div class="aspect-square overflow-hidden bg-gray-50">
                        <img src="{{ $related->primaryImage ? $related->primaryImage->url : asset('images/placeholder.jpg') }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                             alt="{{ $related->name }}">
                    </div>
                    <div class="p-3">
                        <p class="text-xs text-gray-500 mb-0.5">{{ $related->category->name ?? '' }}</p>
                        <h3 class="text-xs font-semibold text-gray-800 line-clamp-2 mb-1.5 group-hover:text-primary transition">{{ $related->name }}</h3>
                        <span class="text-sm font-bold text-gray-900">${{ number_format($related->base_price, 2) }}</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </section>
    @endif

</div>

@push('scripts')
<script>
function productDetails(data) {
    return {
        activeImage: '{{ ($product->primaryImage ?? $product->images->first())?->url ?? asset('images/placeholder.jpg') }}',
        currentPrice: data.basePrice,
        selectedColor: null,
        selectedColorName: '',
        selectedSize: null,
        selectedSizeName: '',
        quantity: 1,
        variants: data.variants,
        isAddingToCart: false,

        init() {
            if (data.colors.length > 0) this.selectColor(data.colors[0].id, data.colors[0].color_name);
            if (data.sizes.length > 0) this.selectSize(data.sizes[0].id, data.sizes[0].size_name);
        },

        selectColor(id, name) { this.selectedColor = id; this.selectedColorName = name; this.updatePrice(); },
        selectSize(id, name) { this.selectedSize = id; this.selectedSizeName = name; this.updatePrice(); },

        updatePrice() {
            const variant = this.variants.find(v => {
                const cm = this.selectedColor ? v.color_id == this.selectedColor : true;
                const sm = this.selectedSize ? v.size_id == this.selectedSize : true;
                return cm && sm;
            });
            this.currentPrice = (variant && variant.price) ? parseFloat(variant.price) : data.basePrice;
        },

        addToCart() {
            this.isAddingToCart = true;
            fetch(`/cart/add/{{ $product->id }}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ quantity: this.quantity, color_id: this.selectedColor, size_id: this.selectedSize })
            })
            .then(async res => { const d = await res.json(); if (!res.ok) throw new Error(d.message); return d; })
            .then(d => { this.isAddingToCart = false; if(d.success) window.location.href = d.redirect || '{{ route('cart.index') }}'; })
            .catch(err => {
                this.isAddingToCart = false;
                window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'error', message: err.message || 'Failed to add to cart' } }));
            });
        },

        addToWishlist() { toggleWishlist({{ $product->id }}); }
    }
}
</script>
@endpush

@endsection
