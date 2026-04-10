<?php

namespace App\Models;

use App\Support\Money\Money;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $category_id
 * @property int $brand_id
 * @property string $name
 * @property string $slug
 * @property string|null $content
 * @property string|null $image
 * @property string|int|float $price
 * @property bool $new
 * @property bool $hit
 * @property bool $sale
 * @property-read \App\Models\Brand|null $brand
 * @property-read \App\Models\Category|null $category
 * @property-read object|null $pivot
 */
class Product extends Model
{
    use HasFactory;

    protected $casts = [
        'price' => 'decimal:2',
        'new' => 'boolean',
        'hit' => 'boolean',
        'sale' => 'boolean',
    ];

    protected $fillable = [
        'category_id',
        'brand_id',
        'name',
        'slug',
        'content',
        'image',
        'price',
        'new',
        'hit',
        'sale',
    ];

    /**
     * Связь «товар принадлежит» таблицы `products` с таблицей `categories`
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Связь «товар принадлежит» таблицы `products` с таблицей `brands`
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Связь «многие ко многим» таблицы `products` с таблицей `baskets`
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function baskets()
    {
        return $this->belongsToMany(Basket::class)->withPivot('quantity');
    }

    public function priceMoney(?string $currency = null): Money
    {
        return Money::fromDecimal(
            (string) $this->price,
            $currency ?? (string) config('payments.store_currency', 'KZT'),
        );
    }

    /**
     * Позволяет выбирать товары категории и всех ее потомков
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  int  $id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCategoryProducts($builder, $id)
    {
        $descendants = Category::getAllChildren($id);
        $descendants[] = $id;

        return $builder->whereIn('category_id', $descendants);
    }

    /**
     * Позволяет фильтровать товары по нескольким условиям
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \App\Domain\Catalog\Filters\ProductFilters  $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterProducts($builder, $filters)
    {
        return $filters->apply($builder);
    }
}
