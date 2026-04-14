<div class="cabinet-user_cabinet-user-top-menu">
    <ul class="cabinet-user-top-menu">
        <li class="{{ active_linkMenu(asset(route('cabinet_vendor')))  }}">
            <a href="{{ route('cabinet_vendor') }}">Личные данные</a>
        </li>
        <li class="{{ active_linkMenu(asset(route('cabinet_vendor_services')))  }}">
            <a href="{{ route('cabinet_vendor_services') }}">Услуги</a>
        </li>
        <li class="{{ active_linkMenu(asset(route('cabinet_vendor_service_add')))  }}">
            <a href="{{ route('cabinet_vendor_service_add') }}">Добавить</a>
        </li>

    </ul>
</div>

