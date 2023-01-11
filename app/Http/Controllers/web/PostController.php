<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
class PostController extends Controller
{
    public function index($slug, $id=1)
    {
        $oneItem = Post::findOrFail($id);
        $post = Post::with('user')->find($id);
        $data['category'] = $category = Category::find($oneItem->category_id);
        $data['post'] = $post;
        $data['date'] = date('l j/n/Y');
        $data['listPost'] = Post::orderBy('id', 'DESC')->limit(6)->get();
        return view('web.post.index', $data);
    }
}
