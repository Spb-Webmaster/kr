<div class="menu__wrap">
<div class="menu_top_menu">

    <div class="top_menu__mobile">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
        </svg>
    </div>

    {{-- Оверлей и мобильная панель меню --}}
    <div class="mobile_menu_overlay"></div>
    <div class="mobile_menu_panel">
        <button class="mobile_menu_panel__close" type="button" aria-label="Закрыть меню">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <div class="mobile_menu_panel__logo">
            <x-logo.logo />
        </div>
        <div class="mobile_menu_panel__content">
            <ul class="mobile_menu_list">
                @include('components.site.menu.partials.menu-items')
            </ul>
            <div class="mobile_menu_panel__enter">
                <x-cabinet.enter.enter />
                <span class="mobile_menu_panel__enter__label">
                    @auth Личный кабинет @endauth
                    @guest Войти @endguest
                </span>
            </div>
        </div>
    </div>

        <nav>
            <ul class="top_menu app_top_menu">
                @include('components.site.menu.partials.menu-items')
            </ul>
        </nav>

    </div>
</div>
