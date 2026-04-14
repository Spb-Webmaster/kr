@extends('layouts.partial.layout-page', ['class' => 'auth'])
<x-seo.meta
    title="Регистрация поставщиков услуг"
    description="Регистрация поставщиков услуг"
    keywords="Регистрация поставщиков услуг"
/>
@section('content-home')
    <main class="auth sign_up app_form_loader">

        <section>
            <div class="block block_content ">

                <div class="window_white_wrap">
                    <div class="window_white">

                        <div class="window_white__padding">

                            <x-cabinet.title2
                                title="Регистрация продавцов"
                                subtitle="Если вы желаете продавать услуги через сайт, требуется регистрация"
                            />

                            <x-form action="{{ route('vendor_handel_sign_up') }}">

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

                                <x-form.form-select
                                    name="Типы предпринимательской деятельности" {{-- назване --}}
                                    :selected="$types[0]['key']"
                                    :value="$types[0]['value']"
                                    :options="$types"
                                    field_name="type"
                                />

                                <div class="input-button">
                                    <x-form.form-button class="w_100_important" type="submit">1 Шаг. Далее
                                    </x-form.form-button>
                                </div>

                                <div class="auth_links">
                                    <div class="auth_link"><a href="{{ route('vendor_login') }}">Вход</a></div>
                                </div>

                            </x-form>

                        </div>
                    </div>
                </div>

            </div>
        </section>

    </main>
@endsection



