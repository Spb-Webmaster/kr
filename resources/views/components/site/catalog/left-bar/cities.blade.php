<div class="site_catalog_left-bar_tags-slider site_catalog_left-bar">
    <div class="tags _box">
        <div class="_box__flex">
            <div class="label">Город</div>
            <div class="after">&#8250;</div>
        </div>
    </div>

    <div class="price_toggle">
        <div class="tag__block">

            @forelse($cities as $city)

                <div class="flex tag__flex">
                    <div class="tag__left">
                        <x-checkbox.checkbox4 :value="$city->id" wire:model.live="selectedCities" />
                    </div>
                    <div class="tag__right">
                        {{ $city->title }}
                    </div>


                </div>
            @empty
            @endforelse
        </div>
    </div>
</div>

