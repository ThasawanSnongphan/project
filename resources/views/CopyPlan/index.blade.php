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
                                <input class="form-control" type="text" name="name" id="name" required='required'
                                    value="{{ $data['strategic']->name }}" readonly>

                            </div>
                        </div>
                        <div class="field item form-group">
                            <label for="title"
                                class="col-form-label col-md-3 col-sm-3  label-align">ปีงบประมาณที่จะตัดลอก<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <select id="yearID" name="yearID" class="form-control" required>
                                    @foreach ($data['year'] as $item)
                                        @if ($item->yearID > $data['strategic']->yearID)
                                            <option value="{{ $item->yearID }}"> {{ $item->year }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @if (!empty($data['SFA3LV']))
                            @foreach ($data['SFA3LV'] as $item)
                                <input type="text" name="SFA3LVName[]" value="{{ $item->name }}">
                            @endforeach
                        @endif
                        @if (!empty($data['goal']))
                            @foreach ($data['goal'] as $item)
                                <input type="text" name="goal3LVName[]" value="{{ $item->name }}">
                            @endforeach
                        @endif
                        <div class="ln_solid">
                            <div class="form-group ">
                                <div class="col-md-6 offset-md-3">
                                    <button type='submit' class="btn btn-success" value="บันทึก">Copy</button>
                                    <button type='reset' class="btn btn-primary">back</button>
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
