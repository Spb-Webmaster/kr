@extends('layouts.partial.layout-page', ['class' => ''])
<x-seo.meta
    title="Редактировать услугу"
    description="Редактировать услугу"
    keywords="Редактировать услугу"
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

                <x-form action="{{ route('cabinet_vendor_service_update', $product->id) }}">

                    <div class="block_content__flex">
                        <div class="block_content__left">

                            <div class="cabinet_radius12_fff">

                                <x-cabinet.title2
                                    class="top_0 pad_b28_important"
                                    title="Редактировать услугу"
                                    subtitle="После сохранения услуга будет отправлена на повторную модерацию"
                                />

                                @if($product->order_papers_count > 0)
                                    <span class="vendor-service-card__papers-badge" style="margin-bottom: 12px;" title="Для этой услуги выписаны бумажные сертификаты">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                                        Бумажные сертификаты
                                    </span>
                                @endif
                                <div class="service-status {{ $product->published ? 'service-status--published' : 'service-status--pending' }}">
                                    @if($product->published)
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                            <polyline points="22 4 12 14.01 9 11.01"/>
                                        </svg>
                                        <div>
                                            <strong>Услуга опубликована</strong>
                                            <span>Видна всем пользователям на сайте</span>
                                        </div>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="10"/>
                                            <line x1="12" y1="8" x2="12" y2="12"/>
                                            <line x1="12" y1="16" x2="12.01" y2="16"/>
                                        </svg>
                                        <div>
                                            <strong>На модерации</strong>
                                            <span>Услуга проверяется и пока не видна на сайте</span>
                                        </div>
                                    @endif
                                </div>
                                <br>

                                <x-form.form-input
                                    name="title"
                                    type="text"
                                    label="Название услуги"
                                    value="{{ old('title') ?: $product->title }}"
                                    required="true"
                                />

                                <x-form.form-input
                                    name="subtitle"
                                    type="text"
                                    label="Подзаголовок"
                                    value="{{ old('subtitle') ?: $product->subtitle }}"
                                />

                                <div class="trix-field-wrap">
                                    <p class="trix-field-label">Описание услуги</p>
                                    <x-form.form-textarea
                                        name="desc"
                                        label="Описание услуги"
                                        editor="true"
                                        value="{!! old('desc') ?: $product->desc !!}"
                                    />
                                </div>

                                @php
                                    $existingPrices = $product->prices
                                        ? $product->prices->map(fn($p) => [
                                            'option_id' => is_array($p) ? $p['option_id'] : $p->option_id,
                                            'price'     => is_array($p) ? $p['price']     : $p->price,
                                          ])->all()
                                        : [];
                                @endphp

                                <x-cabinet.cabinet_vendor.price-options
                                    :priceOptions="$priceOptions"
                                    :prices="$existingPrices"
                                    :price="$product->price"
                                />

                                <x-form.form-select
                                    name="Город"
                                    :options="$cities"
                                    :selected="old('city_id') ?: $product->city_id"
                                    field_name="city_id"
                                    required="true"
                                />

                                <div class="cu_row_50">
                                    <div class="cu__col">
                                        <x-form.form-select
                                            name="Количество человек"
                                            :options="$personCounts"
                                            :selected="old('person_count_id') ?: $product->person_count_id"
                                            field_name="person_count_id"
                                        />
                                    </div>
                                    <div class="cu__col">
                                        <x-form.form-select
                                            name="Возрастное ограничение"
                                            :options="$ageRestrictions"
                                            :selected="old('age_restriction_id') ?: $product->age_restriction_id"
                                            field_name="age_restriction_id"
                                        />
                                    </div>
                                </div>

                                <x-form.form-textarea
                                    name="weather"
                                    label="Погодные условия"
                                    value="{{ old('weather') ?: strip_tags($product->weather) }}"
                                    error="weather"
                                />

                                <div class="trix-field-wrap">
                                    <p class="trix-field-label">Специальная одежда</p>
                                    <x-form.form-textarea
                                        name="special_clothing"
                                        label="Специальная одежда"
                                        editor="true"
                                        value="{!! old('special_clothing') ?: $product->special_clothing !!}"
                                    />
                                    @error('special_clothing')<div class="input_error app_input_error">{{ $message }}</div>@enderror
                                </div>

                                <div class="trix-field-wrap">
                                    <p class="trix-field-label">Дополнительная информация</p>
                                    <x-form.form-textarea
                                        name="other_info"
                                        label="Дополнительная информация"
                                        editor="true"
                                        value="{!! old('other_info') ?: $product->other_info !!}"
                                    />
                                </div>

                                <x-cabinet.cabinet_vendor.image-upload
                                    imgName="img"
                                    galleryName="gallery"
                                    :uploadImgRoute="route('cabinet_vendor_upload_image')"
                                    :uploadGalleryRoute="route('cabinet_vendor_upload_gallery_image')"
                                    :imgValue="$product->img"
                                    :galleryValue="$product->gallery ? $product->gallery->toJson() : null"
                                />

                                <x-cabinet.cabinet_vendor.video-upload
                                    name="video"
                                    label="Видео"
                                    :uploadRoute="route('cabinet_vendor_upload_video_chunk')"
                                    :videoValue="$product->video"
                                    :productId="$product->id"
                                />

                            </div>
                            <br>
                            <br>

                            <div id="js-categories-block" class="cabinet_radius12_fff"
                                 @error('categories') style="background:#fdecee" @enderror>
                                <x-cabinet.title2
                                    class="top_0 pad_b16_important"
                                    title="Категории"
                                    subtitle="Заполните все необходимые категории"
                                />
                                @if($categories->isNotEmpty())
                                    @php $selectedCategories = old('categories', $product->categories->pluck('id')->all()); @endphp
                                    <x-form.form-checkboxes
                                        name="categories[]"
                                        :checkboxes="$categories->map(fn($c) => [
                                            'id'       => $c->id,
                                            'title'    => $c->title,
                                            'subtitle' => $c->subtitle ?? '',
                                            'checked'  => in_array($c->id, (array) $selectedCategories),
                                        ])->all()"
                                    />
                                @endif
                            </div>
                            <br>
                            <br>

                            <div class="cabinet_radius12_fff">
                                <x-cabinet.title2
                                    class="top_0 pad_b16_important"
                                    title="Теги"
                                    subtitle="Заполните все необходимые теги"
                                />
                                @if($tags->isNotEmpty())
                                    @php $selectedTags = old('tags', $product->tags->pluck('id')->all()); @endphp
                                    <x-form.form-checkboxes
                                        name="tags[]"
                                        :checkboxes="$tags->map(fn($t) => [
                                            'id'       => $t->id,
                                            'title'    => $t->title,
                                            'subtitle' => $t->subtitle ?? '',
                                            'checked'  => in_array($t->id, (array) $selectedTags),
                                        ])->all()"
                                        class="pad_t10"
                                    />
                                @endif
                                <br>
                                {{-- Адрес проведения услуги --}}
                                <div class="pad_t26_important">
                                    <x-form.form-input
                                        name="address"
                                        type="text"
                                        label="Адрес проведения услуги"
                                        value="{{ old('address') ?: $product->address }}"
                                        required="true"
                                    />
                                    <p style="font-size:13px;color:#8a8a92;margin-top:-10px;margin-bottom:26px;">
                                        Этот адрес на сайте не публикуется. Он будет доступен только тем, кто приобрёл сертификат на данную услугу.
                                    </p>
                                </div>

                                <div class="edit-form-notice">
                                    <strong>Внимание!</strong>
                                    После сохранения услуга будет отправлена на повторную модерацию и временно скрыта с сайта до прохождения проверки.
                                </div>

                                <div class="input-button pad_t26_important edit-form-actions">
                                    <div class="edit-form-actions__left">
                                        <button type="submit" name="action" value="save" class="btn btn-big">
                                            Сохранить
                                        </button>
                                        <button type="submit" name="action" value="save_exit" class="btn btn_green btn-big">
                                            Сохранить и выйти
                                        </button>
                                    </div>
                                    <div class="edit-form-actions__right">
                                        @if($product->order_papers_count > 0)
                                            <button type="button" class="btn btn-delete btn-big"
                                                onclick="alert('Удаление невозможно. Для этой услуги выписаны бумажные сертификаты. Чтобы удалить услугу, обратитесь к администратору.')">
                                                Удалить
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-delete btn-big"
                                                onclick="if(confirm('Вы уверены? Услуга будет удалена со всеми данными. Это действие необратимо.')) document.getElementById('js-delete-service-form').submit()">
                                                Удалить
                                            </button>
                                        @endif
                                    </div>
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

    @if($product->order_papers_count == 0)
        <form id="js-delete-service-form" method="POST" action="{{ route('cabinet_vendor_service_delete', $product->id) }}" style="display:none">
            @csrf
            @method('DELETE')
        </form>
    @endif

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
