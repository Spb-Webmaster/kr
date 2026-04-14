@extends('layouts.partial.layout-page', ['class' => 'auth'])
<x-seo.meta
    title="Забыли пароль"
    description="Забыли пароль"
    keywords="Забыли пароль"
/>
@section('content-home')
    <main class="auth app_form_loader">

        <section>
            <div class="block block_content">

                <div class="window_white_wrap">
                    <div class="window_white">
                        @if(!$forgot)
                            <div class="window_white__padding">

                                <x-cabinet.title2
                                    title="Восстановление пароля"
                                    subtitle="Введите свой  email указанный при регистрации"
                                />

                                <x-form action="{{ route('handel_forgot') }}">
                                    <x-form.form-input
                                        name="email"
                                        type="email"
                                        label="Email"
                                        value="{{ old('email')?:'' }}"
                                        required="{{ true }}"
                                        autofocus="{{ true }}"
                                    />

                                    <div class="input-button ">
                                        <x-form.form-button class="w_100_important" type="submit">Отправить</x-form.form-button>
                                    </div>

                                </x-form>

                            </div>
                            @else
                            <div class="window_white__padding">
                                <x-cabinet.title2
                                    title="{{ config('site.constants.reset_password') }}"
                                    subtitle="{{ config('site.constants.reset_password_text') }}"
                                />

                            </div>

                        @endif
                    </div>
                </div>

            </div>
        </section>

    </main>
    <section class="block relative">
        <x-site.catalog.category.category/>
    </section>
@endsection


