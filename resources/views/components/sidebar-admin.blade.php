<!-- Admin Sidebar -->
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
                    <div class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full border-2 border-slate-900"></div>
                </div>
                <div class="text-center">
                    <span class="text-xs font-bold tracking-widest text-primary uppercase">Admin Panel</span>
                </div>
            </div>
            <button id="closeSidebar" class="lg:hidden text-white hover:bg-slate-700/50 p-2 rounded-lg transition-colors cursor-pointer">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto no-scrollbar">
            <!-- Dashboard -->
            <a href="/dashboard" class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->is('dashboard') ? 'bg-[#1B262D] border-l-4 border-primary shadow-lg shadow-black/20' : 'hover:bg-slate-700/50' }} transition-all group cursor-pointer">
                <i class="fas fa-chart-line text-lg {{ request()->is('dashboard') ? 'text-white' : 'text-primary' }} group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">Dashboard</span>
            </a>

            <!-- Hero Section -->
            <a href="{{ route('admin.hero.edit') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->is('admin/hero*') ? 'bg-[#1B262D] border-l-4 border-primary shadow-lg shadow-black/20' : 'hover:bg-slate-700/50' }} transition-all group cursor-pointer">
                <i class="fas fa-sliders text-lg {{ request()->is('admin/hero*') ? 'text-white' : 'text-yellow-400' }} group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">Hero Section</span>
            </a>

            <!-- Users Management -->
            <a href="{{ route('admin.users.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->is('admin/users*') ? 'bg-[#1B262D] border-l-4 border-primary shadow-lg shadow-black/20' : 'hover:bg-slate-700/50' }} transition-all group cursor-pointer">
                <i class="fas fa-users text-lg {{ request()->is('admin/users*') ? 'text-white' : 'text-blue-400' }} group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">Users</span>
                <span class="ml-auto bg-blue-500/20 text-blue-300 text-xs px-2 py-1 rounded-full">{{ \App\Models\User::count() }}</span>
            </a>

            <!-- Products -->
            <a href="{{ route('admin.products.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->is('admin/products*') ? 'bg-[#1B262D] border-l-4 border-primary shadow-lg shadow-black/20' : 'hover:bg-slate-700/50' }} transition-all group cursor-pointer">
                <i class="fas fa-box text-lg {{ request()->is('admin/products*') ? 'text-white' : 'text-green-400' }} group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">Products</span>
            </a>

            <!-- Orders -->
            <a href="{{ route('admin.orders.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->is('admin/orders*') ? 'bg-[#1B262D] border-l-4 border-primary shadow-lg shadow-black/20' : 'hover:bg-slate-700/50' }} transition-all group cursor-pointer">
                <i class="fas fa-shopping-cart text-lg {{ request()->is('admin/orders*') ? 'text-white' : 'text-pink-400' }} group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">Orders</span>
            </a>

            <!-- Categories -->
            <a href="{{ route('admin.categories.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->is('admin/categories*') ? 'bg-[#1B262D] border-l-4 border-primary shadow-lg shadow-black/20' : 'hover:bg-slate-700/50' }} transition-all group cursor-pointer">
                <i class="fas fa-tags text-lg {{ request()->is('admin/categories*') ? 'text-white' : 'text-indigo-400' }} group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">Categories</span>
            </a>

            <!-- Brands -->
            <a href="{{ route('admin.brands.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->is('admin/brands*') ? 'bg-[#1B262D] border-l-4 border-primary shadow-lg shadow-black/20' : 'hover:bg-slate-700/50' }} transition-all group cursor-pointer">
                <i class="fas fa-certificate text-lg {{ request()->is('admin/brands*') ? 'text-white' : 'text-rose-400' }} group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">Brands</span>
            </a>

            <!-- Pages Dropdown -->
            <div x-data="{ open: {{ request()->is('admin/pages*') ? 'true' : 'false' }} }" class="space-y-1">
                <button @click="open = !open" 
                   class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl transition-all group cursor-pointer focus:outline-none {{ request()->is('admin/pages*') ? 'bg-[#1B262D] border-l-4 border-primary shadow-lg shadow-black/20' : 'hover:bg-slate-700/50' }}">
                    <i class="fas fa-file-alt text-lg {{ request()->is('admin/pages*') ? 'text-white' : 'text-cyan-400' }} group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium">Pages</span>
                    <i class="fas fa-chevron-down ml-auto text-xs transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                </button>
                
                <div x-show="open" 
                     x-cloak
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-2"
                     class="pl-11 pr-2 space-y-1">
                    <a href="{{ route('admin.pages.index') }}" class="flex items-center space-x-2 py-2 text-sm {{ request()->routeIs('admin.pages.index') ? 'text-primary font-bold' : 'text-gray-400 hover:text-white' }} transition-all duration-200 hover:translate-x-1">
                        <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.pages.index') ? 'bg-primary shadow-[0_0_8px_rgba(251,191,36,0.6)]' : 'bg-slate-600' }}"></span>
                        <span>All Pages</span>
                    </a>
                    @foreach(\App\Models\Page::orderBy('name')->get() as $p)
                    <a href="{{ route('admin.pages.edit', $p->id) }}" class="flex items-center space-x-2 py-2 text-sm {{ request()->is('admin/pages/'.$p->id.'/edit') ? 'text-primary font-bold' : 'text-gray-400 hover:text-white' }} transition-all duration-200 hover:translate-x-1">
                        <span class="w-1.5 h-1.5 rounded-full {{ request()->is('admin/pages/'.$p->id.'/edit') ? 'bg-primary shadow-[0_0_8px_rgba(251,191,36,0.6)]' : 'bg-slate-600' }}"></span>
                        <span>{{ $p->name }}</span>
                    </a>
                    @endforeach
                </div>
            </div>

            <!-- Checkout Fields -->
            <a href="{{ route('admin.checkout-fields.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->is('admin/checkout-fields*') ? 'bg-[#1B262D] border-l-4 border-primary shadow-lg shadow-black/20' : 'hover:bg-slate-700/50' }} transition-all group cursor-pointer">
                <i class="fas fa-list-check text-lg {{ request()->is('admin/checkout-fields*') ? 'text-white' : 'text-indigo-400' }} group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">Checkout Fields</span>
            </a>

            <!-- Deals & Offers -->
            @php
                $dealsPage = \App\Models\Page::where('slug', 'deals')->first();
            @endphp
            <a href="{{ $dealsPage ? route('admin.pages.edit', $dealsPage->id) : '#' }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->is('admin/pages/'.$dealsPage?->id.'/edit') ? 'bg-[#1B262D] border-l-4 border-primary shadow-lg shadow-black/20' : 'hover:bg-slate-700/50' }} transition-all group cursor-pointer">
                <i class="fas fa-percentage text-lg {{ request()->is('admin/pages/'.$dealsPage?->id.'/edit') ? 'text-white' : 'text-yellow-400' }} group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">Deals & Offers</span>
            </a>

            <!-- Header Settings -->
            @php
                $headerPage = \App\Models\Page::where('slug', 'header')->first();
            @endphp
            <a href="{{ $headerPage ? route('admin.pages.edit', $headerPage->id) : '#' }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->is('admin/pages/'.$headerPage?->id.'/edit') ? 'bg-[#1B262D] border-l-4 border-primary shadow-lg shadow-black/20' : 'hover:bg-slate-700/50' }} transition-all group cursor-pointer">
                <i class="fas fa-window-maximize text-lg {{ request()->is('admin/pages/'.$headerPage?->id.'/edit') ? 'text-white' : 'text-indigo-400' }} group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">Header Settings</span>
            </a>

            <!-- Footer Settings -->
            @php
                $footerPage = \App\Models\Page::where('slug', 'footer')->first();
            @endphp
            <a href="{{ $footerPage ? route('admin.pages.edit', $footerPage->id) : '#' }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->is('admin/pages/'.$footerPage?->id.'/edit') ? 'bg-[#1B262D] border-l-4 border-primary shadow-lg shadow-black/20' : 'hover:bg-slate-700/50' }} transition-all group cursor-pointer">
                <i class="fas fa-shoe-prints text-lg {{ request()->is('admin/pages/'.$footerPage?->id.'/edit') ? 'text-white' : 'text-blue-400' }} group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">Footer Settings</span>
            </a>

            <!-- Policy Pages -->
            @php
                $policyPages = \App\Models\Page::whereIn('slug', ['privacy-policy','terms-conditions','refund-policy'])->get();
            @endphp
            <div x-data="{ open: {{ $policyPages->contains(fn($p) => request()->is('admin/pages/'.$p->id.'/edit')) ? 'true' : 'false' }} }" class="space-y-1">
                <button @click="open = !open"
                   class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl transition-all group cursor-pointer focus:outline-none hover:bg-slate-700/50">
                    <i class="fas fa-file-shield text-lg text-orange-300 group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium">Policy Pages</span>
                    <i class="fas fa-chevron-down ml-auto text-xs transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="open" x-cloak
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="pl-11 pr-2 space-y-1">
                    @foreach($policyPages as $pp)
                    <a href="{{ route('admin.pages.edit', $pp->id) }}"
                       class="flex items-center space-x-2 py-2 text-sm {{ request()->is('admin/pages/'.$pp->id.'/edit') ? 'text-primary font-bold' : 'text-gray-400 hover:text-white' }} transition-all duration-200 hover:translate-x-1">
                        <span class="w-1.5 h-1.5 rounded-full {{ request()->is('admin/pages/'.$pp->id.'/edit') ? 'bg-primary' : 'bg-slate-600' }}"></span>
                        <span>{{ $pp->name }}</span>
                    </a>
                    @endforeach
                </div>
            </div>

            <!-- Contact Messages -->
            @php $unreadMsgs = \App\Models\ContactMessage::where('status','unread')->count(); @endphp
            <a href="{{ route('admin.contact-messages.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->is('admin/contact-messages*') ? 'bg-[#1B262D] border-l-4 border-primary shadow-lg shadow-black/20' : 'hover:bg-slate-700/50' }} transition-all group cursor-pointer">
                <i class="fas fa-envelope text-lg {{ request()->is('admin/contact-messages*') ? 'text-white' : 'text-teal-400' }} group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">Contact Messages</span>
                @if($unreadMsgs > 0)
                    <span class="ml-auto bg-red-500/20 text-red-300 text-xs px-2 py-1 rounded-full">{{ $unreadMsgs }}</span>
                @endif
            </a>

            <!-- Reviews -->
            <a href="{{ route('admin.reviews.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.reviews.index') ? 'bg-[#1B262D] border-l-4 border-primary shadow-lg shadow-black/20' : 'hover:bg-slate-700/50' }} transition-all group cursor-pointer">
                <i class="fas fa-star text-lg {{ request()->routeIs('admin.reviews.index') ? 'text-white' : 'text-orange-400' }} group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">Reviews</span>
            </a>

            <!-- Settings -->
            <a href="{{ route('admin.settings.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.settings.*') ? 'bg-[#1B262D] border-l-4 border-primary shadow-lg shadow-black/20' : 'hover:bg-slate-700/50' }} transition-all group cursor-pointer">
                <i class="fas fa-cog text-lg {{ request()->routeIs('admin.settings.*') ? 'text-white' : 'text-gray-400' }} group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">Site Settings</span>
            </a>
        </nav>

        <!-- User Profile & Logout -->
        <div class="px-4 py-4 border-t border-slate-700/50 bg-slate-900/50 backdrop-blur space-y-2">
            <a href="{{ route('profile') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-slate-700/50 transition-all group cursor-pointer">
                @if(Auth::user()->profile_picture)
                    <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="{{ Auth::user()->name }}" class="w-8 h-8 rounded-full object-cover border-2 border-primary">
                @else
                    <div class="w-8 h-8 bg-linear-to-br from-primary to-primary/80 rounded-full flex items-center justify-center">
                        <span class="text-white text-sm font-bold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                @endif
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-400 truncate">{{ Auth::user()->email }}</p>
                </div>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center space-x-2 px-4 py-3 rounded-xl bg-red-600/20 hover:bg-red-600 transition-all text-red-400 hover:text-white font-medium cursor-pointer">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>

<!-- Overlay for mobile -->
<div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 lg:hidden hidden"></div>
