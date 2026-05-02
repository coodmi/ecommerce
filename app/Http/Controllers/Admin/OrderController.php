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
                // Strip common prefixes so "#EA-00006", "EA-00006", "00006", "6" all work
                $numericId = preg_replace('/[^0-9]/', '', $search);

                if ($numericId !== '') {
                    $q->orWhere('id', (int)$numericId);
                }

                // Search by customer name or email via user relation
                $q->orWhereHas('user', function ($uq) use ($search) {
                    $uq->where('name', 'like', "%{$search}%")
                       ->orWhere('email', 'like', "%{$search}%");
                });

                // Search in checkout_details JSON
                $q->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(checkout_details, '$.full_name')) LIKE ?", ["%{$search}%"])
                  ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(checkout_details, '$.email')) LIKE ?", ["%{$search}%"]);
            });
        }

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        $orders = $query->paginate(15)->withQueryString();

        $statuses = ['processing', 'shipped', 'delivered', 'cancelled', 'on_hold'];
        $counts = ['all' => Order::count()];
        foreach ($statuses as $s) {
            $counts[$s] = Order::where('status', $s)->count();
        }

        return view('dashboard.admin.orders.index', compact('orders', 'counts'));
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
            'status' => 'required|in:pending,processing,shipped,delivered,completed,cancelled,on_hold'
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
