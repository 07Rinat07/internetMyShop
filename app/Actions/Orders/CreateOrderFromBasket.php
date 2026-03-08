<?php

namespace App\Actions\Orders;

use App\Models\Basket;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class CreateOrderFromBasket {
    public function execute(Basket $basket, array $payload, ?int $userId = null): Order {
        return DB::transaction(function () use ($basket, $payload, $userId) {
            $order = Order::create(array_merge($payload, [
                'amount' => $basket->getAmount(),
                'status' => 0,
                'user_id' => $userId,
            ]));

            foreach ($basket->products as $product) {
                $order->items()->create([
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $product->pivot->quantity,
                    'cost' => $product->price * $product->pivot->quantity,
                ]);
            }

            return $order;
        });
    }
}
