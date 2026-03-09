@extends('layout.site', ['title' => __('site.payments.title')])

@section('content')
    <section class="page-hero page-hero--compact">
        <div class="page-hero__content">
            <span class="page-hero__eyebrow">{{ __('site.payments.summary') }}</span>
            <h1 class="page-hero__title">{{ __('site.payments.title') }}</h1>
            <p class="page-hero__description">{{ __('site.payments.description') }}</p>
        </div>
    </section>

    <section class="surface-panel">
        <div class="section-heading">
            <span class="section-heading__eyebrow">{{ __('site.payments.summary') }}</span>
            <h2>{{ $payment->public_id }}</h2>
        </div>
        <div class="detail-list">
            <div class="detail-list__item">
                <span>{{ __('site.payments.status') }}</span>
                <strong>{{ $payment->statusEnum()->label() }}</strong>
            </div>
            <div class="detail-list__item">
                <span>{{ __('site.payments.provider') }}</span>
                <strong>{{ $payment->providerEnum()->label() }}</strong>
            </div>
            <div class="detail-list__item">
                <span>{{ __('site.payments.charged_amount') }}</span>
                <strong>@price($payment->amount) {{ $payment->currency }}</strong>
            </div>
            <div class="detail-list__item">
                <span>{{ __('site.payments.store_amount') }}</span>
                <strong>@price($payment->store_amount) {{ $payment->store_currency }}</strong>
            </div>
            @if ($payment->failure_reason)
                <div class="detail-list__item detail-list__item--wide">
                    <span>{{ __('site.payments.failure_reason') }}</span>
                    <strong>{{ $payment->failure_reason }}</strong>
                </div>
            @endif
            <div class="detail-list__item detail-list__item--wide">
                <span>{{ __('site.payments.refresh_note') }}</span>
                <strong>{{ optional($payment->updated_at)->format('d.m.Y H:i') }}</strong>
            </div>
        </div>
    </section>

    @if ($payment->order)
        <section class="content-section">
            <div class="section-heading">
                <span class="section-heading__eyebrow">{{ __('site.payments.order_summary') }}</span>
                <h2>{{ __('site.account.order_details', ['id' => $payment->order->id]) }}</h2>
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
                    @foreach($payment->order->items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>@price($item->price) {{ $payment->order->currency }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>@price($item->cost) {{ $payment->order->currency }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <th colspan="4" class="text-right">{{ __('site.table.total') }}</th>
                        <th>@price($payment->order->amount) {{ $payment->order->currency }}</th>
                    </tr>
                </table>
            </div>
        </section>
    @endif
@endsection
