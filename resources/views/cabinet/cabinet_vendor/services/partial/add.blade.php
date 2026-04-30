@extends('layouts.partial.layout-page', ['class' => ''])
<x-seo.meta
    title="Добавить услугу"
    description="Добавить услугу"
    keywords="Добавить услугу"
/>
@section('content-home')
    <main class="cabinet_vendor_services">
        <section>
            <div class="block_content cabinet_user">

                <x-cabinet.cabinet_vendor.title
                    title="Профиль продавца услуг"
                    :username="$vendor->username"
                    :surname="$vendor->surname"
                    :patronymic="$vendor->patronymic"
                />

                <x-cabinet.menu.cabinet_vendor.menu-horizontal/>

                <x-form action="{{ route('cabinet_vendor_service_store') }}">

                    <div class="block_content__flex">
                        <div class="block_content__left">

                            {{-- Верхний блок: поля формы --}}
                            <div class="cabinet_radius12_fff">

                                <x-cabinet.title2
                                    class="top_0 pad_b28_important"
                                    title="Добавить услугу"
                                    subtitle="Заполните все поля и отправьте форму на проверку"
                                />

                                {{-- Название и подзаголовок --}}
                                <x-form.form-input
                                    name="title"
                                    type="text"
                                    label="Название услуги"
                                    value="{{ old('title') ?: '' }}"
                                    required="true"
                                />

                                <x-form.form-input
                                    name="subtitle"
                                    type="text"
                                    label="Подзаголовок"
                                    value="{{ old('subtitle') ?: '' }}"
                                />

                                {{-- Описание --}}
                                <div class="trix-field-wrap">
                                    <p class="trix-field-label">Описание услуги</p>
                                    <x-form.form-textarea
                                        name="desc"
                                        label="Описание услуги"
                                        editor="true"
                                        value="{!! old('desc') ?: '' !!}"
                                    />
                                </div>

                                <x-cabinet.cabinet_vendor.price-options :priceOptions="$priceOptions"/>

                                {{-- Город --}}
                                <x-form.form-select
                                    name="Город"
                                    :options="$cities"
                                    :selected="old('city_id')"
                                    field_name="city_id"
                                    required="true"
                                />

                                {{-- Количество человек и возрастное ограничение --}}
                                <div class="cu_row_50">
                                    <div class="cu__col">
                                        <x-form.form-select
                                            name="Количество человек"
                                            :options="$personCounts"
                                            :selected="old('person_count_id')"
                                            field_name="person_count_id"
                                        />
                                    </div>
                                    <div class="cu__col">
                                        <x-form.form-select
                                            name="Возрастное ограничение"
                                            :options="$ageRestrictions"
                                            :selected="old('age_restriction_id')"
                                            field_name="age_restriction_id"
                                        />
                                    </div>
                                </div>

                                <x-form.form-textarea
                                    name="weather"
                                    label="Погодные условия"
                                    value="{{ old('weather') ?: '' }}"
                                    error="weather"
                                />

                                <div class="trix-field-wrap">
                                    <p class="trix-field-label">Специальная одежда</p>
                                    <x-form.form-textarea
                                        name="special_clothing"
                                        label="Специальная одежда"
                                        editor="true"
                                        value="{!! old('special_clothing') ?: '' !!}"
                                    />
                                    @error('special_clothing')<div class="input_error app_input_error">{{ $message }}</div>@enderror
                                </div>

                                <div class="trix-field-wrap">
                                    <p class="trix-field-label">Дополнительная информация</p>
                                    <x-form.form-textarea
                                        name="other_info"
                                        label="Дополнительная информация"
                                        editor="true"
                                        value="{!! old('other_info') ?: '' !!}"
                                    />
                                </div>

                                <x-cabinet.cabinet_vendor.image-upload
                                    imgName="img"
                                    galleryName="gallery"
                                    :uploadImgRoute="route('cabinet_vendor_upload_image')"
                                    :uploadGalleryRoute="route('cabinet_vendor_upload_gallery_image')"
                                />

                                <x-cabinet.cabinet_vendor.video-upload
                                    name="video"
                                    label="Видео"
                                    :uploadRoute="route('cabinet_vendor_upload_video_chunk')"
                                />

                            </div>
                            <br>
                            <br>
                            {{-- Нижний блок: категории и теги --}}
                            <div id="js-categories-block" class="cabinet_radius12_fff"
                                 @error('categories') style="background:#fdecee" @enderror>
                                <x-cabinet.title2
                                    class="top_0 pad_b16_important"
                                    title="Добавить категории"
                                    subtitle="Заполните все необходимые категории"
                                />
                                {{-- Категории --}}
                                @if($categories->isNotEmpty())
                                    <x-form.form-checkboxes
                                        name="categories[]"
                                        :checkboxes="$categories->map(fn($c) => [
                                            'id'       => $c->id,
                                            'title'    => $c->title,
                                            'subtitle' => $c->subtitle ?? '',
                                            'checked'  => in_array($c->id, (array) old('categories', [])),
                                        ])->all()"
                                    />
                                @endif
                            </div>
                            <br>
                            <br>
                            <div class="cabinet_radius12_fff">
                                <x-cabinet.title2
                                    class="top_0 pad_b16_important"
                                    title="Добавить теги"
                                    subtitle="Заполните все необходимые теги"
                                />
                                {{-- Теги --}}
                                @if($tags->isNotEmpty())
                                    <x-form.form-checkboxes
                                        name="tags[]"
                                        :checkboxes="$tags->map(fn($t) => [
                                            'id'       => $t->id,
                                            'title'    => $t->title,
                                            'subtitle' => $t->subtitle ?? '',
                                            'checked'  => in_array($t->id, (array) old('tags', [])),
                                        ])->all()"
                                        class="pad_t10"
                                    />
                                @endif

                                <div class="input-button pad_t26_important">
                                    <x-form.form-submit type="submit" class="btn-big">
                                        Отправить на проверку
                                    </x-form.form-submit>
                                </div>

                            </div>

                        </div>

                        <div class="block_content__right">
                            @include('cabinet.cabinet_vendor.partial.right_bar')
                        </div>

                    </div>

                </x-form>
            </div>
        </section>
    </main>
    <section class="block relative">
        <x-site.catalog.category.category/>
    </section>

    @push('scripts')
        <script>
            (function () {
                const block = document.getElementById('js-categories-block');
                if (!block) return;
                block.querySelectorAll('input[type="checkbox"]').forEach(function (checkbox) {
                    checkbox.addEventListener('change', function () {
                        const anyChecked = block.querySelectorAll('input[type="checkbox"]:checked').length > 0;
                        block.style.background = anyChecked ? '' : '#fdecee';
                    });
                });
            })();
        </script>
    @endpush

@endsection
