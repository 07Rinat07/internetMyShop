<?php

namespace App\Http\Resources\Api\V1;

use App\Support\Money\MoneyFormatter;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\OrderItem
 */
class OrderItemResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'name' => $this->name,
            'price' => MoneyFormatter::toNumeric((string) $this->price),
            'quantity' => (int) $this->quantity,
            'cost' => MoneyFormatter::toNumeric((string) $this->cost),
            'product' => $this->product ? [
                'id' => $this->product->id,
                'slug' => $this->product->slug,
            ] : null,
        ];
    }
}
