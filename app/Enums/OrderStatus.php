<?php

namespace App\Enums;

enum OrderStatus: int
{
    case New = 0;
    case Processed = 1;
    case Paid = 2;
    case Delivered = 3;
    case Completed = 4;

    public function label(): string
    {
        return match ($this) {
            self::New => __('site.order_status.new'),
            self::Processed => __('site.order_status.processed'),
            self::Paid => __('site.order_status.paid'),
            self::Delivered => __('site.order_status.delivered'),
            self::Completed => __('site.order_status.completed'),
        };
    }

    /**
     * @return array<int, string>
     */
    public static function labels(): array
    {
        $labels = [];

        foreach (self::cases() as $status) {
            $labels[$status->value] = $status->label();
        }

        return $labels;
    }

    /**
     * @return array<int>
     */
    public static function values(): array
    {
        return array_map(static fn (self $status): int => $status->value, self::cases());
    }
}
