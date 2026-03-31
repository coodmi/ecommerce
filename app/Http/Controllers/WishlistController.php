<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlistItems = Wishlist::with('product.primaryImage')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(12);

        return view('pages.wishlist', compact('wishlistItems'));
    }

    public function toggle(Product $product)
    {
        if (!Auth::check()) {
            return response()->json([
                'status' => 'unauthenticated',
                'message' => 'Please login to manage your wishlist'
            ], 401);
        }

        $wishlistItem = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($wishlistItem) {
            $wishlistItem->delete();
            return response()->json([
                'status' => 'removed',
                'message' => 'Product removed from wishlist'
            ]);
        }

        Wishlist::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id
        ]);

        return response()->json([
            'status' => 'added',
            'message' => 'Product added to wishlist'
        ]);
    }
}
