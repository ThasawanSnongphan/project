@extends('layout')
@section('title', 'Project')
@section('content')
    {{-- @include('Project.create') --}}



    <div class="field item form-group ">
        <label class="col-form-label col-md-1 col-sm-1 " for="heard">ปีงบประมาณ*</label>
        <div class="col-md-2 col-sm-2 m-2 ">
            <select name="year" id="yearID" class="form-control">
                <option data-year="ทั้งหมด">ทั้งหมด</option>
                @foreach ($year as $year)
                    <option value="{{ $year->yearID }}" data-year="{{ $year->yearID }}">
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
                <th>ประเภทโครงการ</th>
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
            @foreach ($project as $index => $item)
                <tr>
                    <td>{{ $i }}</td>
                    <td data-project="{{ $item->proID }}">
                        @if ($item->statusID <= 4)
                            <a href="{{ route('project.detail', $item->proID) }}">{{ $item->name }}</a>
                        @elseif($item->statusID == 12)
                            {{ $item->name }}
                        @else
                            <a href="{{ route('detail.evaluation', $item->proID) }}">{{ $item->name }}</a>
                        @endif
                    </td>
                    <td>{{$item->projectType->name}}</td>
                    <td>{{ $item->status->name ?? 'ไม่พบ' }}</td>
                    {{-- <td>  <a href=""><i class="fa fa-eye btn btn-primary"> ดูสถานะ</i></a> </td> --}}
                    <td>
                        @php
                                $q1 = false;
                                foreach ($data['evaluation'] as $eva){
                                    if ($eva->proID == $item->proID && $eva->quarID == 1){
                                        $q1 = true;
                                    }
                                }
                            @endphp
                            @if ($q1)
                            <a href="{{ route('report.quarter', [$item->proID, 1]) }}"><i
                                class="fa fa-pencil btn btn-primary"> ดูรายงาน</i> </a>
                            @else
                            <a href="#" class="disabled"><i class="fa fa-pencil btn btn-secondary disabled">
                                ดูรายงาน</i></a> 
                            @endif
                    </td>
                    <td>

                        @php
                        $q1 = false;
                        foreach ($data['evaluation'] as $eva){
                            if ($eva->proID == $item->proID && $eva->quarID == 2){
                                $q1 = true;
                            }
                        }
                    @endphp
                    @if ($q1)
                    <a href="{{ route('report.quarter', [$item->proID, 2]) }}"><i
                        class="fa fa-pencil btn btn-primary"> ดูรายงาน</i> </a>
                    @else
                    <a href="#" class="disabled"><i class="fa fa-pencil btn btn-secondary disabled">
                        ดูรายงาน</i></a> 
                    @endif
                    </td>
                    <td>
                        @php
                        $q1 = false;
                        foreach ($data['evaluation'] as $eva){
                            if ($eva->proID == $item->proID && $eva->quarID == 3){
                                $q1 = true;
                            }
                        }
                    @endphp
                    @if ($q1)
                    <a href="{{ route('report.quarter', [$item->proID, 3]) }}"><i
                        class="fa fa-pencil btn btn-primary"> ดูรายงาน</i> </a>
                    @else
                    <a href="#" class="disabled"><i class="fa fa-pencil btn btn-secondary disabled">
                        ดูรายงาน</i></a> 
                    @endif
                    </td>
                    <td>
                        @php
                        $q1 = false;
                        foreach ($data['evaluation'] as $eva){
                            if ($eva->proID == $item->proID && $eva->quarID == 4){
                                $q1 = true;
                            }
                        }
                    @endphp
                    @if ($q1)
                    <a href="{{ route('report.quarter', [$item->proID, 4]) }}"><i
                        class="fa fa-pencil btn btn-primary"> ดูรายงาน</i> </a>
                    @else
                    <a href="#" class="disabled"><i class="fa fa-pencil btn btn-secondary disabled">
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
