<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $parent_id
 * @property string $name
 * @property string $slug
 * @property string|null $content
 * @property string|null $image
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Category> $children
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 */
class Category extends Model {
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'content',
        'image',
    ];

    /**
     * Связь «один ко многим» таблицы `categories` с таблицей `products`
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products() {
        return $this->hasMany(Product::class);
    }

    /**
     * Связь «один ко многим» таблицы `categories` с таблицей `categories`
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children() {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Связь «один ко многим» таблицы `categories` с таблицей `categories`,но
     * позволяет получить не только дочерние категории, но и дочерние-дочерние
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function descendants() {
        return $this->hasMany(Category::class, 'parent_id')->with('descendants');
    }

    /**
     * Возвращает список корневых категорий каталога товаров
     */
    public static function roots() {
        return self::where('parent_id', 0)->with('children')->get();
    }

    /**
     * Возвращает список всех категорий каталога в виде дерева
     */
    public static function hierarchy() {
        return self::where('parent_id', 0)->with('descendants')->get();
    }

    /**
     * Проверяет, что переданный идентификатор id может быть родителем
     * этой категории; что категорию не пытаются поместить внутрь себя
     */
    public function validParent($id) {
        $id = (integer)$id;
        // получаем идентификаторы всех потомков текущей категории
        $ids = $this->getAllChildren($this->id);
        $ids[] = $this->id;
        return ! in_array($id, $ids);
    }

    /**
     * Возвращает всех потомков категории с идентификатором $id
     */
    public static function getAllChildren($id) {
        // получаем прямых потомков категории с идентификатором $id
        $children = self::where('parent_id', $id)->with('children')->get();
        $ids = [];
        foreach ($children as $child) {
            $ids[] = $child->id;
            // для каждого прямого потомка получаем его прямых потомков
            if ($child->children->count()) {
                $ids = array_merge($ids, self::getAllChildren($child->id));
            }
        }
        return $ids;
    }
}
