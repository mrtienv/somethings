@extends('web.layout')
@section('content')
    <section class="container">
        <div class="row">
            <main class="col-12 col-lg-9 container g-2 g-lg-3">
                {{--<nav class="col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/" title="Home">Home</a></li>
                        <li class="breadcrumb-item">
                            <a href="{{getUrlCate($oneItem)}}" title="{{$oneItem->title}}">{{$oneItem->title}}</a>
                        </li>
                    </ol>
                </nav>--}}

                <h1 class="title-border-left my-3 fs-24">{{$oneItem->title}}</h1>

                @if(!empty($class))
                <section class="row mx-0">
                    <div class="col-12 px-0 {{$class}}">
                        {!! $data_top !!}
                    </div>
                </section>
                @endif

                @if ($oneItem->id == 60)
                    @include('web.spin_lottery._mb', ['title' => 'Quay thử xổ số miền Bắc', 'id' => 0])
                @endif

                @if(($oneItem->id >= 8 && $oneItem->id <= 13) || ($oneItem->id >= 51 && $oneItem->id <= 57))
                    @include('web.spin_lottery._mb', ['title' => $oneItem->title, 'id' => $oneItem->id])
                @elseif($oneItem->id == 14 || $oneItem->id == 36)
                    @include('web.spin_lottery._mt_mn', ['title' => $oneItem->title, 'list_province' => getProvince($oneItem->id), 'id' => $oneItem->id])
                @elseif($oneItem->id >= 15 && $oneItem->id <= 50)
                    @include('web.spin_lottery._province', ['title' => $oneItem->title, 'id' => $oneItem->id])
                @elseif($oneItem->id == 58)
                    @include('web.spin_lottery._vietlott', ['title' => $oneItem->title, 'id' => $oneItem->id])
                @endif

                <p class="description my-3">{{$oneItem->description}}</p>
                <div class="news-content">{!! $oneItem->content !!}</div>
            </main>

            @include('web.block._sidebar')
        </div>
    </section>
@endsection
