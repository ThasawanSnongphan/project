@extends('layout')
@section('title', 'Year')
@section('content')
    {{-- <h2 class="m-2">Year</h2>
    <form method="POST" action="/yInsert">
        @csrf
        <div class="form-group m-2">
            <label for="name">ปีงบประมาณ</label>
            <input type="text" name="name" id="name" >
            <input type="submit" value="บันทึก" class="btn btn-primary m-2">
        </div>
        @error('name')
            <div class="m-2">
                <span class="text text-danger">{{$message}}</span>
            </div>
        @enderror
        
    </form> --}}

    <div class="container body">
        <div class="main_container">
            <div role="main">
                <div class="">
                    <div class="page-title">
                        <div class="title_left">
                            <h3>เพิ่มปีงบประมาณ</h3>
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
                        <div class="col-md-3 col-sm-3"></div>
                        <div class="col-md-6 col-sm-6">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>ปีงบประมาณ </h2>
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
                                    <form method="POST" action="/yInsert"novalidate enctype="multipart/form-data">
                                        @csrf
                                        <div class="field item form-group">
                                            <label for="title"
                                                class="col-form-label col-md-3 col-sm-3  label-align">year<span
                                                    class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <input class="form-control" type="textt" name="name"
                                                    id="name" required='required' data-validate-length-range="8,20" />
                                            </div>
                                        </div>
                                        @error('title')
                                            <div class="m-2">
                                                <span class="text text-danger">{{ $message }}</span>
                                            </div>
                                        @enderror
                                        
                                        
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
                        <div class="col-md-3 col-sm-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection