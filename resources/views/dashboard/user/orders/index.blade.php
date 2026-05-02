@extends('layouts.dashboard')

@section('title', 'My Orders')

@section('content')
<div class="p-6">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-gray-900">My Orders</h1>
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
        $activeTab = $status ?: 'all';
    @endphp

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden mb-6">
        <div class="flex overflow-x-auto no-scrollbar border-b border-gray-200">
            @foreach($tabs as $key => $label)
            @php $count = $counts[$key] ?? 0; @endphp
            <a href="{{ route('user.orders', ['status' => $key === 'all' ? null : $key]) }}"
               class="flex-shrink-0 px-5 py-3 text-sm font-medium whitespace-nowrap transition-colors
                      {{ $activeTab === $key
                          ? 'bg-white text-gray-900 font-semibold border-b-2 border-gray-900 -mb-px'
                          : 'text-gray-500 hover:text-gray-700' }}">
                {{ $label }} ({{ $count }})
            </a>
            @endforeach
        </div>

        {{-- Table --}}
        <div class="p-5">
            <div class="mb-3">
                <p class="text-sm font-semibold text-gray-700">Orders</p>
                <p class="text-xs text-gray-400">Manage and track your orders</p>
            </div>

            @if($orders->count())
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="text-left py-3 pr-4 text-xs font-semibold text-gray-600 whitespace-nowrap">Order Number</th>
                            <th class="text-left py-3 pr-4 text-xs font-semibold text-gray-600">Date</th>
                            <th class="text-left py-3 pr-4 text-xs font-semibold text-gray-600">Shipping Address</th>
                            <th class="text-left py-3 pr-4 text-xs font-semibold text-gray-600">Total</th>
                            <th class="text-left py-3 pr-4 text-xs font-semibold text-gray-600">Status</th>
                            <th class="text-right py-3 text-xs font-semibold text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($orders as $order)
                        @php
                            $details = $order->checkout_details ?? [];
                            $name    = $details['full_name'] ?? ($details['name'] ?? '');
                            $phone   = $details['phone'] ?? '';
                            $address = $details['full_address'] ?? ($details['address'] ?? '');
                            $addressSnippet = collect([$name ? 'Name: '.$name : null, $phone ? 'Phone: '.$phone : null, $address])
                                ->filter()->implode(', ');
                            $statusColors = [
                                'pending'    => 'bg-amber-100 text-amber-700',
                                'processing' => 'bg-blue-100 text-blue-700',
                                'shipped'    => 'bg-indigo-100 text-indigo-700',
                                'delivered'  => 'bg-green-100 text-green-700',
                                'completed'  => 'bg-green-100 text-green-700',
                                'cancelled'  => 'bg-red-100 text-red-700',
                                'on_hold'    => 'bg-gray-100 text-gray-600',
                                'returned'   => 'bg-orange-100 text-orange-700',
                                'refunded'   => 'bg-purple-100 text-purple-700',
                            ];
                            $badgeClass = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-600';
                        @endphp
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-4 pr-4 font-bold text-gray-900 whitespace-nowrap">
                                NBR{{ $order->created_at->format('Y') }}{{ str_pad($order->id, 8, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="py-4 pr-4 text-gray-500 whitespace-nowrap">
                                {{ $order->created_at->format('n/j/y') }}
                            </td>
                            <td class="py-4 pr-4 text-gray-500 max-w-[220px]">
                                <span class="truncate block" title="{{ $addressSnippet }}">
                                    {{ Str::limit($addressSnippet, 45) }}
                                </span>
                            </td>
                            <td class="py-4 pr-4 whitespace-nowrap">
                                <span class="font-semibold text-gray-900">৳{{ number_format($order->total_amount, 0) }}</span>
                                <span class="block text-xs text-gray-400">{{ $order->items->count() }} {{ Str::plural('item', $order->items->count()) }}</span>
                            </td>
                            <td class="py-4 pr-4">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold capitalize {{ $badgeClass }}">
                                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                </span>
                            </td>
                            <td class="py-4 text-right">
                                <a href="{{ route('order.invoice', $order->id) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 border border-gray-200 rounded-lg text-xs font-medium text-gray-600 hover:bg-gray-50 transition-colors">
                                    <i class="fas fa-eye text-xs"></i> View
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-5">
                {{ $orders->links() }}
            </div>

            @else
            <div class="text-center py-16">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-shopping-bag text-2xl text-gray-300"></i>
                </div>
                <p class="text-sm font-semibold text-gray-500">No orders found</p>
                <a href="{{ route('shop') }}" class="mt-4 inline-block text-xs font-semibold text-primary hover:underline">
                    Start Shopping →
                </a>
            </div>
            @endif
        </div>
    </div>

</div>
@endsection
