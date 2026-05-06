@extends('layouts.app')

@section('title', 'About Us - Ecom Alpha')

@section('content')
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
<style>
    @keyframes float-up {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }
    .float-up {
        animation: float-up 4s ease-in-out infinite;
    }
    @keyframes pulse-glow {
        0%, 100% { box-shadow: 0 0 20px rgba(147, 51, 234, 0.5); }
        50% { box-shadow: 0 0 40px rgba(236, 72, 153, 0.8); }
    }
    .pulse-glow {
        animation: pulse-glow 2s ease-in-out infinite;
    }
</style>

<!-- Fancy Hero Section -->
<section class="relative bg-linear-to-br from-primary to-primary/80 overflow-hidden py-20 md:py-28 min-h-[60vh]">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-primary/30 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
        <div class="absolute top-1/2 right-1/4 w-96 h-96 bg-primary/50 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-0 left-1/2 w-96 h-96 bg-yellow-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob animation-delay-4000"></div>
    </div>

    <!-- Geometric Shapes -->
    <div class="absolute inset-0 overflow-hidden opacity-10">
        <div class="absolute top-32 left-20 w-24 h-24 border-4 border-white rounded-lg transform rotate-45 animate-spin-slow"></div>
        <div class="absolute bottom-40 right-32 w-20 h-20 border-4 border-white rounded-full animate-bounce-slow"></div>
        <div class="absolute top-1/2 left-1/3 w-16 h-16 bg-white rounded-full opacity-50 animate-pulse"></div>
        <div class="absolute bottom-1/3 left-1/4 w-14 h-14 border-4 border-white transform rotate-12"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10 h-full flex items-center">
        <div class="max-w-5xl mx-auto text-center space-y-8 py-8">
            <!-- Badge -->
            <div class="inline-block">
                <div class="bg-white/20 backdrop-blur-md text-white px-6 py-2 rounded-full font-bold text-sm border border-white/30">
                    <i class="fas fa-users mr-2"></i>{{ $heroContent['badge_text'] ?? 'Our Story' }}
                </div>
            </div>

            <!-- Main Title -->
            <div class="space-y-4">
                <h1 class="text-2xl md:text-3xl font-bold text-white font-display leading-tight">
                    {{ $heroContent['title'] ?? 'About Our Company' }}
                </h1>
                <h2 class="text-xl md:text-2xl font-bold text-yellow-300 font-display leading-tight">
                    {{ $heroContent['subtitle'] ?? 'Building Excellence Since Day One' }}
                </h2>
            </div>

            <div class="max-w-4xl mx-auto">
                <p class="text-sm md:text-base text-purple-100 leading-relaxed px-4">
                    {{ $heroContent['description'] ?? 'We are dedicated to providing the best products and services to our customers. Our journey started with a simple vision: to make quality accessible to everyone.' }}
                </p>
            </div>
        </div>
    </div>

    <!-- Wave Decoration -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg class="w-full h-auto" viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 120L60 110C120 100 240 80 360 70C480 60 600 60 720 65C840 70 960 80 1080 85C1200 90 1320 90 1380 90L1440 90V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="white"/>
        </svg>
    </div>
</section>

<!-- Stats Section -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            @php
            $displayStats = $statsContent['stats'] ?? [
                ['icon' => 'fa-users', 'number' => '2M+', 'label' => 'Happy Customers'],
                ['icon' => 'fa-box', 'number' => '50K+', 'label' => 'Products'],
                ['icon' => 'fa-globe', 'number' => '100+', 'label' => 'Countries'],
                ['icon' => 'fa-award', 'number' => '15+', 'label' => 'Years Experience'],
            ];
            $colors = ['purple', 'pink', 'indigo', 'rose']; // Cycle through these colors
            @endphp

            @foreach($displayStats as $index => $stat)
            @php $color = $colors[$index % count($colors)]; @endphp
            <div class="text-center group">
                <div class="bg-linear-to-br from-{{ $color }}-100 to-{{ $color }}-200 w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:shadow-xl transform group-hover:-translate-y-2 transition-all duration-300">
                    <i class="fas {{ $stat['icon'] ?? 'fa-chart-bar' }} text-3xl text-{{ $color }}-600"></i>
                </div>
                <div class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">{{ $stat['number'] ?? $stat['count'] ?? '0' }}</div>
                <div class="text-gray-600 font-medium">{{ $stat['label'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Our Story Section -->
<section class="py-16 bg-gradient-to-b from-white to-purple-50">
    <div class="container mx-auto px-4">
        <div class="grid md:grid-cols-2 gap-12 items-center max-w-6xl mx-auto">
            <!-- Content -->
            <div class="space-y-6">
                <div class="inline-block bg-linear-to-r from-primary to-primary/80 text-white px-4 py-1 rounded-full font-bold text-sm">
                    OUR STORY
                </div>
                <h2 class="text-xl md:text-2xl font-bold text-gray-900 font-display">
                    {{ $storyContent['title'] ?? 'Building the Future of' }}
                    <span class="text-primary">{{ $storyContent['subtitle'] ?? 'E-Commerce' }}</span>
                </h2>
                <p class="text-gray-600 leading-relaxed text-sm">
                    {{ $storyContent['content'] ?? 'Founded in 2010, Ecom Alpha started with a simple mission: to make online shopping accessible, enjoyable, and trustworthy for everyone. What began as a small startup has grown into a global marketplace serving millions of customers worldwide.' }}
                </p>
                <div class="flex flex-wrap gap-4 pt-4">
                    @php
                    $displayFeatures = $storyContent['features'] ?? [
                        ['icon' => 'fa-check-circle', 'title' => 'Quality Assured'],
                        ['icon' => 'fa-check-circle', 'title' => 'Fast Delivery'],
                        ['icon' => 'fa-check-circle', 'title' => '24/7 Support'],
                    ];
                    @endphp
                    @foreach($displayFeatures as $feature)
                    <div class="flex items-center gap-2">
                        <i class="fas {{ $feature['icon'] ?? 'fa-check-circle' }} text-green-500 text-xl"></i>
                        <span class="text-gray-700 font-medium">{{ $feature['title'] ?? $feature['description'] ?? '' }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Image Placeholder -->
            <div class="relative">
                <div class="bg-linear-to-br from-purple-200 via-pink-200 to-purple-300 rounded-3xl p-12 relative overflow-hidden pulse-glow">
                    <div class="relative z-10 flex items-center justify-center h-full">
                        <i class="fas fa-store text-9xl text-primary float-up"></i>
                    </div>
                    <!-- Decorative circles -->
                    <div class="absolute top-10 right-10 w-24 h-24 bg-white/30 rounded-full"></div>
                    <div class="absolute bottom-10 left-10 w-32 h-32 bg-white/20 rounded-full"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Core Values Section -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <div class="inline-block bg-linear-to-r from-primary to-primary/80 text-white px-6 py-2 rounded-full font-bold text-sm mb-4">
                <i class="fas fa-heart mr-2"></i>OUR VALUES
            </div>
            <h2 class="text-xl md:text-2xl font-bold text-gray-900 font-display mb-3">
                {{ $valuesContent['title'] ?? 'What Drives Us Forward' }}
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                {{ $valuesContent['subtitle'] ?? 'Our core values shape everything we do and guide our commitment to excellence' }}
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 max-w-7xl mx-auto">
            @php
            $displayValues = $valuesContent['values'] ?? [
                [
                    'icon' => 'fa-shield-alt',
                    'title' => 'Trust & Security',
                    'description' => 'Your data and transactions are protected with industry-leading security measures.',
                ],
                [
                    'icon' => 'fa-gem',
                    'title' => 'Quality First',
                    'description' => 'We partner only with verified sellers to ensure authentic, high-quality products.',
                ],
                [
                    'icon' => 'fa-rocket',
                    'title' => 'Innovation',
                    'description' => 'Constantly evolving with cutting-edge technology to enhance your experience.',
                ],
                [
                    'icon' => 'fa-smile',
                    'title' => 'Customer First',
                    'description' => 'Your satisfaction is our priority. We go the extra mile to make you happy.',
                ],
            ];
            $colors = ['blue', 'purple', 'pink', 'green'];
            @endphp

            @foreach($displayValues as $index => $value)
            @php $color = $colors[$index % count($colors)]; @endphp
            <div class="group bg-white rounded-2xl p-8 shadow-md hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 border border-gray-100">
                <div class="bg-linear-to-br from-{{ $color }}-100 to-{{ $color }}-200 w-16 h-16 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <i class="fas {{ $value['icon'] ?? 'fa-heart' }} text-3xl text-{{ $color }}-600"></i>
                </div>
                <h3 class="text-base font-bold text-gray-900 mb-2">{{ $value['title'] }}</h3>
                <p class="text-gray-600 leading-relaxed">{{ $value['description'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <div class="inline-block bg-linear-to-r from-primary to-primary/80 text-white px-6 py-2 rounded-full font-bold text-sm mb-4">
                <i class="fas fa-star mr-2"></i>WHY CHOOSE US
            </div>
            <h2 class="text-xl md:text-2xl font-bold text-gray-900 font-display mb-3">
                {{ $whyChooseUsContent['title'] ?? 'The Ecom Alpha Advantage' }}
            </h2>
            @if(!empty($whyChooseUsContent['subtitle']))
            <p class="text-gray-600 max-w-2xl mx-auto">
                {{ $whyChooseUsContent['subtitle'] }}
            </p>
            @endif
        </div>

        <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            @php
            $displayReasons = $whyChooseUsContent['reasons'] ?? [
                [
                    'icon' => 'fa-shipping-fast',
                    'title' => 'Fast & Free Shipping',
                    'description' => 'Free shipping on orders over ৳500. Express delivery available.',
                ],
                [
                    'icon' => 'fa-undo',
                    'title' => 'Easy Returns',
                    'description' => '30-day hassle-free returns. No questions asked guarantee.',
                ],
                [
                    'icon' => 'fa-tags',
                    'title' => 'Best Prices',
                    'description' => 'Price match guarantee and exclusive deals for members.',
                ],
            ];
            @endphp

            @foreach($displayReasons as $reason)
            <div class="bg-linear-to-br from-purple-50 to-pink-50 rounded-2xl p-8 hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300">
                <div class="bg-linear-to-r from-primary to-primary/80 w-16 h-16 rounded-2xl flex items-center justify-center mb-6">
                    <i class="fas {{ $reason['icon'] ?? 'fa-check' }} text-3xl text-white"></i>
                </div>
                <h3 class="text-base font-bold text-gray-900 mb-2">{{ $reason['title'] }}</h3>
                <p class="text-gray-600 mb-6">{{ $reason['description'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-linear-to-r from-primary via-primary/90 to-primary/80 relative overflow-hidden">
    <!-- Background Animation -->
    <div class="absolute inset-0 overflow-hidden opacity-20">
        <div class="absolute top-10 left-10 w-64 h-64 bg-white rounded-full filter blur-3xl animate-blob"></div>
        <div class="absolute bottom-10 right-10 w-64 h-64 bg-yellow-300 rounded-full filter blur-3xl animate-blob animation-delay-2000"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto text-center space-y-8">
            <h2 class="text-xl md:text-2xl font-bold text-white font-display">
                {{ $ctaContent['title'] ?? 'Ready to Start Your Shopping Journey?' }}
            </h2>
            <p class="text-sm text-purple-100">
                {{ $ctaContent['description'] ?? 'Join millions of satisfied customers and discover amazing products at unbeatable prices' }}
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @if(isset($ctaContent['buttons']) && is_array($ctaContent['buttons']))
                    @foreach($ctaContent['buttons'] as $button)
                        <a href="{{ $button['url'] }}" class="{{ $button['style'] === 'primary'
                            ? 'bg-white text-primary px-10 py-4 rounded-xl font-bold text-lg hover:shadow-2xl transform hover:scale-105 transition-all inline-block'
                            : 'bg-white/10 backdrop-blur-md text-white px-10 py-4 rounded-xl font-bold text-lg border-2 border-white/30 hover:bg-white/20 transition-all inline-block' }}">
                            @if($button['style'] === 'primary')
                                <i class="fas fa-shopping-bag mr-2"></i>
                            @else
                                <i class="fas fa-fire mr-2"></i>
                            @endif
                            {{ $button['text'] }}
                        </a>
                    @endforeach
                @else
                    <a href="/shop" class="bg-white text-primary px-10 py-4 rounded-xl font-bold text-lg hover:shadow-2xl transform hover:scale-105 transition-all inline-block">
                        <i class="fas fa-shopping-bag mr-2"></i>Browse Products
                    </a>
                    <a href="/deals" class="bg-white/10 backdrop-blur-md text-white px-10 py-4 rounded-xl font-bold text-lg border-2 border-white/30 hover:bg-white/20 transition-all inline-block">
                        <i class="fas fa-fire mr-2"></i>View Hot Deals
                    </a>
                @endif
            </div>

            <!-- Trust Badges -->
            <div class="flex flex-wrap justify-center gap-8 pt-8">
                <div class="flex items-center gap-2 text-white">
                    <i class="fas fa-lock text-2xl"></i>
                    <span class="font-medium">Secure Payment</span>
                </div>
                <div class="flex items-center gap-2 text-white">
                    <i class="fas fa-shield-alt text-2xl"></i>
                    <span class="font-medium">Buyer Protection</span>
                </div>
                <div class="flex items-center gap-2 text-white">
                    <i class="fas fa-award text-2xl"></i>
                    <span class="font-medium">Verified Sellers</span>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
