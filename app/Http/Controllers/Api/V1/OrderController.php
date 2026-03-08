<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Concerns\InteractsWithPagination;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\OrderDetailResource;
use App\Http\Resources\Api\V1\OrderSummaryResource;
use App\Models\Order;

class OrderController extends Controller
{
    use InteractsWithPagination;

    public function __construct()
    {
        $this->authorizeResource(Order::class, 'order', ['except' => ['index']]);
    }

    public function index()
    {
        $this->authorize('viewAny', Order::class);

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

    public function show(Order $order)
    {
        $this->authorize('view', $order);

        $order = $order->load(['items.product']);

        return response()->json([
            'data' => (new OrderDetailResource($order))->resolve(),
        ]);
    }
}
