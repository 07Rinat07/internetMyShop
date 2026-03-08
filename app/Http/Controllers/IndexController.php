<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class IndexController extends Controller {
    public function __invoke(Request $request) {
        $new = Product::whereNew(true)->latest()->limit(3)->get();
        $hit = Product::whereHit(true)->latest()->limit(3)->get();
        $sale = Product::whereSale(true)->latest()->limit(3)->get();

        $categories = Category::whereIn('slug', ['alpine', 'basecamp'])->get()->keyBy('slug');

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
        ])->filter(fn ($item) => $item['category'] !== null)->values();

        return view('index', compact('new', 'hit', 'sale', 'editorials'));
    }
}
