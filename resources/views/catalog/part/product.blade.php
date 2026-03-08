<div class="col-xl-4 col-md-6 mb-4">
    <article class="card product-card list-item">
        <a class="product-card__media" href="{{ route('catalog.product', ['product' => $product->slug]) }}">
            <div class="product-card__badges">
                @if($product->new)
                    <span class="badge badge-info text-white">{{ __('site.product.new') }}</span>
                @endif
                @if($product->hit)
                    <span class="badge badge-danger">{{ __('site.product.hit') }}</span>
                @endif
                @if($product->sale)
                    <span class="badge badge-success">{{ __('site.product.sale') }}</span>
                @endif
            </div>
            @if ($product->image)
                @php($url = url('storage/catalog/product/thumb/' . $product->image))
                <img src="{{ $url }}" class="img-fluid" alt="{{ $product->name }}">
            @else
                <img src="{{ asset('img/catalog-placeholder.svg') }}" class="img-fluid" alt="{{ $product->name }}">
            @endif
        </a>
        <div class="card-body product-card__body">
            <h3 class="mb-0">{{ $product->name }}</h3>
            <p class="product-card__description">
                {{ \Illuminate\Support\Str::limit(strip_tags($product->content ?? __('site.product.description_fallback')), 90) }}
            </p>
            <div class="product-card__price">
                <span>{{ __('site.product.price') }}</span>
                <strong>@price($product->price) {{ __('site.product.currency') }}</strong>
            </div>
        </div>
        <div class="card-footer product-card__footer">
            <form action="{{ route('basket.add', ['id' => $product->id]) }}"
                  method="post" class="add-to-basket">
                @csrf
                <button type="submit" class="btn btn-success btn-block">{{ __('site.product.add_to_cart') }}</button>
            </form>
            <a href="{{ route('catalog.product', ['product' => $product->slug]) }}"
               class="btn btn-dark btn-block">{{ __('site.product.view') }}</a>
        </div>
    </article>
</div>
