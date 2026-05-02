<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
    @foreach($products as $product)
    <div class="group relative bg-white rounded-3xl shadow-sm hover:shadow-2xl transition-all duration-500 overflow-hidden border border-gray-100 flex flex-col h-full">
        <!-- Whole Card Clickable Area -->
        <a href="{{ route('product.details', $product->slug) }}" class="absolute inset-0 z-[1]"></a>

        <!-- Image Area -->
        <div class="relative aspect-[4/5] overflow-hidden">
            @php
                $primaryImage = $product->primaryImage ?? $product->images->first();
                $imageUrl = $primaryImage ? $primaryImage->url : asset('images/placeholder-product.jpg');
            @endphp
            <a href="{{ route('product.details', $product->slug) }}" class="block w-full h-full relative z-[2]">
                <img src="{{ $imageUrl }}" 
                     alt="{{ $product->name }}" 
                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
            </a>
            
            </a>
            <!-- Category Badge -->
            <div class="absolute top-4 left-4 z-[3]">
                <span class="px-4 py-2 bg-white/90 backdrop-blur-md text-slate-900 text-xs font-bold rounded-full shadow-sm">
                    {{ $product->category->name }}
                </span>
            </div>

            <!-- Action Buttons -->
            <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition-all duration-500 flex items-center justify-center gap-3 translate-y-4 group-hover:translate-y-0 z-[2]">
                <a href="{{ route('product.details', $product->slug) }}" class="w-12 h-12 bg-white text-slate-900 rounded-full flex items-center justify-center hover:bg-primary hover:text-white transition-all shadow-lg cursor-pointer relative z-[3]">
                    <i class="fas fa-eye text-lg"></i>
                </a>
                <button onclick="toggleWishlist({{ $product->id }})" class="w-12 h-12 bg-white text-slate-900 rounded-full flex items-center justify-center hover:bg-rose-500 hover:text-white transition-all shadow-lg cursor-pointer relative z-[3]">
                    <i class="fas fa-heart text-lg"></i>
                </button>
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="relative z-[3]">
                    @csrf
                    <button type="submit" class="w-12 h-12 bg-white text-slate-900 rounded-full flex items-center justify-center hover:bg-primary hover:text-white transition-all shadow-lg cursor-pointer">
                        <i class="fas fa-shopping-cart text-lg"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- Content Area -->
        <div class="p-6 flex flex-col flex-1">
            <h3 class="text-lg font-bold text-slate-900 mb-1 group-hover:text-primary transition-colors uppercase tracking-tight line-clamp-1">
                {{ $product->name }}
            </h3>
            
            <!-- Rating -->
            <div class="flex items-center mb-3">
                <div class="flex text-yellow-400 text-xs">
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
                <span class="text-[10px] text-gray-400 font-bold ml-2">({{ number_format($rating, 1) }})</span>
            </div>
            
            <!-- Price and Stock -->
            <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-50">
                <div class="flex flex-col">
                    <span class="text-sm text-slate-400 font-medium lowercase tracking-wider">price start from</span>
                    <span class="text-2xl font-black text-slate-900">${{ number_format($product->base_price, 2) }}</span>
                </div>
                @if($product->stock_quantity > 0)
                <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-3 py-1.5 rounded-full uppercase tracking-widest">
                    In Stock
                </span>
                @else
                <span class="text-xs font-bold text-rose-600 bg-rose-50 px-3 py-1.5 rounded-full uppercase tracking-widest">
                    Out of Stock
                </span>
                @endif
            </div>

            <!-- Colors & Sizes Preview -->
            <div class="mt-4 flex items-center gap-4">
                @if($product->colors->count() > 0)
                <div class="flex -space-x-2">
                    @foreach($product->colors->take(3) as $color)
                    <div class="w-5 h-5 rounded-full border-2 border-white shadow-sm" style="background-color: {{ $color->color_code }}"></div>
                    @endforeach
                    @if($product->colors->count() > 3)
                    <div class="w-5 h-5 rounded-full border-2 border-white bg-slate-100 flex items-center justify-center text-[8px] font-bold text-slate-500">
                        +{{ $product->colors->count() - 3 }}
                    </div>
                    @endif
                </div>
                @endif

                @if($product->sizes->count() > 0)
                <div class="flex gap-1">
                    @foreach($product->sizes->take(2) as $size)
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">{{ $size->size_name }}</span>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
