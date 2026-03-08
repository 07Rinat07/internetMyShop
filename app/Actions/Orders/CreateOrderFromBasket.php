<?php

namespace App\Actions\Orders;

use App\Enums\OrderStatus;
use App\Models\Basket;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class CreateOrderFromBasket
{
    public function execute(Basket $basket, array $payload, ?int $userId = null): Order
    {
        return DB::transaction(function () use ($basket, $payload, $userId) {
            $order = new Order($payload);
            $order->amount = $basket->getAmount();
            $order->status = OrderStatus::New->value;
            $order->user_id = $userId;
            $order->save();

            foreach ($basket->products as $product) {
                $order->items()->create([
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $product->pivot->quantity,
                    'cost' => $product->price * $product->pivot->quantity,
                ]);
            }

            $basket->clear();

            return $order;
        });
    }
}
