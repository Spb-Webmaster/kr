@props([
    'method' => 'post',
    'action' => '',
    'put' => false,
    'class' => '',
])

<form action="{{ $action }}" method="{{ $method }}" class="{{ $class }}">
    @csrf
    @if($put)
       @method('PUT')
    @endif
    @honeypot
    {{ $slot }}
</form>
