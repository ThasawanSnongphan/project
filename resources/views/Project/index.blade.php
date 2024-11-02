@extends('layout')
@section('title', 'Project')
@section('content')
    {{-- @include('Project.create') --}}
    
    <table id="example" class="display">
        <thead>

            <tr>
                <th>#</th>
                <th>ชื่อโครงการ</th>
                <th>สถานะ</th>
                <th>สถานะการจัดซื้อจัดจ้าง</th>
                <th>ไตรมาส 1</th>
                <th>ไตรมาส 2</th>
                <th>ไตรมาส 3</th>
                <th>ไตรมาส 4</th>
                <th></th>
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
                    <td>{{ $item->name }}</td>
                    <td>{{ $status->firstWhere('statusID', $item->statusID)->name ?? 'ไม่พบ' }}</td>
                    <td></td>
                    <td>
                        @if ($currentMonth >= 10 && $currentMonth <= 12)
                            <!-- เช็คว่าเป็นเดือนตุลาคมถึงธันวาคม -->
                            <a href=""><i class="fa fa-pencil btn btn-primary"> เขียน</i></a>
                        @else
                            <a href="#" class="disabled"><i class="fa fa-pencil btn btn-secondary disabled">
                                    เขียน</i></a>
                        @endif
                    </td>
                    <td>
                        @if ($currentMonth >= 1 && $currentMonth <= 3)
                        <!-- เช็คว่าเป็นเดือนตุลาคมถึงธันวาคม -->
                        <a href=""><i class="fa fa-pencil btn btn-primary"> เขียน</i></a>
                    @else
                        <a href="#" class="disabled"><i class="fa fa-pencil btn btn-secondary disabled">
                                เขียน</i></a>
                    @endif
                    </td>
                    <td>
                        @if ($currentMonth >= 4 && $currentMonth <= 6)
                        <!-- เช็คว่าเป็นเดือนตุลาคมถึงธันวาคม -->
                        <a href=""><i class="fa fa-pencil btn btn-primary"> เขียน</i></a>
                    @else
                        <a href="#" class="disabled"><i class="fa fa-pencil btn btn-secondary disabled">
                                เขียน</i></a>
                    @endif
                    </td>
                    <td>
                        @if ($currentMonth >= 7 && $currentMonth <= 9)
                        <!-- เช็คว่าเป็นเดือนตุลาคมถึงธันวาคม -->
                        <a href=""><i class="fa fa-pencil btn btn-primary"> เขียน</i></a>
                    @else
                        <a href="#" class="disabled"><i class="fa fa-pencil btn btn-secondary disabled">
                                เขียน</i></a>
                    @endif
                    </td>
                    <td>
                        <a href="{{route('project.edit',$item->proID)}}"><i class="fa fa-pencil btn btn-warning"></i></a>
                        <a href="{{route('project.delete',$item->proID)}}" onclick="return confirm('ต้องการลบโปรเจค {{$item->name}}  หรือไม่')"><i
                                class="fa fa-times btn btn-danger"></i></a>
                    </td>
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

@endsection
