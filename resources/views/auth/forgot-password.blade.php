@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
@php
    $loginBrand = \App\Models\Page::where('slug','header')->with('sections')->first();
    $loginBrandContent = $loginBrand ? ($loginBrand->sections->where('key','brand')->first()?->content ?? []) : [];
    $loginLogo = isset($loginBrandContent['logo']) ? asset('storage/' . $loginBrandContent['logo']) : asset('images/shankhobazar.png');
@endphp

{{-- MOBILE --}}
<section class="sm:hidden flex items-center justify-center bg-gradient-to-br from-primary to-primary/80 px-4 py-8 min-h-[calc(100vh-72px)]">
    <div class="w-full max-w-sm">
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <div class="flex justify-center mb-6">
                <img src="{{ $loginLogo }}" alt="Logo" class="h-16 w-auto object-contain">
            </div>
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-lock text-primary text-2xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">Forgot Password?</h2>
                <p class="text-sm text-gray-500 mt-1">Enter your email and we'll send you a reset link.</p>
            </div>

            @if(session('success'))
            <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm flex items-start gap-2">
                <i class="fas fa-check-circle mt-0.5"></i>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            @if($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm">
                @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
            </div>
            @endif

            <form method="POST" action="{{ route('password.forgot.send') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none text-sm transition" required autofocus>
                </div>
                <button type="submit" class="w-full bg-primary hover:bg-primary/90 text-white py-2.5 rounded-xl font-semibold text-sm transition shadow-sm">
                    <i class="fas fa-paper-plane mr-2"></i>Send Reset Link
                </button>
            </form>
            <div class="mt-5 text-center">
                <a href="{{ route('login') }}" class="text-sm text-primary font-semibold hover:underline">
                    <i class="fas fa-arrow-left mr-1 text-xs"></i> Back to Sign In
                </a>
            </div>
        </div>
    </div>
</section>

{{-- DESKTOP --}}
<section class="hidden sm:flex min-h-screen">
    <div class="hidden lg:flex w-1/2 bg-gradient-to-br from-primary to-primary/80 flex-col items-center justify-center px-16 text-white relative overflow-hidden">
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-white/10 rounded-full"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-white/10 rounded-full"></div>
        <div class="relative z-10 text-center">
            <img src="{{ $loginLogo }}" alt="Logo" class="h-20 w-auto object-contain mx-auto mb-8 brightness-0 invert">
            <h1 class="text-4xl font-bold mb-4">Forgot Your Password?</h1>
            <p class="text-white/80 text-lg max-w-sm leading-relaxed">No worries! Enter your email and we'll send you a secure link to reset it.</p>
            <div class="mt-12 bg-white/10 rounded-2xl p-6 text-left">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center text-sm font-bold">1</div>
                    <p class="text-sm">Enter your registered email address</p>
                </div>
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center text-sm font-bold">2</div>
                    <p class="text-sm">Check your inbox for the reset link</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center text-sm font-bold">3</div>
                    <p class="text-sm">Set your new password and sign in</p>
                </div>
            </div>
        </div>
    </div>

    <div class="flex-1 flex items-center justify-center bg-gray-50 px-8 py-16">
        <div class="w-full max-w-md">
            <div class="flex justify-center mb-8 lg:hidden">
                <img src="{{ $loginLogo }}" alt="Logo" class="h-16 w-auto object-contain">
            </div>

            <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center mb-6">
                <i class="fas fa-lock text-primary text-2xl"></i>
            </div>

            <h2 class="text-3xl font-bold text-gray-900 mb-2">Forgot Password?</h2>
            <p class="text-gray-500 mb-8">Enter your email and we'll send you a reset link.</p>

            @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-4 rounded-xl text-sm flex items-start gap-3">
                <i class="fas fa-check-circle text-green-500 mt-0.5 text-lg"></i>
                <div>
                    <p class="font-semibold">Email sent!</p>
                    <p class="mt-0.5">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm">
                @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
            </div>
            @endif

            <form method="POST" action="{{ route('password.forgot.send') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none text-sm transition shadow-sm" required autofocus>
                    @error('email')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>
                <button type="submit" class="w-full bg-primary hover:bg-primary/90 text-white py-3 rounded-xl font-bold text-sm transition shadow-md hover:shadow-lg">
                    <i class="fas fa-paper-plane mr-2"></i>Send Reset Link
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-gray-200 text-center">
                <a href="{{ route('login') }}" class="text-sm text-primary font-bold hover:underline">
                    <i class="fas fa-arrow-left mr-1 text-xs"></i> Back to Sign In
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
