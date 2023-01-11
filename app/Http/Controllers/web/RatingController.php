<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Cookie;

class RatingController extends Controller
{

    public function rating() {
        $post = Request::post();

        if (!Cookie::get('rating_'.$post['type'].'_'.$post['rating_id'])) {
            Cookie::queue('rating_'.$post['type'].'_'.$post['rating_id'], $post['star']);
            $post['count'] = 1;
            $post['avg_rating'] = $post['star'];
            $post['sum_rating'] = $post['star'];
            $rating = Rating::where('rating_id', $post['rating_id'])->where('type', $post['type'])->first();
            if (!empty($rating)) {
                $post['count'] = $rating->count + 1;
                $post['sum_rating'] = $rating->sum_rating + $post['star'];
                $post['avg_rating'] = $post['sum_rating'] / $post['count'];
            }
            unset($post['star']);
            Rating::updateOrInsert(['rating_id' => $post['rating_id'], 'type' => $post['type']], $post);

            $response = initRatingData($post['rating_id'], $post['type']);

            $response['message'] = 'Vote thành công!';

            return Response::json($response);
        }
    }
}
