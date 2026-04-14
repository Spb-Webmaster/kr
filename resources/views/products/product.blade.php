@extends('layouts.partial.layout-page', ['class' => ''])
<x-seo.meta
    :title="$product->metatitle ?? $product->title"
    :description="$product->description ?? ''"
    :keywords="$product->keywords ?? ''"
/>
@section('content-home')

    <section class="block relative">
        <x-site.catalog.category.category/>
    </section>

    <section class="block relative">
        <div class="product_single">
            <div class="title">
                <h1 class="product_single__title">{{ $product->title }}</h1>

                @if($product->subtitle)
                    <div class="product_single__subtitle">{{ $product->subtitle }}</div>
                @endif
            </div>
            <div class="product_single__flex">
                <div class="left">

                    <div class="product_single__img">
                        <a
                            href="{{ Storage::url($product->img) }}"
                            data-fancybox="gallery"
                            data-caption=""
                        >
                            <img src="{{ asset(intervention('695x422', $product->img, 'image/product', 'cover')) }}"
                                 alt="{{ $product->title }}">
                        </a>
                    </div>

                    @if($product->gallery && $product->gallery->isNotEmpty())
                        <div class="product_single__gallery">
                            <div class="swiper productSwiper">
                                <div class="swiper-wrapper">
                                    @foreach($product->gallery as $item)
                                        @php $img = is_array($item) ? $item['json_gallery_text'] : $item->json_gallery_text; @endphp
                                        @if($img)
                                            <div class="product_single__gallery-item swiper-slide">
                                                <a
                                                    href="{{ Storage::url($img) }}"
                                                    data-fancybox="gallery"
                                                    data-caption=""
                                                >
                                                    <img
                                                        src="{{ asset(intervention('154x104', $img, 'image/product/gallery', 'cover')) }}"
                                                        alt="{{ $product->title }}">
                                                </a>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
                <div class="right">
                    <div class="product_single__content">

                        <div class="product_single__options">
                            <div class="product_single__price_label pad_b28_important">Продажа сертификата</div>


                            @if($product->city)
                                <div class="product_single__section product_single__other-city">
                                    <div class="product_single__section_icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="m20.893 13.393-1.135-1.135a2.252 2.252 0 0 1-.421-.585l-1.08-2.16a.414.414 0 0 0-.663-.107.827.827 0 0 1-.812.21l-1.273-.363a.89.89 0 0 0-.738 1.595l.587.39c.59.395.674 1.23.172 1.732l-.2.2c-.212.212-.33.498-.33.796v.41c0 .409-.11.809-.32 1.158l-1.315 2.191a2.11 2.11 0 0 1-1.81 1.025 1.055 1.055 0 0 1-1.055-1.055v-1.172c0-.92-.56-1.747-1.414-2.089l-.655-.261a2.25 2.25 0 0 1-1.383-2.46l.007-.042a2.25 2.25 0 0 1 .29-.787l.09-.15a2.25 2.25 0 0 1 2.37-1.048l1.178.236a1.125 1.125 0 0 0 1.302-.795l.208-.73a1.125 1.125 0 0 0-.578-1.315l-.665-.332-.091.091a2.25 2.25 0 0 1-1.591.659h-.18c-.249 0-.487.1-.662.274a.931.931 0 0 1-1.458-1.137l1.411-2.353a2.25 2.25 0 0 0 .286-.76m11.928 9.869A9 9 0 0 0 8.965 3.525m11.928 9.868A9 9 0 1 1 8.965 3.525"/>
                                        </svg>

                                    </div>
                                    <div class="product_single__section_description">
                                        <div class="product_single__section-title">Город</div>
                                        <div class="product_single__section-desc">{{ $product->city->title }}</div>
                                    </div>
                                </div>

                            @endif
                            @if($product->weather)
                                <div class="product_single__section product_single__weather">
                                    <div class="product_single__section_icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"/>
                                        </svg>
                                    </div>
                                    <div class="product_single__section_description">
                                        <div class="product_single__section-title">Погодные условия</div>
                                        <div class="product_single__section-desc">{!! $product->weather !!}</div>
                                    </div>
                                </div>
                            @endif
                            @if($product->personCount)
                                <div class="product_single__section product_single__human">
                                    <div class="product_single__section_icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>
                                        </svg>

                                    </div>
                                    <div class="product_single__section_description">
                                        <div class="product_single__section-title">Количество человек</div>
                                        <div
                                            class="product_single__section-desc">{{ $product->personCount->title }}</div>
                                    </div>
                                </div>
                            @endif
                            @if($product->ageRestriction)
                                <div class="product_single__section product_single__human">
                                    <div class="product_single__section_icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M10.05 4.575a1.575 1.575 0 1 0-3.15 0v3m3.15-3v-1.5a1.575 1.575 0 0 1 3.15 0v1.5m-3.15 0 .075 5.925m3.075.75V4.575m0 0a1.575 1.575 0 0 1 3.15 0V15M6.9 7.575a1.575 1.575 0 1 0-3.15 0v8.175a6.75 6.75 0 0 0 6.75 6.75h2.018a5.25 5.25 0 0 0 3.712-1.538l1.732-1.732a5.25 5.25 0 0 0 1.538-3.712l.003-2.024a.668.668 0 0 1 .198-.471 1.575 1.575 0 1 0-2.228-2.228 3.818 3.818 0 0 0-1.12 2.687M6.9 7.575V12m6.27 4.318A4.49 4.49 0 0 1 16.35 15m.002 0h-.002"/>
                                        </svg>


                                    </div>
                                    <div class="product_single__section_description">
                                        <div class="product_single__section-title">Возрастное ограничение</div>
                                        <div
                                            class="product_single__section-desc">{{ $product->ageRestriction->title }}</div>
                                    </div>
                                </div>
                            @endif

                            @if($product->special_clothing)
                                <div class="product_single__section product_single__clothing">
                                    <div class="product_single__section_icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 0 0 4.486-6.336l-3.276 3.277a3.004 3.004 0 0 1-2.25-2.25l3.276-3.276a4.5 4.5 0 0 0-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437 1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008Z"/>
                                        </svg>

                                    </div>
                                    <div class="product_single__section_description">
                                        <div class="product_single__section-title">Специальная одежда</div>
                                        <div
                                            class="product_single__section-desc">{!! $product->special_clothing !!}</div>
                                    </div>
                                </div>
                            @endif

                        </div>
                        <div class="product_single__options">
                            <div class="product_single__price">

                                <x-form.form
                                    class="product_single__form"
                                    action="{{ route('order.store', ['category' => $category, 'slug' => $product->slug]) }}"
                                    method="POST"
                                >
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="vendor_id" value="{{ $product->vendor_id }}">

                                    @if($product->prices_list->isNotEmpty())
                                        <input type="hidden" name="price_option" value="{{ $product->prices_list->first()['option'] }}">
                                        <div class="product_single__price_label">Доступные варианты</div>
                                        @foreach($product->prices_list as $variant)
                                            <label class="product_single__price-row">

                                                <div class="radio-wrapper-1">
                                                    <input type="radio"
                                                           id="price-{{ $loop->index }}"
                                                           name="price"
                                                           value="{{ $variant['price'] }}"
                                                           data-option="{{ $variant['option'] }}"
                                                        {{ $loop->first ? 'checked' : '' }}>
                                                    <label for="price-{{ $loop->index }}"></label>
                                                </div>

                                                <span class="radio-wrapper-text">
                                                    <span class="r__left">                                                                                                       <span
                                                            class="product_single__price-option">{{ $variant['option'] }}</span>
                                                    </span>
                                                    <span class="r_right">
                                                                <span
                                                                    class="product_single__price-value">{{ $variant['price'] }}</span>
                                                <span class="currency">{{ config('currency.currency.RUB') }}</span>
                                                    </span>

                                                </span>
                                            </label>
                                        @endforeach
                                    @elseif($product->display_price)
                                        <input type="hidden" name="price" value="{{ $product->display_price }}">
                                        <div class="product_single__price_label">Стоимость сертификата</div>
                                        <div class="product_single__price-row product_single__price-one">
                                            <span
                                                class="product_single__price-value">{{ $product->display_price }}</span>
                                            <span class="currency">{{ config('currency.currency.RUB') }}</span>
                                        </div>
                                    @endif
                                    <br>
                                    @auth
                                        <button type="submit" class="product_single__btn btn btn-big">{{ config('site.constants.buy_certificate') }}</button>
                                    @else
                                        <button type="button" data-form="fast_registration" data-transfer="{{ json_encode(['redirect' => url()->current()]) }}" class="open-fancybox product_single__btn btn btn-big js-guest-buy">{{ config('site.constants.buy_certificate') }}</button>
                                    @endauth
                                </x-form.form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($product->desc)
                <div class="product_single__desc desc">
                    <h2>Описание</h2>
                    {!! $product->desc !!}
                </div>
            @endif

            @if($product->other_info)
                <div class="product_single__desc desc">
                    <h2>Дополнительная информация</h2>
                    {!! $product->other_info !!}
                </div>

            @endif
            <br>
            <div class="product_single__back">
                <a href="{{ route('certificates', ['category' => $category]) }}">← Назад к списку</a>
            </div>

        </div>
    </section>

@endsection
