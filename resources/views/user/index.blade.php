@extends('layout.site', ['title' => __('site.account.title')])

@section('content')
    <section class="page-hero page-hero--compact">
        <div class="page-hero__content">
            <span class="page-hero__eyebrow">{{ __('site.header.account') }}</span>
            <h1 class="page-hero__title">{{ __('site.account.welcome', ['name' => auth()->user()->name]) }}</h1>
            <p class="page-hero__description">{{ __('site.account.description') }}</p>
        </div>
    </section>

    <section class="dashboard-grid">
        @if (auth()->user()?->admin)
            <a href="{{ route('moonshine.index') }}" class="info-tile">
                <span class="info-tile__eyebrow">{{ __('site.header.admin') }}</span>
                <strong>{{ __('site.navigation.to_admin') }}</strong>
            </a>
        @endif
        <a href="{{ route('user.profile.index') }}" class="info-tile">
            <span class="info-tile__eyebrow">{{ __('site.account.profiles') }}</span>
            <strong>{{ __('site.account.profiles_title') }}</strong>
        </a>
        <a href="{{ route('user.order.index') }}" class="info-tile">
            <span class="info-tile__eyebrow">{{ __('site.account.orders') }}</span>
            <strong>{{ __('site.account.orders_title') }}</strong>
        </a>
    </section>

    <section class="surface-panel">
        <form action="{{ route('user.logout') }}" method="post">
            @csrf
            <button type="submit" class="btn btn-dark">{{ __('site.account.logout') }}</button>
        </form>
    </section>
@endsection
