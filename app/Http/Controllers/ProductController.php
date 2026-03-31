<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductSize;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'images', 'colors', 'sizes', 'variants'])
            ->where('is_active', true);

        // Filter by categories
        if ($request->has('categories') && is_array($request->categories)) {
            $query->whereIn('category_id', $request->categories);
        }

        // Filter by colors
        if ($request->has('colors') && is_array($request->colors)) {
            $query->whereHas('colors', function($q) use ($request) {
                $q->whereIn('color_name', $request->colors);
            });
        }

        // Filter by sizes
        if ($request->has('sizes') && is_array($request->sizes)) {
            $query->whereHas('sizes', function($q) use ($request) {
                $q->whereIn('size_name', $request->sizes);
            });
        }

        // Filter by brands
        if ($request->has('brands') && is_array($request->brands)) {
            $query->whereIn('brand_id', $request->brands);
        }

        // Filter by rating
        if ($request->has('ratings') && is_array($request->ratings)) {
            $minRating = min(array_map('intval', $request->ratings));
            $query->where('rating', '>=', $minRating);
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('base_price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('base_price', '<=', $request->max_price);
        }

        // Search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('base_price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('base_price', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12);
        
        // Fetch all categories for filter with product count
        $categories = Category::where('is_active', true)->withCount('products')->get();
        
        // Fetch unique brands for filter
        $allBrands = \App\Models\Brand::where('is_active', true)
            ->whereHas('products')
            ->get();
        
        // Fetch unique color names and sizes for filter from existing records
        $allColors = ProductColor::select('color_name', 'color_code')->distinct()->get();
        $allSizes = ProductSize::select('size_name')->distinct()->get();

        if ($request->ajax()) {
            return response()->json([
                'products' => view('pages.partials.product-list', compact('products'))->render(),
                'pagination' => (string) $products->links()
            ]);
        }

        return view('pages.shop', compact('products', 'categories', 'allColors', 'allSizes', 'allBrands'));
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $product = Product::with(['category', 'images', 'colors', 'sizes', 'variants.color', 'variants.size'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();

        return view('pages.product-details', compact('product', 'relatedProducts'));
    }
    public function categories()
    {
        $categories = Category::withCount('products')
            ->where('is_active', true)
            ->get();
            
        $popularCategories = Category::withCount('products')
            ->where('is_active', true)
            ->where('is_popular', true)
            ->get();
            
        $brands = \App\Models\Brand::withCount('products')
            ->where('is_active', true)
            ->get();
            
        // Fetch CMS Content
        $page = \App\Models\Page::where('slug', 'categories')->with('sections')->first();
        $heroSection = $page ? $page->sections->where('key', 'hero')->first() : null;
        $bannerSection = $page ? $page->sections->where('key', 'banner')->first() : null;
        
        $heroContent = $heroSection ? $heroSection->content : null;
        $bannerContent = $bannerSection ? $bannerSection->content : null;

        return view('pages.categories', compact('categories', 'popularCategories', 'brands', 'heroContent', 'bannerContent'));
    }
}
