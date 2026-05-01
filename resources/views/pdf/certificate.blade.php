<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Сертификат № {{ $order->number }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: #fff;
            color: #1a1a1a;
            font-size: 15px;
        }

        .cert {
            width: 210mm;
            min-height: 297mm;
            padding: 0;
        }

        /* ── Шапка ── */
        .cert-ribbon {
            background: none;
            color: #fff;
            padding: 18px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            border-bottom: 5px solid #E20607;
        }

        .cert-ribbon__left {}

        .cert-ribbon__label {
            font-size: 11px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            opacity: 0.85;
            font-weight: 500;
            margin-bottom: 4px;
            color: #282828 ;
        }

        .cert-ribbon__number {
            font-size: 24px;
            font-weight: 700;
            font-variant-numeric: tabular-nums;
            color: #000000;
        }

        .cert-ribbon__logo {
            max-height: 71px;
            max-width: 300px;
            object-fit: contain;
            display: block;
            mix-blend-mode: screen;
        }

        .cert-ribbon__brand {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.9;
            text-align: right;
        }

        /* ── Тело ── */
        .cert-body {
            padding: 50px 60px 10px;
        }

        .cert-eyebrow {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #6b6b6b;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .cert-title {
            font-size: 26px;
            font-weight: 700;
            color: #1a1a1a;
            margin: 0 0 10px;
            line-height: 1.25;
        }

        .cert-subtitle {
            font-size: 15px;
            color: #6b6b6b;
            margin: 0 0 18px;
            line-height: 1.5;
        }

        .cert-option-chip {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: #fdecee;
            color: #E20607;
            padding: 7px 14px 7px 7px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 26px;
        }

        .cert-option-chip svg {
            width: 14px;
            height: 14px;
            flex-shrink: 0;
        }

        /* ── Строки ── */
        .cert-rows {
            border-top: 1px dashed #ececec;
        }

        .cert-row {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            padding: 14px 0;
            border-bottom: 1px dashed #ececec;
            font-size: 15px;
            gap: 16px;
        }

        .cert-row:last-child {
            border-bottom: none;
        }

        .cert-row__key {
            color: #6b6b6b;
            flex-shrink: 0;
        }

        .cert-row__val {
            font-weight: 500;
            text-align: right;
        }

        /* ── Итого ── */
        .cert-total {
            padding: 22px 60px;
            background: #fafafa;
            border-top: 1px solid #ececec;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .cert-total__label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #6b6b6b;
            font-weight: 500;
        }

        .cert-total__amount {
            font-size: 32px;
            font-weight: 700;
            color: #E20607;
            font-variant-numeric: tabular-nums;
        }

        /* ── Баннер ── */
        .cert-banner {
            margin: 40px 60px 0;
            border-radius: 12px;
            overflow: hidden;
            height: 142px;

            position: relative;
            display: flex;
            align-items: center;
            padding: 0 30px;
        }

        .cert-banner__content {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .cert-banner__text {
            font-size: 16px;
            line-height: 1.3;
            color: #fff;
        }

        .cert-banner__value {
            font-size: 26px;
            font-weight: 700;
            line-height: 1.3;
            color: #fff;
            padding-top: 10px;
        }

        .cert-banner__img {
            height: 130px;
            width: auto;
            display: block;
            flex-shrink: 0;
        }

        /* ── Контактная информация ── */
        .cert-info {
            margin: 28px 60px 40px;
            padding: 20px 24px;
            background: #fafafa;
            border: 1px solid #ececec;
            border-radius: 12px;
        }

        .cert-info__text {
            font-size: 13px;
            color: #282828;
            line-height: 1.6;
            margin-bottom: 26px;
        }

        .cert-info__contacts {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .cert-info__row {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            font-weight: 500;
            color: #1a1a1a;
        }

        .cert-info__icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: #fdecee;
            color: #E20607;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .cert-info__icon svg {
            width: 15px;
            height: 15px;
        }
        .cert-desc {
            padding: 0 60px 12px 60px;
            width: 100%;
            position: relative;

        }
        .cert-desc p, .cert-desc div {
            width: 100%;
            position: relative;
            padding: 10px 0;
            line-height: 1.6rem;
            font-size: 16px;

        }


        .cert-desc h2 {
            line-height: 1.25em;
            padding: 16px 0 8px 0;
            font-weight: 600;
            font-style: normal;
            font-size: 23px;
        }

        .cert-desc h3 {
            line-height:  1.25em;
            padding: 12px 0 8px 0;
            font-weight: 600;
            font-style: normal;
            font-size: 23px;
        }

        .cert-desc h4 {
            line-height:  1.25em;
            padding:12px 0 8px 0;
            font-weight: 600;
            font-style: normal;
            font-size: 22px;
        }

        .cert-desc   iframe, .cert-desc embed {
            box-sizing: border-box;
            border-radius: 24px;
            margin: 16px 0;
        }

        .cert-desc ul,.cert-desc ol {
            padding: 15px 0;
        }

        .cert-desc ul li:before {
            content: '';
            display: inline-block;
            border-radius: 10px;
            width: 8px;
            height: 8px;
            position: absolute;
            left: -4px;
            top: 12px;
        }

        .cert-desc ul li {
            padding: 5px 5px 5px 25px;
            font-size: 16px;
            position: relative;
            line-height: 1.4rem;
        }

        .cert-desc ol {
            padding-left: 15px
        }

        .cert-desc ol li {
            padding: 5px 5px 5px 5px;
            font-size: 16px;
            position: relative;
            line-height: 1.4rem;
            list-style-type: decimal;
        }

    </style>
</head>
<body>
<div class="cert">

    <div class="cert-ribbon">
        <div class="cert-ribbon__left">
            <div class="cert-ribbon__label">Номер заказа</div>
            <div class="cert-ribbon__number">№ {{ $order->number }}</div>
        </div>
        @if($logoDataUrl)
            <img src="{{ $logoDataUrl }}" alt="{{ config('app.name') }}" class="cert-ribbon__logo" style="-webkit-print-color-adjust: exact;">
        @else
            <div class="cert-ribbon__brand">{{ config('app.name') }}</div>
        @endif
    </div>

    <div class="cert-body">
        <div class="cert-eyebrow">Подарочный сертификат</div>
        <h1 class="cert-title">{{ $order->title }}</h1>
        @if($order->product?->subtitle)
            <p class="cert-subtitle">{!! html_entity_decode(strip_tags($order->product->subtitle), ENT_QUOTES | ENT_HTML5, 'UTF-8') !!}</p>
        @endif

        @if($order->price_option)
            <div class="cert-option-chip">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="9"/>
                    <path d="M12 7v5l3 2"/>
                </svg>
                Вариант: {{ $order->price_option }}
            </div>
        @endif

        <div class="cert-rows">
            <div class="cert-row">
                <span class="cert-row__key">Услуга</span>
                <span class="cert-row__val">{{ $order->title }}</span>
            </div>
            @if($order->price_option)
                <div class="cert-row">
                    <span class="cert-row__key">Вариант</span>
                    <span class="cert-row__val">{{ $order->price_option }}</span>
                </div>
            @endif
            <div class="cert-row">
                <span class="cert-row__key">Количество</span>
                <span class="cert-row__val">1 сертификат</span>
            </div>
            <div class="cert-row">
                <span class="cert-row__key">Формат доставки</span>
                <span class="cert-row__val">Электронный (PDF на e-mail)</span>
            </div>
        </div>
    </div>

    <div class="cert-total">
        <span class="cert-total__label">Стоимость</span>
        <span class="cert-total__amount">{{ price($order->price) }} {{ config('currency.currency.RUB') }}</span>
    </div>

    <div class="cert-banner" style="background:#af0421 !important; -webkit-print-color-adjust:exact;">
        <div class="cert-banner__content">
            <span class="cert-banner__text" style="color:#fff !important;">Подарочные сертификаты действительны</span>
            <span class="cert-banner__value" style="color:#fff !important;">3 года</span>
        </div>
        @if($giftBoxDataUrl)
            <img src="{{ $giftBoxDataUrl }}" class="cert-banner__img" alt="">
        @endif
    </div>

    <div class="cert-info">
        <p class="cert-info__text">
            Чтобы произвести резервацию необходимо связаться с поставщиком услуги. В случае если услугу организовывает и обеспечивает {{ config('app.url_short') }}, то тогда Вам необходимо связаться с администрацией
            {{ config('app.url_short') }} в рабочее время.

        @if(!$order->vendor)
                Услугу организовывает и обеспечивает {{ config('app.url') }},
                Вам необходимо связаться с администрацией в рабочее время.
            @endif
        </p>
        <div class="cert-info__contacts">
            @if($order->vendor?->phone)
                <div class="cert-info__row">
                    <span class="cert-info__icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.8 19.8 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.8 19.8 0 0 1 1.63 3.39 2 2 0 0 1 3.61 1.22h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.86a16 16 0 0 0 6.06 6.06l.95-.95a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21.73 16.92z"/>
                        </svg>
                    </span>
                    <span>{{ format_phone($order->vendor->phone) }}</span>
                </div>
            @endif
            @if($order->product?->address)
                <div class="cert-info__row">
                    <span class="cert-info__icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>
                    </span>
                    <span>{{ $order->product->address }}</span>
                </div>
            @endif


        </div>
    </div>


</div>
</body>
</html>
