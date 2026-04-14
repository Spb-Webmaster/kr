<div class="modal-form-container mini app_form_modal">

    <x-form.form-loader />
    <x-form.form-response />

    <div class="modal_padding relative app_modal">
        <div class="form_title">
            <div class="form_title__h1">Продолжить без регистрации</div>
            <div class="form_title__h2">Укажите ваши данные для оформления заказа</div>
        </div>
        <div class="form_data app_form_data">
            <div class="window_white__padding">

                <input type="hidden" name="redirect_to" class="app_input_name" value="{{ $redirectTo }}">

                <x-form.form-input
                    name="username"
                    type="text"
                    label="Имя"
                    :required="true"
                    autofocus="{{ true }}"
                />
                <x-form.form-input
                    name="email"
                    type="text"
                    label="Email"
                    :required="true"
                />
                <x-form.form-input
                    name="phone"
                    type="tel"
                    label="Телефон"
                    class="imask"
                    :required="true"
                />

                <div class="input-button">
                    <x-form.form-button class="w_100_important" url="no-registration-ajax">Оформить заказ
                    </x-form.form-button>
                </div>

            </div>
        </div>
    </div>
</div>
