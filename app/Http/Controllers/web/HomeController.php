<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Nha_Cai;
use App\Models\Category;
use App\Models\Post;

class HomeController extends Controller
{
    public function index() {
        $data['categoryHome'] = Category::where('order_by', '>', 0)->orderBy('order_by')->limit(8)->get();
        $data['seo_data'] = initSeoData();
        $about = getSiteSetting('site_about');
        $about = $this->parse_content($about);
        $data['about'] = $about;
        $data['schema'] = getSchemaHome();
        return view('web.home.index', $data);
    }

    private function parse_content($content) {
        $content = str_replace('<img', '<img loading="lazy"', $content);
        $content = tableOfContent($content);
        return $content;
    }
}
