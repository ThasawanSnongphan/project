@extends('layout')
@section('title', 'ProjectCharector')
@section('content')
<div class="container body">
    <div class="main_container">
        <!-- page content -->
        <div role="main">
            <div class="">
                

                @include('ProjectCharac.create')

                <div class="row" style="display: block;">
                    <div class="col-md-3 col-sm-3  "></div>
                    <div class="col-md-6 col-sm-6  ">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>ลักษณะโครงการ</h2>
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
                                            <th>name</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i=1;
                                        @endphp
                                        @foreach ($pro_char as $pro )
                                            <tr>
                                                <th scope="row">{{$i}}</th>
                                                <td>{{ $pro->name }}</td>
                                                <td>
                                                    <a
                                                            href="{{ route('pro.edit', $pro->proChaID) }}"><i
                                                                class="fa fa-pencil btn btn-warning"></i></a>
                                                        <a href="{{ route('pro.delete', $pro->proChaID) }}"
                                                            onclick="return confirm('ต้องการลบ {{ $pro->name }} หรือไม่')"><i
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