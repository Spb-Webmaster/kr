@extends('html.email.layouts.layout_default_mail')
@section('title', 'Запрос на регистрацию')
@section('description', 'Хочу заполнить данные при встрече с представителем ')

@section('content')
    <p style="word-wrap: break-word;"><b>{{__('Имя')}}</b> - <span style="color: #282828">{{ $user['username']  }}</span><br>
        <b>{{__('Email')}}</b> - <span style="color: #282828">{{ $user['email']  }}</span><br>
        <b>{{__('Телефон')}}</b> - <span style="color: #282828">{{ $user['phone']  }}</span><br>
        <b>{{__('Тип')}}</b> - <span style="color: #282828">{{ $user['type']  }}</span>
    </p>

    <hr style=" margin-top: 1rem; margin-bottom: 1.4rem;  border: 0; border-top: 1px solid rgba(0, 0, 0, 0.1);">
@endsection



