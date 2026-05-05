@extends('layouts.app')

@section('title', 'Reset Password')

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
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-key text-green-600 text-2xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">Set New Password</h2>
                <p class="text-sm text-gray-500 mt-1">Choose a strong password for your account.</p>
            </div>

            @if($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm">
                @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
            </div>
            @endif

            <form method="POST" action="{{ route('password.reset.update') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                    <input type="password" name="password" placeholder="Min. 8 characters"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none text-sm transition" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                    <input type="password" name="password_confirmation" placeholder="Repeat your password"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none text-sm transition" required>
                </div>
                <button type="submit" class="w-full bg-primary hover:bg-primary/90 text-white py-2.5 rounded-xl font-semibold text-sm transition shadow-sm">
                    <i class="fas fa-check mr-2"></i>Reset Password
                </button>
            </form>
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
            <h1 class="text-4xl font-bold mb-4">Almost There!</h1>
            <p class="text-white/80 text-lg max-w-sm leading-relaxed">Create a strong new password to keep your account secure.</p>
            <div class="mt-12 bg-white/10 rounded-2xl p-6 text-left space-y-3">
                <p class="text-sm font-semibold mb-2">Password tips:</p>
                <div class="flex items-center gap-2 text-sm"><i class="fas fa-check-circle text-green-300"></i> At least 8 characters</div>
                <div class="flex items-center gap-2 text-sm"><i class="fas fa-check-circle text-green-300"></i> Mix of letters and numbers</div>
                <div class="flex items-center gap-2 text-sm"><i class="fas fa-check-circle text-green-300"></i> Avoid common words</div>
            </div>
        </div>
    </div>

    <div class="flex-1 flex items-center justify-center bg-gray-50 px-8 py-16">
        <div class="w-full max-w-md">
            <div class="flex justify-center mb-8 lg:hidden">
                <img src="{{ $loginLogo }}" alt="Logo" class="h-16 w-auto object-contain">
            </div>

            <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mb-6">
                <i class="fas fa-key text-green-600 text-2xl"></i>
            </div>

            <h2 class="text-3xl font-bold text-gray-900 mb-2">Set New Password</h2>
            <p class="text-gray-500 mb-8">Choose a strong password for <strong>{{ $email }}</strong></p>

            @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm">
                @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
            </div>
            @endif

            <form method="POST" action="{{ route('password.reset.update') }}" class="space-y-5">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">New Password</label>
                    <input type="password" name="password" placeholder="Min. 8 characters"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none text-sm transition shadow-sm" required>
                    @error('password')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Confirm New Password</label>
                    <input type="password" name="password_confirmation" placeholder="Repeat your password"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none text-sm transition shadow-sm" required>
                </div>

                <button type="submit" class="w-full bg-primary hover:bg-primary/90 text-white py-3 rounded-xl font-bold text-sm transition shadow-md hover:shadow-lg">
                    <i class="fas fa-check mr-2"></i>Reset Password
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
