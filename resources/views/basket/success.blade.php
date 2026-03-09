@extends('layout.site', ['title' => __('site.basket.order_placed')])

@section('content')
    <section class="page-hero page-hero--compact">
        <div class="page-hero__content">
            <span class="page-hero__eyebrow">{{ __('site.basket.summary') }}</span>
            <h1 class="page-hero__title">{{ __('site.basket.order_placed') }}</h1>
            <p class="page-hero__description">
                {{ $order->paymentMethodEnum()->value === 'manager_confirmation'
                    ? __('site.basket.manual_success_message')
                    : __('site.basket.payment_success_message') }}
            </p>
        </div>
    </section>

    <section class="content-section">
        <div class="section-heading">
            <span class="section-heading__eyebrow">{{ __('site.basket.summary') }}</span>
            <h2>{{ __('site.basket.your_order') }}</h2>
        </div>
        <div class="table-shell">
            <table class="table table-bordered">
                <tr>
                    <th>{{ __('site.table.number') }}</th>
                    <th>{{ __('site.table.name') }}</th>
                    <th>{{ __('site.table.price') }}</th>
                    <th>{{ __('site.table.quantity') }}</th>
                    <th>{{ __('site.table.cost') }}</th>
                </tr>
                @foreach($order->items as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->name }}</td>
                        <td>@price($item->price) {{ $order->currency }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>@price($item->cost) {{ $order->currency }}</td>
                    </tr>
                @endforeach
                <tr>
                    <th colspan="4" class="text-right">{{ __('site.table.total') }}</th>
                    <th>@price($order->amount) {{ $order->currency }}</th>
                </tr>
            </table>
        </div>
    </section>

    <section class="surface-panel">
        <div class="section-heading">
            <span class="section-heading__eyebrow">{{ __('site.basket.summary') }}</span>
            <h2>{{ __('site.basket.your_details') }}</h2>
        </div>
        <div class="detail-list">
            <div class="detail-list__item">
                <span>{{ __('site.forms.full_name') }}</span>
                <strong>{{ $order->name }}</strong>
            </div>
            <div class="detail-list__item">
                <span>{{ __('site.forms.email') }}</span>
                <strong><a href="mailto:{{ $order->email }}">{{ $order->email }}</a></strong>
            </div>
            <div class="detail-list__item">
                <span>{{ __('site.forms.phone') }}</span>
                <strong>{{ $order->phone }}</strong>
            </div>
            <div class="detail-list__item">
                <span>{{ __('site.forms.address') }}</span>
                <strong>{{ $order->address }}</strong>
            </div>
            @isset ($order->comment)
                <div class="detail-list__item detail-list__item--wide">
                    <span>{{ __('site.forms.comment') }}</span>
                    <strong>{{ $order->comment }}</strong>
                </div>
            @endisset
        </div>
    </section>
@endsection
