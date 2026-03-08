<?php

namespace App\Domain\Catalog\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProductFilters
{
    private Builder $builder;

    public function __construct(private readonly Request $request) {}

    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;

        foreach ($this->request->query() as $filter => $value) {
            if (method_exists($this, $filter)) {
                $this->{$filter}($value);
            }
        }

        return $this->builder;
    }

    private function price(string $value): void
    {
        if (! in_array($value, ['min', 'max'], true)) {
            return;
        }

        $count = (clone $this->builder)->count();

        if ($count <= 1) {
            return;
        }

        $min = (float) (clone $this->builder)->min('price');
        $max = (float) (clone $this->builder)->max('price');
        $avg = ($min + $max) * 0.5;

        if ($value === 'min') {
            $this->builder->where('price', '<=', $avg);

            return;
        }

        $this->builder->where('price', '>=', $avg);
    }

    private function new(string $value): void
    {
        if ($value === 'yes') {
            $this->builder->where('new', true);
        }
    }

    private function hit(string $value): void
    {
        if ($value === 'yes') {
            $this->builder->where('hit', true);
        }
    }

    private function sale(string $value): void
    {
        if ($value === 'yes') {
            $this->builder->where('sale', true);
        }
    }
}
