<?php
//use Cookie;
use App\Models\Rating;

function toSlug($doc)
{
    $str = addslashes(html_entity_decode($doc));
    $str = trim($str);
    $str = toNormal($str);
    $str = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $str);
    $str = preg_replace("/( )/", '-', $str);
    $str = str_replace('/', '', $str);
    $str = str_replace("\/", '', $str);
    $str = str_replace("+", "", $str);
    $str = strtolower($str);
    $str = stripslashes($str);
    return trim($str, '-');
}

function toNormal($str)
{
    $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
    $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
    $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
    $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
    $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
    $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
    $str = preg_replace("/(đ)/", 'd', $str);
    $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
    $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
    $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
    $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
    $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
    $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
    $str = preg_replace("/(Đ)/", 'D', $str);
    return $str;
}

function get_limit_content($string, $length = 255)
{
    //$string = strip_tags($string);
    if (strlen($string) > 0) {
        $arr = explode(' ', $string);
        $return = '';
        if (count($arr) > 0) {
            $count = 0;
            if ($arr) foreach ($arr as $str) {
                $count += strlen($str);
                if ($count > $length) {
                    $return .= "...";
                    break;
                }
                $return .= " " . $str;
            }
            $return .= ' <a href="javascript:;" title="Xem thêm" class="text-success content-expand">Xem thêm</a>';
            $return = closeTags($return);
        }
        return $return;
    } else {
        return '';
    }
}

function closeTags($html){
    preg_match_all('#<(?!meta|img|br|hr|input\b)\b([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
    $openEdTags = $result[1];
    preg_match_all('#</([a-z]+)>#iU', $html, $result);
    $closedTags = $result[1];
    $len_opened = count($openEdTags);
    if (count($closedTags) == $len_opened) {
        return $html;
    }
    $openEdTags = array_reverse($openEdTags);
    for ($i = 0; $i < $len_opened; $i++) {
        if (!in_array($openEdTags[$i], $closedTags)) {
            $html .= '</' . $openEdTags[$i] . '>';
        } else {
            unset($closedTags[array_search($openEdTags[$i], $closedTags)]);
        }
    }
    return $html;
}

function getListPermission() {
    return [
        'category' => 'Chuyên mục',
        'post' => 'Bài viết',
        'tour' => 'Tour',
        'user' => 'Thành viên',
        'group' => 'Nhóm quyền',
        'site_setting' => 'Cài đặt chung',
        'menu' => 'Cấu hình Menu',
    ];
}

function getCurrentController() {
    $controller = class_basename(Route::current()->controller);
    return strtolower(str_replace('Controller', '', $controller));
}

function getCurrentAction() {
    return class_basename(Route::current()->getActionMethod());
}

function getCurrentParams() {
    return Route::current()->parameters();
}

function getCurrentControllerTitle() {
    $controller = getCurrentController();
    $listPermission = getListPermission();
    return !empty($listPermission[$controller]) ? $listPermission[$controller] : '';
}

function getSiteSetting($key) {
    $value = '';
    if (!empty($key)) {
        $value = \App\Models\SiteSetting::where('setting_key', $key)->first();
    }
    return $value->setting_value;
}

function strip_quotes($str)
{
    return str_replace(array('"', "'"), '', $str);
}

function genImage($src, $width, $height, $title = false, $class = 'img-fluid', $lazy = true) {
    if (!IS_AMP){
        if ($lazy)
            $lazy = " loading=\"lazy\"";
        $src = getThumbnail($src, $width, $height);
        $img = "<img $lazy src='$src' alt='$title' class='$class' width='$width' height='$height'>";
    } else {
        $img = "<amp-img src='$src' alt='$title' width='$width' height='$height'></amp-img>";
    }

    return $img;
}

function getThumbnail($image_url, $width = '', $height = ''){
    $source_file = public_path().$image_url;
    if (!file_exists($source_file)){
        return $image_url;
    }

    //return url($image_url);
    //check file exist
    if (empty($width) || empty($height))
        return url($image_url);

    $source_file = str_replace('//','/',$source_file);

    $image_name = substr($image_url, 0, strrpos($image_url, '.'));
    $image_ext = substr($image_url, strrpos($image_url, '.'));

    $resize_image_name = $image_name.'-'.$width.'x'.$height.$image_ext;
    $resize_image_file = public_path().'/thumb'.$resize_image_name;
    $resize_image_url = url('thumb'.$resize_image_name);

    if(file_exists($resize_image_file)){
        $img_src = $resize_image_url;
    }else{
        resize_crop_image($width, $height, $source_file, $resize_image_file);
        if(file_exists($resize_image_file)){
            $img_src = $resize_image_url;
        }else{
            $img_src = $image_url;
        }
    }

    return $img_src;
}

function resize_crop_image($max_width, $max_height, $source_file, $dst_dir, $quality = 80){
    try {
        $imgSize = getimagesize($source_file);
        $width = $imgSize[0];
        $height = $imgSize[1];
        $mime = $imgSize['mime'];

        switch ($mime) {
            case 'image/gif':
                $image_create = "imagecreatefromgif";
                $image = "imagegif";
                break;

            case 'image/png':
                $image_create = "imagecreatefrompng";
                $image = "imagepng";
                $quality = 7;
                break;

            case 'image/jpeg':
                $image_create = "imagecreatefromjpeg";
                $image = "imagejpeg";
                $quality = 80;
                break;

            default:
                return false;
                break;
        }

        $dst_img = imagecreatetruecolor($max_width, $max_height);
        $src_img = $image_create($source_file);

        $width_new = $height * $max_width / $max_height;
        $height_new = $width * $max_height / $max_width;
        //if the new width is greater than the actual width of the image, then the height is too large and the rest cut off, or vice versa
        if ($width_new > $width) {
            //cut point by height
            $h_point = (($height - $height_new) / 2);
            //copy image
            imagecopyresampled($dst_img, $src_img, 0, 0, 0, $h_point, $max_width, $max_height, $width, $height_new);
        } else {
            //cut point by width
            $w_point = (($width - $width_new) / 2);
            imagecopyresampled($dst_img, $src_img, 0, 0, $w_point, 0, $max_width, $max_height, $width_new, $height);
        }

        $folderPath = substr($dst_dir, 0, strrpos($dst_dir, '/'));
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0755, true);
        }

        $image($dst_img, $dst_dir, $quality);

        if ($dst_img) imagedestroy($dst_img);
        if ($src_img) imagedestroy($src_img);
    } catch (Exception $e) {

    }
}

function initSeoData($item='', $type='home'){
    switch ($type) {
        case 'category':
            $data_seo = [
                'meta_title' => strip_quotes($item->meta_title),
                'meta_keyword' => $item->meta_keyword,
                'meta_description' => strip_quotes($item->meta_description),
                'site_image' => $item->thumbnail,
                'canonical' => getUrlCate($item),
                'index' => !empty($item->status) ? 'index,follow' : 'noindex,nofollow',
            ];
            break;
        case 'tag':
            $data_seo = [
                'meta_title' => strip_quotes($item->meta_title),
                'meta_keyword' => $item->meta_keyword,
                'meta_description' => strip_quotes($item->meta_description),
                'site_image' => getSiteSetting('site_logo'),
                'canonical' => getUrlCate($item),
                'index' => !empty($item->index) ? 'index,follow' : 'noindex,nofollow',
            ];
            break;
        case 'page':
            $data_seo = [
                'meta_title' => strip_quotes($item->meta_title),
                'meta_keyword' => $item->meta_keyword,
                'meta_description' => strip_quotes($item->meta_description),
                'site_image' => $item->thumbnail,
                'canonical' => getUrlStaticPage($item),
                'index' => !empty($item->status) ? 'index,follow' : 'noindex,nofollow',
                'published_time' => !empty($item->created_time) ? date('Y-m-d\TH:i:s',strtotime($item->created_time) - 1800) : '',
                'modified_time' => !empty($item->created_time) ? date('Y-m-d\TH:i:s',strtotime($item->created_time)) : '',
                'updated_time' => !empty($item->updated_time) ? date('Y-m-d\TH:i:s',strtotime($item->updated_time)) :''
            ];
            break;
        case 'post':
            $data_seo = [
                'meta_title' => strip_quotes($item->meta_title),
                'meta_keyword' => $item->meta_keyword,
                'meta_description' => strip_quotes($item->meta_description),
                'site_image' => $item->thumbnail,
                'canonical' => getUrlPost($item),
                'is_post' => true,
                'index' => 'index,follow',
                'published_time' => !empty($item->created_time) ? date('Y-m-d\TH:i:s',strtotime($item->created_time) - 1800) : '',
                'modified_time' => !empty($item->created_time) ? date('Y-m-d\TH:i:s',strtotime($item->created_time)) : '',
                'updated_time' => !empty($item->updated_time) ? date('Y-m-d\TH:i:s',strtotime($item->updated_time)) :''
            ];
            break;
        case 'home':
            $data_seo = [
                'meta_title' => strip_quotes(getSiteSetting('site_title')),
                'meta_keyword' => strip_quotes(getSiteSetting('site_keyword')),
                'meta_description' => strip_quotes(getSiteSetting('site_description')),
                'site_image' => getSiteSetting('site_logo'),
                'canonical' => env('APP_URL'),
                'index' => 'index,follow',
                'published_time' => '',
                'modified_time' => '',
                'updated_time' => ''
            ];
            break;
        default:
            $data_seo = [
                'meta_title' => strip_quotes(getSiteSetting('site_title')),
                'meta_keyword' => '',
                'meta_description' => strip_quotes(getSiteSetting('site_description')),
                'site_image' => getSiteSetting('site_logo'),
                'canonical' => url()->current(),
                'index' => 'index,follow',
                'published_time' => '',
                'modified_time' => '',
                'updated_time' => ''
            ];
            break;
    }
    return $data_seo;
}

function isMobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}

function getDataAPIPost($url, $data = []){
    $resource = curl_init();
    curl_setopt($resource, CURLOPT_URL, $url);
    curl_setopt($resource, CURLOPT_POST, true);
    curl_setopt($resource, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($resource, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($resource, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($resource,CURLOPT_TIMEOUT,10);

    $response = curl_exec($resource);
    curl_close($resource);
    return json_decode($response);
}

function getNumberLinkOut($content) {
    preg_match_all('/href="(.*?)"/', $content, $match);
    return count($match[1]);
}

function content_rss_replace($content){
    $content = preg_replace('/[\x00-\x09\x0B\x0C\x0E-\x1F\x7F]/', '', $content);
    $content = preg_replace("/\<iframe.*?\>.*?\<\/iframe\>/", "", $content);
    $content = preg_replace("/caption\=['\"].*?['\"]/", "", $content);
    $content = preg_replace("/controls\=['\"].*?['\"]/", "", $content);
    return $content;
}

function init_cms_pagination($page, $pagination){
    $content = '<ul class="pagination">';
    if ($page > 1) $content .= '<li class="page-item">
                                    <a class="page-link" href="' . getUrlPage($page-1) . '">Prev</a>
                                </li>';
    if ($page > 4) $content .= '<li class="page-item">
                                    <a class="page-link" href="' . getUrlPage(1) . '">1</a>
                                </li>
                                <li class="page-item">
                                    <span class="page-link">...</span>
                                </li>';
    for ($i = $page - 3 ; $i <= $page + 3; $i++) {
        if ($i < 1 || $i > $pagination) continue;
        $active = '';
        if ($i == $page) $active = 'active';
        $content .= '<li class="page-item ' . $active . '">
                        <a class="page-link" href="' . getUrlPage($i) . '">' . $i . '</a>
                    </li>';
    }
    if ($page < $pagination - 3) $content .= '<li class="page-item">
                                                <span class="page-link">...</span>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="' . getUrlPage($pagination) . '">' . $pagination . '</a>
                                            </li>';
    $content .= '<li class="page-item">
                    <a class="page-link" href="' . getUrlPage($page+1) . '">Next</a>
                </li>';
    $content .= '</ul>';
    echo $content;
}
function getReward($code)
{
    if ($code == 'mien-bac') {
        $data = [
            'ĐB' => [
                'count' => 1,
                'length' => 5
            ],
            'G1' => [
                'count' => 1,
                'length' => 5
            ],
            'G2' => [
                'count' => 2,
                'length' => 5
            ],
            'G3' => [
                'count' => 6,
                'length' => 5
            ],
            'G4' => [
                'count' => 4,
                'length' => 4
            ],
            'G5' => [
                'count' => 6,
                'length' => 4
            ],
            'G6' => [
                'count' => 3,
                'length' => 3
            ],
            'G7' => [
                'count' => 4,
                'length' => 2
            ],
        ];
    } elseif ($code == 'vietlott') {
        $data = [
            'G3' => [
                'count' => 6,
                'length' => 2
            ],
        ];
    } else {
        $data = [
            'G8' => [
                'count' => 1,
                'length' => 2
            ],
            'G7' => [
                'count' => 1,
                'length' => 3
            ],
            'G6' => [
                'count' => 3,
                'length' => 4
            ],
            'G5' => [
                'count' => 1,
                'length' => 4
            ],
            'G4' => [
                'count' => 7,
                'length' => 5
            ],
            'G3' => [
                'count' => 2,
                'length' => 5
            ],
            'G2' => [
                'count' => 1,
                'length' => 5
            ],
            'G1' => [
                'count' => 1,
                'length' => 5
            ],
            'ĐB' => [
                'count' => 1,
                'length' => 6
            ],
        ];
    }
    return $data;
}
function getProvince($id){
    if ($id == 14)
        $date = date('H') < 17 ? date('Y-m-d') : date('Y-m-d', strtotime("+1 day"));
    else
        $date = date('H') < 18 ? date('Y-m-d') : date('Y-m-d', strtotime("+1 day"));
    $arr_province = [
        '14' => [
            '1' => [
                'Hồ Chí Minh',
                'Đồng Tháp',
                'Cà Mau'
            ],
            '2' => [
                'Bến Tre',
                'Vũng Tàu',
                'Bạc Liêu'
            ],
            '3' => [
                'Đồng Nai',
                'Cần Thơ',
                'Sóc Trăng'
            ],
            '4' => [
                'Tây Ninh',
                'An Giang',
                'Bình Thuận'
            ],
            '5' => [
                'Vĩnh Long',
                'Bình Dương',
                'Trà Vinh'
            ],
            '6' => [
                'Hồ Chí Minh',
                'Long An',
                'Bình Phước',
                'Hậu Giang'
            ],
            '7' => [
                'Tiền Giang',
                'Kiên Giang',
                'Đà Lạt'
            ],
        ],
        '36' => [
            '1' => [
                'TT Huế',
                'Phú Yên'
            ],
            '2' => [
                'Đắk Lắk',
                'Quảng Nam'
            ],
            '3' => [
                'Đà Nẵng',
                'Khánh Hòa',
            ],
            '4' => [
                'Bình Định',
                'Quảng Trị',
                'Quảng Bình'
            ],
            '5' => [
                'Gia Lai',
                'Ninh Thuận'
            ],
            '6' => [
                'Đà Nẵng',
                'Quảng Ngãi',
                'Đắk Nông'
            ],
            '7' => [
                'Khánh Hòa',
                'Kon Tum'
            ],
        ]
    ];
    return $arr_province[$id][date('N', strtotime($date))];
}

function initVideo($url) {
    if (strpos($url, '.m3u8') !== false) {
        $url = '/video.php?url=' . $url;
    }
    $html = "<div>
                    <div class='video position-relative w-100'>
                        <iframe class='w-100 h-100 position-absolute top-0 bottom-0' src='$url' allowfullscreen></iframe>
                    </div>
                </div>";
    return $html;
}

function array_group_by(array $arr, callable $key_selector)
{
    $result = array();
    foreach ($arr as $i) {
        $key = call_user_func($key_selector, $i);
        $result[$key][] = $i;
    }
    return $result;
}

function getBanner($slug){
    $banners = config('app.banner');
    if (empty($banners[$slug])) return;

    $content = $banners[$slug][0]['content'];
    if (in_array($slug, ['popunder-pc', 'popunder-mobile', 'dat-cuoc-pc', 'dat-cuoc-mobile', 'link-xem-live-mobile', 'link-xem-live-pc'])){
        $content = preg_replace('/\/\*[\s\S]*?\*\//', '', $content);
        return strip_tags($content);
    }

    $html = $content;
    if (strpos($html, 'adsbygoogle') !== false && !IS_AMP) return trim($html);
    $html = preg_replace('/\/\*[\s\S]*?\*\//', '', $html);
    preg_match_all('/(<a[\s\S]*?<\/a>)/', $html, $arr);
    if (empty($arr[0])) return;
    $tmp = '';
    foreach ($arr[0] as $index => $item){
        if (IS_AMP){
            $item = preg_replace('/<img(.*?)>/', '<amp-img layout="fill"$1></amp-img>', $item);
        } else {
            //$item = str_replace('src=', 'data-src=', $item);
            $item = str_replace('src=', 'loading="lazy" alt="banner" src=', $item);
        }
        $tmp .= '<div class="ads-container position-relative mw-100" data-position="'.$slug.$index.'">
                    <span class="banner-close d-flex font-12 p-0 text-center position-absolute">
                        <i class="info-icon bg-white"></i>
                        <i class="close-icon bg-white" data-bs-dismiss="modal"></i>
                    </span>
                    <div class="banners">'.$item.'</div>
                </div>';
    }
    return $tmp;
}

function initRating($id, $type, $title = '', $schema = false, $show_count = true, $is_post = false) {
    $data = initRatingData($id, $type);
    $data['title'] = $title;
    $data['schema'] = $schema;
    $data['show_count'] = $show_count;
    $data['is_post'] = $is_post;
    return view('web.block._rating', $data);
}

function initRatingData($id, $type){
    $rating = Rating::where('rating_id', $id)->where('type', $type)->first();
    if (!empty($rating)) {
        $data = [
            'rating_id' => $id,
            'type' => $type,
            'avg' => round($rating->avg_rating, 1, PHP_ROUND_HALF_UP),
            'count' => $rating->count
        ];
    } else {
        $data = [
            'rating_id' => $id,
            'type' => $type,
            'avg' => 5,
            'count' => 5
        ];
        $params = [
            'rating_id' => $id,
            'type' => $type,
            'count' => 5,
            'avg_rating' => 5,
            'sum_rating' => 25
        ];
        Rating::updateOrInsert(['rating_id' => $id, 'type' => $type], $params);
    }
    if (!empty(Cookie::get('rating_'.$type.'_'.$id))) {
        $data['avg'] = Cookie::get('rating_'.$type.'_'.$id);
        $data['readonly'] = true;
    }
    return $data;
}
?>
