@extends('html.email.layouts.layout_default_mail')
@section('title', 'Создан аккаунт')
@section('description', 'Данные для входа')

@section('content')
    <p style="word-wrap: break-word;"><b>{{__('Логин')}}</b> - <span style="color: #282828">{{ $user['email']  }}</span><br>
        <b>{{__('Пароль')}}</b> - <span style="color: #282828">{{ $user['password']  }}</span></p>

    <p><a href="{{ config('app.app_url') . '/login' }}" class="btn btn-primary" style="background: #E20607;border-radius: 5px;color: #ffffff;display: inline-block;padding: 8px 15px 8px 15px;text-decoration: none;">{{ __('Войти на сайт') }}</a></p>
    <p style="word-wrap: break-word;">{{__('Адрес для входа в аккаунт')}} -
        <span style=" color: #29abe2"> {{ config('app.app_url') . '/login' }} </span></p>
    <hr style=" margin-top: 1rem; margin-bottom: 1.4rem;  border: 0; border-top: 1px solid rgba(0, 0, 0, 0.1);">
@endsection


