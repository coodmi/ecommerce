<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\ProductColor;
use App\Models\ProductSize;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand', 'images', 'primaryImage', 'colors', 'sizes'])
            ->latest();

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhereHas('category', fn($q) => $q->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('brand', fn($q) => $q->where('name', 'like', "%{$search}%"));
            });
        }

        $products = $query->paginate(10)->withQueryString();

        return view('dashboard.admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        $brands = \App\Models\Brand::where('is_active', true)->get();
        return view('dashboard.admin.products.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'base_price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'stock_quantity' => 'required|integer|min:0',
            'sku' => 'nullable|string|max:255',
            'rating' => 'nullable|integer|min:0|max:5',
            'is_active' => 'boolean',
            'is_deal' => 'boolean',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'colors.*.name' => 'nullable|string|max:255',
            'colors.*.code' => 'nullable|string|max:7',
            'sizes.*.name' => 'nullable|string|max:255',
            'variants.*.color_id' => 'nullable|integer',
            'variants.*.size_id' => 'nullable|integer',
            'variants.*.price' => 'nullable|numeric|min:0',
            'variants.*.stock' => 'nullable|integer|min:0',
            'variants.*.sku' => 'nullable|string|max:255',
        ], [
            'images.*.max' => 'Each image must be less than 5MB.',
            'images.*.image' => 'The uploaded file must be an image.',
            'images.*.mimes' => 'Images must be in jpeg, png, jpg, or gif format.',
            'base_price.required' => 'Please provide a base price.',
            'category_id.required' => 'Please select a category.',
        ]);

        DB::beginTransaction();
        try {
            // Create product
            $product = Product::create([
                'name' => $validated['name'],
                'slug' => Str::slug($validated['name']),
                'description' => $validated['description'] ?? null,
                'base_price' => $validated['base_price'],
                'delivery_charge' => $request->input('delivery_charge') !== '' ? $request->input('delivery_charge') : null,
                'category_id' => $validated['category_id'],
                'brand_id' => $validated['brand_id'] ?? null,
                'stock_quantity' => $validated['stock_quantity'],
                'sku' => $validated['sku'] ?? null,
                'rating' => $validated['rating'] ?? 0,
                'is_active' => $request->has('is_active'),
                'is_deal' => $request->has('is_deal'),
            ]);

            // Handle multiple images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {
                    $imagePath = $image->store('products', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $imagePath,
                        'is_primary' => $index === 0, // First image is primary
                        'sort_order' => $index,
                    ]);
                }
            }

            // Handle colors
            $colorMap = [];
            $colorsData = $request->has('colors_json') ? json_decode($request->input('colors_json'), true) : ($request->input('colors', []));
            foreach (($colorsData ?? []) as $index => $colorData) {
                if (!empty($colorData['code'])) {
                    $color = ProductColor::create([
                        'product_id' => $product->id,
                        'color_name' => trim($colorData['name'] ?? '') ?: 'Color ' . ($index + 1),
                        'color_code' => $colorData['code'],
                    ]);
                    $colorMap[$index] = $color->id;
                }
            }

            // Handle sizes
            $sizeMap = [];
            $sizesData = $request->has('sizes_json') ? json_decode($request->input('sizes_json'), true) : ($request->input('sizes', []));
            foreach (($sizesData ?? []) as $index => $sizeData) {
                if (!empty($sizeData['name'])) {
                    $size = ProductSize::create([
                        'product_id' => $product->id,
                        'size_name' => trim($sizeData['name']),
                    ]);
                    $sizeMap[$index] = $size->id;
                }
            }

            // Handle variants (color/size combinations with pricing)
            $savedVariantKeys = [];
            if ($request->has('variants')) {
                foreach ($request->variants as $variantData) {
                    $colorId = isset($variantData['color_id']) && $variantData['color_id'] !== '' && $variantData['color_id'] !== 'null'
                        ? ($colorMap[(int)$variantData['color_id']] ?? null)
                        : null;
                    $sizeId = isset($variantData['size_id']) && $variantData['size_id'] !== '' && $variantData['size_id'] !== 'null'
                        ? ($sizeMap[(int)$variantData['size_id']] ?? null)
                        : null;

                    if ($colorId !== null || $sizeId !== null) {
                        $key = ($colorId ?? 'n') . '_' . ($sizeId ?? 'n');
                        if (isset($savedVariantKeys[$key])) continue;
                        $savedVariantKeys[$key] = true;

                        ProductVariant::updateOrCreate(
                            ['product_id' => $product->id, 'color_id' => $colorId, 'size_id' => $sizeId],
                            [
                                'price'          => !empty($variantData['price']) ? $variantData['price'] : $validated['base_price'],
                                'stock_quantity' => $variantData['stock'] ?? 0,
                                'sku'            => $variantData['sku'] ?? null,
                            ]
                        );
                    }
                }
            }

            DB::commit();
            return redirect()->route('admin.products.index')
                ->with('success', 'Product created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Failed to create product: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load(['category', 'images', 'colors', 'sizes', 'variants']);
        return view('dashboard.admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)->get();
        $brands = \App\Models\Brand::where('is_active', true)->get();
        $product->load(['images', 'colors', 'sizes', 'variants.color', 'variants.size']);
        return view('dashboard.admin.products.edit', compact('product', 'categories', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'base_price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'stock_quantity' => 'required|integer|min:0',
            'sku' => 'nullable|string|max:255',
            'rating' => 'nullable|integer|min:0|max:5',
            'is_active' => 'boolean',
            'is_deal' => 'boolean',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'delete_images.*' => 'nullable|integer|exists:product_images,id',
            'colors.*.name' => 'nullable|string|max:255',
            'colors.*.code' => 'nullable|string|max:7',
            'sizes.*.name' => 'nullable|string|max:255',
            'variants.*.color_id' => 'nullable|integer',
            'variants.*.size_id' => 'nullable|integer',
            'variants.*.price' => 'nullable|numeric|min:0',
            'variants.*.stock' => 'nullable|integer|min:0',
            'variants.*.sku' => 'nullable|string|max:255',
        ], [
            'images.*.max' => 'Each image must be less than 5MB.',
            'images.*.image' => 'The uploaded file must be an image.',
            'images.*.mimes' => 'Images must be in jpeg, png, jpg, or gif format.',
            'base_price.required' => 'Please provide a base price.',
            'category_id.required' => 'Please select a category.',
        ]);

        DB::beginTransaction();
        try {
            // Update product
            $product->update([
                'name' => $validated['name'],
                'slug' => Str::slug($validated['name']),
                'description' => $validated['description'] ?? null,
                'base_price' => $validated['base_price'],
                'delivery_charge' => $request->input('delivery_charge') !== '' ? $request->input('delivery_charge') : null,
                'category_id' => $validated['category_id'],
                'brand_id' => $validated['brand_id'] ?? null,
                'stock_quantity' => $validated['stock_quantity'],
                'sku' => $validated['sku'] ?? null,
                'rating' => $validated['rating'] ?? 0,
                'is_active' => $request->has('is_active'),
                'is_deal' => $request->has('is_deal'),
            ]);

            // Handle image deletion
            if ($request->has('delete_images')) {
                foreach ($request->delete_images as $imageId) {
                    $image = ProductImage::find($imageId);
                    if ($image && $image->product_id === $product->id) {
                        Storage::disk('public')->delete($image->image_path);
                        $image->delete();
                    }
                }
            }

            // Handle new images
            if ($request->hasFile('images')) {
                $existingImagesCount = $product->images()->count();
                foreach ($request->file('images') as $index => $image) {
                    $imagePath = $image->store('products', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $imagePath,
                        'is_primary' => $existingImagesCount === 0 && $index === 0,
                        'sort_order' => $existingImagesCount + $index,
                    ]);
                }
            }

            // Delete existing colors, sizes, and variants
            $product->colors()->delete();
            $product->sizes()->delete();
            $product->variants()->delete();

            // Re-create colors
            $colorMap = [];
            $colorsData = $request->has('colors_json') ? json_decode($request->input('colors_json'), true) : ($request->input('colors', []));
            foreach (($colorsData ?? []) as $index => $colorData) {
                if (!empty($colorData['code'])) {
                    $color = ProductColor::create([
                        'product_id' => $product->id,
                        'color_name' => trim($colorData['name'] ?? '') ?: 'Color ' . ($index + 1),
                        'color_code' => $colorData['code'],
                    ]);
                    $colorMap[$index] = $color->id;
                }
            }

            // Re-create sizes
            $sizeMap = [];
            $sizesData = $request->has('sizes_json') ? json_decode($request->input('sizes_json'), true) : ($request->input('sizes', []));
            foreach (($sizesData ?? []) as $index => $sizeData) {
                if (!empty($sizeData['name'])) {
                    $size = ProductSize::create([
                        'product_id' => $product->id,
                        'size_name' => trim($sizeData['name']),
                    ]);
                    $sizeMap[$index] = $size->id;
                }
            }

            // Re-create variants
            $savedVariantKeys = [];
            if ($request->has('variants')) {
                foreach ($request->variants as $variantData) {
                    $colorId = isset($variantData['color_id']) && $variantData['color_id'] !== '' && $variantData['color_id'] !== 'null'
                        ? ($colorMap[(int)$variantData['color_id']] ?? null)
                        : null;
                    $sizeId = isset($variantData['size_id']) && $variantData['size_id'] !== '' && $variantData['size_id'] !== 'null'
                        ? ($sizeMap[(int)$variantData['size_id']] ?? null)
                        : null;

                    if ($colorId !== null || $sizeId !== null) {
                        $key = ($colorId ?? 'n') . '_' . ($sizeId ?? 'n');
                        if (isset($savedVariantKeys[$key])) continue; // skip duplicates
                        $savedVariantKeys[$key] = true;

                        ProductVariant::create([
                            'product_id'     => $product->id,
                            'color_id'       => $colorId,
                            'size_id'        => $sizeId,
                            'price'          => !empty($variantData['price']) ? $variantData['price'] : $validated['base_price'],
                            'stock_quantity' => $variantData['stock'] ?? 0,
                            'sku'            => $variantData['sku'] ?? null,
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('admin.products.index')
                ->with('success', 'Product updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Failed to update product: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        DB::beginTransaction();
        try {
            // Delete all product images
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image->image_path);
            }

            // Delete product (cascade will handle related records)
            $product->delete();

            DB::commit();
            return redirect()->route('admin.products.index')
                ->with('success', 'Product deleted successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete product: ' . $e->getMessage());
        }
    }
}
