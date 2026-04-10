<?php

namespace App\Models;

use App\Support\Money\Money;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int|null $product_id
 * @property string $name
 * @property string|int|float $price
 * @property int $quantity
 * @property string|int|float $cost
 * @property-read \App\Models\Product|null $product
 */
class OrderItem extends Model
{
    public $timestamps = false;

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
        'cost' => 'decimal:2',
    ];

    protected $fillable = [
        'product_id',
        'name',
        'price',
        'quantity',
        'cost',
    ];

    /**
     * Связь «элемент принадлежит» таблицы `order_item` с таблицей `products`
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function priceMoney(string $currency): Money
    {
        return Money::fromDecimal((string) $this->price, $currency);
    }

    public function costMoney(string $currency): Money
    {
        return Money::fromDecimal((string) $this->cost, $currency);
    }
}
