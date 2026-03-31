@extends('layouts.app')

@section('title', 'Login - Shankhobazar')

@section('content')
<section class="min-h-screen flex items-center justify-center bg-linear-to-br from-primary to-primary/80 py-12 px-4">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-primary/30 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
        <div class="absolute top-1/2 right-1/4 w-96 h-96 bg-primary/50 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-0 left-1/2 w-96 h-96 bg-yellow-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob animation-delay-4000"></div>
    </div>

    <div class="w-full max-w-md relative z-10">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="flex justify-center mb-6">
                <div class="h-24 transition-transform hover:scale-105">
                    <img src="{{ asset('images/shankhobazar.png') }}" alt="Shankhobazar Logo" class="h-full w-auto object-contain">
                </div>
            </div>
            <p class="text-purple-100 text-lg">Admin Dashboard Login</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-10">
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-gray-900 font-display mb-2">Welcome Back!</h2>
                <p class="text-gray-600">Sign in to access your dashboard</p>
            </div>

            @if(session('error'))
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                    <p class="text-red-700 text-sm">{{ session('error') }}</p>
                </div>
            </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}" class="space-y-6">
                @csrf

                <!-- Email -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        Email Address
                    </label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="email"
                               name="email"
                               value="{{ old('email') }}"
                               placeholder="admin@gmail.com"
                               class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-purple-600 focus:ring-4 focus:ring-purple-100 outline-none transition-all @error('email') border-red-500 @enderror"
                               required>
                    </div>
                    @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        Password
                    </label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="password"
                               name="password"
                               placeholder="••••••••"
                               class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-purple-600 focus:ring-4 focus:ring-purple-100 outline-none transition-all @error('password') border-red-500 @enderror"
                               required>
                    </div>
                    @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember & Forgot -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-primary">
                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                    </label>
                    <a href="#" class="text-sm text-purple-600 hover:text-purple-700 font-semibold">
                        Forgot password?
                    </a>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                        class="w-full bg-linear-to-r from-purple-600 to-pink-600 text-white py-4 rounded-xl font-bold text-lg hover:shadow-2xl transform hover:scale-105 transition-all">
                    <i class="fas fa-sign-in-alt mr-2"></i>Sign In
                </button>
            </form>

            <!-- Divider -->
            <div class="my-8 flex items-center">
                <div class="flex-1 border-t border-gray-300"></div>
                <span class="px-4 text-sm text-gray-500">OR</span>
                <div class="flex-1 border-t border-gray-300"></div>
            </div>

            <!-- Register Link -->
            <a href="{{ route('register') }}" class="block w-full text-center bg-purple-100 text-purple-700 py-3 rounded-xl font-semibold hover:bg-purple-200 transition-colors mb-3">
                <i class="fas fa-user-plus mr-2"></i>Create New Account
            </a>

            <!-- Back to Website -->
            <a href="/" class="block w-full text-center bg-gray-100 text-gray-700 py-3 rounded-xl font-semibold hover:bg-gray-200 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Back to Website
            </a>
        </div>

        <!-- Info -->
        <div class="mt-6 text-center">
            <p class="text-purple-100 text-sm">
                <i class="fas fa-info-circle mr-1"></i>
                Demo credentials: admin@gmail.com / password
            </p>
        </div>
    </div>
</section>
@endsection
