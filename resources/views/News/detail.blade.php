@extends('layout')
@section('title', 'News')
@section('content')

    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <!-- page content -->
                <div role="main">
                    <div class="">
                        <div class="page-title">
                            <div class="title_left">
                                <h3>ข่าวประชาสัมพันธ์ </h3>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="x_panel">
                                    <div class="x_title ">
                                        <h2>รายละเอียดข่าวประชาสัมพันธ์</h2>
                                        <ul class="nav navbar-right panel_toolbox">
                                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                        </ul>

                                        <div class="clearfix"></div>
                                    </div>

                                    <div class="x_content">
                                        {{-- <div class="col-lg-2"></div> --}}
                                        {{-- <div class="col-lg-8"> --}}
                                            <div class="card mb-3">
                                                <img class="card-img-top"
                                                    style="max-width: 100%; max-height: 500px; height: auto; width: auto; object-fit: cover;"
                                                    src="{{ asset('images/News/' . $data['newsDetail']->img) }}">
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ $data['newsDetail']->title }}</h5>
                                                    <p class="card-text">{{ $data['newsDetail']->content }}</p>
                                                    <p class="card-text"><small
                                                            class="text-muted">{{ $data['newsDetail']->updated_at }}</small>
                                                    </p>
                                                </div>
                                            </div>
                                        {{-- </div> --}}
                                        {{-- <div class="col-lg-2"></div> --}}

                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="ln_solid">
                                        <a href="/" style="float: right"><i class="fa fa-arrow-left"> back</i></a>
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
