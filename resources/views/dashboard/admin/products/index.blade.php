@extends('layouts.dashboard')

@section('title', 'Products Management')

@section('content')
<div class="p-6" x-data="{}">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
        <h1 class="dash-title text-gray-900">Products Management</h1>
            <p class="text-gray-600 mt-1">Manage your product inventory</p>
        </div>
        <a href="{{ route('admin.products.create') }}"
           class="px-6 py-3 bg-primary text-white rounded-xl font-bold hover:bg-primary/90 transition-all">
            <i class="fas fa-plus mr-2"></i>Add Product
        </a>
    </div>

    {{-- Search bar --}}
    <form method="GET" action="{{ route('admin.products.index') }}" class="flex gap-3 mb-6">
        <div class="relative flex-1 max-w-md">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search by name, SKU, category or brand..."
                   class="w-full pl-9 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary shadow-sm bg-white">
        </div>
        <button type="submit" class="px-5 py-2.5 bg-primary text-white rounded-xl text-sm font-medium hover:bg-primary/90 transition shadow-sm">
            Search
        </button>
        @if(request('search'))
            <a href="{{ route('admin.products.index') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-sm font-medium transition">
                Clear
            </a>
        @endif
    </form>

    <!-- Products Table -->
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100" x-data>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Image</th>
                        <th class="px-6 py-5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Brand</th>
                        <th class="px-6 py-5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Colors</th>
                        <th class="px-6 py-5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Sizes</th>
                        <th class="px-6 py-5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Stock</th>
                        <th class="px-6 py-5 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($products as $product)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="relative w-16 h-16 rounded-2xl overflow-hidden shadow-sm border border-gray-100 group-hover:shadow-md transition-all">
                                @php
                                    $displayImage = $product->primaryImage ?? $product->images->first();
                                @endphp

                                @if($displayImage)
                                    <img src="{{ $displayImage->url }}"
                                         alt="{{ $product->name }}"
                                         class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-400">
                                        <i class="fas fa-image text-xl"></i>
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-900 group-hover:text-purple-600 transition-colors">{{ $product->name }}</div>
                            <div class="text-xs text-slate-400 font-medium">SKU: {{ $product->sku ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-black text-slate-900">${{ number_format($product->base_price, 2) }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-[10px] font-bold uppercase tracking-wider">
                                {{ $product->category->name }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($product->brand)
                                <span class="px-3 py-1 bg-rose-50 text-rose-600 rounded-full text-[10px] font-bold uppercase tracking-wider">
                                    {{ $product->brand->name }}
                                </span>
                            @else
                                <span class="text-[10px] text-slate-300 font-bold uppercase tracking-wider">No Brand</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($product->colors->count() > 0)
                            <div class="flex flex-wrap gap-1.5">
                                @foreach($product->colors->take(3) as $color)
                                <div class="w-5 h-5 rounded-full border-2 border-white shadow-sm ring-1 ring-gray-100"
                                     style="background-color: {{ $color->color_code }}"
                                     title="{{ $color->color_name }}"></div>
                                @endforeach
                                @if($product->colors->count() > 3)
                                <span class="text-[10px] font-bold text-slate-400">+{{ $product->colors->count() - 3 }}</span>
                                @endif
                            </div>
                            @else
                            <span class="text-[10px] text-slate-300 font-bold uppercase">None</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($product->sizes->count() > 0)
                            <div class="flex flex-wrap gap-1">
                                @foreach($product->sizes->take(3) as $size)
                                <span class="px-2 py-0.5 bg-slate-100 text-slate-600 rounded-md text-[10px] font-bold uppercase">
                                    {{ $size->size_name }}
                                </span>
                                @endforeach
                                @if($product->sizes->count() > 3)
                                <span class="text-[10px] font-bold text-slate-400">+{{ $product->sizes->count() - 3 }}</span>
                                @endif
                            </div>
                            @else
                            <span class="text-[10px] text-slate-300 font-bold uppercase">None</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($product->stock_quantity > 10)
                                <span class="text-slate-900 font-bold">{{ $product->stock_quantity }}</span>
                            @elseif($product->stock_quantity > 0)
                                <span class="text-orange-600 font-bold">{{ $product->stock_quantity }} Low</span>
                            @else
                                <span class="text-red-600 font-bold">Out</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('admin.products.edit', $product) }}"
                                   class="w-9 h-9 flex items-center justify-center bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-600 hover:text-white transition-all">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>
                                <form id="deleteForm{{ $product->id }}"
                                      action="{{ route('admin.products.destroy', $product) }}"
                                      method="POST"
                                      class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button type="button"
                                        @click="$dispatch('confirm-modal', {
                                            type: 'danger',
                                            icon: 'fa-trash-alt',
                                            title: 'Delete Product',
                                            message: 'Are you sure you want to delete \'{{ addslashes($product->name) }}\'? This cannot be undone.',
                                            confirmText: 'Delete',
                                            formId: 'deleteForm{{ $product->id }}'
                                        })"
                                        class="w-9 h-9 flex items-center justify-center bg-red-50 text-red-600 rounded-xl hover:bg-red-600 hover:text-white transition-all">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-box-open text-3xl text-slate-300"></i>
                                </div>
                                <h3 class="text-lg font-bold text-slate-900">No products found</h3>
                                <p class="text-slate-500 text-sm max-w-xs mx-auto mt-1">Start by adding your first product to the inventory.</p>
                                <a href="{{ route('admin.products.create') }}"
                                   class="mt-6 px-6 py-2 bg-primary text-white rounded-xl font-bold hover:shadow-lg transition-all">
                                    Add First Product
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-slate-50/50">
            {{ $products->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
