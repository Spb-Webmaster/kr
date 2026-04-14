<div class="product_content">
    <div class="product__flex">

        <div class="product__left left">
            <div class="left_bar">

                {{-- Ценовой слайдер --}}
                <x-site.catalog.left-bar.price-slider
                    :minPrice="$priceMin"
                    :maxPrice="$priceMax"
                    wireMin="priceMin"
                    wireMax="priceMax"
                />

                {{-- Теги --}}
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
                                        <x-checkbox.checkbox4 wire:model.live="selectedTags" value="{{ $tag->id }}" />
                                    </div>
                                    <div class="tag__right">{{ $tag->title }}</div>
                                </div>
                            @empty
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Города --}}
                <div class="site_catalog_left-bar_cities-slider site_catalog_left-bar">
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
                                        <x-checkbox.checkbox4 wire:model.live="selectedCities" value="{{ $city->id }}" />
                                    </div>
                                    <div class="tag__right">{{ $city->title }}</div>
                                </div>
                            @empty
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="product__right right">
            @if($products->isEmpty())
                <div class="products_isEmpty">Сертификаты не найдены</div>
            @else
                <div class="products_list">
                    @foreach($products as $product)
                        <div class="teaser">
                            <a href="{{ route('certificate', ['category' => $category, 'slug' => $product->slug]) }}" class="img"
                                 style="background-image: url({{ asset(intervention('400x269', $product->img, 'image/product', 'cover'))}})"></a>

                            <div class="title">{{ $product->title }}</div>
                            <div class="button">
                                <a href="{{ route('certificate', ['category' => $category, 'slug' => $product->slug]) }}">
                                    <span>{{ $product->display_price }}</span>
                                    <span class="currency">{{ config('currency.currency.RUB') }}</span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</div>
