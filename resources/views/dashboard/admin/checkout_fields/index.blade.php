@extends('layouts.dashboard')

@section('title', 'Checkout Fields Management')

@section('content')
<div class="p-6" x-data="{}">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-display font-bold text-gray-900">Checkout Fields</h1>
            <p class="text-gray-600 mt-1">Manage dynamic fields for the checkout form</p>
        </div>
        <a href="{{ route('admin.checkout-fields.create') }}" 
           class="px-6 py-3 bg-linear-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-bold hover:shadow-lg transition-all hover:scale-[1.02] transform">
            <i class="fas fa-plus mr-2"></i>Add Field
        </a>
    </div>

    <!-- Fields Table -->
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Order</th>
                        <th class="px-6 py-5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Label / Name</th>
                        <th class="px-6 py-5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Required</th>
                        <th class="px-6 py-5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-5 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($fields as $field)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-6 py-4">
                            <span class="font-bold text-slate-900">{{ $field->sort_order }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-900">{{ $field->label }}</div>
                            <div class="text-xs text-slate-400 font-medium">Name: {{ $field->name }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-xs font-bold uppercase tracking-wider">
                                {{ $field->type }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($field->is_required)
                                <span class="text-rose-600 font-bold text-xs uppercase">Yes</span>
                            @else
                                <span class="text-slate-400 font-bold text-xs uppercase">No</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($field->is_active)
                                <span class="px-3 py-1 bg-green-50 text-green-600 rounded-full text-[10px] font-bold uppercase tracking-wider">Active</span>
                            @else
                                <span class="px-3 py-1 bg-red-50 text-red-600 rounded-full text-[10px] font-bold uppercase tracking-wider">Inactive</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('admin.checkout-fields.edit', $field) }}" 
                                   class="w-9 h-9 flex items-center justify-center bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-600 hover:text-white transition-all">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>
                                <button @click="$dispatch('confirm-modal', {
                                            type: 'danger',
                                            icon: 'fa-trash-can',
                                            title: 'Delete Field',
                                            message: 'Are you sure you want to delete \'{{ addslashes($field->label) }}\'? This may cause data loss for existing orders.',
                                            confirmText: 'Delete Now',
                                            ajax: true,
                                            url: '{{ route('admin.checkout-fields.destroy', $field) }}',
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
                                    <i class="fas fa-list-check text-3xl text-slate-300"></i>
                                </div>
                                <h3 class="text-lg font-bold text-slate-900">No fields found</h3>
                                <p class="text-slate-500 text-sm max-w-xs mx-auto mt-1">Add checkout fields to collect customer information.</p>
                                <a href="{{ route('admin.checkout-fields.create') }}" 
                                   class="mt-6 px-6 py-2 bg-indigo-600 text-white rounded-xl font-bold hover:shadow-lg transition-all">
                                    Add First Field
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
