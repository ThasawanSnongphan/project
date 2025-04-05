@extends('layout')
@section('title','DateInPlan')
@section('content')
<div class="container body">
    <div class="main_container">
        <div role="main">
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                        <h3>กำหนดการเสนอโครงการในแผน</h3>
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

                @include('DateInPlan.create')

                <div class="row" style="display: block;">
                    <div class="col-md-3 col-sm-1  "></div>
                    <div class="col-md-6 col-sm-10  ">

                        <div class="x_panel">
                            <div class="x_title">
                                <h2>กำหนดการเสนอโครงการในแผน</h2>
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

                                <table id="example" class="display">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>ปีงบประมาณ</th>
                                            <th>วันที่เปิด</th>
                                            <th>วันที่ปิด</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($data['date'] as $item)
                                            <tr>
                                                <th scope="row">{{ $i }}</th>
                                                <td>{{$item->year->year}}</td>
                                                <td>{{ $item->startDate }}</td>
                                                <td>{{ $item->endDate }}</td>
                                                <td>
                                                    <a href="{{ route('dateInPlan.edit', $item->id) }}">
                                                        <i class="fa fa-pencil btn btn-warning
                                                        "></i></a>
                                                    <a href="{{ route('dateInPlan.delete', $item->id) }}"
                                                        onclick="return confirm('ต้องการลบกำหนดการปี{{ $item->year->year }} หรือไม่')">
                                                        <i class="fa fa-times btn btn-danger"></i></a>
                                                </td>
                                            </tr>
                                            @php
                                                $i++;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-1  "></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection