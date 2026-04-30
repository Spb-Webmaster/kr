@extends('html.email.layouts.layout_email')

@section('title', 'Восстановление пароля')
@section('preheader', 'Вы получили запрос на сброс пароля. Ссылка для восстановления внутри письма.')
@section('recipient_email', $user['email'])
@section('send_reason', 'запроса на восстановление пароля')

@section('content')

    {{-- Hero --}}
    <tr>
        <td class="hero-pad" style="padding:40px 40px 32px 40px;background-color:#fff7f7;" align="left">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="font-family:Arial, Helvetica, sans-serif;font-size:12px;line-height:16px;color:#e30613;font-weight:bold;letter-spacing:1.5px;text-transform:uppercase;padding-bottom:12px;">
                        Безопасность аккаунта
                    </td>
                </tr>
            </table>
            <div class="h1" style="font-family:Arial, Helvetica, sans-serif;font-size:34px;line-height:40px;color:#1a1a1a;font-weight:bold;margin:0 0 10px 0;">
                Сброс пароля
            </div>
            <div style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;color:#6b6b73;">
                Вы получили это письмо, потому что мы получили запрос на сброс пароля для вашей учётной записи.
            </div>
        </td>
    </tr>

    {{-- Button --}}
    <tr>
        <td class="px-40" style="padding:28px 40px 12px 40px;" align="left">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="center" style="border-radius:4px;background-color:#e30613;">
                        <!--[if mso]>
                        <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="{{ config('app.url') }}/reset-password/{{ $user['token'] }}/?email={{ $user['email'] }}" style="height:48px;v-text-anchor:middle;width:240px;" arcsize="9%" strokecolor="#e30613" fillcolor="#e30613">
                            <w:anchorlock/>
                            <center style="color:#ffffff;font-family:Arial, Helvetica, sans-serif;font-size:15px;font-weight:bold;">Сбросить пароль</center>
                        </v:roundrect>
                        <![endif]-->
                        <!--[if !mso]><!-- -->
                        <a href="{{ config('app.url') }}/reset-password/{{ $user['token'] }}/?email={{ $user['email'] }}" class="btn-a" target="_blank" style="background-color:#e30613;border:1px solid #e30613;border-radius:4px;color:#ffffff;display:inline-block;font-family:Arial, Helvetica, sans-serif;font-size:15px;font-weight:bold;line-height:48px;text-align:center;text-decoration:none;width:240px;-webkit-text-size-adjust:none;mso-hide:all;">Сбросить пароль &rarr;</a>
                        <!--<![endif]-->
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    {{-- Reset URL --}}
    <tr>
        <td class="px-40" style="padding:4px 40px 24px 40px;font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:20px;color:#8a8a92;" align="left">
            Или скопируйте ссылку в браузер:<br />
            <a href="{{ config('app.url') }}/reset-password/{{ $user['token'] }}/?email={{ $user['email'] }}" target="_blank" style="color:#e30613;text-decoration:none;font-weight:bold;word-break:break-all;">{{ config('app.url') }}/reset-password/{{ $user['token'] }}/?email={{ $user['email'] }}</a>
        </td>
    </tr>

    {{-- Warning note --}}
    <tr>
        <td class="px-40" style="padding:0 40px 32px 40px;" align="left">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#fffaf0;border-left:3px solid #f0b429;border-radius:4px;">
                <tr>
                    <td style="padding:14px 18px;font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:20px;color:#5a4a1f;" align="left">
                        Если вы не запрашивали сброс пароля, просто проигнорируйте это письмо.
                    </td>
                </tr>
            </table>
        </td>
    </tr>

@endsection
