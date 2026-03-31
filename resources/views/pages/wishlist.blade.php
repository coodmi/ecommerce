@extends('layouts.app')

@section('title', 'My Wishlist - Ecom Alpha')

@section('content')
<!-- Breadcrumb -->
<section class="bg-linear-to-r from-primary to-primary/80 text-white py-12">
    <div class="container mx-auto px-4">
        <nav class="flex items-center space-x-2 text-sm mb-4">
            <a href="/" class="hover:text-gray-200 transition">
                <i class="fas fa-home"></i> Home
            </a>
            <i class="fas fa-chevron-right text-xs"></i>
            <span class="text-gray-200">My Wishlist</span>
        </nav>
        <h1 class="text-4xl md:text-5xl font-display font-bold">My Wishlist</h1>
        <p class="text-gray-100 mt-2">Products you've saved for later</p>
    </div>
</section>

<section class="py-16 bg-gray-50 min-h-[600px]">
    <div class="container mx-auto px-4">
        @if($wishlistItems->isEmpty())
        <div class="max-w-md mx-auto text-center bg-white p-12 rounded-[2rem] shadow-sm border border-gray-100">
            <div class="w-24 h-24 bg-rose-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-heart text-rose-500 text-3xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-slate-900 mb-4 uppercase tracking-tight">Your wishlist is empty</h2>
            <p class="text-slate-500 mb-8 leading-relaxed">Seems like you haven't saved any items yet. Explore our shop and find something you love!</p>
            <a href="{{ route('shop') }}" class="inline-flex items-center justify-center px-10 py-4 bg-primary text-white font-black rounded-2xl shadow-xl shadow-primary/20 hover:bg-primary/90 transition-all active:scale-95 uppercase tracking-widest text-sm">
                Start Shopping
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
        @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @foreach($wishlistItems as $item)
            @php $product = $item->product; @endphp
            <div class="group relative bg-white rounded-3xl shadow-sm hover:shadow-2xl transition-all duration-500 overflow-hidden border border-gray-100 flex flex-col h-full">
                <!-- Image Area -->
                <div class="relative aspect-[4/5] overflow-hidden">
                    <img src="{{ $product->primaryImage ? $product->primaryImage->url : asset('images/placeholder-product.jpg') }}" 
                         alt="{{ $product->name }}" 
                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    
                    <!-- Action Overlay -->
                    <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition-all duration-500 flex items-center justify-center gap-3 translate-y-4 group-hover:translate-y-0 z-[2]">
                        <a href="{{ route('product.details', $product->slug) }}" class="w-12 h-12 bg-white text-slate-900 rounded-full flex items-center justify-center hover:bg-primary hover:text-white transition-all shadow-lg">
                            <i class="fas fa-eye text-lg"></i>
                        </a>
                        <button onclick="toggleWishlist({{ $product->id }})" class="w-12 h-12 bg-rose-500 text-white rounded-full flex items-center justify-center hover:bg-rose-600 transition-all shadow-lg">
                            <i class="fas fa-heart text-lg"></i>
                        </button>
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

                    <div class="mt-auto pt-4 border-t border-gray-50 flex items-center justify-between">
                        <span class="text-2xl font-black text-slate-900">${{ number_format($product->base_price, 2) }}</span>
                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-11 h-11 bg-slate-900 text-white rounded-xl flex items-center justify-center hover:bg-primary transition-all shadow-lg scale-90 hover:scale-100">
                                <i class="fas fa-shopping-cart text-sm"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="mt-12">
            {{ $wishlistItems->links() }}
        </div>
        @endif
    </div>
</section>
@endsection
