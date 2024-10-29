@extends('layout')
@section('title', 'Strategic')
@section('content')
    <div class="main_container">
        <!-- page content -->
        <div role="main">
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                        <h3>แผนยุทธศาสตร์</h3>
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

                @include('Strategics.create')

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
                            <div class="field item  form-group ">
                                <label class="col-form-label col-md-1 col-sm-1 " for="heard">ปีงบประมาณ*</label>
                                <div class="col-md-2 col-sm-2 m-2 ">
                                    <select name="year" id="year" class="form-control">
                                        <option data-year="ทั้งหมด">ทั้งหมด</option>
                                        @foreach ($year as $year)
                                            <option value="{{ $year->yearID }}" data-year="{{ $year->name }}">
                                                {{ $year->name }}</option>
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
                                        <th>สถานะ</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $sortedStrategic = $strategic->sortBy('yearID');
                                        $i = 1;
                                    @endphp
                                    @foreach ($sortedStrategic as $stra)
                                        <tr>
                                            <th scope="row">{{ $i }}</th>
                                            <td>{{ $year->firstWhere('yearID', $stra->yearID)->name ?? 'ไม่ปีงบประมาณ' }}
                                            </td>
                                            <td>{{ $stra->name }}</td>
                                            <td></td>
                                            <td>
                                                <a href="{{ route('strategic.edit', $stra->straID) }}">
                                                    <i class="fa fa-pencil btn btn-warning"></i>
                                                </a>
                                                <a href="{{ route('strategic.delete', $stra->straID) }}"
                                                    onclick="return confirm('ต้องการลบข่าว {{ $stra->name }} หรือไม่')">
                                                    <i class="fa fa-times btn btn-danger"></i>
                                                </a>
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
                    <div class="col-md-1 col-sm-1  "></div>
                </div>
            </div>
        </div>
        <!-- /page content -->
    </div>
@endsection
