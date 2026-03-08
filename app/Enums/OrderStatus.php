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
            self::New => 'Новый',
            self::Processed => 'Обработан',
            self::Paid => 'Оплачен',
            self::Delivered => 'Доставлен',
            self::Completed => 'Завершен',
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
