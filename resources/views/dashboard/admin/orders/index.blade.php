@extends('layouts.dashboard')

@section('title', 'Orders Management')

@section('content')
<div class="p-6">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="dash-title text-gray-900">Orders Management</h1>
            <p class="dash-subtitle mt-0.5">Track and manage customer orders</p>
        </div>
        <span class="text-sm text-gray-400">{{ $counts['all'] }} {{ Str::plural('order', $counts['all']) }}</span>
    </div>

    {{-- Status Tabs --}}
    @php
        $tabs = [
            'all'        => 'All',
            'processing' => 'Processing',
            'shipped'    => 'Shipped',
            'delivered'  => 'Delivered',
            'cancelled'  => 'Cancelled',
            'on_hold'    => 'Holded',
        ];
        $activeTab = request('status') ?: 'all';
    @endphp

    <div class="flex overflow-x-auto no-scrollbar bg-white rounded-xl border border-gray-200 mb-4">
        @foreach($tabs as $key => $label)
        @php $count = $counts[$key] ?? 0; @endphp
        <a href="{{ route('admin.orders.index', array_merge(request()->except('status','page'), $key !== 'all' ? ['status' => $key] : [])) }}"
           class="flex-shrink-0 px-5 py-3 text-sm font-medium whitespace-nowrap transition-colors
                  {{ $activeTab === $key
                      ? 'text-gray-900 font-semibold border-b-2 border-gray-900'
                      : 'text-gray-500 hover:text-gray-700' }}">
            {{ $label }} ({{ $count }})
        </a>
        @endforeach
    </div>

    {{-- Search --}}
    <form method="GET" action="{{ route('admin.orders.index') }}" class="flex gap-3 mb-4">
        @if(request('status'))
            <input type="hidden" name="status" value="{{ request('status') }}">
        @endif
        <div class="relative flex-1">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search by order ID, customer name or email..."
                   class="w-full pl-9 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary bg-white">
        </div>
        <button type="submit" class="px-5 py-2.5 bg-primary text-white rounded-xl text-sm font-semibold hover:bg-primary/90 transition">
            Search
        </button>
        @if(request('search'))
            <a href="{{ route('admin.orders.index', request('status') ? ['status' => request('status')] : []) }}"
               class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-sm font-medium transition text-center">
                Clear
            </a>
        @endif
    </form>

    {{-- Table Card --}}
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="p-5 border-b border-gray-100">
            <p class="text-sm font-semibold text-gray-700">Orders</p>
            <p class="text-xs text-gray-400">Manage and track customer orders</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50">
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-600 whitespace-nowrap">Order Number</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-600">Customer</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-600">Date</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-600">Shipping Address</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-600">Total</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-600">Status</th>
                        <th class="text-right px-5 py-3 text-xs font-semibold text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($orders as $order)
                    @php
                        $details = $order->checkout_details ?? [];
                        $name    = $details['full_name'] ?? ($order->user->name ?? 'Guest');
                        $email   = $details['email'] ?? ($order->user->email ?? '');
                        $phone   = $details['phone'] ?? '';
                        $address = $details['full_address'] ?? ($details['address'] ?? '');
                        $addressSnippet = collect([
                            $name    ? 'Name: '.$name    : null,
                            $phone   ? 'Phone: '.$phone  : null,
                            $address ?: null,
                        ])->filter()->implode(', ');

                        $statusColors = [
                            'pending'    => 'bg-amber-100 text-amber-700',
                            'processing' => 'bg-blue-100 text-blue-700',
                            'shipped'    => 'bg-indigo-100 text-indigo-700',
                            'delivered'  => 'bg-green-100 text-green-700',
                            'completed'  => 'bg-green-100 text-green-700',
                            'cancelled'  => 'bg-red-100 text-red-700',
                            'on_hold'    => 'bg-gray-100 text-gray-600',
                        ];
                        $badgeClass = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-600';
                    @endphp
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-5 py-4 font-bold text-gray-900 whitespace-nowrap">
                            NBR{{ $order->created_at->format('Y') }}{{ str_pad($order->id, 8, '0', STR_PAD_LEFT) }}
                        </td>
                        <td class="px-5 py-4">
                            <p class="font-semibold text-gray-900">{{ $name }}</p>
                            @if($email)
                            <p class="text-xs text-gray-400">{{ $email }}</p>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-gray-500 whitespace-nowrap">
                            {{ $order->created_at->format('n/j/y') }}
                        </td>
                        <td class="px-5 py-4 text-gray-500 max-w-[200px]">
                            <span class="truncate block" title="{{ $addressSnippet }}">
                                {{ Str::limit($addressSnippet, 45) }}
                            </span>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <span class="font-semibold text-gray-900">৳{{ number_format($order->total_amount, 0) }}</span>
                        </td>
                        <td class="px-5 py-4">
                            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                                @csrf @method('PUT')
                                <select name="status" onchange="this.form.submit()"
                                        class="px-2 py-1 rounded-full text-xs font-semibold border-0 focus:outline-none focus:ring-2 focus:ring-primary cursor-pointer {{ $badgeClass }}">
                                    @foreach(['pending','processing','shipped','delivered','completed','cancelled','on_hold'] as $s)
                                    <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('_', ' ', $s)) }}
                                    </option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td class="px-5 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('order.invoice', $order) }}"
                                   class="w-8 h-8 flex items-center justify-center bg-green-50 text-green-600 rounded-lg hover:bg-green-600 hover:text-white transition-all" title="Invoice">
                                    <i class="fas fa-file-invoice text-xs"></i>
                                </a>
                                <a href="{{ route('admin.orders.show', $order) }}"
                                   class="w-8 h-8 flex items-center justify-center bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-600 hover:text-white transition-all" title="View">
                                    <i class="fas fa-eye text-xs"></i>
                                </a>
                                <button @click="$dispatch('confirm-modal', {
                                            type: 'danger',
                                            icon: 'fa-trash-can',
                                            title: 'Delete Order',
                                            message: 'Are you sure you want to delete this order?',
                                            confirmText: 'Delete',
                                            ajax: true,
                                            url: '{{ route('admin.orders.destroy', $order) }}',
                                            method: 'DELETE'
                                        })"
                                        class="w-8 h-8 flex items-center justify-center bg-red-50 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition-all">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-5 py-16 text-center">
                            <div class="w-14 h-14 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-shopping-cart text-2xl text-gray-300"></i>
                            </div>
                            <p class="text-sm font-semibold text-gray-500">No orders found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $orders->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
