@extends('layouts.layout')
@section('content')
    @include('templates.axeld.header.header-page', ($class)?['class' => $class]:['class' => '']) {{--все изменения для шаблона templates.axeld.header.header-hage -  это для обычной страницы без слайдера--}}
    @yield('content-home')
@endsection
