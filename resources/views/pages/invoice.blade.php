@extends('layouts.app')

@section('title', 'Invoice #' . $order->id)

@section('content')
<div class="min-h-screen bg-gray-50 py-10 px-4">
    <div class="max-w-3xl mx-auto">

        {{-- Success Banner --}}
        <div class="bg-green-50 border border-green-200 rounded-2xl p-5 mb-6 flex items-center gap-4">
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fas fa-check-circle text-green-500 text-2xl"></i>
            </div>
            <div>
                <h2 class="text-lg font-bold text-green-800">Order Placed Successfully!</h2>
                <p class="text-sm text-green-600">Thank you for your order. Your invoice is below.</p>
            </div>
        </div>

        {{-- Invoice Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden" id="invoice-content">

            {{-- Header --}}
            <div class="relative bg-primary px-8 py-8 flex items-center justify-between overflow-hidden">
                {{-- Decorative white shapes --}}
                <div class="absolute -top-8 -left-8 w-40 h-40 bg-white/10 rounded-full"></div>
                <div class="absolute -bottom-10 left-24 w-28 h-28 bg-white/10 rounded-full"></div>
                <div class="absolute top-0 right-48 w-20 h-20 bg-white/10 rounded-full"></div>
                <div class="absolute -top-4 -right-4 w-32 h-32 bg-white/10 rounded-full"></div>

                <div class="relative z-10 flex items-center gap-4">
                    {{-- Simple white bg behind logo only --}}
                    @php
                        $brand = $globalHeaderConfig->get('brand', []);
                        $logo  = isset($brand['logo']) ? asset('storage/' . $brand['logo']) : asset('images/shankhobazar.png');
                    @endphp
                    <div class="bg-white rounded-xl p-2 shadow-sm">
                        <img src="{{ $logo }}" alt="Logo" class="h-10 w-auto object-contain">
                    </div>
                    <div>
                        <p class="text-white font-bold text-lg leading-tight">Shankhobazar</p>
                        <p class="text-white text-xs">Your trusted shopping destination</p>
                    </div>
                </div>

                <div class="relative z-10 text-right">
                    <p class="text-white text-3xl font-black tracking-widest">INVOICE</p>
                    <p class="text-white text-sm font-semibold mt-1">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
                </div>
            </div>

            <div class="px-8 py-6 space-y-6">

                {{-- Meta row --}}
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                    <div>
                        <p class="text-gray-400 text-xs uppercase tracking-wider mb-1">Order Date</p>
                        <p class="font-semibold text-gray-800">{{ $order->created_at->format('d M Y, h:i A') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs uppercase tracking-wider mb-1">Payment Method</p>
                        <p class="font-semibold text-gray-800">{{ $order->payment_method }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs uppercase tracking-wider mb-1">Status</p>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-yellow-50 text-yellow-700 border border-yellow-200 capitalize">
                            {{ $order->status }}
                        </span>
                    </div>
                </div>

                {{-- Billing Info --}}
                @if($order->checkout_details)
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs uppercase tracking-wider text-gray-400 font-semibold mb-3">Billing / Shipping Details</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm">
                        @foreach($order->checkout_details as $key => $value)
                            @if($value)
                            <div>
                                <span class="text-gray-400 capitalize">{{ str_replace('_', ' ', $key) }}:</span>
                                <span class="font-medium text-gray-700 ml-1">{{ $value }}</span>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Items Table --}}
                <div>
                    <p class="text-xs uppercase tracking-wider text-gray-400 font-semibold mb-3">Order Items</p>
                    <div class="border border-gray-100 rounded-xl overflow-hidden">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 border-b border-gray-100">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Product</th>
                                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Qty</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Price</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($order->items as $item)
                                <tr>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-3">
                                            @if($item->product?->primaryImage)
                                                <img src="{{ $item->product->primaryImage->url }}" class="w-10 h-10 rounded-lg object-cover border border-gray-100 flex-shrink-0">
                                            @else
                                                <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center flex-shrink-0">
                                                    <i class="fas fa-box text-gray-300 text-xs"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <p class="font-medium text-gray-800">{{ $item->product?->name ?? 'Product #'.$item->product_id }}</p>
                                                @if($item->color || $item->size)
                                                    <p class="text-xs text-gray-400">
                                                        @if($item->color) Color: {{ $item->color }} @endif
                                                        @if($item->color && $item->size) · @endif
                                                        @if($item->size) Size: {{ $item->size }} @endif
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-center text-gray-600">{{ $item->quantity }}</td>
                                    <td class="px-4 py-3 text-right text-gray-600">${{ number_format($item->price, 2) }}</td>
                                    <td class="px-4 py-3 text-right font-semibold text-gray-800">${{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Totals --}}
                <div class="flex justify-end">
                    <div class="w-full max-w-xs space-y-2 text-sm">
                        <div class="flex justify-between text-gray-500">
                            <span>Subtotal</span>
                            <span>${{ number_format($order->total_amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-500">
                            <span>Shipping</span>
                            <span class="text-green-600 font-medium">FREE</span>
                        </div>
                        <div class="flex justify-between font-bold text-gray-900 text-base border-t border-gray-100 pt-2">
                            <span>Total</span>
                            <span class="text-primary">${{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>

                {{-- Footer note --}}
                <div class="border-t border-gray-100 pt-4 text-center text-xs text-gray-400">
                    Thank you for shopping with us! For any queries, contact us at
                    <a href="mailto:info@ecomalpha.com" class="text-primary hover:underline">info@ecomalpha.com</a>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex flex-col sm:flex-row gap-3 mt-6 mb-16">
            <button onclick="window.print()"
                    class="flex-1 flex items-center justify-center gap-2 px-6 py-3 bg-primary hover:bg-primary/90 text-white rounded-xl font-semibold transition shadow-sm">
                <i class="fas fa-print"></i> Print Invoice
            </button>
            <a href="{{ route('user.orders') }}"
               class="flex-1 flex items-center justify-center gap-2 px-6 py-3 bg-white border border-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition">
                <i class="fas fa-shopping-bag"></i> My Orders
            </a>
            <a href="{{ route('shop') }}"
               class="flex-1 flex items-center justify-center gap-2 px-6 py-3 bg-white border border-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition">
                <i class="fas fa-store"></i> Continue Shopping
            </a>
        </div>
    </div>
</div>

<style>
@media print {
    body * { visibility: hidden; }
    #invoice-content, #invoice-content * { visibility: visible; }
    #invoice-content { position: absolute; left: 0; top: 0; width: 100%; }
    .bg-primary { background-color: #9333ea !important; -webkit-print-color-adjust: exact; }
}
</style>
@endsection
