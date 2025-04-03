@extends('layout')
@section('title','KPIMain')
@section('content')
<div class="main_container">
    <!-- page content -->
    <div role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>ตัวชี้วัดของแผน</h3>
                </div>

                
            </div>

            @include('Strategic3Level.KPIMain.create')

            <div class="row" style="display: block;">
                <div class="col-md-1 col-sm-1  "></div>
                <div class="col-md-10 col-sm-10  ">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>ตัวชี้วัดของแผน</h2>
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

                            <div class="field item form-group ">
                                <label class="col-form-label col-md-1 col-sm-1 " for="heard" >ปีงบประมาณ*</label>
                                <div class="col-md-2 col-sm-2 m-2 ">
                                    <select name="year" id="yearID" class="form-control">
                                        <option data-year="ทั้งหมด">ทั้งหมด</option>
                                        @foreach ($year as $year)
                                            <option value="{{ $year->yearID }}" data-year="{{ $year->year }}">
                                                {{ $year->year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <table id="example" class="display">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>ปีงบประมาณ</th>
                                        <th>แผนยุทธศาสตร์</th>
                                        <th>ประเด็นยุทธศาสตร์</th>
                                        <th>เป้าประสงค์</th>
                                        <th>KPI</th>
                                        <th>หน่วยนับ</th>
                                        <th>ค่าเป้าหมาย</th>
                                        <th>ผู้กำกับ</th>
                                        <th>ผู้บันทึกข้อมูล</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $sortedKPI = $KPIMain->sortBy(function ($KPIMain) {
                                            return $KPIMain->goal->SFA->strategic->year->year ?? 0; // กำหนดค่าปีที่ต้องการเรียง
                                        });
                                        $i=1;
                                    @endphp
                                    @foreach ($sortedKPI as $item )
                                        <tr>
                                            <th scope="row">{{$i}}</th>
                                            <td>{{ $item->goal->SFA->strategic->year->year ?? 'ไม่พบปี' }}</td>
                                            <td>{{ $item->goal->SFA->strategic->name ?? 'ไม่พบแผนยุทธศาสตร์' }}</td>
                                            <td>{{ $item->goal->SFA->name ?? 'ไม่พบประเด็นยุทธศาสตร์' }}</td>
                                            <td>{{ $item->goal->name ?? 'ไม่พบเป้าประสงค์' }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->count }}</td>
                                            <td>{{ $item->target }}</td>
                                            <td> 
                                                @if($item->director)
                                                    {{ $item->director->firstname_en }} {{ $item->director->lastname_en }}
                                                @else
                                                    null
                                                @endif
                                            </td>
                                            <td>
                                                @if($item->recorder)
                                                    {{ $item->recorder->firstname_en }} {{ $item->recorder->lastname_en }}
                                                @else
                                                    null
                                                @endif
                                            </td>
                                            <td>
                                                <a
                                                        href="{{route('KPIMain.edit',$item->KPIMain3LVID)}}"><i
                                                            class="fa fa-pencil btn btn-warning"></i></a>
                                                    <a href="{{route('KPIMain.delete',$item->KPIMain3LVID)}}"
                                                        onclick="return confirm('ต้องการลบตัวชี้วัดบังคับ {{$item->name}}   หรือไม่')"><i
                                                            class="fa fa-times btn btn-danger"></i></a>
                                            </td>
                                        </tr>
                                        @php
                                            $i++;
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>

                            <script>
                                // เมื่อมีการเลือกแผนยุทธศาสตร์จาก dropdown
                                document.getElementById('yearID').addEventListener('change', function() {
                                    // ดึงค่า "data-year" จาก option ที่ถูกเลือก
                                    var selectedOption = this.options[this.selectedIndex];
                                    var year = selectedOption.getAttribute('data-year');
                                    console.log(year);

                                    const tableRows = document.querySelectorAll("table tbody tr");


                                    tableRows.forEach(row => {
                                        const yearCell = row.children[1]
                                            .textContent; // Assuming year is in the second cell (index 1)

                                        // Check if the row should be displayed
                                        if (year === "" || year === "ทั้งหมด" || yearCell.includes(year)) {
                                            row.style.display = ""; // Show the row
                                        } else {
                                            row.style.display = "none"; // Hide the row
                                        }
                                    });
                                });
                            </script>
                            
                        </div>
                    </div>
                </div>
                <div class="col-md-1 col-sm-1  "></div>
            </div>
        </div>
    </div>
    <!-- /page content -->
</div>
@endsection