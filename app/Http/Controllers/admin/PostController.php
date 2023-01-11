<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Request;
use Redirect;
use App\Models\Post;
use App\Models\Category;
//use App\Models\Post_tag;
use App\Models\Post_Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class   PostController extends Controller
{
    public function __construct()
    {

    }

    public function index() {
        $limit = 10;
        $count = Post::count();
        $pagination = (int) ceil($count/$limit);
        #
        $page = !empty($_GET['page']) ? $_GET['page'] : 1;
        #
        $condition = [];

        if (isset($_GET['status'])) {
            $condition[] = ['status', $_GET['status']];
        }
        if (!empty($_GET['hen_gio'])) {
            $condition[] = ['displayed_time', '>', Post::raw('NOW()')];
        } elseif (!empty($_GET['status'])) {
            $condition[] = ['displayed_time', '<=', Post::raw('NOW()')];
        }
        if (!empty($_GET['keyword'])) {
            $condition[] = ['slug_search', 'LIKE', '%'.toSlug($_GET['keyword']).'%'];
        }
        if (!empty($_GET['category_id'])) {
            $condition[] = ['category_id', $_GET['category_id']];
        }
        if (!empty($_GET['user_id'])) {
            $condition[] = ['user_id', $_GET['user_id']];
        }
        #

        $data['categoryTree'] = Category::getTree();
        $data['listUser'] = User::where('status', 1)->get();
        #
        $listItem = Post::where($condition)->orderBy('displayed_time', 'DESC')->offset(($page-1)*$limit)->limit($limit)->get();
        $data['total'] = Post::where($condition)->count();

        $data['listItem'] = $listItem;
        $data['pagination'] = $pagination;
        $data['page'] = $page;
        return view('admin.post.index', $data);
    }

    public function update($id = 0) {
        $data['categoryTree'] = Category::getTree();
        $data['user_id'] = Auth::id();
        $data['group_id'] = Auth::user()->group_id;

        if ($id > 0) {
            $data['oneItem'] = $oneItem = Post::findOrFail($id);
            $data['optional'] = json_decode($oneItem->optional);
        }
        if (!empty(Request::post())) {
            $post_data = Request::post();
            if (empty($post_data['slug'])) $post_data['slug'] = toSlug($post_data['title']);
            $post_data['slug_search'] = toSlug($post_data['title']);
            $post_data['count_link_out'] = getNumberLinkOut($post_data['description'].$post_data['content']);
            if (!empty($post_data['category_id'])) {
                $category_id = $post_data['category_id'];
            }
            Post::updateOrInsert(['id' => $id], $post_data);
            if ($id == 0) $id = DB::getPdo()->lastInsertId();
            if (!empty($category_id)) {
                Post_Category::where('post_id', $id)->delete();
                Post_Category::insert(['post_id' => $id, 'category_id' => $category_id]);
            }

            return Redirect::to('/admin/post?status=1');
        }
        return view('admin.post.update', $data);
    }

    public function delete($id) {
        Post::destroy($id);
        //Post_tag::where('post_id', $id)->delete();
        Post_Category::where('post_id', $id)->delete();
        return back();
    }
}
