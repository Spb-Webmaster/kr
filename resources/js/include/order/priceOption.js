export function priceOptions() {
    const radios = document.querySelectorAll('input[name="price"]');
    if (!radios.length) return;

    const appPrice = document.querySelector('.app_price');
    const appLabel = document.querySelector('.app_label');
    const priceOptionInput = document.querySelector('input[name="price_option"]');

    function activate(radio) {
        document.querySelectorAll('label.product_single__price-row').forEach(function (label) {
            label.classList.remove('active');
        });
        radio.closest('label.product_single__price-row').classList.add('active');

        if (appPrice) appPrice.textContent = radio.value;
        if (appLabel) appLabel.textContent = radio.dataset.option || '';
        if (priceOptionInput) priceOptionInput.value = radio.dataset.option || '';
    }

    radios.forEach(function (radio) {
        radio.addEventListener('change', function () {
            activate(this);
        });
    });
}
