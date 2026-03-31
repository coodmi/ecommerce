@extends('layouts.dashboard')

@section('title', 'Categories Management')

@section('content')
<div class="p-6" x-data="bulkSelect()">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-display font-bold text-gray-900">Categories Management</h1>
            <p class="text-gray-600 mt-1">Manage product categories</p>
        </div>
        <a href="{{ route('admin.categories.create') }}"
           class="px-6 py-3 bg-primary text-white rounded-xl font-bold hover:bg-primary/90 transition-all">
            <i class="fas fa-plus mr-2"></i>Add Category
        </a>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="mb-4 flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm">
            <i class="fas fa-check-circle text-green-500"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
            <i class="fas fa-exclamation-circle text-red-500"></i> {{ session('error') }}
        </div>
    @endif

    {{-- Bulk Action Bar --}}
    <div x-show="selected.length > 0"
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="mb-4 flex items-center justify-between bg-primary/5 border border-primary/20 rounded-2xl px-5 py-3">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center">
                <i class="fas fa-check-square text-primary text-sm"></i>
            </div>
            <span class="text-sm font-semibold text-gray-700">
                <span x-text="selected.length"></span> item(s) selected
            </span>
        </div>
        <div class="flex items-center gap-2">
            <button type="button" @click="clearAll()"
                    class="px-4 py-2 text-sm text-gray-500 hover:text-gray-700 font-medium transition">
                Clear
            </button>
            <form id="bulkDeleteForm" method="POST" action="{{ route('admin.categories.bulk-delete') }}">
                @csrf
                <template x-for="id in selected" :key="id">
                    <input type="hidden" name="ids[]" :value="id">
                </template>
                <button type="button"
                        @click="$dispatch('confirm-modal', {
                            type: 'danger',
                            icon: 'fa-trash-alt',
                            title: 'Delete Selected',
                            message: selected.length + ' categories will be permanently deleted.',
                            confirmText: 'Delete All',
                            formId: 'bulkDeleteForm'
                        })"
                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-xl transition flex items-center gap-2">
                    <i class="fas fa-trash-alt text-xs"></i>
                    Delete Selected
                </button>
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-5 w-10">
                            <input type="checkbox"
                                   @change="toggleAll($event)"
                                   :checked="allSelected"
                                   class="w-4 h-4 rounded text-primary border-gray-300 cursor-pointer">
                        </th>
                        <th class="px-6 py-5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Image</th>
                        <th class="px-6 py-5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Products</th>
                        <th class="px-6 py-5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Created</th>
                        <th class="px-6 py-5 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($categories as $category)
                    <tr class="hover:bg-slate-50/50 transition-colors group"
                        :class="selected.includes({{ $category->id }}) ? 'bg-primary/5' : ''">
                        <td class="px-6 py-4">
                            <input type="checkbox"
                                   @change="toggle({{ $category->id }})"
                                   :checked="selected.includes({{ $category->id }})"
                                   class="w-4 h-4 rounded text-primary border-gray-300 cursor-pointer">
                        </td>
                        <td class="px-6 py-4">
                            <div class="relative w-16 h-16 rounded-2xl overflow-hidden shadow-sm border border-gray-100 group-hover:shadow-md transition-all">
                                <img src="{{ $category->image_url }}" alt="{{ $category->name }}"
                                     class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-900 group-hover:text-primary transition-colors flex items-center gap-2">
                                {{ $category->name }}
                                @if($category->is_popular)
                                    <span class="px-2 py-0.5 bg-yellow-100 text-yellow-600 rounded text-[10px] font-bold uppercase tracking-wide border border-yellow-200">
                                        <i class="fas fa-star mr-1"></i>Popular
                                    </span>
                                @endif
                            </div>
                            <div class="text-xs text-slate-400 font-medium">{{ Str::limit($category->description, 50) }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-purple-50 text-purple-600 rounded-full text-xs font-bold">
                                {{ $category->products->count() }} Products
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($category->is_active)
                                <span class="px-3 py-1 bg-green-50 text-green-600 rounded-full text-[10px] font-bold uppercase tracking-wider">Active</span>
                            @else
                                <span class="px-3 py-1 bg-red-50 text-red-600 rounded-full text-[10px] font-bold uppercase tracking-wider">Inactive</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-500 font-medium">
                            {{ $category->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('admin.categories.edit', $category) }}"
                                   class="w-9 h-9 flex items-center justify-center bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-600 hover:text-white transition-all">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>
                                <form id="deleteForm{{ $category->id }}"
                                      action="{{ route('admin.categories.destroy', $category) }}"
                                      method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button type="button"
                                        @click="$dispatch('confirm-modal', {
                                            type: 'danger',
                                            icon: 'fa-trash-alt',
                                            title: 'Delete Category',
                                            message: 'Delete \'{{ addslashes($category->name) }}\'? This cannot be undone.',
                                            confirmText: 'Delete',
                                            formId: 'deleteForm{{ $category->id }}'
                                        })"
                                        class="w-9 h-9 flex items-center justify-center bg-red-50 text-red-600 rounded-xl hover:bg-red-600 hover:text-white transition-all">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-folder-open text-3xl text-slate-300"></i>
                                </div>
                                <h3 class="text-lg font-bold text-slate-900">No categories found</h3>
                                <a href="{{ route('admin.categories.create') }}"
                                   class="mt-6 px-6 py-2 bg-primary text-white rounded-xl font-bold hover:shadow-lg transition-all">
                                    Add First Category
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($categories->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-slate-50/50">
            {{ $categories->links() }}
        </div>
        @endif
    </div>
</div>

<script>
function bulkSelect() {
    return {
        selected: [],
        allIds: @json($categories->pluck('id')),
        get allSelected() {
            return this.allIds.length > 0 && this.selected.length === this.allIds.length;
        },
        toggle(id) {
            this.selected.includes(id)
                ? this.selected = this.selected.filter(i => i !== id)
                : this.selected.push(id);
        },
        toggleAll(e) {
            this.selected = e.target.checked ? [...this.allIds] : [];
        },
        clearAll() { this.selected = []; },
    }
}
</script>
@endsection
