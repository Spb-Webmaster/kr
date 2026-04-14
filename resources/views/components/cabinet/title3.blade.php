@props([
    'title',
    'subtitle',
])
<div class="window_white__title">
        <div class="w_flex">
            <div class="w_left">
                <h1 class="h1">{{$title}}</h1>
                <p class="_subtitle">{{$subtitle}}</p>
            </div>
            <div class="w_right">
                {!! $slot !!}
            </div>
        </div>

</div>
