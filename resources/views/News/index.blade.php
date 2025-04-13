@extends('layout')
@section('title', 'Home')
@section('content')

    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <!-- page content -->
                <div role="main">
                    <div class="">


                        @if (Auth::check() && auth()->user() && auth()->user()->Admin == 1)
                            @include('News.create')
                        @endif
                        <div class="row">
                            <div class="col-md-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>ข่าวประชาสัมพันธ์</h2>
                                        <ul class="nav navbar-right panel_toolbox">
                                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                            </li>

                                        </ul>
                                        <div class="clearfix"></div>
                                    </div>

                                    <div class="x_content">
                                        <div class="row">
                                            @foreach ($news as $new)
                                                {{-- <div class="card  mb-3" style="max-width: 18rem;margin: 1%">
                                                    <div class="card-header bg-transparent ">
                                                        <a href="/newsDetail/{{ $new->id }}"><img
                                                                style="width: 100%; display: block;"
                                                                src="{{ asset('images/News/' . $new->img) }}" /></a>
                                                    </div>
                                                    <div class="card-body">
                                                        <h5 class="card-title"><a href="/newsDetail/{{ $new->id }}">{{ $new->title }}</a></h5>
                                                        
                                                    </div>
                                                    <div class="card-footer bg-transparent d-flex justify-content-end">

                                                        <a href="{{ route('news.edit', $new->id) }}"><i
                                                                class="fa fa-pencil btn btn-warning"></i></a>
                                                        <a href="{{ route('news.delete', $new->id) }}"
                                                            onclick="return confirm('ต้องการลบข่าว {{ $new->title }} หรือไม่')"><i
                                                                class="fa fa-times btn btn-danger"></i></a>

                                                    </div>
                                                </div> --}}
                                                {{-- <div class="card" style="width: 18rem;margin: 1%">
                                                    <div class="image view view-first " style="width: 100%;max-height: 50%">
                                                        <a href="/newsDetail/{{ $new->id }}"><img
                                                                style="width: 100%; display: block;"
                                                                src="{{ asset('images/News/' . $new->img) }}" /></a>

                                                    </div>
                                                    <div class="card-body">
                                                        <h6 class="card-title">
                                                            <a href="/newsDetail/{{ $new->id }}">{{ $new->title }}</a>
                                                        </h6>
                                                       
                                                    </div>
                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item">
                                                            
                                                            <div class="d-flex justify-content-end ">
                                                                <a href="{{ route('news.edit', $new->id) }}"><i
                                                                        class="fa fa-pencil btn btn-warning"></i></a>
                                                                <a href="{{ route('news.delete', $new->id) }}"
                                                                    onclick="return confirm('ต้องการลบข่าว {{ $new->title }} หรือไม่')"><i
                                                                        class="fa fa-times btn btn-danger"></i></a>
                                                            </div>
                                                        </li>

                                                    </ul>
                                                    <div class="card-body">
                                                        <a href="#" class="card-link">Card link</a>
                                                        <a href="#" class="card-link">Another link</a>
                                                    </div>
                                                </div> --}}
                                                <div class="col-md-4">
                                                    <div class="thumbnail m-2">
                                                        <div class="image view view-first">
                                                            <a href="/newsDetail/{{ $new->id }}"><img
                                                                    style="width: 100%; display: block; "
                                                                    src="{{ asset('images/News/' . $new->img) }}" /></a>

                                                        </div>
                                                        {{-- <div class=""> --}}
                                                        <a href="/newsDetail/{{ $new->id }}">{{ $new->title }}</a>

                                                        {{-- </div> --}}
                                                        <div class="d-flex justify-content-end m-2">
                                                            <a href="{{ route('news.edit', $new->id) }}"><i
                                                                    class="fa fa-pencil btn btn-warning"></i></a>
                                                            <a href="{{ route('news.delete', $new->id) }}"
                                                                onclick="return confirm('ต้องการลบข่าว {{ $new->title }} หรือไม่')"><i
                                                                    class="fa fa-times btn btn-danger"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>






                    </div>
                </div>
                <!-- /page content -->
            </div>
        </div>
    </body>



@endsection
