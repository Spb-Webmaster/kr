<div class="site_catalog_left-bar_price-slider site_catalog_left-bar">
    <div class="price _box">
        <div class="_box__flex">
            <div class="label">Цена</div>
            <div class="after">&#8250;</div>
        </div>
    </div>


    <div class="price_toggle">
    <div class="price_inputs">
        <div class="p_left_r">
            <input type="text" inputmode="numeric" class="price_min"
                   value="{{ $minPrice }}"
                   data-min="{{ $absoluteMin }}"
                   data-max="{{ $absoluteMax }}"
                   @if($wireMin) wire:model.live.debounce.500ms="{{ $wireMin }}" @endif
                   placeholder="От">
            <span class="min_r">₽</span>
        </div>
        <div class="p_right_r">
            <input type="text" inputmode="numeric" class="price_max"
                   value="{{ $maxPrice }}"
                   data-min="{{ $absoluteMin }}"
                   data-max="{{ $absoluteMax }}"
                   @if($wireMax) wire:model.live.debounce.500ms="{{ $wireMax }}" @endif
                   placeholder="До">
            <span class="max_r">₽</span>
        </div>
    </div>
    <div class="slider"></div>
        <div class="button-right"><button type="button" class="price-filter-submit btn btn-mini">Показать</button></div>
    </div>
</div>
