<div class="site_catalog_left-bar_tags-slider site_catalog_left-bar">
    <div class="tags _box">
        <div class="_box__flex">
            <div class="label">Категории</div>
            <div class="after">&#8250;</div>
        </div>
    </div>

    <div class="price_toggle">
        <div class="tag__block">

        @forelse($tags as $tag)

        <div class="flex tag__flex">
            <div class="tag__left">
                <x-checkbox.checkbox4 :value="$tag->id" wire:model.live="selectedTags" />
            </div>
            <div class="tag__right">
                {{ $tag->title }}
            </div>


        </div>
        @empty
        @endforelse
        </div>
    </div>
</div>
