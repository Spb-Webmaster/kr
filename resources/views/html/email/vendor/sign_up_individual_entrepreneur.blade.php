@extends('html.email.layouts.layout_email')

@section('title', 'Регистрация поставщика услуг')
@section('preheader', 'Ваш аккаунт поставщика создан. Данные для входа внутри письма.')
@section('recipient_email', $vendor['email'])
@section('send_reason', 'регистрации аккаунта поставщика')

@section('content')

    {{-- Hero --}}
    <tr>
        <td class="hero-pad" style="padding:40px 40px 32px 40px;background-color:#fff7f7;" align="left">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="font-family:Arial, Helvetica, sans-serif;font-size:12px;line-height:16px;color:#e30613;font-weight:bold;letter-spacing:1.5px;text-transform:uppercase;padding-bottom:12px;">
                        Добро пожаловать
                    </td>
                </tr>
            </table>
            <div class="h1" style="font-family:Arial, Helvetica, sans-serif;font-size:34px;line-height:40px;color:#1a1a1a;font-weight:bold;margin:0 0 10px 0;">
                Аккаунт поставщика создан
            </div>
            <div style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;color:#6b6b73;">
                Ваша заявка на регистрацию в качестве индивидуального предпринимателя принята. Ниже данные вашего аккаунта.
            </div>
        </td>
    </tr>

    {{-- Credentials --}}
    <tr>
        <td class="px-40" style="padding:28px 40px 8px 40px;" align="left">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#fafafb;border:1px solid #ececee;border-radius:6px;">
                <tr>
                    <td class="cred-pad" style="padding:20px 24px;" align="left">
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">

                            <tr>
                                <td width="150" valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:22px;color:#8a8a92;padding:4px 0;">Наименование</td>
                                <td valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;color:#1a1a1a;font-weight:bold;padding:4px 0;">{{ $vendor['name'] ?? '—' }}</td>
                            </tr>
                            <tr><td colspan="2" style="font-size:0;line-height:0;padding:4px 0;"><table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td style="border-top:1px dashed #e4e4e8;font-size:0;line-height:0;">&nbsp;</td></tr></table></td></tr>

                            <tr>
                                <td width="150" valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:22px;color:#8a8a92;padding:4px 0;">Полное наименование</td>
                                <td valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;color:#1a1a1a;font-weight:bold;padding:4px 0;">{{ $vendor['full_name'] ?? '—' }}</td>
                            </tr>
                            <tr><td colspan="2" style="font-size:0;line-height:0;padding:4px 0;"><table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td style="border-top:1px dashed #e4e4e8;font-size:0;line-height:0;">&nbsp;</td></tr></table></td></tr>

                            @if(!empty($vendor['phone']))
                            <tr>
                                <td width="150" valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:22px;color:#8a8a92;padding:4px 0;">Телефон</td>
                                <td valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;color:#1a1a1a;font-weight:bold;padding:4px 0;">{{ $vendor['phone'] }}</td>
                            </tr>
                            <tr><td colspan="2" style="font-size:0;line-height:0;padding:4px 0;"><table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td style="border-top:1px dashed #e4e4e8;font-size:0;line-height:0;">&nbsp;</td></tr></table></td></tr>
                            @endif

                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    {{-- Login credentials --}}
    <tr>
        <td class="px-40" style="padding:16px 40px 8px 40px;" align="left">
            <div style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:16px;color:#8a8a92;text-transform:uppercase;letter-spacing:1px;padding-bottom:10px;">Данные для входа</div>
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#fafafb;border:1px solid #ececee;border-radius:6px;">
                <tr>
                    <td class="cred-pad" style="padding:20px 24px;" align="left">
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td width="150" valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:22px;color:#8a8a92;padding:4px 0;">Логин</td>
                                <td valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;color:#1a1a1a;font-weight:bold;padding:4px 0;">{{ $vendor['email'] }}</td>
                            </tr>
                            <tr><td colspan="2" style="font-size:0;line-height:0;padding:4px 0;"><table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td style="border-top:1px dashed #e4e4e8;font-size:0;line-height:0;">&nbsp;</td></tr></table></td></tr>
                            <tr>
                                <td width="150" valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:22px;color:#8a8a92;padding:4px 0;">Пароль</td>
                                <td valign="top" style="font-family:'Courier New', Courier, monospace;font-size:16px;line-height:22px;color:#1a1a1a;font-weight:bold;padding:4px 0;letter-spacing:1px;">{{ $vendor['password'] }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    {{-- Admin verification note --}}
    <tr>
        <td class="px-40" style="padding:16px 40px 8px 40px;" align="left">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#fffaf0;border-left:3px solid #f0b429;border-radius:4px;">
                <tr>
                    <td style="padding:14px 18px;font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:20px;color:#5a4a1f;" align="left">
                        Войти в личный кабинет можно будет только после проверки данных администратором. Мы уведомим вас по email.
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    {{-- Button --}}
    <tr>
        <td class="px-40" style="padding:24px 40px 12px 40px;" align="left">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="center" style="border-radius:4px;background-color:#e30613;">
                        <!--[if mso]>
                        <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="{{ route('vendor_login') }}" style="height:48px;v-text-anchor:middle;width:240px;" arcsize="9%" strokecolor="#e30613" fillcolor="#e30613">
                            <w:anchorlock/>
                            <center style="color:#ffffff;font-family:Arial, Helvetica, sans-serif;font-size:15px;font-weight:bold;">Войти в личный кабинет</center>
                        </v:roundrect>
                        <![endif]-->
                        <!--[if !mso]><!-- -->
                        <a href="{{ route('vendor_login') }}" class="btn-a" target="_blank" style="background-color:#e30613;border:1px solid #e30613;border-radius:4px;color:#ffffff;display:inline-block;font-family:Arial, Helvetica, sans-serif;font-size:15px;font-weight:bold;line-height:48px;text-align:center;text-decoration:none;width:240px;-webkit-text-size-adjust:none;mso-hide:all;">Войти в личный кабинет &rarr;</a>
                        <!--<![endif]-->
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    {{-- Login URL --}}
    <tr>
        <td class="px-40" style="padding:4px 40px 32px 40px;font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:20px;color:#8a8a92;" align="left">
            Или перейдите по адресу<br />
            <a href="{{ route('vendor_login') }}" target="_blank" style="color:#e30613;text-decoration:none;font-weight:bold;word-break:break-all;">{{ route('vendor_login') }}</a>
        </td>
    </tr>

@endsection
