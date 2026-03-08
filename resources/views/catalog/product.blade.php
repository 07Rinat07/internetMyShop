@extends('layout.site', ['title' => $product->name])

@section('content')
    <section class="page-hero page-hero--compact">
        <div class="page-hero__content">
            <span class="page-hero__eyebrow">{{ __('site.product.details') }}</span>
            <h1 class="page-hero__title">{{ $product->name }}</h1>
            <p class="page-hero__description">{{ $product->content ?: __('site.product.description_fallback') }}</p>
        </div>
    </section>

    <section class="surface-panel product-detail">
        <div class="product-detail__gallery">
            <div class="product-card__badges product-card__badges--detail">
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
                @php($url = url('storage/catalog/product/image/' . $product->image))
                <img src="{{ $url }}" alt="{{ $product->name }}" class="img-fluid">
            @else
                <img src="{{ asset('img/catalog-placeholder.svg') }}" alt="{{ $product->name }}" class="img-fluid">
            @endif
        </div>

        <div class="product-detail__summary">
            <div class="product-detail__price">
                <span>{{ __('site.product.price') }}</span>
                <strong>@price($product->price) {{ __('site.product.currency') }}</strong>
            </div>

            <form action="{{ route('basket.add', ['id' => $product->id]) }}"
                  method="post" class="product-detail__purchase add-to-basket">
                @csrf
                <label for="input-quantity">{{ __('site.product.quantity') }}</label>
                <input type="text" name="quantity" id="input-quantity" value="1" class="form-control">
                <button type="submit" class="btn btn-success">
                    {{ __('site.product.add_to_cart') }}
                </button>
            </form>

            <div class="product-detail__meta">
                @isset($product->category)
                    <div>
                        <span>{{ __('site.product.category') }}</span>
                        <a href="{{ route('catalog.category', ['category' => $product->category->slug]) }}">
                            {{ $product->category->name }}
                        </a>
                    </div>
                @endisset

                @isset($product->brand)
                    <div>
                        <span>{{ __('site.product.brand') }}</span>
                        <a href="{{ route('catalog.brand', ['brand' => $product->brand->slug]) }}">
                            {{ $product->brand->name }}
                        </a>
                    </div>
                @endisset
            </div>
        </div>
    </section>
@endsection
