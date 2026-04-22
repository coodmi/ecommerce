<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;

class DeliveryChargeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $products = Product::with(['category', 'primaryImage'])
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%"))
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        $globalCharge        = Setting::get('delivery_charge', 0);
        $globalFreeThreshold = Setting::get('delivery_free_threshold', 0);
        $globalLabel         = Setting::get('delivery_label', 'Delivery Charge');

        return view('dashboard.admin.delivery.index', compact(
            'products', 'search', 'globalCharge', 'globalFreeThreshold', 'globalLabel'
        ));
    }

    public function updateProduct(Request $request, Product $product)
    {
        $request->validate([
            'delivery_charge' => 'nullable|numeric|min:0',
        ]);

        $product->update([
            'delivery_charge' => $request->input('delivery_charge') !== '' ? $request->input('delivery_charge') : null,
        ]);

        return back()->with('success', "Delivery charge updated for \"{$product->name}\".");
    }

    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'charges'   => 'required|array',
            'charges.*' => 'nullable|numeric|min:0',
        ]);

        foreach ($request->charges as $productId => $charge) {
            Product::where('id', $productId)->update([
                'delivery_charge' => ($charge !== '' && $charge !== null) ? $charge : null,
            ]);
        }

        return back()->with('success', 'Delivery charges updated successfully.');
    }
}
