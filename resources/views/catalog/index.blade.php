@extends('layout.site', ['title' => __('site.catalog.title')])

@section('content')
    <section class="page-hero page-hero--compact">
        <div class="page-hero__content">
            <span class="page-hero__eyebrow">{{ __('site.catalog.eyebrow') }}</span>
            <h1 class="page-hero__title">{{ __('site.catalog.headline') }}</h1>
            <p class="page-hero__description">{{ __('site.catalog.description') }}</p>
        </div>
    </section>

    <section class="surface-panel surface-panel--notice">
        <div class="section-heading mb-0">
            <div>
                <span class="section-heading__eyebrow">{{ __('site.header.badge') }}</span>
                <h2>{{ __('site.catalog.story_title') }}</h2>
            </div>
        </div>
        <p class="surface-panel__text mb-0">{{ __('site.catalog.story_description') }}</p>
    </section>

    <section class="content-section">
        <div class="section-heading">
            <span class="section-heading__eyebrow">{{ __('site.catalog.eyebrow') }}</span>
            <h2>{{ __('site.catalog.categories_title') }}</h2>
        </div>
        <div class="row">
            @foreach ($roots as $root)
                @include('catalog.part.category', ['category' => $root])
            @endforeach
        </div>
    </section>

    <section class="content-section">
        <div class="section-heading">
            <span class="section-heading__eyebrow">{{ __('site.catalog.eyebrow') }}</span>
            <h2>{{ __('site.catalog.brands_title') }}</h2>
        </div>
        <div class="row">
            @foreach ($brands as $brand)
                @include('catalog.part.brand', ['brand' => $brand])
            @endforeach
        </div>
    </section>
@endsection
