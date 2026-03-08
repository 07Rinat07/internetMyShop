<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Concerns\InteractsWithPagination;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\OrderDetailResource;
use App\Http\Resources\Api\V1\OrderSummaryResource;
use App\Models\Order;

class OrderController extends Controller {
    use InteractsWithPagination;

    public function index() {
        $orders = auth()->user()->orders()
            ->withCount('items')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json([
            'data' => OrderSummaryResource::collection($orders->getCollection())->resolve(),
            'meta' => $this->paginationMeta($orders),
            'links' => $this->paginationLinks($orders),
        ]);
    }

    public function show(Order $order) {
        $order = $this->ownedOrder($order)->load(['items.product']);

        return response()->json([
            'data' => (new OrderDetailResource($order))->resolve(),
        ]);
    }

    private function ownedOrder(Order $order) {
        if ((int)$order->user_id !== (int)auth()->id()) {
            abort(404);
        }

        return $order;
    }
}
