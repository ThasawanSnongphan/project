@extends('layout')
@section('title', 'AddNews')
@section('content')
    {{-- <h2 class="m-2">เพิ่มข่าวประชาสัมพันธ์</h2>
    <form method="POST" action="/insert">
        @csrf
        <div class="form-group m-2">
            <label for="title">หัวข้อข่าว</label>
            <input type="text" name="title" id="title" class="form-control">
        </div>
        @error('title')
            <div class="m-2">
                <span class="text text-danger">{{$message}}</span>
            </div>
        @enderror
        <div class="form-group m-2">
            <label for="content">รายละเอียดข่าว</label>
            <textarea name="content" id="content" rows="5" class="form-control"></textarea>
        </div>
        @error('content')
            <div class="m-2">
                <span class="text text-danger">{{$message}}</span>
            </div>
        @enderror
        <div class="form-group m-2">
            <label for="img">รูป</label>
            <input type="file" name="img" id="img" class="form-control">
        </div>
        <input type="submit" value="บันทึก" class="btn btn-primary m-2">
        <a href="/" class="btn btn-secondary">กลับ</a>
    </form> --}}
    <div class="container body">
        <div class="main_container">
            <div role="main">
                <div class="">
                    <div class="page-title">
                        <div class="title_left">
                            <h3>เพิ่มข่าวประชาสัมพันธ์</h3>
                        </div>

                        <div class="title_right">
                            <div class="col-md-5 col-sm-5 form-group pull-right top_search">
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
                        <div class="col-md-12 col-sm-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>ข่าวประชาสัมพันธ์ </h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                                aria-expanded="false"><i class="fa fa-wrench"></i></a>
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
                                    <form method="POST" action="/insert"novalidate enctype="multipart/form-data">
                                        @csrf
                                        <div class="field item form-group">
                                            <label for="title"
                                                class="col-form-label col-md-3 col-sm-3  label-align">หัวข้อข่าว<span
                                                    class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <input class="form-control" type="textt" name="title"
                                                    id="title" required='required' data-validate-length-range="8,20" />
                                            </div>
                                        </div>
                                        @error('title')
                                            <div class="m-2">
                                                <span class="text text-danger">{{ $message }}</span>
                                            </div>
                                        @enderror
                                        <div class="field item form-group">
                                            <label for="content"
                                                class="col-form-label col-md-3 col-sm-3  label-align">รายละเอียดข่าว<span
                                                    class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <textarea required="required" name="content" id="content" rows="5 "></textarea>
                                            </div>
                                        </div>
                                        @error('content')
                                            <div class="m-2">
                                                <span class="text text-danger">{{ $message }}</span>
                                            </div>
                                        @enderror
                                        <div class="field item form-group">
                                            <label for="img"
                                                class="col-form-label col-md-3 col-sm-3  label-align">รูป<span
                                                    class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <input type="file" name="img" id="img" class="form-control"
                                                 required='required' data-validate-length-range="8,20"/>
                                            </div>
                                        </div>
                                        <div class="ln_solid">
                                            <div class="form-group ">
                                                <div class="col-md-6 offset-md-3">
                                                    <button type='submit' class="btn btn-primary" value="บันทึก">Submit</button>
                                                    <button type='reset' class="btn btn-success">Reset</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
