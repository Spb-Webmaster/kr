@extends('layouts.partial.layout-page', ['class' => 'auth'])
<x-seo.meta
    title="Только для продавцов | Вход в личный кабинет"
    description="Только для продавцов |  Вход в личный кабинет"
    keywords="Только для продавцов |  Вход в личный кабинет"
/>
@section('content-home')
    <main class="auth app_form_loader">

        <section>
            <div class="block block_content">

                <div class="window_white_wrap">
                    <div class="window_white">
                        <x-form.form-loader />
                        <div class="window_white__padding">

                            <x-cabinet.title2
                                title="ВХОД для продавцов"
                                subtitle="Вход для поставщиков услуг"
                            />
                            <x-form action="{{ route('vendor_handel_sign_in') }}">
                                <x-form.form-input
                                    name="email"
                                    type="email"
                                    label="Email"
                                    value="{{ ( session('v_email') ) ?  : '' }}"
                                    required="{{ true }}"
                                    autofocus="{{ true }}"
                                />
                                <x-form.form-input
                                    name="password"
                                    type="password"
                                    label="Пароль"
                                    value="{{ ( session('v_password') ) ?  : '' }}"
                                    required="{{ true }}"
                                />
                                <div class="input-button ">
                                    <x-form.form-button class="w_100_important" type="submit">Войти</x-form.form-button>
                                </div>
                                <div class="auth_links">
                                    <div class="auth_link"><a href="{{ route('vendor_sign_up') }}">Регистрация</a></div>
                                </div>
                            </x-form>

                        </div>
                    </div>
                </div>

            </div>
        </section>

    </main>
    <section class="block relative">
        <x-site.catalog.category.category/>
    </section>
@endsection


