<section class="sidebar-panel">
    <div class="sidebar-panel__header">
        <span class="sidebar-panel__eyebrow">{{ __('site.header.catalog') }}</span>
        <h2>{{ __('site.sidebar.catalog_title') }}</h2>
    </div>
    <div id="catalog-sidebar">
        @include('layout.part.branch', ['parent' => 0])
    </div>
</section>
