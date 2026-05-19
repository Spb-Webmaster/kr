<div class="logo logo_logo">
    @if(route_name() != 'home')
        <a href="{{ route('home') }}">
            @endif
                <img  src="{{ Storage::url('/images/logo.png') }}"  alt="{{ config('app.name') }}" loading="lazy" width="193" height="57"/>
            @if(route_name() != 'home')
        </a>
    @endif
</div>
