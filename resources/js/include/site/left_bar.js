import {slideToggle} from '../methods/slideToggle';

export function leftBar() {
    // Делегирование на document — один раз, не дублируется при ре-рендере Livewire
    document.addEventListener('click', function (e) {
        const box = e.target.closest('._box');
        if (!box) return;

        const container = box.closest('.site_catalog_left-bar');
        if (!container) return;

        const toggle = container.querySelector('.price_toggle');
        const after = container.querySelector('.after');

        if (!toggle) return;

        slideToggle(toggle);
        after.classList.toggle('_up');
    });
}
