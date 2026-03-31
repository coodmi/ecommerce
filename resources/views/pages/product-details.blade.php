@extends('layouts.app')

@section('title', $product->name . ' - Ecom Alpha')

@section('content')
<!-- Breadcrumb -->
<section class="bg-slate-50 border-b border-slate-200 py-6 mb-12">
    <div class="container mx-auto px-4">
        <nav class="flex items-center space-x-2 text-sm font-medium">
            <a href="/" class="text-slate-500 hover:text-primary transition">Home</a>
            <i class="fas fa-chevron-right text-[10px] text-slate-300"></i>
            <a href="{{ route('shop') }}" class="text-slate-500 hover:text-primary transition">Shop</a>
            <i class="fas fa-chevron-right text-[10px] text-slate-300"></i>
            <span class="text-slate-900">{{ $product->name }}</span>
        </nav>
    </div>
</section>

<div class="container mx-auto px-4 pb-20" x-data="productDetails({
    basePrice: {{ $product->base_price }},
    variants: {{ $product->variants->toJson() }},
    colors: {{ $product->colors->toJson() }},
    sizes: {{ $product->sizes->toJson() }}
})">
    <div class="flex flex-col lg:flex-row gap-16">
        <!-- Image Gallery -->
        <div class="lg:w-1/2">
            <div class="sticky top-24">
                <div class="relative aspect-square rounded-[2.5rem] overflow-hidden bg-slate-50 border border-slate-100 group">
                    <img :src="activeImage" 
                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" 
                         alt="{{ $product->name }}">
                    
                    @if($product->stock_quantity <= 0)
                    <div class="absolute inset-0 bg-white/60 backdrop-blur-[2px] flex items-center justify-center">
                        <span class="px-8 py-4 bg-rose-600 text-white font-black uppercase tracking-[0.2em] rounded-full shadow-2xl rotate-[-5deg]">
                            Out of Stock
                        </span>
                    </div>
                    @endif
                </div>

                <!-- Thumbnails -->
                @if($product->images->count() > 1)
                <div class="mt-6 flex flex-wrap gap-4">
                    @foreach($product->images as $image)
                    <button @click="activeImage = '{{ $image->url }}'" 
                            class="w-24 h-24 rounded-2xl overflow-hidden border-2 transition-all duration-300 hover:scale-105"
                            :class="activeImage === '{{ $image->url }}' ? 'border-primary shadow-lg' : 'border-slate-100 hover:border-slate-300'">
                        <img src="{{ $image->url }}" class="w-full h-full object-cover" alt="Thumbnail">
                    </button>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        <!-- Product Info -->
        <div class="lg:w-1/2">
            <div class="flex flex-col h-full">
                <!-- Header -->
                <div class="mb-8">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="px-4 py-1.5 bg-primary/5 text-primary text-[10px] font-black uppercase tracking-[0.1em] rounded-full">
                            {{ $product->category->name }}
                        </span>
                        @if($product->stock_quantity > 0)
                        <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> IN STOCK
                        </span>
                        @endif
                    </div>
                    <h1 class="text-4xl md:text-5xl font-black text-slate-900 mb-4 tracking-tight leading-tight uppercase">
                        {{ $product->name }}
                    </h1>
                    <div class="flex items-end gap-3">
                        <span class="text-4xl font-black text-slate-900" x-text="'$' + currentPrice.toFixed(2)">
                            ${{ number_format($product->base_price, 2) }}
                        </span>
                        <span class="text-slate-400 font-medium mb-1.5">tax included</span>
                    </div>
                </div>

                <!-- Description -->
                <div class="prose prose-slate max-w-none mb-10 text-slate-600 leading-relaxed">
                    {!! nl2br(e($product->description)) !!}
                </div>

                <!-- Options -->
                <div class="space-y-8 mb-12">
                    <!-- Colors -->
                    @if($product->colors->count() > 0)
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-xs font-black text-slate-900 uppercase tracking-widest">Select Color</span>
                            <span class="text-xs font-bold text-primary" x-text="selectedColorName"></span>
                        </div>
                        <div class="flex flex-wrap gap-4">
                            @foreach($product->colors as $color)
                            <button @click="selectColor({{ $color->id }}, '{{ $color->color_name }}')" 
                                    class="w-10 h-10 rounded-full border-2 transition-all duration-300 hover:scale-110 flex items-center justify-center relative cursor-pointer"
                                    :class="selectedColor === {{ $color->id }} ? 'border-primary scale-110' : 'border-slate-100'"
                                    style="background-color: {{ $color->color_code }}"
                                    title="{{ $color->color_name }}">
                                <i x-show="selectedColor === {{ $color->id }}" 
                                   class="fas fa-check text-[10px]" 
                                   :class="'{{ $color->color_code }}' === '#FFFFFF' ? 'text-black' : 'text-white'"></i>
                            </button>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Sizes -->
                    @if($product->sizes->count() > 0)
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-xs font-black text-slate-900 uppercase tracking-widest">Select Size</span>
                            <span class="text-xs font-bold text-primary" x-text="selectedSizeName"></span>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            @foreach($product->sizes as $size)
                            <button @click="selectSize({{ $size->id }}, '{{ $size->size_name }}')" 
                                    class="px-6 py-3 border-2 rounded-2xl text-xs font-black transition-all duration-300 hover:border-primary/50 cursor-pointer"
                                    :class="selectedSize === {{ $size->id }} ? 'bg-slate-900 text-white border-slate-900 shadow-xl scale-105' : 'bg-white text-slate-600 border-slate-100'">
                                {{ $size->size_name }}
                            </button>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Quantity -->
                    <div>
                        <span class="text-xs font-black text-slate-900 uppercase tracking-widest mb-4 block">Quantity</span>
                        <div class="flex items-center gap-6">
                            <div class="flex items-center bg-slate-50 rounded-2xl p-1 shadow-inner">
                                <button @click="quantity > 1 ? quantity-- : null" class="w-10 h-10 flex items-center justify-center text-slate-400 hover:text-slate-900 hover:bg-white rounded-xl transition cursor-pointer">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" x-model="quantity" class="w-16 bg-transparent text-center font-bold text-slate-900 outline-none border-none pointer-events-none" readonly>
                                <button @click="quantity++" class="w-10 h-10 flex items-center justify-center text-slate-400 hover:text-slate-900 hover:bg-white rounded-xl transition cursor-pointer">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <span class="text-xs font-medium text-slate-400">Limited stock available</span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row gap-4 mt-auto">
                    <button @click="addToCart()" 
                            :disabled="isAddingToCart"
                            class="flex-1 bg-slate-900 text-white px-8 py-5 rounded-3xl font-black uppercase tracking-[0.2em] shadow-2xl shadow-slate-200 hover:bg-slate-800 transition-all duration-300 flex items-center justify-center gap-3 cursor-pointer disabled:opacity-50">
                        <i class="fas" :class="isAddingToCart ? 'fa-spinner fa-spin' : 'fa-shopping-bag'"></i> 
                        <span x-text="isAddingToCart ? 'Adding...' : 'Add to Bag'"></span>
                    </button>
                    
                    <button @click="addToWishlist()"
                            class="px-8 py-5 bg-white text-slate-900 border-2 border-slate-900 rounded-3xl font-black uppercase tracking-[0.2em] hover:bg-slate-50 transition-all duration-300 flex items-center justify-center gap-3 cursor-pointer">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>

                <!-- Info Grid -->
                <div class="grid grid-cols-2 gap-8 mt-12 pt-12 border-t border-slate-100">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400">
                            <i class="fas fa-truck text-xs"></i>
                        </div>
                        <div>
                            <span class="block text-[10px] font-black text-slate-900 uppercase tracking-widest mb-1">Free Delivery</span>
                            <span class="text-xs text-slate-400 font-medium">Orders over $200</span>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400">
                            <i class="fas fa-undo text-xs"></i>
                        </div>
                        <div>
                            <span class="block text-[10px] font-black text-slate-900 uppercase tracking-widest mb-1">Easy Returns</span>
                            <span class="text-xs text-slate-400 font-medium">30 days return policy</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <section class="mt-32 border-t border-slate-100 pt-32" id="reviews">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-16">
            <!-- Review Summary -->
            <div>
                <h2 class="text-3xl font-black text-slate-900 uppercase tracking-tight mb-8">Customer Reviews</h2>
                <div class="bg-slate-50 rounded-[2.5rem] p-10 border border-slate-100">
                    <div class="flex items-center gap-4 mb-6">
                        <span class="text-6xl font-black text-slate-900">{{ number_format($product->rating ?? 0, 1) }}</span>
                        <div>
                            <div class="flex text-yellow-400 text-sm mb-1">
                                @php $rating = (float)($product->rating ?? 0); @endphp
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $rating)
                                        <i class="fas fa-star"></i>
                                    @elseif($i - 0.5 <= $rating)
                                        <i class="fas fa-star-half-alt"></i>
                                    @else
                                        <i class="far fa-star text-slate-300"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Based on {{ $product->reviews()->where('status', 'approved')->count() }} reviews</span>
                        </div>
                    </div>
                    
                    @auth
                    <div x-data="{ rating: 5, comment: '' }" class="mt-8 pt-8 border-t border-slate-200">
                        <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-6">Write a Review</h3>
                        <form action="{{ route('reviews.store', $product) }}" method="POST" class="space-y-6">
                            @csrf
                            <input type="hidden" name="rating" :value="rating">
                            
                            <!-- Star Selection -->
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Your Rating</label>
                                <div class="flex gap-2">
                                    <template x-for="i in 5">
                                        <button type="button" 
                                                @click="rating = i" 
                                                class="text-2xl transition-transform hover:scale-120 focus:outline-none"
                                                :class="i <= rating ? 'text-yellow-400' : 'text-slate-200'">
                                            <i class="fas fa-star"></i>
                                        </button>
                                    </template>
                                </div>
                            </div>

                            <div>
                                <label for="comment" class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Your Opinion</label>
                                <textarea id="comment" 
                                          name="comment" 
                                          rows="4" 
                                          x-model="comment"
                                          required
                                          placeholder="Share your experience with this product..."
                                          class="w-full px-6 py-4 bg-white border border-slate-200 rounded-2xl focus:ring-4 focus:ring-primary/5 focus:border-primary outline-none transition-all text-sm text-slate-600 leading-relaxed"></textarea>
                            </div>

                            <button type="submit" 
                                    class="w-full py-4 bg-slate-900 text-white rounded-2xl font-black uppercase tracking-[0.2em] text-xs shadow-xl shadow-slate-200 hover:bg-slate-800 transition-all active:scale-95">
                                Submit Review
                            </button>
                        </form>
                    </div>
                    @else
                    <div class="mt-8 pt-8 border-t border-slate-200 text-center">
                        <p class="text-sm text-slate-500 mb-6">Please log in to write a review.</p>
                        <a href="{{ route('login') }}" class="inline-block px-8 py-3 bg-slate-900 text-white rounded-xl font-black uppercase tracking-widest text-[10px]">Login Now</a>
                    </div>
                    @endauth
                </div>
            </div>

            <!-- Reviews List -->
            <div class="lg:col-span-2">
                <div class="space-y-8">
                    @forelse($product->reviews()->where('status', 'approved')->latest()->get() as $review)
                    <div class="p-8 bg-white border border-slate-100 rounded-[2rem] hover:shadow-xl hover:shadow-slate-100 transition-all duration-500 group">
                        <div class="flex items-start justify-between mb-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 font-black text-lg">
                                    {{ substr($review->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <h4 class="font-black text-slate-900 uppercase tracking-tight">{{ $review->user->name }}</h4>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $review->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                            <div class="flex text-yellow-400 text-[10px] bg-yellow-400/5 px-3 py-1.5 rounded-full border border-yellow-400/10">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star"></i>
                                @endfor
                            </div>
                        </div>
                        <p class="text-slate-600 leading-relaxed text-sm">
                            {{ $review->comment }}
                        </p>
                    </div>
                    @empty
                    <div class="text-center py-20 bg-slate-50 rounded-[2.5rem] border border-dashed border-slate-200">
                        <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm">
                            <i class="fas fa-comments text-slate-300"></i>
                        </div>
                        <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight">No reviews yet</h3>
                        <p class="text-slate-400 text-sm max-w-xs mx-auto mt-2">Be the first to share your thoughts about this product!</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
    <section class="mt-32">
        <div class="flex items-end justify-between mb-12">
            <div>
                <span class="text-[10px] font-black text-primary uppercase tracking-[0.3em] mb-3 block">Complete the look</span>
                <h2 class="text-4xl font-black text-slate-900 uppercase tracking-tight">You May Also Like</h2>
            </div>
            <a href="{{ route('shop') }}" class="text-xs font-black uppercase tracking-widest text-slate-400 hover:text-slate-900 transition flex items-center gap-2">
                Explore All <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($relatedProducts as $related)
            <div class="group cursor-pointer">
                <div class="relative aspect-[4/5] rounded-[2rem] overflow-hidden mb-6 bg-slate-50 border border-slate-100">
                    <img src="{{ $related->primaryImage ? $related->primaryImage->url : asset('images/placeholder-product.jpg') }}" 
                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" 
                         alt="{{ $related->name }}">
                    <a href="{{ route('product.details', $related->slug) }}" class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                        <span class="px-6 py-3 bg-white text-slate-900 rounded-full text-xs font-black uppercase tracking-widest">View Product</span>
                    </a>
                </div>
                <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest mb-2">{{ $related->name }}</h3>
                <span class="text-lg font-black text-slate-900">${{ number_format($related->base_price, 2) }}</span>
            </div>
            @endforeach
        </div>
    </section>
    @endif
</div>

@push('scripts')
<script>
function productDetails(data) {
    return {
        activeImage: '{{ ($product->primaryImage ?? $product->images->first())->url ?? asset('images/placeholder-product.jpg') }}',
        currentPrice: data.basePrice,
        selectedColor: null,
        selectedColorName: '',
        selectedSize: null,
        selectedSizeName: '',
        quantity: 1,
        variants: data.variants,
        isAddingToCart: false,

        init() {
            // Pick first color/size if available
            if (data.colors.length > 0) {
                this.selectColor(data.colors[0].id, data.colors[0].color_name);
            }
            if (data.sizes.length > 0) {
                this.selectSize(data.sizes[0].id, data.sizes[0].size_name);
            }
        },

        selectColor(id, name) {
            this.selectedColor = id;
            this.selectedColorName = name;
            this.updatePrice();
        },

        selectSize(id, name) {
            this.selectedSize = id;
            this.selectedSizeName = name;
            this.updatePrice();
        },

        updatePrice() {
            // Find matching variant
            const variant = this.variants.find(v => {
                const colorMatch = this.selectedColor ? v.color_id == this.selectedColor : true;
                const sizeMatch = this.selectedSize ? v.size_id == this.selectedSize : true;
                return colorMatch && sizeMatch;
            });

            if (variant && variant.price) {
                this.currentPrice = parseFloat(variant.price);
            } else {
                this.currentPrice = data.basePrice;
            }
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
                body: JSON.stringify({ 
                    quantity: this.quantity,
                    color_id: this.selectedColor,
                    size_id: this.selectedSize
                })
            })
            .then(async res => {
                const data = await res.json();
                if (!res.ok) throw new Error(data.message || 'Server error');
                return data;
            })
            .then(data => {
                this.isAddingToCart = false;
                if(data.success) {
                    window.location.href = data.redirect || '{{ route('cart.index') }}';
                }
            })
            .catch(err => {
                this.isAddingToCart = false;
                window.dispatchEvent(new CustomEvent('toast', {
                    detail: { type: 'error', message: err.message || 'Failed to add to cart' }
                }));
            });
        },

        addToWishlist() {
            toggleWishlist({{ $product->id }});
        }
    }
}
</script>
@endpush

@endsection
