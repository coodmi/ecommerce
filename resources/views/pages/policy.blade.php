@extends('layouts.app')

@section('title', $title . ' - ' . config('app.name'))

@section('content')

@php
    $hero = $sections['hero'] ?? [];
    $policySections = $sections['sections'] ?? [];
@endphp

<!-- Hero -->
<section class="relative text-white py-16 md:py-20 overflow-hidden" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-72 h-72 bg-primary rounded-full filter blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-72 h-72 bg-primary rounded-full filter blur-3xl"></div>
    </div>
    <div class="container mx-auto px-4 relative z-10 text-center">
        <h1 class="text-3xl md:text-5xl font-display font-bold mb-4">{{ $hero['title'] ?? $title }}</h1>
        <p class="text-gray-400 text-sm md:text-base max-w-xl mx-auto">{{ $hero['subtitle'] ?? '' }}</p>
        <p class="text-gray-500 text-xs mt-3">Last updated: {{ date('F d, Y') }}</p>
        <nav class="mt-4 text-sm text-gray-400">
            <a href="/" class="hover:text-white transition">Home</a>
            <span class="mx-2">/</span>
            <span class="text-white">{{ $title }}</span>
        </nav>
    </div>
</section>

<!-- Content -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl shadow-sm p-8 md:p-12">

                @php
                    $icons = [
                        'privacy-policy'   => 'fa-shield-alt',
                        'terms-conditions' => 'fa-file-contract',
                        'refund-policy'    => 'fa-undo-alt',
                    ];
                    $icon = $icons[$slug] ?? 'fa-file-alt';
                @endphp

                <!-- Header -->
                <div class="flex items-center gap-3 mb-8 pb-6 border-b border-gray-100">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center flex-shrink-0" style="background: var(--primary-color)20">
                        <i class="fas {{ $icon }} text-xl" style="color: var(--primary-color)"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">{{ $hero['title'] ?? $title }}</h2>
                        <p class="text-gray-500 text-sm">{{ $hero['subtitle'] ?? '' }}</p>
                    </div>
                </div>

                <!-- Sections -->
                <div class="space-y-8">
                    @foreach($policySections as $index => $section)
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2 mb-3">
                            <span class="w-7 h-7 rounded-full text-white text-xs flex items-center justify-center flex-shrink-0" style="background: var(--primary-color)">{{ $index + 1 }}</span>
                            {{ $section['title'] ?? '' }}
                        </h3>
                        <p class="text-gray-600 leading-relaxed">{{ $section['body'] ?? '' }}</p>
                    </div>
                    @endforeach
                </div>

            </div>

            <!-- Other Policies -->
            <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-4">
                @if($slug !== 'privacy-policy')
                <a href="{{ route('privacy-policy') }}" class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 hover:border-primary hover:shadow-md transition group">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center group-hover:bg-primary transition">
                            <i class="fas fa-shield-alt text-primary group-hover:text-white transition"></i>
                        </div>
                        <span class="font-medium text-gray-800 group-hover:text-primary transition">Privacy Policy</span>
                    </div>
                </a>
                @endif
                @if($slug !== 'terms-conditions')
                <a href="{{ route('terms-conditions') }}" class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 hover:border-primary hover:shadow-md transition group">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center group-hover:bg-primary transition">
                            <i class="fas fa-file-contract text-primary group-hover:text-white transition"></i>
                        </div>
                        <span class="font-medium text-gray-800 group-hover:text-primary transition">Terms & Conditions</span>
                    </div>
                </a>
                @endif
                @if($slug !== 'refund-policy')
                <a href="{{ route('refund-policy') }}" class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 hover:border-primary hover:shadow-md transition group">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center group-hover:bg-primary transition">
                            <i class="fas fa-undo-alt text-primary group-hover:text-white transition"></i>
                        </div>
                        <span class="font-medium text-gray-800 group-hover:text-primary transition">Refund Policy</span>
                    </div>
                </a>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection
