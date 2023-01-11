<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;

class CategoryController extends Controller
{
    public function index($slug, $id=1) {
        $category = Category::find($id);
        $data['category'] = $category;
        $data['date'] = date("l j/n/Y");
        $listPost = Post::with('user')->where('category_id', $id)->limit(10)->get();
        $data['listPost'] = $listPost;

        return view('web.category.index', $data);
    }
}
