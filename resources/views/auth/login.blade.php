@extends('layouts.app')

@section('title', 'Sign In')

@section('content')
<section class="min-h-screen flex items-center justify-center bg-gradient-to-br from-primary to-primary/80 px-4">
    <div class="w-full max-w-sm relative z-10">
        <div class="bg-white rounded-2xl shadow-xl p-8">
            @php
                $loginBrand = \App\Models\Page::where('slug','header')->with('sections')->first();
                $loginBrandContent = $loginBrand ? ($loginBrand->sections->where('key','brand')->first()?->content ?? []) : [];
                $loginLogo = isset($loginBrandContent['logo']) ? asset('storage/' . $loginBrandContent['logo']) : asset('images/shankhobazar.png');
            @endphp
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
            <div class="mt-5 text-center">
                <a href="/" class="text-sm text-gray-400 hover:text-gray-600 transition">
                    <i class="fas fa-arrow-left mr-1 text-xs"></i> Back to website
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
