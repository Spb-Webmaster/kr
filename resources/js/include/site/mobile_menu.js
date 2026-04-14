export function mobileMenu() {
    const trigger  = document.querySelector('.top_menu__mobile');
    const overlay  = document.querySelector('.mobile_menu_overlay');
    const panel    = document.querySelector('.mobile_menu_panel');
    const closeBtn = document.querySelector('.mobile_menu_panel__close');

    if (!trigger || !overlay || !panel) return;

    function openMenu() {
        overlay.classList.add('is-active');
        panel.classList.add('is-active');
        document.body.classList.add('mobile_menu_open');
    }

    function closeMenu() {
        overlay.classList.remove('is-active');
        panel.classList.remove('is-active');
        document.body.classList.remove('mobile_menu_open');
    }

    trigger.addEventListener('click', openMenu);
    overlay.addEventListener('click', closeMenu);
    if (closeBtn) closeBtn.addEventListener('click', closeMenu);

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeMenu();
    });
}
