export function priceOptions() {
    document.querySelectorAll('input[name="price"]').forEach(function (radio) {
        radio.addEventListener('change', function () {
            document.querySelector('input[name="price_option"]').value = this.dataset.option;
        });
    });
}
