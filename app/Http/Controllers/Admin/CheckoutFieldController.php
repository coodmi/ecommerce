<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CheckoutField;
use Illuminate\Http\Request;

class CheckoutFieldController extends Controller
{
    public function index()
    {
        $fields = CheckoutField::orderBy('sort_order')->get();
        return view('dashboard.admin.checkout_fields.index', compact('fields'));
    }

    public function create()
    {
        return view('dashboard.admin.checkout_fields.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'placeholder' => 'nullable|string|max:255',
            'options' => 'nullable|string',
            'is_required' => 'boolean',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $validated['is_required'] = $request->has('is_required');
        $validated['is_active'] = $request->has('is_active');
        
        if ($request->filled('options')) {
            $validated['options'] = array_map('trim', explode(',', $request->options));
        }

        CheckoutField::create($validated);

        return redirect()->route('admin.checkout-fields.index')->with('success', 'Checkout field created successfully.');
    }

    public function edit(CheckoutField $checkoutField)
    {
        return view('dashboard.admin.checkout_fields.edit', compact('checkoutField'));
    }

    public function update(Request $request, CheckoutField $checkoutField)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'placeholder' => 'nullable|string|max:255',
            'options' => 'nullable|string',
            'is_required' => 'boolean',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $validated['is_required'] = $request->has('is_required');
        $validated['is_active'] = $request->has('is_active');

        if ($request->filled('options')) {
            $validated['options'] = array_map('trim', explode(',', $request->options));
        } else {
            $validated['options'] = null;
        }

        $checkoutField->update($validated);

        return redirect()->route('admin.checkout-fields.index')->with('success', 'Checkout field updated successfully.');
    }

    public function destroy(CheckoutField $checkoutField)
    {
        $checkoutField->delete();
        return response()->json(['success' => true, 'message' => 'Checkout field deleted successfully.']);
    }
}
