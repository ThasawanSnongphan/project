@extends('layout')
@section('title', 'CostType')
@section('content')
<div class="container body">
    <div class="main_container">
        <!-- page content -->
        <div role="main">
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                        <h3>หมวดรายจ่าย</h3>
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

                @include('CostTypes.create')

                <div class="row" style="display: block;">
                    <div class="col-md-1 col-sm-1  "></div>
                    <div class="col-md-10 col-sm-10  ">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>หมวดรายจ่าย</h2>
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
                                            <th>แผนงานมหาลัย</th>
                                            <th>กองทุน</th>
                                            <th>งบรายจ่าย</th>
                                            <th>หมวดรายจ่าย</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i=1;
                                        @endphp
                                        @foreach ($cost_types as $cost )
                                            <tr>
                                                <th scope="row">{{$i}}</th>
                                                <td>{{$cost->expense->fund->uniplan->name ?? 'ไม่พบแผนงานมหาลัย'}}</td>
                                                <td>{{$cost->expense->fund->name ?? 'ไม่พบกองทุน'}}</td>
                                                <td>{{$expanses->firstWhere('expID',$cost->expID)->exname ?? 'ไม่พบงบรายจ่าย'}}</td>
                                                <td>{{ $cost->costname }}</td>
                                                <td>
                                                    <a
                                                            href="{{ route('costs.edit', $cost->id) }}"><i
                                                                class="fa fa-pencil btn btn-warning"></i></a>
                                                        <a href="{{ route('costs.delete', $cost->id) }}"
                                                            onclick="return confirm('ต้องการลบข่าว {{ $cost->costname }} หรือไม่')"><i
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
                    <div class="col-md-1 col-sm-1  "></div>
                </div>
            </div>
        </div>
        <!-- /page content -->
    </div>
</div>
@endsection