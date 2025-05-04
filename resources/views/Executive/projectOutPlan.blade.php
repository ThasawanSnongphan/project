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
                                                        <tr>
                                                            <td>{{ $i }}</td>
                                                            <td data-project="{{ $item->proID }}">
                                                                @if ($item->statusID == 7 || $item->statusID == 5)
                                                                    <a
                                                                        href="{{ route('Executive.detailEvaluation', $item->proID) }}">{{ $item->name }}</a>
                                                                @elseif($item->statusID == 3 || $item->statusID == 1)
                                                                    <a
                                                                        href="{{ route('Executive.detail', $item->proID) }}">{{ $item->name }}</a>
                                                                @endif
                                                            </td>

                                                            <td>{{ $item->status->name ?? 'ไม่พบ' }}</td>
                                                            {{-- <td>  <a href=""><i class="fa fa-eye btn btn-primary"> ดูสถานะ</i></a> </td> --}}
                                                            <td>
                                                                @php
                                                                    $found1 = false;

                                                                    foreach ($data['report'] as $report) {
                                                                        if ($report->proID == $item->proID) {
                                                                            if ($report->quarID == 1) {
                                                                                $found1 = true;
                                                                            }
                                                                        }
                                                                    }

                                                                @endphp
                                                                @if ($found1)
                                                                    <a
                                                                        href="{{ route('report.quarter', [$item->proID, 1]) }}">
                                                                        <i class="fa fa-eye btn btn-primary">
                                                                            ดูรายงาน</i>
                                                                    </a>
                                                                @else
                                                                    <a href="#" class="disabled"><i
                                                                            class="fa fa-pencil btn btn-secondary disabled">
                                                                            ดูรายงาน</i></a>
                                                                @endif

                                                            </td>
                                                            <td>
                                                                @php
                                                                    $found2 = false;

                                                                    foreach ($data['report'] as $report) {
                                                                        if ($report->proID == $item->proID) {
                                                                            if ($report->quarID == 2) {
                                                                                $found2 = true;
                                                                            }
                                                                        }
                                                                    }

                                                                @endphp
                                                                @if ($found2)
                                                                    <a
                                                                        href="{{ route('report.quarter', [$item->proID, 2]) }}">
                                                                        <i class="fa fa-eye btn btn-primary">
                                                                            ดูรายงาน</i>
                                                                    </a>
                                                                @else
                                                                    <a href="#" class="disabled"><i
                                                                            class="fa fa-pencil btn btn-secondary disabled">
                                                                            ดูรายงาน</i></a>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @php
                                                                    $found3 = false;

                                                                    foreach ($data['report'] as $report) {
                                                                        if ($report->proID == $item->proID) {
                                                                            if ($report->quarID == 3) {
                                                                                $found3 = true;
                                                                            }
                                                                        }
                                                                    }

                                                                @endphp
                                                                @if ($found3)
                                                                    <a
                                                                        href="{{ route('report.quarter', [$item->proID, 3]) }}">
                                                                        <i class="fa fa-eye btn btn-primary">
                                                                            ดูรายงาน</i>
                                                                    </a>
                                                                @else
                                                                    <a href="#" class="disabled"><i
                                                                            class="fa fa-pencil btn btn-secondary disabled">
                                                                            ดูรายงาน</i></a>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @php
                                                                $found4 = false;

                                                                foreach ($data['report'] as $report) {
                                                                    if ($report->proID == $item->proID) {
                                                                        if ($report->quarID == 4) {
                                                                            $found4 = true;
                                                                        }
                                                                    }
                                                                }

                                                            @endphp
                                                            @if ($found4)
                                                                <a
                                                                    href="{{ route('report.quarter', [$item->proID, 14]) }}">
                                                                    <i class="fa fa-eye btn btn-primary">
                                                                        ดูรายงาน</i>
                                                                </a>
                                                            @else
                                                                <a href="#" class="disabled"><i
                                                                        class="fa fa-pencil btn btn-secondary disabled">
                                                                        ดูรายงาน</i></a>
                                                            @endif
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
