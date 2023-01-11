<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Request;
use Redirect;
use App\Models\Tour;
use App\Models\Post_Category;
use Route;

class TourController extends Controller
{
    public function __construct()
    {

    }

    public function index() {
        $listItem = Tour::all();
        $data['listItem'] = $listItem;
        return view('admin.tour.index', $data);
    }

    public function add($id = 0) {
        $data = [];
        if (!empty(Request::post())) {
            Tour::insert(Request::post());
            return Redirect::to('/admin/tour');
        }
        return view('admin.tour.add', $data);
    }

    public function edit($id) {
        $data = [];
        $data['data_content'] = Tour::findOrFail($id);
        if (!empty(Request::post())) {
            Tour::where('id', $id)->update(Request::post());
            return Redirect::to('/admin/tour');
        }
        return view('admin.tour.edit', $data);
    }

    public function delete($id) {
        Tour::destroy($id);
        return back();
    }


}
