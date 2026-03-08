<div class="col-xl-4 col-md-6 mb-4">
    <article class="card showcase-card list-item">
        <a class="showcase-card__media" href="{{ route('catalog.category', ['category' => $category->slug]) }}">
            @if ($category->image)
                @php($url = url('storage/catalog/category/thumb/' . $category->image))
                <img src="{{ $url }}" class="img-fluid" alt="{{ $category->name }}">
            @else
                <img src="{{ asset('img/catalog-placeholder.svg') }}" class="img-fluid" alt="{{ $category->name }}">
            @endif
        </a>
        <div class="card-body showcase-card__body">
            <span class="showcase-card__eyebrow">{{ __('site.catalog.categories_title') }}</span>
            <h3 class="mb-0">{{ $category->name }}</h3>
            <p>{{ \Illuminate\Support\Str::limit(strip_tags($category->content ?? __('site.catalog.category_products')), 86) }}</p>
        </div>
        <div class="card-footer showcase-card__footer">
            <a href="{{ route('catalog.category', ['category' => $category->slug]) }}"
               class="btn btn-dark btn-block">{{ __('site.catalog.category_products') }}</a>
        </div>
    </article>
</div>
