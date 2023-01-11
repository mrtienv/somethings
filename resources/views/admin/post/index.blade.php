@extends('admin.layout')
@section('content')
    <main class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <div class="card">
                    <div class="card-header">
                        Danh sách bài viết ({{$total}})
                        <div class="card-header-actions pr-1">
                            <a href="/admin/post/update"><button class="btn btn-block btn-primary btn-sm mr-3" type="button">Thêm mới</button></a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="get" action="">
                            <div class="form-group row">
                                <div class="col-2">
                                    <select name="status" class="form-control sl-type-post">
                                        <option value="/admin/post?status=1" {{!empty($_GET['status']) && $_GET['status'] == 1 ? "selected" : ""}}>Đã đăng</option>
                                        <option value="/admin/post?status=1&hen_gio=1" {{!empty($_GET['hen_gio']) && $_GET['hen_gio'] == 1 ? "selected" : ""}}>Hẹn giờ</option>
                                        <option value="/admin/post?status=0" {{!empty($_GET['status']) && $_GET['status'] == 0 ? "selected" : ""}}>Lưu nháp</option>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <input type="text" value="{{$_GET['keyword'] ?? ''}}" name="keyword" class="form-control" placeholder="Từ khóa">
                                </div>
                                <div class="col-2">
                                    <select name="category_id" class="form-control">
                                        <option value="">Chuyên mục</option>
                                        @foreach($categoryTree as $item)
                                            <option value="{{$item['id']}}" {{!empty($_GET['category_id']) && $item['id'] == $_GET['category_id'] ? 'selected': ''}}>{{$item['title']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-2">
                                    <select name="user_id" class="form-control">
                                        <option value="">Thành viên</option>
                                        @foreach($listUser as $item)
                                            <option value="{{$item['id']}}" {{!empty($_GET['user_id']) && $item['id'] == $_GET['user_id'] ? 'selected': ''}}>{{$item['username']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="hidden" name="status" value="{{$_GET['status']}}">
                                <div class="col-2">
                                    <input type="submit" class="btn btn-success" value="Tìm kiếm">
                                </div>
                            </div>
                        </form>
                        <table class="table table-striped table-bordered datatable">
                            <thead>
                            <tr>
                                <th class="text-center w-5">ID</th>
                                <th class="text-center w-15">Tiêu đề</th>
                                <th class="text-center w-15">Chuyên mục</th>
                                <th class="text-center w-15">Ngày đăng bài</th>
                                <th class="text-center w-15">Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($listItem)) @foreach($listItem as $item)
                            <tr>
                                <td class="text-center">{{$item->id}}</td>
                                <td><a target="_blank" rel="nofollow" href="{{getUrlPost($item)}}">{{$item->title}}</a></td>
                                <td class="text-center">{{$categoryTree[$item->category_id]['title']}}</td>
                                <td class="text-center">{{date('d-m-Y H:i', strtotime($item->displayed_time))}}</td>
                                <td class="text-center">
                                    <a class="btn btn-info" href="/admin/post/update/{{$item->id}}">
                                        <svg class="c-icon">
                                            <use xlink:href="/admin/images/icon-svg/free.svg#cil-pencil"></use>
                                        </svg>
                                    </a>
                                    <a class="btn btn-danger" onclick="return confirm('Bạn có chắc muốn xóa?')"
                                       href="/admin/post/delete/{{$item->id}}">
                                        <svg class="c-icon">
                                            <use xlink:href="/admin/images/icon-svg/free.svg#cil-trash"></use>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                            @endforeach @endif
                            </tbody>
                        </table>
                        @php init_cms_pagination($page, $pagination) @endphp
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
