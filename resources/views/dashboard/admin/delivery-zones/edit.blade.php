@extends('layouts.dashboard')
@section('title', 'Edit Delivery Zone')
@section('content')
<div class="p-6 max-w-2xl">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.delivery-zones.index') }}" class="text-gray-400 hover:text-gray-600 transition">
            <i class="fas fa-arrow-left text-lg"></i>
        </a>
        <h1 class="text-2xl font-bold text-gray-900">Edit Delivery Zone</h1>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <form method="POST" action="{{ route('admin.delivery-zones.update', $deliveryZone) }}" class="space-y-5">
            @csrf @method('PUT')

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Zone Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $deliveryZone->name) }}" required
                       placeholder="e.g., Inside Dhaka"
                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Delivery Charge (৳) <span class="text-red-500">*</span></label>
                    <input type="number" name="charge" value="{{ old('charge', $deliveryZone->charge) }}" step="0.01" min="0" required
                           placeholder="80"
                           class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition @error('charge') border-red-500 @enderror">
                    @error('charge')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Delivery Time <span class="text-red-500">*</span></label>
                    <input type="text" name="delivery_time" value="{{ old('delivery_time', $deliveryZone->delivery_time) }}" required
                           placeholder="e.g., Delivery within 1-2 days"
                           class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition @error('delivery_time') border-red-500 @enderror">
                    @error('delivery_time')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Icon <span class="text-red-500">*</span></label>
                <input type="text" name="icon" value="{{ old('icon', $deliveryZone->icon) }}" required
                       placeholder="e.g., fa-map-marker-alt"
                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition @error('icon') border-red-500 @enderror">
                <p class="text-xs text-gray-500 mt-1">Use Font Awesome icon class names (e.g., fa-map-marker-alt, fa-truck, fa-globe)</p>
                @error('icon')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $deliveryZone->sort_order) }}" min="0"
                           placeholder="0"
                           class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition">
                    <p class="text-xs text-gray-500 mt-1">Lower numbers appear first</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $deliveryZone->is_active) ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300 text-primary focus:ring-primary">
                        <span class="text-sm text-gray-700">Active</span>
                    </label>
                </div>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit" class="flex-1 px-4 py-2.5 bg-primary text-white rounded-lg font-medium hover:bg-primary/90 transition">
                    Update Zone
                </button>
                <a href="{{ route('admin.delivery-zones.index') }}" class="flex-1 px-4 py-2.5 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
