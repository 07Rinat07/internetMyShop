@extends('layout.site', ['title' => __('site.account.profiles_title')])

@section('content')
    <section class="page-hero page-hero--compact">
        <div class="page-hero__content">
            <span class="page-hero__eyebrow">{{ __('site.account.profiles') }}</span>
            <h1 class="page-hero__title">{{ __('site.account.profiles_title') }}</h1>
            <p class="page-hero__description">{{ __('site.account.description') }}</p>
        </div>
    </section>

    <section class="content-section">
        <div class="action-row">
            <a href="{{ route('user.profile.create') }}" class="btn btn-success">
                {{ __('site.account.create_profile') }}
            </a>
        </div>

        @if ($profiles->count())
            <div class="table-shell">
                <table class="table table-bordered">
                    <tr>
                        <th>{{ __('site.table.number') }}</th>
                        <th>{{ __('site.forms.profile_title') }}</th>
                        <th>{{ __('site.forms.full_name') }}</th>
                        <th>{{ __('site.table.email') }}</th>
                        <th>{{ __('site.table.phone') }}</th>
                        <th>{{ __('site.table.actions') }}</th>
                    </tr>
                    @foreach($profiles as $profile)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <a href="{{ route('user.profile.show', ['profile' => $profile->id]) }}">
                                    {{ $profile->title }}
                                </a>
                            </td>
                            <td>{{ $profile->name }}</td>
                            <td><a href="mailto:{{ $profile->email }}">{{ $profile->email }}</a></td>
                            <td>{{ $profile->phone }}</td>
                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('user.profile.edit', ['profile' => $profile->id]) }}"
                                       class="icon-action" title="{{ __('site.account.edit_profile') }}">
                                        <i class="far fa-edit"></i>
                                    </a>
                                    <form action="{{ route('user.profile.destroy', ['profile' => $profile->id]) }}"
                                          method="post" onsubmit="return confirm('{{ __('site.account.delete_confirm') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="icon-action icon-action--danger"
                                                title="{{ __('site.account.delete_profile') }}">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            {{ $profiles->links() }}
        @else
            <div class="empty-state">
                <p>{{ __('site.account.profiles_empty') }}</p>
            </div>
        @endif
    </section>
@endsection
