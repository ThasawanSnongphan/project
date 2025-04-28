@extends('layout')
@section('title', 'โครงการประจำปี')
@section('content')

    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <div role="main">
                    <div class="">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>โครงการที่ไม่อนุมัติ/ยกเลิกประจำปี</h2>
                                        <ul class="nav navbar-right panel_toolbox">
                                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                            </li>
                                        </ul>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">
                                        <div class="field item form-group ">
                                            <label class="col-form-label col-md-1 col-sm-1 "
                                                for="heard">ปีงบประมาณ*</label>
                                            <div class="col-md-2 col-sm-2 m-2 ">
                                                <select name="year" id="yearID" class="form-control">
                                                    <option data-year="ทั้งหมด">ทั้งหมด</option>
                                                    @foreach ($data['year'] as $year)
                                                        <option value="{{ $year->yearID }}" data-year="{{ $year->yearID }}">
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
                                                    $i = 1;
                                                @endphp

                                                @foreach ($data['project'] as $item)
                                                    <tr>
                                                        <td>{{ $i }}</td>
                                                        <td>{{ $item->name }}</td>
                                                        <td>{{ $item->status->name }}</td>
                                                        <td>
                                                            @php
                                                                $q1 = false;
                                                                foreach ($data['evaluation'] as $eva) {
                                                                    if (
                                                                        $eva->proID == $item->proID &&
                                                                        $eva->quarID == 1
                                                                    ) {
                                                                        $q1 = true;
                                                                    }
                                                                }
                                                            @endphp
                                                            @if ($q1)
                                                                <a href="{{ route('report.quarter', [$item->proID, 1]) }}"><i
                                                                        class="fa fa-eye btn btn-primary"> ดูรายงาน</i> </a>
                                                            @else
                                                                <a href="#" class="disabled"><i
                                                                        class="fa fa-eye btn btn-secondary disabled">
                                                                        ดูรายงาน</i></a>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @php
                                                                $q1 = false;
                                                                foreach ($data['evaluation'] as $eva) {
                                                                    if (
                                                                        $eva->proID == $item->proID &&
                                                                        $eva->quarID == 2
                                                                    ) {
                                                                        $q1 = true;
                                                                    }
                                                                }
                                                            @endphp
                                                            @if ($q1)
                                                                <a href="{{ route('report.quarter', [$item->proID, 2]) }}"><i
                                                                        class="fa fa-eye btn btn-primary"> ดูรายงาน</i> </a>
                                                            @else
                                                                <a href="#" class="disabled"><i
                                                                        class="fa fa-eye btn btn-secondary disabled">
                                                                        ดูรายงาน</i></a>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @php
                                                                $q1 = false;
                                                                foreach ($data['evaluation'] as $eva) {
                                                                    if (
                                                                        $eva->proID == $item->proID &&
                                                                        $eva->quarID == 3
                                                                    ) {
                                                                        $q1 = true;
                                                                    }
                                                                }
                                                            @endphp
                                                            @if ($q1)
                                                                <a href="{{ route('report.quarter', [$item->proID, 3]) }}"><i
                                                                        class="fa fa-eye btn btn-primary"> ดูรายงาน</i> </a>
                                                            @else
                                                                <a href="#" class="disabled"><i
                                                                        class="fa fa-eye btn btn-secondary disabled">
                                                                        ดูรายงาน</i></a>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @php
                                                                $q1 = false;
                                                                foreach ($data['evaluation'] as $eva) {
                                                                    if (
                                                                        $eva->proID == $item->proID &&
                                                                        $eva->quarID == 4
                                                                    ) {
                                                                        $q1 = true;
                                                                    }
                                                                }
                                                            @endphp
                                                            @if ($q1)
                                                                <a href="{{ route('report.quarter', [$item->proID, 4]) }}"><i
                                                                        class="fa fa-eye btn btn-primary"> ดูรายงาน</i> </a>
                                                            @else
                                                                <a href="#" class="disabled"><i
                                                                        class="fa fa-eye btn btn-secondary disabled">
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

            const projectYear = @json($data['projectYear']);
            console.log(projectYear);
            const tableRows = document.querySelectorAll("table tbody tr");


            tableRows.forEach(row => {
                const cell = row.querySelector('td[data-project]');
                if (cell) {
                    const projectID = cell.getAttribute('data-project');
                    const project = projectYear.find(project => project.proID == projectID);
                    // console.log(projectID);
                    // console.log(project);

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
