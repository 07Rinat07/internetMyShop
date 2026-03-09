<?php

namespace App\Http\Controllers;

use App\Actions\Orders\CheckoutBasket;
use App\Http\Requests\CheckoutOrderRequest;
use App\Http\Resources\Api\V1\OrderDetailResource;
use App\Http\Resources\Api\V1\PaymentResource;
use App\Models\Basket;
use App\Models\Order;
use Illuminate\Http\Request;
use Throwable;

class BasketController extends Controller {

    private $basket;
    private $checkoutBasket;

    public function __construct(CheckoutBasket $checkoutBasket) {
        $this->checkoutBasket = $checkoutBasket;
    }

    private function basket() {
        if ($this->basket === null) {
            $this->basket = Basket::getBasket();
        }

        return $this->basket;
    }

    /**
     * Показывает корзину покупателя
     */
    public function index() {
        $basket = $this->basket();
        $products = $basket->products;
        $amount = $basket->getAmount();
        return view('basket.index', compact('products', 'amount'));
    }

    /**
     * Форма оформления заказа
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function checkout(Request $request) {
        $profile = null;
        $profiles = null;
        if (auth()->check()) { // если пользователь аутентифицирован
            $user = auth()->user();
            // ...и у него есть профили для оформления
            $profiles = $user->profiles;
            // ...и был запрошен профиль для оформления
            $prof_id = (int)$request->input('profile_id');
            if ($prof_id) {
                $profile = $user->profiles()->whereIdAndUserId($prof_id, $user->id)->first();
            }
        }
        return view('basket.checkout', compact('profiles', 'profile'));
    }

    /**
     * Возвращает профиль пользователя в формате JSON
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function profile(Request $request) {
        if ( ! $request->ajax()) {
            abort(404);
        }
        if ( ! auth()->check()) {
            return response()->json(['error' => __('site.messages.auth_required')], 404);
        }
        $user = auth()->user();
        $profile_id = (int)$request->input('profile_id');
        if ($profile_id) {
            $profile = $user->profiles()->whereIdAndUserId($profile_id, $user->id)->first();
            if ($profile) {
                return response()->json(['profile' => $profile]);
            }
        }
        return response()->json(['error' => __('site.messages.profile_not_found')], 404);
    }

    /**
     * Сохранение заказа в БД
     */
    public function saveOrder(CheckoutOrderRequest $request) {
        $basket = $this->basket();
        if ($basket->products->isEmpty()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => __('site.messages.empty_order'),
                    'errors' => [
                        'basket' => [__('site.messages.empty_order')],
                    ],
                ], 422);
            }

            return redirect()
                ->route('basket.index')
                ->withErrors(__('site.messages.empty_order'));
        }

        try {
            $result = $this->checkoutBasket->execute($basket, $request->validated(), auth()->id());
        } catch (Throwable $exception) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => __('site.messages.checkout_failed'),
                    'errors' => [
                        'checkout' => [$exception->getMessage()],
                    ],
                ], 502);
            }

            return redirect()
                ->back()
                ->withErrors($exception->getMessage())
                ->withInput();
        }

        if ($request->expectsJson()) {
            return response()->json([
                'data' => [
                    'order' => (new OrderDetailResource($result->order))->resolve(),
                    'payment' => $result->payment
                        ? (new PaymentResource($result->payment))->resolve()
                        : null,
                ],
            ], 201);
        }

        return redirect()
            ->route('basket.success')
            ->with('order_id', $result->order->id);
    }

    /**
     * Сообщение об успешном оформлении заказа
     */
    public function success(Request $request) {
        if ($request->session()->exists('order_id')) {
            // сюда покупатель попадает сразу после оформления заказа
            $order_id = $request->session()->pull('order_id');
            $order = Order::findOrFail($order_id);
            return view('basket.success', compact('order'));
        } else {
            // если покупатель попал сюда не после оформления заказа
            return redirect()->route('basket.index');
        }
    }

    /**
     * Добавляет товар с идентификатором $id в корзину
     */
    public function add(Request $request, $id) {
        $quantity = max(1, (int)$request->input('quantity', 1));
        $basket = $this->basket();
        $basket->increase($id, $quantity);
        if ( ! $request->ajax()) {
            // выполняем редирект обратно на ту страницу,
            // где была нажата кнопка «В корзину»
            return back();
        }
        // в случае ajax-запроса возвращаем html-код корзины в правом
        // верхнем углу, чтобы заменить исходный html-код, потому что
        // теперь количество позиций будет другим
        $positions = $basket->products()->count();
        return view('basket.part.basket', compact('positions'));
    }

    /**
     * Увеличивает кол-во товара $id в корзине на единицу
     */
    public function plus($id) {
        $this->basket()->increase($id);
        // выполняем редирект обратно на страницу корзины
        return redirect()->route('basket.index');
    }

    /**
     * Уменьшает кол-во товара $id в корзине на единицу
     */
    public function minus($id) {
        $this->basket()->decrease($id);
        // выполняем редирект обратно на страницу корзины
        return redirect()->route('basket.index');
    }

    /**
     * Удаляет товар с идентификаторм $id из корзины
     */
    public function remove($id) {
        $this->basket()->remove($id);
        // выполняем редирект обратно на страницу корзины
        return redirect()->route('basket.index');
    }

    /**
     * Полностью очищает содержимое корзины покупателя
     */
    public function clear() {
        $this->basket()->clear();
        // выполняем редирект обратно на страницу корзины
        return redirect()->route('basket.index');
    }
}
