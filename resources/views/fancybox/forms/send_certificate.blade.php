<div class="modal-form-container mini app_form_modal">

    <x-form.form-loader />

    <x-form.form-response-custom
        title="Сертификат"
        text="Ссылка на сертификат успешно отправлена"
    />

    <div class="modal_padding relative app_modal">
        <div class="form_title">
            <div class="form_title__h1">Отправить сертификат</div>
            <div class="form_title__h2">Введите e-mail, на который нужно отправить сертификат</div>
        </div>
        <div class="form_data app_form_data">
            <div class="window_white__padding">

                <input type="hidden" name="order_number" class="app_input_name" value="{{ $number }}">

                <x-form.form-input
                    name="email"
                    type="email"
                    label="E-mail"
                    :required="true"
                    :autofocus="true"
                />

                <div class="input-button">
                    <x-form.form-button url="order/{{ $number }}/send-certificate">
                        Отправить
                    </x-form.form-button>
                </div>

            </div>
        </div>
    </div>

</div>
