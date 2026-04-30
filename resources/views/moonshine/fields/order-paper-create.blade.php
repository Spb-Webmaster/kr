<div
    x-data="{
        count: 1,
        loading: false,
        message: '',
        messageType: '',
        async submit() {
            this.loading = true;
            this.message = '';
            try {
                const response = await fetch('{{ $createUrl }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content ?? '',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ product_id: {{ $productId ?? 'null' }}, count: this.count }),
                });
                const data = await response.json();
                if (response.ok) {
                    this.message = data.message;
                    this.messageType = 'success';
                } else {
                    this.message = data.message ?? 'Ошибка при создании';
                    this.messageType = 'error';
                }
            } catch (e) {
                this.message = 'Ошибка запроса';
                this.messageType = 'error';
            } finally {
                this.loading = false;
            }
        }
    }"
    class="flex flex-col gap-3"
>
    <div class="text-sm" style="color: #ffffff !important">
        Выписано бумажных сертификатов: <strong>{{ $papersCount }}</strong>
    </div>

    <div class="font-semibold" style="color: #ffffff !important">Создание бумажных сертификатов</div>

    <div class="flex items-end gap-3">
        <div class="flex flex-col gap-1">
            <label class="text-sm" style="color: #ffffff !important">Количество</label>
            <input
                type="number"
                x-model.number="count"
                min="1"
                max="500"
                class="form-input w-32"
            />
        </div>

        <button
            type="button"
            @click="submit"
            :disabled="loading"
            class="btn btn-primary"
        >
            <span x-show="!loading">Создать</span>
            <span x-show="loading">Создание...</span>
        </button>
    </div>

    <div x-show="message" x-cloak>
        <div
            x-text="message"
            :class="messageType === 'success' ? 'text-green-600' : 'text-red-600'"
            class="text-sm"
        ></div>
    </div>
</div>
