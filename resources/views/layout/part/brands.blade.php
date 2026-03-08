<section class="sidebar-panel">
    <div class="sidebar-panel__header">
        <span class="sidebar-panel__eyebrow">{{ __('site.catalog.brands_title') }}</span>
        <h2>{{ __('site.sidebar.brands_title') }}</h2>
    </div>
    <ul id="brands-popular" class="brand-list">
        @foreach($items as $item)
            <li>
                <a href="{{ route('catalog.brand', ['brand' => $item->slug]) }}">
                    <span>{{ $item->name }}</span>
                    <span class="brand-list__count">{{ $item->products_count }}</span>
                </a>
            </li>
        @endforeach
    </ul>
</section>
