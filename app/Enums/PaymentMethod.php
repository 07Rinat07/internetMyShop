<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case OnlineCard = 'online_card';
    case ManagerConfirmation = 'manager_confirmation';

    public function label(): string
    {
        return match ($this) {
            self::OnlineCard => __('site.payment_method.online_card'),
            self::ManagerConfirmation => __('site.payment_method.manager_confirmation'),
        };
    }

    /**
     * @return array<string>
     */
    public static function values(): array
    {
        return array_map(static fn (self $method): string => $method->value, self::cases());
    }
}
