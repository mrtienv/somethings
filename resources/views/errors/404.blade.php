@extends('web.layout')
@section('content')
    <section class="container">
        <div class="row">
            <div class="col-12 col-lg-6">
                <img class="w-100 m-auto h-auto" src="{{url('web/images/404-error.svg')}}" alt="Page not found." style="max-width: 400px;">
            </div>
            <div class="col-12 col-lg-6">
                <h1 class="font-weight-bold fs-30 my-4 text-center">404</h1>
                <h2 class="font-weight-bold fs-20 my-4 text-center">Oops! Page not found.</h2>
                <p>The page you're looking for has not been found. Please, proceed by using our navigation or search.</p>
            </div>
        </div>
    </section>
@endsection
