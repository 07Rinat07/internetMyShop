<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderController extends Controller {

    public function index() {
        $orders = Order::whereUserId(auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate(5);
        $statuses = Order::STATUSES;
        return view('user.order.index', compact('orders', 'statuses'));
    }

    public function show(Order $order) {
        if ((int)$order->user_id !== (int)auth()->id()) {
            // можно просматривать только свои заказы
            abort(404);
        }
        $statuses = Order::STATUSES;
        return view('user.order.show', compact('order', 'statuses'));
    }
}
