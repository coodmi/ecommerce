@extends('layouts.app')

@section('title', 'Sign In')

@section('content')
@php
    $loginBrand = \App\Models\Page::where('slug','header')->with('sections')->first();
    $loginBrandContent = $loginBrand ? ($loginBrand->sections->where('key','brand')->first()?->content ?? []) : [];
    $loginLogo = isset($loginBrandContent['logo']) ? asset('storage/' . $loginBrandContent['logo']) : asset('images/shankhobazar.png');
@endphp

{{-- MOBILE: centered card on gradient background --}}
<section class="sm:hidden flex items-center justify-center bg-gradient-to-br from-primary to-primary/80 px-4 py-8 min-h-[calc(100vh-72px)]">
    <div class="w-full max-w-sm">
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <div class="flex justify-center mb-6">
                <img src="{{ $loginLogo }}" alt="Logo" class="h-16 w-auto object-contain">
            </div>
            <h2 class="text-2xl font-bold text-gray-900 text-center mb-1">Sign In</h2>
            <p class="text-sm text-gray-400 text-center mb-6">Enter your credentials to continue</p>
            @if(session('error'))
            <div class="mb-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
            @endif
            <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none text-sm transition" required>
                    @error('email')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" placeholder="••••••••"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none text-sm transition" required>
                    @error('password')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-500">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-primary focus:ring-primary">
                    <span>Remember me</span>
                </div>
                <button type="submit" class="w-full bg-primary hover:bg-primary/90 text-white py-2.5 rounded-xl font-semibold text-sm transition shadow-sm">
                    Sign In
                </button>
            </form>
            <div class="mt-5 text-center space-y-3">
                <p class="text-sm text-gray-500">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-primary font-semibold hover:underline">Create one</a>
                </p>
                <a href="/" class="block text-sm text-gray-400 hover:text-gray-600 transition">
                    <i class="fas fa-arrow-left mr-1 text-xs"></i> Back to website
                </a>
            </div>
        </div>
    </div>
</section>

{{-- DESKTOP: modern split layout --}}
<section class="hidden sm:flex min-h-screen">

    {{-- Left: branding panel --}}
    <div class="hidden lg:flex w-1/2 bg-gradient-to-br from-primary to-primary/80 flex-col items-center justify-center px-16 text-white relative overflow-hidden">
        {{-- decorative circles --}}
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-white/10 rounded-full"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-white/10 rounded-full"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-white/5 rounded-full"></div>

        <div class="relative z-10 text-center">
            <img src="{{ $loginLogo }}" alt="Logo" class="h-20 w-auto object-contain mx-auto mb-8 brightness-0 invert">
            <h1 class="text-4xl font-bold mb-4 leading-tight">Welcome Back!</h1>
            <p class="text-white/80 text-lg max-w-sm leading-relaxed">Sign in to access your orders, wishlist, and exclusive deals.</p>

            <div class="mt-12 grid grid-cols-3 gap-6 text-center">
                <div class="bg-white/10 rounded-2xl p-4">
                    <i class="fas fa-shipping-fast text-2xl mb-2 block"></i>
                    <p class="text-xs font-semibold">Fast Delivery</p>
                </div>
                <div class="bg-white/10 rounded-2xl p-4">
                    <i class="fas fa-shield-alt text-2xl mb-2 block"></i>
                    <p class="text-xs font-semibold">Secure Payment</p>
                </div>
                <div class="bg-white/10 rounded-2xl p-4">
                    <i class="fas fa-undo text-2xl mb-2 block"></i>
                    <p class="text-xs font-semibold">Easy Returns</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Right: form panel --}}
    <div class="flex-1 flex items-center justify-center bg-gray-50 px-8 py-16">
        <div class="w-full max-w-md">

            {{-- Logo for medium screens (no left panel) --}}
            <div class="flex justify-center mb-8 lg:hidden">
                <img src="{{ $loginLogo }}" alt="Logo" class="h-16 w-auto object-contain">
            </div>

            <h2 class="text-3xl font-bold text-gray-900 mb-2">Sign In</h2>
            <p class="text-gray-500 mb-8">Enter your credentials to continue</p>

            @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none text-sm transition shadow-sm" required>
                    @error('email')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
                    <input type="password" name="password" placeholder="••••••••"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none text-sm transition shadow-sm" required>
                    @error('password')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-500">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-primary focus:ring-primary">
                    <span>Remember me</span>
                </div>
                <button type="submit" class="w-full bg-primary hover:bg-primary/90 text-white py-3 rounded-xl font-bold text-sm transition shadow-md hover:shadow-lg">
                    Sign In
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-gray-200 text-center space-y-3">
                <p class="text-sm text-gray-500">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-primary font-bold hover:underline">Create one</a>
                </p>
                <a href="/" class="block text-sm text-gray-400 hover:text-gray-600 transition">
                    <i class="fas fa-arrow-left mr-1 text-xs"></i> Back to website
                </a>
            </div>
        </div>
    </div>

</section>
@endsection
