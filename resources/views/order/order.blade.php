@extends('layouts.partial.layout-page', ['class' => ''])
<x-seo.meta
    title="Заказ № {{ $order->number }}"
    description=""
    keywords=""
/>
@section('noindex', true)
@section('content-home')

    <section class="block relative">
        <x-site.catalog.category.category/>
    </section>

    <section class="block relative">
        <div class="order-confirmation">

            {{-- Success header --}}
            <div class="order-success-header">
                <div class="order-success-badge">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12l5 5L20 7"/>
                    </svg>
                </div>
                <h1 class="order-success-title">Заказ оформлен</h1>
                <p class="order-success-sub">Спасибо за покупку! Сертификат отправлен на указанную электронную почту.<br>Ниже — подробности вашего заказа.</p>
            </div>

            <div class="order-grid">

                {{-- Certificate card --}}
                <section class="order-cert-card">
                    <div class="order-cert-ribbon">
                        <div>
                            <div class="order-cert-ribbon__label">Номер заказа</div>
                            <div class="order-cert-ribbon__number">№ {{ $order->number }}</div>
                        </div>
                        @if($order->status_yoo_kassa === 'succeeded')
                            <div class="order-cert-ribbon__status">Оплачен</div>
                        @elseif($order->status_yoo_kassa)
                            <div class="order-cert-ribbon__status order-cert-ribbon__status--pending">В ожидании</div>
                        @endif
                    </div>

                    <div class="order-cert-body">
                        <div class="order-cert-eyebrow">Подарочный сертификат</div>
                        <h2 class="order-cert-title">{{ $order->title }}</h2>

                        @if($order->price_option)
                            <div class="order-cert-options">
                                <span class="order-opt-chip">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="9"/>
                                        <path d="M12 7v5l3 2"/>
                                    </svg>
                                    Вариант: {{ $order->price_option }}
                                </span>
                            </div>
                        @endif

                        <div class="order-cert-rows">
                            <div class="order-cert-row">
                                <span class="order-cert-row__key">Услуга</span>
                                <span class="order-cert-row__val">{{ $order->title }}</span>
                            </div>
                            @if($order->price_option)
                                <div class="order-cert-row">
                                    <span class="order-cert-row__key">Вариант</span>
                                    <span class="order-cert-row__val">{{ $order->price_option }}</span>
                                </div>
                            @endif
                            <div class="order-cert-row">
                                <span class="order-cert-row__key">Количество</span>
                                <span class="order-cert-row__val">1 сертификат</span>
                            </div>
                            <div class="order-cert-row">
                                <span class="order-cert-row__key">Формат доставки</span>
                                <span class="order-cert-row__val">Электронный (PDF на e-mail)</span>
                            </div>
                        </div>
                    </div>

                    <div class="order-cert-total">
                        <span class="order-cert-total__label">К оплате</span>
                        <span class="order-cert-total__amount">{{ price($order->price) }} {{ config('currency.currency.RUB') }}</span>
                    </div>
                </section>

                {{-- Side column --}}
                <aside class="order-side">

                    <div class="order-side-card">
                        <h3>Данные покупателя</h3>

                        <div class="order-buyer-row">
                            <div class="order-buyer-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="8" r="4"/>
                                    <path d="M4 21c0-4 4-7 8-7s8 3 8 7"/>
                                </svg>
                            </div>
                            <div class="order-buyer-text">
                                <span class="order-buyer-text__label">Имя</span>
                                <span class="order-buyer-text__val">{{ $order->username }}</span>
                            </div>
                        </div>

                        <div class="order-buyer-row">
                            <div class="order-buyer-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="5" width="18" height="14" rx="2"/>
                                    <path d="M3 7l9 6 9-6"/>
                                </svg>
                            </div>
                            <div class="order-buyer-text">
                                <span class="order-buyer-text__label">E-mail</span>
                                <span class="order-buyer-text__val">{{ $order->email }}</span>
                            </div>
                        </div>

                        @if($order->phone)
                            <div class="order-buyer-row">
                                <div class="order-buyer-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.8 19.8 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.37 1.9.72 2.81a2 2 0 0 1-.45 2.11L8.1 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.35 1.85.59 2.81.72A2 2 0 0 1 22 16.92z"/>
                                    </svg>
                                </div>
                                <div class="order-buyer-text">
                                    <span class="order-buyer-text__label">Телефон</span>
                                    <span class="order-buyer-text__val">{{ format_phone($order->phone) }}</span>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="order-next-steps">
                        <strong>Что дальше?</strong>
                        Ваш сертификат уже в пути. Проверьте папку «Входящие» или «Спам».
                    </div>

                    <div class="order-actions">
                        <a href="{{ route('order.certificate', ['number' => $order->number]) }}" class="order-btn order-btn--primary js-cert-download">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                <path d="M7 10l5 5 5-5"/>
                                <path d="M12 15V3"/>
                            </svg>
                            Скачать сертификат (PDF)
                        </a>
                        <button type="button" class="order-btn order-btn--ghost open-fancybox" data-form="send_certificate" data-transfer='{"number":"{{ $order->number }}"}'>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="5" width="18" height="14" rx="2"/>
                                <path d="M3 7l9 6 9-6"/>
                            </svg>
                            Отправить на другой e-mail
                        </button>
                    </div>

                </aside>
            </div>

        </div>
    </section>

@push('scripts')
<style>
.cert-toast {
    position: fixed;
    bottom: 32px;
    left: 50%;
    transform: translateX(-50%) translateY(20px);
    background: #1a1a1a;
    color: #fff;
    padding: 14px 22px;
    border-radius: 10px;
    font-size: 15px;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 12px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.18);
    z-index: 9999;
    opacity: 0;
    transition: opacity 0.25s, transform 0.25s;
    white-space: nowrap;
    pointer-events: none;
}
.cert-toast--visible {
    opacity: 1;
    transform: translateX(-50%) translateY(0);
}
.cert-toast__icon {
    width: 20px;
    height: 20px;
    flex-shrink: 0;
}
.cert-toast--success { background: #1a6b3c; }
</style>

<div class="cert-toast" id="certToast">
    <svg class="cert-toast__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="10"/>
        <path d="M12 8v4l2 2"/>
    </svg>
    <span id="certToastText">Формируем сертификат, подождите…</span>
</div>

<script>
document.querySelector('.js-cert-download').addEventListener('click', function () {
    const toast   = document.getElementById('certToast');
    const text    = document.getElementById('certToastText');

    text.textContent = 'Сертификат скачивается…';
    toast.classList.remove('cert-toast--success');
    toast.classList.add('cert-toast--visible');

    setTimeout(function () {
        toast.classList.add('cert-toast--success');
        toast.querySelector('.cert-toast__icon').innerHTML =
            '<polyline points="20 6 9 17 4 12"/>';
        text.textContent = 'Сертификат скачан на ваш компьютер';
    }, 3000);

    setTimeout(function () {
        toast.classList.remove('cert-toast--visible');
    }, 9000);
});
</script>
@endpush

@endsection
