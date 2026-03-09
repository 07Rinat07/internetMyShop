<?php

namespace App\Services\Payments;

use App\Contracts\Payments\PaymentProviderDriver;
use App\Enums\PaymentProvider;
use App\Services\Payments\Providers\FakePaymentProvider;
use App\Services\Payments\Providers\PayPalProvider;
use InvalidArgumentException;

class PaymentManager
{
    public function driver(?string $code = null): PaymentProviderDriver
    {
        $code ??= (string) config('payments.default', PaymentProvider::PayPal->value);

        return match ($code) {
            PaymentProvider::Fake->value => app(FakePaymentProvider::class),
            PaymentProvider::PayPal->value => app(PayPalProvider::class),
            default => throw new InvalidArgumentException("Unsupported payment provider [{$code}]."),
        };
    }
}
