<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Brand>
 */
class BrandFactory extends Factory
{
    protected $model = Brand::class;

    public function definition(): array
    {
        $name = fake()->realText(random_int(20, 30));

        return [
            'name' => $name,
            'content' => fake()->realText(random_int(150, 200)),
            'slug' => Str::slug($name).'-'.fake()->unique()->numberBetween(1000, 9999),
            'image' => null,
        ];
    }
}
