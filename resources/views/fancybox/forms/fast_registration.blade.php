<div class="modal-form-container mini  app_form_modal">

    <x-form.form-loader />
    <x-form.form-response />

    <div class="modal_padding relative app_modal">
        <div class="form_title">
            <div class="form_title__h1">Регистрация</div>
            <div class="form_title__h2">Заполните форму и вы будете получать уведомления о заказе</div>
        </div>
        <div class="form_data app_form_data">
            <div class="window_white__padding">

                <input type="hidden" name="redirect_to" class="app_input_name" value="{{ $redirectTo }}">

                <x-form.form-input
                    name="username"
                    type="text"
                    label="Имя"
                    required="{{ true }}"
                    autofocus="{{ true }}"
                />
                <x-form.form-input
                    name="email"
                    type="text"
                    label="Email"
                    required="{{ true }}"
                />
                <x-form.form-input
                    name="password"
                    type="password"
                    label="Пароль"
                    required="{{ true }}"
                />
                <x-form.form-input
                    name="password_confirmation"
                    type="password"
                    label="Повторите пароль"
                    required="{{ true }}"
                />

                <div class="input-button">
                    <div class="flex box_prod__flex">
                        <div class="left__login">
                            <div class="fast-login-ajax btn btn-big w_100_important">Войти</div>
                        </div>
                        <div class="right__req">
                            <x-form.form-button class="w_100_important btn_green" url="fast-registration-ajax">Зарегистрироваться
                            </x-form.form-button>
                        </div>
                    </div>

                </div>

                <div class="auth_links">
                    <div class="no_register"><div class="no-registration-ajax" url="no-registration-ajax">Продолжить без регистрации</div></div>
                </div>

            </div>
        </div>
    </div>
</div>



