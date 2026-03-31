<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Page;

class DealsController extends Controller
{
    public function index()
    {
        $page = Page::where('slug', 'deals')->with('sections')->first();
        $sections = $page ? $page->sections->pluck('content', 'key') : collect();

        // 1. Top Deals: products where is_deal = true, fallback to latest active
        $topDeals = Product::where('is_deal', true)
            ->where('is_active', true)
            ->with(['primaryImage', 'images', 'category'])
            ->latest()
            ->take(6)
            ->get();

        if ($topDeals->isEmpty()) {
            $topDeals = Product::where('is_active', true)
                ->with(['primaryImage', 'images', 'category'])
                ->latest()
                ->take(6)
                ->get();
        }

        // 2. Lightning Deals: random active products (prefer is_deal)
        $lightningDeals = Product::where('is_deal', true)
            ->where('is_active', true)
            ->with(['primaryImage', 'images', 'category'])
            ->inRandomOrder()
            ->take(4)
            ->get();

        if ($lightningDeals->isEmpty()) {
            $lightningDeals = Product::where('is_active', true)
                ->with(['primaryImage', 'images', 'category'])
                ->inRandomOrder()
                ->take(4)
                ->get();
        }

        // 3. Deals by Category: categories marked is_deal, fallback to popular categories
        $dealCategories = Category::where('is_deal', true)
            ->where('is_active', true)
            ->with(['products' => function($query) {
                $query->where('is_active', true)->take(6);
            }, 'products.primaryImage', 'products.images'])
            ->get();

        if ($dealCategories->isEmpty()) {
            $dealCategories = Category::where('is_active', true)
                ->with(['products' => function($query) {
                    $query->where('is_active', true)->take(6);
                }, 'products.primaryImage', 'products.images'])
                ->take(4)
                ->get();
        }

        return view('pages.deals', compact('topDeals', 'lightningDeals', 'dealCategories', 'sections'));
    }
}
