@extends('layout.site', ['title' => $page->name])

@section('content')
    <section class="page-hero page-hero--compact">
        <div class="page-hero__content">
            <span class="page-hero__eyebrow">{{ __('site.header.home') }}</span>
            <h1 class="page-hero__title">{{ $page->name }}</h1>
        </div>
    </section>

    <article class="surface-panel page-article">
        <div class="page-article__content">
            {!! $page->content !!}
        </div>
        <div class="page-article__meta">
            {{ __('site.page.published_at') }}: {{ $page->created_at->format('d.m.Y H:i') }}
        </div>
    </article>
@endsection
