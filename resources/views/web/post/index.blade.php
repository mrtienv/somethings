@extends('web.layout')
@section('content')
<section class="breadcrumb-blog-version-one">

    <div class="single-bredcurms" style="background-image:url('/web/images/bercums/contact-page.jpg');">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="bredcrums-content">
                        <h2>{{$category->title}}</h2>
                        <ul>
                            <li><a href="index-2.html">Home</a></li>
                            <li class="active"><a href="blog-single.html">{{$category->title}}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section><!-- blog breadcrumb version one end here -->

<!-- Start blog -->
<section id="blog" class="section-paddings single section page">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-sm-12 col-xs-12">
                <div class="col-md-12">
                    <!-- Single blog -->
                    <div class="single-blog">
                        <div class="blog-head">
                            <img src="/web/images/blog/1.jpg" alt="#">
                        </div>
                        <div class="blog-content">
                            <h2>{{$post->title}}</h2>
                            <div class="meta">
                                <span><i class="fa fa-user"></i>Admin</span>
                                <span><i class="fa fa-calender"></i>{{$post->displayed_time}}</span>
                                <span><i class="fa fa-comments"></i>65 Comments</span>
                            </div>
                            {!! $post->content !!}
                        </div>
                    </div><!--/ End Single blog -->
                </div>
            </div>

            <div class="col-md-4 col-sm-12 col-xs-12">
                <!-- Blog Sidebar -->
                <div class="blog-sidebar">
                    <!-- Start Search Form -->
                    <div class="single-sidebar form">
                        <form class="search" action="#">
                            <input type="text" placeholder="Type To Search">
                            <div class="s-button">
                                <input type="submit" value="search">
                            </div>
                        </form>
                    </div><!--/ End Search Form -->

                    <!-- Single Sidebar -->
                    <div class="single-sidebar latest">
                        <h2>Popular Post</h2>
                        @foreach($listPost as $item)
                        <div class="single-post">
                            <div class="post-info">
                                <h4><a href="#">{{$item->title}}</a></h4>
                                <p>{{$item->displayed_time}}</p>
                            </div>
                        </div>
                        @endforeach
                    </div><!--/ End Single Sidebar -->
                </div><!--/ End Blog Sidebar -->
            </div>
        </div>
    </div>
</section>
@endsection
