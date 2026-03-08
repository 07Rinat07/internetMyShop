<?php

namespace App\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DemoCatalogSeeder extends Seeder
{
    public function run()
    {
        $categories = $this->seedCategories();
        $brands = $this->seedBrands();

        $products = [
            [
                'category' => 'backpacks',
                'brand' => 'alpine-works',
                'name' => 'Alpine Expedition 45',
                'slug' => 'alpine-expedition-45',
                'content' => 'Large hiking backpack for demo catalog and basket testing.',
                'price' => 18990.00,
                'new' => true,
                'hit' => true,
                'sale' => false,
            ],
            [
                'category' => 'backpacks',
                'brand' => 'trailhead',
                'name' => 'Trailhead Scout 28',
                'slug' => 'trailhead-scout-28',
                'content' => 'Compact daypack suitable for quick purchase and checkout checks.',
                'price' => 12490.00,
                'new' => true,
                'hit' => false,
                'sale' => false,
            ],
            [
                'category' => 'duffel-bags',
                'brand' => 'urban-nomad',
                'name' => 'Urban Nomad Transit 55',
                'slug' => 'urban-nomad-transit-55',
                'content' => 'Travel duffel for testing brand pages and order creation.',
                'price' => 15990.00,
                'new' => false,
                'hit' => true,
                'sale' => true,
            ],
            [
                'category' => 'duffel-bags',
                'brand' => 'alpine-works',
                'name' => 'Alpine Weekender 40',
                'slug' => 'alpine-weekender-40',
                'content' => 'Weekend bag for category, basket and admin product checks.',
                'price' => 13990.00,
                'new' => false,
                'hit' => false,
                'sale' => true,
            ],
            [
                'category' => 'drinkware',
                'brand' => 'trailhead',
                'name' => 'Trailhead Thermo Bottle 1L',
                'slug' => 'trailhead-thermo-bottle-1l',
                'content' => 'Accessory product for testing small items in the cart.',
                'price' => 4990.00,
                'new' => false,
                'hit' => true,
                'sale' => false,
            ],
            [
                'category' => 'drinkware',
                'brand' => 'camp-forge',
                'name' => 'Camp Forge Mug',
                'slug' => 'camp-forge-mug',
                'content' => 'Low-cost accessory to test order totals and quantity changes.',
                'price' => 2490.00,
                'new' => false,
                'hit' => false,
                'sale' => true,
            ],
            [
                'category' => 'sleeping-bags',
                'brand' => 'alpine-works',
                'name' => 'Alpine Summit Sleeping Bag',
                'slug' => 'alpine-summit-sleeping-bag',
                'content' => 'Sleeping bag for testing broader catalog coverage.',
                'price' => 21990.00,
                'new' => true,
                'hit' => false,
                'sale' => false,
            ],
            [
                'category' => 'sleeping-bags',
                'brand' => 'camp-forge',
                'name' => 'Camp Forge Trek Lite',
                'slug' => 'camp-forge-trek-lite',
                'content' => 'Alternative sleeping bag to validate filters and product detail routes.',
                'price' => 17490.00,
                'new' => false,
                'hit' => true,
                'sale' => false,
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                [
                    'slug' => $product['slug'],
                ],
                [
                    'category_id' => $categories[$product['category']]->id,
                    'brand_id' => $brands[$product['brand']]->id,
                    'name' => $product['name'],
                    'content' => $product['content'],
                    'image' => null,
                    'price' => $product['price'],
                    'new' => $product['new'],
                    'hit' => $product['hit'],
                    'sale' => $product['sale'],
                ]
            );
        }
    }

    private function seedCategories()
    {
        $outdoor = Category::updateOrCreate(
            ['slug' => 'outdoor-gear'],
            [
                'parent_id' => 0,
                'name' => 'Outdoor Gear',
                'content' => 'Main category for outdoor catalog testing.',
                'image' => null,
            ]
        );

        $travel = Category::updateOrCreate(
            ['slug' => 'travel-gear'],
            [
                'parent_id' => 0,
                'name' => 'Travel Gear',
                'content' => 'Category for travel products in demo data.',
                'image' => null,
            ]
        );

        $accessories = Category::updateOrCreate(
            ['slug' => 'accessories'],
            [
                'parent_id' => 0,
                'name' => 'Accessories',
                'content' => 'Accessory category for small checkout items.',
                'image' => null,
            ]
        );

        return [
            'backpacks' => Category::updateOrCreate(
                ['slug' => 'backpacks'],
                [
                    'parent_id' => $outdoor->id,
                    'name' => 'Backpacks',
                    'content' => 'Backpack category for testing catalog pages.',
                    'image' => null,
                ]
            ),
            'sleeping-bags' => Category::updateOrCreate(
                ['slug' => 'sleeping-bags'],
                [
                    'parent_id' => $outdoor->id,
                    'name' => 'Sleeping Bags',
                    'content' => 'Sleeping bags for wider demo catalog coverage.',
                    'image' => null,
                ]
            ),
            'duffel-bags' => Category::updateOrCreate(
                ['slug' => 'duffel-bags'],
                [
                    'parent_id' => $travel->id,
                    'name' => 'Duffel Bags',
                    'content' => 'Travel bags for brand and product detail testing.',
                    'image' => null,
                ]
            ),
            'drinkware' => Category::updateOrCreate(
                ['slug' => 'drinkware'],
                [
                    'parent_id' => $accessories->id,
                    'name' => 'Drinkware',
                    'content' => 'Small items that are useful for cart and checkout tests.',
                    'image' => null,
                ]
            ),
        ];
    }

    private function seedBrands()
    {
        return [
            'alpine-works' => Brand::updateOrCreate(
                ['slug' => 'alpine-works'],
                [
                    'name' => 'Alpine Works',
                    'content' => 'Outdoor brand for demo products.',
                    'image' => null,
                ]
            ),
            'trailhead' => Brand::updateOrCreate(
                ['slug' => 'trailhead'],
                [
                    'name' => 'Trailhead',
                    'content' => 'Mid-range demo brand for catalog and checkout testing.',
                    'image' => null,
                ]
            ),
            'urban-nomad' => Brand::updateOrCreate(
                ['slug' => 'urban-nomad'],
                [
                    'name' => 'Urban Nomad',
                    'content' => 'Travel-oriented demo brand.',
                    'image' => null,
                ]
            ),
            'camp-forge' => Brand::updateOrCreate(
                ['slug' => 'camp-forge'],
                [
                    'name' => 'Camp Forge',
                    'content' => 'Accessory-focused demo brand.',
                    'image' => null,
                ]
            ),
        ];
    }
}
