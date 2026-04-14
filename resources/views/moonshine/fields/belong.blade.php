@if($array)
    <x-moonshine::card
        :title="$array['type']"
        :values="$array['model']"
    >
    </x-moonshine::card>
@else
<x-moonshine::card
    title="Пока связей не выявлено"
>
</x-moonshine::card>
@endif
