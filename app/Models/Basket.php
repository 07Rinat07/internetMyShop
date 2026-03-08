<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

/**
 * @property int $id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 */
class Basket extends Model {

    /**
     * Связь «многие ко многим» таблицы `baskets` с таблицей `products`
     */
    public function products() {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }

    /**
     * Увеличивает кол-во товара $id в корзине на величину $count
     */
    public function increase($id, $count = 1) {
        $this->change($id, $count);
    }

    /**
     * Устанавливает кол-во товара $id в корзине
     */
    public function setQuantity($id, $quantity) {
        $quantity = (int)$quantity;
        $id = (int)$id;

        if ($quantity <= 0) {
            $this->remove($id);
            return;
        }

        DB::table('basket_product')
            ->updateOrInsert(
                ['basket_id' => $this->id, 'product_id' => $id],
                ['quantity' => $quantity]
            );

        $this->unsetRelation('products');
        $this->touch();
    }

    /**
     * Уменьшает кол-во товара $id в корзине на величину $count
     */
    public function decrease($id, $count = 1) {
        $this->change($id, -1 * $count);
    }

    /**
     * Изменяет количество товара $id в корзине на величину $count;
     * если товара еще нет в корзине — добавляет этот товар; $count
     * может быть как положительным, так и отрицательным числом
     */
    private function change($id, $count = 1) {
        if ($count == 0) {
            return;
        }
        $id = (int)$id;

        DB::transaction(function () use ($id, $count) {
            $pivotRow = DB::table('basket_product')
                ->where('basket_id', $this->id)
                ->where('product_id', $id)
                ->lockForUpdate()
                ->first();

            if ($pivotRow) {
                $quantity = (int) $pivotRow->quantity + $count;
                if ($quantity > 0) {
                    DB::table('basket_product')
                        ->where('id', $pivotRow->id)
                        ->update(['quantity' => $quantity]);
                } else {
                    DB::table('basket_product')
                        ->where('id', $pivotRow->id)
                        ->delete();
                }

                return;
            }

            if ($count > 0) {
                DB::table('basket_product')->insert([
                    'basket_id' => $this->id,
                    'product_id' => $id,
                    'quantity' => $count,
                ]);
            }
        });

        $this->unsetRelation('products');
        // обновляем поле `updated_at` таблицы `baskets`
        $this->touch();
    }

    /**
     * Удаляет товар с идентификатором $id из корзины покупателя
     */
    public function remove($id) {
        // удаляем товар из корзины (разрушаем связь)
        $this->products()->detach($id);
        $this->unsetRelation('products');
        // обновляем поле `updated_at` таблицы `baskets`
        $this->touch();
    }

    /**
     * Удаляет все товары из корзины покупателя
     */
    public function clear() {
        // удаляем товар из корзины (разрушаем все связи)
        $this->products()->detach();
        $this->unsetRelation('products');
        // обновляем поле `updated_at` таблицы `baskets`
        $this->touch();
    }

    /**
     * Возвращает стоимость всех товаров в корзине
     */
    public function getAmount() {
        $amount = 0.0;
        foreach ($this->products as $product) {
            $amount = $amount + $product->price * $product->pivot->quantity;
        }
        return $amount;
    }

    /**
     * Возвращает количество позиций в корзине
     */
    public static function getCount() {
        $basket_id = request()->cookie('basket_id');
        if (empty($basket_id)) {
            return 0;
        }

        return (int) DB::table('basket_product')
            ->where('basket_id', (int) $basket_id)
            ->count();
    }

    /**
     * Возвращает объект корзины; если не найден — создает новый
     */
    public static function getBasket() {
        $basket_id = (int)request()->cookie('basket_id');
        if (!empty($basket_id)) {
            try {
                $basket = Basket::findOrFail($basket_id);
            } catch (ModelNotFoundException $e) {
                $basket = Basket::create();
            }
        } else {
            $basket = Basket::create();
        }
        Cookie::queue('basket_id', $basket->id, 525600);
        return $basket;
    }
}
