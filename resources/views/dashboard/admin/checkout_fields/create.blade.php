@extends('layouts.dashboard')

@section('title', 'Add Checkout Field')

@section('content')
<div class="p-6">
    <!-- Page Header -->
    <div class="mb-8">
        <a href="{{ route('admin.checkout-fields.index') }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-700 mb-2 inline-block">
            <i class="fas fa-arrow-left mr-1"></i> Back to Fields
        </a>
        <h1 class="text-3xl font-display font-bold text-gray-900">Add Checkout Field</h1>
        <p class="text-gray-600 mt-1">Create a new field for the checkout form</p>
    </div>

    <div class="max-w-4xl">
        <form action="{{ route('admin.checkout-fields.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Label -->
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700 uppercase tracking-wider ml-1">Field Label</label>
                        <input type="text" name="label" required value="{{ old('label') }}"
                               class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-indigo-500 focus:bg-white transition-all outline-none text-slate-900 font-medium"
                               placeholder="e.g. Full Name">
                    </div>

                    <!-- Name -->
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700 uppercase tracking-wider ml-1">Field Name (Backend)</label>
                        <input type="text" name="name" required value="{{ old('name') }}"
                               class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-indigo-500 focus:bg-white transition-all outline-none text-slate-900 font-medium"
                               placeholder="e.g. full_name">
                    </div>

                    <!-- Type -->
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700 uppercase tracking-wider ml-1">Field Type</label>
                        <select name="type" required
                                class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-indigo-500 focus:bg-white transition-all outline-none text-slate-900 font-medium">
                            <option value="text">Text</option>
                            <option value="email">Email</option>
                            <option value="tel">Telephone</option>
                            <option value="textarea">Textarea</option>
                            <option value="select">Select Dropdown</option>
                        </select>
                    </div>

                    <!-- Placeholder -->
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700 uppercase tracking-wider ml-1">Placeholder</label>
                        <input type="text" name="placeholder" value="{{ old('placeholder') }}"
                               class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-indigo-500 focus:bg-white transition-all outline-none text-slate-900 font-medium"
                               placeholder="e.g. Enter your full name">
                    </div>

                    <!-- Sort Order -->
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700 uppercase tracking-wider ml-1">Sort Order</label>
                        <input type="number" name="sort_order" required value="{{ old('sort_order', 0) }}"
                               class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-indigo-500 focus:bg-white transition-all outline-none text-slate-900 font-medium">
                    </div>

                    <!-- Options (for Select) -->
                    <div class="space-y-2 md:col-span-2">
                        <label class="text-sm font-bold text-slate-700 uppercase tracking-wider ml-1">Options (Comma separated, for Select only)</label>
                        <textarea name="options" rows="2"
                                  class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-indigo-500 focus:bg-white transition-all outline-none text-slate-900 font-medium"
                                  placeholder="e.g. Option 1, Option 2, Option 3">{{ old('options') }}</textarea>
                    </div>

                    <!-- Toggles -->
                    <div class="md:col-span-2 flex flex-wrap gap-6">
                        <div class="flex items-center space-x-4 p-4 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_required" value="1" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                            </label>
                            <span class="text-sm font-bold text-slate-700 uppercase tracking-wider">Required Field</span>
                        </div>

                        <div class="flex items-center space-x-4 p-4 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                            </label>
                            <span class="text-sm font-bold text-slate-700 uppercase tracking-wider">Field is Active</span>
                        </div>
                    </div>
                </div>

                <div class="mt-10 pt-8 border-t border-gray-100">
                    <button type="submit" 
                            class="w-full md:w-auto px-12 py-4 bg-linear-to-r from-indigo-600 to-purple-600 text-white rounded-2xl font-bold hover:shadow-2xl transition-all hover:scale-[1.02] transform">
                        Create Field
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
