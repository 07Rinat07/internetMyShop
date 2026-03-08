@extends('layout.site', ['title' => $category->name])

@section('content')
    <section class="page-hero page-hero--compact">
        <div class="page-hero__content">
            <span class="page-hero__eyebrow">{{ __('site.catalog.categories_title') }}</span>
            <h1 class="page-hero__title">{{ $category->name }}</h1>
            <p class="page-hero__description">{{ $category->content ?: __('site.catalog.description') }}</p>
        </div>
    </section>

    @if ($category->children->count())
        <section class="content-section">
            <div class="section-heading">
                <span class="section-heading__eyebrow">{{ __('site.catalog.eyebrow') }}</span>
                <h2>{{ __('site.catalog.categories_title') }}</h2>
            </div>
            <div class="row">
                @foreach ($category->children as $child)
                    @include('catalog.part.category', ['category' => $child])
                @endforeach
            </div>
        </section>
    @endif

    <section class="surface-panel">
        <div class="section-heading section-heading--split">
            <div>
                <span class="section-heading__eyebrow">{{ __('site.catalog.eyebrow') }}</span>
                <h2>{{ __('site.catalog.filters_title') }}</h2>
            </div>
            <a href="{{ route('catalog.category', ['category' => $category->slug]) }}"
               class="btn btn-outline-dark">{{ __('site.catalog.reset_filters') }}</a>
        </div>
        <form method="get" action="{{ route('catalog.category', ['category' => $category->slug]) }}">
            @include('catalog.part.filter')
        </form>
    </section>

    <section class="content-section">
        <div class="section-heading">
            <span class="section-heading__eyebrow">{{ __('site.catalog.eyebrow') }}</span>
            <h2>{{ __('site.catalog.category_products') }}</h2>
        </div>

        @if ($products->count())
            <div class="row">
                @foreach ($products as $product)
                    @include('catalog.part.product', ['product' => $product])
                @endforeach
            </div>
            {{ $products->links() }}
        @else
            <div class="empty-state">
                <p>{{ __('site.catalog.empty') }}</p>
            </div>
        @endif
    </section>
@endsection
