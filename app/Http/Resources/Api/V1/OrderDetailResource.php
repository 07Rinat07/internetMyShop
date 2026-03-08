<?php

namespace App\Http\Resources\Api\V1;

class OrderDetailResource extends OrderSummaryResource {
    public function toArray($request) {
        return array_merge(parent::toArray($request), [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'comment' => $this->comment,
            'items' => OrderItemResource::collection($this->whenLoaded('items')),
        ]);
    }
}
