@extends('layout')
@section('title','Fund')
@section('content')
<div class="main_container">
    <!-- page content -->
    <div role="main">
        <div class="">
            

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
                                
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <table id="example" class="display">
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