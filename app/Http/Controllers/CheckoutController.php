<?php

namespace App\Http\Controllers;

use App\Models\CheckoutField;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('shop')->with('error', 'Your cart is empty.');
        }

        $total = 0;
        foreach ($cart as $details) {
            $total += $details['price'] * $details['quantity'];
        }

        $fields = CheckoutField::where('is_active', true)->orderBy('sort_order')->get();
        $deliveryZones = \App\Models\DeliveryZone::active();

        $deliveryCharge        = (float) \App\Models\Setting::get('delivery_charge', 0);
        $deliveryFreeThreshold = (float) \App\Models\Setting::get('delivery_free_threshold', 0);
        $deliveryLabel         = \App\Models\Setting::get('delivery_label', 'Delivery Charge');
        $shipping = 0;
        if ($deliveryCharge > 0) {
            $shipping = ($deliveryFreeThreshold > 0 && $total >= $deliveryFreeThreshold) ? 0 : $deliveryCharge;
        }
        $grandTotal = $total + $shipping;

        return view('pages.checkout', compact('cart', 'total', 'fields', 'deliveryZones', 'shipping', 'deliveryLabel', 'grandTotal'));
    }

    public function store(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return response()->json(['success' => false, 'message' => 'Your cart is empty.'], 400);
        }

        // Always validate these core fields (hardcoded in the form)
        $rules = [
            'delivery_zone' => 'required|exists:delivery_zones,id',
            'full_name'     => 'required|string|max:255',
            'phone'         => 'required|string|max:50',
            'email'         => 'nullable|email|max:255',
            'full_address'  => 'required|string|max:1000',
            'order_notes'   => 'nullable|string|max:1000',
        ];

        // Also add any extra dynamic checkout fields
        $fields = CheckoutField::where('is_active', true)->orderBy('sort_order')->get();
        $coreFields = ['full_name', 'phone', 'email', 'full_address', 'order_notes', 'delivery_zone'];
        foreach ($fields as $field) {
            if (!in_array($field->name, $coreFields)) {
                $rule = $field->is_required ? ['required'] : ['nullable'];
                if ($field->type === 'email') $rule[] = 'email';
                $rules[$field->name] = implode('|', $rule);
            }
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
                'message' => 'Please fix the errors below.',
            ], 422);
        }

        $validated = $validator->validated();

        // Build checkout details (exclude internal fields)
        $checkoutDetails = collect($validated)
            ->except(['delivery_zone', 'shipping_cost', 'total_amount'])
            ->toArray();

        try {
            DB::beginTransaction();

            $subtotal = 0;
            foreach ($cart as $details) {
                $subtotal += $details['price'] * $details['quantity'];
            }

            // Use the selected delivery zone charge
            $shipping = 0;
            $zone = \App\Models\DeliveryZone::find($request->delivery_zone);
            if ($zone) {
                $shipping = (float) $zone->charge;
            }

            $total = $subtotal + $shipping;

            $order = Order::create([
                'user_id'          => auth()->id(),
                'total_amount'     => $total,
                'status'           => 'pending',
                'checkout_details' => $checkoutDetails,
                'payment_method'   => 'Cash on Delivery',
            ]);

            foreach ($cart as $id => $details) {
                $productId = $details['product_id'] ?? (is_numeric($id) ? $id : explode('-', $id)[0]);

                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $productId,
                    'quantity'   => $details['quantity'],
                    'price'      => $details['price'],
                    'color'      => $details['color'] ?? null,
                    'size'       => $details['size'] ?? null,
                ]);
            }

            session()->forget('cart');
            session(['last_order_id' => $order->id]);
            DB::commit();

            return response()->json([
                'success'  => true,
                'message'  => 'Order placed successfully!',
                'redirect' => route('order.invoice', $order->id),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function invoice(Order $order)
    {
        // Allow owner, admin, or if order was just placed (stored in session)
        $justPlaced = session('last_order_id') == $order->id;
        $isOwner    = auth()->check() && $order->user_id === auth()->id();
        $isAdmin    = auth()->check() && auth()->user()->isAdmin();

        if (!$justPlaced && !$isOwner && !$isAdmin) {
            abort(403);
        }

        $order->load(['items.product.primaryImage', 'user']);

        return view('pages.invoice', compact('order'));
    }
}
