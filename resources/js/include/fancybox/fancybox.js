import { Fancybox } from "@fancyapps/ui/dist/fancybox/";
import "@fancyapps/ui/dist/fancybox/fancybox.css";
import {asyncExecution} from "../form_async/async_execution";


// Биндинг для галерей (data-fancybox="gallery") и одиночных изображений
Fancybox.bind('[data-fancybox]');

/** получаем csrf **/
const metaElements = document.querySelectorAll('meta[name="csrf-token"]');
const csrf = metaElements.length > 0 ? metaElements[0].content : "";
/** получаем csrf **/


const fancyWindows = Array.from(document.querySelectorAll('.open-fancybox'))

/** открыть open-fancybox **/
for (let fancyWindow of fancyWindows) {
    fancyWindow.addEventListener('click', openFancyBox)
}

/** открыть fast-login-ajax (делегация — элемент загружается динамически) **/
document.addEventListener('click', async function (e) {
    const btn = e.target.closest('.fast-login-ajax');
    if (!btn) return;
    e.preventDefault();

    try {
        const response = await fetch('/fancybox-ajax', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-Token': csrf },
            body: JSON.stringify({ template: 'fast_login', author: '@AxeldMaster', data: '{}' }),
        });

        const data = await response.text();

        Fancybox.close();
        Fancybox.show([{ html: data }], {
            dragToClose: false,
            closeButton: true,
            backdropClick: 'close',
        });

        asyncExecution();
    } catch (err) {
        console.error('Ошибка fast-login-ajax:', err.message);
    }
})

/** открыть no-registration-ajax (делегация — элемент загружается динамически) **/
document.addEventListener('click', async function (e) {
    const btn = e.target.closest('.no-registration-ajax');
    if (!btn) return;
    e.preventDefault();

    try {
        const transferData = btn.closest('.app_form_modal')
            ?.querySelector('input[name="redirect_to"]')?.value ?? '';

        const template = { template: 'no_registration', author: '@AxeldMaster', data: JSON.stringify({ redirect: transferData }) };

        const response = await fetch('/fancybox-ajax', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-Token': csrf },
            body: JSON.stringify(template),
        });

        const data = await response.text();

        Fancybox.close();
        Fancybox.show([{ html: data }], {
            dragToClose: false,
            closeButton: true,
            backdropClick: 'close',
        });

        asyncExecution();
    } catch (err) {
        console.error('Ошибка no-registration-ajax:', err.message);
    }
})


async  function openFancyBox(e) {
    e.preventDefault()
    try {

        /** в случае клика по-внутреннему тэгу, получим data-form в любом случае **/
        const parentEl = e.target.closest('.open-fancybox');
        const formTemplate = parentEl.dataset.form; /** название шаблона для blade **/
        const transferData = parentEl.dataset.transfer; /** дополнительные данные в json для blade **/
        const template = { template: formTemplate, author: '@AxeldMaster', data: transferData };

        console.log(template)

        const response = await fetch('/fancybox-ajax', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-Token': csrf
            },
            body: JSON.stringify(template),
        });

        if (!response.ok) {
            console.error(`Error: ${response.status}`);
        }
        // const data = await response.json();
        const data = await response.text(); // Важно использовать .text(), а не .json()

        Fancybox.show([{
            html: data,

        }],
            {
            dragToClose: false,       // Перетаскивание не закроет модалку
            closeButton: true,         // Крестик закрытия включен
            backdropClick: 'close'    // закрытие по клику в пустое пространство
        },
            );


        asyncExecution() // соберем эту форму

    } catch (err) {
        console.error('Ошибка AJAX:', err.message);
        alert('Ошибка при получении данных');
    }
}
