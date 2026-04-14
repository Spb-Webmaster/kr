@props([
    'title' => '',
    'username' => '',
    'surname' => '',
    'patronymic' => '',
])
<div class="block_content__title"><h1 class="h1">{{ $title }}</h1>
    <p class="_subtitle">{{ $surname }} {{ $username }} {{ $patronymic }}</p>
</div>
