@props(['prev','next', 'route'])
<div class="cu_row_50 sign_up_buttons">
    <input type="hidden" name="questionnaire" value="distance" />
    <div class="cu__col left"><a href="{{ $route }}">← {{ $prev }}</a></div>
    <div class="cu__col right">
        <x-form.form-button class="w_100_important" type="submit">{{ $next }}</x-form.form-button>
    </div>
</div>
