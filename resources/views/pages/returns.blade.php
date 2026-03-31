@extends('layouts.app')

@section('title', 'My Returns - ' . config('app.name'))

@section('content')

<!-- Hero -->
<section class="relative text-white py-14 overflow-hidden" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);">
    <div class="container mx-auto px-4 relative z-10">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-full flex items-center justify-center flex-shrink-0" style="background: var(--primary-color)">
                <i class="fas fa-undo-alt text-white"></i>
            </div>
            <div>
                <h1 class="text-2xl md:text-3xl font-display font-bold">My Returns</h1>
                <nav class="text-sm text-gray-400 mt-1">
                    <a href="/" class="hover:text-white transition">Home</a>
                    <span class="mx-2">/</span>
                    <span class="text-white">Returns</span>
                </nav>
            </div>
        </div>
    </div>
</section>

<section class="py-12 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 max-w-5xl">

        @guest
        <!-- Not logged in -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-16 text-center">
            <div class="w-20 h-20 rounded-full bg-primary/10 flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-lock text-3xl" style="color: var(--primary-color)"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Login Required</h3>
            <p class="text-gray-500 mb-6">Please login to view your return requests.</p>
            <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-6 py-3 text-white rounded-xl font-semibold transition" style="background: var(--primary-color)">
                <i class="fas fa-sign-in-alt"></i> Login
            </a>
        </div>
        @else

        <!-- Stats -->
        <div class="grid grid-cols-3 gap-3 mb-8">
            @foreach([
                ['label' => 'Total Returns', 'value' => $totalReturns, 'icon' => 'fa-undo-alt', 'color' => 'blue'],
                ['label' => 'Pending', 'value' => $pendingReturns, 'icon' => 'fa-clock', 'color' => 'amber'],
                ['label' => 'Completed', 'value' => $completedReturns, 'icon' => 'fa-check-circle', 'color' => 'green'],
            ] as $stat)
            <div class="bg-white rounded-xl p-3 md:p-4 shadow-sm border border-gray-100 text-center">
                <div class="w-9 h-9 md:w-10 md:h-10 rounded-full bg-{{ $stat['color'] }}-100 flex items-center justify-center mx-auto mb-2">
                    <i class="fas {{ $stat['icon'] }} text-sm text-{{ $stat['color'] }}-500"></i>
                </div>
                <p class="text-xl md:text-2xl font-bold text-gray-900">{{ $stat['value'] }}</p>
                <p class="text-[10px] md:text-xs text-gray-500 leading-tight">{{ $stat['label'] }}</p>
            </div>
            @endforeach
        </div>

        <!-- Returns List -->
        @if($returnOrders->count() > 0)
        <div class="space-y-4">
            @foreach($returnOrders as $order)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0" style="background: var(--primary-color)20">
                                <i class="fas fa-undo-alt" style="color: var(--primary-color)"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900">Order #EA-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h3>
                                <p class="text-xs text-gray-500">Placed {{ $order->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase
                                @if($order->status === 'returned') bg-blue-50 text-blue-600
                                @elseif($order->status === 'refunded') bg-green-50 text-green-600
                                @elseif($order->status === 'return_requested') bg-amber-50 text-amber-600
                                @else bg-gray-100 text-gray-600 @endif">
                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                            </span>
                            <span class="font-bold text-gray-900">${{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>

                    <!-- Items -->
                    <div class="flex gap-3 overflow-x-auto pb-2">
                        @foreach($order->items as $item)
                        <div class="flex-shrink-0 flex items-center gap-2 bg-gray-50 rounded-xl p-2 min-w-0">
                            <div class="w-12 h-12 rounded-lg overflow-hidden flex-shrink-0">
                                <img src="{{ $item->product && $item->product->primaryImage
                                    ? (str_starts_with($item->product->primaryImage->image_path, 'http')
                                        ? $item->product->primaryImage->image_path
                                        : asset('storage/' . $item->product->primaryImage->image_path))
                                    : asset('images/placeholder-product.jpg') }}"
                                     class="w-full h-full object-cover" alt="">
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs font-medium text-gray-800 truncate max-w-[100px]">{{ $item->product->name ?? 'Product' }}</p>
                                <p class="text-xs text-gray-500">Qty: {{ $item->quantity }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach

            <div class="mt-6">{{ $returnOrders->links() }}</div>
        </div>

        @else
        <!-- Empty state -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 pt-16 pb-12 px-8 text-center">
            <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-box-open text-3xl text-gray-300"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">No Returns Yet</h3>
            <p class="text-gray-500 mb-6">You haven't requested any returns. If you need to return an item, go to your orders.</p>
            <a href="{{ route('user.orders') }}" class="inline-flex items-center gap-2 px-6 py-3 text-white rounded-xl font-semibold transition" style="background: var(--primary-color)">
                <i class="fas fa-shopping-bag"></i> View My Orders
            </a>
        </div>
        @endif

        <!-- How to Return -->
        <div class="mt-10 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-info-circle" style="color: var(--primary-color)"></i>
                How to Request a Return
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach([
                    ['step' => '01', 'title' => 'Go to My Orders', 'desc' => 'Find the delivered order you want to return.'],
                    ['step' => '02', 'title' => 'Contact Support', 'desc' => 'Reach out via the Contact page with your order number.'],
                    ['step' => '03', 'title' => 'Get Refund', 'desc' => 'Once approved, refund is processed in 5-7 business days.'],
                ] as $step)
                <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-xl">
                    <span class="font-bold text-lg flex-shrink-0" style="color: var(--primary-color)">{{ $step['step'] }}</span>
                    <div>
                        <p class="font-semibold text-gray-900 text-sm">{{ $step['title'] }}</p>
                        <p class="text-gray-500 text-xs mt-0.5">{{ $step['desc'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        @endguest
    </div>
</section>

@endsection
