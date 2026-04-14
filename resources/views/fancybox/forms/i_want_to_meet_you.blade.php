<div class="modal-form-container mini  app_form_modal">

    <div class="modal_padding relative app_modal ">
        <div class="form_title">
            <div class="form_title__h1">Заполнение данных</div>
            <div class="form_title__h2">Хочу заполнить данные при встрече с представителем</div>
        </div>
        <div class="form_data app_form_data">
        </div>
        <div class="input-button ">
            <x-form action="{{ route('vendor_handel_i_want_to_meet') }}">

                <x-form.form-input
                    name="username"
                    type="text"
                    label="Имя"
                    value="{{ (old('username')) ?: (($username) ?: '')  }}"
                    required="{{ true }}"
                    autofocus="{{ true }}"
                />
                <x-form.form-input
                    name="phone"
                    type="tel"
                    label="Телефон"
                    value="{{ (old('phone'))?:'' }}"
                    class="imask"
                />
                <x-form.form-input
                    name="email"
                    type="email"
                    label="Email"
                    value="{{ (old('email')) ?: (($email) ?: '')  }}"
                    required="true"
                />
                <input type="hidden" name="type" id="" value="{{ ($type)??'' }}"/>
                <div class="input-button">
                    <x-form.form-button class="w_100_important" type="submit">Отправить заявку
                    </x-form.form-button>
                </div>

            </x-form>
        </div>
    </div>
</div>


