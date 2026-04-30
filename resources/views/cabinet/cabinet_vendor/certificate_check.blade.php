@extends('layouts.partial.layout-page', ['class' => ''])
<x-seo.meta
    title="Проверка сертификата"
    description="Проверка сертификата"
    keywords="Проверка сертификата"
/>
@section('content-home')
    <main class="certificate-check">
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

                        <div class="cabinet_radius12_fff" id="">
                            <x-cabinet.title2
                                class="top_0 pad_b33_important"
                                title="Проверка сертификата"
                                subtitle="Введите номер сертификата для проверки"
                            />
                            <x-form.form action="{{ route('cabinet_vendor_certificate_check_handle') }}">
                                <x-form.form-input
                                    name="number"
                                    label="Номер сертификата"
                                    :value="$number ?? old('number')"
                                    :required="true"
                                />
                                <x-form.form-submit type="submit" class="btn_green btn-big">Проверить</x-form.form-submit>
                            </x-form.form>
                        </div>

                        @isset($number)
                            <div id="come-on-mobile"></div>
                            @if(!$result)
                                <div class="edit-form-notice">
                                    <strong>Сертификат не найден.</strong>
                                    Номер <strong>{{ $number }}</strong> не существует или не относится к вашим услугам. Проверьте правильность введённого номера.
                                </div>
                            @endif
                            @if($result)
                                @php
                                    $model  = $result['model'];
                                    $type   = $result['type'];
                                    $status = $model->certificate_status;
                                @endphp

                                    <div class="order-confirmation">
                                        <section class="order-cert-card">
                                            <div class="order-cert-ribbon">
                                                <div>
                                                    <div class="order-cert-ribbon__label">Номер сертификата</div>
                                                    <div class="order-cert-ribbon__number">№ {{ $model->number }}</div>
                                                </div>
                                                <div class="order-cert-ribbon__status {{ $status === \App\Enum\CertificateStatus::Used ? 'order-cert-ribbon__status--pending' : '' }}">
                                                    {{ $status->toString() }}
                                                </div>
                                            </div>

                                            <div class="order-cert-body">
                                                <div class="order-cert-eyebrow">Подарочный сертификат</div>
                                                <h2 class="order-cert-title">{{ $model->product?->title ?? '—' }}</h2>

                                                <div class="order-cert-rows">
                                                    <div class="order-cert-row">
                                                        <span class="order-cert-row__key">Услуга</span>
                                                        <span class="order-cert-row__val">{{ $model->product?->title ?? '—' }}</span>
                                                    </div>
                                                    @if($model->price_option)
                                                        <div class="order-cert-row">
                                                            <span class="order-cert-row__key">Вариант</span>
                                                            <span class="order-cert-row__val">{{ $model->price_option }}</span>
                                                        </div>
                                                    @endif
                                                    <div class="order-cert-row">
                                                        <span class="order-cert-row__key">Статус</span>
                                                        <span class="order-cert-row__val">{{ $status->toString() }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="order-cert-total">
                                                <span class="order-cert-total__label">Сумма</span>
                                                <span class="order-cert-total__amount">{{ price($model->price) }} {{ config('currency.currency.RUB') }}</span>
                                            </div>
                                        </section>
                                    </div>

                                    @if($status === \App\Enum\CertificateStatus::Unused)
                                        <x-form.form action="{{ route('cabinet_vendor_certificate_redeem') }}">
                                            <input type="hidden" name="type" value="{{ $type }}">
                                            <input type="hidden" name="id" value="{{ $model->id }}">
                                            <x-form.form-submit type="submit" class="btn_green btn-big">Погасить сертификат</x-form.form-submit>
                                        </x-form.form>
                                    @else
                                        <div class="edit-form-notice">
                                            <strong>Сертификат уже использован.</strong>
                                            Данный сертификат был погашен ранее.
                                        </div>
                                    @endif

                            @endif
                        @endisset

                    </div>

                    <div class="block_content__right">
                        @include('cabinet.cabinet_vendor.partial.right_bar')
                    </div>
                </div>

            </div>
        </section>
    </main>
@endsection

@isset($number)
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                if (window.innerWidth < 1024) {
                    var target = document.getElementById('come-on-mobile');
                    if (target) {
                        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                }
            });
        </script>
    @endpush
@endisset
