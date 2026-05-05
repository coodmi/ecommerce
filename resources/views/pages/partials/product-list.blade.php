<div class="grid grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-5">
    @foreach($products as $product)
    @php
        $primaryImage = $product->primaryImage ?? $product->images->first();
        $imageUrl = $primaryImage ? $primaryImage->url : asset('images/placeholder-product.jpg');
        $rating = (float)($product->rating ?? 0);
    @endphp

    <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col">

        <!-- ===== IMAGE AREA ===== -->
        <a href="{{ route('product.details', $product->slug) }}" class="block relative overflow-hidden aspect-[4/5]">

            <img src="{{ $imageUrl }}" alt="{{ $product->name }}"
                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">

            <!-- Category Badge -->
            <div class="absolute top-3 left-3 z-10">
                <span class="px-3 py-1 bg-white/90 backdrop-blur-sm text-gray-800 text-[11px] font-bold rounded-full shadow-sm">
                    {{ $product->category->name ?? '' }}
                </span>
            </div>

            <!-- Sale Badge -->
            @if($product->discount_price)
            <div class="absolute top-3 right-3 z-10">
                <span class="px-2 py-1 bg-red-500 text-white text-[10px] font-bold rounded-full">SALE</span>
            </div>
            @endif

            <!-- Out of Stock Overlay -->
            @if($product->stock_quantity <= 0)
            <div class="absolute inset-0 bg-white/60 flex items-center justify-center z-10">
                <span class="bg-red-500 text-white text-xs font-bold px-4 py-1.5 rounded-full">Out of Stock</span>
            </div>
            @endif

            <!-- Action Icons — slide up from bottom of image on hover -->
            <div class="absolute bottom-0 left-0 right-0 z-20 flex items-center justify-center gap-3 py-3
                        translate-y-full group-hover:translate-y-0 opacity-0 group-hover:opacity-100
                        transition-all duration-300 bg-gradient-to-t from-black/50 to-transparent">
                <!-- View -->
                <span class="w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-md hover:bg-primary hover:text-white transition-all text-gray-700">
                    <i class="fas fa-eye text-sm"></i>
                </span>
                <!-- Wishlist -->
                <button type="button" onclick="event.preventDefault(); toggleWishlist({{ $product->id }})"
                        class="w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-md hover:bg-rose-500 hover:text-white transition-all text-gray-700">
                    <i class="fas fa-heart text-sm"></i>
                </button>
                <!-- Quick Add to Cart -->
                @if($product->stock_quantity > 0)
                <form action="{{ route('cart.add', $product->id) }}" method="POST" onclick="event.stopPropagation()">
                    @csrf
                    <button type="submit"
                            class="w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-md hover:bg-primary hover:text-white transition-all text-gray-700">
                        <i class="fas fa-shopping-cart text-sm"></i>
                    </button>
                </form>
                @endif
            </div>

        </a>

        <!-- ===== CONTENT AREA ===== -->
        <div class="p-3 sm:p-4 flex flex-col flex-1">

            <!-- Name -->
            <a href="{{ route('product.details', $product->slug) }}" class="block mb-1">
                <h3 class="text-sm sm:text-base font-bold text-primary uppercase tracking-tight line-clamp-2 leading-snug hover:opacity-80 transition">
                    {{ $product->name }}
                </h3>
            </a>

            <!-- Rating -->
            <div class="flex items-center gap-1 mb-3">
                <div class="flex text-yellow-400 text-xs">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $rating) <i class="fas fa-star"></i>
                        @elseif($i - 0.5 <= $rating) <i class="fas fa-star-half-alt"></i>
                        @else <i class="far fa-star text-gray-200"></i>
                        @endif
                    @endfor
                </div>
                <span class="text-[11px] text-gray-500 font-semibold">({{ number_format($rating, 1) }})</span>
            </div>

            <!-- Price + Stock -->
            <div class="flex items-center justify-between mt-auto pt-3 border-t border-gray-100">
                <div>
                    <span class="text-base sm:text-xl font-black text-gray-900">${{ number_format($product->base_price, 2) }}</span>
                    @if($product->discount_price)
                    <span class="text-xs text-gray-400 line-through ml-1">${{ number_format($product->base_price, 2) }}</span>
                    @endif
                </div>
                @if($product->stock_quantity > 0)
                <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full uppercase tracking-wide">In Stock</span>
                @else
                <span class="text-[10px] font-bold text-rose-600 bg-rose-50 px-2.5 py-1 rounded-full uppercase tracking-wide">Out of Stock</span>
                @endif
            </div>

            <!-- Colors & Sizes -->
            @if($product->colors->count() > 0 || $product->sizes->count() > 0)
            <div class="mt-2.5 flex items-center gap-3">
                @if($product->colors->count() > 0)
                <div class="flex -space-x-1.5">
                    @foreach($product->colors->take(4) as $color)
                    <div class="w-4 h-4 rounded-full border-2 border-white shadow-sm" style="background-color: {{ $color->color_code }}"></div>
                    @endforeach
                    @if($product->colors->count() > 4)
                    <div class="w-4 h-4 rounded-full border-2 border-white bg-gray-100 flex items-center justify-center text-[7px] font-bold text-gray-500">+{{ $product->colors->count() - 4 }}</div>
                    @endif
                </div>
                @endif
                @if($product->sizes->count() > 0)
                <div class="flex gap-1">
                    @foreach($product->sizes->take(3) as $size)
                    <span class="text-[10px] font-semibold text-gray-400 uppercase">{{ $size->size_name }}</span>
                    @endforeach
                </div>
                @endif
            </div>
            @endif

            <!-- Add to Cart Button -->
            @if($product->stock_quantity > 0)
            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-3">
                @csrf
                <button type="submit"
                        class="w-full py-2.5 bg-primary text-white text-xs font-bold rounded-xl flex items-center justify-center gap-2 hover:bg-primary/90 active:scale-95 transition-all">
                    <i class="fas fa-shopping-cart text-xs"></i> Add to Cart
                </button>
            </form>
            @else
            <div class="mt-3 w-full py-2.5 bg-gray-100 text-gray-400 text-xs font-bold rounded-xl flex items-center justify-center gap-2 cursor-not-allowed">
                <i class="fas fa-ban text-xs"></i> Out of Stock
            </div>
            @endif
        </div>

    </div>
    @endforeach
</div>
