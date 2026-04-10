<?php

declare(strict_types=1);

namespace App\Support\Money;

use InvalidArgumentException;

final readonly class Currency
{
    public string $code;

    public function __construct(string $code)
    {
        $normalized = strtoupper(trim($code));

        if (! preg_match('/^[A-Z]{3}$/', $normalized)) {
            throw new InvalidArgumentException('Currency code must be a 3-letter ISO string.');
        }

        $this->code = $normalized;
    }

    public function equals(self $other): bool
    {
        return $this->code === $other->code;
    }

    public function __toString(): string
    {
        return $this->code;
    }
}
