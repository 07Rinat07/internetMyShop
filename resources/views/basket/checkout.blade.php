@extends('layout.site', ['title' => __('site.basket.checkout')])

@section('content')
    <section class="page-hero page-hero--compact">
        <div class="page-hero__content">
            <span class="page-hero__eyebrow">{{ __('site.basket.summary') }}</span>
            <h1 class="page-hero__title">{{ __('site.basket.checkout') }}</h1>
            <p class="page-hero__description">{{ __('site.basket.profile_prompt') }}</p>
        </div>
    </section>

    @if ($profiles && $profiles->count())
        <section class="surface-panel">
            <div class="section-heading">
                <span class="section-heading__eyebrow">{{ __('site.account.profiles') }}</span>
                <h2>{{ __('site.basket.choose_profile') }}</h2>
            </div>
            @include('basket.select', ['current' => $profile->id ?? 0])
        </section>
    @endif

    <section class="surface-panel">
        <form method="post" action="{{ route('basket.saveorder') }}" id="checkout">
            @csrf
            <div class="form-group">
                <label for="checkout-name">{{ __('site.forms.full_name') }}</label>
                <input type="text" class="form-control" id="checkout-name" name="name"
                       placeholder="{{ __('site.forms.full_name') }}"
                       required maxlength="255" value="{{ old('name') ?? $profile->name ?? '' }}">
            </div>
            <div class="form-group">
                <label for="checkout-email">{{ __('site.forms.email') }}</label>
                <input type="email" class="form-control" id="checkout-email" name="email"
                       placeholder="{{ __('site.forms.email') }}"
                       required maxlength="255" value="{{ old('email') ?? $profile->email ?? '' }}">
            </div>
            <div class="form-group">
                <label for="checkout-phone">{{ __('site.forms.phone') }}</label>
                <input type="text" class="form-control" id="checkout-phone" name="phone"
                       placeholder="{{ __('site.forms.phone') }}"
                       required maxlength="255" value="{{ old('phone') ?? $profile->phone ?? '' }}">
            </div>
            <div class="form-group">
                <label for="checkout-address">{{ __('site.forms.address') }}</label>
                <input type="text" class="form-control" id="checkout-address" name="address"
                       placeholder="{{ __('site.forms.address') }}"
                       required maxlength="255" value="{{ old('address') ?? $profile->address ?? '' }}">
            </div>
            <div class="form-group">
                <label for="checkout-comment">{{ __('site.forms.comment') }}</label>
                <textarea class="form-control" id="checkout-comment" name="comment"
                          placeholder="{{ __('site.forms.comment') }}"
                          maxlength="255" rows="4">{{ old('comment') ?? $profile->comment ?? '' }}</textarea>
            </div>
            <div class="action-row">
                <a href="{{ route('basket.index') }}" class="btn btn-outline-dark">{{ __('site.basket.cart_status') }}</a>
                <button type="submit" class="btn btn-success">{{ __('site.basket.place_order') }}</button>
            </div>
        </form>
    </section>
@endsection
