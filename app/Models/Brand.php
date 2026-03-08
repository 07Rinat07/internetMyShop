<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $content
 * @property string|null $image
 * @property int|null $products_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 */
class Brand extends Model {
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'content',
        'image',
    ];

    /**
     * Связь «один ко многим» таблицы `brands` с таблицей `products`
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products() {
        return $this->hasMany(Product::class);
    }

    /**
     * Возвращает список популярных брендов каталога товаров.
     * Следовало бы отобрать бренды, товары которых продаются
     * чаще всего. Но поскольку таких данных у нас еще нет,
     * просто получаем 5 брендов с наибольшим кол-вом товаров
     */
    public static function popular() {
        return self::withCount('products')
            ->orderByDesc('products_count')
            ->orderBy('name')
            ->limit(5)
            ->get();
    }
}
