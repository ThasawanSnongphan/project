@extends('layout')
@section('title', 'DateInPlan')
@section('content')
    <div class="row">
        <div class="col-md-3 col-sm-1"></div>
        <div class="col-md-6 col-sm-10">
            <div class="x_panel">
                <div class="x_title">
                    <h2>กำหนดการเสนอโครงการในแผน </h2>
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
                    <form method="POST"  action="{{route('dateInPlan.update',$data['date']->id)}}" novalidate enctype="multipart/form-data">
                        @csrf
                        <div class="field item form-group">
                            <label for="title" class="col-form-label col-md-3 col-sm-3 label-align">ปีงบประมาณ<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <select id="year" name="yearID" class="form-control" required>
                                    @foreach ($data['year'] as $item)
                                        @if ($item->yearID == $data['date']->yearID)
                                            <option value="{{ $item->yearID }}" selected>{{ $item->year }}
                                            </option>
                                        @else
                                            <option value="{{ $item->yearID }}">{{ $item->year }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="field item form-group">
                            <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">วันที่เปิด<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control" type="date" name="startDate" value="{{$data['date']->startDate}}" required>

                            </div>
                        </div>
                        <div class="field item form-group">
                            <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">วันที่ปิด<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control" type="date" name="endDate" value="{{$data['date']->endDate}}" required>

                            </div>
                        </div>
                        <div class="ln_solid ">
                            <div class="form-group ">
                                <div class="col-md-6 offset-md-3">
                                    <button type='submit' class="btn btn-warning" value="บันทึก">Edit</button>
                                    <button type='reset' class="btn btn-danger">Back</button>
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
