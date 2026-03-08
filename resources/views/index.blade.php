@extends('layout.site', ['title' => __('site.home.title')])

@section('content')
    <section class="page-hero">
        <div class="page-hero__content">
            <span class="page-hero__eyebrow">{{ __('site.home.eyebrow') }}</span>
            <h1 class="page-hero__title">{{ __('site.home.headline') }}</h1>
            <p class="page-hero__description">{{ __('site.home.description') }}</p>
            <div class="page-hero__actions">
                <a href="{{ route('catalog.index') }}" class="btn btn-dark page-hero__primary">
                    {{ __('site.home.primary_cta') }}
                </a>
                <a href="#hit-products" class="btn btn-outline-dark page-hero__secondary">
                    {{ __('site.home.secondary_cta') }}
                </a>
            </div>
        </div>

        <div class="page-hero__stats">
            <div class="hero-stat">
                <strong>{{ $new->count() }}</strong>
                <span>{{ __('site.home.section_new') }}</span>
            </div>
            <div class="hero-stat">
                <strong>{{ $hit->count() }}</strong>
                <span>{{ __('site.home.section_hit') }}</span>
            </div>
            <div class="hero-stat">
                <strong>{{ $sale->count() }}</strong>
                <span>{{ __('site.home.section_sale') }}</span>
            </div>
        </div>
    </section>

    @if(($editorials ?? collect())->count())
        <section class="content-section">
            <div class="section-heading section-heading--split">
                <div>
                    <span class="section-heading__eyebrow">{{ __('site.home.editorial_section_eyebrow') }}</span>
                    <h2>{{ __('site.home.editorial_section_title') }}</h2>
                </div>
                <p class="mb-0">{{ __('site.home.editorial_section_description') }}</p>
            </div>

            <div class="editorial-grid">
                @foreach($editorials as $item)
                    @php($category = $item['category'])
                    @php($imageUrl = $category->image ? url('storage/catalog/category/image/' . $category->image) : asset('img/catalog-placeholder.svg'))
                    <article class="editorial-card">
                        <div class="editorial-card__media">
                            <img src="{{ $imageUrl }}" alt="{{ $item['title'] }}">
                        </div>
                        <div class="editorial-card__body">
                            <span class="editorial-card__eyebrow">{{ $item['eyebrow'] }}</span>
                            <h3>{{ $item['title'] }}</h3>
                            <p>{{ $item['description'] }}</p>
                            <a href="{{ route('catalog.category', ['category' => $category->slug]) }}" class="btn btn-dark">
                                {{ $item['cta'] }}
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif

    @if($new->count())
        <section class="content-section">
            <div class="section-heading">
                <span class="section-heading__eyebrow">{{ __('site.home.eyebrow') }}</span>
                <h2>{{ __('site.home.section_new') }}</h2>
            </div>
            <div class="row">
                @foreach($new as $item)
                    @include('catalog.part.product', ['product' => $item])
                @endforeach
            </div>
        </section>
    @endif

    @if($hit->count())
        <section class="content-section" id="hit-products">
            <div class="section-heading">
                <span class="section-heading__eyebrow">{{ __('site.home.eyebrow') }}</span>
                <h2>{{ __('site.home.section_hit') }}</h2>
            </div>
            <div class="row">
                @foreach($hit as $item)
                    @include('catalog.part.product', ['product' => $item])
                @endforeach
            </div>
        </section>
    @endif

    @if($sale->count())
        <section class="content-section">
            <div class="section-heading">
                <span class="section-heading__eyebrow">{{ __('site.home.eyebrow') }}</span>
                <h2>{{ __('site.home.section_sale') }}</h2>
            </div>
            <div class="row">
                @foreach($sale as $item)
                    @include('catalog.part.product', ['product' => $item])
                @endforeach
            </div>
        </section>
    @endif
@endsection
