@extends('layout.site', ['title' => __('site.account.profile_details')])

@section('content')
    <section class="page-hero page-hero--compact">
        <div class="page-hero__content">
            <span class="page-hero__eyebrow">{{ __('site.account.profiles') }}</span>
            <h1 class="page-hero__title">{{ __('site.account.profile_details') }}</h1>
            <p class="page-hero__description">{{ $profile->title }}</p>
        </div>
    </section>

    <section class="surface-panel">
        <div class="detail-list">
            <div class="detail-list__item">
                <span>{{ __('site.forms.profile_title') }}</span>
                <strong>{{ $profile->title }}</strong>
            </div>
            <div class="detail-list__item">
                <span>{{ __('site.forms.full_name') }}</span>
                <strong>{{ $profile->name }}</strong>
            </div>
            <div class="detail-list__item">
                <span>{{ __('site.forms.email') }}</span>
                <strong><a href="mailto:{{ $profile->email }}">{{ $profile->email }}</a></strong>
            </div>
            <div class="detail-list__item">
                <span>{{ __('site.forms.phone') }}</span>
                <strong>{{ $profile->phone }}</strong>
            </div>
            <div class="detail-list__item">
                <span>{{ __('site.forms.address') }}</span>
                <strong>{{ $profile->address }}</strong>
            </div>
            @isset ($profile->comment)
                <div class="detail-list__item detail-list__item--wide">
                    <span>{{ __('site.forms.comment') }}</span>
                    <strong>{{ $profile->comment }}</strong>
                </div>
            @endisset
        </div>

        <div class="action-row mt-4">
            <a href="{{ route('user.profile.edit', ['profile' => $profile->id]) }}"
               class="btn btn-success">{{ __('site.account.edit_profile') }}</a>
            <form method="post" onsubmit="return confirm('{{ __('site.account.delete_confirm') }}')"
                  action="{{ route('user.profile.destroy', ['profile' => $profile->id]) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger">{{ __('site.account.delete_profile') }}</button>
            </form>
        </div>
    </section>
@endsection
