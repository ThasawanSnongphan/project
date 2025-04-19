@extends('layout')
@section('title', 'เป้าหมาย')
@section('content')
    <div class="main_container">
        <!-- page content -->
        <div role="main">
            <div class="">
                

                @include('Strategic1Level.Targets.create')

                <div class="row" style="display: block;">
                    <div class="col-md-1 col-sm-1  "></div>
                    <div class="col-md-10 col-sm-10  ">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>เป้าหมาย</h2>
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
                                <div class="field item  form-group ">
                                    <label class="col-form-label col-md-1 col-sm-1 " for="heard">ปีงบประมาณ*</label>
                                    <div class="col-md-2 col-sm-2 m-2 ">
                                        <select name="year" id="year" class="form-control">
                                            <option data-year="ทั้งหมด">ทั้งหมด</option>
                                            @foreach ($year as $year)
                                                <option value="{{ $year->yearID }}" data-year="{{ $year->year }}">
                                                    {{ $year->year }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <table id="example" class="display">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>ปีงบประมาณ</th>
                                            <th>แผนยุทธศาสตร์</th>
                                            <th>เป้าหมาย</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $sortedTargets = $target->sortBy(function ($SFA) {
                                                return $target->strategic->year->name ?? 0; // กำหนดค่าปีที่ต้องการเรียง
                                            });
                                            $i = 1;
                                        @endphp
                                        @foreach ($sortedTargets as $item)
                                            <tr>
                                                <th scope="row">{{ $i }}</th>
                                                <td>{{ $item->strategic->year->year ?? 'ไม่พบปีงบประมาณ' }}</td>
                                                <td>{{ $strategic->firstWhere('stra1LVID', $item->stra1LVID)->name ?? 'ไม่พบแผนยุทธศาสตร์' }}
                                                </td>
                                                <td>{{ $item->name }}</td>
                                                <td>
                                                    <a href="{{ route('target1LV.edit', $item->tar1LVID) }}"><i class="fa fa-pencil btn btn-warning"></i></a>
                                                    <a href="{{ route('target1LV.delete', $item->tar1LVID) }}" onclick="return confirm('ต้องการลบ {{$item->name}} หรือไม่')"><i
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
                                    document.getElementById('year').addEventListener('change', function() {
                                        // ดึงค่า "data-year" จาก option ที่ถูกเลือก
                                        var selectedOption = this.options[this.selectedIndex];
                                        var year = selectedOption.getAttribute('data-year');
                                        // console.log(year);
    
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
                    <div class="col-md-1 col-sm-1 "></div>
                </div>
            </div>
        </div>
        <!-- /page content -->
    </div>
@endsection
