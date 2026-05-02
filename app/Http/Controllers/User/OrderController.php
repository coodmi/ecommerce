<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();
        $status = $request->get('status');

        $statuses = ['processing', 'shipped', 'delivered', 'cancelled', 'on_hold'];

        $counts = ['all' => Order::where('user_id', $userId)->count()];
        foreach ($statuses as $s) {
            $counts[$s] = Order::where('user_id', $userId)->where('status', $s)->count();
        }

        $query = Order::where('user_id', $userId)
            ->with(['items.product.primaryImage'])
            ->latest();

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        $orders = $query->paginate(10)->withQueryString();

        return view('dashboard.user.orders.index', compact('orders', 'counts', 'status'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load(['items.product.primaryImage']);
        return view('dashboard.user.orders.show', compact('order'));
    }
}
