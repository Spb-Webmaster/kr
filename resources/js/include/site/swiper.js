// import Swiper bundle with all modules installed
import Swiper from 'swiper/bundle';

export function swiper() {

// init Swiper:
    const swiper = new Swiper('.swiper', {
        loop: true,
        slidesPerView: 4,
        spaceBetween: 30,
        breakpoints: {
            0: {
                slidesPerView: 2,
                spaceBetween: 4,
                centeredSlides: true,
            },
            568: {
                slidesPerView: 3,
                spaceBetween: 10,
                centeredSlides: false,
            },
            742: {
                slidesPerView: 4,
                spaceBetween: 10,
            },
            846: {
                slidesPerView: 5,
                spaceBetween: 10,
            },
            960: {
                slidesPerView: 3,
                spaceBetween: 20,
            },
            1122: {
                slidesPerView: 4,
                spaceBetween: 30,
            },
        },
 /*       pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },*/

        // Navigation arrows
/*
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
*/


    });
}
