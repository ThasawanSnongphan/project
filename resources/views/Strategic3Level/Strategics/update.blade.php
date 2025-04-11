@extends('layout')
@section('title', 'Strategic')
@section('content')
    <div class="container body">
        <div class="main_container">
            <div role="main">
                <div class="">
                    {{-- <div class="page-title">
                        <div class="title_left">
                            <h3>แก้ไขแผนยุทธศาสตร์</h3>
                        </div> 
                    </div>
                    <div class="clearfix"></div> --}}

                    <div class="row">
                        <div class="col-md-1 col-sm-1"></div>
                        <div class="col-md-10 col-sm-10">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>แผนยุทธศาสตร์ </h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>
                                        
                                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <form method="POST" action="{{ route('strategic.update', $strategic->stra3LVID) }}"novalidate
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="field item form-group">
                                            <label for="title"
                                                class="col-form-label col-md-3 col-sm-3  label-align">ปีงบประมาณ<span
                                                    class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <select id="yearID" name="yearID" class="form-control" disabled>
                                                    @foreach ($year as $year)
                                                        <option value="{{ $year->yearID }}"  @if ($year->yearID == $strategic->yearID) selected @endif > {{ $year->year }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="field item form-group">
                                            <label for="title"
                                                class="col-form-label col-md-3 col-sm-3  label-align">name<span
                                                    class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <input class="form-control" type="text" name="name" id="name"
                                                    required='required' data-validate-length-range="8,20"
                                                    value="{{ $strategic->name }}" />
                                                @error('name')
                                                    <div class="m-2">
                                                        <span class="text text-danger">{{ $message }}</span>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>



                                        <div class="ln_solid">
                                            <div class="form-group ">
                                                <div class="col-md-6 offset-md-3">
                                                    <button type='submit' class="btn btn-primary"
                                                        value="บันทึก">Submit</button>
                                                    <button type='reset' class="btn btn-success">Reset</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1 col-sm-1"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
