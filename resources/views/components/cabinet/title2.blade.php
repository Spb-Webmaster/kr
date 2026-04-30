@props([
    'title',
    'subtitle',
    'slot',
    'class'
])
<div class="window_white__title {{ $class ??= "" }}">
    <h1 class="h1">{{$title}}</h1>
    <p class="_subtitle">{{$subtitle}}</p>
</div>
