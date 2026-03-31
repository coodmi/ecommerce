@php
    $headerPage = \App\Models\Page::where('slug', 'header')->with('sections')->first();
    $headerSections = $headerPage ? $headerPage->sections->pluck('content', 'key') : collect();
    $topBar = $headerSections->get('top_bar', []);
    $navigation = $headerSections->get('navigation', []);
    $brand = $headerSections->get('brand', []);
@endphp

<header class="bg-white shadow-md sticky top-0 z-50">
    <!-- Top Bar -->
    <div class="bg-primary text-white py-2 hidden md:block">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center text-sm">
                <div class="flex items-center space-x-6">
                    <a href="tel:{{ str_replace([' ', '-', '(', ')'], '', $topBar['phone'] ?? '+8801234567890') }}" class="hover:text-white/80 transition">
                        <i class="fas fa-phone-alt mr-2"></i>{{ $topBar['phone'] ?? '+880 1234-567890' }}
                    </a>
                    <a href="mailto:{{ $topBar['email'] ?? 'info@ecomalpha.com' }}" class="hover:text-white/80 transition">
                        <i class="fas fa-envelope mr-2"></i>{{ $topBar['email'] ?? 'info@ecomalpha.com' }}
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <span><i class="fas fa-truck mr-2"></i>{{ $topBar['announcement'] ?? 'Free Shipping on Orders Over $50' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation -->
    <nav class="container mx-auto px-4 py-3">

        <!-- Mobile: single row — logo | search | cart | hamburger -->
        <div class="flex lg:hidden items-center gap-2">
            <!-- Logo -->
            <a href="/" class="flex-shrink-0">
                <img src="{{ isset($brand['logo']) ? asset('storage/' . $brand['logo']) : asset('images/shankhobazar.png') }}"
                     alt="Logo" class="h-10 w-auto object-contain">
            </a>

            <!-- Mobile Search -->
            <div class="flex-1 min-w-0 flex items-center gap-1" x-data="searchComponent()">
                <div class="relative flex-1 min-w-0">
                    <input type="text"
                           x-model="searchQuery"
                           @input="handleSearch"
                           @focus="showResults = true"
                           @keydown.escape="showResults = false"
                           @keydown.enter.prevent="selectResult"
                           placeholder="Search..."
                           class="w-full px-3 py-2 pr-3 border border-gray-300 rounded-lg text-sm focus:border-primary focus:outline-none"
                           autocomplete="off">
                </div>
                <button @click="performSearch" class="flex-shrink-0 bg-primary text-white w-9 h-9 rounded-lg flex items-center justify-center">
                    <i class="fas fa-search text-sm"></i>
                </button>
                <!-- Mobile Search Dropdown -->
                <div x-show="showResults && (searchResults.length > 0 || isLoading)"
                     @click.away="showResults = false"
                     class="absolute left-4 right-4 bg-white border border-gray-200 rounded-lg shadow-xl mt-1 max-h-80 overflow-y-auto z-50"
                     style="display: none;">
                    <div x-show="isLoading" class="p-3 text-center text-sm text-gray-500">
                        <i class="fas fa-spinner fa-spin text-primary mr-1"></i>Searching...
                    </div>
                    <template x-for="(product, index) in searchResults" :key="product.id">
                        <a :href="`/product/${product.slug}`"
                           class="flex items-center p-2 hover:bg-gray-50 border-b border-gray-100 last:border-0">
                            <img :src="product.image" :alt="product.name" class="w-10 h-10 object-cover rounded mr-2 flex-shrink-0">
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-gray-900 text-xs truncate" x-text="product.name"></p>
                                <p class="text-primary font-bold text-xs" x-text="product.price"></p>
                            </div>
                        </a>
                    </template>
                    <div x-show="!isLoading && searchResults.length === 0 && searchQuery.length > 0" class="p-3 text-center text-sm text-gray-500">
                        No results found
                    </div>
                </div>
            </div>

            <!-- Cart -->
            <a href="{{ route('cart.index') }}" class="flex-shrink-0 relative text-gray-700 hover:text-primary">
                <i class="fas fa-shopping-cart text-xl"></i>
                @php $cartCount = count(session('cart', [])); @endphp
                @if($cartCount > 0)
                    <span class="absolute -top-1 -right-1 bg-primary text-white text-[10px] rounded-full w-4 h-4 flex items-center justify-center">{{ $cartCount }}</span>
                @endif
            </a>

            <!-- Hamburger -->
            <button id="mobileMenuBtn" class="flex-shrink-0 text-gray-700 hover:text-primary">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>

        <!-- Desktop: logo | nav | search | icons -->
        <div class="hidden lg:flex items-center justify-between gap-6">
            <!-- Logo -->
            <a href="/" class="flex-shrink-0">
                <img src="{{ isset($brand['logo']) ? asset('storage/' . $brand['logo']) : asset('images/shankhobazar.png') }}"
                     alt="Logo" class="h-12 w-auto object-contain">
            </a>

            <!-- Desktop Nav -->
            <div class="flex items-center space-x-8 flex-shrink-0">
                @foreach($navigation['items'] ?? [] as $item)
                    <a href="{{ $item['url'] ?? '#' }}"
                       class="{{ Request::is(trim($item['url'] ?? '', '/') ?: '/') ? 'text-primary font-bold' : 'text-gray-700 hover:text-primary' }} font-medium transition whitespace-nowrap">
                        {{ $item['name'] ?? '' }}
                    </a>
                @endforeach
            </div>

            <!-- Desktop Search -->
            <div class="flex-1 max-w-xl" x-data="searchComponent()">
                <div class="relative">
                    <input type="text"
                           x-model="searchQuery"
                           @input="handleSearch"
                           @focus="showResults = true"
                           @keydown.escape="showResults = false"
                           @keydown.arrow-down.prevent="navigateResults('down')"
                           @keydown.arrow-up.prevent="navigateResults('up')"
                           @keydown.enter.prevent="selectResult"
                           placeholder="Search products..."
                           class="w-full px-4 py-2.5 pr-12 border border-gray-300 rounded-lg focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none text-sm"
                           autocomplete="off">
                    <button @click="performSearch" class="absolute right-1 top-1/2 -translate-y-1/2 bg-primary text-white px-4 py-1.5 rounded-md hover:bg-primary/90 transition">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <!-- Desktop Search Dropdown -->
                <div x-show="showResults && (searchResults.length > 0 || isLoading)"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     @click.away="showResults = false"
                     class="absolute top-full left-0 right-0 bg-white border border-gray-200 rounded-lg shadow-xl mt-1 max-h-96 overflow-y-auto z-50"
                     style="display: none;">
                    <div x-show="isLoading" class="p-4 text-center">
                        <i class="fas fa-spinner fa-spin text-primary"></i>
                        <span class="ml-2 text-gray-600 text-sm">Searching...</span>
                    </div>
                    <template x-for="(product, index) in searchResults" :key="product.id">
                        <a :href="`/product/${product.slug}`"
                           class="flex items-center p-3 hover:bg-gray-50 border-b border-gray-100 last:border-0"
                           :class="{ 'bg-primary/5': selectedIndex === index }"
                           @mouseenter="selectedIndex = index">
                            <img :src="product.image" :alt="product.name" class="w-12 h-12 object-cover rounded-lg mr-3">
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-900 text-sm" x-text="product.name"></h4>
                                <p class="text-xs text-gray-500" x-text="product.category"></p>
                                <span class="text-primary font-bold text-sm" x-text="product.price"></span>
                            </div>
                        </a>
                    </template>
                    <div x-show="!isLoading && searchResults.length === 0 && searchQuery.length > 0" class="p-4 text-center text-gray-500 text-sm">
                        No products found for "<span x-text="searchQuery"></span>"
                    </div>
                    <div x-show="searchResults.length > 0" class="p-3 border-t border-gray-200 bg-gray-50">
                        <a :href="`/shop?search=${encodeURIComponent(searchQuery)}`"
                           class="block text-center text-primary font-medium text-sm hover:text-primary/80">
                            View all results
                        </a>
                    </div>
                </div>
            </div>

            <!-- Desktop Icons -->
            <div class="flex items-center gap-6 flex-shrink-0">
                <a href="{{ route('wishlist.index') }}" class="text-gray-700 hover:text-primary relative flex flex-col items-center gap-1 group">
                    <i class="fas fa-heart text-lg"></i>
                    <span class="text-[11px] text-gray-500 group-hover:text-primary">Wishlist</span>
                    @php $wishlistCount = \App\Models\Wishlist::where('user_id', Auth::id())->count(); @endphp
                    @if($wishlistCount > 0)
                        <span class="absolute -top-1 -right-2 bg-red-500 text-white text-[9px] rounded-full w-4 h-4 flex items-center justify-center font-bold">{{ $wishlistCount }}</span>
                    @endif
                </a>
                <a href="{{ route('cart.index') }}" class="text-gray-700 hover:text-primary relative flex flex-col items-center gap-1 group">
                    <i class="fas fa-shopping-cart text-lg"></i>
                    <span class="text-[11px] text-gray-500 group-hover:text-primary">Cart</span>
                    @php $cartCount = count(session('cart', [])); @endphp
                    @if($cartCount > 0)
                        <span class="absolute -top-1 -right-2 bg-primary text-white text-[9px] rounded-full w-4 h-4 flex items-center justify-center font-bold">{{ $cartCount }}</span>
                    @endif
                </a>
                <!-- User Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="text-gray-700 hover:text-primary flex flex-col items-center gap-1 group">
                        @auth
                            @if(Auth::user()->profile_picture)
                                <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile" class="w-6 h-6 rounded-full object-cover border-2 border-primary">
                            @else
                                <i class="fas fa-user-circle text-lg text-primary"></i>
                            @endif
                            <span class="text-[11px] text-gray-500 group-hover:text-primary">Account</span>
                        @else
                            <i class="fas fa-user text-lg"></i>
                            <span class="text-[11px] text-gray-500 group-hover:text-primary">Login</span>
                        @endauth
                    </button>
                    <div x-show="open" @click.away="open = false"
                         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                         class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-200 py-2 z-50"
                         style="display: none;">
                        @auth
                            <div class="px-4 py-3 border-b border-gray-200">
                                <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                            </div>
                            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-4 py-2 text-gray-700 hover:bg-primary/5 transition">
                                <i class="fas fa-tachometer-alt text-primary"></i><span class="font-medium">Dashboard</span>
                            </a>
                            <a href="{{ route('profile') }}" class="flex items-center space-x-3 px-4 py-2 text-gray-700 hover:bg-primary/5 transition">
                                <i class="fas fa-user-circle text-primary"></i><span class="font-medium">Profile</span>
                            </a>
                            <a href="{{ route('user.orders') }}" class="flex items-center space-x-3 px-4 py-2 text-gray-700 hover:bg-primary/5 transition">
                                <i class="fas fa-shopping-bag text-primary"></i><span class="font-medium">My Orders</span>
                            </a>
                            <div class="border-t border-gray-200 my-2"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center space-x-3 px-4 py-2 text-red-600 hover:bg-red-50 transition">
                                    <i class="fas fa-sign-out-alt"></i><span class="font-medium">Logout</span>
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="flex items-center space-x-3 px-4 py-2 text-gray-700 hover:bg-primary/5 transition">
                                <i class="fas fa-sign-in-alt text-primary"></i><span class="font-medium">Login</span>
                            </a>
                            <a href="{{ route('register') }}" class="flex items-center space-x-3 px-4 py-2 text-gray-700 hover:bg-primary/5 transition">
                                <i class="fas fa-user-plus text-primary"></i><span class="font-medium">Register</span>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Menu (hamburger dropdown) -->
        <div id="mobileMenu" class="hidden lg:hidden mt-3 pb-3 border-t pt-3">
            <div class="flex flex-col space-y-1">
                @foreach($navigation['items'] ?? [] as $item)
                    <a href="{{ $item['url'] ?? '#' }}"
                       class="{{ Request::is(trim($item['url'] ?? '', '/') ?: '/') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100' }} block px-4 py-2.5 rounded-lg font-medium transition">
                        {{ $item['name'] ?? '' }}
                    </a>
                @endforeach
                <div class="pt-3 border-t space-y-1">
                    @auth
                        <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition">
                            <i class="fas fa-tachometer-alt mr-2 text-primary"></i>Dashboard
                        </a>
                        <a href="{{ route('profile') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition">
                            <i class="fas fa-user-circle mr-2 text-primary"></i>Profile
                        </a>
                        <a href="{{ route('user.orders') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition">
                            <i class="fas fa-shopping-bag mr-2 text-primary"></i>My Orders
                        </a>
                        <a href="{{ route('wishlist.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition">
                            <i class="fas fa-heart mr-2 text-primary"></i>Wishlist
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg transition">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition">
                            <i class="fas fa-sign-in-alt mr-2 text-primary"></i>Login
                        </a>
                        <a href="{{ route('register') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition">
                            <i class="fas fa-user-plus mr-2 text-primary"></i>Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
</header>

<script>
function searchComponent() {
    return {
        searchQuery: '',
        searchResults: [],
        showResults: false,
        isLoading: false,
        selectedIndex: -1,
        searchTimeout: null,
        handleSearch() {
            clearTimeout(this.searchTimeout);
            if (this.searchQuery.length < 2) { this.searchResults = []; this.showResults = false; return; }
            this.searchTimeout = setTimeout(() => this.performLiveSearch(), 300);
        },
        async performLiveSearch() {
            this.isLoading = true; this.showResults = true;
            try {
                const res = await fetch(`/api/search?q=${encodeURIComponent(this.searchQuery)}&limit=8`);
                const data = await res.json();
                this.searchResults = data.products || [];
                this.selectedIndex = -1;
            } catch(e) { this.searchResults = []; }
            finally { this.isLoading = false; }
        },
        navigateResults(dir) {
            if (!this.searchResults.length) return;
            this.selectedIndex = dir === 'down'
                ? Math.min(this.selectedIndex + 1, this.searchResults.length - 1)
                : Math.max(this.selectedIndex - 1, -1);
        },
        selectResult() {
            if (this.selectedIndex >= 0 && this.searchResults[this.selectedIndex])
                window.location.href = `/product/${this.searchResults[this.selectedIndex].slug}`;
            else this.performSearch();
        },
        performSearch() {
            if (this.searchQuery.trim()) window.location.href = `/shop?search=${encodeURIComponent(this.searchQuery)}`;
        }
    }
}
</script>
