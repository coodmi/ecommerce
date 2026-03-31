@extends('layouts.dashboard')

@section('title', 'Order Details')

@section('content')
<div class="p-6">
    <!-- Page Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <a href="{{ route('admin.orders.index') }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-700 mb-2 inline-block">
                <i class="fas fa-arrow-left mr-1"></i> Back to Orders
            </a>
            <h1 class="text-3xl font-display font-bold text-gray-900">Order #EA-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h1>
            <p class="text-gray-600 mt-1">Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>
        </div>

        <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="flex flex-col sm:flex-row items-center gap-4">
            @csrf
            @method('PUT')
            <div class="relative w-full sm:w-auto">
                <select name="status"
                        class="appearance-none pl-6 pr-10 py-3 w-full sm:w-auto rounded-2xl font-black uppercase tracking-widest text-xs border-2 cursor-pointer outline-none focus:ring-2 focus:ring-offset-2 transition-all
                        {{ $order->status === 'completed' || $order->status === 'delivered' ? 'bg-green-50 text-green-600 border-green-100 focus:ring-green-500' : '' }}
                        {{ $order->status === 'pending' ? 'bg-amber-50 text-amber-600 border-amber-100 focus:ring-amber-500' : '' }}
                        {{ $order->status === 'processing' ? 'bg-blue-50 text-blue-600 border-blue-100 focus:ring-blue-500' : '' }}
                        {{ $order->status === 'shipped' ? 'bg-primary/10 text-primary border-primary/20 focus:ring-primary' : '' }}
                        {{ $order->status === 'cancelled' ? 'bg-red-50 text-red-600 border-red-100 focus:ring-red-500' : '' }}">
                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                <i class="fas fa-chevron-down absolute right-4 top-1/2 transform -translate-y-1/2 pointer-events-none opacity-50"></i>
            </div>
            <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-slate-900 text-white rounded-xl font-black uppercase tracking-widest text-[10px] hover:bg-slate-800 transition-all cursor-pointer shadow-lg shadow-slate-900/10 hover:shadow-xl hover:-translate-y-0.5">
                Update Status
            </button>
        </form>
    </div>

    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
         class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center justify-between" role="alert">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
        <button @click="show = false" class="text-green-500 hover:text-green-700">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Order Items -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 overflow-hidden">
                <div class="p-8 border-b border-gray-50 flex items-center justify-between">
                    <h2 class="text-xl font-black text-slate-900 uppercase tracking-widest">Order Items</h2>
                    <span class="px-4 py-1 bg-slate-100 text-slate-600 rounded-full text-[10px] font-black uppercase tracking-wider">
                        {{ $order->items->count() }} Products
                    </span>
                </div>
                <div class="divide-y divide-gray-50">
                    @foreach($order->items as $item)
                    <div class="p-8 flex items-center gap-6">
                        <div class="w-20 h-20 rounded-2xl overflow-hidden bg-slate-50 flex-shrink-0 border border-slate-100">
                            <img src="{{ $item->product->primaryImage ? (str_starts_with($item->product->primaryImage->image_path, 'http') ? $item->product->primaryImage->image_path : asset('storage/' . $item->product->primaryImage->image_path)) : asset('images/placeholder-product.jpg') }}"
                                 class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold text-slate-900 uppercase tracking-widest text-sm truncate">{{ $item->product->name }}</h3>
                            <div class="flex flex-wrap gap-2 mt-1">
                                @if($item->color)
                                <span class="px-2 py-0.5 bg-slate-100 text-slate-500 text-[10px] font-bold rounded uppercase">Color: {{ $item->color }}</span>
                                @endif
                                @if($item->size)
                                <span class="px-2 py-0.5 bg-slate-100 text-slate-500 text-[10px] font-bold rounded uppercase">Size: {{ $item->size }}</span>
                                @endif
                                <span class="text-[10px] text-slate-400 font-medium px-2 py-0.5">Unit Price: ${{ number_format($item->price, 2) }}</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-xs text-slate-400 font-black uppercase tracking-widest mb-1">Qty: {{ $item->quantity }}</div>
                            <div class="font-black text-slate-900">${{ number_format($item->price * $item->quantity, 2) }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <!-- Summary -->
                <div class="p-8 bg-slate-50 border-t border-gray-100">
                    <div class="flex justify-between items-center text-lg">
                        <span class="font-black text-slate-900 uppercase tracking-widest">Total Amount Paid</span>
                        <span class="text-3xl font-black text-slate-900">${{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Dynamic Checkout Details -->
            <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 p-8">
                <h2 class="text-xl font-black text-slate-900 uppercase tracking-widest mb-8">Customer Submission</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @foreach($order->checkout_details as $label => $value)
                    <div class="space-y-1">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ str_replace('_', ' ', $label) }}</p>
                        <p class="text-slate-900 font-bold text-lg">{{ $value ?: '—' }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Order Summary & Side Info -->
        <div class="space-y-6">
            <div class="bg-slate-900 rounded-[2.5rem] p-10 text-white shadow-2xl">
                <h2 class="text-xl font-black uppercase tracking-tight mb-8">Payment Info</h2>
                <div class="space-y-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center">
                            <i class="fas fa-wallet text-amber-500"></i>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest">Method</p>
                            <p class="font-bold text-sm">{{ $order->payment_method }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-green-500/10 flex items-center justify-center">
                            <i class="fas fa-check-double text-green-500"></i>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest">Payment Status</p>
                            <p class="font-bold text-sm text-green-400 uppercase tracking-widest">Pending Verification</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[2.5rem] p-8 border border-gray-100 shadow-xl">
                <h2 class="text-xl font-black text-slate-900 uppercase tracking-widest mb-6">Internal Notes</h2>
                <form action="{{ route('admin.orders.update-notes', $order) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <textarea name="notes" class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl p-4 text-sm font-medium focus:border-indigo-500 outline-none transition-all h-32" placeholder="Add some notes about this order...">{{ $order->notes }}</textarea>
                    <button type="submit" class="mt-4 w-full py-3 bg-slate-900 text-white rounded-xl font-black uppercase tracking-widest text-[10px] hover:bg-slate-800 transition-all cursor-pointer">
                        Save Notes
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
