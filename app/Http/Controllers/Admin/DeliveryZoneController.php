<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryZone;
use Illuminate\Http\Request;

class DeliveryZoneController extends Controller
{
    public function index(Request $request)
    {
        $zones = DeliveryZone::orderBy('sort_order')->paginate(15);
        return view('dashboard.admin.delivery-zones.index', compact('zones'));
    }

    public function create()
    {
        return view('dashboard.admin.delivery-zones.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'charge' => 'required|numeric|min:0',
            'delivery_time' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        DeliveryZone::create($validated);

        return redirect()->route('admin.delivery-zones.index')
                       ->with('success', 'Delivery zone created successfully.');
    }

    public function edit(DeliveryZone $deliveryZone)
    {
        return view('dashboard.admin.delivery-zones.edit', compact('deliveryZone'));
    }

    public function update(Request $request, DeliveryZone $deliveryZone)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'charge' => 'required|numeric|min:0',
            'delivery_time' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $deliveryZone->update($validated);

        return redirect()->route('admin.delivery-zones.index')
                       ->with('success', 'Delivery zone updated successfully.');
    }

    public function destroy(DeliveryZone $deliveryZone)
    {
        $deliveryZone->delete();
        return back()->with('success', 'Delivery zone deleted.');
    }
}
