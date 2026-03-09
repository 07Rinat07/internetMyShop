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
        <form method="post" action="{{ route('basket.saveorder') }}" id="checkout"
              data-manual-label="{{ __('site.basket.pay_later') }}"
              data-online-label="{{ __('site.basket.pay_now') }}"
              data-checkout-created-online="{{ __('site.basket.payment_step_description') }}"
              data-checkout-failed="{{ __('site.messages.checkout_failed') }}"
              data-payment-sdk-missing="{{ __('site.messages.payment_sdk_missing') }}"
              data-payment-sdk-unavailable="{{ __('site.messages.payment_sdk_unavailable') }}"
              data-payment-sdk-load-failed="{{ __('site.messages.payment_sdk_load_failed') }}"
              data-payment-form-not-ready="{{ __('site.messages.payment_form_not_ready') }}"
              data-payment-provider-unsupported="{{ __('site.messages.payment_provider_unsupported') }}"
              data-payment-not-available="{{ __('site.messages.payment_not_available') }}"
              data-card-payment-failed="{{ __('site.messages.card_payment_failed') }}"
              data-sandbox-charge-template="{{ __('site.basket.sandbox_conversion_notice') }}"
              data-expiry-label="{{ __('site.basket.expiry') }}"
              data-cvv-label="{{ __('site.basket.cvv') }}"
              data-postal-label="{{ __('site.basket.postal_code') }}">
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
            <div class="form-group">
                <label>{{ __('site.basket.payment_method') }}</label>
                <p class="form-hint">{{ __('site.basket.payment_method_hint') }}</p>
                <div class="checkout-payment-methods">
                    <label class="checkout-payment-option">
                        <input type="radio" name="payment_method" value="online_card"
                               @checked(old('payment_method', 'online_card') === 'online_card')>
                        <span>
                            <strong>{{ __('site.basket.online_card_title') }}</strong>
                            <small>{{ __('site.basket.online_card_description') }}</small>
                        </span>
                    </label>
                    <label class="checkout-payment-option">
                        <input type="radio" name="payment_method" value="manager_confirmation"
                               @checked(old('payment_method') === 'manager_confirmation')>
                        <span>
                            <strong>{{ __('site.basket.manager_confirmation_title') }}</strong>
                            <small>{{ __('site.basket.manager_confirmation_description') }}</small>
                        </span>
                    </label>
                </div>
            </div>
            <div id="checkout-feedback" class="alert alert-success site-alert" hidden></div>
            <div id="checkout-payment-error" class="alert alert-danger site-alert" hidden></div>
            <div class="action-row">
                <a href="{{ route('basket.index') }}" class="btn btn-outline-dark">{{ __('site.basket.cart_status') }}</a>
                <button type="submit" class="btn btn-success" id="checkout-submit-button">{{ __('site.basket.pay_now') }}</button>
            </div>
        </form>
    </section>

    <section class="surface-panel checkout-payment-panel" id="checkout-payment-panel" hidden>
        <div class="section-heading">
            <span class="section-heading__eyebrow">{{ __('site.basket.summary') }}</span>
            <h2>{{ __('site.basket.payment_step_title') }}</h2>
        </div>
        <p id="checkout-payment-description">{{ __('site.basket.payment_step_description') }}</p>
        <div id="checkout-payment-note" class="alert alert-warning site-alert" hidden></div>
        <div id="checkout-payment-loading" class="alert alert-secondary site-alert" hidden>{{ __('site.basket.payment_pending') }}</div>
        <div class="checkout-hosted-fields" id="checkout-paypal-fields" hidden>
            <div class="form-group">
                <label>{{ __('site.forms.full_name') }}</label>
                <div id="paypal-name-field" class="checkout-hosted-field"></div>
            </div>
            <div class="form-group">
                <label>{{ __('site.basket.card_number') }}</label>
                <div id="paypal-number-field" class="checkout-hosted-field"></div>
            </div>
            <div class="checkout-hosted-fields__row">
                <div class="form-group">
                    <label>{{ __('site.basket.expiry') }}</label>
                    <div id="paypal-expiry-field" class="checkout-hosted-field"></div>
                </div>
                <div class="form-group">
                    <label>{{ __('site.basket.cvv') }}</label>
                    <div id="paypal-cvv-field" class="checkout-hosted-field"></div>
                </div>
            </div>
        </div>
        <div id="checkout-fake-fields" class="checkout-fake-card" hidden>
            <strong>{{ __('site.basket.sandbox_card') }}</strong>
            <div class="checkout-fake-card__meta">
                <span id="checkout-fake-number"></span>
                <span id="checkout-fake-expiry"></span>
                <span id="checkout-fake-cvv"></span>
                <span id="checkout-fake-postal"></span>
            </div>
        </div>
        <div class="action-row">
            <a href="#" class="btn btn-outline-dark" id="checkout-payment-status-link">{{ __('site.basket.open_payment_status') }}</a>
            <button type="button" class="btn btn-success" id="checkout-card-submit">{{ __('site.basket.pay_now_button') }}</button>
        </div>
    </section>
@endsection
