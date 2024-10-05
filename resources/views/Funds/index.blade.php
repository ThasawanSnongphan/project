@extends('layout')
@section('title','Fund')
@section('content')
<div class="main_container">
    <!-- page content -->
    <div role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>กองทุน</h3>
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

            @include('Funds.create')

            <div class="row" style="display: block;">
                <div class="col-md-3 col-sm-3  "></div>
                <div class="col-md-6 col-sm-6  ">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>กองทุน</h2>
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
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @php
                                        // $sortedStrategic = $strategic->sortBy('yearID');
                                        $i=1;
                                    @endphp
                                    @foreach ($fund as $item )
                                        <tr>
                                            <th scope="row">{{$i}}</th>
                                            <td>{{$plan->firstWhere('planID',$item->planID)->name ?? 'ไม่พบแผนงายมหาลัย' }}</td>
                                            <td>{{$item->name}}</td>
                                            <td></td>
                                            <td>
                                                <a
                                                        href="{{ route('fund.edit', $item->fundID) }}"><i
                                                            class="fa fa-pencil btn btn-warning"></i></a>
                                                    <a href="{{ route('fund.delete', $item->fundID) }}"
                                                        onclick="return confirm('ต้องการลบกองทุน {{$item->name}} หรือไม่')"><i
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
@endsection