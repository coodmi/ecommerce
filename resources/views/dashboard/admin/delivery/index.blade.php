@extends('layouts.dashboard')

@section('title', 'Delivery Charges')

@section('content')
<div class="p-6 space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="dash-title text-gray-900">Delivery Charges</h1>
            <p class="dash-subtitle mt-0.5">Set per-product delivery charges. Leave blank to use the global default.</p>
        </div>
        <a href="{{ route('admin.settings.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-50 transition">
            <i class="fas fa-cog text-primary text-xs"></i> Global Settings
        </a>
    </div>

    @if(session('success'))
    <div class="flex items-center gap-2 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
    @endif

    {{-- Global defaults info --}}
    <div class="bg-blue-50 border border-blue-100 rounded-xl px-4 py-3 text-sm text-blue-700 flex flex-wrap gap-4">
        <span><i class="fas fa-info-circle mr-1"></i> Global default:</span>
        <span class="font-semibold">{{ $globalLabel }}: ৳{{ number_format($globalCharge, 0) }}</span>
        @if($globalFreeThreshold > 0)
        <span>· Free above <span class="font-semibold">৳{{ number_format($globalFreeThreshold, 0) }}</span></span>
        @endif
        <a href="{{ route('admin.settings.index') }}" class="text-blue-600 underline hover:text-blue-800">Change global</a>
    </div>

    {{-- Search --}}
    <form method="GET" class="flex gap-3">
        <div class="relative flex-1 max-w-md">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
            <input type="text" name="search" value="{{ $search }}"
                   placeholder="Search products..."
                   class="w-full pl-9 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary shadow-sm bg-white">
        </div>
        <button type="submit" class="px-5 py-2.5 bg-primary text-white rounded-xl text-sm font-medium hover:bg-primary/90 transition shadow-sm">
            Search
        </button>
        @if($search)
        <a href="{{ route('admin.delivery.index') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-sm font-medium transition">
            Clear
        </a>
        @endif
    </form>

    {{-- Bulk update form --}}
    <form method="POST" action="{{ route('admin.delivery.bulk') }}">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Product</th>
                            <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Category</th>
                            <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Base Price</th>
                            <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-48">
                                Delivery Charge ($)
                                <span class="text-gray-400 font-normal normal-case ml-1">blank = global</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($products as $product)
                        <tr class="hover:bg-gray-50/60 transition">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    @if($product->primaryImage)
                                        <img src="{{ $product->primaryImage->url }}" class="w-10 h-10 rounded-lg object-cover border border-gray-100 flex-shrink-0">
                                    @else
                                        <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-box text-gray-300 text-xs"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-semibold text-gray-800 text-sm">{{ $product->name }}</p>
                                        <p class="text-xs text-gray-400">SKU: {{ $product->sku ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-gray-500 text-xs">{{ $product->category->name ?? '—' }}</td>
                            <td class="px-5 py-3.5 font-semibold text-gray-800">৳{{ number_format($product->base_price, 0) }}</td>
                            <td class="px-5 py-3.5">
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs">৳</span>
                                    <input type="number"
                                           name="charges[{{ $product->id }}]"
                                           value="{{ $product->delivery_charge !== null ? number_format($product->delivery_charge, 2, '.', '') : '' }}"
                                           min="0" step="0.01"
                                           placeholder="{{ number_format($globalCharge, 2) }}"
                                           class="w-full pl-6 pr-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20 bg-white">
                                </div>
                                @if($product->delivery_charge !== null)
                                <p class="text-xs text-primary mt-0.5 font-medium">Custom: ${{ number_format($product->delivery_charge, 2) }}</p>
                                @else
                                <p class="text-xs text-gray-400 mt-0.5">Using global</p>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-5 py-12 text-center text-gray-400">
                                <i class="fas fa-box text-3xl mb-3 block opacity-20"></i>
                                No products found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($products->count() > 0)
            <div class="px-5 py-4 bg-gray-50 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-3">
                <div class="text-xs text-gray-500">
                    Showing {{ $products->firstItem() }}–{{ $products->lastItem() }} of {{ $products->total() }} products
                </div>
                <button type="submit"
                        class="px-6 py-2.5 bg-primary text-white rounded-xl text-sm font-semibold hover:bg-primary/90 transition shadow-sm">
                    <i class="fas fa-save mr-1.5"></i> Save All Changes
                </button>
            </div>
            @endif
        </div>
    </form>

    {{-- Pagination --}}
    @if($products->hasPages())
    <div class="flex justify-center">
        {{ $products->links() }}
    </div>
    @endif

</div>
@endsection
