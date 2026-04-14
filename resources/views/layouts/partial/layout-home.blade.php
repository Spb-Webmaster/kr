@extends('layouts.layout')
@section('content')
    @include('templates.axeld.header.header-home') {{--все изменения для шаблона templates.axeld.header.header-home -  это для главно страницы--}}
    @yield('content-home')
@endsection
