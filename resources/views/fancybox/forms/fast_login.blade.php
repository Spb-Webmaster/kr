<div class="modal-form-container mini app_form_modal">

    <x-form.form-loader />
    <x-form.form-response />

    <div class="modal_padding relative app_modal">
        <div class="form_title">
            <div class="form_title__h1">Вход</div>
            <div class="form_title__h2">Введите e-mail и пароль для входа в аккаунт</div>
        </div>
        <div class="form_data app_form_data">
            <div class="window_white__padding">

                <x-form.form-input
                    name="email"
                    type="text"
                    label="Email"
                    :required="true"
                    autofocus="{{ true }}"
                />
                <x-form.form-input
                    name="password"
                    type="password"
                    label="Пароль"
                    :required="true"
                />

                <div class="input-button">
                    <x-form.form-button class="w_100_important" url="fast-login-ajax">Войти
                    </x-form.form-button>
                </div>

            </div>
        </div>
    </div>
</div>
