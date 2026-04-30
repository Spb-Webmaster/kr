@extends('layouts.partial.layout-page', ['class' => ''])
<x-seo.meta
    title="Мои сертификаты"
    description=""
    keywords=""
/>
@section('noindex', true)
@section('content-home')
    <main class="">
        <section>
            <div class="block_content cabinet_user">

                <div class="block_content__title">
                    <h1 class="h1">Мои сертификаты</h1>
                </div>

                <x-cabinet.menu.cabinet_user.menu-horizontal />

                <div class="block_content__flex">
                    <div class="block_content__left">
                        <div class="cabinet_radius12_fff">
                        <div class="cabinet-certificates">

                            @forelse($orders as $order)
                                <div class="cabinet-cert-item">
                                    <div class="cabinet-cert-item__left">
                                        <div class="cabinet-cert-item__number">№ {{ $order->number }}</div>
                                        <div class="cabinet-cert-item__title">{{ $order->title }}</div>
                                        @if($order->price_option)
                                            <div class="cabinet-cert-item__option">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>
                                                </svg>
                                                {{ $order->price_option }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="cabinet-cert-item__right">
                                        <div class="cabinet-cert-item__price">{{ price($order->price) }} {{ config('currency.currency.RUB') }}</div>
                                        <div class="cabinet-cert-item__status {{ $order->status_yoo_kassa === 'succeeded' ? 'cabinet-cert-item__status--active' : 'cabinet-cert-item__status--pending' }}">
                                            {{ $order->status_yoo_kassa === 'succeeded' ? 'Оплачен' : 'В ожидании' }}
                                        </div>
                                        <a href="{{ route('order.show', $order->number) }}" class="cabinet-cert-item__link">
                                            Подробнее
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="cabinet-certificates__empty">
                                    <p>У вас пока нет сертификатов.</p>
                                </div>
                            @endforelse

                            {{ $orders->withQueryString()->links('pagination::default') }}

                        </div>
                        </div>
                    </div>

                    <div class="block_content__right">
                        @include('cabinet.cabinet_user.partial.right_bar')
                    </div>
                </div>

            </div>
        </section>
    </main>
    <section class="block relative">
        <x-site.catalog.category.category/>
    </section>
@endsection
