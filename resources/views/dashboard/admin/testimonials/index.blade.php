@extends('layouts.dashboard')
@section('title', 'Testimonials')

@section('content')
<div class="p-6" x-data="{ editId: null, editData: {} }">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="dash-title text-gray-900">Testimonials</h1>
            <p class="dash-subtitle mt-0.5">Manage customer testimonials shown on the homepage</p>
        </div>
        <button @click="editId = 'new'; editData = { rating: 5, is_active: true }"
                class="px-4 py-2 bg-primary text-white rounded-xl text-sm font-semibold hover:bg-primary/90 transition flex items-center gap-2">
            <i class="fas fa-plus"></i> Add Testimonial
        </button>
    </div>

    {{-- Testimonials Table --}}
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 bg-gray-50">
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-600">Person</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-600">Message</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-600">Rating</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-600">Status</th>
                    <th class="text-right px-5 py-3 text-xs font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($testimonials as $t)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            <img src="{{ $t->avatar_url }}" alt="{{ $t->name }}"
                                 class="w-10 h-10 rounded-full object-cover border border-gray-100">
                            <div>
                                <p class="font-semibold text-gray-900 text-sm">{{ $t->name }}</p>
                                @if($t->designation)
                                <p class="text-xs text-gray-400">{{ $t->designation }}</p>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-4 text-gray-500 max-w-xs">
                        <p class="line-clamp-2 text-xs">{{ $t->message }}</p>
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex text-yellow-400 text-xs gap-0.5">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="{{ $i <= $t->rating ? 'fas' : 'far' }} fa-star"></i>
                            @endfor
                        </div>
                    </td>
                    <td class="px-5 py-4">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $t->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $t->is_active ? 'Active' : 'Hidden' }}
                        </span>
                    </td>
                    <td class="px-5 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button @click="editId = {{ $t->id }}; editData = {{ $t->toJson() }}"
                                    class="w-8 h-8 flex items-center justify-center bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-600 hover:text-white transition-all">
                                <i class="fas fa-edit text-xs"></i>
                            </button>
                            <button @click="$dispatch('confirm-modal', {
                                        type: 'danger', icon: 'fa-trash-can',
                                        title: 'Delete Testimonial',
                                        message: 'Are you sure you want to delete this testimonial?',
                                        confirmText: 'Delete',
                                        ajax: true,
                                        url: '{{ route('admin.testimonials.destroy', $t) }}',
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
                    <td colspan="5" class="px-5 py-16 text-center">
                        <div class="w-14 h-14 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-quote-left text-2xl text-gray-300"></i>
                        </div>
                        <p class="text-sm font-semibold text-gray-500">No testimonials yet</p>
                        <button @click="editId = 'new'; editData = { rating: 5, is_active: true }"
                                class="mt-3 text-xs text-primary font-semibold hover:underline">Add your first testimonial</button>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Add / Edit Modal --}}
    <div x-show="editId !== null" x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
         style="display:none;"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100">

        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="scale-95 opacity-0"
             x-transition:enter-end="scale-100 opacity-100"
             @click.stop>

            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h3 class="font-bold text-gray-900" x-text="editId === 'new' ? 'Add Testimonial' : 'Edit Testimonial'"></h3>
                <button @click="editId = null" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 text-gray-500 hover:bg-gray-200">
                    <i class="fas fa-times text-sm"></i>
                </button>
            </div>

            {{-- Add Form --}}
            <template x-if="editId === 'new'">
                <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Name *</label>
                            <input type="text" name="name" required class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-primary">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Designation</label>
                            <input type="text" name="designation" placeholder="e.g. Verified Customer" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-primary">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Message *</label>
                        <textarea name="message" rows="3" required class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-primary resize-none"></textarea>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Rating</label>
                            <select name="rating" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-primary">
                                @foreach([5,4,3,2,1] as $r)
                                <option value="{{ $r }}">{{ $r }} ★</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Sort Order</label>
                            <input type="number" name="sort_order" value="0" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-primary">
                        </div>
                        <div class="flex flex-col justify-end">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" checked class="w-4 h-4 text-primary rounded">
                                <span class="text-xs font-semibold text-gray-700">Active</span>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Avatar (optional)</label>
                        <input type="file" name="avatar" accept="image/*" class="w-full text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                    </div>
                    <div class="flex gap-3 pt-2">
                        <button type="button" @click="editId = null" class="flex-1 py-2.5 border border-gray-200 rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-50">Cancel</button>
                        <button type="submit" class="flex-1 py-2.5 bg-primary text-white rounded-xl text-sm font-bold hover:bg-primary/90">Add Testimonial</button>
                    </div>
                </form>
            </template>

            {{-- Edit Form --}}
            <template x-if="editId !== null && editId !== 'new'">
                <form :action="'/admin/testimonials/' + editId" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                    @csrf @method('PUT')
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Name *</label>
                            <input type="text" name="name" :value="editData.name" required class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-primary">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Designation</label>
                            <input type="text" name="designation" :value="editData.designation" placeholder="e.g. Verified Customer" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-primary">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Message *</label>
                        <textarea name="message" rows="3" required x-text="editData.message" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-primary resize-none"></textarea>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Rating</label>
                            <select name="rating" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-primary">
                                @foreach([5,4,3,2,1] as $r)
                                <option value="{{ $r }}" :selected="editData.rating == {{ $r }}">{{ $r }} ★</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Sort Order</label>
                            <input type="number" name="sort_order" :value="editData.sort_order" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-primary">
                        </div>
                        <div class="flex flex-col justify-end">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" :checked="editData.is_active" class="w-4 h-4 text-primary rounded">
                                <span class="text-xs font-semibold text-gray-700">Active</span>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Avatar (leave blank to keep current)</label>
                        <div class="flex items-center gap-3 mb-2" x-show="editData.avatar">
                            <img :src="'/storage/' + editData.avatar" class="w-10 h-10 rounded-full object-cover border border-gray-100">
                            <span class="text-xs text-gray-400">Current avatar</span>
                        </div>
                        <input type="file" name="avatar" accept="image/*" class="w-full text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                    </div>
                    <div class="flex gap-3 pt-2">
                        <button type="button" @click="editId = null" class="flex-1 py-2.5 border border-gray-200 rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-50">Cancel</button>
                        <button type="submit" class="flex-1 py-2.5 bg-primary text-white rounded-xl text-sm font-bold hover:bg-primary/90">Save Changes</button>
                    </div>
                </form>
            </template>
        </div>
    </div>

</div>
@endsection
