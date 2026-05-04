<div class="modal-form-container mini app_form_modal">

    <div class="modal_padding relative app_modal">
        <div class="form_title">
            <div class="form_title__h1">Контакты</div>
            <div class="form_title__h2">Для связи с администрацией ресурса</div>
        </div>
        <div class="form_data app_form_data">
            <div class="window_white__padding">

                <div class="order-confirmation pad_t0_important pad_b20_important">
                    <div class="order-side-card">


                        <div class="order-buyer-row">
                            <div class="order-buyer-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="8" r="4"></circle>
                                    <path d="M4 21c0-4 4-7 8-7s8 3 8 7"></path>
                                </svg>
                            </div>
                            <div class="order-buyer-text">
                                <span class="order-buyer-text__label">Администратор</span>
                                <span class="order-buyer-text__val">Сергей</span>
                            </div>
                        </div>

                        <div class="order-buyer-row">
                            <div class="order-buyer-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                                    <path d="M3 7l9 6 9-6"></path>
                                </svg>
                            </div>
                            <div class="order-buyer-text">
                                <span class="order-buyer-text__label">E-mail</span>
                                <span class="order-buyer-text__val">{{ config2('moonshine.setting.email') }}</span>
                            </div>
                        </div>

                        <div class="order-buyer-row">
                            <div class="order-buyer-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path
                                        d="M22 16.92v3a2 2 0 0 1-2.18 2 19.8 19.8 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.37 1.9.72 2.81a2 2 0 0 1-.45 2.11L8.1 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.35 1.85.59 2.81.72A2 2 0 0 1 22 16.92z"></path>
                                </svg>
                            </div>
                            <div class="order-buyer-text">
                                <span class="order-buyer-text__label">Телефон</span>
                                <span class="order-buyer-text__val">  <a
                                        href="tel:+{{ config2('moonshine.setting.phone') }}">
                        {{ format_phone(trim(config2('moonshine.setting.phone'))) }}
                    </a></span>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal_address">
                    <div class="title">Адрес:
                    </div>
                    <div class="address">{!! config2('moonshine.setting.address_footer_top') !!}</div>
                    <div class="address2">{!! config2('moonshine.setting.address_footer_bottom') !!}</div>

                </div>

            </div>
        </div>
    </div>
</div>
