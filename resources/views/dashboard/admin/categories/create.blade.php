@extends('layouts.dashboard')

@section('title', 'Create Category')

@section('content')
<div class="p-6">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center space-x-4 mb-4">
            <a href="{{ route('admin.categories.index') }}" 
               class="text-gray-600 hover:text-gray-900 transition">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-3xl font-display font-bold text-gray-900">Create Category</h1>
                <p class="text-gray-600 mt-1">Add a new product category</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="max-w-3xl">
        <form action="{{ route('admin.categories.store') }}" 
              method="POST" 
              enctype="multipart/form-data"
              x-data="{ imagePreview: null }">
            @csrf

            <div class="bg-white rounded-2xl shadow-md p-8 space-y-6">
                <!-- Name -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Category Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="name" 
                           value="{{ old('name') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-primary transition @error('name') border-red-500 @enderror"
                           placeholder="Enter category name"
                           required>
                    @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Description
                    </label>
                    <textarea name="description" 
                              rows="4"
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-primary transition @error('description') border-red-500 @enderror"
                              placeholder="Enter category description">{{ old('description') }}</textarea>
                    @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image Upload -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Category Image
                    </label>
                    <div class="flex items-start space-x-4">
                        <div class="flex-1">
                            <input type="file" 
                                   name="image" 
                                   accept="image/*"
                                   @change="imagePreview = URL.createObjectURL($event.target.files[0])"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-primary transition @error('image') border-red-500 @enderror">
                            @error('image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Accepted formats: JPG, PNG, GIF (Max: 2MB)</p>
                        </div>
                        <div x-show="imagePreview" 
                             x-cloak
                             class="w-32 h-32 border-2 border-gray-300 rounded-xl overflow-hidden">
                            <img :src="imagePreview" alt="Preview" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <label class="flex items-center space-x-3">
                        <input type="checkbox" 
                               name="is_active" 
                               value="1"
                               {{ old('is_active', true) ? 'checked' : '' }}
                               class="w-5 h-5 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                        <span class="text-sm font-semibold text-gray-700">Active</span>
                    </label>
                    <p class="mt-1 text-sm text-gray-500 ml-8">Category will be visible to customers</p>
                </div>

                <!-- Popular Status -->
                <div>
                    <label class="flex items-center space-x-3">
                        <input type="checkbox" 
                               name="is_popular" 
                               value="1"
                               {{ old('is_popular') ? 'checked' : '' }}
                               class="w-5 h-5 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                        <span class="text-sm font-semibold text-gray-700">Popular Category</span>
                    </label>
                    <p class="mt-1 text-sm text-gray-500 ml-8">Category will be featured in popular sections</p>
                </div>

                <!-- Deal Status -->
                <div>
                    <label class="flex items-center space-x-3">
                        <input type="checkbox" 
                               name="is_deal" 
                               value="1"
                               {{ old('is_deal') ? 'checked' : '' }}
                               class="w-5 h-5 text-amber-600 border-gray-300 rounded focus:ring-amber-500">
                        <span class="text-sm font-semibold text-gray-700">Deal Category</span>
                    </label>
                    <p class="mt-1 text-sm text-gray-500 ml-8">Category will be featured in the Deals page</p>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.categories.index') }}" 
                       class="px-6 py-3 bg-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-300 transition">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-linear-to-r from-purple-600 to-pink-600 text-white rounded-xl font-semibold hover:shadow-lg transition">
                        <i class="fas fa-save mr-2"></i>Create Category
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
</style>
@endsection
