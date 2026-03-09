<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? __('site.meta.default_title') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
          integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p"
          crossorigin="anonymous"/>
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/site.js') }}" defer></script>
</head>
<body class="site-body" data-request-failed="{{ __('site.messages.request_failed') }}">
@php($currentLocale = app()->getLocale())
@php($previousUrl = url()->previous())
@php($backUrl = filled($previousUrl) && $previousUrl !== url()->current() ? $previousUrl : route(request()->routeIs('user.index') ? 'index' : 'user.index'))
<div class="site-shell">
    <header class="site-header">
        <div class="site-topbar">
            <a class="site-brand" href="{{ route('index') }}">
                <span class="site-brand__mark">IM</span>
                <span>
                    <strong>{{ __('site.header.brand') }}</strong>
                    <small>{{ __('site.header.badge') }}</small>
                </span>
            </a>

            <div class="site-topbar__message">
                <span class="site-pill">{{ __('site.header.badge') }}</span>
                <p>{{ __('site.header.tagline') }}</p>
            </div>

            <div class="site-utility">
                <div class="locale-switch" aria-label="{{ __('site.header.language') }}">
                    @foreach (config('app.supported_locales', ['ru']) as $locale)
                        <a href="{{ route('locale.switch', ['locale' => $locale]) }}"
                           class="locale-switch__link @if ($currentLocale === $locale) is-active @endif">
                            {{ strtoupper($locale) }}
                        </a>
                    @endforeach
                </div>

                <div id="top-basket">
                    @include('basket.part.basket', ['positions' => $positions])
                </div>

                @guest
                    <a class="utility-link" href="{{ route('user.login') }}">{{ __('site.header.login') }}</a>
                    @if (Route::has('user.register'))
                        <a class="utility-link" href="{{ route('user.register') }}">{{ __('site.header.register') }}</a>
                    @endif
                @else
                    @if (auth()->user()?->admin)
                        <a class="utility-link" href="{{ route('moonshine.index') }}">{{ __('site.header.admin') }}</a>
                    @endif
                    <a class="utility-link" href="{{ route('user.index') }}">{{ __('site.header.account') }}</a>
                    <form action="{{ route('user.logout') }}" method="post" class="utility-form">
                        @csrf
                        <button type="submit" class="utility-link utility-link--button">{{ __('site.account.logout') }}</button>
                    </form>
                @endguest
            </div>
        </div>

        <nav class="navbar navbar-expand-lg site-navbar">
            <a class="site-navbar__home" href="{{ route('index') }}">{{ __('site.header.home') }}</a>
            <button class="navbar-toggler site-navbar__toggler" type="button" data-toggle="collapse"
                    data-target="#site-navigation" aria-controls="site-navigation"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="site-navigation">
                <ul class="navbar-nav site-nav-links">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('catalog.index') }}">{{ __('site.header.catalog') }}</a>
                    </li>
                    @include('layout.part.pages')
                </ul>

                <form action="{{ route('catalog.search') }}" class="site-search" role="search">
                    <input class="form-control site-search__input" type="search" name="query"
                           value="{{ request('query') }}"
                           placeholder="{{ __('site.header.search_placeholder') }}" aria-label="{{ __('site.header.search_placeholder') }}">
                    <button class="btn site-search__button" type="submit">{{ __('site.header.search_button') }}</button>
                </form>
            </div>
        </nav>
    </header>

    <main class="site-main">
        <aside class="site-sidebar">
            @include('layout.part.roots')
            @include('layout.part.brands')
        </aside>

        <section class="site-content">
            @auth
                @if (request()->routeIs('user.*'))
                    <div class="context-actions">
                        <a href="{{ $backUrl }}" class="btn btn-outline-dark">{{ __('site.navigation.back') }}</a>
                        <a href="{{ route('index') }}" class="btn btn-outline-dark">{{ __('site.navigation.home') }}</a>
                        @if (auth()->user()?->admin)
                            <a href="{{ route('moonshine.index') }}" class="btn btn-outline-dark">{{ __('site.navigation.to_admin') }}</a>
                        @endif
                        @unless (request()->routeIs('user.index'))
                            <a href="{{ route('user.index') }}" class="btn btn-outline-dark">{{ __('site.header.account') }}</a>
                        @endunless
                        <form action="{{ route('user.logout') }}" method="post" class="context-actions__form">
                            @csrf
                            <button type="submit" class="btn btn-dark">{{ __('site.account.logout') }}</button>
                        </form>
                    </div>
                @endif
            @endauth

            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible site-alert mt-0" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="{{ __('Close') }}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{ $message }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible site-alert" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="{{ __('Close') }}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </section>
    </main>

    <footer class="site-footer">
        <div class="site-footer__brand">
            <a class="site-brand site-brand--footer" href="{{ route('index') }}">
                <span class="site-brand__mark">IM</span>
                <span>
                    <strong>{{ __('site.footer.title') }}</strong>
                    <small>{{ __('site.header.badge') }}</small>
                </span>
            </a>

            <div class="site-footer__copy">
                <span class="site-pill">{{ __('site.header.badge') }}</span>
                <p>{{ __('site.footer.description') }}</p>
            </div>
        </div>

        <small class="site-footer__note">{{ __('site.footer.note') }}</small>
    </footer>
</div>
</body>
</html>
