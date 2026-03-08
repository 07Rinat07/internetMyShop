<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Orders\CreateOrderFromBasket;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\BasketResource;
use App\Http\Resources\Api\V1\OrderDetailResource;
use App\Http\Requests\CheckoutOrderRequest;
use App\Models\Basket;
use App\Models\Product;
use Illuminate\Http\Request;

class BasketController extends Controller {
    private $createOrderFromBasket;

    public function __construct(CreateOrderFromBasket $createOrderFromBasket) {
        $this->createOrderFromBasket = $createOrderFromBasket;
    }

    public function show() {
        return $this->basketResponse($this->basket());
    }

    public function storeItem(Request $request) {
        $validated = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'nullable|integer|min:1|max:255',
        ]);

        $basket = $this->basket();
        $basket->increase($validated['product_id'], $validated['quantity'] ?? 1);

        return $this->basketResponse($basket);
    }

    public function updateItem(Request $request, Product $product) {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:255',
        ]);

        $basket = $this->basket();
        $basket->setQuantity($product->id, $validated['quantity']);

        return $this->basketResponse($basket);
    }

    public function destroyItem(Product $product) {
        $basket = $this->basket();
        $basket->remove($product->id);

        return $this->basketResponse($basket);
    }

    public function clear() {
        $basket = $this->basket();
        $basket->clear();

        return $this->basketResponse($basket);
    }

    public function checkout(CheckoutOrderRequest $request) {
        $basket = $this->basket();
        if ($basket->products->isEmpty()) {
            return response()->json([
                'message' => 'Basket is empty.',
                'errors' => [
                    'basket' => ['Basket is empty.'],
                ],
            ], 422);
        }

        $order = $this->createOrderFromBasket->execute(
            $basket,
            $request->validated(),
            optional(auth('sanctum')->user())->id ?: auth()->id()
        );
        $basket->clear();

        return response()->json([
            'data' => (new OrderDetailResource($order->load(['items.product'])))->resolve(),
        ], 201);
    }

    private function basket() {
        return Basket::getBasket()->load(['products.brand', 'products.category']);
    }

    private function basketResponse(Basket $basket) {
        return response()->json([
            'data' => (new BasketResource($basket->fresh()->load(['products.brand', 'products.category'])))->resolve(),
        ]);
    }
}
