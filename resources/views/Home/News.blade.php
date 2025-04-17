@extends('layout')
@section('title', 'Home')
@section('content')

    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <!-- page content -->
                <div role="main">
                    <div class="">
                        

                        <div class="clearfix"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="x_panel">
                                    <div class="x_title ">
                                        <h2>ข่าวประชาสัมพันธ์</h2>
                                        <ul class="nav navbar-right panel_toolbox">
                                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li> 
                                        </ul>

                                        <div class="clearfix"></div>
                                    </div>

                                    <div class="x_content">
                                        <div class="row">
                                            @foreach ($data['news'] as $new)
                                                <div class="col-md-55">
                                                    <div class="thumbnail">
                                                        <div class="image view view-first">
                                                            {{-- {{dd(asset('public/images/News' . $new->img))}} --}}
                                                            <a href="/newsDetail/{{ $new->id }}"><img
                                                                    style="width: 100%; display: block;"
                                                                    src="{{ asset('images/News/' . $new->img) }}" /></a>

                                                        </div>
                                                        <div class="caption">
                                                            <a href="/newsDetail/{{ $new->id }}">{{ $new->content }}</a>
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
            </div>
        </div>
    </body>



@endsection
