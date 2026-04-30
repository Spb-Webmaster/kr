@props([
    'img' => '<img alt="enter" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjIiIGhlaWdodD0iMjUiIHZpZXdCb3g9IjAgMCAyMiAyNSIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTEwLjg3NSAxMC44NzVDMTMuODc4IDEwLjg3NSAxNi4zMTI1IDguNDQwNTQgMTYuMzEyNSA1LjQzNzVDMTYuMzEyNSAyLjQzNDQ2IDEzLjg3OCAwIDEwLjg3NSAwQzcuODcxOTYgMCA1LjQzNzUgMi40MzQ0NiA1LjQzNzUgNS40Mzc1QzUuNDM3NSA4LjQ0MDU0IDcuODcxOTYgMTAuODc1IDEwLjg3NSAxMC44NzVaIiBmaWxsPSIjRTIwNjA3Ii8+CjxwYXRoIGQ9Ik0yMS43NSAyMS42Mzk4QzIxLjc1IDE4LjUxNjYgMTguMzYwNiAxMy4xOTUgMTAuNjkzNyAxMy4xOTVDNC4xMzI1IDEzLjE5NSAwIDE4LjUxNjYgMCAyMS42Mzk4VjI0LjUwNUg3LjM0MDYySDE0LjczNTZIMjEuNzVWMjEuNjM5OFoiIGZpbGw9IiNFMjA2MDciLz4KPC9zdmc+Cg==" />'
])
<div class="cabinet_enter_enter">
    @auth
        <a href="{{ route('cabinet_user') }}">{!! $img !!} </a>
    @endauth

    @guest
        <a href="{{ route('login') }}">
            <svg class="cabinet_enter_enter__guest-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="8" r="4"/>
                <path d="M4 21c0-4 4-7 8-7s8 3 8 7"/>
            </svg>
        </a>
    @endguest
</div>
