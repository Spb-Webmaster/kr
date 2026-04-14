<div class="cabinet_cabinet_user_update-password">

<x-form.form
    method="POST"
    :put="true"
    :action="route('cabinet_user_update_password')"
>
     <x-cabinet.title
     title="Изменить пароль"
     subtitle="Пароль минимум из пяти символов"
     />
    <div class="cu_row_50">
        <div class="cu__col">
            <x-form.form-input
                type="password"
                name="password"
                label="Пароль"
                required="true"
                :required="true"

            />
        </div>
        <div class="cu__col">
            <x-form.form-input
                name="password_confirmation"
                type="password"
                label="Повторите пароль"
                required="{{ true }}"

            />
        </div>
    </div>
    <div class="pad_t16">
        <button type="submit" class="btn btn-big"><span>Изменить пароль</span></button>
    </div>


</x-form.form>

</div>
