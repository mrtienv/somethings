<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = 'post';
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function categories(){
        return $this->belongsToMany(Category::class, 'post_category', 'post_id', 'category_id');
    }

    static function getPosts($params) {
        extract($params);
        $data = self::where([
            'status' => 1,
            ['displayed_time', '<=', Post::raw('NOW()')]
        ]);

        if (isset($category_id)) {
            $data = $data->join('post_category', 'post_category.post_id', '=', 'post.id');
            $data = $data->where('post_category.category_id', $category_id);
            if (!empty($only_primary_category)) {
                $data = $data->where('post_category.is_primary', 1);
            }
        }

        if (isset($info_category)) {
            $data = $data->with('category');
        }

        $offset = $offset ?? 0;
        $limit = $limit ?? 10;

        $data = $data->orderBy('post.displayed_time', 'desc')
            ->offset($offset)
            ->limit($limit)
            ->get();
        return $data;
    }

    static function getCount($params) {
        extract($params);
        $data = self::where([
            'status' => 1,
            ['displayed_time', '<=', Post::raw('NOW()')]
        ]);

        if (isset($category_id)) {
            $data = $data->join('post_category', 'post_category.post_id', '=', 'post.id');
            $data = $data->where('post_category.category_id', $category_id);
            if (!empty($only_primary_category)) {
                $data = $data->where('post_category.is_primary', 1);
            }
        }

        return $data->count();
    }

    static function get_list_match($params){
        extract($params);
        $offset = $offset ?? 0;
        $limit = $limit ?? 10;
        $order_by = $order_by ?? ['match.scheduled' => 'ASC'];
        $res = DB::table('post')->select('post.*', 'scheduled', 'tournament', 'team_home_name', 'team_home_logo', 'team_away_name', 'team_away_logo', 'hdc_asia', 'hdc_eu', 'hdc_tx')
            ->join('match', 'post.id_bongdalu', '=', 'match.id_bongdalu');
        if (!empty($category_id)) {
            $res = $res->where('category_id', $category_id);
        }
        $res = $res->where('status', 1);
        $res = $res->where('displayed_time', '<=', Post::raw('NOW()'));
        if (!empty($scheduled_after)) {
            $res = $res->where('match.scheduled', '>=', $scheduled_after);
        } elseif (!empty($scheduled_before)) {
            $res = $res->where('match.scheduled', '<=', $scheduled_before);
        } else {
            $res = $res->where('match.scheduled', '>', Post::raw('(NOW() - INTERVAL 2 HOUR)'));
        }
        if (!empty($not_in)) foreach ($not_in as $key => $value) {
            $res = $res->whereNotIn($key, $value);
        }
        foreach ($order_by as $key => $value) {
            $res = $res->orderBy($key, $value);
        }
        $res = $res->limit($limit, $offset);
        $res = $res->get();
        return $res;
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}

