@extends('layouts.partial.layout-page', ['class' => ''])
<x-seo.meta
    title="Список услуг"
    description="Список услуг"
    keywords="Список услуг"
/>
@section('content-home')
    <main class="cabinet_vendor_services">
        <section>
            <div class="block_content cabinet_user">

                <x-cabinet.cabinet_vendor.title
                    title="Профиль продавца услуг"
                    :username="$vendor->username"
                    :surname="$vendor->surname"
                    :patronymic="$vendor->patronymic"
                />

                <x-cabinet.menu.cabinet_vendor.menu-horizontal/>

                <div class="block_content__flex">
                    <div class="block_content__left">
                        <div class="cabinet_radius12_fff">
                            <x-cabinet.title2
                                class="top_0 pad_b33_important"
                                title="Список ваших услуг"
                                subtitle="Вы можете редактировать свои услуги"
                            />

                            @if($products->isEmpty())
                                <p class="vendor-service-card__empty">У вас пока нет добавленных услуг.</p>
                            @else
                                <div class="vendor-services-list">
                                    @foreach($products as $product)
                                        <div class="vendor-service-card">
                                            <a href="{{ route('cabinet_vendor_service_edit', $product->id) }}" class="vendor-service-card__img">
                                                @if($product->img)
                                                    <img
                                                        src="{{ Storage::url($product->img) }}"
                                                        alt="{{ $product->title }}"
                                                    >
                                                @endif
                                            </a>
                                            <div class="vendor-service-card__body">
                                                <a href="{{ route('cabinet_vendor_service_edit', $product->id) }}" class="vendor-service-card__title">{{ $product->title }}</a>
                                                <p class="vendor-service-card__price">{{ $product->display_price }}</p>

                                               <div class="vendor-service_flex">
                                                <span class="vendor-service-card__status {{ $product->published ? 'vendor-service-card__status--published' : 'vendor-service-card__status--pending' }}">
                                                    {{ $product->published ? 'Опубликовано' : 'На модерации' }}
                                                </span>
                                                @if($product->order_papers_count > 0)
                                                    <span class="vendor-service-card__papers-badge" title="Выписаны бумажные сертификаты">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                                                        Бумажные сертификаты
                                                    </span>
                                                @endif
                                               </div>

                                            </div>
                                            @if($product->published)
                                                <a href="{{ route('certificate', $product->slug) }}"
                                                   target="_blank"
                                                   class="vendor-service-card__link"
                                                   title="Открыть страницу услуги">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
                                                        <polyline points="15 3 21 3 21 9"/>
                                                        <line x1="10" y1="14" x2="21" y2="3"/>
                                                    </svg>
                                                </a>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>

                                {{ $products->withQueryString()->links('pagination::default') }}
                            @endif
                        </div>
                    </div>

                    <div class="block_content__right">
                        @include('cabinet.cabinet_vendor.partial.right_bar')
                    </div>

                </div>
            </div>
        </section>
    </main>
    <section class="block relative">
        <x-site.catalog.category.category/>
    </section>
@endsection





