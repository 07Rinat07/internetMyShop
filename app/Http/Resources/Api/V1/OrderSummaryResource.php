<?php

namespace App\Http\Resources\Api\V1;

use App\Models\Order;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderSummaryResource extends JsonResource {
    public function toArray($request) {
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'status' => [
                'code' => (int)$this->status,
                'label' => Order::STATUSES[(int)$this->status] ?? null,
            ],
            'items_count' => (int)($this->items_count ?? $this->items->count()),
            'created_at' => optional($this->created_at)->toIso8601String(),
            'updated_at' => optional($this->updated_at)->toIso8601String(),
        ];
    }
}
