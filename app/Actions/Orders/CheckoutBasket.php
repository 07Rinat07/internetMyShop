<?php

namespace App\Actions\Orders;

use App\DTO\Orders\CheckoutBasketResult;
use App\Enums\PaymentMethod;
use App\Models\Basket;
use App\Services\Payments\PaymentService;

class CheckoutBasket
{
    public function __construct(
        private readonly CreateOrderFromBasket $createOrderFromBasket,
        private readonly PaymentService $paymentService,
    ) {}

    public function execute(Basket $basket, array $payload, ?int $userId = null): CheckoutBasketResult
    {
        $order = $this->createOrderFromBasket->execute($basket, $payload, $userId);
        $paymentMethod = PaymentMethod::from((string) $order->payment_method);
        $payment = null;

        if ($paymentMethod === PaymentMethod::OnlineCard) {
            $payment = $this->paymentService->createForOrder($order);
        }

        $basket->clear();

        return new CheckoutBasketResult(
            order: $order->fresh(['items.product', 'payments']),
            payment: $payment?->fresh(['order.items']),
        );
    }
}
