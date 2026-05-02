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
                <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold flex-shrink-0 {{ $t->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                    {{ $t->is_active ? 'Active' : 'Hidden' }}
                </span>
            </div>
            <p class="text-xs text-gray-500 leading-relaxed line-clamp-3 flex-1">"{{ $t->message }}"</p>
            <div class="flex items-center gap-2 pt-3 border-t border-gray-50">
                <button @click="editId = {{ $t->id }}; editData = {{ $t->toJson() }}"
                        class="flex-1 flex items-center justify-center gap-1.5 py-2 bg-indigo-50 text-indigo-600 rounded-lg text-xs font-semibold hover:bg-indigo-600 hover:text-white transition-all">
                    <i class="fas fa-edit text-xs"></i> Edit
                </button>
                <button @click="$dispatch('confirm-modal', {
                            type: 'danger', icon: 'fa-trash-can',
                            title: 'Delete Testimonial',
                            message: 'Are you sure you want to delete this testimonial?',
                            confirmText: 'Delete', ajax: true,
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
                    class="text-xs text-primary font-semibold hover:underline">Add your first testimonial →</button>
        </div>
        @endforelse
    </div>

    {{-- MODAL BACKDROP --}}
    <div x-show="editId !== null"
         x-cloak
         style="display:none"
         class="fixed inset-0 z-[999] bg-black/60 backdrop-blur-sm">

        {{-- MODAL BOX --}}
        <div class="min-h-screen flex items-center justify-center p-4"
             @click.self="editId = null">

            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md" @click.stop>

                {{-- Modal Header --}}
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
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

                {{-- Modal Body --}}
                <div class="overflow-y-auto max-h-[70vh]">

                    {{-- ADD FORM --}}
                    <template x-if="editId === 'new'">
                        <form action="{{ route('admin.testimonials.store') }}" method="POST"
                              enctype="multipart/form-data" class="p-6 space-y-4">
                            @csrf
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Name *</label>
                                    <input type="text" name="name" required placeholder="Sarah Johnson"
                                           class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Designation</label>
                                    <input type="text" name="designation" placeholder="Verified Customer"
                                           class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Message *</label>
                                <textarea name="message" rows="3" required placeholder="Customer feedback..."
                                          class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary resize-none"></textarea>
                            </div>
                            <div class="grid grid-cols-3 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Rating</label>
                                    <select name="rating" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary bg-white">
                                        @foreach([5,4,3,2,1] as $r)
                                        <option value="{{ $r }}">{{ $r }} ★</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Sort</label>
                                    <input type="number" name="sort_order" value="0"
                                           class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary">
                                </div>
                                <div class="flex flex-col justify-end pb-0.5">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox" name="is_active" value="1" checked class="w-4 h-4 accent-primary">
                                        <span class="text-xs font-semibold text-gray-600">Active</span>
                                    </label>
                                </div>
                            </div>
                            <div x-data="{ preview: null }">
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Avatar <span class="text-gray-400 font-normal">(optional)</span></label>
                                <label class="flex items-center gap-3 px-3 py-2.5 border border-dashed border-gray-300 rounded-xl cursor-pointer hover:border-primary transition">
                                    <template x-if="preview">
                                        <img :src="preview" class="w-8 h-8 rounded-full object-cover flex-shrink-0">
                                    </template>
                                    <template x-if="!preview">
                                        <i class="fas fa-image text-gray-400 text-sm flex-shrink-0"></i>
                                    </template>
                                    <span class="text-xs text-gray-400" x-text="preview ? 'Image selected — click to change' : 'Click to upload image'"></span>
                                    <input type="file" name="avatar" accept="image/*" class="hidden"
                                           @change="preview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null">
                                </label>
                            </div>
                            <div class="flex gap-3 pt-1">
                                <button type="button" @click="editId = null"
                                        class="flex-1 py-2.5 border border-gray-200 rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">Cancel</button>
                                <button type="submit"
                                        class="flex-1 py-2.5 bg-primary text-white rounded-xl text-sm font-bold hover:bg-primary/90 transition">Add Testimonial</button>
                            </div>
                        </form>
                    </template>

                    {{-- EDIT FORM --}}
                    <template x-if="editId !== null && editId !== 'new'">
                        <form :action="'/admin/testimonials/' + editId" method="POST"
                              enctype="multipart/form-data" class="p-6 space-y-4">
                            @csrf
                            <input type="hidden" name="_method" value="PUT">
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Name *</label>
                                    <input type="text" name="name" :value="editData.name" required
                                           class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Designation</label>
                                    <input type="text" name="designation" :value="editData.designation"
                                           placeholder="Verified Customer"
                                           class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Message *</label>
                                <textarea name="message" rows="3" required x-text="editData.message"
                                          class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary resize-none"></textarea>
                            </div>
                            <div class="grid grid-cols-3 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Rating</label>
                                    <select name="rating" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary bg-white">
                                        @foreach([5,4,3,2,1] as $r)
                                        <option value="{{ $r }}" :selected="editData.rating == {{ $r }}">{{ $r }} ★</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Sort</label>
                                    <input type="number" name="sort_order" :value="editData.sort_order"
                                           class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary">
                                </div>
                                <div class="flex flex-col justify-end pb-0.5">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox" name="is_active" value="1"
                                               :checked="editData.is_active" class="w-4 h-4 accent-primary">
                                        <span class="text-xs font-semibold text-gray-600">Active</span>
                                    </label>
                                </div>
                            </div>
                            <div x-data="{ preview: null }">
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Avatar <span class="text-gray-400 font-normal">(leave blank to keep)</span></label>
                                <label class="flex items-center gap-3 px-3 py-2.5 border border-dashed border-gray-300 rounded-xl cursor-pointer hover:border-primary transition">
                                    <template x-if="preview">
                                        <img :src="preview" class="w-8 h-8 rounded-full object-cover flex-shrink-0">
                                    </template>
                                    <template x-if="!preview && editData.avatar">
                                        <img :src="'/storage/' + editData.avatar" class="w-8 h-8 rounded-full object-cover flex-shrink-0">
                                    </template>
                                    <template x-if="!preview && !editData.avatar">
                                        <i class="fas fa-image text-gray-400 text-sm flex-shrink-0"></i>
                                    </template>
                                    <span class="text-xs text-gray-400"
                                          x-text="preview ? 'New image selected — click to change' : (editData.avatar ? 'Current avatar — click to change' : 'Click to upload new image')"></span>
                                    <input type="file" name="avatar" accept="image/*" class="hidden"
                                           @change="preview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null">
                                </label>
                            </div>
                            <div class="flex gap-3 pt-1">
                                <button type="button" @click="editId = null"
                                        class="flex-1 py-2.5 border border-gray-200 rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">Cancel</button>
                                <button type="submit"
                                        class="flex-1 py-2.5 bg-primary text-white rounded-xl text-sm font-bold hover:bg-primary/90 transition">Save Changes</button>
                            </div>
                        </form>
                    </template>

                </div>{{-- end body --}}
            </div>{{-- end modal box --}}
        </div>{{-- end centering --}}
    </div>{{-- end backdrop --}}

</div>
@endsection
