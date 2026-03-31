<!-- Sidebar -->
<aside id="sidebar" class="sidebar-animate fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-primary to-primary/80 text-white transform transition-transform duration-300 lg:translate-x-0 lg:static lg:inset-0">
    <div class="flex flex-col h-full">
        <!-- Logo -->
        <div class="flex items-center justify-between px-6 py-6 border-b border-white/20">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                    <span class="text-primary font-bold text-xl">EA</span>
                </div>
                <span class="text-xl font-display font-bold">Ecom Alpha</span>
            </div>
            <button id="closeSidebar" class="lg:hidden text-white hover:bg-white/20 p-2 rounded-lg">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            <a href="/dashboard" class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->is('dashboard') ? 'bg-white/20' : 'hover:bg-white/20' }} transition-colors">
                <i class="fas fa-home text-lg"></i>
                <span class="font-medium">Dashboard</span>
            </a>

            @if(Auth::user()->isAdmin() || Auth::user()->isSeller())
                <a href="{{ route('admin.products.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.products.*') ? 'bg-white/20' : 'hover:bg-white/20' }} transition-colors">
                    <i class="fas fa-shopping-bag text-lg"></i>
                    <span class="font-medium">Products</span>
                </a>
            @endif

            <a href="{{ route('admin.orders.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.orders.*') ? 'bg-white/20' : 'hover:bg-white/20' }} transition-colors">
                <i class="fas fa-shopping-cart text-lg"></i>
                <span class="font-medium">Orders</span>
            </a>

            @if(Auth::user()->isAdmin())
                <a href="{{ route('admin.categories.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.categories.*') ? 'bg-white/20' : 'hover:bg-white/20' }} transition-colors">
                    <i class="fas fa-tags text-lg"></i>
                    <span class="font-medium">Categories</span>
                </a>
                <a href="{{ route('admin.reviews.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.reviews.index') ? 'bg-white/20' : 'hover:bg-white/20' }} transition-colors">
                    <i class="fas fa-comment-dots text-lg"></i>
                    <span class="font-medium">Reviews</span>
                </a>
                <a href="{{ route('admin.seller-requests') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->is('admin/seller-requests') ? 'bg-white/20' : 'hover:bg-white/20' }} transition-colors">
                    <i class="fas fa-user-check text-lg"></i>
                    <span class="font-medium">Seller Requests</span>
                </a>
            @endif

            <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-white/20 transition-colors">
                <i class="fas fa-cog text-lg"></i>
                <span class="font-medium">Settings</span>
            </a>
        </nav>

        <!-- Logout Button -->
        <div class="px-4 py-4 border-t border-white/20">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center space-x-2 px-4 py-3 rounded-xl bg-white/10 hover:bg-red-500 transition-colors text-white">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="font-medium">Logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>

<!-- Overlay for mobile -->
<div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 lg:hidden hidden"></div>
