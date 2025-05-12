@extends('layout')
@section('title', 'copy')
@section('content')

    <div class="row">
        <div class="col-md-1 col-sm-1"></div>
        <div class="col-md-10 col-sm-10">
            <div class="x_panel">
                <div class="x_title">
                    <h2>คัดลอกแผนยุทธศาสตร์ </h2>
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
                    <form method="POST" action="/copy"novalidate enctype="multipart/form-data">
                        @csrf
                        <div class="field item form-group">
                            <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">ปีงบประมาณ</label>
                            <div class="col-md-6 col-sm-6">
                                <select class="form-control" required disabled>
                                    @foreach ($data['year'] as $item)
                                        <option value="{{ $item->yearID }}"
                                            @if ($item->yearID == $data['strategic']->yearID) selected @endif> {{ $item->year }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="field item form-group">

                            <label for="title"
                                class="col-form-label col-md-3 col-sm-3  label-align">แผนยุทธศาสตร์</label>
                            <div class="col-md-6 col-sm-6">
                                @if ($data['lv'] == 3)
                                    <input type="hidden" name="stra3LVID" id="stra3LVID" value="{{$data['strategic']->stra3LVID}}">
                                @elseif($data['lv'] == 2)
                                    <input type="hidden" name="stra2LVID" id="stra2LVID" value="{{$data['strategic']->stra2LVID}}">
                                @else
                                    <input type="hidden" name="stra1LVID" id="stra1LVID" value="{{$data['strategic']->stra1LVID}}">
                                @endif
                                <input type="hidden" name="lv" id="lv" value="{{$data['lv']}}">
                                <input class="form-control" type="text" name="name" id="name" required='required'
                                    value="{{ $data['strategic']->name }}" readonly>

                            </div>
                        </div>
                        <div class="field item form-group">
                            <label for="title"
                                class="col-form-label col-md-3 col-sm-3  label-align">ปีงบประมาณที่จะคัดลอก<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <select id="to_yearID" name="to_yearID" class="form-control" required>
                                    @foreach ($data['year'] as $item)
                                        @if ($item->yearID > $data['strategic']->yearID)
                                            <option value="{{ $item->yearID }}"> {{ $item->year }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="ln_solid">
                            <div class="form-group text-center">
                                <div class="col-md-6 offset-md-3">
                                    <button type='submit' class="btn btn-success" value="บันทึก">Copy</button>
                                    @if ($data['lv'] == 3)
                                        <button type='button' class="btn btn-danger"><a href="/strategic" style="color: white">Back</a></button>
                                    @elseif($data['lv'] == 2)
                                        <button type='button' class="btn btn-danger"><a href="/strategic2LV" style="color: white">Back</a></button>
                                    @else
                                        <button type='button' class="btn btn-danger"><a href="/strategic1LV" style="color: white">Back</a></button>
                                    @endif
                                    
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
