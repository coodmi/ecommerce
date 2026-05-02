@extends('layouts.dashboard')
@section('title', 'Testimonials')

@section('content')
<div class="p-6" x-data="{ editId: null, editData: {} }">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="dash-title text-gray-900">Testimonials</h1>
            <p class="dash-subtitle mt-0.5">Manage customer testimonials shown on the homepage</p>
        </div>
        <button @click="editId = 'new'; editData = { rating: 5, is_active: true }"
                class="px-4 py-2 bg-primary text-white rounded-xl text-sm font-semibold hover:bg-primary/90 transition flex items-center gap-2">
            <i class="fas fa-plus text-xs"></i> Add Testimonial
        </button>
    </div>

    {{-- Cards Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
        @forelse($testimonials as $t)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex flex-col gap-4 hover:shadow-md transition-shadow">
            {{-- Top: avatar + name + actions --}}
            <div class="flex items-start justify-between gap-3">
                <div class="flex items-center gap-3">
                    <img src="{{ $t->avatar_url }}" alt="{{ $t->name }}"
                         class="w-12 h-12 rounded-full object-cover border-2 border-gray-100 flex-shrink-0">
                    <div>
                        <p class="font-semibold text-gray-900 text-sm leading-tight">{{ $t->name }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $t->designation ?: 'Verified Customer' }}</p>
                        <div class="flex text-yellow-400 text-xs gap-0.5 mt-1">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="{{ $i <= $t->rating ? 'fas' : 'far' }} fa-star"></i>
                            @endfor
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-1.5 flex-shrink-0">
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold {{ $t->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $t->is_active ? 'Active' : 'Hidden' }}
                    </span>
                </div>
            </div>

            {{-- Message --}}
            <p class="text-xs text-gray-500 leading-relaxed line-clamp-3 flex-1">
                "{{ $t->message }}"
            </p>

            {{-- Actions --}}
            <div class="flex items-center gap-2 pt-3 border-t border-gray-50">
                <button @click="editId = {{ $t->id }}; editData = {{ $t->toJson() }}"
                        class="flex-1 flex items-center justify-center gap-1.5 py-2 bg-indigo-50 text-indigo-600 rounded-lg text-xs font-semibold hover:bg-indigo-600 hover:text-white transition-all">
                    <i class="fas fa-edit text-xs"></i> Edit
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
                        class="flex-1 flex items-center justify-center gap-1.5 py-2 bg-red-50 text-red-500 rounded-lg text-xs font-semibold hover:bg-red-500 hover:text-white transition-all">
                    <i class="fas fa-trash text-xs"></i> Delete
                </button>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-20 bg-white rounded-2xl border border-dashed border-gray-200">
            <div class="w-14 h-14 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <i class="fas fa-quote-left text-2xl text-gray-300"></i>
            </div>
            <p class="text-sm font-semibold text-gray-500 mb-2">No testimonials yet</p>
            <button @click="editId = 'new'; editData = { rating: 5, is_active: true }"
                    class="text-xs text-primary font-semibold hover:underline">
                Add your first testimonial →
            </button>
        </div>
        @endforelse
    </div>

    {{-- ── MODAL ── --}}
    <div x-show="editId !== null" x-cloak
         class="fixed inset-0 z-50 flex items-end sm:items-center justify-center p-0 sm:p-4 bg-black/50 backdrop-blur-sm"
         style="display:none;"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click.self="editId = null">

        <div class="bg-white w-full sm:w-[520px] sm:max-w-[520px] sm:rounded-2xl rounded-t-3xl shadow-2xl overflow-hidden flex-shrink-0"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="translate-y-4 sm:scale-95 opacity-0"
             x-transition:enter-end="translate-y-0 sm:scale-100 opacity-100">

            {{-- Modal Header --}}
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center">
                        <i class="fas fa-quote-left text-primary text-xs"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 text-sm"
                        x-text="editId === 'new' ? 'Add Testimonial' : 'Edit Testimonial'"></h3>
                </div>
                <button @click="editId = null"
                        class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 text-gray-500 hover:bg-gray-200 transition">
                    <i class="fas fa-times text-xs"></i>
                </button>
            </div>

            {{-- Scrollable body --}}
            <div class="overflow-y-auto max-h-[75vh]">

                {{-- ADD FORM --}}
                <template x-if="editId === 'new'">
                    <form action="{{ route('admin.testimonials.store') }}" method="POST"
                          enctype="multipart/form-data" class="p-5 space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Name <span class="text-red-500">*</span></label>
                                <input type="text" name="name" required placeholder="e.g. Sarah Johnson"
                                       class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Designation</label>
                                <input type="text" name="designation" placeholder="e.g. Verified Customer"
                                       class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Message <span class="text-red-500">*</span></label>
                            <textarea name="message" rows="3" required placeholder="What did the customer say?"
                                      class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition resize-none"></textarea>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Rating</label>
                                <select name="rating"
                                        class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary transition bg-white">
                                    @foreach([5,4,3,2,1] as $r)
                                    <option value="{{ $r }}">{{ $r }} ★</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Sort Order</label>
                                <input type="number" name="sort_order" value="0"
                                       class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary transition">
                            </div>
                            <div class="flex items-end pb-1">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <div class="relative">
                                        <input type="checkbox" name="is_active" value="1" checked class="sr-only peer">
                                        <div class="w-9 h-5 bg-gray-200 peer-checked:bg-primary rounded-full transition-colors"></div>
                                        <div class="absolute top-0.5 left-0.5 w-4 h-4 bg-white rounded-full shadow transition-transform peer-checked:translate-x-4"></div>
                                    </div>
                                    <span class="text-xs font-semibold text-gray-600">Active</span>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Avatar <span class="text-gray-400 font-normal">(optional)</span></label>
                            <label class="flex items-center gap-3 px-3 py-2.5 border border-dashed border-gray-300 rounded-xl cursor-pointer hover:border-primary transition group">
                                <div class="w-8 h-8 bg-gray-100 group-hover:bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0 transition">
                                    <i class="fas fa-image text-gray-400 group-hover:text-primary text-xs transition"></i>
                                </div>
                                <span class="text-xs text-gray-400 group-hover:text-primary transition">Click to upload image</span>
                                <input type="file" name="avatar" accept="image/*" class="hidden">
                            </label>
                        </div>

                        <div class="flex gap-3 pt-1">
                            <button type="button" @click="editId = null"
                                    class="flex-1 py-2.5 border border-gray-200 rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="flex-1 py-2.5 bg-primary text-white rounded-xl text-sm font-bold hover:bg-primary/90 transition shadow-sm">
                                Add Testimonial
                            </button>
                        </div>
                    </form>
                </template>

                {{-- EDIT FORM --}}
                <template x-if="editId !== null && editId !== 'new'">
                    <form :action="'/admin/testimonials/' + editId" method="POST"
                          enctype="multipart/form-data" class="p-5 space-y-4">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Name <span class="text-red-500">*</span></label>
                                <input type="text" name="name" :value="editData.name" required
                                       class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Designation</label>
                                <input type="text" name="designation" :value="editData.designation"
                                       placeholder="e.g. Verified Customer"
                                       class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Message <span class="text-red-500">*</span></label>
                            <textarea name="message" rows="3" required x-text="editData.message"
                                      class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition resize-none"></textarea>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Rating</label>
                                <select name="rating"
                                        class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary transition bg-white">
                                    @foreach([5,4,3,2,1] as $r)
                                    <option value="{{ $r }}" :selected="editData.rating == {{ $r }}">{{ $r }} ★</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Sort Order</label>
                                <input type="number" name="sort_order" :value="editData.sort_order"
                                       class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary transition">
                            </div>
                            <div class="flex items-end pb-1">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <div class="relative">
                                        <input type="checkbox" name="is_active" value="1"
                                               :checked="editData.is_active" class="sr-only peer">
                                        <div class="w-9 h-5 bg-gray-200 peer-checked:bg-primary rounded-full transition-colors"></div>
                                        <div class="absolute top-0.5 left-0.5 w-4 h-4 bg-white rounded-full shadow transition-transform peer-checked:translate-x-4"></div>
                                    </div>
                                    <span class="text-xs font-semibold text-gray-600">Active</span>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Avatar <span class="text-gray-400 font-normal">(leave blank to keep current)</span></label>
                            <div class="flex items-center gap-3 mb-2" x-show="editData.avatar">
                                <img :src="'/storage/' + editData.avatar"
                                     class="w-10 h-10 rounded-full object-cover border-2 border-gray-100">
                                <span class="text-xs text-gray-400">Current avatar</span>
                            </div>
                            <label class="flex items-center gap-3 px-3 py-2.5 border border-dashed border-gray-300 rounded-xl cursor-pointer hover:border-primary transition group">
                                <div class="w-8 h-8 bg-gray-100 group-hover:bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0 transition">
                                    <i class="fas fa-image text-gray-400 group-hover:text-primary text-xs transition"></i>
                                </div>
                                <span class="text-xs text-gray-400 group-hover:text-primary transition">Click to upload new image</span>
                                <input type="file" name="avatar" accept="image/*" class="hidden">
                            </label>
                        </div>

                        <div class="flex gap-3 pt-1">
                            <button type="button" @click="editId = null"
                                    class="flex-1 py-2.5 border border-gray-200 rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="flex-1 py-2.5 bg-primary text-white rounded-xl text-sm font-bold hover:bg-primary/90 transition shadow-sm">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </template>

            </div>{{-- end scrollable --}}
        </div>
    </div>

</div>
@endsection
