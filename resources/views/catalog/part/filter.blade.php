<div class="filter-panel">
    <div class="filter-panel__field">
        <label for="catalog-price">{{ __('site.filters.price') }}</label>
        <select name="price" id="catalog-price" class="form-control" title="{{ __('site.filters.price') }}">
            <option value="0">{{ __('site.filters.choose_price') }}</option>
            <option value="min"@if(request()->price == 'min') selected @endif>{{ __('site.filters.min') }}</option>
            <option value="max"@if(request()->price == 'max') selected @endif>{{ __('site.filters.max') }}</option>
        </select>
    </div>

    <label class="filter-check" for="new-product">
        <input type="checkbox" name="new" class="form-check-input" id="new-product"
               @if(request()->has('new')) checked @endif value="yes">
        <span>{{ __('site.filters.new') }}</span>
    </label>

    <label class="filter-check" for="hit-product">
        <input type="checkbox" name="hit" class="form-check-input" id="hit-product"
               @if(request()->has('hit')) checked @endif value="yes">
        <span>{{ __('site.filters.hit') }}</span>
    </label>

    <label class="filter-check" for="sale-product">
        <input type="checkbox" name="sale" class="form-check-input" id="sale-product"
               @if(request()->has('sale')) checked @endif value="yes">
        <span>{{ __('site.filters.sale') }}</span>
    </label>

    <button type="submit" class="btn btn-dark">{{ __('site.filters.apply') }}</button>
</div>
