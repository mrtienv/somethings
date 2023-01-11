<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
    <div class="c-sidebar-brand d-lg-down-none">
        <svg class="c-sidebar-brand-full" width="118" height="46" alt="CoreUI Logo">
            <use xlink:href="/admin/images/icon-svg/coreui.svg#full"></use>
        </svg>
        <svg class="c-sidebar-brand-minimized" width="46" height="46" alt="CoreUI Logo">
            <use xlink:href="/admin/images/icon-svg/coreui.svg#signet"></use>
        </svg>
    </div>
    <ul class="c-sidebar-nav ps ps--active-y">
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="/admin/home">
                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="/admin/images/icon-svg/free.svg#cil-speedometer"></use>
                </svg>
                Dashboard
            </a>
        </li>
        @if(!empty($permission['category']))
        <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
            <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="/admin/images/icon-svg/free.svg#cil-list"></use>
                </svg>
                Quản lý Chuyên mục
            </a>
            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/admin/category"><span class="c-sidebar-nav-icon"></span> Danh sách</a></li>
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/admin/category/update"><span class="c-sidebar-nav-icon"></span> Thêm mới</a></li>
            </ul>
        </li>
        @endif
        @if(!empty($permission['post']))
        <li class="c-sidebar-nav-item c-sidebar-nav-dropdown @if(getCurrentController() == 'post') c-show @endif">
            <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="/admin/images/icon-svg/free.svg#cil-description"></use>
                </svg>
                Quản lý Bài viết
            </a>
            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link @if(!empty($_GET['status']) && empty($_GET['hen_gio'])) c-active @endif" href="/admin/post?status=1"><span class="c-sidebar-nav-icon"></span> Danh sách bài viết</a></li>
{{--                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link @if(!empty($_GET['status']) && !empty($_GET['hen_gio'])) c-active @endif" href="/admin/post?status=1&hen_gio=1"><span class="c-sidebar-nav-icon"></span> Bài viết hẹn giờ</a></li>--}}
{{--                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link @if(isset($_GET['status']) && $_GET['status'] == 0) c-active @endif" href="/admin/post?status=0"><span class="c-sidebar-nav-icon"></span> Bài viết lưu nháp</a></li>--}}
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/admin/post/update"><span class="c-sidebar-nav-icon"></span> Thêm mới</a></li>
            </ul>
        </li>
        @endif
        @if(!empty($permission['tour']))
            <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
                <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="/admin/images/icon-svg/free.svg#cil-list"></use>
                    </svg>
                    Quản lý Tour
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/admin/tour"><span class="c-sidebar-nav-icon"></span> Danh sách</a></li>
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/admin/tour/add"><span class="c-sidebar-nav-icon"></span> Thêm mới</a></li>
                </ul>
            </li>
        @endif

        @if(!empty($permission['user']))
        <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
            <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="/admin/images/icon-svg/free.svg#cil-user"></use>
                </svg>
                Quản lý Thành viên
            </a>
            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/admin/user"><span class="c-sidebar-nav-icon"></span> Danh sách</a></li>
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/admin/user/update"><span class="c-sidebar-nav-icon"></span> Thêm mới</a></li>
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/admin/group"><span class="c-sidebar-nav-icon"></span> Danh sách nhóm quyền</a></li>
            </ul>
        </li>
        @endif

        @if(!empty($permission['site_setting']))
            <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
                <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="/admin/images/icon-svg/free.svg#cil-settings"></use>
                    </svg>
                    Cài đặt chung
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/admin/menu"><span class="c-sidebar-nav-icon"></span> Cấu hình Menu</a></li>
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/admin/site_setting/update"><span class="c-sidebar-nav-icon"></span> Thông tin trang</a></li>
                </ul>
            </li>
        @endif
    </ul>
    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>
</div>
