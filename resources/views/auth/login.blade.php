@extends('layouts.partial.layout-page', ['class' => 'auth'])
<x-seo.meta
    title="Вход в личный кабинет"
    description="Вход в личный кабинет"
    keywords="Вход в личный кабинет"
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
                                title="Авторизация"
                                subtitle="Для просмотра личного кабинете требуется вход"
                            />
                            <x-form action="{{ route('handle_login') }}">
                                <x-form.form-input
                                    name="email"
                                    type="email"
                                    label="Email"
                                    value="{{ old('email')?:'' }}"
                                    required="{{ true }}"
                                    autofocus="{{ true }}"
                                />
                                <x-form.form-input
                                    name="password"
                                    type="password"
                                    label="Пароль"
                                    value="{{ old('password')?:'' }}"
                                    required="{{ true }}"
                                />
                                <div class="input-button ">
                                    <x-form.form-button class="w_100_important" type="submit">Войти</x-form.form-button>
                                </div>
                                <div class="auth_links">
                                <div class="auth_link"><a href="{{ route('forgot') }}">Восстановить пароль</a></div>
                                <div class="auth_link"><a href="{{ route('sign_up') }}">Регистрация</a></div>
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

