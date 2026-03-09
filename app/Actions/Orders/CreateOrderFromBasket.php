<?php

namespace App\Actions\Orders;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
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
            $order->currency = (string) ($payload['currency'] ?? config('payments.store_currency', 'KZT'));
            $order->status = OrderStatus::New->value;
            $order->payment_method = (string) ($payload['payment_method'] ?? PaymentMethod::ManagerConfirmation->value);
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

            return $order;
        });
    }
}
