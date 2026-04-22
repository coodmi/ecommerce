@extends('layouts.dashboard')

@section('title', 'Orders Management')

@section('content')
<div class="p-6" x-data="{}">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
            <div>
                <h1 class="dash-title text-gray-900">Orders Management</h1>
                <p class="dash-subtitle mt-0.5">Track and manage customer orders</p>
            </div>
        </div>

    {{-- Search & Filter --}}
    <form method="GET" action="{{ route('admin.orders.index') }}" class="flex flex-col sm:flex-row gap-3 mb-6">
        <div class="relative flex-1">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search by order ID, customer name or email..."
                   class="w-full pl-9 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary shadow-sm bg-white">
        </div>
        <select name="status" class="bg-white border border-gray-200 rounded-xl text-sm text-gray-700 px-4 py-2.5 focus:outline-none focus:border-primary shadow-sm">
            <option value="">All Statuses</option>
            @foreach(['pending','processing','shipped','delivered','cancelled'] as $s)
                <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
        <button type="submit" class="px-5 py-2.5 bg-primary text-white rounded-xl text-sm font-medium hover:bg-primary/90 transition shadow-sm">
            Search
        </button>
        @if(request('search') || request('status'))
            <a href="{{ route('admin.orders.index') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-sm font-medium transition text-center">
                Clear
            </a>
        @endif
    </form>

    <!-- Orders Table -->
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Order ID</th>
                        <th class="px-6 py-5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-5 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($orders as $order)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-6 py-4">
                            <span class="font-black text-slate-900">#EA-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-900">{{ $order->checkout_details['full_name'] ?? ($order->user->name ?? 'Guest User') }}</div>
                            <div class="text-xs text-slate-400 font-medium">{{ $order->checkout_details['email'] ?? ($order->user->email ?? 'N/A') }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-black text-slate-900">${{ number_format($order->total_amount, 2) }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-amber-50 text-amber-600 rounded-full text-[10px] font-bold uppercase tracking-wider">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-500 font-medium">
                            {{ $order->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('order.invoice', $order) }}" 
                                   class="w-9 h-9 flex items-center justify-center bg-green-50 text-green-600 rounded-xl hover:bg-green-600 hover:text-white transition-all" title="Invoice">
                                    <i class="fas fa-file-invoice text-sm"></i>
                                </a>
                                <a href="{{ route('admin.orders.show', $order) }}" 
                                   class="w-9 h-9 flex items-center justify-center bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition-all" title="View">
                                    <i class="fas fa-eye text-sm"></i>
                                </a>
                                <button @click="$dispatch('confirm-modal', {
                                            type: 'danger',
                                            icon: 'fa-trash-can',
                                            title: 'Delete Order',
                                            message: 'Are you sure you want to delete this order? This action cannot be undone.',
                                            confirmText: 'Delete Now',
                                            ajax: true,
                                            url: '{{ route('admin.orders.destroy', $order) }}',
                                            method: 'DELETE'
                                        })" 
                                        class="w-9 h-9 flex items-center justify-center bg-red-50 text-red-600 rounded-xl hover:bg-red-600 hover:text-white transition-all">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-shopping-cart text-3xl text-slate-300"></i>
                                </div>
                                <h3 class="text-lg font-bold text-slate-900">No orders yet</h3>
                                <p class="text-slate-500 text-sm max-w-xs mx-auto mt-1">Orders will appear here once customers start purchasing.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-slate-50/50">
            {{ $orders->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
