@extends('layouts.dashboard')
@section('title', 'Delivery Zones')
@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Delivery Zones</h1>
        <a href="{{ route('admin.delivery-zones.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-lg font-medium hover:bg-primary/90 transition">
            <i class="fas fa-plus text-sm"></i> Add Zone
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700">Zone Name</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700">Delivery Time</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700">Charge</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($zones as $zone)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <i class="fas {{ $zone->icon }} text-primary text-lg"></i>
                                <span class="font-medium text-gray-900">{{ $zone->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $zone->delivery_time }}</td>
                        <td class="px-6 py-4 font-semibold text-gray-900">৳{{ number_format($zone->charge, 0) }}</td>
                        <td class="px-6 py-4">
                            @if($zone->is_active)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-50 text-green-700 text-xs font-medium rounded-full">
                                    <i class="fas fa-check-circle text-xs"></i> Active
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-gray-100 text-gray-600 text-xs font-medium rounded-full">
                                    <i class="fas fa-times-circle text-xs"></i> Inactive
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.delivery-zones.edit', $zone) }}" class="text-primary hover:text-primary/80 transition">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.delivery-zones.destroy', $zone) }}" class="inline" onsubmit="return confirm('Delete this zone?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700 transition">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                            No delivery zones found. <a href="{{ route('admin.delivery-zones.create') }}" class="text-primary hover:underline">Create one</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($zones->hasPages())
        <div class="mt-6">
            {{ $zones->links() }}
        </div>
    @endif
</div>
@endsection
