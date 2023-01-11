@extends('admin.layout')
@section('content')
    <main class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <form method="post" action="">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="card">
                                <div class="card-header"><strong>{{!empty($oneItem) ? 'Chỉnh sửa' : 'Thêm mới'}} Thông tin trang</strong></div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Tiêu đề trang</label>
                                                <input class="form-control" name="site_title" value="{{!empty($oneItem->site_title) ? $oneItem->site_title : ''}}" type="text" placeholder="Tiêu đề trang">
                                            </div>
                                            <div class="form-group">
                                                <label>Mô tả trang</label>
                                                <textarea class="form-control" name="site_description" rows="4" placeholder="Mô tả trang">{{!empty($oneItem->site_description) ? $oneItem->site_description : ''}}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Từ khoá SEO</label>
                                                <textarea class="form-control" name="site_keyword" rows="4" placeholder="Từ khoá SEO">{{!empty($oneItem->site_keyword) ? $oneItem->site_keyword : ''}}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Giới thiệu trang</label>
                                                <textarea id="full-featured" class="form-control" name="site_about">{{!empty($oneItem->site_about) ? $oneItem->site_about : ''}}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Thông tin Footer</label>
                                                <textarea id="tiny-featured" class="form-control" name="site_content_footer" rows="4" placeholder="Thông tin Footer">{{!empty($oneItem->site_content_footer) ? $oneItem->site_content_footer : ''}}</textarea>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3">
                                                    <label>Facebook</label>
                                                    <input type="text" class="form-control" name="site_facebook" value="{{!empty($oneItem->site_facebook) ? $oneItem->site_facebook : ''}}" placeholder="Facebook">
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Youtube</label>
                                                    <input type="text" class="form-control" name="site_youtube" value="{{!empty($oneItem->site_youtube) ? $oneItem->site_youtube : ''}}" placeholder="Youtube">
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Twitter</label>
                                                    <input type="text" class="form-control" name="site_twitter" value="{{!empty($oneItem->site_twitter) ? $oneItem->site_twitter : ''}}" placeholder="Twitter">
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Pinterest</label>
                                                    <input type="text" class="form-control" name="site_pinterest" value="{{!empty($oneItem->site_pinterest) ? $oneItem->site_pinterest : ''}}" placeholder="Pinterest">
                                                </div>
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
                                        <label>Logo</label>
                                        @if(!empty($oneItem->site_logo))
                                            <img src="{{$oneItem->site_logo}}" id="lbl_img" class="img-fluid d-block" onclick="upload_file('chosefile','img')">
                                        @else
                                            <img src="{{url('admin/images/no-image.jpg')}}" id="lbl_img" class="img-fluid d-block" onclick="upload_file('chosefile','img')">
                                        @endif
                                        <input type="hidden" id="hd_img" name="site_logo" value="{{!empty($oneItem->site_logo)? $oneItem->site_logo: ''}}" required>
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
