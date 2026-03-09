<?php

namespace App\DTO\Orders;

use App\Models\Order;
use App\Models\Payment;

readonly class CheckoutBasketResult
{
    public function __construct(
        public Order $order,
        public ?Payment $payment = null,
    ) {
    }
}
