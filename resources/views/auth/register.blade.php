@extends('layouts.app')

@section('title', 'Create Account')

@section('content')
<section class="min-h-[calc(100svh-80px)] flex items-center justify-center bg-gradient-to-br from-primary to-primary/80 px-4 py-6">
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

            <h2 class="text-xl font-bold text-gray-900 text-center mb-1">Create Account</h2>
            <p class="text-xs text-gray-400 text-center mb-6">Join us today — it's free</p>

            @if($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-xs">
                <ul class="space-y-1">
                    @foreach($errors->all() as $error)
                        <li class="flex items-center gap-1.5"><i class="fas fa-exclamation-circle"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('register.post') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Your full name"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none text-sm transition" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none text-sm transition" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" placeholder="Min. 8 characters"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none text-sm transition" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <input type="password" name="password_confirmation" placeholder="Repeat password"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none text-sm transition" required>
                </div>

                <button type="submit"
                        class="w-full bg-primary hover:bg-primary/90 text-white py-2.5 rounded-xl font-semibold text-sm transition shadow-sm">
                    <i class="fas fa-user-plus mr-1.5"></i> Create Account
                </button>
            </form>

            <div class="mt-5 text-center space-y-3">
                <p class="text-sm text-gray-500">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-primary font-semibold hover:underline">Sign in</a>
                </p>
                <a href="/" class="block text-sm text-gray-400 hover:text-gray-600 transition">
                    <i class="fas fa-arrow-left mr-1 text-xs"></i> Back to website
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
