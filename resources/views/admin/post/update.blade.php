@extends('admin.layout')
@section('content')
    <main class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <form method="post" action="">
                    <input type="hidden" name="user_id" value="{{!empty($oneItem)? $oneItem->user_id: $user_id}}">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="card">
                                <div class="card-header"><strong>{{!empty($oneItem) ? 'Chỉnh sửa' : 'Thêm mới'}} Bài viết</strong>{!!!empty($oneItem) ? ' - <a rel="nofollow" target="_blank" href="'.getUrlPost($oneItem).'">'.$oneItem->title.'</a>' : ''!!}</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Tiêu đề</label>
                                                <input class="form-control" required name="title" value="{{!empty($oneItem->title) ? $oneItem->title : ''}}" type="text" placeholder="Tiêu đề">
                                            </div>
                                            <div class="form-group">
                                                <label>Mô tả</label>
                                                <textarea id="tiny-featured" class="form-control" rows="4" name="description">{{!empty($oneItem->description) ? $oneItem->description : ''}}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Nội dung</label>
                                                <textarea id="full-featured" class="form-control" name="content">{{!empty($oneItem->content) ? $oneItem->content : ''}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-4">
                            <div class="card">
                                <div class="card-header"><strong>Thông tin khác</strong></div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Thumbnail</label>
                                        @if(!empty($oneItem->thumbnail))
                                            <img src="{{$oneItem->thumbnail}}" id="lbl_img" class="img-fluid d-block" onclick="upload_file('chosefile','img')">
                                        @else
                                            <img src="{{url('admin/images/no-image.jpg')}}" id="lbl_img" class="img-fluid d-block" onclick="upload_file('chosefile','img')">
                                        @endif
                                        <input type="hidden" name="thumbnail" id="hd_img" value="{{!empty($oneItem->thumbnail)? $oneItem->thumbnail: ''}}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Chuyên mục</label>
                                        <select class="form-control" name="category_id">
                                            @foreach($categoryTree as $item)
                                            <option value="{{$item['id']}}" {{!empty($oneItem) && $item['id'] == $oneItem->category_id? 'selected': ''}}>{{$item['title']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
{{--                                    <div class="form-group">--}}
{{--                                        <label>Tag</label>--}}
{{--                                        <div id="select-multi-tag" data-post-id="{{!empty($oneItem->id) ? $oneItem->id : 0}}"></div>--}}
{{--                                    </div>--}}
                                    <div class="form-group">
                                        <label>
                                            Tiêu đề SEO
                                            <span class="text-danger" id="title-count-text">
                                                <span>Độ dài hiện tại: </span>
                                                <span id="title-count">0</span>px
                                            </span>
                                        </label>
                                        <input class="form-control" name="meta_title" value="{{!empty($oneItem->meta_title) ? $oneItem->meta_title : ''}}" type="text" placeholder="Tiêu đề SEO">
                                    </div>
                                    <div class="form-group">
                                        <label>
                                            Mô tả SEO
                                            <span class="text-danger" id="description-count-text">
                                                <span>Độ dài hiện tại: </span>
                                                <span id="description-count">0</span>px
                                            </span>
                                        </label>
                                        <textarea class="form-control" name="meta_description" rows="4" placeholder="Mô tả SEO">{{!empty($oneItem->meta_description) ? $oneItem->meta_description : ''}}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>
                                            Từ khóa SEO
                                        </label>
                                        <input class="form-control" name="meta_keyword" value="{{!empty($oneItem->meta_keyword) ? $oneItem->meta_keyword : ''}}" type="text" placeholder="Từ khóa SEO">
                                    </div>
                                    @if ($group_id == 1)
                                        <div class="form-group">
                                            <label>Trạng thái</label>
                                            <select name="status" class="form-control">
                                                <option {{isset($oneItem->status) && $oneItem->status == 1 ? 'selected' : ''}} value="1">Công khai</option>
                                                <option {{isset($oneItem->status) && $oneItem->status == 0 ? 'selected' : ''}} value="0">Bản nháp</option>
                                            </select>
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <label>Thời gian hiển thị</label>
                                        <input class="form-control" name="displayed_time" value="{{!empty($oneItem->displayed_time) ? date('Y-m-d\TH:i:s', strtotime($oneItem->displayed_time)) : date('Y-m-d\TH:i:s')}}" type="datetime-local">
                                    </div>
                                    <div class="form-group float-right">
                                        <button type="submit" class="btn btn-primary">Lưu trữ</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection
<span style="font-family: arial, sans-serif;font-size: 18px!important;position:absolute;white-space:nowrap;visibility:hidden" id="title-sizer"></span>
<span style="font-family: arial, sans-serif;font-size: 18px!important;position:absolute;white-space:nowrap;visibility:hidden;" id="title-sizer-temp"></span>
<span style="font-family: arial, sans-serif;font-size:13px;position:absolute;visibility:hidden;white-space:nowrap;" id="description-sizer"></span>
<span style="font-family: arial, sans-serif;font-size:13px;position:absolute;visibility:hidden;white-space:nowrap;" id="description-sizer-temp"></span>
