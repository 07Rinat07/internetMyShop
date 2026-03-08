@extends('layout.site', ['title' => __('site.catalog.search_title')])

@section('content')
    <section class="page-hero page-hero--compact">
        <div class="page-hero__content">
            <span class="page-hero__eyebrow">{{ __('site.catalog.search_results') }}</span>
            <h1 class="page-hero__title">{{ __('site.catalog.search_title') }}</h1>
            <p class="page-hero__description">
                {{ __('site.catalog.query_label') }}:
                <strong>{{ $search ?: '...' }}</strong>
            </p>
        </div>
    </section>

    <section class="content-section">
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
