<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::withCount('products')->latest()->get();
        return view('dashboard.admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('dashboard.admin.brands.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'is_active' => 'boolean'
        ], [
            'logo.max' => 'The brand logo must be less than 5MB.'
        ]);

        try {
            $data = $request->except('logo');
            $data['slug'] = Str::slug($request->name);
            $data['is_active'] = $request->has('is_active');

            if ($request->hasFile('logo')) {
                $path = $request->file('logo')->store('brands', 'public');
                $data['logo'] = $path;
            }

            Brand::create($data);

            return redirect()->route('admin.brands.index')->with('success', 'Brand created successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function edit(Brand $brand)
    {
        return view('dashboard.admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'is_active' => 'boolean'
        ], [
            'logo.max' => 'The brand logo must be less than 5MB.'
        ]);

        try {
            $data = $request->except('logo');
            $data['slug'] = Str::slug($request->name);
            $data['is_active'] = $request->has('is_active');

            if ($request->hasFile('logo')) {
                // Delete old logo
                if ($brand->logo) {
                    Storage::disk('public')->delete($brand->logo);
                }
                $path = $request->file('logo')->store('brands', 'public');
                $data['logo'] = $path;
            }

            $brand->update($data);

            return redirect()->route('admin.brands.index')->with('success', 'Brand updated successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function destroy(Brand $brand)
    {
        try {
            if ($brand->logo) {
                Storage::disk('public')->delete($brand->logo);
            }
            $brand->delete();
            return response()->json(['success' => true, 'message' => 'Brand deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Something went wrong.'], 500);
        }
    }
}
