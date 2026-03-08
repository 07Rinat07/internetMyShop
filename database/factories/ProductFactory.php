<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = fake()->realText(random_int(40, 50));

        return [
            'category_id' => Category::factory(),
            'brand_id' => Brand::factory(),
            'name' => $name,
            'content' => fake()->realText(random_int(400, 500)),
            'slug' => Str::slug($name).'-'.fake()->unique()->numberBetween(1000, 9999),
            'image' => null,
            'price' => fake()->numberBetween(1000, 2000),
            'new' => false,
            'hit' => false,
            'sale' => false,
        ];
    }
}
