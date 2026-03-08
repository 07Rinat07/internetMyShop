<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $name = fake()->realText(random_int(30, 40));

        return [
            'parent_id' => 0,
            'name' => $name,
            'content' => fake()->realText(random_int(150, 200)),
            'slug' => Str::slug($name).'-'.fake()->unique()->numberBetween(1000, 9999),
            'image' => null,
        ];
    }
}
