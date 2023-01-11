<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Models\Page;
use App\Models\Crawler;

class PageController extends Controller
{
    public function index($slug, $id) {
        $oneItem = Page::findOrFail($id);
        if ($oneItem->slug != $slug) return Redirect::to(getUrlStaticPage($oneItem), 301);
        $oneItem->content = $this->parse_content($oneItem->content);
        $data['oneItem'] = $oneItem;
        switch ($oneItem->id) {
            case 1: // Tip bóng đá
                if (isMobile()) {
                    $data_api = getDataAPIPost('http://api.sblradar.net/api/v2/page/getPage?id=9');
                    $class = "data-tip-mb";
                } else {
                    $data_api = getDataAPIPost('http://api.sblradar.net/api/v2/page/getPage?id=8');
                    $class = "data-tip";
                }
                $data['data_top'] = $this->parse_content($data_api->data->content);
                $data['class'] = $class;
                break;
            case 7: //May tinh du doan
                $result = Crawler::where('page', 'may-tinh-du-doan-bong-da')->get();
                if (!empty($result[0]->content)) $data['data_top'] = $this->removeUrl($result[0]->content);
                $data['class'] = ' ';
                break;
            case 59: //Da ga
                if (strpos($oneItem->content, '[live1]') !== false)
                    $oneItem->content = $this->daGa($oneItem->content, '[live1]', getSiteSetting('site_daGa'));
                break;
            default:
                break;
        }

        $breadCrumb = [];

        $breadCrumb[] = [
            'name' => 'Trang chủ',
            'item' => url('/'),
            'schema' => false,
            'show' => true
        ];

        $breadCrumb[] = [
            'name' => $oneItem->title,
            'item' => getUrlStaticPage($oneItem),
            'schema' => true,
            'show' => false
        ];

        $data['schema'] = getSchemaBreadCrumb($breadCrumb);

        $data['seo_data'] = initSeoData($oneItem, 'page');
        return view('web.page.index', $data);
    }

    private function parse_content($content) {
        $array_str_remove = array(
            'background-color: #EEEEEE;'
        );
        $content = str_replace($array_str_remove, '', $content);
        return $content;
    }

    private function removeUrl($content) {
        return preg_replace('#<a.*?>(.*?)</a>#i', '\1', $content);
    }

    private function daGa($content, $short_code, $url) {
        return str_replace($short_code, initVideo($url), $content);
    }

    public function not_found() {
        abort(404);
    }

    public function error() {
        return Redirect::to(url('/'), 301);
    }

    public function any() {
        return Redirect::to(url('404.html'));
    }
}
