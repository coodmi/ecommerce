@extends('layouts.app')

@section('title', 'Contact Us - Ecom Alpha')

@section('content')
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
<style>
    @keyframes slide-in-left {
        0% { transform: translateX(-100px); opacity: 0; }
        100% { transform: translateX(0); opacity: 1; }
    }
    @keyframes slide-in-right {
        0% { transform: translateX(100px); opacity: 0; }
        100% { transform: translateX(0); opacity: 1; }
    }
    .slide-in-left {
        animation: slide-in-left 0.8s ease-out;
    }
    .slide-in-right {
        animation: slide-in-right 0.8s ease-out;
    }
    @keyframes glow-pulse {
        0%, 100% { box-shadow: 0 0 20px rgba(147, 51, 234, 0.3); }
        50% { box-shadow: 0 0 40px rgba(236, 72, 153, 0.6); }
    }
    .glow-pulse {
        animation: glow-pulse 3s ease-in-out infinite;
    }
</style>

<!-- Fancy Hero Section -->
<section class="relative bg-linear-to-br from-primary to-primary/80 overflow-hidden py-16 md:py-20 min-h-[50vh]">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-primary/30 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
        <div class="absolute top-1/2 -right-40 w-96 h-96 bg-primary/50 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-40 left-1/2 w-96 h-96 bg-yellow-400 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob animation-delay-4000"></div>
    </div>

    <!-- Geometric Shapes -->
    <div class="absolute inset-0 overflow-hidden opacity-10">
        <div class="absolute top-20 right-1/4 w-20 h-20 border-4 border-white rounded-lg transform rotate-45 animate-spin-slow"></div>
        <div class="absolute bottom-32 left-1/3 w-16 h-16 border-4 border-white rounded-full animate-bounce-slow"></div>
        <div class="absolute top-1/3 left-1/4 w-12 h-12 bg-white rounded-full opacity-50 animate-pulse"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10 h-full flex items-center">
        <div class="max-w-4xl mx-auto text-center space-y-8 py-8">
            <!-- Badge -->
            <div class="inline-block">
                <div class="bg-white/20 backdrop-blur-md text-white px-4 py-1.5 rounded-full font-bold text-sm border border-white/30">
                    <i class="fas fa-headset mr-2"></i>{{ $heroContent['badge_text'] ?? 'GET IN TOUCH' }}
                </div>
            </div>

            <!-- Main Title -->
            <div class="space-y-4">
                <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-white font-display leading-tight">
                    {{ $heroContent['title_prefix'] ?? "Let's Start a" }}
                </h1>
                <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-yellow-300 font-display leading-tight">
                    {{ $heroContent['title_suffix'] ?? 'Conversation' }}
                </h2>
            </div>

            <div class="max-w-3xl mx-auto px-4">
                <p class="text-base md:text-lg text-purple-100 leading-relaxed">
                    {{ $heroContent['description'] ?? "We're here to help! Whether you have questions, feedback, or need support, our team is ready to assist you 24/7." }}
                </p>
            </div>
        </div>
    </div>

    <!-- Wave Bottom -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg class="w-full h-auto" viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 120L60 110C120 100 240 80 360 70C480 60 600 60 720 65C840 70 960 80 1080 85C1200 90 1320 90 1380 90L1440 90V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="white"/>
        </svg>
    </div>
</section>

<!-- Contact Form Section -->
<section class="py-12 bg-gradient-to-b from-white to-purple-50">
    <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-8">
                <!-- Left: Form -->
                <div class="slide-in-left">
                    <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8 h-full flex flex-col">
                        <div class="mb-6">
                            <div class="inline-block bg-linear-to-r from-primary to-primary/80 text-white px-3 py-1 rounded-full font-bold text-xs mb-3">
                                {{ $formAreaContent['badge'] ?? 'SEND MESSAGE' }}
                            </div>
                            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 font-display mb-3">
                                {{ $formAreaContent['title'] ?? 'Drop Us a Message' }}
                            </h2>
                            <p class="text-gray-600 text-sm">
                                {{ $formAreaContent['description'] ?? "Fill out the form below and we'll get back to you within 24 hours" }}
                            </p>
                        </div>

                        <div class="flex-1 flex flex-col">
                            @if(session('contact_success'))
                            <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
                                <i class="fas fa-check-circle text-green-500"></i> {{ session('contact_success') }}
                            </div>
                            @endif
                            <form method="POST" action="{{ route('contact.store') }}" class="space-y-4 flex-1 flex flex-col">
                                @csrf
                                <!-- Name -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Full Name <span class="text-red-500">*</span></label>
                                    <input type="text" name="name" value="{{ old('name') }}" placeholder="John Doe"
                                           class="w-full px-3 py-2.5 rounded-lg border-2 border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/10 outline-none transition-all text-sm" required>
                                </div>

                                <!-- Email -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Email Address <span class="text-red-500">*</span></label>
                                    <input type="email" name="email" value="{{ old('email') }}" placeholder="john@example.com"
                                           class="w-full px-3 py-2.5 rounded-lg border-2 border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/10 outline-none transition-all text-sm" required>
                                </div>

                                <!-- Phone -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Phone Number</label>
                                    <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="+880 1234-567890"
                                           class="w-full px-3 py-2.5 rounded-lg border-2 border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/10 outline-none transition-all text-sm">
                                </div>

                                <!-- Subject -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Subject <span class="text-red-500">*</span></label>
                                    <select name="subject" class="w-full px-3 py-2.5 rounded-lg border-2 border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/10 outline-none transition-all text-sm" required>
                                        <option value="">Select a subject</option>
                                        <option {{ old('subject') == 'General Inquiry' ? 'selected' : '' }}>General Inquiry</option>
                                        <option {{ old('subject') == 'Product Support' ? 'selected' : '' }}>Product Support</option>
                                        <option {{ old('subject') == 'Order Issue' ? 'selected' : '' }}>Order Issue</option>
                                        <option {{ old('subject') == 'Refund Request' ? 'selected' : '' }}>Refund Request</option>
                                        <option {{ old('subject') == 'Partnership' ? 'selected' : '' }}>Partnership</option>
                                        <option {{ old('subject') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>

                                <!-- Message -->
                                <div class="flex-1">
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Message <span class="text-red-500">*</span></label>
                                    <textarea name="message" placeholder="Tell us how we can help you..."
                                              class="w-full h-full min-h-[120px] px-3 py-2.5 rounded-lg border-2 border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/10 outline-none transition-all resize-none text-sm"
                                              required>{{ old('message') }}</textarea>
                                </div>

                                <div class="mt-auto pt-4">
                                    <!-- Submit Button -->
                                    <button type="submit"
                                            class="w-full bg-linear-to-r from-primary to-primary/80 text-white py-3 rounded-lg font-bold hover:shadow-lg transform hover:scale-105 transition-all">
                                        <i class="fas fa-paper-plane mr-2"></i>Send Message
                                    </button>

                                    <p class="text-xs text-gray-500 text-center mt-3">
                                        We respect your privacy and will never share your information
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Right: Additional Info -->
                <div class="slide-in-right">
                    <div class="h-full flex flex-col space-y-6">
                    <!-- FAQ Quick Links -->
                    <div class="bg-linear-to-br from-purple-50 to-pink-50 rounded-2xl p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="bg-linear-to-r from-primary to-primary/80 w-10 h-10 rounded-xl flex items-center justify-center">
                                <i class="fas fa-question-circle text-lg text-white"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">{{ $sidebarContent['faq_title'] ?? 'Quick Answers' }}</h3>
                        </div>
                        <p class="text-gray-600 mb-4 text-sm">
                            {{ $sidebarContent['faq_desc'] ?? 'Looking for quick answers? Check out our FAQ section for instant help.' }}
                        </p>
                        <a href="{{ $sidebarContent['faq_link_url'] ?? '#' }}" class="inline-flex items-center gap-2 text-primary font-bold hover:gap-3 transition-all text-sm">
                            {{ $sidebarContent['faq_link_text'] ?? 'Visit FAQ Center' }} <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>

                    <!-- Office Hours -->
                    <div class="bg-white rounded-2xl shadow-lg p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="bg-linear-to-br from-blue-100 to-blue-200 w-10 h-10 rounded-xl flex items-center justify-center">
                                <i class="fas fa-clock text-lg text-blue-600"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">{{ $sidebarContent['hours_title'] ?? 'Office Hours' }}</h3>
                        </div>
                        <div class="space-y-3">
                            @php
                            $hours = $sidebarContent['hours'] ?? [
                                ['day' => 'Monday - Friday', 'time' => '9:00 AM - 6:00 PM'],
                                ['day' => 'Saturday', 'time' => '10:00 AM - 4:00 PM'],
                                ['day' => 'Sunday', 'time' => 'Closed'],
                            ];
                            @endphp
                            @foreach($hours as $hour)
                            <div class="flex justify-between items-center pb-2 border-b border-gray-200 last:border-b-0">
                                <span class="text-gray-700 font-medium text-sm">{{ $hour['day'] }}</span>
                                <span class="{{ ($hour['is_closed'] ?? false) || $hour['time'] == 'Closed' ? 'text-red-600' : 'text-gray-900' }} font-bold text-sm">
                                    {{ $hour['time'] }}
                                </span>
                            </div>
                            @endforeach
                        </div>
                        <div class="mt-4 p-3 bg-purple-50 rounded-lg">
                            <p class="text-xs text-gray-700">
                                <i class="fas fa-info-circle text-purple-600 mr-1"></i>
                                {{ $sidebarContent['hours_note'] ?? 'Email support is available 24/7, even outside office hours' }}
                            </p>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div class="bg-linear-to-r from-primary to-primary/80 rounded-2xl p-6 text-white">
                        <h3 class="text-xl font-bold mb-3">{{ $sidebarContent['social_title'] ?? 'Follow Us' }}</h3>
                        <p class="text-purple-100 mb-4 text-sm">
                            {{ $sidebarContent['social_desc'] ?? 'Stay connected and get the latest updates on our social channels' }}
                        </p>
                        <div class="flex flex-wrap gap-3">
                            @php
                            $socials = $sidebarContent['socials'] ?? [
                                ['icon' => 'fab fa-facebook-f', 'name' => 'Facebook', 'url' => '#'],
                                ['icon' => 'fab fa-twitter', 'name' => 'Twitter', 'url' => '#'],
                                ['icon' => 'fab fa-instagram', 'name' => 'Instagram', 'url' => '#'],
                                ['icon' => 'fab fa-linkedin-in', 'name' => 'LinkedIn', 'url' => '#'],
                                ['icon' => 'fab fa-youtube', 'name' => 'YouTube', 'url' => '#'],
                            ];
                            @endphp

                            @foreach($socials as $social)
                            <a href="{{ $social['url'] }}" class="bg-white/20 backdrop-blur-sm hover:bg-white hover:text-primary w-10 h-10 rounded-lg flex items-center justify-center transition-all transform hover:scale-110" title="{{ $social['name'] ?? '' }}">
                                <i class="{{ $social['icon'] }} text-sm"></i>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section id="map" class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <div class="inline-block bg-linear-to-r from-primary to-primary/80 text-white px-6 py-2 rounded-full font-bold text-sm mb-4">
                <i class="fas fa-map-marked-alt mr-2"></i>{{ $mapContent['badge'] ?? 'FIND US' }}
            </div>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 font-display mb-4">
                {{ $mapContent['title'] ?? 'Visit Our Office' }}
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                {{ $mapContent['description'] ?? 'Drop by our headquarters for an in-person meeting with our team' }}
            </p>
        </div>

        <div class="max-w-6xl mx-auto">
            <div class="bg-linear-to-br from-purple-100 via-pink-100 to-purple-200 rounded-3xl overflow-hidden shadow-2xl">
                @if(!empty($mapContent['embed_html']))
                <div class="w-full relative overflow-hidden" style="min-height: 450px;">
                    <style>
                        .map-embed-container iframe {
                            width: 100% !important;
                            height: 100% !important;
                            position: absolute;
                            top: 0;
                            left: 0;
                            border: 0 !important;
                        }
                    </style>
                    <div class="map-embed-container w-full h-full absolute inset-0">
                        {!! $mapContent['embed_html'] !!}
                    </div>
                </div>
                @elseif(!empty($mapContent['image']))
                <div class="relative group">
                    <img src="{{ asset('storage/' . $mapContent['image']) }}" alt="Our Location" class="w-full h-auto aspect-video object-cover transition-transform duration-700 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-8">
                        <p class="text-white font-medium flex items-center gap-2">
                            <i class="fas fa-map-marker-alt text-red-500"></i>
                            {{ $mapContent['address'] ?? 'Visit our office today!' }}
                        </p>
                    </div>
                </div>
                @else
                <div class="aspect-video flex items-center justify-center p-8">
                    <div class="text-center">
                        <i class="fas fa-map-marked-alt text-8xl text-primary mb-6"></i>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Interactive Map</h3>
                        <p class="text-gray-700 mb-6 max-w-md mx-auto">
                            {{ $mapContent['address'] ?? '123 Commerce Street, Gulshan, Dhaka 1212, Bangladesh' }}
                        </p>
                        <div class="flex flex-wrap gap-4 justify-center">
                            <a href="#" class="bg-linear-to-r from-primary to-primary/80 text-white px-6 py-3 rounded-xl font-bold hover:shadow-xl transform hover:scale-105 transition-all">
                                <i class="fas fa-directions mr-2"></i>Get Directions
                            </a>
                            <a href="#" class="bg-white text-primary px-6 py-3 rounded-xl font-bold hover:shadow-xl transform hover:scale-105 transition-all">
                                <i class="fas fa-street-view mr-2"></i>Street View
                            </a>
                        </div>
                    </div>
                </div>
                @endif
            </div>
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
        <div class="max-w-4xl mx-auto text-center space-y-6">
            <h2 class="text-3xl md:text-5xl font-bold text-white font-display">
                {{ $ctaContent['title'] ?? 'Still Have Questions?' }}
            </h2>
            <p class="text-xl text-purple-100">
                {{ $ctaContent['description'] ?? "Our support team is here to help you 24/7. Don't hesitate to reach out!" }}
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center pt-4">
                @if(isset($ctaContent['buttons']) && is_array($ctaContent['buttons']))
                    @foreach($ctaContent['buttons'] as $button)
                    <a href="{{ $button['url'] }}" class="{{ ($button['style'] ?? 'primary') === 'primary'
                        ? 'bg-white text-primary px-10 py-4 rounded-xl font-bold text-lg hover:shadow-2xl transform hover:scale-105 transition-all inline-flex items-center justify-center gap-2'
                        : 'bg-white/10 backdrop-blur-md text-white px-10 py-4 rounded-xl font-bold text-lg border-2 border-white/30 hover:bg-white/20 transition-all inline-flex items-center justify-center gap-2' }}">
                        @if(!empty($button['icon']))
                        <i class="{{ $button['icon'] }}"></i>
                        @endif
                        {{ $button['text'] }}
                    </a>
                    @endforeach
                @else
                    <a href="tel:+8801234567890" class="bg-white text-primary px-10 py-4 rounded-xl font-bold text-lg hover:shadow-2xl transform hover:scale-105 transition-all inline-flex items-center justify-center gap-2">
                        <i class="fas fa-phone-alt"></i>Call Now
                    </a>
                    <a href="mailto:support@ecomalpha.com" class="bg-white/10 backdrop-blur-md text-white px-10 py-4 rounded-xl font-bold text-lg border-2 border-white/30 hover:bg-white/20 transition-all inline-flex items-center justify-center gap-2">
                        <i class="fas fa-envelope"></i>Email Support
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
