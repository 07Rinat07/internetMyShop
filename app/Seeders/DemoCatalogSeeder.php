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
        $this->removeLegacyFixtures();

        $categories = $this->seedCategories();
        $brands = $this->seedBrands();

        foreach ($this->products() as $product) {
            Product::updateOrCreate(
                ['slug' => $product['slug']],
                [
                    'category_id' => $categories[$product['category']]->id,
                    'brand_id' => $brands[$product['brand']]->id,
                    'name' => $product['name'],
                    'content' => $product['content'],
                    'image' => $product['image'],
                    'price' => $product['price'],
                    'new' => $product['new'],
                    'hit' => $product['hit'],
                    'sale' => $product['sale'],
                ]
            );
        }
    }

    private function removeLegacyFixtures()
    {
        Product::whereIn('slug', [
            'alpine-expedition-45',
            'trailhead-scout-28',
            'urban-nomad-transit-55',
            'alpine-weekender-40',
            'trailhead-thermo-bottle-1l',
            'camp-forge-mug',
            'alpine-summit-sleeping-bag',
            'camp-forge-trek-lite',
        ])->delete();

        Category::whereIn('slug', [
            'outdoor-gear',
            'travel-gear',
            'accessories',
            'backpacks',
            'sleeping-bags',
            'duffel-bags',
            'drinkware',
        ])->delete();

        Brand::whereIn('slug', [
            'alpine-works',
            'trailhead',
            'urban-nomad',
            'camp-forge',
        ])->delete();
    }

    private function seedCategories()
    {
        $alpine = Category::updateOrCreate(
            ['slug' => 'alpine'],
            [
                'parent_id' => 0,
                'name' => 'Alpine',
                'content' => 'Technical packs and mountain-ready layers for fast, high-output movement.',
                'image' => 'alpine.jpg',
            ]
        );

        $basecamp = Category::updateOrCreate(
            ['slug' => 'basecamp'],
            [
                'parent_id' => 0,
                'name' => 'Basecamp',
                'content' => 'Shelter, sleep systems and camp essentials for longer stops in rough conditions.',
                'image' => 'basecamp.jpg',
            ]
        );

        $travel = Category::updateOrCreate(
            ['slug' => 'travel'],
            [
                'parent_id' => 0,
                'name' => 'Travel',
                'content' => 'Route-to-terminal duffels and transit gear built for constant movement.',
                'image' => 'travel.jpg',
            ]
        );

        return [
            'technical-packs' => Category::updateOrCreate(
                ['slug' => 'technical-packs'],
                [
                    'parent_id' => $alpine->id,
                    'name' => 'Technical Packs',
                    'content' => 'Lightweight carry systems for ridgelines, steep access and fast summit days.',
                    'image' => 'alpine.jpg',
                ]
            ),
            'sleeping-systems' => Category::updateOrCreate(
                ['slug' => 'sleeping-systems'],
                [
                    'parent_id' => $basecamp->id,
                    'name' => 'Sleeping Systems',
                    'content' => 'Cold-weather sleep gear for exposed camps, snow lines and extended stops.',
                    'image' => 'sleep.jpg',
                ]
            ),
            'camp-drinkware' => Category::updateOrCreate(
                ['slug' => 'camp-drinkware'],
                [
                    'parent_id' => $basecamp->id,
                    'name' => 'Camp Drinkware',
                    'content' => 'Insulated bottles and mugs for cold starts, stove sessions and long carries.',
                    'image' => 'drink.jpg',
                ]
            ),
            'expedition-duffels' => Category::updateOrCreate(
                ['slug' => 'expedition-duffels'],
                [
                    'parent_id' => $travel->id,
                    'name' => 'Expedition Duffels',
                    'content' => 'Hard-wearing transit bags for flights, truck beds and gear-room transfers.',
                    'image' => 'duffel.jpg',
                ]
            ),
        ];
    }

    private function seedBrands()
    {
        return [
            'arcteryx' => Brand::updateOrCreate(
                ['slug' => 'arcteryx'],
                [
                    'name' => "Arc'teryx",
                    'content' => 'Technical mountain equipment with a clean alpine design language and serious route intent.',
                    'image' => 'arc.jpg',
                ]
            ),
            'osprey' => Brand::updateOrCreate(
                ['slug' => 'osprey'],
                [
                    'name' => 'Osprey',
                    'content' => 'Known for balanced carry systems, ventilation and comfort over long, uneven miles.',
                    'image' => 'osp.jpg',
                ]
            ),
            'patagonia' => Brand::updateOrCreate(
                ['slug' => 'patagonia'],
                [
                    'name' => 'Patagonia',
                    'content' => 'A modern expedition staple for durable travel bags and cold-weather insulation.',
                    'image' => 'pat.jpg',
                ]
            ),
            'the-north-face' => Brand::updateOrCreate(
                ['slug' => 'the-north-face'],
                [
                    'name' => 'The North Face',
                    'content' => 'Expedition-proven outerwear, sleep systems and duffels with real route heritage.',
                    'image' => 'tnf.jpg',
                ]
            ),
            'yeti' => Brand::updateOrCreate(
                ['slug' => 'yeti'],
                [
                    'name' => 'YETI',
                    'content' => 'Field-tough insulated drinkware for basecamp routines and long-weather exposure.',
                    'image' => 'yet.jpg',
                ]
            ),
        ];
    }

    private function products()
    {
        return [
            [
                'category' => 'technical-packs',
                'brand' => 'arcteryx',
                'name' => "Arc'teryx Aerios 35 Pack",
                'slug' => 'arcteryx-aerios-35-pack',
                'content' => 'Fast-moving alpine pack for steep approaches, hut traverses and weather-shifting ridge days.',
                'image' => 'aer35.jpg',
                'price' => 35990.00,
                'new' => true,
                'hit' => true,
                'sale' => false,
            ],
            [
                'category' => 'technical-packs',
                'brand' => 'osprey',
                'name' => 'Osprey Talon 33 Pack',
                'slug' => 'osprey-talon-33-pack',
                'content' => 'Ventilated all-day pack built for long scrambles, mixed terrain and efficient moving light.',
                'image' => 'tal33.jpg',
                'price' => 24990.00,
                'new' => true,
                'hit' => true,
                'sale' => false,
            ],
            [
                'category' => 'expedition-duffels',
                'brand' => 'patagonia',
                'name' => 'Patagonia Black Hole Duffel 55L',
                'slug' => 'patagonia-black-hole-duffel-55l',
                'content' => 'Weather-resistant expedition duffel sized for rough transfers, boots, shells and modular packing cubes.',
                'image' => 'bh55.jpg',
                'price' => 21990.00,
                'new' => false,
                'hit' => true,
                'sale' => true,
            ],
            [
                'category' => 'expedition-duffels',
                'brand' => 'the-north-face',
                'name' => 'The North Face Base Camp Duffel M',
                'slug' => 'the-north-face-base-camp-duffel-m',
                'content' => 'A classic expedition duffel for flights, road transfers and basecamp organization in foul weather.',
                'image' => 'bcduf.jpg',
                'price' => 19990.00,
                'new' => false,
                'hit' => true,
                'sale' => true,
            ],
            [
                'category' => 'sleeping-systems',
                'brand' => 'the-north-face',
                'name' => 'The North Face Blue Kazoo',
                'slug' => 'the-north-face-blue-kazoo',
                'content' => 'Cold-weather down sleeping bag tuned for alpine bivies, shoulder-season camps and compact packing.',
                'image' => 'kazoo.jpg',
                'price' => 28990.00,
                'new' => true,
                'hit' => false,
                'sale' => false,
            ],
            [
                'category' => 'sleeping-systems',
                'brand' => 'the-north-face',
                'name' => 'The North Face Eco Trail Bed 20',
                'slug' => 'the-north-face-eco-trail-bed-20',
                'content' => 'Roomier synthetic sleep system for damp weather, colder trailheads and steady basecamp comfort.',
                'image' => 'fitz.jpg',
                'price' => 16990.00,
                'new' => false,
                'hit' => false,
                'sale' => true,
            ],
            [
                'category' => 'camp-drinkware',
                'brand' => 'yeti',
                'name' => 'YETI Rambler 26 oz Bottle',
                'slug' => 'yeti-rambler-26-oz-bottle',
                'content' => 'Insulated carry bottle for frozen dawn starts, long water carries and all-day temperature retention.',
                'image' => 'rb26.jpg',
                'price' => 5990.00,
                'new' => true,
                'hit' => false,
                'sale' => false,
            ],
            [
                'category' => 'camp-drinkware',
                'brand' => 'yeti',
                'name' => 'YETI Rambler 14 oz Mug',
                'slug' => 'yeti-rambler-14-oz-mug',
                'content' => 'Steel camp mug for stove-side coffee, windy ridgelines and slow evenings back in basecamp.',
                'image' => 'rb14.jpg',
                'price' => 3990.00,
                'new' => false,
                'hit' => true,
                'sale' => true,
            ],
        ];
    }
}
