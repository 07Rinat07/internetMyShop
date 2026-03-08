<a class="utility-link utility-link--cart @if ($positions) is-filled @endif"
   href="{{ route('basket.index') }}">
    <span>{{ $positions ? __('site.basket.cart_count', ['count' => $positions]) : __('site.basket.cart_status') }}</span>
    @if ($positions)
        <span class="utility-link__badge">{{ $positions }}</span>
    @endif
</a>
