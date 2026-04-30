@props([
    'imgName'            => 'img',
    'galleryName'        => 'gallery',
    'uploadImgRoute',
    'uploadGalleryRoute',
    'imgValue'           => null,
    'galleryValue'       => null,
])

@php
    $imgDisplay     = old($imgName) ?: $imgValue;
    $galleryDisplay = old($galleryName) ?: $galleryValue;

    $galleryItems = [];
    if ($galleryDisplay) {
        $decoded = json_decode($galleryDisplay, true);
        if (is_array($decoded)) {
            $galleryItems = $decoded;
        }
    }
    $maxGallery = 15;
    $uid = 'img_' . uniqid();
@endphp

<div class="img-upload" id="{{ $uid }}">

    <div class="img-upload__title">Изображения</div>


    {{-- Основное изображение --}}
    <div class="img-upload__main">
        <div class="img-upload__preview-wrap">
            <div class="img-upload__preview-placeholder{{ $errors->has($imgName) ? ' img-upload__preview-placeholder--error' : '' }}"
                 id="{{ $uid }}-placeholder"
                 @if($imgDisplay) style="display:none" @endif>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <rect x="3" y="3" width="18" height="18" rx="2"/>
                    <circle cx="8.5" cy="8.5" r="1.5"/>
                    <path d="M21 15l-5-5L5 21"/>
                </svg>
            </div>
            <img
                src="{{ $imgDisplay ? Storage::url($imgDisplay) : '' }}"
                alt=""
                class="img-upload__preview-img{{ $imgDisplay ? ' img-upload__preview-img--visible' : '' }}"
                id="{{ $uid }}-preview"
            >
        </div>

        <div class="img-upload__main-right">
            <p class="img-upload__main-label">Основное изображение</p>
            <input type="hidden" name="{{ $imgName }}" id="{{ $uid }}-path"
                   value="{{ old($imgName) ?: $imgValue ?: '' }}">
            <input type="file" id="{{ $uid }}-file" accept="image/jpeg,image/png,image/webp,image/gif"
                   class="img-upload__file-input">
            <label for="{{ $uid }}-file" class="img-upload__btn btn">Выбрать фото</label>
            <div class="img-upload__status" id="{{ $uid }}-status"></div>
        </div>
    </div>

    {{-- Галерея --}}
    <div class="img-upload__gallery">
        <p class="img-upload__gallery-label">Галерея</p>
        <input type="hidden" name="{{ $galleryName }}" id="{{ $uid }}-gallery-json"
               value="{{ old($galleryName) ?: $galleryValue ?: '' }}">

        <div class="img-upload__gallery-items" id="{{ $uid }}-gallery-items">
            @foreach($galleryItems as $item)
                <div class="img-upload__gallery-item" data-path="{{ $item['json_gallery_text'] }}">
                    <img src="{{ Storage::url($item['json_gallery_text']) }}" alt="">
                    <button type="button" class="img-upload__gallery-remove" aria-label="Удалить">&times;</button>
                </div>
            @endforeach
        </div>

        <div class="img-upload__gallery-add" id="{{ $uid }}-gallery-add"
             @if(count($galleryItems) >= $maxGallery) style="display:none" @endif>
            <input type="file" id="{{ $uid }}-gallery-file"
                   accept="image/jpeg,image/png,image/webp,image/gif"
                   class="img-upload__file-input" multiple>
            <label for="{{ $uid }}-gallery-file" class="img-upload__gallery-add-label">
                <span>+ Добавить в галерею</span>
                <span class="img-upload__gallery-count" id="{{ $uid }}-gallery-count">
                    {{ count($galleryItems) }} / {{ $maxGallery }}
                </span>
            </label>
        </div>

        <div class="img-upload__gallery-status" id="{{ $uid }}-gallery-status"></div>
    </div>
</div>

@push('scripts')
<script>
(function () {
    const UID             = '{{ $uid }}';
    const MAX_GALLERY     = {{ $maxGallery }};
    const uploadImgUrl    = '{{ $uploadImgRoute }}';
    const uploadGalUrl    = '{{ $uploadGalleryRoute }}';
    const csrf            = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

    const root            = document.getElementById(UID);
    const fileInput       = document.getElementById(UID + '-file');
    const pathInput       = document.getElementById(UID + '-path');
    const placeholder     = document.getElementById(UID + '-placeholder');
    const preview         = document.getElementById(UID + '-preview');
    const statusEl        = document.getElementById(UID + '-status');
    const galleryItems    = document.getElementById(UID + '-gallery-items');
    const galleryAdd      = document.getElementById(UID + '-gallery-add');
    const galleryFile     = document.getElementById(UID + '-gallery-file');
    const galleryJson     = document.getElementById(UID + '-gallery-json');
    const galleryCount    = document.getElementById(UID + '-gallery-count');
    const galleryStatus   = document.getElementById(UID + '-gallery-status');

    if (!root) return;

    // ── Основное изображение ──────────────────────────────────────────────────

    fileInput.addEventListener('change', async function () {
        const file = fileInput.files[0];
        if (!file) return;

        setStatus(statusEl, '', '');

        const form = new FormData();
        form.append('image', file);
        form.append('_token', csrf);

        try {
            const res  = await fetch(uploadImgUrl, { method: 'POST', headers: { Accept: 'application/json' }, body: form });
            const data = await res.json();

            if (!res.ok) {
                setStatus(statusEl, data.message ?? 'Ошибка загрузки', 'error');
                return;
            }

            pathInput.value = data.path;
            preview.src     = data.url;
            preview.classList.add('img-upload__preview-img--visible');
            placeholder.style.display = 'none';
            placeholder.classList.remove('img-upload__preview-placeholder--error');
            setStatus(statusEl, 'Фото загружено', 'ok');
        } catch (e) {
            setStatus(statusEl, 'Ошибка сети', 'error');
        }

        fileInput.value = '';
    });

    // ── Галерея ───────────────────────────────────────────────────────────────

    galleryFile.addEventListener('change', async function () {
        const files = Array.from(galleryFile.files);
        if (!files.length) return;

        setStatus(galleryStatus, '', '');

        const current = galleryItems.querySelectorAll('.img-upload__gallery-item').length;
        const allowed = MAX_GALLERY - current;

        if (allowed <= 0) {
            setStatus(galleryStatus, 'Достигнут лимит ' + MAX_GALLERY + ' изображений', 'error');
            galleryFile.value = '';
            return;
        }

        const toUpload = files.slice(0, allowed);

        for (const file of toUpload) {
            const form = new FormData();
            form.append('image', file);
            form.append('_token', csrf);

            try {
                const res  = await fetch(uploadGalUrl, { method: 'POST', headers: { Accept: 'application/json' }, body: form });
                const data = await res.json();

                if (!res.ok) {
                    setStatus(galleryStatus, data.message ?? 'Ошибка загрузки', 'error');
                    continue;
                }

                addGalleryThumb(data.path, data.url);
            } catch (e) {
                setStatus(galleryStatus, 'Ошибка сети', 'error');
            }
        }

        if (files.length > allowed) {
            setStatus(galleryStatus, 'Добавлено ' + allowed + ' из ' + files.length + '. Лимит ' + MAX_GALLERY + ' фото достигнут.', 'error');
        }

        galleryFile.value = '';
        syncGallery();
    });

    galleryItems.addEventListener('click', function (e) {
        const btn = e.target.closest('.img-upload__gallery-remove');
        if (!btn) return;
        btn.closest('.img-upload__gallery-item').remove();
        syncGallery();
        setStatus(galleryStatus, '', '');
    });

    function addGalleryThumb(path, url) {
        const item = document.createElement('div');
        item.className = 'img-upload__gallery-item';
        item.dataset.path = path;
        item.innerHTML =
            '<img src="' + escHtml(url) + '" alt="">' +
            '<button type="button" class="img-upload__gallery-remove" aria-label="Удалить">&times;</button>';
        galleryItems.appendChild(item);
    }

    function syncGallery() {
        const items = galleryItems.querySelectorAll('.img-upload__gallery-item');
        const count = items.length;

        const arr = Array.from(items).map(el => ({
            json_gallery_label: null,
            json_gallery_text:  el.dataset.path,
        }));

        galleryJson.value = arr.length ? JSON.stringify(arr) : '';
        galleryCount.textContent = count + ' / ' + MAX_GALLERY;

        if (count >= MAX_GALLERY) {
            galleryAdd.style.display = 'none';
        } else {
            galleryAdd.style.display = '';
        }
    }

    function setStatus(el, msg, type) {
        el.textContent  = msg;
        el.className    = 'img-upload__status';
        if (type === 'ok')    el.classList.add('img-upload__status--ok');
        if (type === 'error') el.classList.add('img-upload__status--error');
    }

    function escHtml(str) {
        return str.replace(/&/g,'&amp;').replace(/"/g,'&quot;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
    }
})();
</script>
@endpush
