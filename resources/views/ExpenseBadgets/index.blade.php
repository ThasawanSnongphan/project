@extends('layout')
@section('title', 'งบรายจ่าย')
@section('content')
<div class="container body">
    <div class="main_container">
        <!-- page content -->
        <div role="main">
            <div class="">
               
                @include('ExpenseBadgets.create')

                <div class="row" style="display: block;">
                    <div class="col-md-2 col-sm-2  "></div>
                    <div class="col-md-8 col-sm-8  ">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>งบรายจ่าย</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                    {{-- <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                            aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="#">Settings 1</a>
                                            <a class="dropdown-item" href="#">Settings 2</a>
                                        </div>
                                    </li>
                                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                                    </li> --}}
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">

                                <table id="example" class="display">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>แผนงานมหาวิทยาลัย</th>
                                            <th>กองุทน</th>
                                            <th>งบรายจ่าย</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i=1;
                                        @endphp
                                        @foreach ($expense as $ex)
                                            <tr>
                                                <th scope="row">{{$i}}</th>
                                                <td>{{$ex->fund->uniplan->name ?? 'ไม่พบแผนงานมหาวิทยาลัย'}}</td>
                                                <td>{{ $fund->firstWhere('fundID',$ex->fundID)->name ?? 'ไม่พบกองทุน' }}</td>
                                                <td>{{ $ex->name ?? 'ไม่พบงบรายจ่าย' }}</td>
                                                <td>
                                                    <a
                                                            href="{{ route('ex.edit', $ex->expID) }}"><i
                                                                class="fa fa-pencil btn btn-warning"></i></a>
                                                        <a href="{{ route('ex.delete', $ex->expID) }}"
                                                            onclick="return confirm('ต้องการลบ {{ $ex->name }} หรือไม่')"><i
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
                    <div class="col-md-2 col-sm-2  "></div>
                </div>
            </div>
        </div>
        <!-- /page content -->
    </div>
</div>
@endsection