@props(['priceOptions', 'prices' => [], 'price' => null])

{{-- Цена --}}
<div class="cu_row_50">
    <div class="cu__col">
@php $priceVal = old('price') ?? $price; @endphp
        <x-form.form-input
            name="price"
            type="text"
            inputmode="numeric"
            class="js-price-input"
            label="Стоимость (руб.)"
            value="{{ $priceVal ? number_format((int) $priceVal, 0, '.', ' ') : '' }}"
        />
    </div>
    <div class="cu__col">
        <div class="input-group">
        <button type="button" id="js-price-options-toggle" class="btn btn_green btn-big" style="width:100%">
            Указать свойства цены
        </button>
        </div>
    </div>
</div>

{{-- Панель вариантов цены --}}
<div id="js-price-options-panel" class="price-options-panel" style="display:none">
    <div id="js-price-options-rows">
        @foreach(old('prices', $prices) as $i => $oldPrice)
            <div class="price-options-panel__row">
                <div class="cu_row cu_row_30">
                    <div class="cu__col">
                        <div class="input-group">
                            <select name="prices[{{ $i }}][option_id]" class="input-group__input price-options-panel__select">
                                <option value=""></option>
                                @foreach($priceOptions as $opt)
                                    <option value="{{ $opt->id }}" @selected((int)($oldPrice['option_id'] ?? 0) === $opt->id)>
                                        {{ $opt->title }}
                                    </option>
                                @endforeach
                            </select>
                            <label class="input-group__label @if(!empty($oldPrice['option_id'])) position_top @endif">Вариант цены</label>
                        </div>
                    </div>
                    <div class="cu__col">
                        <div class="input-group">
                            <input type="text"
                                   inputmode="numeric"
                                   name="prices[{{ $i }}][price]"
                                   class="input-group__input js-price-input"
                                   placeholder=""
                                   value="{{ !empty($oldPrice['price']) ? number_format((int) $oldPrice['price'], 0, '.', ' ') : '' }}" />
                            <label class="input-group__label @if(!empty($oldPrice['price'])) position_top @endif">Цена (руб.)</label>
                        </div>
                    </div>
                    <div class="cu__col price-options-panel__remove-col">
                        <button type="button" class="price-options-panel__remove js-remove-price-row" aria-label="Удалить">
                            <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 1L9 9M9 1L1 9" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <button type="button" id="js-add-price-row" class="btn">+ Добавить вариант</button>
</div>

@push('scripts')
<script>
(function () {
    const options  = @json($priceOptions->map(fn($o) => ['id' => $o->id, 'title' => $o->title]));
    const toggle   = document.getElementById('js-price-options-toggle');
    const panel    = document.getElementById('js-price-options-panel');
    const rowsWrap = document.getElementById('js-price-options-rows');
    const addBtn   = document.getElementById('js-add-price-row');

    // Форматирование: «10000» → «10 000»
    function formatPrice(val) {
        const digits = val.replace(/\D/g, '');
        return digits.replace(/\B(?=(\d{3})+(?!\d))/g, '\u00a0');
    }

    // Навешиваем форматирование на инпут
    function bindPriceInput(input) {
        input.addEventListener('input', function () {
            const pos = this.selectionStart;
            const before = this.value.length;
            this.value = formatPrice(this.value);
            const diff = this.value.length - before;
            this.setSelectionRange(pos + diff, pos + diff);
        });
    }

    // Подключаем уже существующие поля
    document.querySelectorAll('.js-price-input').forEach(bindPriceInput);

    // Перед отправкой снимаем пробелы — бэкенд получает «10000»
    const form = toggle.closest('form');
    if (form) {
        form.addEventListener('submit', function () {
            form.querySelectorAll('.js-price-input').forEach(function (input) {
                input.value = input.value.replace(/\D/g, '');
            });
        });
    }

    @if(old('prices') || count($prices) > 0)
    panel.style.display = 'block';
    updateAddBtn();
    @endif

    toggle.addEventListener('click', function () {
        const visible = panel.style.display !== 'none';
        panel.style.display = visible ? 'none' : 'block';
        if (!visible && rowsWrap.children.length === 0) addRow();
        if (!visible && window.innerWidth < 768) {
            setTimeout(function () {
                panel.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 200);
        }
    });

    addBtn.addEventListener('click', addRow);

    rowsWrap.addEventListener('click', function (e) {
        const btn = e.target.closest('.js-remove-price-row');
        if (btn) {
            btn.closest('.price-options-panel__row').remove();
            reindex();
            updateAddBtn();
            if (rowsWrap.children.length === 0) {
                panel.style.display = 'none';
            }
        }
    });

    function addRow() {
        if (rowsWrap.children.length >= options.length) return;

        const idx  = rowsWrap.children.length;
        const opts = options.map(o => `<option value="${o.id}">${o.title}</option>`).join('');

        const row = document.createElement('div');
        row.className = 'price-options-panel__row';
        row.innerHTML = `
            <div class="cu_row cu_row_30">
                <div class="cu__col">
                    <div class="input-group">
                        <select name="prices[${idx}][option_id]" class="input-group__input price-options-panel__select">
                            <option value=""></option>${opts}
                        </select>
                        <label class="input-group__label">Вариант цены</label>
                    </div>
                </div>
                <div class="cu__col">
                    <div class="input-group">
                        <input type="text" inputmode="numeric"
                               name="prices[${idx}][price]"
                               class="input-group__input js-price-input"
                               placeholder="" />
                        <label class="input-group__label">Цена (руб.)</label>
                    </div>
                </div>
                <div class="cu__col price-options-panel__remove-col">
                    <button type="button" class="price-options-panel__remove js-remove-price-row" aria-label="Удалить">
                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 1L9 9M9 1L1 9" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </button>
                </div>
            </div>`;
        rowsWrap.appendChild(row);

        // Подключаем форматирование к новому инпуту
        bindPriceInput(row.querySelector('.js-price-input'));
        updateAddBtn();
    }

    function reindex() {
        Array.from(rowsWrap.children).forEach(function (row, i) {
            row.querySelector('select').name = `prices[${i}][option_id]`;
            row.querySelector('input').name  = `prices[${i}][price]`;
        });
    }

    function updateAddBtn() {
        addBtn.disabled = rowsWrap.children.length >= options.length;
    }
})();
</script>
@endpush
