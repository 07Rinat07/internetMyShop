<?php

namespace App\Contracts\Payments;

use App\DTO\Payments\PaymentCreationResult;
use App\DTO\Payments\PaymentResolutionResult;
use App\Models\Order;
use App\Models\Payment;

interface PaymentProviderDriver
{
    public function code(): string;

    public function createPayment(Payment $payment, Order $order): PaymentCreationResult;

    public function finalizePayment(Payment $payment, array $parameters = []): PaymentResolutionResult;

    public function checkoutConfiguration(Payment $payment): array;

    public function verifyWebhook(array $headers, array $payload): bool;

    public function resolveWebhook(array $payload): PaymentResolutionResult;
}
