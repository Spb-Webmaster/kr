@extends('layouts.partial.layout-page', ['class' => ''])
<x-seo.meta
    title="Редактирование личных данных"
    description="Редактирование личных данных"
    keywords="Редактирование личных данных"
/>
@section('content-home')
    <main class="">
        <section>
            <div class="block_content cabinet_user">
                <div class="block_content__title"><h1 class="h1">Мой профиль</h1>
                    @if($user->UserHuman)
                        <p class="_subtitle">{{ $user->UserHuman->title }}</p>
                    @endif
                </div>

                <x-cabinet.menu.cabinet_user.menu-horizontal />

                <div class="block_content__flex">
                    <div class="block_content__left">
                        <div class="cabinet_radius12_fff">

                            <x-cabinet.cabinet_user.update-data :user="$user"/>

                            <x-cabinet.cabinet_user.update-password />

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



