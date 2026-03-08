@extends('layout.site', ['title' => __('site.account.create_title')])

@section('content')
    <section class="page-hero page-hero--compact">
        <div class="page-hero__content">
            <span class="page-hero__eyebrow">{{ __('site.account.profiles') }}</span>
            <h1 class="page-hero__title">{{ __('site.account.create_title') }}</h1>
            <p class="page-hero__description">{{ __('site.account.description') }}</p>
        </div>
    </section>

    <section class="surface-panel">
        <form method="post" action="{{ route('user.profile.store') }}">
            @include('user.profile.part.form')
        </form>
    </section>
@endsection
