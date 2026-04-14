@extends('layouts.partial.layout-page', ['class' => ''])
<x-seo.meta
    title="Личный кабинет продавца"
    description="Личный кабинет продавца"
    keywords="Личный кабинет продавца"
/>
@section('content-home')
    <main class="">
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
                            <div class="">
                                <h2 class="h1">{{ $vendor->surname }} {{ $vendor->username }} {{ $vendor->patronymic }}</h2>
                                <div class="vendor_table">
                                    <div class="tr">
                                        <div class="td">Email</div>
                                        <div class="td">{{ $vendor->email }}</div>
                                    </div>

                                    <div class="tr">
                                        <div class="td">Телефон</div>
                                        <div class="td">{{ format_phone($vendor->phone) }}</div>
                                    </div>

                                    <div class="tr">
                                        <div class="td_100">
                                            <div class="title">Описание деятельности</div>
                                            {!!  $vendor->about_me !!}
                                        </div>

                                    </div>

                                </div>
                                <hr>
                                <h2 class="h1">{{ $vendor->type }}</h2>
                                <div class="vendor_table">
                                    @foreach($vendor->array_data as $k => $value)
                                        <div class="tr">
                                            <div class="td">{{ $k }}</div>
                                            <div class="td">{{ $value}}</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
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




