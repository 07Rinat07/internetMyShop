<?php

namespace App\DTO\Payments;

use App\Enums\PaymentStatus;

readonly class PaymentResolutionResult
{
    public function __construct(
        public PaymentStatus $status,
        public ?string $providerPaymentId = null,
        public ?string $providerOperationId = null,
        public ?string $failureReason = null,
        public array $payload = [],
    ) {
    }
}
