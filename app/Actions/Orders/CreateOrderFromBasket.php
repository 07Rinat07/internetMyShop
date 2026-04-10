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
            $order->currency = (string) config('payments.store_currency', 'KZT');
            $order->amount = $basket->getAmountMoney()->toDecimal();
            $order->status = OrderStatus::New->value;
            $order->payment_method = (string) ($payload['payment_method'] ?? PaymentMethod::ManagerConfirmation->value);
            $order->user_id = $userId;
            $order->save();

            foreach ($basket->products as $product) {
                $price = $product->priceMoney($order->currency);

                $order->items()->create([
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'price' => $price->toDecimal(),
                    'quantity' => $product->pivot->quantity,
                    'cost' => $price->multiply((int) $product->pivot->quantity)->toDecimal(),
                ]);
            }

            return $order;
        });
    }
}
