<div class="col-xl-4 col-md-6 mb-4">
    <article class="card showcase-card list-item">
        <a class="showcase-card__media" href="{{ route('catalog.brand', ['brand' => $brand->slug]) }}">
            @if ($brand->image)
                @php($url = url('storage/catalog/brand/thumb/' . $brand->image))
                <img src="{{ $url }}" class="img-fluid" alt="{{ $brand->name }}">
            @else
                <img src="{{ asset('img/catalog-placeholder.svg') }}" class="img-fluid" alt="{{ $brand->name }}">
            @endif
        </a>
        <div class="card-body showcase-card__body">
            <span class="showcase-card__eyebrow">{{ __('site.catalog.brands_title') }}</span>
            <h3 class="mb-0">{{ $brand->name }}</h3>
            <p>{{ \Illuminate\Support\Str::limit(strip_tags($brand->content ?? __('site.catalog.brand_products')), 86) }}</p>
        </div>
        <div class="card-footer showcase-card__footer">
            <a href="{{ route('catalog.brand', ['brand' => $brand->slug]) }}"
               class="btn btn-dark btn-block">{{ __('site.catalog.brand_products') }}</a>
        </div>
    </article>
</div>
