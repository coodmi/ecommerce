<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user')->latest();

        if ($search = trim($request->get('search', ''))) {
            $query->where(function ($q) use ($search) {
                // Search by order ID (numeric)
                if (is_numeric($search)) {
                    $q->where('id', $search);
                }
                // Search by customer name or email via user relation
                $q->orWhereHas('user', function ($uq) use ($search) {
                    $uq->where('name', 'like', "%{$search}%")
                       ->orWhere('email', 'like', "%{$search}%");
                });
                // Search in checkout_details JSON (name/email entered at checkout)
                $q->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(checkout_details, '$.full_name')) LIKE ?", ["%{$search}%"])
                  ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(checkout_details, '$.email')) LIKE ?", ["%{$search}%"]);
            });
        }

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        $orders = $query->paginate(15)->withQueryString();

        return view('dashboard.admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['items.product', 'user']);
        return view('dashboard.admin.orders.show', compact('order'));
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(['success' => true, 'message' => 'Order deleted successfully.']);
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        $order->update(['status' => $validated['status']]);

        return back()->with('success', 'Order status updated successfully.');
    }

    public function updateNotes(Request $request, Order $order)
    {
        $validated = $request->validate([
            'notes' => 'nullable|string'
        ]);

        $order->update(['notes' => $validated['notes']]);

        return back()->with('success', 'Order notes updated successfully.');
    }
}
