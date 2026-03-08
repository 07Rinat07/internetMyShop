<?php

namespace App\Http\Resources\Api\V1;

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
            'price' => $this->price,
            'quantity' => (int) $this->quantity,
            'cost' => $this->cost,
            'product' => $this->product ? [
                'id' => $this->product->id,
                'slug' => $this->product->slug,
            ] : null,
        ];
    }
}
