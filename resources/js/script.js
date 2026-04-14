import { imask } from './include/imask';
import { close_flash } from './include/flash';
import {yandex_map_object} from "./include/site/yandex_map";
import {swiper} from "./include/site/swiper";
import {content_faq} from "./include/site/content_faq";
import {removeErrors} from "./include/fancybox/form/removeErrors";
 import {select} from "./include/select/select";
import {flash_message} from "./include/flash_message/flash_message";
import {uploadAvatar} from "./include/cabinet/uploadAvatar";
import {uploadFiles} from "./include/cabinet/uploadFiles";
import {datepicker_date_birthday} from "./include/datepicker/datepicker";
import {trix} from "./include/editor/trix";
import {initRange} from "./include/nouislider/nouislider";
import {leftBar} from "./include/site/left_bar";
import {priceOptions} from "./include/order/priceOption.js";
import {mobileMenu} from "./include/site/mobile_menu";



document.addEventListener('DOMContentLoaded', function () {

    imask() // маска на поле input input[name="phone"]
    close_flash() // закрытие flash
   /* tooltip() // tooltip */
    yandex_map_object('43db27ba-be61-4e84-b139-ff37ad4802b8') // карта в объект
    swiper()
    content_faq() // FAQ
    removeErrors() // убрать ошибки с input`s
    select() // select, для axios модальных форм подключается отдельно
    flash_message() // закрытие модального окна
    uploadAvatar() // отправляем аватар пользователя
     uploadFiles() //
    datepicker_date_birthday() // календарик день рождения
    trix() // редактор
    initRange() // слайдер nouiSlider
    leftBar() // раскрытие/скрытие фильтра цены
    priceOptions() // радио цены
    mobileMenu() // мобильное меню
});

// После каждого успешного ре-рендера Livewire переинициализируем слайдер.
// Используем commit-хук Livewire 4: succeed срабатывает после обновления DOM.
// queueMicrotask гарантирует запуск после завершения морфинга DOM.
document.addEventListener('livewire:initialized', () => {
    Livewire.hook('commit', ({ succeed }) => {
        succeed(() => {
            queueMicrotask(() => initRange())
        })
    })
})
