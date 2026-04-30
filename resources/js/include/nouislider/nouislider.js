import 'nouislider/dist/nouislider.css'
import Nouislider from "nouislider"

function formatPrice(value) {
    return Math.round(value).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '\u00A0');
}

function parsePrice(value) {
    return parseFloat(value.toString().replace(/\s/g, '')) || 0;
}

export function initRange() {
    document.querySelectorAll('.slider').forEach(function (sliderEl) {
        const container = sliderEl.closest('.left_bar') ?? sliderEl.parentElement;
        const inputMin = container.querySelector('.price_min');
        const inputMax = container.querySelector('.price_max');
        const hiddenMin = container.querySelector('.price_min_hidden');
        const hiddenMax = container.querySelector('.price_max_hidden');

        const min = inputMin ? parseFloat(inputMin.dataset.min) || 0 : 0;
        const max = inputMax ? parseFloat(inputMax.dataset.max) || 100000 : 100000;
        const startMin = inputMin ? parsePrice(inputMin.value) || min : min;
        const startMax = inputMax ? parsePrice(inputMax.value) || max : max;

        // Если слайдер уже был инициализирован (например, после ре-рендера Livewire) — уничтожаем его
        if (sliderEl.noUiSlider) {
            sliderEl.noUiSlider.destroy();
        }

        Nouislider.create(sliderEl, {
            start: [startMin, startMax],
            connect: true,
            range: { min, max }
        });

        sliderEl.noUiSlider.on('update', function (values) {
            const valMin = Math.round(values[0]);
            const valMax = Math.round(values[1]);

            if (inputMin) inputMin.value = formatPrice(valMin);
            if (inputMax) inputMax.value = formatPrice(valMax);
            if (hiddenMin) hiddenMin.value = valMin;
            if (hiddenMax) hiddenMax.value = valMax;
        });

        if (inputMin) {
            inputMin.addEventListener('change', function () {
                sliderEl.noUiSlider.set([parsePrice(this.value), null]);
            });
        }

        if (inputMax) {
            inputMax.addEventListener('change', function () {
                sliderEl.noUiSlider.set([null, parsePrice(this.value)]);
            });
        }

        // Кнопка «Показать»: вызываем метод Livewire-компонента с текущими значениями слайдера.
        // Livewire сам знает о выбранных чекбоксах, тегах, городах и категории.
        const btn = container.querySelector('.price-filter-submit');
        if (btn) {
            btn.addEventListener('click', function () {
                const valMin = inputMin ? parsePrice(inputMin.value) : 0;
                const valMax = inputMax ? parsePrice(inputMax.value) : 0;

                const wireEl = sliderEl.closest('[wire\\:id]');
                if (!wireEl || !window.Livewire) return;

                const wire = Livewire.find(wireEl.getAttribute('wire:id'));
                if (wire) wire.$call('applyPriceFilter', valMin, valMax);
            });
        }
    });
}
