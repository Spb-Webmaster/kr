@extends('layouts.partial.layout-page', ['class' => ''])
<x-seo.meta
    title="Редактирование профиля"
    description="Редактирование профиля продавца услуг"
    keywords="Редактирование профиля продавца"
/>
@section('content-home')
    <main class="">
        <section>
            <div class="block_content cabinet_user">

                <x-cabinet.cabinet_vendor.title
                    title="Редактирование профиля"
                    :username="$vendor->username"
                    :surname="$vendor->surname"
                    :patronymic="$vendor->patronymic"
                />

                <x-cabinet.menu.cabinet_vendor.menu-horizontal/>

                <div class="block_content__flex">
                    <div class="block_content__left">
                        <div class="cabinet_radius12_fff">

                            <x-form action="{{ route('cabinet_vendor_edit_update') }}">

                                {{-- Личные данные --}}
                                <x-cabinet.title
                                    title="Личные данные"
                                    subtitle="Измените свои личные данные"
                                />

                                <div class="cu_row cu_row_30">
                                    <div class="cu__col">
                                        <x-form.form-input
                                            name="surname"
                                            type="text"
                                            label="Фамилия"
                                            value="{{ old('surname', $vendor->surname) }}"
                                        />
                                    </div>
                                    <div class="cu__col">
                                        <x-form.form-input
                                            name="username"
                                            type="text"
                                            label="Имя"
                                            value="{{ old('username', $vendor->username) }}"
                                            required="true"
                                        />
                                    </div>
                                    <div class="cu__col">
                                        <x-form.form-input
                                            name="patronymic"
                                            type="text"
                                            label="Отчество"
                                            value="{{ old('patronymic', $vendor->patronymic) }}"
                                        />
                                    </div>
                                </div>

                                <x-form.form-textarea
                                    name="about_me"
                                    class="about_me"
                                    editor="true"
                                    :label="config('site.constants.about_me')"
                                    value="{!! old('about_me', $vendor->about_me) !!}"
                                />

                                <div class="cu_row_50">
                                    <div class="cu__col">
                                        <x-form.form-input
                                            name="phone"
                                            type="tel"
                                            :label="config('site.constants.phone')"
                                            value="{{ old('phone', $vendor->phone) }}"
                                            class="imask"
                                        />
                                    </div>
                                    <div class="cu__col">
                                        <x-form.form-select
                                            :name="config('site.constants.city')"
                                            :options="$cities"
                                            :selected="old('city_id', $vendor->city_id)"
                                            field_name="city_id"
                                        />
                                    </div>
                                </div>

                                <hr>

                                {{-- Данные компании --}}
                                <x-cabinet.title
                                    :title="$vendor->type"
                                    subtitle="Измените свои личные данные"
                                />

                                @if($vendor->selfEmployed)
                                    @php $se = $vendor->selfEmployed; @endphp

                                    <div class="cu_row_50">
                                        <div class="cu__col">
                                            <x-form.form-input name="register_address" type="text" :label="config('site.constants.register_address')" value="{{ old('register_address', $se->register_address) }}" />
                                        </div>
                                        <div class="cu__col">
                                            <x-form.form-input name="address" type="text" :label="config('site.constants.address')" value="{{ old('address', $se->address) }}" />
                                        </div>
                                    </div>

                                    <div class="cu_row_50">
                                        <div class="cu__col">
                                            <x-form.form-input name="passport_serial" type="text" :label="config('site.constants.passport_serial')" value="{{ old('passport_serial', $se->passport_serial) }}" />
                                        </div>
                                        <div class="cu__col">
                                            <x-form.form-input name="passport_number" type="text" :label="config('site.constants.passport_number')" value="{{ old('passport_number', $se->passport_number) }}" />
                                        </div>
                                    </div>

                                    <div class="cu_row_50">
                                        <div class="cu__col">
                                            <x-form.form-input name="who_issued" type="text" :label="config('site.constants.who_issued')" value="{{ old('who_issued', $se->who_issued) }}" />
                                        </div>
                                        <div class="cu__col">
                                            <x-form.form-input name="date_issued" type="text" :label="config('site.constants.date_issued')" value="{{ old('date_issued', $se->date_issued) }}" />
                                        </div>
                                    </div>

                                    <x-form.form-input name="bank" type="text" :label="config('site.constants.bank')" value="{{ old('bank', $se->bank) }}" />

                                    <div class="cu_row_50">
                                        <div class="cu__col">
                                            <x-form.form-input name="bik" type="text" :label="config('site.constants.bik')" value="{{ old('bik', $se->bik) }}" />
                                        </div>
                                        <div class="cu__col">
                                            <x-form.form-input name="correspondent_account" type="text" :label="config('site.constants.correspondent_account')" value="{{ old('correspondent_account', $se->correspondent_account) }}" />
                                        </div>
                                    </div>

                                    <x-form.form-input name="payment_account" type="text" :label="config('site.constants.payment_account')" value="{{ old('payment_account', $se->payment_account) }}" />

                                @elseif($vendor->individualEntrepreneur)
                                    @php $ie = $vendor->individualEntrepreneur; @endphp

                                    <div class="cu_row_50">
                                        <div class="cu__col">
                                            <x-form.form-input name="ie_name" type="text" :label="config('site.constants.name')" value="{{ old('ie_name', $ie->name) }}" />
                                        </div>
                                        <div class="cu__col">
                                            <x-form.form-input name="ie_full_name" type="text" :label="config('site.constants.full_name')" value="{{ old('ie_full_name', $ie->full_name) }}" />
                                        </div>
                                    </div>

                                    <div class="cu_row_50">
                                        <div class="cu__col">
                                            <x-form.form-input name="register_address" type="text" :label="config('site.constants.register_address')" value="{{ old('register_address', $ie->register_address) }}" />
                                        </div>
                                        <div class="cu__col">
                                            <x-form.form-input name="address" type="text" :label="config('site.constants.address')" value="{{ old('address', $ie->address) }}" />
                                        </div>
                                    </div>

                                    <div class="cu_row_50">
                                        <div class="cu__col">
                                            <x-form.form-input name="ogrnip" type="text" :label="config('site.constants.ogrnip')" value="{{ old('ogrnip', $ie->ogrnip) }}" />
                                        </div>
                                        <div class="cu__col">
                                            <x-form.form-input name="okved" type="text" :label="config('site.constants.okved')" value="{{ old('okved', $ie->okved) }}" />
                                        </div>
                                    </div>

                                    <x-form.form-input name="bank" type="text" :label="config('site.constants.bank')" value="{{ old('bank', $ie->bank) }}" />

                                    <div class="cu_row_50">
                                        <div class="cu__col">
                                            <x-form.form-input name="bik" type="text" :label="config('site.constants.bik')" value="{{ old('bik', $ie->bik) }}" />
                                        </div>
                                        <div class="cu__col">
                                            <x-form.form-input name="correspondent_account" type="text" :label="config('site.constants.correspondent_account')" value="{{ old('correspondent_account', $ie->correspondent_account) }}" />
                                        </div>
                                    </div>

                                    <x-form.form-input name="payment_account" type="text" :label="config('site.constants.payment_account')" value="{{ old('payment_account', $ie->payment_account) }}" />

                                    <div class="cu_row_50">
                                        <div class="cu__col">
                                            <x-form.form-select
                                                :name="config('site.constants.taxation')"
                                                :options="$taxations"
                                                :selected="old('taxation_id', $ie->taxation_id)"
                                                field_name="taxation_id"
                                            />
                                        </div>
                                        <div class="cu__col">
                                            <x-form.form-select
                                                :name="config('site.constants.payment_nds')"
                                                :options="$payment_nds"
                                                :selected="old('payment_nds', $ie->payment_nds)"
                                                field_name="payment_nds"
                                            />
                                        </div>
                                    </div>

                                @elseif($vendor->legalEntity)
                                    @php $le = $vendor->legalEntity; @endphp

                                    <div class="cu_row_50">
                                        <div class="cu__col">
                                            <x-form.form-input name="le_name" type="text" :label="config('site.constants.name')" value="{{ old('le_name', $le->name) }}" />
                                        </div>
                                        <div class="cu__col">
                                            <x-form.form-input name="le_full_name" type="text" :label="config('site.constants.full_name')" value="{{ old('le_full_name', $le->full_name) }}" />
                                        </div>
                                    </div>

                                    <div class="cu_row_50">
                                        <div class="cu__col">
                                            <x-form.form-input name="legal_address" type="text" :label="config('site.constants.legal_entity_address')" value="{{ old('legal_address', $le->legal_address) }}" />
                                        </div>
                                        <div class="cu__col">
                                            <x-form.form-input name="address" type="text" :label="config('site.constants.address')" value="{{ old('address', $le->address) }}" />
                                        </div>
                                    </div>

                                    <div class="cu_row_50">
                                        <div class="cu__col">
                                            <x-form.form-input name="kpp" type="text" :label="config('site.constants.kpp')" value="{{ old('kpp', $le->kpp) }}" />
                                        </div>
                                        <div class="cu__col">
                                            <x-form.form-input name="ogrn" type="text" :label="config('site.constants.ogrn')" value="{{ old('ogrn', $le->ogrn) }}" />
                                        </div>
                                    </div>

                                    <x-form.form-input name="director" type="text" :label="config('site.constants.director')" value="{{ old('director', $le->director) }}" />
                                    <x-form.form-input name="accountant" type="text" :label="config('site.constants.accountant')" value="{{ old('accountant', $le->accountant) }}" />
                                    <x-form.form-input name="person_contract" type="text" :label="config('site.constants.person_contract')" value="{{ old('person_contract', $le->person_contract) }}" />

                                    <x-form.form-input name="bank" type="text" :label="config('site.constants.bank')" value="{{ old('bank', $le->bank) }}" />

                                    <div class="cu_row_50">
                                        <div class="cu__col">
                                            <x-form.form-input name="bik" type="text" :label="config('site.constants.bik')" value="{{ old('bik', $le->bik) }}" />
                                        </div>
                                        <div class="cu__col">
                                            <x-form.form-input name="okved" type="text" :label="config('site.constants.okved')" value="{{ old('okved', $le->okved) }}" />
                                        </div>
                                    </div>

                                    <div class="cu_row_50">
                                        <div class="cu__col">
                                            <x-form.form-input name="correspondent_account" type="text" :label="config('site.constants.correspondent_account')" value="{{ old('correspondent_account', $le->correspondent_account) }}" />
                                        </div>
                                        <div class="cu__col">
                                            <x-form.form-input name="payment_account" type="text" :label="config('site.constants.payment_account')" value="{{ old('payment_account', $le->payment_account) }}" />
                                        </div>
                                    </div>

                                    <div class="cu_row_50">
                                        <div class="cu__col">
                                            <x-form.form-select
                                                :name="config('site.constants.taxation')"
                                                :options="$taxations"
                                                :selected="old('taxation_id', $le->taxation_id)"
                                                field_name="taxation_id"
                                            />
                                        </div>
                                        <div class="cu__col">
                                            <x-form.form-select
                                                :name="config('site.constants.payment_nds')"
                                                :options="$payment_nds"
                                                :selected="old('payment_nds', $le->payment_nds)"
                                                field_name="payment_nds"
                                            />
                                        </div>
                                    </div>
                                @endif

                                <div class="input-button pad_t20">
                                    <x-cabinet.partial.sign_up_buttons
                                        prev="Назад"
                                        :route="route('cabinet_vendor')"
                                        next="Сохранить"
                                    />
                                </div>

                            </x-form>

                        </div>
                    </div>

                    <div class="block_content__right">
                        @include('cabinet.cabinet_vendor.partial.right_bar')
                    </div>
                </div>

            </div>
        </section>
    </main>
@endsection
