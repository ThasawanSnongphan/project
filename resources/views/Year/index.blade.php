@extends('layout')
@section('title', 'Year')
@section('content')
    {{-- <h2 class="m-2">ปีงบประมาณ</h2>
    <a href="/yCreate" class="btn btn-primary m-2">เพิ่มปีงบประมาณ</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">First</th>
                <th scope="col">Last</th>
                <th scope="col">Handle</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">1</th>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
            </tr>
        </tbody>
    </table> --}}
    <div class="container body">
        <div class="main_container">
            <!-- page content -->
            <div role="main">
                <div class="">
                    <div class="page-title">
                        <div class="title_left">
                            <h3>ปีงบประมาณ</h3>
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

                    @include('Year.create')

                    <div class="row" style="display: block;">
                        <div class="col-md-3 col-sm-3  "></div>
                        <div class="col-md-6 col-sm-6  ">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>ปีงบประมาณ</h2>
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
                                                <th>yaer</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i=1;
                                            @endphp
                                            @foreach ($year as $year )
                                                <tr>
                                                    <th scope="row">{{$i}}</th>
                                                    <td>{{ $year->name }}</td>
                                                    <td>
                                                        {{-- <a
                                                                href="{{ route('edit', $year->id) }}"><i
                                                                    class="fa fa-pencil btn btn-warning"></i></a> --}}
                                                            <a href="{{ route('years.delete', $year->yearID) }}"
                                                                onclick="return confirm('ต้องการลบข่าว {{ $year->name }} หรือไม่')"><i
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
                        <div class="col-md-3 col-sm-3  "></div>







                    </div>
                </div>
            </div>
            <!-- /page content -->
        </div>
    </div>
@endsection
