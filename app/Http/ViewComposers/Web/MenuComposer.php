<?php

namespace App\Http\ViewComposers\Web;

use App\Models\Menu;
use Illuminate\View\View;

class MenuComposer
{
    public function compose(View $view)
    {
        $mainMenuPc = Menu::find(1);
        $data = [];
        if (!empty($mainMenuPc)) {
            $mainMenuPc = json_decode($mainMenuPc->data, 1);
            $data['mainMenuPc'] = $mainMenuPc;
        }
        $subMenuPc = Menu::find(2);
        if (!empty($subMenuPc)) {
            $subMenuPc = json_decode($subMenuPc->data, 1);
            $data['subMenuPc'] = $subMenuPc;
        }
        $mainMenuMobile = Menu::find(3);
        if (!empty($mainMenuMobile)) {
            $mainMenuMobile = json_decode($mainMenuMobile->data, 1);
            $data['mainMenuMobile'] = $mainMenuMobile;
        }
        $subMenuMobile1 = Menu::find(4);
        if (!empty($subMenuMobile1)) {
            $subMenuMobile1 = json_decode($subMenuMobile1->data, 1);
            $data['subMenuMobile1'] = $subMenuMobile1;
        }
        $subMenuMobile2 = Menu::find(5);
        if (!empty($subMenuMobile2)) {
            $subMenuMobile2 = json_decode($subMenuMobile2->data, 1);
            $data['subMenuMobile2'] = $subMenuMobile2;
        }
        $subMenuMobile3 = Menu::find(6);
        if (!empty($subMenuMobile3)) {
            $subMenuMobile3 = json_decode($subMenuMobile3->data, 1);
            $data['subMenuMobile3'] = $subMenuMobile3;
        }
        $menuGioiThieu= Menu::find(7);
        if (!empty($menuGioiThieu)) {
            $menuGioiThieu = json_decode($menuGioiThieu->data, 1);
            $data['menuGioiThieu'] = $menuGioiThieu;
        }
        $menuTienIch = Menu::find(8);
        if (!empty($menuTienIch)) {
            $menuTienIch = json_decode($menuTienIch->data, 1);
            $data['menuTienIch'] = $menuTienIch;
        }
        $view->with($data);
    }
}
