<?php
function getSchemaHome() {
    return '
    <script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "EntertainmentBusiness",
    "name": "Bet Đây Rồi",
    "alternateName": "betdayroi",
    "@id": "https://betdayroi.com/#EntertainmentBusiness",
    "logo": "https://betdayroi.com/web/images/logo.png",
    "image": "https://betdayroi.com/web/images/logo.png",
    "description": "Bet Đây Rồi ! - Địa chỉ chuyên đánh giá và xếp hạng nhà cái uy tín, trang cá cược bóng đá, casino online, game đổi thưởng tốt nhất tại Việt Nam hiện nay.",
    "url": "https://betdayroi.com/",
    "telephone": "0868-268-686",
    "email": "betdayroi.com@gmail.com",
    "priceRange": 0,
  "sameAs": [
        "https://www.youtube.com/c/Betdayroi",
        "https://www.facebook.com/betdayroi/",
        "https://www.pinterest.com/betdayroi/",
        "https://betdayroi.tumblr.com/",
        "https://www.linkedin.com/company/betdayroi-com",
        "https://twitter.com/betdayroi"
    ],
    "founders": [
        {
            "@type": "Person",
            "name": "Akari Nguyên",
            "url": "https://betdayroi.com/akari-nguyen-pt6.html",
            "image": "https://betdayroi.com/upload/admin/Betdayroi/akari-nguyen.jpg",
            "telephone": "0988-456-086",
            "email": "akaringuyen@gmail.com",
            "jobTitle": "Founders"
        }
    ]
}
</script>


<script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "WebSite",
      "url": "https://betdayroi.com/",
      "potentialAction": {
        "@type": "SearchAction",
        "target": {
          "@type": "EntryPoint",
          "urlTemplate": "https://betdayroi.com/search?q={search_term_string}"
        },
        "query-input": "required name=search_term_string"
      }
    }
    </script>
<script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "LocalBusiness",
 "url": "https://betdayroi.com/",
      "image": "https://betdayroi.com/web/images/logo.png",
      "name": "Bet Đây Rồi",
"telephone": "0868-268-686",
     "address": {
        "@type": "PostalAddress",
        "streetAddress": "16 Trần Hữu Tước, Nam Đồng",
        "addressLocality": "Đống Đa",
        "addressRegion": "Hà Nội",
        "postalCode": "100000",
        "addressCountry": "VN"
    },
    "geo": {
        "@type": "GeoCoordinates",
        "latitude": 21.0172962,
        "longitude": 105.8297063
    },
    "openingHoursSpecification": {
        "@type": "OpeningHoursSpecification",
        "dayOfWeek": [
            "Monday",
            "Tuesday",
            "Wednesday",
            "Thursday",
            "Friday",
            "Saturday",
            "Sunday"
        ],
        "opens": "08:00",
        "closes": "21:00"
    }
}
    </script>
    ';
}
function getSchemaBreadCrumb($breadCrumb){
    $itemListElement = [];
    foreach ($breadCrumb as $key => $item) {
        $itemListElement[] = [
            '@type' => 'ListItem',
            'position' => $key + 1,
            'name' => $item['name'],
            'item' => $item['item']
        ];
    }
    $schema = '<script type="application/ld+json">';
    $schema .= json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => $itemListElement
    ]);
    $schema .= '</script>';
    return $schema;
}
function getSchemaNewsArticle($oneItem) {
    return '
      <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "NewsArticle",
      "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "'.getUrlPost($oneItem).'"
      },
      "headline": "'.$oneItem->title.'",
       "description": "'.$oneItem->meta_description.'",
      "image":
{
"@type": "ImageObject",
 "url": "'.url($oneItem->thumbnail).'"},

      "datePublished": "'.date('c', strtotime($oneItem->displayed_time)).'",
      "dateModified": "'.date('c', strtotime($oneItem->updated_time)).'",
      "author": {
        "@type": "Person",
        "name": "Akari Nguyên",
        "url": "https://betdayroi.com/akari-nguyen-pt6.html"
      },
      "publisher": {
        "@type": "EntertainmentBusiness",
        "name": "Bet Đây Rồi",
        "logo": {
          "@type": "ImageObject",
          "url": "https://betdayroi.com/web/images/logo.png"
        }
      }
    }
    </script>
    ';
}
?>
