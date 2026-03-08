<?php

namespace App\Http\Controllers\Api\V1;

use App\Domain\Catalog\Filters\ProductFilters;
use App\Http\Controllers\Api\V1\Concerns\InteractsWithPagination;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\BrandResource;
use App\Http\Resources\Api\V1\CategoryTreeResource;
use App\Http\Resources\Api\V1\ProductDetailResource;
use App\Http\Resources\Api\V1\ProductListResource;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;

class CatalogController extends Controller
{
    use InteractsWithPagination;

    public function index()
    {
        return response()->json([
            'data' => [
                'categories' => CategoryTreeResource::collection(Category::roots())->resolve(),
                'brands' => BrandResource::collection(Brand::popular())->resolve(),
            ],
        ]);
    }

    public function category(Category $category, ProductFilters $filters)
    {
        $products = Product::query()
            ->with(['brand', 'category'])
            ->categoryProducts($category->id)
            ->filterProducts($filters)
            ->paginate(6)
            ->appends(request()->query());

        return response()->json([
            'data' => [
                'category' => (new CategoryTreeResource($category->load('children')))->resolve(),
                'products' => ProductListResource::collection($products->getCollection())->resolve(),
            ],
            'meta' => $this->paginationMeta($products),
            'links' => $this->paginationLinks($products),
        ]);
    }

    public function brand(Brand $brand, ProductFilters $filters)
    {
        $products = Product::query()
            ->with(['brand', 'category'])
            ->where('brand_id', $brand->id)
            ->filterProducts($filters)
            ->paginate(6)
            ->appends(request()->query());

        return response()->json([
            'data' => [
                'brand' => (new BrandResource($brand))->resolve(),
                'products' => ProductListResource::collection($products->getCollection())->resolve(),
            ],
            'meta' => $this->paginationMeta($products),
            'links' => $this->paginationLinks($products),
        ]);
    }

    public function product(Product $product)
    {
        return response()->json([
            'data' => (new ProductDetailResource($product->load(['brand', 'category'])))->resolve(),
        ]);
    }
}
