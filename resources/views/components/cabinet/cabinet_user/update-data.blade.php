@props([
    'user'
])
<div class="cabinet_cabinet_user_update-data">
<x-form.form
    method="POST"
    :put="true"
    :action="route('cabinet_user_update_handel')"
>
    <x-cabinet.title
        title="Личные данные"
        subtitle="Измените свои личные данные"
    />
    <div class="cu_row_50">
        <div class="cu__col">
            <x-form.form-input
                name="username"
                type="text"
                label="Имя"
                value="{!!  (old('username'))?: ($user->username?:'') !!}"
                autofocus="{{ true }}"
                required="{{ true }}"

            />
        </div>
        <div class="cu__col">
            <x-form.form-input
                name="email"
                type="email"
                label="Email"
                required="{{ true }}"
                value="{{ (old('email'))?: ($user->email?:'') }}"

            />
        </div>
    </div>


    <div class="pad_t16">
        <input type="hidden" name="id" value="{{ $user->id }}">
        <button type="submit" class="btn btn-big"><span>Изменить</span></button>
    </div>

</x-form.form>
</div>
