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
            <tr>
                <th style="width: 25%;">ปีงบประมาณ</th>
                @foreach ($projectYear as $item)
                    @if ($item->yearID === $project->yearID)
                        <td colspan="3">{{ $item->name }}</td>
                    @endif
                @endforeach

            </tr>
            <tr>
                <th>ชื่อโครงการ</th>
                <td colspan="3">{{ $project->name }}</td>
            </tr>
            <tr>
                <th>เจ้าของโครงการ</th>
            </tr>
            <tr>
                <th>สังกัด</th>
            </tr>
            <tr>
                <th>format</th>
                <td colspan="3">{{ $project->format }}</td>
            </tr>
            <tr>
                <th>แผนยุทธศาสตร์</th>
            </tr>
            <tr>
                <th>ประเด็นยุทธศาสตร์</th>
            </tr>
            <tr>
                <th>เป้าประสงค์</th>
            </tr>
            <tr>
                <th>กลยุทธ์</th>
            </tr>
            <tr>
                <th>ประเภทโครงการ</th>
                @foreach ($projectType as $item)
                    @if ($project->proTypeID === $item->proTypeID)
                        <td colspan="3">{{ $item->name }}</td>
                    @endif
                @endforeach


            </tr>
            <tr>
                <th>ลักษณะโครงการ</th>
                @foreach ($projectCharector as $item)
                    @if ($project->proChaID === $item->proChaID)
                        <td colspan="3">{{ $item->pro_cha_name }}</td>
                    @endif
                @endforeach
            </tr>
            <tr>
                <th @if (!empty($project->proInDetail)) rowspan="2" @endif>การบูรณาการ</th>
                @foreach ($projectIntegrat as $item)
                    @if ($project->proInID === $item->proInID)
                        <td colspan="3">{{ $item->name }}</td>
                    @endif
                @endforeach
            </tr>
            @if (!empty($project->proInDetail))
                <tr>
                    <td colspan="3">{{ $project->proInDetail }}</td>
                </tr>
            @endif

            <tr>
                <th>หลักการและเหตุผล</th>
                <td colspan="3">{{ $project->princiDetail }}</td>
            </tr>
            <tr>
                <th>วัตถุประสงค์</th>
                @foreach ($projectOBJ as $item)
                    @if ($project->proID === $item->proID)
                    <td colspan="3">{{ $item->name }}</td>
                      
                    @endif
                @endforeach
            </tr>
            <tr>
                <th colspan="3">ตัวชี้วัดของแผน</th>
            </tr>
            <tr>
                <th>ตัวชี้วัดความสำเร็จ</th>
                <th>หน่วยนับ</th>
                <th>ค่าเป้าหมาย</th>
            </tr>
            <tr>
                <th>กลุ่มเป้าหมาย</th>
                @foreach ($projectTarget as $item)
                    @if ($project->tarID === $item->tarID)
                        <td colspan="3">{{ $item->name }}</td>
                    @endif
                @endforeach
            </tr>
            <tr>
                <th colspan="3">ขั้นตอนการดำเนินการ</th>
            </tr>
            <tr>
                <th>รายการกิจกรรม</th>
                <th>เริ่มต้น</th>
                <th>สิ้นสุด</th>
            </tr>
            <tr>
                <th>แหล่งเงินประเภทงบประมาณที่ใช้</th>
                @foreach ($projectBadgetType as $item)
                    @if ($project->badID === $item->badID)
                        <td colspan="3">{{ $item->name }}</td>
                    @endif
                @endforeach
            </tr>
            <tr>
                <th>แผนงาน</th>
                @foreach ($projectUniPlan as $item)
                    @if ($project->planID === $item->planID)
                        <td colspan="3">{{ $item->name }}</td>
                    @endif
                @endforeach
            </tr>
            <tr>
                <th colspan="4">ประมาณการค่าใช้จ่าย</th>
            </tr>
            <tr>
                <th>งบรายจ่าย</th>
            </tr>
            <tr>
                <th>หมวดรายจ่าย</th>
            </tr>
            <tr>
                <th>ไตรมาส 1 (ต.ค.-ธ.ค.)</th>

                <th>ไตรมาส 1 (ม.ค.-มี.ค.)</th>

                <th>ไตรมาส 1 (เม.ย.-มิ.ย.)</th>

                <th>ไตรมาส 1 (ก.ค.-ก.ย.)</th>
            </tr>
            <tr>
                <th>ประมาณการงบประมาณที่ใช้</th>
                <td colspan="3">{{ $project->badgetTotal }}</td>
            </tr>
            <tr>
                <th>ประโยชน์ที่คาดว่าจะได้รับ</th>
            </tr>
            <tr>
                <th>ไฟล์เอกสารประกอบโครงการ</th>
            </tr>
        </table>
    </div>
    <div class="col-md-1 col-sm-1"></div>



@endsection
