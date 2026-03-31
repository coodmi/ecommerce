<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductSize;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        
        $total = 0;
        foreach($cart as $id => $details) {
            $total += $details['price'] * $details['quantity'];
        }

        return view('pages.cart', compact('cart', 'total'));
    }

    public function add(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);
            $cart = session()->get('cart', []);
            $quantity = (int) $request->get('quantity', 1);
            
            // Basic support for variations in the cart display
            $colorId = $request->get('color_id');
            $sizeId = $request->get('size_id');
            
            $colorName = $colorId ? ProductColor::find($colorId)?->color_name : null;
            $sizeName = $sizeId ? ProductSize::find($sizeId)?->size_name : null;

            // Generate a unique key for items with different variations
            $cartKey = $id;
            if ($colorId || $sizeId) {
                $cartKey = $id . '-' . ($colorId ?? '0') . '-' . ($sizeId ?? '0');
            }

            if(isset($cart[$cartKey])) {
                $cart[$cartKey]['quantity'] += $quantity;
            } else {
                $image = $product->primaryImage ?? $product->images->first();
                
                // Determine price (simplified: use base_price for now or use variation price if we lookup variant)
                $price = (float)$product->base_price;
                
                // If variant exists and has a price, we should ideally use that.
                // For now, let's keep it simple as the landing page mostly uses base_price.
                
                $cart[$cartKey] = [
                    "product_id" => $product->id,
                    "name" => $product->name,
                    "quantity" => $quantity,
                    "price" => $price,
                    "image" => $image ? $image->image_path : '',
                    "color" => $colorName,
                    "size" => $sizeName
                ];
            }

            session()->put('cart', $cart);

            if($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'cart_count' => count($cart),
                    'message' => 'Product added to cart successfully!',
                    'redirect' => route('cart.index')
                ]);
            }

            return redirect()->route('cart.index')->with('success', 'Product added to cart successfully!');
        } catch (\Exception $e) {
            if($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ], 500);
            }
            return back()->with('error', 'Could not add product to cart.');
        }
    }

    public function update(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                $cart[$request->id]["quantity"] = $request->quantity;
                session()->put('cart', $cart);
                
                $total = 0;
                foreach($cart as $item) {
                    $total += $item['price'] * $item['quantity'];
                }

                return response()->json([
                    'success' => true,
                    'total' => number_format($total, 2),
                    'item_total' => number_format($cart[$request->id]['price'] * $cart[$request->id]['quantity'], 2),
                    'cart_count' => count($cart)
                ]);
            }
        }
        return response()->json(['success' => false], 400);
    }

    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            
            $total = 0;
            foreach($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            return response()->json([
                'success' => true,
                'total' => number_format($total, 2),
                'cart_count' => count($cart)
            ]);
        }
        return response()->json(['success' => false], 400);
    }
}
