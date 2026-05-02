<!-- Top Navigation -->
<header class="bg-white shadow-sm z-30">
    <div class="flex items-center justify-between px-6 py-4">
        <!-- Left: Menu Button -->
        <div class="flex items-center space-x-4">
            <button id="openSidebar" class="lg:hidden text-gray-600 hover:text-primary transition-colors cursor-pointer">
                <i class="fas fa-bars text-xl"></i>
            </button>
            
            <!-- Mobile Logo -->
            <div class="lg:hidden h-8">
                @php
                    $brand = $globalHeaderConfig->get('brand', []);
                    $logo = isset($brand['logo']) ? asset('storage/' . $brand['logo']) : asset('images/shankhobazar.png');
                @endphp
                <img src="{{ $logo }}" alt="Logo" class="h-full w-auto object-contain">
            </div>
        </div>

        <!-- Right: Notifications & Profile -->
        <div class="flex items-center space-x-3">
            <!-- Visit Site Button -->
            <a href="{{ url('/') }}" target="_blank"
               class="hidden sm:flex items-center space-x-2 px-3 py-2 bg-primary/10 hover:bg-primary/20 text-primary rounded-xl text-sm font-semibold transition-colors">
                <i class="fas fa-external-link-alt text-xs"></i>
                <span>Visit Site</span>
            </a>

            @if(Auth::check() && Auth::user()->isAdmin())
            @php
                $newOrders = \App\Models\Order::where('status', 'pending')
                    ->where('created_at', '>=', now()->subHours(24))
                    ->latest()->take(5)->get();
                $newOrdersCount = $newOrders->count();
            @endphp
            {{-- Notification Bell --}}
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open"
                        class="relative p-2 text-gray-600 hover:text-primary hover:bg-primary/10 rounded-xl transition-colors cursor-pointer">
                    <i class="fas fa-bell text-xl"></i>
                    @if($newOrdersCount > 0)
                        <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                    @endif
                </button>

                <div x-show="open" @click.away="open = false"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     class="absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-xl border border-gray-100 z-50"
                     style="display:none;">
                    <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="font-semibold text-gray-900 text-sm">New Orders</h3>
                        @if($newOrdersCount > 0)
                            <span class="bg-red-100 text-red-600 text-xs font-bold px-2 py-0.5 rounded-full">{{ $newOrdersCount }} new</span>
                        @endif
                    </div>
                    <div class="max-h-72 overflow-y-auto">
                        @forelse($newOrders as $order)
                        <a href="{{ route('admin.orders.show', $order) }}"
                           class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 transition border-b border-gray-50 last:border-0">
                            <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="fas fa-shopping-bag text-primary text-xs"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-800">Order #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ $order->user->name ?? ($order->checkout_details['full_name'] ?? 'Guest') }}</p>
                                <p class="text-xs text-gray-400">{{ $order->created_at->diffForHumans() }}</p>
                            </div>
                            <span class="text-xs font-bold text-gray-900 flex-shrink-0">${{ number_format($order->total_amount, 2) }}</span>
                        </a>
                        @empty
                        <div class="px-4 py-6 text-center text-sm text-gray-400">
                            <i class="fas fa-check-circle text-green-400 text-2xl mb-2 block"></i>
                            No new orders in the last 24h
                        </div>
                        @endforelse
                    </div>
                    @if($newOrdersCount > 0)
                    <div class="px-4 py-3 border-t border-gray-100">
                        <a href="{{ route('admin.orders.index') }}" class="block text-center text-xs font-semibold text-primary hover:text-primary/80">
                            View all orders →
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Profile Dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center space-x-3 p-2 hover:bg-gray-50 rounded-xl transition-colors cursor-pointer">
                    @if(Auth::check() && Auth::user()->profile_picture)
                        <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}"
                             alt="Profile"
                             class="w-10 h-10 rounded-full object-cover">
                    @else
                        <div class="w-10 h-10 bg-linear-to-r from-primary to-primary/80 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-white"></i>
                        </div>
                    @endif
                    <div class="hidden md:block text-left">
                        <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name ?? 'Guest' }}</p>
                        <p class="text-xs text-gray-500">{{ Auth::check() ? ucfirst(Auth::user()->role) : 'Not logged in' }}</p>
                    </div>
                    <i class="fas fa-chevron-down text-gray-400 text-sm"></i>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="open"
                     @click.away="open = false"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-200 py-2 z-50"
                     style="display: none;">

                    @auth
                        <!-- Profile Link -->
                        <a href="{{ route('profile') }}" class="flex items-center space-x-3 px-4 py-2 text-gray-700 hover:bg-purple-50 transition-colors cursor-pointer">
                            <i class="fas fa-user-circle text-purple-600"></i>
                            <span class="font-medium">Profile</span>
                        </a>

                        <div class="border-t border-gray-200 my-2"></div>

                        <!-- Logout Form -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center space-x-3 px-4 py-2 text-red-600 hover:bg-red-50 transition-colors cursor-pointer">
                                <i class="fas fa-sign-out-alt"></i>
                                <span class="font-medium">Logout</span>
                            </button>
                        </form>
                    @else
                        <!-- Login Link -->
                        <a href="{{ route('login') }}" class="flex items-center space-x-3 px-4 py-2 text-gray-700 hover:bg-purple-50 transition-colors cursor-pointer">
                            <i class="fas fa-sign-in-alt text-purple-600"></i>
                            <span class="font-medium">Login</span>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</header>
