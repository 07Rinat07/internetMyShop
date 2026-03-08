@extends('layout.site', ['title' => __('site.basket.title')])

@section('content')
    <section class="page-hero page-hero--compact">
        <div class="page-hero__content">
            <span class="page-hero__eyebrow">{{ __('site.basket.summary') }}</span>
            <h1 class="page-hero__title">{{ __('site.basket.title') }}</h1>
            <p class="page-hero__description">{{ __('site.basket.description') }}</p>
        </div>
    </section>

    @if ($products->count())
        <section class="content-section">
            <div class="action-row">
                <a href="{{ route('catalog.index') }}" class="btn btn-outline-dark">
                    {{ __('site.basket.continue_shopping') }}
                </a>
                <form action="{{ route('basket.clear') }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger">{{ __('site.basket.clear') }}</button>
                </form>
            </div>

            <div class="table-shell">
                <table class="table table-bordered">
                    <tr>
                        <th>{{ __('site.table.number') }}</th>
                        <th>{{ __('site.table.name') }}</th>
                        <th>{{ __('site.table.price') }}</th>
                        <th>{{ __('site.table.quantity') }}</th>
                        <th>{{ __('site.table.cost') }}</th>
                        <th>{{ __('site.table.actions') }}</th>
                    </tr>
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <a href="{{ route('catalog.product', ['product' => $product->slug]) }}">
                                    {{ $product->name }}
                                </a>
                            </td>
                            <td>@price($product->price) {{ __('site.product.currency') }}</td>
                            <td>
                                <div class="quantity-controls">
                                    <form action="{{ route('basket.minus', ['id' => $product->id]) }}"
                                          method="post" class="d-inline">
                                        @csrf
                                        <button type="submit" class="icon-action" aria-label="-">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </form>
                                    <span class="quantity-controls__value">{{ $product->pivot->quantity }}</span>
                                    <form action="{{ route('basket.plus', ['id' => $product->id]) }}"
                                          method="post" class="d-inline">
                                        @csrf
                                        <button type="submit" class="icon-action" aria-label="+">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            <td>@price($product->price * $product->pivot->quantity) {{ __('site.product.currency') }}</td>
                            <td>
                                <form action="{{ route('basket.remove', ['id' => $product->id]) }}"
                                      method="post">
                                    @csrf
                                    <button type="submit" class="icon-action icon-action--danger"
                                            title="{{ __('site.basket.remove') }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </section>

        <section class="surface-panel">
            <div class="summary-bar">
                <div>
                    <span>{{ __('site.table.total') }}</span>
                    <strong>@price($amount) {{ __('site.product.currency') }}</strong>
                </div>
                <a href="{{ route('basket.checkout') }}" class="btn btn-success">
                    {{ __('site.basket.checkout') }}
                </a>
            </div>
        </section>
    @else
        <section class="content-section">
            <div class="empty-state">
                <p>{{ __('site.basket.empty') }}</p>
                <a href="{{ route('catalog.index') }}" class="btn btn-dark mt-4">
                    {{ __('site.basket.empty_cta') }}
                </a>
            </div>
        </section>
    @endif
@endsection
