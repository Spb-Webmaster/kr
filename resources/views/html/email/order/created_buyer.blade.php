@extends('html.email.layouts.layout_email')

@section('title', 'Ваш заказ оформлен')
@section('preheader', 'Спасибо за покупку! Ваш сертификат — № ' . $data['order_number'])
@section('send_reason', 'подтверждения оформления заказа')

@section('content')

    {{-- Hero --}}
    <tr>
        <td class="hero-pad" style="padding:40px 40px 32px 40px;background-color:#f0fff4;" align="left">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="font-family:Arial, Helvetica, sans-serif;font-size:12px;line-height:16px;color:#1a6b3c;font-weight:bold;letter-spacing:1.5px;text-transform:uppercase;padding-bottom:12px;">
                        Заказ оформлен
                    </td>
                </tr>
            </table>
            <div class="h1" style="font-family:Arial, Helvetica, sans-serif;font-size:34px;line-height:40px;color:#1a1a1a;font-weight:bold;margin:0 0 10px 0;">
                Спасибо за покупку!
            </div>
            <div style="font-family:Arial, Helvetica, sans-serif;font-size:28px;line-height:34px;color:#e30613;font-weight:bold;letter-spacing:1px;text-transform:uppercase;margin:0 0 8px 0;">
                № {{ $data['order_number'] }}
            </div>
            <div style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;color:#6b6b73;">
                Ваш сертификат успешно оформлен. Ниже — подробности заказа.
            </div>
        </td>
    </tr>

    {{-- Услуга --}}
    <tr>
        <td class="px-40" style="padding:28px 40px 8px 40px;" align="left">
            <div style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:16px;color:#8a8a92;text-transform:uppercase;letter-spacing:1px;padding-bottom:10px;">Услуга</div>
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#fafafb;border:1px solid #ececee;border-radius:6px;">
                <tr>
                    <td style="padding:20px 24px;" align="left">
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">

                            {{-- Название --}}
                            <tr>
                                <td width="150" valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:22px;color:#8a8a92;padding:4px 0;">Название</td>
                                <td valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;color:#1a1a1a;font-weight:bold;padding:4px 0;">{{ $data['title'] }}</td>
                            </tr>

                            {{-- Подзаголовок --}}
                            @if (!empty($data['subtitle']))
                                <tr><td colspan="2" style="font-size:0;line-height:0;padding:4px 0;"><table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td style="border-top:1px dashed #e4e4e8;font-size:0;line-height:0;">&nbsp;</td></tr></table></td></tr>
                                <tr>
                                    <td width="150" valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:22px;color:#8a8a92;padding:4px 0;">Подзаголовок</td>
                                    <td valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;color:#1a1a1a;padding:4px 0;">{{ $data['subtitle'] }}</td>
                                </tr>
                            @endif

                            {{-- Стоимость --}}
                            <tr><td colspan="2" style="font-size:0;line-height:0;padding:4px 0;"><table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td style="border-top:1px dashed #e4e4e8;font-size:0;line-height:0;">&nbsp;</td></tr></table></td></tr>
                            <tr>
                                <td width="150" valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:22px;color:#8a8a92;padding:4px 0;">Стоимость</td>
                                <td valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;color:#e30613;font-weight:bold;padding:4px 0;">
                                    @if (!empty($data['price_option']) && !empty($data['price']))
                                        {{ $data['price_option'] }}: {{ $data['price'] }} {{ config('currency.currency.RUB') }}
                                    @elseif (!empty($data['price']))
                                        {{ $data['price'] }} {{ config('currency.currency.RUB') }}
                                    @else
                                        —
                                    @endif
                                </td>
                            </tr>

                            {{-- Время заказа --}}
                            <tr><td colspan="2" style="font-size:0;line-height:0;padding:4px 0;"><table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td style="border-top:1px dashed #e4e4e8;font-size:0;line-height:0;">&nbsp;</td></tr></table></td></tr>
                            <tr>
                                <td width="150" valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:22px;color:#8a8a92;padding:4px 0;">Время заказа</td>
                                <td valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;color:#1a1a1a;padding:4px 0;">{{ $data['ordered_at'] }}</td>
                            </tr>

                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    {{-- Опции услуги --}}
    @if (!empty($data['city']) || !empty($data['person_count']) || !empty($data['age_restriction']))
    <tr>
        <td class="px-40" style="padding:16px 40px 8px 40px;" align="left">
            <div style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:16px;color:#8a8a92;text-transform:uppercase;letter-spacing:1px;padding-bottom:10px;">Параметры сертификата</div>
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#fafafb;border:1px solid #ececee;border-radius:6px;">
                <tr>
                    <td style="padding:20px 24px;" align="left">
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">

                            @php $first = true; @endphp

                            @if (!empty($data['city']))
                                @if (!$first)<tr><td colspan="2" style="font-size:0;line-height:0;padding:4px 0;"><table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td style="border-top:1px dashed #e4e4e8;font-size:0;line-height:0;">&nbsp;</td></tr></table></td></tr>@endif
                                @php $first = false; @endphp
                                <tr>
                                    <td width="150" valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:22px;color:#8a8a92;padding:4px 0;">Город</td>
                                    <td valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;color:#1a1a1a;padding:4px 0;">{{ $data['city'] }}</td>
                                </tr>
                            @endif

                            @if (!empty($data['person_count']))
                                @if (!$first)<tr><td colspan="2" style="font-size:0;line-height:0;padding:4px 0;"><table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td style="border-top:1px dashed #e4e4e8;font-size:0;line-height:0;">&nbsp;</td></tr></table></td></tr>@endif
                                @php $first = false; @endphp
                                <tr>
                                    <td width="150" valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:22px;color:#8a8a92;padding:4px 0;">Количество человек</td>
                                    <td valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;color:#1a1a1a;padding:4px 0;">{{ $data['person_count'] }}</td>
                                </tr>
                            @endif

                            @if (!empty($data['age_restriction']))
                                @if (!$first)<tr><td colspan="2" style="font-size:0;line-height:0;padding:4px 0;"><table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td style="border-top:1px dashed #e4e4e8;font-size:0;line-height:0;">&nbsp;</td></tr></table></td></tr>@endif
                                @php $first = false; @endphp
                                <tr>
                                    <td width="150" valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:22px;color:#8a8a92;padding:4px 0;">Возраст</td>
                                    <td valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;color:#1a1a1a;padding:4px 0;">{{ $data['age_restriction'] }}</td>
                                </tr>
                            @endif


                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    @endif

    {{-- Описание услуги (desc) --}}
    @if (!empty($data['desc']))
    <tr>
        <td class="px-40" style="padding:16px 40px 8px 40px;" align="left">
            <div style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:16px;color:#8a8a92;text-transform:uppercase;letter-spacing:1px;padding-bottom:10px;">Описание</div>
            <div style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:24px;color:#1a1a1a;">
                {!! $data['desc'] !!}
            </div>
        </td>
    </tr>
    @endif

    {{-- Дополнительное описание (desc2) --}}
    @if (!empty($data['desc2']))
    <tr>
        <td class="px-40" style="padding:16px 40px 8px 40px;" align="left">
            <div style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:24px;color:#1a1a1a;">
                {!! $data['desc2'] !!}
            </div>
        </td>
    </tr>
    @endif

    {{-- Погодные условия --}}
    @if (!empty($data['weather']))
    <tr>
        <td class="px-40" style="padding:16px 40px 8px 40px;" align="left">
            <div style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:16px;color:#8a8a92;text-transform:uppercase;letter-spacing:1px;padding-bottom:10px;">Погодные условия</div>
            <div style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:24px;color:#1a1a1a;">
                {!! $data['weather'] !!}
            </div>
        </td>
    </tr>
    @endif

    {{-- Специальная одежда --}}
    @if (!empty($data['special_clothing']))
    <tr>
        <td class="px-40" style="padding:16px 40px 8px 40px;" align="left">
            <div style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:16px;color:#8a8a92;text-transform:uppercase;letter-spacing:1px;padding-bottom:10px;">Специальная одежда</div>
            <div style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:24px;color:#1a1a1a;">
                {!! $data['special_clothing'] !!}
            </div>
        </td>
    </tr>
    @endif

    {{-- Продавец --}}
    @if (!empty($data['vendor_phone']) || !empty($data['product_address']))
    <tr>
        <td class="px-40" style="padding:16px 40px 8px 40px;" align="left">
            <div style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:16px;color:#8a8a92;text-transform:uppercase;letter-spacing:1px;padding-bottom:10px;">Продавец услуги</div>
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#fafafb;border:1px solid #ececee;border-radius:6px;">
                <tr>
                    <td style="padding:20px 24px;" align="left">
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">

                            @php $firstVendor = true; @endphp

                            @if (!empty($data['vendor_phone']))
                                <tr>
                                    <td width="150" valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:22px;color:#8a8a92;padding:4px 0;">Телефон</td>
                                    <td valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;color:#1a1a1a;padding:4px 0;">{{ $data['vendor_phone'] }}</td>
                                </tr>
                                @php $firstVendor = false; @endphp
                            @endif

                            @if (!empty($data['product_address']))
                                @if (!$firstVendor)<tr><td colspan="2" style="font-size:0;line-height:0;padding:4px 0;"><table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td style="border-top:1px dashed #e4e4e8;font-size:0;line-height:0;">&nbsp;</td></tr></table></td></tr>@endif
                                <tr>
                                    <td width="150" valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:22px;color:#8a8a92;padding:4px 0;">Адрес</td>
                                    <td valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;color:#1a1a1a;padding:4px 0;">{{ $data['product_address'] }}</td>
                                </tr>
                            @endif

                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    @endif

    {{-- Резервация --}}
    <tr>
        <td class="px-40" style="padding:16px 40px 8px 40px;" align="left">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#fff0f0;border:2px solid #e30613;border-radius:6px;">
                <tr>
                    <td style="padding:20px 24px;" align="left">
                        <div style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:16px;color:#e30613;font-weight:bold;text-transform:uppercase;letter-spacing:1px;padding-bottom:10px;">Важно</div>
                        <div style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:24px;color:#1a1a1a;">
                            Чтобы произвести резервацию, необходимо связаться с поставщиком услуги.<br><br>
                            В случае если услугу организовывает и обеспечивает <strong>o-podarok.ru</strong>, то Вам необходимо связаться с администрацией <strong>o-podarok.ru</strong> в рабочее время.
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    {{-- Кнопка — скачать сертификат --}}
    <tr>
        <td class="px-40" style="padding:28px 40px 40px 40px;" align="left">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="center" style="border-radius:6px;background-color:#e30613;">
                        <a href="{{ $data['certificate_url'] }}"
                           style="display:inline-block;padding:14px 32px;font-family:Arial, Helvetica, sans-serif;font-size:15px;font-weight:bold;color:#ffffff;text-decoration:none;border-radius:6px;">
                            Скачать PDF сертификат
                        </a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>


@endsection
