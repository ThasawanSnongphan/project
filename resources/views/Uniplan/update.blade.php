@extends('layout')
@section('title', 'UnivarsityPlan')
@section('content')
    <div class="container body">
        <div class="main_container">
            <div role="main">
                <div class="">
                    
                    <div class="row">
                        <div class="col-md-3 col-sm-3"></div>
                        <div class="col-md-6 col-sm-6">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>แก้ไขแผนงานมหาลัย </h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>
                                        {{-- <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                                aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="#">Settings 1</a>
                                                <a class="dropdown-item" href="#">Settings 2</a>
                                            </div>
                                        </li>
                                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                                        </li> --}}
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <form method="POST" action="{{route('plan.update',$plan->planID)}}"novalidate enctype="multipart/form-data">
                                        @csrf
                                        <div class="field item form-group">
                                            <label for="name"
                                                class="col-form-label col-md-3 col-sm-3  label-align">name<span
                                                    class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <input class="form-control" type="text" name="name" id="name"
                                                    required value="{{$plan->name}}"  >
                                                
                                            </div>
                                        </div>



                                        <div class="ln_solid">
                                            <div class="form-group text-center p-2">
                                                <div class="col-md-6 offset-md-3">
                                                    <button type='submit' class="btn btn-warning"
                                                        value="บันทึก">Edit</button>
                                                    <button type='reset' class="btn btn-danger"><a href="/plan" style="color: white">Back</a></button>
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
