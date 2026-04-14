<footer>
    <div class="block">
        <div class="footer_flex">
            <div class="f1">
                <div class="f_logo">
                    <x-logo.logo />
                </div>
                <div class="f_social">
                    <x-social.social />
                </div>

            </div>
            <div class="f2">
                <div class="title">Контакты:</div>
                <div class="phone"><i></i> {{ format_phone(trim(config2('moonshine.setting.phone'))) }}</div>
                <div class="email"><i></i> {{ config2('moonshine.setting.email') }}</div>
            </div>
            <div class="f3">
                <div class="title">Адрес:</div>
                <div class="address">{!!  config2('moonshine.setting.address_footer_top') !!}</div>
                <div class="address2">{!!  config2('moonshine.setting.address_footer_bottom') !!}</div>
            </div>
        </div>
    </div>
</footer>
