<?php

namespace App\Enums;

enum PaymentProvider: string
{
    case Fake = 'fake';
    case PayPal = 'paypal';

    public function label(): string
    {
        return match ($this) {
            self::Fake => __('site.payment_provider.fake'),
            self::PayPal => __('site.payment_provider.paypal'),
        };
    }
}
