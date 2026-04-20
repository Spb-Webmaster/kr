@extends('layouts.partial.layout-page', ['class' => ''])
<x-seo.meta
    title="Заказ № {{ $order->number }}"
    description=""
    keywords=""
/>
@section('noindex', true)
@section('content-home')

    <section class="block relative">
        <x-site.catalog.category.category/>
    </section>

    <section class="block relative">
        <div class="product_single">

            <div class="title">
                <h1 class="product_single__title">Заказ оформлен (Данная страница в разработке)</h1>
            </div>

            <div class="order_info">

                <div class="order_info__row">
                    <span class="order_info__label">Номер заказа</span>
                    <span class="order_info__value">{{ $order->number }}</span>
                </div>

                <div class="order_info__row">
                    <span class="order_info__label">Услуга</span>
                    <span class="order_info__value">{{ $order->title }}</span>
                </div>

                @if($order->price_option)
                    <div class="order_info__row">
                        <span class="order_info__label">Вариант</span>
                        <span class="order_info__value">{{ $order->price_option }}</span>
                    </div>
                @endif

                <div class="order_info__row">
                    <span class="order_info__label">Стоимость</span>
                    <span class="order_info__value">{{ price($order->price) }} {{ config('currency.currency.RUB') }}</span>
                </div>

                <div class="order_info__row">
                    <span class="order_info__label">Имя</span>
                    <span class="order_info__value">{{ $order->username }}</span>
                </div>

                <div class="order_info__row">
                    <span class="order_info__label">E-mail</span>
                    <span class="order_info__value">{{ $order->email }}</span>
                </div>

                @if($order->phone)
                    <div class="order_info__row">
                        <span class="order_info__label">Телефон</span>
                        <span class="order_info__value">{{ $order->phone }}</span>
                    </div>
                @endif

            </div>

        </div>
    </section>

@endsection

