@extends('layouts.partial.layout-page', ['class' => 'auth'])
<x-seo.meta
    title="Регистрация"
    description="Регистрация"
    keywords="Регистрация"
/>
@section('content-home')
    <main class="auth sign_up app_form_loader">

       <section>
            <div class="block block_content ">

                <div class="window_white_wrap">
                    <div class="window_white">
                        <x-form.form-loader/>

                        <div class="window_white__padding">

                            <x-cabinet.title2
                                title="Регистрация"
                                subtitle="Для работы в личном кабинете требуется регистрация"
                            ></x-cabinet.title2>

                            <x-form action="{{ route('handle_sign_up') }}">

                                <x-form.form-input
                                    name="username"
                                    type="text"
                                    label="Имя"
                                    value="{{ old('username')?:'' }}"
                                    required="{{ true }}"
                                    autofocus="{{ true }}"
                                />
                                <x-form.form-input
                                    name="email"
                                    type="text"
                                    label="Email"
                                    value="{{ old('email')?:'' }}"
                                    required="{{ true }}"
                                />
                                <x-form.form-input
                                    name="password"
                                    type="password"
                                    label="Пароль"
                                    value="{{ old('password')?:'' }}"
                                    required="{{ true }}"
                                />

                                <x-form.form-input
                                    name="password_confirmation"
                                    type="password"
                                    label="Повторите пароль"
                                    required="{{ true }}"
                                />


                                <div class="input-button ">
                                    <x-form.form-button class="w_100_important" type="submit">Зарегистрироваться
                                    </x-form.form-button>
                                </div>
                                <div class="auth_links">
                                    <div class="auth_link"><a href="{{ route('forgot') }}">Восстановить пароль</a></div>
                                    <div class="auth_link"><a href="{{ route('login') }}">Вход</a></div>
                                </div>
                            </x-form>

                        </div>
                    </div>
                </div>

            </div>
        </section>

    </main>
@endsection


