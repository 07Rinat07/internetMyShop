<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int|null $product_id
 * @property string $name
 * @property float $price
 * @property int $quantity
 * @property float $cost
 * @property-read \App\Models\Product|null $product
 */
class OrderItem extends Model
{
    public $timestamps = false;

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
    public function product() {
        return $this->belongsTo(Product::class);
    }
}
