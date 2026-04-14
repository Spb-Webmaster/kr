@extends('html.email.layouts.layout_default_mail')
@section('title', 'Запрос на восстановление пароля')
@section('description')
    Вы получили это письмо, потому что мы получили запрос на сброс пароля для Вашей учётной записи. <br>
@endsection
@section('content')

    <p style="word-wrap: break-word; color: #282828">Скопируйте и вставьте приведенный ниже URL-адрес в свой браузер:</p>
    <p><a href="{{config('app.url')}}/reset-password/{{ $user['token'] }}/?email={{ $user['email'] }}">{{config('app.url')}}/reset-password/{{ $user['token'] }}/?email={{ $user['email'] }}</a></p>
    <hr style=" margin-top: 1rem; margin-bottom: 1.4rem;  border: 0; border-top: 1px solid rgba(0, 0, 0, 0.1);">
@endsection


