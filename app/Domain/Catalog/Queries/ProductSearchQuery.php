<?php

namespace App\Domain\Catalog\Queries;

use andrewdanilov\stem\LinguaStemRu;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;

class ProductSearchQuery
{
    public function build(string $search): Builder
    {
        $terms = $this->normalizedTerms($search);

        if ($terms === []) {
            return Product::query()->whereNull('id');
        }

        [$relevanceSql, $relevanceBindings] = $this->relevanceExpression($terms);

        $query = Product::query()
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->select('products.*')
            ->selectRaw($relevanceSql.' as relevance', $relevanceBindings)
            ->where(function (Builder $builder) use ($terms) {
                foreach ($terms as $term) {
                    $like = '%'.$term.'%';

                    $builder
                        ->orWhere('products.name', 'like', $like)
                        ->orWhere('products.content', 'like', $like)
                        ->orWhere('categories.name', 'like', $like)
                        ->orWhere('brands.name', 'like', $like);
                }
            })
            ->orderByDesc('relevance');

        return $query;
    }

    /**
     * @return array<int, string>
     */
    private function normalizedTerms(string $search): array
    {
        $search = iconv_substr($search, 0, 64);
        $search = preg_replace('#[^0-9a-zA-ZА-Яа-яёЁ]#u', ' ', $search) ?? '';
        $search = preg_replace('#\s+#u', ' ', $search) ?? '';
        $search = trim($search);

        if ($search === '') {
            return [];
        }

        $stemmer = new LinguaStemRu;
        $terms = [];

        foreach (explode(' ', $search) as $term) {
            $terms[] = iconv_strlen($term) > 3
                ? $stemmer->stem_word($term)
                : $term;
        }

        return array_values(array_unique($terms));
    }

    /**
     * @param  array<int, string>  $terms
     * @return array{0: string, 1: array<int, string>}
     */
    private function relevanceExpression(array $terms): array
    {
        $parts = [];
        $bindings = [];

        foreach ($terms as $term) {
            $like = '%'.$term.'%';

            $parts[] = 'CASE WHEN products.name LIKE ? THEN 2 ELSE 0 END';
            $parts[] = 'CASE WHEN products.content LIKE ? THEN 1 ELSE 0 END';
            $parts[] = 'CASE WHEN categories.name LIKE ? THEN 1 ELSE 0 END';
            $parts[] = 'CASE WHEN brands.name LIKE ? THEN 2 ELSE 0 END';

            array_push($bindings, $like, $like, $like, $like);
        }

        return [implode(' + ', $parts), $bindings];
    }
}
