<?php

declare(strict_types=1);

namespace App\Support\Money;

use InvalidArgumentException;

final readonly class Money
{
    /**
     * Amount is stored in minor units so every operation stays exact.
     */
    public function __construct(
        public int $amount,
        public Currency $currency,
    ) {
        if ($amount < 0) {
            throw new InvalidArgumentException('Money amount cannot be negative.');
        }
    }

    public static function zero(string|Currency $currency = 'KZT'): self
    {
        return new self(0, self::currency($currency));
    }

    public static function fromMinor(int $amount, string|Currency $currency = 'KZT'): self
    {
        return new self($amount, self::currency($currency));
    }

    public static function fromDecimal(string|int|float $decimal, string|Currency $currency = 'KZT'): self
    {
        $normalized = self::normalizeDecimal($decimal, 2);
        [$whole, $fraction] = self::splitDecimal($normalized, 2);

        return new self((int) ($whole.$fraction), self::currency($currency));
    }

    /**
     * Normalizes decimal input with half-up rounding before it is persisted or serialized.
     */
    public static function normalizeDecimal(string|int|float $decimal, int $scale = 2): string
    {
        if ($scale < 0) {
            throw new InvalidArgumentException('Decimal scale cannot be negative.');
        }

        $value = self::sanitizeDecimal($decimal);
        $truncated = bcadd($value, '0', $scale);
        $roundingDigit = self::fractionDigit($value, $scale + 1);

        if ($roundingDigit < 5) {
            return $truncated;
        }

        return bcadd($truncated, self::increment($scale), $scale);
    }

    public function multiply(int $qty): self
    {
        if ($qty < 0) {
            throw new InvalidArgumentException('Money multiplier cannot be negative.');
        }

        return new self($this->amount * $qty, $this->currency);
    }

    public function add(self $other): self
    {
        $this->guardCurrency($other);

        return new self($this->amount + $other->amount, $this->currency);
    }

    public function subtract(self $other): self
    {
        $this->guardCurrency($other);

        return new self($this->amount - $other->amount, $this->currency);
    }

    public function convert(string|Currency $currency, string|int|float $exchangeRate): self
    {
        $targetCurrency = self::currency($currency);
        $normalizedRate = self::normalizeDecimal($exchangeRate, 6);

        if (bccomp($normalizedRate, '0', 6) <= 0) {
            throw new InvalidArgumentException('Exchange rate must be greater than zero.');
        }

        if ($this->currency->equals($targetCurrency)) {
            return new self($this->amount, $this->currency);
        }

        // Keep a higher intermediate scale before rounding back to money precision.
        $converted = bcdiv($this->toDecimal(), $normalizedRate, 10);

        return self::fromDecimal($converted, $targetCurrency);
    }

    public function toDecimal(): string
    {
        $whole = intdiv($this->amount, 100);
        $fraction = str_pad((string) ($this->amount % 100), 2, '0', STR_PAD_LEFT);

        return $whole.'.'.$fraction;
    }

    public function equals(self $other): bool
    {
        return $this->amount === $other->amount && $this->currency->equals($other->currency);
    }

    private static function currency(string|Currency $currency): Currency
    {
        return $currency instanceof Currency ? $currency : new Currency($currency);
    }

    private static function sanitizeDecimal(string|int|float $decimal): string
    {
        if (is_int($decimal)) {
            return (string) $decimal;
        }

        if (is_float($decimal)) {
            $decimal = rtrim(rtrim(sprintf('%.14F', $decimal), '0'), '.');
        }

        $value = trim(str_replace(',', '.', (string) $decimal));

        if ($value === '') {
            throw new InvalidArgumentException('Decimal value cannot be empty.');
        }

        if (str_starts_with($value, '-')) {
            throw new InvalidArgumentException('Decimal value cannot be negative.');
        }

        if (str_starts_with($value, '.')) {
            $value = '0'.$value;
        }

        if (! preg_match('/^\d+(?:\.\d+)?$/', $value)) {
            throw new InvalidArgumentException('Decimal value must contain digits only.');
        }

        return $value;
    }

    /**
     * @return array{0: string, 1: string}
     */
    private static function splitDecimal(string $decimal, int $scale): array
    {
        [$whole, $fraction] = array_pad(explode('.', $decimal, 2), 2, '');

        return [$whole, str_pad($fraction, $scale, '0')];
    }

    private static function fractionDigit(string $decimal, int $position): int
    {
        if ($position <= 0) {
            return 0;
        }

        [, $fraction] = array_pad(explode('.', $decimal, 2), 2, '');

        if (strlen($fraction) < $position) {
            return 0;
        }

        return (int) $fraction[$position - 1];
    }

    private static function increment(int $scale): string
    {
        if ($scale === 0) {
            return '1';
        }

        return '0.'.str_repeat('0', $scale - 1).'1';
    }

    private function guardCurrency(self $other): void
    {
        if (! $this->currency->equals($other->currency)) {
            throw new InvalidArgumentException(
                "Cannot operate on different currencies: {$this->currency->code} and {$other->currency->code}."
            );
        }
    }
}
