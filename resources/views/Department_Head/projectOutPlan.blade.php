@extends('layout')
@section('title', 'Project')
@section('content')
    {{-- @include('Project.create') --}}

    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <!-- page content -->
                <div role="main">
                    <div class="">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>โครงการนอกแผน</h2>
                                        <ul class="nav navbar-right panel_toolbox">
                                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                        </ul>
                                        <div class="clearfix"></div>
                                        <div class="x_content">
                                            <div class="field item form-group ">
                                                <label class="col-form-label col-md-1 col-sm-1 "
                                                    for="heard">ปีงบประมาณ*</label>
                                                <div class="col-md-2 col-sm-2 m-2 ">
                                                    <select name="year" id="yearID" class="form-control">
                                                        <option data-year="ทั้งหมด">ทั้งหมด</option>
                                                        @foreach ($year as $year)
                                                            <option value="{{ $year->yearID }}"
                                                                data-year="{{ $year->yearID }}">
                                                                {{ $year->year }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                {{-- <div class="ml-auto">

            <a type='submit' class="btn btn-secondary m-2" href="/projectcreate">สร้างโครงการ</a>
        </div> --}}

                                            </div>

                                            <table id="example" class="display">
                                                <thead>

                                                    <tr>
                                                        <th>#</th>
                                                        <th>ชื่อโครงการ</th>

                                                        <th>สถานะ</th>
                                                        <th>ไตรมาส 1</th>
                                                        <th>ไตรมาส 2</th>
                                                        <th>ไตรมาส 3</th>
                                                        <th>ไตรมาส 4</th>


                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $currentMonth = now()->month;
                                                        $i = 1;
                                                    @endphp
                                                    @foreach ($project as $item)
                                                        <td>{{ $i }}</td>
                                                        <td data-project="{{ $item->proID }}">

                                                            @if ($item->statusID == 5)
                                                                <a
                                                                    href="{{ route('Department.detailEvaluation', $item->proID) }}">{{ $item->name }}</a>
                                                            @elseif($item->statusID == 1)
                                                                <a
                                                                    href="{{ route('Department.detail', $item->proID) }}">{{ $item->name }}</a>
                                                            @endif
                                                        </td>
                                                        @if (Auth::check() && auth()->user() && auth()->user()->Responsible == 1)
                                                            <td>{{ $status->firstWhere('statusID', $item->statusID)->name ?? 'ไม่พบ' }}
                                                            </td>
                                                            {{-- <td>  <a href=""><i class="fa fa-eye btn btn-primary"> ดูสถานะ</i></a> </td> --}}
                                                            <td>
                                                                @if ($currentMonth >= 10 && $currentMonth <= 12 && ($currentMonth = 1 && $item->statusID === 7))
                                                                    <!-- เช็คว่าเป็นเดือนตุลาคมถึงธันวาคม -->
                                                                    <a href=""><i
                                                                            class="fa fa-pencil btn btn-primary">
                                                                            เขียน</i></a>
                                                                @else
                                                                    <a href="#" class="disabled"><i
                                                                            class="fa fa-pencil btn btn-secondary disabled">
                                                                            เขียน</i></a>
                                                                @endif
                                                            </td>
                                                            <td>

                                                                @if ($currentMonth >= 1 && $currentMonth <= 3 && $item->statusID === 7)
                                                                    <!-- เช็คว่าเป็นเดือนตุลาคมถึงธันวาคม -->
                                                                    <a href=""><i
                                                                            class="fa fa-pencil btn btn-primary">
                                                                            เขียน</i></a>
                                                                @else
                                                                    <a href="#" class="disabled"><i
                                                                            class="fa fa-pencil btn btn-secondary disabled">
                                                                            เขียน</i></a>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($currentMonth >= 4 && $currentMonth <= 6)
                                                                    <!-- เช็คว่าเป็นเดือนเมษายนถึงมิถุนายน -->

                                                                    @if ($item->statusID == 4)
                                                                        {{-- <input type="text" value="{{$item->proID}}"> --}}
                                                                        {{-- @if (empty($evaluation) && ($evaluation[$index]->proID ?? '') === $item->proID) --}}

                                                                        @if ($proID[$index] ?? '' === $item->proID)
                                                                            <a
                                                                                href="{{ route('report.quarter', [$item->proID, 3]) }}"><i
                                                                                    class="fa fa-pencil btn btn-danger">
                                                                                    เสนอปิดโครงการ</i></a>
                                                                        @else
                                                                            {{-- <input type="text" value="{{$proID ?? ''}}"> --}}
                                                                            <a
                                                                                href="{{ route('report.quarter', [$item->proID, 3]) }}"><i
                                                                                    class="fa fa-pencil btn btn-primary">
                                                                                    เขียน</i></a>
                                                                            {{-- <input type="text" value="{{$item->proID}}"> --}}
                                                                        @endif
                                                                    @elseif($item->statusID == 13)
                                                                        <a
                                                                            href="{{ route('edit.evaluation', $item->proID) }}"><i
                                                                                class="fa fa-pencil btn btn-warning">
                                                                                แก้ไขเอกสารเสนอปิดโครงการ</i></a>
                                                                    @elseif ($item->statusID >= 5 && $item->statusID <= 11)
                                                                        <a
                                                                            href="{{ route('report.quarter', [$item->proID, 3]) }}"><i
                                                                                class="fa fa-eye btn btn-primary">
                                                                                ดูรายงาน</i></a>
                                                                    @else
                                                                        <a href="#" class="disabled"><i
                                                                                class="fa fa-pencil btn btn-secondary disabled">
                                                                                เขียน</i></a>
                                                                    @endif
                                                                @else
                                                                    <a href="#" class="disabled"><i
                                                                            class="fa fa-pencil btn btn-secondary disabled">
                                                                            เขียน</i></a>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($currentMonth >= 7 && $currentMonth <= 9 && $item->statusID === 7)
                                                                    <!-- เช็คว่าเป็นเดือนตุลาคมถึงธันวาคม -->
                                                                    <a href=""><i
                                                                            class="fa fa-pencil btn btn-primary">
                                                                            เขียน</i></a>
                                                                @else
                                                                    <a href="#" class="disabled"><i
                                                                            class="fa fa-pencil btn btn-secondary disabled">
                                                                            เขียน</i></a>
                                                                @endif
                                                            </td>
                                                        @endif
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </body>

    <script>
        // เมื่อมีการเลือกแผนยุทธศาสตร์จาก dropdown
        document.getElementById('yearID').addEventListener('change', function() {
            // ดึงค่า "data-year" จาก option ที่ถูกเลือก
            var selectedOption = this.options[this.selectedIndex];
            var year = selectedOption.getAttribute('data-year');
            console.log(year);

            const projectYear = @json($projectYear);
            console.log(projectYear);
            const tableRows = document.querySelectorAll("table tbody tr");


            tableRows.forEach(row => {
                const cell = row.querySelector('td[data-project]');
                if (cell) {
                    const projectID = cell.getAttribute('data-project');
                    const project = projectYear.find(project => project.proID == projectID);
                    console.log(projectID);
                    console.log(project);

                    // Check if the row should be displayed
                    if (project && (year === "" || year === "ทั้งหมด" || project.yearID == year)) {
                        row.style.display = ""; // Show the row
                    } else {
                        row.style.display = "none"; // Hide the row
                    }
                }
            });
        });
    </script>

@endsection
