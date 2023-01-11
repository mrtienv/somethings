<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        define('IS_AMP', 0);

        define('IS_MOBILE', isMobile());

        $this->getBannerData();
    }

    function getBannerData(){
        $bannerData = Banner::all()->toArray();
        if (!empty($bannerData)) {
            $bannerData = array_group_by($bannerData, function ($a){
                return $a['slug'];
            });
            config(['app.banner' => $bannerData]);
        }
    }
}
