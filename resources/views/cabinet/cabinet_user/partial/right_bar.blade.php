<div class="block_published">

    @if($user->published)
        <div class="__on">{!!   config('site.constants.published_on') !!}</div>
    @else
        <div class="__off">{!!   config('site.constants.published_off') !!}</div>
    @endif
</div>
<div class="block_exit">
    <x-form action="{{ route('logout') }}">
        <x-form.form-button
            type="submit">
            Выход
        </x-form.form-button>
    </x-form>
</div>
