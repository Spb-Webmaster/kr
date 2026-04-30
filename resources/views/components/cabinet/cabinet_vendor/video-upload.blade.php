@props(['label' => 'Видео', 'name' => 'video', 'uploadRoute', 'videoValue' => null, 'productId' => null])

@php $currentVideo = old($name) ?: $videoValue; @endphp

{{-- Загрузка видео --}}
<div class="video-upload">
    <label class="video-upload__label">{{ $label }}</label>
    <input type="hidden" name="{{ $name }}" id="js-video-path" value="{{ $currentVideo ?: '' }}">

    @if($currentVideo)
        <div class="video-upload__current" id="js-video-current">
            <video src="{{ Storage::url($currentVideo) }}" controls class="video-upload__preview"></video>
            <button type="button" class="video-upload__remove" id="js-video-remove"
                @if($productId) data-delete-url="{{ route('cabinet_vendor_service_delete_video', $productId) }}" @endif>
                Удалить видео
            </button>
        </div>
    @endif

    <div class="video-upload__area" id="js-video-area" @if($currentVideo) style="display:none" @endif>
        <input type="file" id="js-video-file" accept="video/mp4,video/quicktime,video/avi,video/webm" class="video-upload__file-input">
        <label for="js-video-file" class="video-upload__btn btn">
            Выбрать файл
        </label>
        <span class="video-upload__name" id="js-video-name">Файл не выбран</span>
    </div>

    <div class="video-upload__progress" id="js-video-progress" style="display:none">
        <div class="video-upload__progress-bar" id="js-video-progress-bar"></div>
        <span class="video-upload__progress-text" id="js-video-progress-text">0%</span>
    </div>

    <div class="video-upload__status" id="js-video-status"></div>
</div>

@push('scripts')
<script>
(function () {
    const CHUNK_SIZE   = 5 * 1024 * 1024; // 5 МБ
    const uploadUrl    = '{{ $uploadRoute }}';
    const csrfToken    = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

    const fileInput    = document.getElementById('js-video-file');
    const pathInput    = document.getElementById('js-video-path');
    const nameEl       = document.getElementById('js-video-name');
    const progressWrap = document.getElementById('js-video-progress');
    const progressBar  = document.getElementById('js-video-progress-bar');
    const progressText = document.getElementById('js-video-progress-text');
    const statusEl     = document.getElementById('js-video-status');

    if (!fileInput) return;

    const currentBlock = document.getElementById('js-video-current');
    const removeBtn    = document.getElementById('js-video-remove');
    const areaEl       = document.getElementById('js-video-area');

    if (removeBtn) {
        removeBtn.addEventListener('click', async function () {
            if (!confirm('Удалить видео? Файл будет удалён с сервера.')) return;

            const deleteUrl = removeBtn.dataset.deleteUrl;
            if (deleteUrl) {
                try {
                    await fetch(deleteUrl, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                        },
                    });
                } catch (e) {}
            }

            pathInput.value = '';
            currentBlock.style.display = 'none';
            areaEl.style.display = '';
        });
    }

    fileInput.addEventListener('change', function () {
        const file = fileInput.files[0];
        if (!file) return;

        nameEl.textContent = file.name;
        pathInput.value    = '';
        statusEl.textContent = '';
        progressBar.style.width = '0%';
        progressText.textContent = '0%';
        progressWrap.style.display = 'block';

        uploadChunked(file);
    });

    async function uploadChunked(file) {
        const totalChunks = Math.ceil(file.size / CHUNK_SIZE);

        for (let i = 0; i < totalChunks; i++) {
            const start = i * CHUNK_SIZE;
            const chunk = file.slice(start, start + CHUNK_SIZE);

            const form = new FormData();
            form.append('chunk', chunk, file.name);
            form.append('chunkIndex', i);
            form.append('totalChunks', totalChunks);
            form.append('filename', file.name);
            form.append('_token', csrfToken);

            let res;
            try {
                res = await fetch(uploadUrl, {
                    method: 'POST',
                    headers: { 'Accept': 'application/json' },
                    body: form,
                });
            } catch (e) {
                setError('Ошибка сети. Попробуйте ещё раз.');
                return;
            }

            if (res.status === 401) {
                setError('Сессия истекла. Обновите страницу и войдите снова.');
                return;
            }

            if (!res.ok) {
                setError('Ошибка загрузки (' + res.status + '). Попробуйте ещё раз.');
                return;
            }

            const data = await res.json();

            const pct = Math.round(((i + 1) / totalChunks) * 100);
            progressBar.style.width = pct + '%';
            progressText.textContent = pct + '%';

            if (data.done) {
                pathInput.value      = data.path;
                statusEl.textContent = 'Видео загружено';
                statusEl.className   = 'video-upload__status video-upload__status--ok';
            }
        }
    }

    function setError(msg) {
        statusEl.textContent = msg;
        statusEl.className   = 'video-upload__status video-upload__status--error';
        progressWrap.style.display = 'none';
    }
})();
</script>
@endpush
