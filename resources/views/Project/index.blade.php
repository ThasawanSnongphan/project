@extends('layout')
@section('title', 'Project')
@section('content')
    {{-- @include('Project.create') --}}


    <h3>โครงการประจำปี</h3>

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
    </div>


    <table id="example" class="display">
        <thead>
            <tr>
                <th>#</th>
                <th>ชื่อโครงการ</th>
                <th>สถานะ</th>
                @if (Auth::check() && auth()->user())
                    <th>ไตรมาส 1</th>
                    <th>ไตรมาส 2</th>
                    <th>ไตรมาส 3</th>
                    <th>ไตรมาส 4</th>
                    <th></th>
                @endif

            </tr>
        </thead>
        <tbody>
            @php
                $currentDate = date('Y-m-d');
                $i = 1;
            @endphp
            @foreach ($project as $index => $item)
                <tr>
                    <td>{{ $i }}</td>
                    <td data-project="{{ $item->proID }}">
                        @if ($item->statusID == 12 || $item->statusID == 13 || $item->statusID == 14)
                            {{ $item->name }}
                        @else
                            <a href="{{ route('project.detail', $item->proID) }}">{{ $item->name }}</a>
                        @endif
                    </td>
                    <td>{{ $status->firstWhere('statusID', $item->statusID)->name ?? 'ไม่พบ' }}</td>
                    <td>
                        @if (count($data['dateQuarter1']))
                            @foreach ($data['dateQuarter1'] as $date)
                                {{-- ไตรมาส 1 (ต.ค-ธ.ค) --}}
                                @if ($date->yearID == $item->yearID && $currentDate >= $date->startDate && $currentDate <= $date->endDate)
                                    
                                      
                                    
                                    <a href="{{ route('report.quarter', [$item->proID, $date->quarID]) }}"><i
                                            class="fa fa-pencil btn btn-primary"> เขียน</i></a>
                                @else
                                    <a href="#" class="disabled"><i class="fa fa-pencil btn btn-secondary disabled">
                                            เขียน</i></a>
                                @endif
                            @endforeach
                        @else
                            <a href="#" class="disabled"><i class="fa fa-pencil btn btn-secondary disabled">
                                    เขียน</i></a>
                        @endif

                    </td>
                    <td>
                        @if (count($data['dateQuarter2']) > 0)
                            @foreach ($data['dateQuarter2'] as $date)
                                @if ($date->yearID == $item->yearID && $currentDate >= $date->startDate && $currentDate <= $date->endDate)
                                    
                                    <a href="{{ route('report.quarter', [$item->proID, $date->quarID]) }}"><i
                                            class="fa fa-pencil btn btn-primary"> เขียน</i></a>
                                @else
                                    <a href="#" class="disabled"><i class="fa fa-pencil btn btn-secondary disabled">
                                            เขียน</i></a>
                                @endif
                            @endforeach
                        @else
                            <a href="#" class="disabled"><i class="fa fa-pencil btn btn-secondary disabled">
                                    เขียน</i></a>
                        @endif

                    </td>
                    <td>
                        @if (count($data['dateQuarter3']) > 0)
                            @foreach ($data['dateQuarter3'] as $date)
                                @if ($date->yearID == $item->yearID && $currentDate >= $date->startDate && $currentDate <= $date->endDate)
                                    <a href="{{ route('report.quarter', [$item->proID, $date->quarID]) }}"><i
                                            class="fa fa-pencil btn btn-primary"> เขียน</i></a>
                                @else
                                    <a href="#" class="disabled"><i class="fa fa-pencil btn btn-secondary disabled">
                                            เขียน</i></a>
                                @endif
                            @endforeach
                        @else
                            <a href="#" class="disabled"><i class="fa fa-pencil btn btn-secondary disabled">
                                    เขียน</i></a>
                        @endif

                    </td>
                    <td>
                        @if (count($data['dateQuarter4']) > 0)
                            @foreach ($data['dateQuarter4'] as $date)
                                @if ($date->yearID == $item->yearID && $currentDate >= $date->startDate && $currentDate <= $date->endDate)
                                    <a href="{{ route('report.quarter', [$item->proID, $date->quarID]) }}"><i
                                            class="fa fa-pencil btn btn-primary"> เขียน</i></a>
                                @else
                                    <a href="#" class="disabled"><i class="fa fa-pencil btn btn-secondary disabled">
                                            เขียน</i></a>
                                @endif
                            @endforeach
                        @else
                            <a href="#" class="disabled"><i class="fa fa-pencil btn btn-secondary disabled">
                                    เขียน</i></a>
                        @endif
                    </td>
                    <td>
                        @if ($item->statusID == 12 || $item->statusID == 14)
                            <a href="{{ route('project.edit1', $item->proID) }}"><i
                                    class="fa fa-pencil btn btn-warning"></i></a>
                            <a href="{{ route('project.delete', $item->proID) }}"
                                onclick="return confirm('ต้องการลบโปรเจค {{ $item->name }}  หรือไม่')"><i
                                    class="fa fa-times btn btn-danger"></i></a>
                        @elseif($item->statusID == 13)
                            <a href="{{ route('edit.evaluation', $item->proID) }}"><i
                                    class="fa fa-pencil btn btn-warning"></i></a>
                            <a href="{{ route('project.delete', $item->proID) }}"
                                onclick="return confirm('ต้องการลบโปรเจค {{ $item->name }}  หรือไม่')"><i
                                    class="fa fa-times btn btn-danger"></i></a>
                        @endif
                    </td>

                    {{-- <td>
                          

                            @if ($currentMonth >= 10 && $currentMonth <= 12)
                               
                                @if ($item->statusID == 4)
                                    @if (!empty($evaluation) && ($evaluation[$index]->proID ?? '') === $item->proID)
                                        <a href="{{ route('edit.evaluation', $item->proID) }}"><i
                                                class="fa fa-pencil btn btn-warning"> แก้ไขเอกสารเสนอปิดโครงการ</i></a>
                                    @elseif (!empty($report) && ($proID[$index] ?? '') === $item->proID)
                                      
                                        <a href="{{ route('report.quarter', [$item->proID, 1]) }}"><i
                                                class="fa fa-pencil btn btn-danger"> เสนอปิดโครงการ</i></a>
                                    @else
                                        <a href="{{ route('report.quarter', [$item->proID, 1]) }}"><i
                                                class="fa fa-pencil btn btn-primary"> เขียน</i></a>
                                      
                                    @endif
                                @elseif($item->statusID == 8 || $item->statusID == 9 || $item->statusID == 10 || $item->statusID == 11)
                                    <a href="{{ route('report.quarter', [$item->proID, 2]) }}"><i
                                            class="fa fa-eye btn btn-primary"> ดูรายงาน</i></a>
                                @endif
                            @else
                                <a href="#" class="disabled"><i class="fa fa-pencil btn btn-secondary disabled">
                                        เขียน</i></a>
                            @endif

                        </td>
                        <td>

                            @if ($currentMonth >= 1 && $currentMonth <= 3)
                               
                                @if ($item->statusID == 4)
                                  

                                    @if ($proID[$index] ?? '' === $item->proID)
                                        <a href="{{ route('report.quarter', [$item->proID, 2]) }}"><i
                                                class="fa fa-pencil btn btn-danger"> เสนอปิดโครงการ</i></a>
                                    @else
                                        
                                        <a href="{{ route('report.quarter', [$item->proID, 2]) }}"><i
                                                class="fa fa-pencil btn btn-primary">
                                                เขียน</i></a>
                                        
                                    @endif
                                @elseif($item->statusID == 13)
                                    <a href="{{ route('edit.evaluation', $item->proID) }}"><i
                                            class="fa fa-pencil btn btn-warning"> แก้ไขเอกสารเสนอปิดโครงการ</i></a>
                                @elseif ($item->statusID >= 5 && $item->statusID <= 11)
                                    <a href="{{ route('report.quarter', [$item->proID, 2]) }}"><i
                                            class="fa fa-eye btn btn-primary"> ดูรายงาน</i></a>
                                @else
                                    <a href="#" class="disabled"><i class="fa fa-pencil btn btn-secondary disabled">
                                            เขียน</i></a>
                                @endif
                            @else
                                <a href="#" class="disabled"><i class="fa fa-pencil btn btn-secondary disabled">
                                        เขียน</i></a>
                            @endif
                        </td>
                        <td>
                            @if ($currentMonth >= 4 && $currentMonth <= 6)
                               
                                @if ($item->statusID == 4)
                                   

                                    @if ($proID[$index] ?? '' === $item->proID)
                                        <a href="{{ route('report.quarter', [$item->proID, 3]) }}"><i
                                                class="fa fa-pencil btn btn-danger"> เสนอปิดโครงการ</i></a>
                                    @else
                                       
                                        <a href="{{ route('report.quarter', [$item->proID, 3]) }}"><i
                                                class="fa fa-pencil btn btn-primary">
                                                เขียน</i></a>
                                    @endif
                                @elseif($item->statusID == 13)
                                    <a href="{{ route('edit.evaluation', $item->proID) }}"><i
                                            class="fa fa-pencil btn btn-warning"> แก้ไขเอกสารเสนอปิดโครงการ</i></a>
                                @elseif ($item->statusID >= 5 && $item->statusID <= 11)
                                    <a href="{{ route('report.quarter', [$item->proID, 2]) }}"><i
                                            class="fa fa-eye btn btn-primary"> ดูรายงาน</i></a>
                                @else
                                    <a href="#" class="disabled"><i class="fa fa-pencil btn btn-secondary disabled">
                                            เขียน</i></a>
                                @endif
                            @else
                                <a href="#" class="disabled"><i class="fa fa-pencil btn btn-secondary disabled">
                                        เขียน</i></a>
                            @endif
                        </td>
                        <td>
                            @if ($currentMonth >= 7 && $currentMonth <= 9 && $item->statusID == 4)
                                <a href="{{ route('report.quarter', [$item->proID, 4]) }}"><i
                                        class="fa fa-pencil btn btn-primary"> เขียน</i></a>
                            @else
                                <a href="#" class="disabled"><i class="fa fa-pencil btn btn-secondary disabled">
                                        เขียน</i></a>
                            @endif
                        </td>
                        
                            @endif --}}

                </tr>
                @php
                    $i++;
                @endphp
            @endforeach
        </tbody>
    </table>
    {{-- <script>
        import DataTable from 'datatables.net-dt';
        import 'datatables.net-responsive-dt';

        let table = new DataTable('#myTable', {
            responsive: true
        });
    </script> --}}
    {{-- <a type='submit' class="btn btn-primary" href="/projectcreate">สร้างโปรเจค</a> --}}
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
