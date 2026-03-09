<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderController extends Controller {

    public function index() {
        $this->authorize('viewAny', Order::class);

        $orders = Order::whereUserId(auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate(5);
        $statuses = Order::STATUSES;
        return view('user.order.index', compact('orders', 'statuses'));
    }

    public function show(Order $order) {
        $this->authorize('view', $order);

        $statuses = Order::STATUSES;
        $order->load('payments');

        return view('user.order.show', compact('order', 'statuses'));
    }
}
