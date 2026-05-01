@extends('html.email.layouts.layout_email')

@section('title', 'Новый заказ')
@section('preheader', 'Новый заказ на сертификат — ' . $data['title'])
@section('recipient_email', config('app.mail_admin'))
@section('send_reason', 'уведомлений о новых заказах')

@section('content')

    {{-- Hero --}}
    <tr>
        <td class="hero-pad" style="padding:40px 40px 32px 40px;background-color:#f0f7ff;" align="left">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="font-family:Arial, Helvetica, sans-serif;font-size:12px;line-height:16px;color:#0062cc;font-weight:bold;letter-spacing:1.5px;text-transform:uppercase;padding-bottom:12px;">
                        Новый заказ
                    </td>
                </tr>
            </table>
            <div class="h1" style="font-family:Arial, Helvetica, sans-serif;font-size:34px;line-height:40px;color:#1a1a1a;font-weight:bold;margin:0 0 10px 0;">
                Создан заказ на сертификат
            </div>
            <div style="font-family:Arial, Helvetica, sans-serif;font-size:28px;line-height:34px;color:#e30613;font-weight:bold;letter-spacing:1px;text-transform:uppercase;margin:0 0 8px 0;">
                № {{ $data['order_number'] }}
            </div>
            <div style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;color:#6b6b73;">
                Покупатель оформил заказ. Ниже представлены данные об услуге и покупателе.
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
                                <td valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;color:#1a1a1a;font-weight:bold;padding:4px 0;">
                                    @if (!empty($data['price_option']) && !empty($data['price']))
                                        {{ $data['price_option'] }}: {{ $data['price'] }} {{ config('currency.currency.RUB') }}
                                    @elseif (!empty($data['price']))
                                        {{ $data['price'] }} {{ config('currency.currency.RUB') }}
                                    @else
                                        —
                                    @endif
                                </td>
                            </tr>

                            {{-- Ссылка на страницу услуги --}}
                            <tr><td colspan="2" style="font-size:0;line-height:0;padding:4px 0;"><table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td style="border-top:1px dashed #e4e4e8;font-size:0;line-height:0;">&nbsp;</td></tr></table></td></tr>
                            <tr>
                                <td width="150" valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:22px;color:#8a8a92;padding:4px 0;">Страница услуги</td>
                                <td valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;padding:4px 0;">
                                    <a href="{{ $data['product_url'] }}" style="color:#0062cc;text-decoration:underline;">Открыть страницу услуги</a>
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

    {{-- Покупатель --}}
    <tr>
        <td class="px-40" style="padding:16px 40px 8px 40px;" align="left">
            <div style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:16px;color:#8a8a92;text-transform:uppercase;letter-spacing:1px;padding-bottom:10px;">Покупатель</div>
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#fafafb;border:1px solid #ececee;border-radius:6px;">
                <tr>
                    <td style="padding:20px 24px;" align="left">
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">

                            {{-- Статус --}}
                            <tr>
                                <td width="150" valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:22px;color:#8a8a92;padding:4px 0;">Статус</td>
                                <td valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;color:#1a1a1a;font-weight:bold;padding:4px 0;">
                                    {{ $data['is_registered'] ? 'Зарегистрированный пользователь' : 'Гость (без регистрации)' }}
                                </td>
                            </tr>

                            {{-- Имя --}}
                            <tr><td colspan="2" style="font-size:0;line-height:0;padding:4px 0;"><table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td style="border-top:1px dashed #e4e4e8;font-size:0;line-height:0;">&nbsp;</td></tr></table></td></tr>
                            <tr>
                                <td width="150" valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:22px;color:#8a8a92;padding:4px 0;">Имя</td>
                                <td valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;color:#1a1a1a;padding:4px 0;">{{ $data['username'] ?? '—' }}</td>
                            </tr>

                            {{-- Email --}}
                            <tr><td colspan="2" style="font-size:0;line-height:0;padding:4px 0;"><table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td style="border-top:1px dashed #e4e4e8;font-size:0;line-height:0;">&nbsp;</td></tr></table></td></tr>
                            <tr>
                                <td width="150" valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:22px;color:#8a8a92;padding:4px 0;">E-mail</td>
                                <td valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;color:#1a1a1a;padding:4px 0;">{{ $data['email'] ?? '—' }}</td>
                            </tr>

                            {{-- Телефон --}}
                            @if (!empty($data['phone']))
                                <tr><td colspan="2" style="font-size:0;line-height:0;padding:4px 0;"><table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td style="border-top:1px dashed #e4e4e8;font-size:0;line-height:0;">&nbsp;</td></tr></table></td></tr>
                                <tr>
                                    <td width="150" valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:22px;color:#8a8a92;padding:4px 0;">Телефон</td>
                                    <td valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;color:#1a1a1a;padding:4px 0;">{{ $data['phone'] }}</td>
                                </tr>
                            @endif

                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    {{-- Продавец --}}
    <tr>
        <td class="px-40" style="padding:16px 40px 8px 40px;" align="left">
            <div style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:16px;color:#8a8a92;text-transform:uppercase;letter-spacing:1px;padding-bottom:10px;">Продавец</div>
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#fafafb;border:1px solid #ececee;border-radius:6px;">
                <tr>
                    <td style="padding:20px 24px;" align="left">
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">

                            <tr>
                                <td width="150" valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:22px;color:#8a8a92;padding:4px 0;">Наименование</td>
                                <td valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;color:#1a1a1a;font-weight:bold;padding:4px 0;">{{ $data['vendor_name'] ?? '—' }}</td>
                            </tr>

                            @if (!empty($data['vendor_phone']))
                                <tr><td colspan="2" style="font-size:0;line-height:0;padding:4px 0;"><table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td style="border-top:1px dashed #e4e4e8;font-size:0;line-height:0;">&nbsp;</td></tr></table></td></tr>
                                <tr>
                                    <td width="150" valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:22px;color:#8a8a92;padding:4px 0;">Телефон</td>
                                    <td valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;color:#1a1a1a;padding:4px 0;">{{ $data['vendor_phone'] }}</td>
                                </tr>
                            @endif

                            @if (!empty($data['vendor_email']))
                                <tr><td colspan="2" style="font-size:0;line-height:0;padding:4px 0;"><table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td style="border-top:1px dashed #e4e4e8;font-size:0;line-height:0;">&nbsp;</td></tr></table></td></tr>
                                <tr>
                                    <td width="150" valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:22px;color:#8a8a92;padding:4px 0;">E-mail</td>
                                    <td valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;color:#1a1a1a;padding:4px 0;">{{ $data['vendor_email'] }}</td>
                                </tr>
                            @endif

                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    {{-- Кнопка — PDF сертификат --}}
    <tr>
        <td class="px-40" style="padding:28px 40px 8px 40px;" align="left">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="center" style="border-radius:6px;background-color:#e30613;">
                        <a href="{{ $data['certificate_url'] }}" target="_blank"
                           style="display:inline-block;padding:14px 32px;font-family:Arial, Helvetica, sans-serif;font-size:15px;font-weight:bold;color:#ffffff;text-decoration:none;border-radius:6px;">
                            Скачать PDF сертификат
                        </a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    {{-- Примечание --}}
    <tr>
        <td class="px-40" style="padding:16px 40px 32px 40px;" align="left">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#f7f7fa;border:1px solid #ececee;border-radius:4px;">
                <tr>
                    <td style="padding:14px 18px;font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:20px;color:#6b6b73;" align="left">
                        В письме перечислены не все данные о заказе. Для просмотра полной информации перейдите в административную панель.
                    </td>
                </tr>
            </table>
        </td>
    </tr>

@endsection
