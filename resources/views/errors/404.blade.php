@extends('layout.site', ['title' => __('site.errors.404_title')])

@section('content')
    <section class="page-hero page-hero--compact">
        <div class="page-hero__content">
            <span class="page-hero__eyebrow">404</span>
            <h1 class="page-hero__title">{{ __('site.errors.404_title') }}</h1>
            <p class="page-hero__description">{{ __('site.errors.404_message') }}</p>
            <div class="page-hero__actions">
                <a href="{{ route('index') }}" class="btn btn-dark">{{ __('Go Home') }}</a>
            </div>
        </div>
    </section>

    <section class="surface-panel">
        <img src="{{ asset('img/404.jpg') }}" alt="{{ __('site.errors.404_title') }}" class="img-fluid rounded">
    </section>
@endsection
