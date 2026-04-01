@extends('layouts.dashboard')

@section('title', 'Brands Management')

@section('content')
<div class="p-6" x-data="{}">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-display font-bold text-gray-900">Brands Management</h1>
            <p class="text-gray-600 mt-1">Manage product brands</p>
        </div>
        <a href="{{ route('admin.brands.create') }}"
           class="px-6 py-3 bg-primary text-white rounded-xl font-bold hover:bg-primary/90 transition-all">
            <i class="fas fa-plus mr-2"></i>Add Brand
        </a>
    </div>

    {{-- Search --}}
    <form method="GET" action="{{ route('admin.brands.index') }}" class="flex gap-3 mb-6">
        <div class="relative flex-1 max-w-md">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search by brand name..."
                   class="w-full pl-9 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary shadow-sm bg-white">
        </div>
        <button type="submit" class="px-5 py-2.5 bg-primary text-white rounded-xl text-sm font-medium hover:bg-primary/90 transition shadow-sm">
            Search
        </button>
        @if(request('search'))
            <a href="{{ route('admin.brands.index') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-sm font-medium transition">
                Clear
            </a>
        @endif
    </form>

    <!-- Brands Table -->
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Logo</th>
                        <th class="px-6 py-5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Products</th>
                        <th class="px-6 py-5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Created</th>
                        <th class="px-6 py-5 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($brands as $brand)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="relative w-16 h-16 rounded-2xl overflow-hidden shadow-sm border border-gray-100 group-hover:shadow-md transition-all flex items-center justify-center bg-gray-50">
                                <img src="{{ $brand->logo_url }}"
                                     alt="{{ $brand->name }}"
                                     class="max-w-[80%] max-h-[80%] object-contain transform group-hover:scale-110 transition-transform duration-500">
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-900 group-hover:text-purple-600 transition-colors">{{ $brand->name }}</div>
                            <div class="text-xs text-slate-400 font-medium">Slug: {{ $brand->slug }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-purple-50 text-purple-600 rounded-full text-xs font-bold">
                                {{ $brand->products_count }} Products
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($brand->is_active)
                                <span class="px-3 py-1 bg-green-50 text-green-600 rounded-full text-[10px] font-bold uppercase tracking-wider">Active</span>
                            @else
                                <span class="px-3 py-1 bg-red-50 text-red-600 rounded-full text-[10px] font-bold uppercase tracking-wider">Inactive</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-500 font-medium">
                            {{ $brand->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('admin.brands.edit', $brand) }}"
                                   class="w-9 h-9 flex items-center justify-center bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-600 hover:text-white transition-all">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>
                                <button @click="$dispatch('confirm-modal', {
                                            type: 'danger',
                                            icon: 'fa-trash-can',
                                            title: 'Delete Brand',
                                            message: 'Are you sure you want to delete \'{{ addslashes($brand->name) }}\'? This action will set brand to null for all associated products.',
                                            confirmText: 'Delete Now',
                                            ajax: true,
                                            url: '{{ route('admin.brands.destroy', $brand) }}',
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
                                    <i class="fas fa-tag text-3xl text-slate-300"></i>
                                </div>
                                <h3 class="text-lg font-bold text-slate-900">No brands found</h3>
                                <p class="text-slate-500 text-sm max-w-xs mx-auto mt-1">Add brands to assign them to your products.</p>
                                <a href="{{ route('admin.brands.create') }}"
                                   class="mt-6 px-6 py-2 bg-primary text-white rounded-xl font-bold hover:shadow-lg transition-all">
                                    Add First Brand
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($brands->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-slate-50/50">
            {{ $brands->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
