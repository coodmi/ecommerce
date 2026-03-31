@extends('layouts.app')

@section('title', 'Categories - Ecom Alpha')

@section('content')

<!-- Fancy Hero Section -->
<section class="relative bg-linear-to-br from-primary via-primary/80 to-primary/60 text-white overflow-hidden">
    <!-- Animated Background Patterns -->
    <div class="absolute inset-0">
        <div class="absolute top-20 left-10 w-72 h-72 bg-primary/50 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
        <div class="absolute top-40 right-20 w-72 h-72 bg-primary/30 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-20 left-1/3 w-72 h-72 bg-primary/40 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-4000"></div>
    </div>

    <!-- Geometric Shapes -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-1/4 right-1/4 w-64 h-64 border-4 border-white/10 rounded-full animate-spin-slow"></div>
        <div class="absolute bottom-1/4 left-1/4 w-48 h-48 border-4 border-pink-300/10 rotate-45 animate-pulse"></div>
    </div>

    <div class="container mx-auto px-4 py-8 md:py-12 relative z-10 text-center">
        <div class="max-w-3xl mx-auto space-y-6">
            <!-- Breadcrumb -->
            <nav class="flex items-center justify-center space-x-2 text-sm mb-4">
                <a href="/" class="hover:text-yellow-300 transition flex items-center bg-white/10 backdrop-blur-sm px-3 py-1.5 rounded-full">
                    <i class="fas fa-home mr-1"></i> Home
                </a>
                <i class="fas fa-chevron-right text-xs"></i>
                <span class="bg-white/20 backdrop-blur-sm px-3 py-1.5 rounded-full">Categories</span>
            </nav>

            <!-- Badge -->
            <div class="inline-flex items-center space-x-2 bg-linear-to-r from-yellow-400 to-orange-500 text-purple-900 px-4 py-2 rounded-full font-semibold text-sm shadow-lg mb-3">
                <i class="fas fa-star"></i>
                <span>{{ $heroContent['badge_text'] ?? '1000+ Premium Products' }}</span>
            </div>

            <!-- Heading -->
            <div>
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-display font-bold leading-tight mb-4">
                    {{ $heroContent['title_prefix'] ?? 'Explore Our' }}
                    <span class="block mt-1 bg-linear-to-r from-yellow-300 via-pink-300 to-purple-300 bg-clip-text text-transparent">
                        {{ $heroContent['title_suffix'] ?? 'Amazing Categories' }}
                    </span>
                </h1>
                <p class="text-lg text-gray-100 leading-relaxed max-w-xl mx-auto">
                    {{ $heroContent['description'] ?? 'Discover thousands of quality products across multiple categories. Find exactly what you\'re looking for with ease.' }}
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-center gap-4">
                <a href="{{ route('shop') }}" class="group bg-white text-primary px-8 py-3 rounded-xl font-bold hover:bg-yellow-300 transition duration-300 shadow-2xl hover:shadow-yellow-300/50 hover:scale-105 transform flex items-center">
                    <i class="fas fa-shopping-bag mr-2"></i>
                    {{ $heroContent['button_text'] ?? 'Start Shopping' }}
                    <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Decorative Wave at Bottom -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full">
            <path d="M0 120L60 110C120 100 240 80 360 70C480 60 600 60 720 65C840 70 960 80 1080 85C1200 90 1320 90 1380 90L1440 90V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="#F9FAFB"/>
        </svg>
    </div>

    <style>
        @keyframes blob {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(30px, -50px) scale(1.1); }
            50% { transform: translate(-30px, 30px) scale(0.9); }
            75% { transform: translate(50px, 40px) scale(1.05); }
        }
        .animate-blob {
            animation: blob 8s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .animate-spin-slow {
            animation: spin-slow 20s linear infinite;
        }
        @keyframes bounce-slow {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }
        .animate-bounce-slow {
            animation: bounce-slow 3s ease-in-out infinite;
        }
    </style>
</section>

<!-- Main Categories Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-display font-bold text-gray-900 mb-4">Popular Categories</h2>
            <p class="text-gray-600 text-lg">Find what you're looking for in our top categories</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($popularCategories as $category)
            <a href="{{ route('shop', ['categories[]' => $category->id]) }}" class="group cursor-pointer">
                <div class="bg-white rounded-2xl shadow-md hover:shadow-2xl transition duration-300 overflow-hidden">
                    <div class="relative h-64 overflow-hidden">
                        <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-6">
                            <h3 class="text-2xl font-display font-bold text-white mb-2">{{ $category->name }}</h3>
                            <p class="text-gray-200 text-sm mb-3">{{ Str::limit($category->description, 50) }}</p>
                            <div class="flex items-center justify-between">
                                <span class="text-white text-sm bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full">{{ $category->products_count }} Products</span>
                                <span class="bg-white text-primary px-4 py-2 rounded-lg font-semibold text-sm hover:bg-gray-100 transition">
                                    Browse <i class="fas fa-arrow-right ml-1"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

<section class="py-16 bg-white" x-data="{
    scrollLeft() {
        const container = $refs.carousel;
        if (!container.firstElementChild) return;
        const itemWidth = container.firstElementChild.offsetWidth;
        const gap = 24; // gap-6 is 1.5rem aka 24px
        const scrollAmount = (itemWidth + gap) * 3;
        container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
    },
    scrollRight() {
        const container = $refs.carousel;
        if (!container.firstElementChild) return;
        const itemWidth = container.firstElementChild.offsetWidth;
        const gap = 24; // gap-6 is 1.5rem aka 24px
        const scrollAmount = (itemWidth + gap) * 3;
        container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    }
}">
    <div class="container mx-auto px-4 relative group">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-display font-bold text-gray-900 mb-4">All Categories</h2>
            <p class="text-gray-600 text-lg">Browse through our complete collection</p>
        </div>

        <!-- Carousel Container -->
        <div class="relative px-4">
            <!-- Prev Button -->
            <button @click="scrollLeft()"
                    class="absolute left-0 top-1/2 -translate-y-1/2 z-10 w-12 h-12 bg-white border border-gray-100 rounded-full shadow-lg text-primary flex items-center justify-center hover:bg-primary/5 transition-all duration-300 opacity-0 group-hover:opacity-100 disabled:opacity-0 transform hover:scale-110">
                <i class="fas fa-chevron-left text-lg"></i>
            </button>

            <!-- Next Button -->
            <button @click="scrollRight()"
                    class="absolute right-0 top-1/2 -translate-y-1/2 z-10 w-12 h-12 bg-white border border-gray-100 rounded-full shadow-lg text-primary flex items-center justify-center hover:bg-primary/5 transition-all duration-300 opacity-0 group-hover:opacity-100 transform hover:scale-110">
                <i class="fas fa-chevron-right text-lg"></i>
            </button>

            <!-- Items -->
            <div x-ref="carousel"
                 class="flex gap-6 overflow-x-auto snap-x snap-mandatory scroll-smooth pb-8 hide-scrollbar px-1">
                @foreach($categories as $category)
                <a href="{{ route('shop', ['categories[]' => $category->id]) }}"
                   class="flex-none w-[calc(50%-12px)] md:w-[calc(33.333%-16px)] lg:w-[calc(25%-18px)] xl:w-[calc(16.666%-20px)] snap-start group/card cursor-pointer">
                    <div class="bg-linear-to-br from-primary/5 to-primary/10 rounded-2xl p-6 hover:shadow-xl transition duration-300 text-center h-full w-full border border-primary/10">
                        <div class="w-20 h-20 mx-auto bg-linear-to-br from-primary/10 to-primary/20 rounded-full flex items-center justify-center mb-4 group-hover/card:scale-110 transition duration-300 shadow-sm">
                            <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="w-12 h-12 object-cover rounded-full">
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-1 group-hover/card:text-primary transition-colors">{{ $category->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $category->products_count }} items</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>

    <style>
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</section>

<!-- Featured Brands Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-display font-bold text-gray-900 mb-4">Shop by Brand</h2>
            <p class="text-gray-600 text-lg">Discover products from your favorite brands</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
            @foreach($brands as $brand)
            <a href="{{ route('shop', ['brands[]' => $brand->id]) }}" class="bg-white rounded-2xl p-8 shadow-md hover:shadow-xl transition duration-300 flex items-center justify-center cursor-pointer group">
                <div class="text-center w-full">
                    <div class="w-16 h-16 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-3 group-hover:bg-primary/10 transition overflow-hidden">
                        @if($brand->logo)
                            <img src="{{ $brand->logo_url }}" alt="{{ $brand->name }}" class="w-10 h-10 object-contain">
                        @else
                            <span class="text-2xl font-bold text-gray-400">{{ substr($brand->name, 0, 1) }}</span>
                        @endif
                    </div>
                    <h4 class="font-semibold text-gray-800 truncate px-2">{{ $brand->name }}</h4>
                    <p class="text-xs text-gray-500 mt-1">{{ $brand->products_count }} items</p>
                </div>
            </a>
            @endforeach
        </div>

        @if($brands->isEmpty())
        <div class="text-center py-12">
            <div class="bg-gray-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-tags text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900">No Brands Found</h3>
            <p class="text-gray-500 mt-2">Check back later for our brand collection.</p>
        </div>
        @endif

        <div class="text-center mt-12">
            <a href="{{ route('shop') }}" class="inline-block bg-linear-to-r from-primary to-primary/80 text-white px-10 py-4 rounded-lg font-semibold hover:shadow-xl transition duration-300 hover:scale-105 transform">
                View All Brands <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- Shop Now CTA -->
<section class="py-20 bg-linear-to-r from-primary to-primary/80 text-white relative overflow-hidden">
    <!-- Decorative Elements -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden opacity-20 pointer-events-none">
        <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl transform -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-yellow-400 rounded-full mix-blend-overlay filter blur-3xl transform translate-x-1/2 translate-y-1/2"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-4xl md:text-5xl font-display font-bold mb-6 leading-tight">
                {{ $bannerContent['title'] ?? 'Ready to Upgrade Your Lifestyle?' }}
            </h2>
            <p class="text-xl text-white/90 mb-10 leading-relaxed max-w-2xl mx-auto">
                {{ $bannerContent['description'] ?? 'Discover a world of premium products curated just for you. From trending fashion to cutting-edge electronics, find everything you love in one place.' }}
            </p>
            <div class="flex justify-center">
                <a href="{{ route('shop') }}" class="group bg-white text-primary px-12 py-5 rounded-2xl font-bold text-lg hover:bg-yellow-300 hover:text-primary transition-all duration-300 shadow-2xl hover:shadow-yellow-300/30 transform hover:-translate-y-1 flex items-center">
                    <i class="fas fa-shopping-cart mr-3"></i>
                    {{ $bannerContent['button_text'] ?? 'Shop Now' }}
                    <i class="fas fa-arrow-right ml-3 group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
