<div class="block_published">

    @if($vendor->published)
        <div class="__on">{!!   config('site.constants.vendor_published_on') !!}</div>
    @else
        <div class="__off">{!!   config('site.constants.vendor_published_off') !!}</div>
    @endif
</div>
<div class="block_exit">
    <x-form action="{{ route('vendor_logout') }}">
        <x-form.form-button
            type="submit">
            Выход
        </x-form.form-button>
    </x-form>
</div>
