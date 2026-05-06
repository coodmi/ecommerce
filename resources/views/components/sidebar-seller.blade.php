<!-- Seller Sidebar -->
<aside id="sidebar" class="sidebar-animate fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-slate-900 via-slate-800 to-slate-900 text-white transform -translate-x-full transition-transform duration-300 lg:translate-x-0 lg:static lg:inset-0 shadow-2xl">
    <div class="flex flex-col h-full">
        <!-- Logo -->
        <div class="flex items-center justify-between px-6 py-6 border-b border-slate-700/50 bg-slate-900/50 backdrop-blur">
            <div class="flex flex-col items-center w-full space-y-3">
                <div class="relative h-16 transition-transform hover:scale-105">
                    @php
                    $brand = $globalHeaderConfig->get('brand', []);
                    $logo = isset($brand['logo']) ? asset('storage/' . $brand['logo']) : asset('images/shankhobazar.png');
                @endphp
                <img src="{{ $logo }}" alt="Logo" class="h-full w-auto object-contain">
                    <div class="absolute -top-1 -right-1 w-3 h-3 bg-green-400 rounded-full border-2 border-slate-900 animate-pulse"></div>
                </div>
                <div class="text-center">
                    <span class="text-xs font-bold tracking-widest text-primary uppercase">Seller Hub</span>
                </div>
            </div>
            <button id="closeSidebar" class="lg:hidden text-white hover:bg-slate-700/50 p-2 rounded-lg transition-colors cursor-pointer">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="px-4 py-4 grid grid-cols-2 gap-2">
            <div class="bg-slate-800/50 rounded-lg p-3 backdrop-blur border border-slate-700/50">
                <p class="text-[10px] uppercase font-bold tracking-wider text-slate-400">Today's Sales</p>
                <p class="text-lg font-bold text-white">৳2,450</p>
            </div>
            <div class="bg-slate-800/50 rounded-lg p-3 backdrop-blur border border-slate-700/50">
                <p class="text-[10px] uppercase font-bold tracking-wider text-slate-400">New Orders</p>
                <p class="text-lg font-bold text-white">24</p>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto">
            <!-- Dashboard -->
            <a href="/dashboard" class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->is('dashboard') ? 'bg-[#1B262D] border-l-4 border-primary shadow-lg shadow-black/20' : 'hover:bg-slate-700/50' }} transition-all group">
                <i class="fas fa-home text-lg {{ request()->is('dashboard') ? 'text-white' : 'text-primary/30' }} group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">Dashboard</span>
            </a>

            <!-- My Products -->
            <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-slate-700/50 transition-all group">
                <i class="fas fa-box text-lg text-amber-300 group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">My Products</span>
                <span class="ml-auto bg-amber-500/20 text-amber-200 text-xs px-2 py-1 rounded-full">48</span>
            </a>

            <!-- Add Product -->
            <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-slate-700/50 transition-all group">
                <i class="fas fa-plus-circle text-lg text-green-300 group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">Add Product</span>
            </a>

            <!-- Orders -->
            <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-slate-700/50 transition-all group">
                <i class="fas fa-shopping-bag text-lg text-blue-300 group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">Orders</span>
                <span class="ml-auto bg-blue-500/20 text-blue-200 text-xs px-2 py-1 rounded-full">156</span>
            </a>

            <!-- Revenue -->
            <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-slate-700/50 transition-all group">
                <i class="fas fa-dollar-sign text-lg text-yellow-300 group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">Revenue</span>
            </a>

            <!-- Customers -->
            <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-slate-700/50 transition-all group">
                <i class="fas fa-users text-lg text-purple-300 group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">Customers</span>
            </a>

            <!-- Reviews -->
            <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-slate-700/50 transition-all group">
                <i class="fas fa-star text-lg text-orange-300 group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">Reviews</span>
            </a>

            <!-- Store Settings -->
            <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-slate-700/50 transition-all group">
                <i class="fas fa-store-alt text-lg text-pink-300 group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">Store Settings</span>
            </a>

            <!-- Analytics -->
            <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-slate-700/50 transition-all group">
                <i class="fas fa-chart-bar text-lg text-cyan-300 group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">Analytics</span>
            </a>

            <!-- Profile -->
            <a href="{{ route('profile') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-slate-700/50 transition-all group">
                <i class="fas fa-user-circle text-lg text-gray-300 group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">Profile</span>
            </a>
        </nav>

        <!-- User Profile & Logout -->
        <div class="px-4 py-4 border-t border-slate-700/50 bg-slate-900/50 backdrop-blur space-y-2">
            <div class="flex items-center space-x-3 px-4 py-3 rounded-xl bg-slate-800/50 border border-slate-700/50">
                @if(Auth::user()->profile_picture)
                    <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="{{ Auth::user()->name }}" class="w-8 h-8 rounded-full object-cover border-2 border-primary/80">
                @else
                    <div class="w-8 h-8 bg-linear-to-br from-primary/80 to-primary/80 rounded-full flex items-center justify-center">
                        <span class="text-white text-sm font-bold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                @endif
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-slate-400 truncate">Seller Account</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center space-x-2 px-4 py-3 rounded-xl bg-red-600/20 hover:bg-red-600 transition-all text-red-300 hover:text-white font-medium">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>

<!-- Overlay for mobile -->
<div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 lg:hidden hidden"></div>
