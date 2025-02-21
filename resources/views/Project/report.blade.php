@extends('layout')
@section('title', 'Project')
@section('content')
    <div>
        <form action="{{ route('project.PDF', $project->proID) }}" method="GET" target="_blank">
            <button type="submit" class="btn btn-danger">Export PDF</button>
        </form>
    </div>

    <div>
        <form action="{{ route('project.Word', $project->proID) }}" method="GET">
            <button type="submit" class="btn btn-primary">Export Word</button>
        </form>
    </div>

    <div class="col-md-1 col-sm-1"></div>
    <div class="col-md-10 col-sm-10">
        <table class="table table-bordered">
            @if (count($comment) > 0)
                <tr>
                    <th>ข้อเสนอเเนะ</th>
                    <td colspan="5" >
                        @foreach ($comment as $item)
                            {{$item->user->firstname_en}} {{$item->user->lastname_en}} : {{$item->detail}} <br> เมื่อ {{$item->created_at}} <br>
                        @endforeach 
                    </td>
                </tr>
            @endif
            <tr>
                <th style="width: 15%">สถานะ</th>
                <td colspan="5">{{ $status->name }}</td>
            </tr>
            <tr>
                <th style="width: 15%">ปีงบประมาณ</th>
                @foreach ($projectYear as $item)
                    @if ($item->yearID === $project->yearID)
                        <td colspan="5">{{ $item->year }}</td>
                    @endif
                @endforeach

            </tr>
            <tr>
                <th style="width: 15%">ชื่อโครงการ</th>
                <td colspan="5">{{ $project->name }}</td>
            </tr>
            <tr>
                <th>เจ้าของโครงการ</th>
                <td colspan="5">
                    @foreach ($userMap as $item)
                        @if ($item->proID == $project->proID)
                            {{ $item->users->firstname_en }} {{ $item->users->lastname_en }} <br>
                        @endif
                    @endforeach
                </td>
            </tr>
            <tr>
                <th>สังกัด</th>
                <td colspan="5">
                    @foreach ($userMap as $item)
                        @if ($item->proID == $project->proID)
                            {{ $item->users->position_name }} <br>
                        @endif
                    @endforeach
                </td>
            </tr>
            <tr>
                <th>format</th>
                <td colspan="5">{{ $project->format }}</td>
            </tr>

            @if (!empty($strategic3LVMap))
                @foreach ($strategic3LVMap as $item)
                    <tr>
                        <th>แผนยุทธศาสตร์</th>
                        <td colspan="5">{{ $item->Stra3LV->name }}</td>
                    </tr>
                    <tr>
                        <th>ประเด็นยุทธศาสตร์</th>
                        <td colspan="5">{{ $item->SFA3LV->name }}</td>
                    </tr>
                    <tr>
                        <th>เป้าประสงค์</th>
                        <td colspan="5">{{ $item->goal3LV->name }}</td>
                    </tr>
                    <tr>
                        <th>กลยุทธ์</th>
                        <td colspan="5">{{ $item->tac3LV->name }}</td>
                    </tr>
                @endforeach
                <tr style="text-align: center">
                    <th colspan="4">ตัวชี้วัดของแผน</th>
                    <th>หน่วยนับ</th>
                    <th>ค่าเป้าหมาย</th>
                </tr>
                <tr>
                    <td colspan="4">
                        @foreach ($KPI3LVMap as $item)
                            {{ $item->KPI->name }} <br>
                        @endforeach
                    </td>
                    <td>
                        @foreach ($KPI3LVMap as $item)
                            {{ $item->KPI->count }} <br>
                        @endforeach
                    </td>
                    <td>
                        @foreach ($KPI3LVMap as $item)
                            {{ $item->KPI->target }} <br>
                        @endforeach
                    </td>
                </tr>
            @endif
            @if (!empty($strategic2LVMap))
                @foreach ($strategic2LVMap as $item)
                    <tr>
                        <th>แผนยุทธศาสตร์</th>
                        <td colspan="5">{{ $item->stra2LV->name }}</td>
                    </tr>
                    <tr>
                        <th>ประเด็นยุทธศาสตร์</th>
                        <td colspan="5">{{ $item->SFA2LV->name }}</td>
                    </tr>
                    <tr>
                        <th>กลยุทธ์</th>
                        <td colspan="5">{{ $item->tac2LV->name }}</td>
                    </tr>
                @endforeach
                <tr style="text-align: center">
                    <th colspan="4">ตัวชี้วัดของแผน</th>
                    <th>หน่วยนับ</th>
                    <th>ค่าเป้าหมาย</th>
                </tr>
                <tr>
                    <td colspan="4">
                        @foreach ($KPI2LVMap as $item)
                            - {{ $item->KPI->name }} <br>
                        @endforeach
                    </td>
                    <td>
                        @foreach ($KPI2LVMap as $item)
                            {{ $item->KPI->count ?? '-' }} <br>
                        @endforeach
                    </td>
                    <td>
                        @foreach ($KPI2LVMap as $item)
                            {{ $item->KPI->target ?? '-' }} <br>
                        @endforeach
                    </td>
                </tr>
            @endif
            @if (!empty($strategic1LVMap))
                @foreach ($strategic1LVMap as $item)
                    <tr>
                        <th>แผนยุทธศาสตร์</th>
                        <td colspan="5">{{ $item->stra1LV->name }}</td>
                    </tr>
                    <tr>
                        <th>เป้าหมาย</th>
                        <td colspan="5">{{ $item->tar1LV->name }}</td>
                    </tr>
                @endforeach
            @endif


            <tr>
                <th>ประเภทโครงการ</th>
                @foreach ($projectType as $item)
                    @if ($project->proTypeID === $item->proTypeID)
                        <td colspan="5">{{ $item->name }}</td>
                    @endif
                @endforeach


            </tr>
            <tr>
                <th>ลักษณะโครงการ</th>
                @foreach ($projectCharector as $item)
                    @if ($project->proChaID === $item->proChaID)
                        <td colspan="5">{{ $item->name }}</td>
                    @endif
                @endforeach
            </tr>
            <tr>
                <th>การบูรณาการ</th>
                <td colspan="5">
                    @foreach ($projectIntegrat as $item)
                        @if ($project->proInID === $item->proInID)
                            {{ $item->name }}
                        @endif
                    @endforeach
                </td>
            </tr>
            @if (!empty($project->proInDetail))
                <tr>
                    <td colspan="5">{{ $project->proInDetail }}</td>
                </tr>
            @endif

            <tr>
                <th>หลักการและเหตุผล</th>
                <td colspan="5">{{ $project->princiDetail }}</td>
            </tr>
            <tr>
                <th>วัตถุประสงค์</th>
                <td colspan="5">
                    @foreach ($projectOBJ as $item)
                        @if ($project->proID === $item->proID)
                            {{ $item->detail }} <br>
                        @endif
                    @endforeach
                </td>
            </tr>

            <tr style="text-align: center">
                <th colspan="4">ตัวชี้วัดความสำเร็จ</th>
                <th>หน่วยนับ</th>
                <th>ค่าเป้าหมาย</th>
            </tr>
            <tr>
                <td colspan="4">
                    @foreach ($KPIProject as $item)
                        - {{ $item->name }} <br>
                    @endforeach
                </td>
                <td>
                    @foreach ($KPIProject as $item)
                        {{ $item->count->name }} <br>
                    @endforeach
                </td>
                <td>
                    @foreach ($KPIProject as $item)
                        {{ $item->target }} <br>
                    @endforeach
                </td>

            </tr>
            <tr>
                <th>กลุ่มเป้าหมาย</th>
                @foreach ($projectTarget as $item)
                    @if ($project->tarID === $item->tarID)
                        <td colspan="5">{{ $item->name }}</td>
                    @endif
                @endforeach
            </tr>
            <tr>
                <th colspan="6">ขั้นตอนการดำเนินการ</th>
            </tr>
            <tr style="text-align: center">
                <th colspan="4">รายการกิจกรรม</th>
                <th>เริ่มต้น</th>
                <th>สิ้นสุด</th>
            </tr>
            <tr>
                <td colspan="4">
                    @foreach ($projectStep as $item)
                        - {{ $item->name }} <br>
                    @endforeach
                </td>
                <td>
                    @foreach ($projectStep as $item)
                        {{ $item->start }} <br>
                    @endforeach
                </td>
                <td>
                    @foreach ($projectStep as $item)
                        {{ $item->end }} <br>
                    @endforeach
                </td>
            </tr>
            <tr>
                <th>แหล่งเงินประเภทงบประมาณที่ใช้</th>
                @foreach ($projectBadgetType as $item)
                    @if ($project->badID === $item->badID)
                        <td colspan="5">{{ $item->name }}</td>
                    @endif
                @endforeach
            </tr>
            <tr>
                <th>แผนงาน</th>
                @foreach ($projectUniPlan as $item)
                    @if ($project->planID === $item->planID)
                        <td colspan="5">{{ $item->name }}</td>
                    @endif
                @endforeach
            </tr>
            <tr>
                <th colspan="6">ประเภทค่าใช้จ่าย</th>
            </tr>
            <tr>
                <th style="width: 15%">งบรายจ่าย</th>
                <th style="width: 15%">หมวดรายจ่าย</th>
                <th style="width: 15%">ไตรมาส 1 (ต.ค.-ธ.ค.)</th>
                <th style="width: 15%">ไตรมาส 2 (ม.ค.-มี.ค.)</th>
                <th style="width: 15%">ไตรมาส 3 (เม.ย.-มิ.ย.)</th>
                <th style="width: 15%">ไตรมาส 4 (ก.ค.-ก.ย.)</th>
            </tr>
            <tr>
                <td>
                    @foreach ($projectCostQuarter as $item)
                        - {{$item->exp->name}} <br>
                    @endforeach
                </td>
                <td>
                    @foreach ($projectCostQuarter as $item)
                        - {{$item->cost->name}} <br>
                    @endforeach
                </td>
                <td>
                    @foreach ($projectCostQuarter as $item)
                        {{ $item->costQu1 }} บาท<br>
                    @endforeach
                </td>
                <td>
                    @foreach ($projectCostQuarter as $item)
                        {{ $item->costQu2 }} บาท<br>
                    @endforeach
                </td>
                <td>
                    @foreach ($projectCostQuarter as $item)
                        {{ $item->costQu3 }} บาท<br>
                    @endforeach
                </td>
                <td>
                    @foreach ($projectCostQuarter as $item)
                        {{ $item->costQu4 }} บาท<br>
                    @endforeach
                </td>
            </tr>
            <tr>
                <th>ประมาณการงบประมาณที่ใช้</th>
                <td colspan="5">{{ $project->badgetTotal }} บาท</td>
            </tr>
            <tr>
                <th>ประโยชน์ที่คาดว่าจะได้รับ</th>
                <td colspan="5">
                    @foreach ($projectBenefit as $item)
                        - {{ $item->detail }} <br>
                    @endforeach
                </td>
            </tr>
            <tr>
                <th>ไฟล์เอกสารประกอบโครงการ</th>
                <td colspan="5">
                    @foreach ($file as $item)
                        <a href="{{ asset('files/' . $item->name) }}" target="_blank">{{ $item->name ?? '-'}}</a> <br>
                    @endforeach

                </td>
            </tr>
        </table>

        {{-- </div> --}}
    </div>
    <div class="col-md-1 col-sm-1"></div>



@endsection
