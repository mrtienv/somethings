@extends('admin.layout')
@section('content')
    <main class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <form method="post" action="">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header"><strong>Chỉnh sửa Tour</strong></div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Tên Tour</label>
                                                <input type="text" id="tiny-featured" class="form-control tiny-featured" rows="4" name="name" placeholder="{{!empty($data_content->name) ? $data_content->name : ''}}">
                                            </div>
                                            <div class="form-group">
                                                <label id="time">Thời gian</label>
                                                <input class="form-control" rows="4" name="time" type="text" value="" placeholder="{{!empty($data_content->time) ? $data_content->time : ''}}"
                                                       min="1997-01-01" max="2030-31-12">
                                            </div>
                                            <div class="form-group">
                                                <label>Giá Tour</label>
                                                <input type="text" class="form-control" rows="4" name="price" placeholder="{{!empty($data_content->price) ? $data_content->price : ''}}">
                                            </div>
                                            <div class="form-group">
                                                <label>Link chi tiết</label>
                                                <input type="text" class="form-control" rows="4" name="link" placeholder="{{!empty($data_content->link) ? $data_content->link : ''}}">
                                            </div>
                                            <div class="form-group float-right">
                                                <button type="submit" class="btn btn-primary">Lưu trữ</button>
                                            </div>
                                        </div>
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
