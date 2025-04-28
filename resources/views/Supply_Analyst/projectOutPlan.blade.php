@extends('layout')
@section('title', 'Project')
@section('content')
    {{-- @include('Project.create') --}}\

    <div class="col-md-12 col-sm-12">
        <div class="main_container">
            <!-- page content -->
            <div role="main">
                <div class="">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>โครงการทั้งหมด</h2>
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

                                                            <a
                                                                href="{{ route('project.detail', $item->proID) }}">{{ $item->name }}</a>

                                                        </td>

                                                        <td>{{ $item->status->name }}</td>

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
    </div>

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
