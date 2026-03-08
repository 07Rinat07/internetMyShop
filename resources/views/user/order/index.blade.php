@extends('layout.site', ['title' => __('site.account.orders_title')])

@section('content')
    <section class="page-hero page-hero--compact">
        <div class="page-hero__content">
            <span class="page-hero__eyebrow">{{ __('site.account.orders') }}</span>
            <h1 class="page-hero__title">{{ __('site.account.orders_title') }}</h1>
            <p class="page-hero__description">{{ __('site.account.description') }}</p>
        </div>
    </section>

    <section class="content-section">
        @if($orders->count())
            <div class="table-shell">
                <table class="table table-bordered">
                    <tr>
                        <th>{{ __('site.table.number') }}</th>
                        <th>{{ __('site.table.date') }}</th>
                        <th>{{ __('site.table.status') }}</th>
                        <th>{{ __('site.table.customer') }}</th>
                        <th>{{ __('site.table.email') }}</th>
                        <th>{{ __('site.table.phone') }}</th>
                        <th>{{ __('site.table.actions') }}</th>
                    </tr>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                            <td><span class="status-chip">{{ $order->statusEnum()->label() }}</span></td>
                            <td>{{ $order->name }}</td>
                            <td><a href="mailto:{{ $order->email }}">{{ $order->email }}</a></td>
                            <td>{{ $order->phone }}</td>
                            <td>
                                <a href="{{ route('user.order.show', ['order' => $order->id]) }}"
                                   class="icon-action" title="{{ __('site.account.order_details', ['id' => $order->id]) }}">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            {{ $orders->links() }}
        @else
            <div class="empty-state">
                <p>{{ __('site.account.orders_empty') }}</p>
            </div>
        @endif
    </section>
@endsection
