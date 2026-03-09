<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\CategoryTreeResource;
use App\Http\Resources\Api\V1\ProductListResource;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function __invoke()
    {
        $new = Product::query()
            ->with(['brand', 'category'])
            ->whereNew(true)
            ->latest()
            ->limit(3)
            ->get();

        $hit = Product::query()
            ->with(['brand', 'category'])
            ->whereHit(true)
            ->latest()
            ->limit(3)
            ->get();

        $sale = Product::query()
            ->with(['brand', 'category'])
            ->whereSale(true)
            ->latest()
            ->limit(3)
            ->get();

        $categories = Category::query()
            ->whereIn('slug', ['alpine', 'basecamp'])
            ->with('children')
            ->get()
            ->keyBy('slug');

        $editorials = collect([
            [
                'eyebrow' => __('site.home.editorial_journal_eyebrow'),
                'title' => __('site.home.editorial_journal_title'),
                'description' => __('site.home.editorial_journal_description'),
                'cta' => __('site.home.editorial_journal_cta'),
                'category' => $categories->get('alpine'),
            ],
            [
                'eyebrow' => __('site.home.editorial_field_eyebrow'),
                'title' => __('site.home.editorial_field_title'),
                'description' => __('site.home.editorial_field_description'),
                'cta' => __('site.home.editorial_field_cta'),
                'category' => $categories->get('basecamp'),
            ],
        ])->filter(static fn (array $item): bool => $item['category'] !== null)
            ->map(static function (array $item): array {
                return [
                    'eyebrow' => $item['eyebrow'],
                    'title' => $item['title'],
                    'description' => $item['description'],
                    'cta' => $item['cta'],
                    'category' => (new CategoryTreeResource($item['category']))->resolve(),
                ];
            })
            ->values()
            ->all();

        return response()->json([
            'data' => [
                'new' => ProductListResource::collection($new)->resolve(),
                'hit' => ProductListResource::collection($hit)->resolve(),
                'sale' => ProductListResource::collection($sale)->resolve(),
                'editorials' => $editorials,
            ],
        ]);
    }
}
