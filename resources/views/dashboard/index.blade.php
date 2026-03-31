@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
@php
    $user = Auth::user();
@endphp

@if($user->isAdmin())
    {{-- ── ADMIN DASHBOARD ── --}}
    <div class="p-6 space-y-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 font-display">Dashboard Overview</h1>
                <p class="text-gray-500 mt-1">Welcome back, {{ $user->name }}!
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary/10 text-primary">Admin</span>
                </p>
            </div>
            <div class="mt-4 md:mt-0 flex gap-3">
                <a href="{{ route('admin.products.create') }}" class="px-6 py-2.5 bg-primary text-white rounded-xl font-medium hover:bg-primary/90 transition">
                    <i class="fas fa-plus mr-2"></i>Add Product
                </a>
            </div>
        </div>

        {{-- Stats --}}
        @php
            $totalOrders    = \App\Models\Order::count();
            $totalRevenue   = \App\Models\Order::whereIn('status', ['delivered','completed'])->sum('total_amount');
            $totalCustomers = \App\Models\User::where('role','user')->count();
            $totalProducts  = \App\Models\Product::count();
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-dollar-sign text-white text-xl"></i>
                    </div>
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">Total Revenue</h3>
                <p class="text-3xl font-bold text-gray-900">${{ number_format($totalRevenue, 2) }}</p>
            </div>
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-primary to-primary/80 rounded-xl flex items-center justify-center">
                        <i class="fas fa-shopping-cart text-white text-xl"></i>
                    </div>
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">Total Orders</h3>
                <p class="text-3xl font-bold text-gray-900">{{ number_format($totalOrders) }}</p>
            </div>
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-users text-white text-xl"></i>
                    </div>
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">Total Customers</h3>
                <p class="text-3xl font-bold text-gray-900">{{ number_format($totalCustomers) }}</p>
            </div>
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-box text-white text-xl"></i>
                    </div>
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">Total Products</h3>
                <p class="text-3xl font-bold text-gray-900">{{ number_format($totalProducts) }}</p>
            </div>
        </div>

        {{-- Recent Orders --}}
        @php $recentOrders = \App\Models\Order::with('user')->latest()->take(8)->get(); @endphp
        <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900">Recent Orders</h3>
                <a href="{{ route('admin.orders.index') }}" class="text-primary text-sm font-semibold hover:text-primary/80">View All <i class="fas fa-arrow-right ml-1"></i></a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100 text-xs uppercase text-gray-500">
                            <th class="text-left py-3 px-4">Order ID</th>
                            <th class="text-left py-3 px-4">Customer</th>
                            <th class="text-left py-3 px-4">Status</th>
                            <th class="text-right py-3 px-4">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                        @php
                            $sc = ['pending'=>'bg-yellow-50 text-yellow-700','processing'=>'bg-blue-50 text-blue-700','delivered'=>'bg-green-50 text-green-700','completed'=>'bg-green-50 text-green-700','cancelled'=>'bg-red-50 text-red-700'];
                            $cls = $sc[$order->status] ?? 'bg-gray-50 text-gray-700';
                        @endphp
                        <tr class="border-b border-gray-50 hover:bg-gray-50">
                            <td class="py-3 px-4 font-semibold text-gray-900">#{{ $order->id }}</td>
                            <td class="py-3 px-4 text-gray-600">{{ $order->user->name ?? 'Guest' }}</td>
                            <td class="py-3 px-4"><span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $cls }}">{{ ucfirst($order->status) }}</span></td>
                            <td class="py-3 px-4 text-right font-bold text-gray-900">${{ number_format($order->total_amount, 2) }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="py-8 text-center text-gray-400">No orders yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@else
    {{-- ── USER DASHBOARD ── --}}
    @php
        $myOrders    = \App\Models\Order::where('user_id', $user->id)->latest()->take(5)->get();
        $orderCount  = \App\Models\Order::where('user_id', $user->id)->count();
        $wishCount   = \App\Models\Wishlist::where('user_id', $user->id)->count();
        $reviewCount = \App\Models\Review::where('user_id', $user->id)->count();
        $pendingCount= \App\Models\Order::where('user_id', $user->id)->whereIn('status',['pending','processing'])->count();
    @endphp

    <div class="p-6 space-y-6">
        {{-- Greeting --}}
        <div class="flex items-center gap-4">
            @if($user->profile_picture)
                <img src="{{ asset('storage/' . $user->profile_picture) }}" class="w-14 h-14 rounded-full object-cover border-2 border-primary shadow">
            @else
                <div class="w-14 h-14 rounded-full bg-gradient-to-br from-primary to-purple-600 flex items-center justify-center text-white text-2xl font-bold shadow">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
            @endif
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Welcome back, {{ $user->name }}!</h1>
                <p class="text-gray-500 text-sm">Here's a summary of your account activity.</p>
            </div>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex flex-col gap-2">
                <div class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center">
                    <i class="fas fa-shopping-bag text-primary"></i>
                </div>
                <p class="text-2xl font-bold text-gray-900">{{ $orderCount }}</p>
                <p class="text-xs text-gray-500 font-medium">Total Orders</p>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex flex-col gap-2">
                <div class="w-10 h-10 bg-yellow-50 rounded-xl flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-500"></i>
                </div>
                <p class="text-2xl font-bold text-gray-900">{{ $pendingCount }}</p>
                <p class="text-xs text-gray-500 font-medium">Pending Orders</p>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex flex-col gap-2">
                <div class="w-10 h-10 bg-pink-50 rounded-xl flex items-center justify-center">
                    <i class="fas fa-heart text-pink-500"></i>
                </div>
                <p class="text-2xl font-bold text-gray-900">{{ $wishCount }}</p>
                <p class="text-xs text-gray-500 font-medium">Wishlist Items</p>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex flex-col gap-2">
                <div class="w-10 h-10 bg-yellow-50 rounded-xl flex items-center justify-center">
                    <i class="fas fa-star text-yellow-400"></i>
                </div>
                <p class="text-2xl font-bold text-gray-900">{{ $reviewCount }}</p>
                <p class="text-xs text-gray-500 font-medium">Reviews Given</p>
            </div>
        </div>

        {{-- Quick Links --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('user.orders') }}" class="bg-white border border-gray-100 rounded-2xl p-5 flex flex-col items-center gap-3 hover:shadow-md hover:border-primary/30 transition group">
                <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center group-hover:bg-primary/20 transition">
                    <i class="fas fa-shopping-bag text-primary text-lg"></i>
                </div>
                <span class="text-sm font-semibold text-gray-700">My Orders</span>
            </a>
            <a href="{{ route('wishlist.index') }}" class="bg-white border border-gray-100 rounded-2xl p-5 flex flex-col items-center gap-3 hover:shadow-md hover:border-pink-200 transition group">
                <div class="w-12 h-12 bg-pink-50 rounded-xl flex items-center justify-center group-hover:bg-pink-100 transition">
                    <i class="fas fa-heart text-pink-500 text-lg"></i>
                </div>
                <span class="text-sm font-semibold text-gray-700">Wishlist</span>
            </a>
            <a href="{{ route('cart.index') }}" class="bg-white border border-gray-100 rounded-2xl p-5 flex flex-col items-center gap-3 hover:shadow-md hover:border-green-200 transition group">
                <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center group-hover:bg-green-100 transition">
                    <i class="fas fa-shopping-cart text-green-500 text-lg"></i>
                </div>
                <span class="text-sm font-semibold text-gray-700">Cart</span>
            </a>
            <a href="{{ route('profile') }}" class="bg-white border border-gray-100 rounded-2xl p-5 flex flex-col items-center gap-3 hover:shadow-md hover:border-blue-200 transition group">
                <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center group-hover:bg-blue-100 transition">
                    <i class="fas fa-user-circle text-blue-500 text-lg"></i>
                </div>
                <span class="text-sm font-semibold text-gray-700">Profile</span>
            </a>
        </div>

        {{-- Recent Orders --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-lg font-bold text-gray-900">Recent Orders</h3>
                <a href="{{ route('user.orders') }}" class="text-primary text-sm font-semibold hover:text-primary/80">View All <i class="fas fa-arrow-right ml-1"></i></a>
            </div>
            @forelse($myOrders as $order)
            @php
                $sc = ['pending'=>'bg-yellow-50 text-yellow-700 border-yellow-200','processing'=>'bg-blue-50 text-blue-700 border-blue-200','delivered'=>'bg-green-50 text-green-700 border-green-200','completed'=>'bg-green-50 text-green-700 border-green-200','cancelled'=>'bg-red-50 text-red-700 border-red-200'];
                $cls = $sc[$order->status] ?? 'bg-gray-50 text-gray-700 border-gray-200';
            @endphp
            <div class="flex items-center justify-between py-3 border-b border-gray-50 last:border-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-box text-primary text-sm"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900 text-sm">Order #{{ $order->id }}</p>
                        <p class="text-xs text-gray-400">{{ $order->created_at->format('d M Y') }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <span class="px-2.5 py-1 rounded-lg text-xs font-semibold border {{ $cls }}">{{ ucfirst($order->status) }}</span>
                    <span class="font-bold text-gray-900 text-sm">${{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
            @empty
            <div class="py-10 text-center text-gray-400">
                <i class="fas fa-shopping-bag text-3xl mb-3 block opacity-20"></i>
                <p class="text-sm">No orders yet. <a href="/" class="text-primary font-medium hover:underline">Start shopping</a></p>
            </div>
            @endforelse
        </div>
    </div>
@endif
@endsection
