@extends('layout')
@section('title', 'SFA')
@section('content')
    <div class="main_container">
        <!-- page content -->
        <div role="main">
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                        <h3>ประเด็นยุทธศาสตร์</h3>
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

                @include('SFA.create')

                <div class="row" style="display: block;">
                    <div class="col-md-1 col-sm-1  "></div>
                    <div class="col-md-10 col-sm-10  ">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>แผนยุทธศาสตร์</h2>
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

                                <table class="table table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>ปีงบประมาณ</th>
                                            <th>แผนยุทธศาสตร์</th>
                                            <th>ประเด็นยุทธศาสตร์</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $sortedSFAs = $SFA->sortBy(function ($SFA) {
                                                return $SFA->strategic->year->name ?? 0; // กำหนดค่าปีที่ต้องการเรียง
                                            });
                                            $i = 1;
                                        @endphp
                                        @foreach ($sortedSFAs as $item)
                                            <tr>
                                                <th scope="row">{{ $i }}</th>
                                                <td>{{ $item->strategic->year->name ?? 'ไม่พบปีงบประมาณ' }}</td>
                                                <td>{{ $strategic->firstWhere('straID', $item->straID)->name ?? 'ไม่พบแผนยุทธศาสตร์' }}
                                                </td>
                                                <td>{{ $item->name }}</td>
                                                <td>
                                                    <a href="{{ route('SFA.edit', $item->SFAID) }}"><i class="fa fa-pencil btn btn-warning"></i></a>
                                                    <a href="{{ route('SFA.delete', $item->SFAID) }}" onclick="return confirm('ต้องการลบประเด็นยุทธศาสตร์ {{$item->name}}  หรือไม่')"><i
                                                            class="fa fa-times btn btn-danger"></i></a>
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
                    <div class="col-md-1 col-sm-1 "></div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <!-- /page content -->
    </div>
@endsection
