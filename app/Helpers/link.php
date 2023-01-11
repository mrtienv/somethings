<?php
function getUrlPost($item, $is_amp = 0){
    $slug = "$item->slug-p$item->id.html";
    if ($is_amp)
        $slug .= "?amp";
    return url($slug);
}
function getUrlCate($item, $is_amp = 0){
    $slug = "$item->slug-c$item->id";
    if ($is_amp)
        $slug .= "?amp";
    return url($slug);
}
function getUrlTag($item, $is_amp = 0){
    $slug = "$item->slug-t$item->id";
    if ($is_amp)
        $slug .= "?amp";
    return url($slug);
}
function getUrlStaticPage($item, $is_amp = 0) {
    $slug = "$item->slug-pt$item->id.html";
    if ($is_amp)
        $slug .= "?amp";
    return url($slug);
}
function getUrlPage($page) {
    $parts = parse_url($_SERVER['REQUEST_URI']);
    parse_str($parts['query'], $query);
    $query['page'] = $page;
    return $parts['path'].'?'.http_build_query($query);
}
function tableOfContent($content) {
    preg_match_all('/<(h2|h3)(.*?)<\/(h2|h3)>/', $content, $headings);
    $index_h2 = 0;
    $index_h3 = 0;
    $main_content = '';
    foreach ($headings[0] as $heading) {
        $title = strip_tags($heading);
        $slug = toSlug($title);
        if (strpos($heading, '</h2>') !== false) {
            $replace_heading = str_replace('<h2', '<h2 id="' . $slug . '"', $heading);
            $content = str_replace($heading, $replace_heading, $content);
            $index_h2++;
            $index_h3 = 0;
            $main_content .= '<a rel="nofollow" href="#' . $slug . '" class="text-blue1 py-1 d-block" title="' . $title . '">' . $title . '</a>';
        } else {
            $replace_heading = str_replace('<h3', '<h3 id="' . $slug . '"', $heading);
            $content = str_replace($heading, $replace_heading, $content);
            $index_h3++;
            $main_content .= '<a rel="nofollow" href="#' . $slug . '" class="text-blue1 ps-4 py-1 d-block" title="' . $title . '">' . $title . '</a>';
        }
    }
    $box_main_content = "<div class=\"d-inline-block py-3 px-4 bg-yellow7 my-3 table_of_content\">
                            <p class=\"text-uppercase collapsible m-0 collapsible-active\">nội dung chính</p>
                            <div class='collapsible-content' style=\"max-height: 1200px\">
                            ".$main_content."
                            </div>
                        </div>
                        <div class=\"news-content\">".$content."</div>";
    return $box_main_content;
}

function getUrlAuthor($item, $is_amp = IS_AMP){
    $slug = "author/$item->slug_author";
    if ($is_amp)
        $slug .= "/amp";
    return url($slug).'/';
}
?>
