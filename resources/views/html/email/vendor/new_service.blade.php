@extends('html.email.layouts.layout_email')

@section('title', 'Новая услуга поставщика')
@section('preheader', 'Поставщик добавил новую услугу. Требуется проверка.')
@section('recipient_email', config('app.mail_admin'))
@section('send_reason', 'уведомления о новой услуге поставщика')

@section('content')

    {{-- Hero --}}
    <tr>
        <td class="hero-pad" style="padding:40px 40px 32px 40px;background-color:#fff7f7;" align="left">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="font-family:Arial, Helvetica, sans-serif;font-size:12px;line-height:16px;color:#e30613;font-weight:bold;letter-spacing:1.5px;text-transform:uppercase;padding-bottom:12px;">
                        Новая услуга
                    </td>
                </tr>
            </table>
            <div class="h1" style="font-family:Arial, Helvetica, sans-serif;font-size:34px;line-height:40px;color:#1a1a1a;font-weight:bold;margin:0 0 10px 0;">
                Требуется проверка
            </div>
            <div style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;color:#6b6b73;">
                Поставщик услуг добавил новую услугу. Пожалуйста, проверьте и опубликуйте её в административной панели.
            </div>
        </td>
    </tr>

    {{-- Service info --}}
    <tr>
        <td class="px-40" style="padding:28px 40px 8px 40px;" align="left">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#fafafb;border:1px solid #ececee;border-radius:6px;">
                <tr>
                    <td class="cred-pad" style="padding:20px 24px;" align="left">
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">

                            {{-- Название --}}
                            <tr>
                                <td width="150" valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:22px;color:#8a8a92;padding:4px 0;">Название</td>
                                <td valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;color:#1a1a1a;font-weight:bold;padding:4px 0;">{{ $data['title'] }}</td>
                            </tr>

                            {{-- Подзаголовок --}}
                            @if(!empty($data['subtitle']))
                            <tr><td colspan="2" style="font-size:0;line-height:0;padding:4px 0;"><table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td style="border-top:1px dashed #e4e4e8;font-size:0;line-height:0;">&nbsp;</td></tr></table></td></tr>
                            <tr>
                                <td width="150" valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:22px;color:#8a8a92;padding:4px 0;">Подзаголовок</td>
                                <td valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;color:#1a1a1a;padding:4px 0;">{{ $data['subtitle'] }}</td>
                            </tr>
                            @endif

                            {{-- Стоимость --}}
                            @if(!empty($data['price']))
                            <tr><td colspan="2" style="font-size:0;line-height:0;padding:4px 0;"><table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td style="border-top:1px dashed #e4e4e8;font-size:0;line-height:0;">&nbsp;</td></tr></table></td></tr>
                            <tr>
                                <td width="150" valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:22px;color:#8a8a92;padding:4px 0;">Стоимость</td>
                                <td valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;color:#1a1a1a;font-weight:bold;padding:4px 0;">{{ $data['price'] }} {{ config('currency.currency.RUB') }}</td>
                            </tr>
                            @endif

                            {{-- Варианты цен --}}
                            @if(!empty($data['prices_list']) && count($data['prices_list']) > 0)
                            <tr><td colspan="2" style="font-size:0;line-height:0;padding:4px 0;"><table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td style="border-top:1px dashed #e4e4e8;font-size:0;line-height:0;">&nbsp;</td></tr></table></td></tr>
                            <tr>
                                <td width="150" valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:22px;color:#8a8a92;padding:4px 0;">Варианты цен</td>
                                <td valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;color:#1a1a1a;padding:4px 0;">
                                    @foreach($data['prices_list'] as $item)
                                        {{ $item['option'] }}: {{ $item['price'] }} {{ config('currency.currency.RUB') }}<br>
                                    @endforeach
                                </td>
                            </tr>
                            @endif

                            {{-- Город --}}
                            @if(!empty($data['city']))
                            <tr><td colspan="2" style="font-size:0;line-height:0;padding:4px 0;"><table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td style="border-top:1px dashed #e4e4e8;font-size:0;line-height:0;">&nbsp;</td></tr></table></td></tr>
                            <tr>
                                <td width="150" valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:22px;color:#8a8a92;padding:4px 0;">Город</td>
                                <td valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;color:#1a1a1a;padding:4px 0;">{{ $data['city'] }}</td>
                            </tr>
                            @endif

                            {{-- Количество человек --}}
                            @if(!empty($data['person_count']))
                            <tr><td colspan="2" style="font-size:0;line-height:0;padding:4px 0;"><table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td style="border-top:1px dashed #e4e4e8;font-size:0;line-height:0;">&nbsp;</td></tr></table></td></tr>
                            <tr>
                                <td width="150" valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:22px;color:#8a8a92;padding:4px 0;">Количество человек</td>
                                <td valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;color:#1a1a1a;padding:4px 0;">{{ $data['person_count'] }}</td>
                            </tr>
                            @endif

                            {{-- Возрастное ограничение --}}
                            @if(!empty($data['age_restriction']))
                            <tr><td colspan="2" style="font-size:0;line-height:0;padding:4px 0;"><table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td style="border-top:1px dashed #e4e4e8;font-size:0;line-height:0;">&nbsp;</td></tr></table></td></tr>
                            <tr>
                                <td width="150" valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:22px;color:#8a8a92;padding:4px 0;">Возрастное ограничение</td>
                                <td valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;color:#1a1a1a;padding:4px 0;">{{ $data['age_restriction'] }}</td>
                            </tr>
                            @endif

                            {{-- Изображение --}}
                            <tr><td colspan="2" style="font-size:0;line-height:0;padding:4px 0;"><table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td style="border-top:1px dashed #e4e4e8;font-size:0;line-height:0;">&nbsp;</td></tr></table></td></tr>
                            <tr>
                                <td width="150" valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:22px;color:#8a8a92;padding:4px 0;">Изображение</td>
                                <td valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;color:#1a1a1a;padding:4px 0;">
                                    @if($data['has_img'])
                                        Загружено изображение
                                    @else
                                        —
                                    @endif
                                </td>
                            </tr>

                            {{-- Галерея --}}
                            @if($data['gallery_count'] > 0)
                            <tr><td colspan="2" style="font-size:0;line-height:0;padding:4px 0;"><table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td style="border-top:1px dashed #e4e4e8;font-size:0;line-height:0;">&nbsp;</td></tr></table></td></tr>
                            <tr>
                                <td width="150" valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:22px;color:#8a8a92;padding:4px 0;">Галерея</td>
                                <td valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;color:#1a1a1a;padding:4px 0;">
                                    В галерее загружено {{ $data['gallery_count'] }} {{ trans_choice('изображение|изображения|изображений', $data['gallery_count']) }}
                                </td>
                            </tr>
                            @endif

                            {{-- Видео --}}
                            @if($data['has_video'])
                            <tr><td colspan="2" style="font-size:0;line-height:0;padding:4px 0;"><table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td style="border-top:1px dashed #e4e4e8;font-size:0;line-height:0;">&nbsp;</td></tr></table></td></tr>
                            <tr>
                                <td width="150" valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:22px;color:#8a8a92;padding:4px 0;">Видео</td>
                                <td valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;color:#1a1a1a;padding:4px 0;">Видео загружено</td>
                            </tr>
                            @endif

                            {{-- Категории --}}
                            @if(!empty($data['categories']))
                            <tr><td colspan="2" style="font-size:0;line-height:0;padding:4px 0;"><table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td style="border-top:1px dashed #e4e4e8;font-size:0;line-height:0;">&nbsp;</td></tr></table></td></tr>
                            <tr>
                                <td width="150" valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:22px;color:#8a8a92;padding:4px 0;">Категории</td>
                                <td valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;color:#1a1a1a;padding:4px 0;">{{ implode(', ', $data['categories']) }}</td>
                            </tr>
                            @endif

                            {{-- Теги --}}
                            @if(!empty($data['tags']))
                            <tr><td colspan="2" style="font-size:0;line-height:0;padding:4px 0;"><table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td style="border-top:1px dashed #e4e4e8;font-size:0;line-height:0;">&nbsp;</td></tr></table></td></tr>
                            <tr>
                                <td width="150" valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:22px;color:#8a8a92;padding:4px 0;">Теги</td>
                                <td valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;color:#1a1a1a;padding:4px 0;">{{ implode(', ', $data['tags']) }}</td>
                            </tr>
                            @endif

                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    {{-- Vendor info --}}
    <tr>
        <td class="px-40" style="padding:16px 40px 8px 40px;" align="left">
            <div style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:16px;color:#8a8a92;text-transform:uppercase;letter-spacing:1px;padding-bottom:10px;">Поставщик</div>
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#fafafb;border:1px solid #ececee;border-radius:6px;">
                <tr>
                    <td class="cred-pad" style="padding:20px 24px;" align="left">
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td width="150" valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:22px;color:#8a8a92;padding:4px 0;">Наименование</td>
                                <td valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;color:#1a1a1a;font-weight:bold;padding:4px 0;">{{ $data['vendor_name'] }}</td>
                            </tr>
                            @if(!empty($data['vendor_phone']))
                            <tr><td colspan="2" style="font-size:0;line-height:0;padding:4px 0;"><table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td style="border-top:1px dashed #e4e4e8;font-size:0;line-height:0;">&nbsp;</td></tr></table></td></tr>
                            <tr>
                                <td width="150" valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:22px;color:#8a8a92;padding:4px 0;">Телефон</td>
                                <td valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;color:#1a1a1a;padding:4px 0;">{{ $data['vendor_phone'] }}</td>
                            </tr>
                            @endif
                            <tr><td colspan="2" style="font-size:0;line-height:0;padding:4px 0;"><table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td style="border-top:1px dashed #e4e4e8;font-size:0;line-height:0;">&nbsp;</td></tr></table></td></tr>
                            <tr>
                                <td width="150" valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:22px;color:#8a8a92;padding:4px 0;">Email</td>
                                <td valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;color:#1a1a1a;padding:4px 0;">{{ $data['vendor_email'] }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    {{-- Note --}}
    <tr>
        <td class="px-40" style="padding:16px 40px 8px 40px;" align="left">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#fffaf0;border-left:3px solid #f0b429;border-radius:4px;">
                <tr>
                    <td style="padding:14px 18px;font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:20px;color:#5a4a1f;" align="left">
                        Услуга ожидает модерации и не будет видна пользователям до её публикации администратором.
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    {{-- Not all data note --}}
    <tr>
        <td class="px-40" style="padding:8px 40px 32px 40px;" align="left">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#fdecee;border-radius:14px;">
                <tr>
                    <td style="padding:18px 20px;font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:1.55;color:#5b1a20;" align="left">
                        <strong style="color:#E20607;display:block;margin-bottom:4px;">Внимание</strong>
                        В письме перечислены не все данные об услуге. Для просмотра полной информации перейдите в административную панель.
                    </td>
                </tr>
            </table>
        </td>
    </tr>

@endsection
