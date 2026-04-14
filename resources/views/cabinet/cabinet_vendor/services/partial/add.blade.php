@extends('layouts.partial.layout-page', ['class' => ''])
<x-seo.meta
    title="Добавить услугу"
    description="Добавить услугу"
    keywords="Добавить услугу"
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
                            <h2 class="h1">Добавить услугу</h2>
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

