<?php

namespace App\Http\ViewComposers\Web;

use App\Models\Nha_Cai;
use Illuminate\View\View;
use App\Models\Post;

class SidebarComposer
{
    public function compose(View $view)
    {
        $data['listHuongDanCaCuoc'] = Post::where(['status' => 1, 'category_id' => 2, ['displayed_time', '<=', Post::raw('NOW()')]])->orderBy('displayed_time', 'DESC')->limit(5)->get();
        $data['listHuongDanChoiGame'] = Post::where(['status' => 1, 'category_id' => 6, ['displayed_time', '<=', Post::raw('NOW()')]])->orderBy('displayed_time', 'DESC')->limit(5)->get();
        $data['listGiftCode'] = Post::where(['status' => 1, 'category_id' => 12, ['displayed_time', '<=', Post::raw('NOW()')]])->orderBy('displayed_time', 'DESC')->limit(5)->get();
        $view->with($data);
    }
}
