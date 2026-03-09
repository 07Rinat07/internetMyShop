<?php

namespace App\DTO\Payments;

use App\Enums\PaymentStatus;

readonly class PaymentCreationResult
{
    public function __construct(
        public PaymentStatus $status,
        public ?string $providerPaymentId = null,
        public ?string $redirectUrl = null,
        public array $requestPayload = [],
        public array $responsePayload = [],
        public ?string $failureReason = null,
    ) {
    }
}
