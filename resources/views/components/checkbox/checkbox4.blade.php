@props([
    'rand' => rand(100, 98765)
])
<div class="checkbox-wrapper-4">
    <input type="checkbox" id="cbx-{{ $rand }}" class="cbx-4" {{ $attributes }}/>
    <label for="cbx-{{ $rand }}" class="toggle"><span></span></label>
</div>
