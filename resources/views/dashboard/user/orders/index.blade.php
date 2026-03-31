@extends('layouts.dashboard')

@section('title', 'My Orders')

@section('content')

<div class="p-6" x-data="{
    activeOrder: null,
    formatDate(dateString) {
        if (!dateString) return '';
        const options = { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' };
        return new Date(dateString).toLocaleDateString('en-US', options);
    },
    formatPrice(price) {
        return '$' + parseFloat(price).toFixed(2);
    }
}">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-display font-bold text-gray-900">My Orders</h1>
        <p class="text-gray-600 mt-1">Track and view your order history</p>
    </div>

    <!-- Orders List -->
    <div class="space-y-6">
        @forelse($orders as $order)
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-shadow">
            <div class="p-8">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-6">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center">
                            <i class="fas fa-box text-2xl text-primary"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-slate-900 uppercase tracking-widest">
                                Order #EA-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                            </h3>
                            <p class="text-sm text-slate-500 font-medium">
                                Placed on {{ $order->created_at->format('M d, Y \a\t h:i A') }}
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="px-4 py-2 rounded-xl text-xs font-black uppercase tracking-widest
                            {{ $order->status === 'completed' ? 'bg-green-50 text-green-600' : '' }}
                            {{ $order->status === 'pending' ? 'bg-amber-50 text-amber-600' : '' }}
                            {{ $order->status === 'cancelled' ? 'bg-red-50 text-red-600' : '' }}
                        ">
                            {{ $order->status }}
                        </span>
                        <a href="{{ route('order.invoice', $order->id) }}"
                           class="px-5 py-3 bg-primary/10 text-primary rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-primary/20 transition-colors">
                            <i class="fas fa-file-invoice mr-1"></i> Invoice
                        </a>
                        <button @click="activeOrder = {{ $order->toJson() }}"
                                class="px-6 py-3 bg-slate-900 text-white rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-slate-800 transition-colors cursor-pointer">
                            View Details
                        </button>
                    </div>
                </div>

                <div class="border-t border-slate-50 pt-6">
                    <div class="flex items-center gap-4 overflow-x-auto pb-2 custom-scrollbar">
                        @foreach($order->items as $item)
                        <div class="relative group flex-shrink-0">
                            <div class="w-20 h-20 rounded-xl overflow-hidden bg-slate-50 border border-slate-100">
                                <img src="{{ $item->product->primaryImage ? (str_starts_with($item->product->primaryImage->image_path, 'http') ? $item->product->primaryImage->image_path : asset('storage/' . $item->product->primaryImage->image_path)) : asset('images/placeholder-product.jpg') }}"
                                     class="w-full h-full object-cover">
                            </div>
                            <div class="absolute -top-2 -right-2 w-6 h-6 bg-slate-900 text-white rounded-full flex items-center justify-center text-[10px] font-bold shadow-md">
                                {{ $item->quantity }}
                            </div>
                        </div>
                        @endforeach
                        @if($order->items->count() > 3)
                        <div class="w-20 h-20 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center flex-shrink-0">
                            <span class="text-slate-400 font-bold text-lg">+{{ $order->items->count() - 3 }}</span>
                        </div>
                        @endif
                    </div>
                    <div class="flex justify-between items-center mt-6">
                        <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Total Amount</p>
                        <p class="text-2xl font-black text-slate-900">${{ number_format($order->total_amount, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-20 bg-white rounded-[2.5rem] border border-gray-100 border-dashed">
            <div class="w-24 h-24 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-shopping-bag text-4xl text-primary/40"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">No orders yet</h3>
            <p class="text-gray-500 mb-8">Start shopping to see your orders here.</p>
            <a href="{{ route('shop') }}" class="inline-flex items-center space-x-2 px-8 py-4 bg-slate-900 text-white rounded-2xl font-bold uppercase tracking-widest text-xs hover:bg-slate-800 transition-all hover:-translate-y-1 shadow-xl shadow-slate-900/10">
                <span>Start Shopping</span>
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        @endforelse

        <div class="mt-8">
            {{ $orders->links() }}
        </div>
    </div>

    <!-- Order Details Modal -->
    <div x-show="activeOrder"
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">

        <!-- Backdrop -->
        <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity" @click="activeOrder = null"></div>

        <div class="flex items-center justify-center min-h-full p-4 text-center sm:p-0">
            <div class="relative bg-white rounded-[2.5rem] text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-3xl sm:w-full"
                 x-show="activeOrder"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

                <!-- Modal Header -->
                <div class="bg-slate-50 px-8 py-6 border-b border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center">
                            <i class="fas fa-receipt text-primary"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-slate-900 uppercase tracking-widest">
                                Order Details
                            </h3>
                            <p class="text-xs text-slate-500 font-bold uppercase tracking-wider mt-1">
                                #EA-<span x-text="String(activeOrder?.id).padStart(5, '0')"></span>
                            </p>
                        </div>
                    </div>
                    <button @click="activeOrder = null" class="w-8 h-8 flex items-center justify-center bg-white rounded-full text-slate-400 hover:text-red-500 hover:bg-red-50 transition-all shadow-sm">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <!-- Modal Content -->
                <div class="px-8 py-6 max-h-[70vh] overflow-y-auto custom-scrollbar">
                    <div class="grid md:grid-cols-2 gap-8 mb-8">
                        <div>
                            <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">Order Information</h4>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-sm font-medium text-slate-600">Date Placed</span>
                                    <span class="text-sm font-bold text-slate-900" x-text="formatDate(activeOrder?.created_at)"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm font-medium text-slate-600">Payment Method</span>
                                    <span class="text-sm font-bold text-slate-900" x-text="activeOrder?.payment_method"></span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-slate-600">Status</span>
                                    <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest"
                                          :class="{
                                              'bg-green-50 text-green-600': activeOrder?.status === 'completed',
                                              'bg-amber-50 text-amber-600': activeOrder?.status === 'pending',
                                              'bg-red-50 text-red-600': activeOrder?.status === 'cancelled'
                                          }"
                                          x-text="activeOrder?.status">
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">Shipping Details</h4>
                            <template x-if="activeOrder?.checkout_details">
                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-sm font-medium text-slate-600">Full Name</span>
                                        <span class="text-sm font-bold text-slate-900" x-text="activeOrder.checkout_details.full_name"></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm font-medium text-slate-600">Phone</span>
                                        <span class="text-sm font-bold text-slate-900" x-text="activeOrder.checkout_details.phone"></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm font-medium text-slate-600">City</span>
                                        <span class="text-sm font-bold text-slate-900" x-text="activeOrder.checkout_details.city"></span>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-slate-600 block mb-1">Address</span>
                                        <span class="text-sm font-bold text-slate-900" x-text="activeOrder.checkout_details.address"></span>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="border-t border-slate-100 pt-8">
                        <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6">Order Items</h4>
                        <div class="space-y-4">
                            <template x-for="item in activeOrder?.items" :key="item.id">
                                <div class="flex items-center gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-100">
                                    <div class="w-16 h-16 rounded-xl overflow-hidden bg-white shrink-0">
                                        <img :src="item.product?.primary_image?.image_path
                                                ? (item.product.primary_image.image_path.startsWith('http')
                                                    ? item.product.primary_image.image_path
                                                    : '/storage/' + item.product.primary_image.image_path)
                                                : '/images/placeholder-product.jpg'"
                                             class="w-full h-full object-cover">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h5 class="font-bold text-slate-900 text-sm truncate" x-text="item.product?.name"></h5>
                                        <p class="text-xs text-slate-500 font-medium mt-1">
                                            Qty: <span x-text="item.quantity"></span> x <span x-text="formatPrice(item.price)"></span>
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-black text-slate-900" x-text="formatPrice(item.price * item.quantity)"></p>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="bg-slate-50 px-8 py-6 border-t border-slate-100 flex justify-between items-center">
                    <span class="text-xs font-black text-slate-400 uppercase tracking-widest">Total Amount Paid</span>
                    <span class="text-2xl font-black text-slate-900" x-text="formatPrice(activeOrder?.total_amount)"></span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.custom-scrollbar::-webkit-scrollbar {
    height: 4px;
    width: 4px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #e2e8f0;
    border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #cbd5e1;
}
</style>
@endsection
