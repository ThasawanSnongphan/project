@extends('layout')
@section('title', 'Project')
@section('content')
    <div class="row">
        <div class="col-md-1 col-sm-1"></div>
        <div class="col-md-10 col-sm-10">
            <div class="x_panel">
                <div class="x_title">
                    <h2>สร้างโครงการ</h2>
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
                    <form id="actionForm" method="GET" action="/projectCreate2"novalidate enctype="multipart/form-data">
                        @csrf
                        

                        <div class="row field item form-group align-items-center">
                            <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">ชื่อโครงการ<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control" type="text" name="name" id="name" required='required'
                                    data-validate-length-range="8,20" />
                                @error('name')
                                    <div class="m-2">
                                        <span class="text text-danger">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row field item form-group align-items-center">
                            <label for="title" class="col-form-label col-md-3 col-sm-3 label-align">ปีงบประมาณ<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <select id="year" name="yearID" class="form-control" required >
                                    @foreach ($year as $item)
                                        <option value="{{ $item->yearID }}">
                                            {{ $item->year }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        @php
                            $index = 0;
                        @endphp
                        @foreach ($strategic3Level as $item)
                            
                            {{-- <div class="row p-2" style="background-color: azure"> --}}
                            <div class="row field item form-group align-items-center">
                                <label for="title"
                                    class="col-form-label col-md-3 col-sm-3  label-align">แผนยุทธศาสตร์<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 d-flex">
                                    <input type="checkbox">
                                    <input type="text" value="{{ $index }}">
                                    <input class="ml-2 form-control" type="text" name="straID[]"
                                        id="straID_{{ $index }}" required='required'
                                        data-validate-length-range="8,20" readonly value="{{$item->name}}">
                                </div>
                                {{-- </div> --}}

                                <div class="col-md-9 border mb-2 p-2" style="background-color:aquamarine">
                                    <div class="row field item form-group align-items-center">
                                        <label for="title"
                                            class="col-form-label col-md-3 col-sm-3  label-align">ประเด็นยุทธศาสตร์<span
                                                class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6">
                                            <input type="text" value="{{ $index }}">
                                            <select id="SFAID_{{ $index }}" name="SFAID[]" class="form-control"
                                                required>
                                                <!-- กลยุทธ์จะถูกโหลดที่นี่ -->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row field item form-group align-items-center">
                                        <label for="title"
                                            class="col-form-label col-md-3 col-sm-3  label-align">เป้าประสงค์<span
                                                class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6">
                                            <select id="goalID_{{ $index }}" name="goalID[]" class="form-control"
                                                required>
                                                <!-- กลยุทธ์จะถูกโหลดที่นี่ -->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row field item form-group align-items-center">
                                        <label for="title"
                                            class="col-form-label col-md-3 col-sm-3  label-align">กลยุทธ์<span
                                                class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6">
                                            <select id="tacID_{{ $index }}" name="tacID[]" class="form-control"
                                                required>
                                                <!-- กลยุทธ์จะถูกโหลดที่นี่ -->
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            @php
                                $index += 1;
                            @endphp
                        @endforeach
                        <div class="row field item form-group align-items-center" id="KPIMainNone" style="display: flex;">
                            <label for="title"
                                class="col-form-label col-md-2 col-sm-2 label-align">ตัวชี้วัดของแผนฉบับที่ 13</label>
                            <div class="row col-md-9 col-sm-9 border m-1">
                                <div class="col-md-12 col-sm-12">
                                    <div
                                        class="row col-md-4 col-sm-4 m-1 d-flex justify-content-center align-items-center">
                                        <label for="title"
                                            class="col-form-label label-align">ตัวชี้วัดความสำเร็จ</label>
                                    </div>
                                    <div
                                        class="row col-md-3 col-sm-3 m-1 d-flex justify-content-center align-items-center">
                                        <label class="col-form-label label-align ">หน่วยนับ</label>

                                    </div>
                                    <div
                                        class="row col-md-3 col-sm-3 m-1 d-flex justify-content-center align-items-center">
                                        <label for="title" class="col-form-label label-align">ค่าเป้าหมาย</label>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="col-md-4 col-sm-4 m-1">
                                        <select id="KPIMain_1" name="KPIMainID[]" class="form-control" required>
                                            <!-- KPIจะถูกโหลดที่นี่ -->
                                        </select>
                                    </div>
                                    <div class=" col-md-3 col-sm-3 m-1">
                                        <input class="form-control" type="text" name="countMain[]" id="countMain_1"
                                            disabled>

                                    </div>
                                    <div class=" col-md-3 col-sm-3 m-1">
                                        <input class="form-control" type="text" name="targetMain[]" id="targetMain_1"
                                            disabled>
                                    </div>
                                    <div class="col-md-1 col-sm-1 m-1">
                                        <button type='button' class="btn btn-primary" onclick="insertKPIMain()">เพิ่ม
                                        </button>

                                    </div>
                                </div>
                                <div id="insertKPIMain"></div>
                            </div>
                        </div>

                        @foreach ($strategic2Level as $item)
                            <div class="row field item form-group align-items-center"
                                style="background-color: antiquewhite">
                                <label for="title"
                                    class="col-form-label col-md-3 col-sm-3  label-align">แผนยุทธศาสตร์<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 d-flex">
                                    <input type="checkbox">

                                    <input class="ml-2 form-control" type="text" name="straID[]"
                                        id="straID_{{ $index++ }}" required='required'
                                        data-validate-length-range="8,20" value="{{ $item->name }}" readonly>


                                </div>
                                <div class="col-md-9 border mb-2 p-2">
                                    <div class="row field item form-group align-items-center">
                                        <label for="title"
                                            class="col-form-label col-md-3 col-sm-3  label-align">ประเด็นยุทธศาสตร์<span
                                                class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6">
                                            <select id="SFAID" name="SFAID[]" class="form-control" required>
                                                <!-- กลยุทธ์จะถูกโหลดที่นี่ -->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row field item form-group align-items-center">
                                        <label for="title"
                                            class="col-form-label col-md-3 col-sm-3  label-align">กลยุทธ์<span
                                                class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6">
                                            <select id="tacID" name="tacID[]" class="form-control" required>
                                                <!-- กลยุทธ์จะถูกโหลดที่นี่ -->
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="row field item form-group align-items-center" id="KPIMainNone"
                            style="display: flex;">
                            <label for="title"
                                class="col-form-label col-md-2 col-sm-2 label-align">ตัวชี้วัดของแผนดิจิทัล</label>
                            <div class="row col-md-9 col-sm-9 border m-1">
                                <div class="col-md-12 col-sm-12">
                                    <div
                                        class="row col-md-4 col-sm-4 m-1 d-flex justify-content-center align-items-center">
                                        <label for="title"
                                            class="col-form-label label-align">ตัวชี้วัดความสำเร็จ</label>
                                    </div>
                                    <div
                                        class="row col-md-3 col-sm-3 m-1 d-flex justify-content-center align-items-center">
                                        <label class="col-form-label label-align ">หน่วยนับ</label>

                                    </div>
                                    <div
                                        class="row col-md-3 col-sm-3 m-1 d-flex justify-content-center align-items-center">
                                        <label for="title" class="col-form-label label-align">ค่าเป้าหมาย</label>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="col-md-4 col-sm-4 m-1">
                                        <select id="KPIMain_1" name="KPIMainID[]" class="form-control" required>
                                            <!-- KPIจะถูกโหลดที่นี่ -->
                                        </select>
                                    </div>
                                    <div class=" col-md-3 col-sm-3 m-1">
                                        <input class="form-control" type="text" name="countMain[]" id="countMain_1"
                                            disabled>

                                    </div>
                                    <div class=" col-md-3 col-sm-3 m-1">
                                        <input class="form-control" type="text" name="targetMain[]" id="targetMain_1"
                                            disabled>
                                    </div>
                                    <div class="col-md-1 col-sm-1 m-1">
                                        <button type='button' class="btn btn-primary" onclick="insertKPIMain()">เพิ่ม
                                        </button>

                                    </div>
                                </div>
                                <div id="insertKPIMain"></div>
                            </div>
                        </div>


                        @foreach ($strategic1Level as $item)
                            <div class="row field item form-group align-items-center"
                                style="background-color: antiquewhite">
                                <label for="title"
                                    class="col-form-label col-md-3 col-sm-3  label-align">แผนยุทธศาสตร์<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 d-flex">
                                    <input type="checkbox">
                                    <input class="ml-2 form-control" type="text" name="straID[]"
                                        id="straID_{{ $index++ }}" required='required'
                                        data-validate-length-range="8,20" value="{{ $item->name }}" readonly>


                                </div>
                                <div class="col-md-9 border mb-2 p-2">
                                    <div class="row field item form-group align-items-center">
                                        <label for="title"
                                            class="col-form-label col-md-3 col-sm-3  label-align">เป้าหมาย<span
                                                class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6">
                                            <select id="SFAID" name="SFAID[]" class="form-control" required>
                                                <!-- กลยุทธ์จะถูกโหลดที่นี่ -->
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endforeach



                        <div class="ln_solid">
                            <div class="form-group ">
                                <div class="col-md-6 offset-md-3 ">
                                    <button type='submit' class="btn btn-primary">ถัดไป</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-1 col-sm-1"></div>
    </div>
@endsection


