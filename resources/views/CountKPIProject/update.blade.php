@extends('layout')
@section('title','countKPIProject')
@section('content')
<div class="row">
    <div class="col-md-3 col-sm-1"></div>
    <div class="col-md-6 col-sm-10">
        <div class="x_panel">
            <div class="x_title">
                <h2>แก้ไขหน่วยนับKPI </h2>
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
                <form method="POST" action="{{route('countKPI.update',$countKPI->countKPIProID)}}"novalidate enctype="multipart/form-data">
                    @csrf
                    <div class="field item form-group">
                        <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">หน่วยนับKPI<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="textt" name="name" id="name" required='required'
                                data-validate-length-range="8,20" value="{{$countKPI->name}}"/>
                            @error('name')
                                <div class="m-2">
                                    <span class="text text-danger">{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="ln_solid ">
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
    <div class="col-md-3 col-sm-1"></div>
</div>

@endsection