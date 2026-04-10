<?php

declare(strict_types=1);

namespace App\Support\Money;

final class MoneyFormatter
{
    public static function format(string|int|float $amount, int $scale = 2): string
    {
        $normalized = Money::normalizeDecimal($amount, $scale);
        [$whole, $fraction] = array_pad(explode('.', $normalized, 2), 2, '');
        $formattedWhole = preg_replace('/\B(?=(\d{3})+(?!\d))/', ' ', $whole) ?: $whole;

        if ((int) $fraction === 0) {
            return $formattedWhole;
        }

        return $formattedWhole.'.'.$fraction;
    }

    public static function toNumeric(string|int|float $amount, int $scale = 2): int|float
    {
        $normalized = Money::normalizeDecimal($amount, $scale);

        if (! str_contains($normalized, '.')) {
            return (int) $normalized;
        }

        [$whole, $fraction] = explode('.', $normalized, 2);

        if ((int) $fraction === 0) {
            return (int) $whole;
        }

        return (float) $normalized;
    }
}
