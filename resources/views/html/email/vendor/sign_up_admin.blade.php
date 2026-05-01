@extends('html.email.layouts.layout_email')

@section('title', 'Регистрация нового поставщика')
@section('preheader', 'Зарегистрировался новый поставщик услуг. Требуется проверка.')
@section('recipient_email', config('app.mail_admin'))
@section('send_reason', 'уведомления о регистрации нового поставщика')

@php
    $typeName = match($vendor['type']) {
        \App\Enum\TypeEnum::LEGALENTITY->value            => 'Юридическое лицо',
        \App\Enum\TypeEnum::INDIVIDUALENTREPRENEUR->value => 'Индивидуальный предприниматель',
        default                                           => 'Самозанятый',
    };
@endphp

@section('content')

    {{-- Hero --}}
    <tr>
        <td class="hero-pad" style="padding:40px 40px 32px 40px;background-color:#fff7f7;" align="left">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="font-family:Arial, Helvetica, sans-serif;font-size:12px;line-height:16px;color:#e30613;font-weight:bold;letter-spacing:1.5px;text-transform:uppercase;padding-bottom:12px;">
                        Новый поставщик
                    </td>
                </tr>
            </table>
            <div class="h1" style="font-family:Arial, Helvetica, sans-serif;font-size:34px;line-height:40px;color:#1a1a1a;font-weight:bold;margin:0 0 10px 0;">
                {{ $typeName }}
            </div>
            <div style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;color:#6b6b73;">
                Зарегистрировался новый поставщик услуг. Аккаунт ожидает проверки администратором.
            </div>
        </td>
    </tr>

    {{-- Vendor info --}}
    <tr>
        <td class="px-40" style="padding:28px 40px 8px 40px;" align="left">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#fafafb;border:1px solid #ececee;border-radius:6px;">
                <tr>
                    <td class="cred-pad" style="padding:20px 24px;" align="left">
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">

                            {{-- Самозанятый: ФИО --}}
                            @if($vendor['type'] === \App\Enum\TypeEnum::SELFEMPLOYED->value)
                                <tr>
                                    <td width="150" valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:22px;color:#8a8a92;padding:4px 0;">Фамилия</td>
                                    <td valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;color:#1a1a1a;font-weight:bold;padding:4px 0;">{{ $vendor['surname'] ?? '—' }}</td>
                                </tr>
                                <tr><td colspan="2" style="font-size:0;line-height:0;padding:4px 0;"><table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td style="border-top:1px dashed #e4e4e8;font-size:0;line-height:0;">&nbsp;</td></tr></table></td></tr>
                                <tr>
                                    <td width="150" valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:22px;color:#8a8a92;padding:4px 0;">Имя</td>
                                    <td valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;color:#1a1a1a;font-weight:bold;padding:4px 0;">{{ $vendor['username'] ?? '—' }}</td>
                                </tr>
                                @if(!empty($vendor['patronymic']))
                                <tr><td colspan="2" style="font-size:0;line-height:0;padding:4px 0;"><table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td style="border-top:1px dashed #e4e4e8;font-size:0;line-height:0;">&nbsp;</td></tr></table></td></tr>
                                <tr>
                                    <td width="150" valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:22px;color:#8a8a92;padding:4px 0;">Отчество</td>
                                    <td valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;color:#1a1a1a;font-weight:bold;padding:4px 0;">{{ $vendor['patronymic'] }}</td>
                                </tr>
                                @endif

                            {{-- ИП: наименование --}}
                            @elseif($vendor['type'] === \App\Enum\TypeEnum::INDIVIDUALENTREPRENEUR->value)
                                <tr>
                                    <td width="150" valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:22px;color:#8a8a92;padding:4px 0;">Наименование</td>
                                    <td valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;color:#1a1a1a;font-weight:bold;padding:4px 0;">{{ $vendor['full_name'] ?? '—' }}</td>
                                </tr>

                            {{-- Юр. лицо: название компании --}}
                            @else
                                <tr>
                                    <td width="150" valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:22px;color:#8a8a92;padding:4px 0;">Название компании</td>
                                    <td valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;color:#1a1a1a;font-weight:bold;padding:4px 0;">{{ $vendor['name'] ?? '—' }}</td>
                                </tr>
                            @endif

                            {{-- Телефон --}}
                            @if(!empty($vendor['phone']))
                            <tr><td colspan="2" style="font-size:0;line-height:0;padding:4px 0;"><table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td style="border-top:1px dashed #e4e4e8;font-size:0;line-height:0;">&nbsp;</td></tr></table></td></tr>
                            <tr>
                                <td width="150" valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:22px;color:#8a8a92;padding:4px 0;">Телефон</td>
                                <td valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;color:#1a1a1a;padding:4px 0;">{{ $vendor['phone'] }}</td>
                            </tr>
                            @endif

                            {{-- Email --}}
                            <tr><td colspan="2" style="font-size:0;line-height:0;padding:4px 0;"><table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td style="border-top:1px dashed #e4e4e8;font-size:0;line-height:0;">&nbsp;</td></tr></table></td></tr>
                            <tr>
                                <td width="150" valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:22px;color:#8a8a92;padding:4px 0;">Email</td>
                                <td valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;color:#1a1a1a;padding:4px 0;">{{ $vendor['email'] }}</td>
                            </tr>

                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    {{-- Note --}}
    <tr>
        <td class="px-40" style="padding:16px 40px 32px 40px;" align="left">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#fdecee;border-radius:14px;">
                <tr>
                    <td style="padding:18px 20px;font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:1.55;color:#5b1a20;" align="left">
                        <strong style="color:#E20607;display:block;margin-bottom:4px;">Требуется проверка</strong>
                        Поставщик ожидает проверки и не сможет войти в личный кабинет до публикации аккаунта администратором.
                    </td>
                </tr>
            </table>
        </td>
    </tr>

@endsection
