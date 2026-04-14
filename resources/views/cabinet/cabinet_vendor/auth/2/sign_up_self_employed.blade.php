@extends('layouts.partial.layout-page', ['class' => 'auth'])
<x-seo.meta
    title="Самозанятый | Регистрация поставщиков услуг"
    description="Самозанятый | Регистрация поставщиков услуг"
    keywords="Самозанятый | Регистрация поставщиков услуг"
/>
@section('content-home')
    <main class="auth sign_up app_form_loader">

        <section>
            <div class="block block_content ">

                <div class="window_white_wrap">
                    <div class="window_white window_white__840">

                        <div class="window_white__padding">

                            <x-cabinet.title3
                                title="Самозанятый"
                                subtitle="Для продолжения регистрации заполните все поля"
                            ><a href="#" class="btn btn-big open-fancybox" data-form="i_want_to_meet_you">{{ config('site.constants.i_want_to_meet_you') }}</a></x-cabinet.title3>

                            <x-form
                                action="{{ route('vendor_handel_sign_up_final') }}"
                                class="pad_t10"
                            >

                                <div class="cu_row cu_row_30">
                                    <div class="cu__col">
                                        <div class="input-group">
                                            <x-form.form-input
                                                name="surname"
                                                type="text"
                                                :label="config('site.constants.surname')"
                                                value="{{ (old('surname')) ?: '' }}"
                                                required="true"
                                            />
                                        </div>
                                    </div>

                                    <div class="cu__col">
                                        <div class="input-group">
                                            <x-form.form-input
                                                name="username"
                                                type="text"
                                                :label="config('site.constants.username')"
                                                value="{{ (old('username')) ?: (($username) ?: '')  }}"
                                                required="true"
                                            />
                                        </div>
                                    </div>

                                    <div class="cu__col">
                                        <div class="input-group">
                                            <x-form.form-input
                                                name="patronymic"
                                                type="text"
                                                :label="config('site.constants.patronymic')"
                                                value="{{ (old('patronymic')) ?: '' }}"
                                            />
                                        </div>
                                    </div>
                                </div>

                                <x-form.form-select
                                    :name="config('site.constants.city')" {{-- назване --}}
                                   :options="$cities"
                                    :selected="old('city_id')"
                                    field_name="city_id"
                                    required="true"
                                />

                                <x-form.form-textarea
                                    name="about_me"
                                    class="about_me"
                                    editor="true"
                                    :label="config('site.constants.about_me')"
                                    value="{!!  (old('about_me'))?:'' !!}"

                                />

                                <div class="cu_row cu_row_30">
                                    <div class="cu__col">
                                        <div class="input-group">
                                            <x-form.form-input
                                                name="phone"
                                                type="tel"
                                                :label="config('site.constants.phone')"
                                                value="{{ (old('phone'))?:'' }}"
                                                class="imask"
                                            />
                                        </div>
                                    </div>

                                    <div class="cu__col">
                                        <div class="input-group">
                                            <x-form.form-input
                                                name="email"
                                                type="email"
                                                :label="config('site.constants.email')"
                                                value="{{ (old('email')) ?: (($email) ?: '')  }}"
                                                required="true"
                                            />
                                        </div>
                                    </div>

                                    <div class="cu__col">
                                        <div class="input-group">
                                            <x-form.form-input
                                                name="inn"
                                                type="text"
                                                :label="config('site.constants.inn')"
                                                value="{{ (old('inn'))?:'' }}"
                                                required="true"
                                            />
                                        </div>
                                    </div>
                                </div>

                                <div class="cu_row_50">
                                    <div class="cu__col">
                                        <x-form.form-input
                                            name="register_address "
                                            type="text"
                                            :label="config('site.constants.register_address')"
                                            value="{{ (old('register_address'))?:'' }}"

                                        />
                                    </div>
                                    <div class="cu__col">
                                        <x-form.form-input
                                            name="address"
                                            type="text"
                                            :label="config('site.constants.address')"
                                            value="{{ (old('address'))?:'' }}"

                                        />
                                    </div>
                                </div>


                                <div class="cu_row_50">
                                    <div class="cu__col">
                                        <x-form.form-input
                                            name="passport_serial"
                                            type="text"
                                            :label="config('site.constants.passport_serial')"
                                            value="{{ (old('passport_serial'))?:'' }}"
                                        />
                                    </div>
                                    <div class="cu__col">
                                        <x-form.form-input
                                            name="passport_number"
                                            type="number"
                                            :label="config('site.constants.passport_number')"
                                            value="{{ (old('passport_number'))?:'' }}"
                                        />
                                    </div>
                                </div>

                                <x-form.form-input
                                    name="who_issued"
                                    type="text"
                                    :label="config('site.constants.who_issued')"
                                    value="{{ (old('who_issued'))?:'' }}"
                                />

                                <x-form.form-input
                                    name="date_issued"
                                    type="text"
                                    :label="config('site.constants.date_issued')"
                                    value="{{ (old('date_issued'))?:'' }}"
                                />

                                <div class="cu_row_50">
                                    <div class="cu__col">
                                        <x-form.form-input
                                            name="bank"
                                            type="text"
                                            :label="config('site.constants.bank')"
                                            value="{{ (old('bank'))?:'' }}"
                                        />
                                    </div>
                                    <div class="cu__col">
                                        <x-form.form-input
                                            name="bik"
                                            type="text"
                                            :label="config('site.constants.bik')"
                                            value="{{ (old('bik'))?:'' }}"
                                        />
                                    </div>
                                </div>

                                <div class="cu_row_50">
                                    <div class="cu__col">
                                        <x-form.form-input
                                            name="correspondent_account"
                                            type="text"
                                            :label="config('site.constants.correspondent_account')"
                                            value="{{ (old('correspondent_account'))?:'' }}"
                                        />
                                    </div>
                                    <div class="cu__col">
                                        <x-form.form-input
                                            name="payment_account"
                                            type="text"
                                            :label="config('site.constants.payment_account')"
                                            value="{{ (old('payment_account'))?:'' }}"
                                        />
                                    </div>
                                </div>





                                <div class="input-button">
                                    <x-cabinet.partial.sign_up_buttons
                                        prev="Назад"
                                        :route="route('vendor_handel_sign_up')"
                                        next="Зарегистрироваться"
                                    />
                                </div>

                            </x-form>

                        </div>
                    </div>
                </div>

            </div>
        </section>

    </main>
@endsection
