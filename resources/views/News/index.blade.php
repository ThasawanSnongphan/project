@extends('layout')
@section('title', 'Home')
@section('content')
    {{-- <h2 class="m-2">ข่าวประชาสัมพันธ์</h2> --}}
    {{-- <a href="/create" class="btn btn-primary">เพิ่มข่าวประชาสัมพันธ์</a> --}}
    {{-- <div class="row">
        @foreach ($news as $new)
        <div class="col mt-3">
            <div class="card" style="width: 18rem;">
                <img src="{{ Storage::url('images/' . $new->img)}}" class="card-img-top"> --}}
    {{-- <p>{{dd(Storage::url('app/public/images/' . $new->img)) }}</p> --}}
    {{-- <div class="card-body">
                    <h5 class="card-title">{{ $new->title }}</h5>
                    <p class="card-text">{{ $new->content }}</p>
                    <a href="{{route('edit',$new->id)}}" class="btn btn-warning">แก้ไข</a>
                    <a href="{{route('delete',$new->id)}}" class="btn btn-danger" 
                       onclick="return confirm('ต้องการลบข่าว {{$new->title}} หรือไม่')" >ลบ
                    </a>
                </div>
            </div>
        </div>
    @endforeach
    </div> --}}

    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <!-- page content -->
                <div role="main">
                    <div class="">
                        <div class="page-title">
                            <div class="title_left">
                                <h3> ข่าวประชาสัมพันธ์ </h3>
                            </div>

                            <div class="title_right">
                                <div class="col-md-5 col-sm-5   form-group pull-right top_search">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search for...">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button">Go!</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>ข่าวประชาสัมพันธ์</h2>
                                        <ul class="nav navbar-right panel_toolbox">
                                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                            </li>
                                            <li class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                                                    role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="#">Settings 1</a>
                                                    <a class="dropdown-item" href="#">Settings 2</a>
                                                </div>
                                            </li>
                                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                                            </li>
                                        </ul>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">

                                        <div class="row">
                                            @foreach ($news as $new)
                                            <div class="col-md-55">
                                                <div class="thumbnail">
                                                    <div class="image view view-first">
                                                        <img style="width: 100%; display: block;" src="{{ Storage::url($new->img)}}"
                                                             />
                                                        <div class="mask">
                                                            <p>Your Text</p>
                                                            <div class="tools tools-bottom">
                                                                <a href="#"><i class="fa fa-link"></i></a>
                                                                <a href="{{route('news.edit',$new->id)}}"><i class="fa fa-pencil"></i></a>
                                                                <a href="{{route('news.delete',$new->id)}}" onclick="return confirm('ต้องการลบข่าว {{$new->title}} หรือไม่')" ><i class="fa fa-times"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="caption">
                                                        <p>{{ $new->content }}</p>
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
