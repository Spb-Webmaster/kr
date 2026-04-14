<?php

namespace App\View\Components\Site\Menu;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TopMenu extends Component
{

    public array $menu_rendered;

    public function __construct()
    {

        $this->menu_rendered = $this->setMenu();


    }


    public function setMenu():array
    {

        $menu = [];

        $menu[0]['text'] = 'Главная';
        $menu[0]['link'] = '/';
        $menu[0]['class'] = false;
        $menu[0]['data'] = false;
        $menu[0]['class_li'] = false;
        $menu[0]['parent'] = false;

        $menu[1]['text'] = 'Все подарки';
        $menu[1]['link'] = route('certificates', ['category'=>'all']);
        $menu[1]['class'] = false;
        $menu[1]['data'] = false;
        $menu[1]['class_li'] = false;
        $menu[1]['parent'] = false;

        $menu[2]['text'] = 'Правила и условия';
        $menu[2]['link'] = '/pravila-i-usloviya';
        $menu[2]['class'] = false;
        $menu[2]['data'] = false;
        $menu[2]['class_li'] = false;
        $menu[2]['parent'] = false;

        $menu[3]['text'] = 'Для продавцов';
        $menu[3]['link'] = route('vendor_login');
        $menu[3]['class'] = false;
        $menu[3]['data'] = false;
        $menu[3]['class_li'] = false;
        $menu[3]['parent'] = false;

        $menu[4]['text'] = 'Контакты';
        $menu[4]['link'] = '#';
        $menu[4]['class'] = false;
        $menu[4]['data'] = false;
        $menu[4]['class_li'] = false;
        $menu[4]['parent'] = false;



        return $menu;
    }


    public function render(): View|Closure|string
    {
        return view('components.site.menu.top-menu');
    }
}
