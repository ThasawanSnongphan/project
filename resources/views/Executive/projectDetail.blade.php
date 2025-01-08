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
                        <td colspan="3">{{ $item->year }}</td>
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
            <tr></tr>
            {{-- <td></td> --}}
            @endif
            @endforeach
            </tr>
            <tr>
                <th colspan="4">ตัวชี้วัดของแผน</th>
            </tr>
            <tr>
                <td></td>
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
                <td></td>
                <th>รายการกิจกรรม</th>
                <th>เริ่มต้น</th>
                <th>สิ้นสุด</th>
            </tr>
            <tr>
                {{-- <td></td> --}}
                @foreach ($projectStep as $item)
                    @if ($project->proID === $item->proID)
                        <td></td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->start }}</td>
                        <td>{{ $item->end }}</td>
            <tr></tr>
            @endif
            @endforeach
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
                <th colspan="4">ประเภทค่าใช้จ่าย</th>
            </tr>
            <tr>
                <th>งบรายจ่าย</th>
                @foreach ($projectCostQuarter as $item)
                    @if ($project->proID === $item->proID)
                        @foreach ($peojectEXP as $exp)
                            @if ($item->expID === $exp->expID)
                                <td colspan="3">{{ $exp->exname }}</td>
            <tr></tr>
            @endif
            @endforeach
            @endif
            @endforeach

            </tr>
            <tr>
                <th>หมวดรายจ่าย</th>
                @foreach ($projectCostQuarter as $item)
                    @if ($project->proID === $item->proID)
                        @foreach ($projectCostType as $cost)
                            @if ($item->costID === $cost->costID)
                                <td colspan="3">{{ $cost->costname }}</td>
            <tr></tr>
            @endif
            @endforeach
            @endif
            @endforeach
            </tr>
            <tr>
                <th>ไตรมาส 1 (ต.ค.-ธ.ค.)</th>
                <th>ไตรมาส 2 (ม.ค.-มี.ค.)</th>
                <th>ไตรมาส 3 (เม.ย.-มิ.ย.)</th>
                <th>ไตรมาส 4 (ก.ค.-ก.ย.)</th>
            </tr>
            <tr>
                @foreach ($projectCostQuarter as $item)
                    @if ($project->proID === $item->proID)
                        <td>{{ $item->costQu1 }}</td>
                        <td>{{ $item->costQu2 }}</td>
                        <td>{{ $item->costQu3 }}</td>
                        <td>{{ $item->costQu4 }}</td>
            <tr></tr>
            @endif
            @endforeach
            </tr>
            <tr>
                <th>ประมาณการงบประมาณที่ใช้</th>
                <td colspan="3">{{ $project->badgetTotal }}</td>
            </tr>
            <tr>
                <th>ประโยชน์ที่คาดว่าจะได้รับ</th>

                @foreach ($projectBenefit as $item)
                    @if ($project->proID === $item->proID)
                        <td colspan="3">{{ $item->detail }}</td>
            <tr></tr>
            {{-- <td></td> --}}
            @endif
            @endforeach
            </tr>
            <tr>
                <th>ไฟล์เอกสารประกอบโครงการ</th>
            </tr>
        </table>
        
      
           

            {{-- <div class="ln_solid"> --}}
            <form id="actionForm" method="POST" >
                @csrf
                <div class="">
                    <label for="comment" class="col-md-2 form-label label-align">ข้อเสนอแนะ</label>
                    <div class="col-md-6 col-sm-6">
                        <textarea name="comment" id="comment" class="form-control"></textarea>
                    </div>
                </div>
                <div class="form-group mt-2">
                    <div class="col-md-6 offset-md-3">

                        <button type="submit" class="btn btn-success" onclick="submitButton('pass')">ผ่าน</button>
                        <button type="submit" class="btn btn-warning" onclick="submitButton('edit')">กลับไปแก้ไข</button>
                        <button type="submit" class="btn btn-danger" onclick="submitButton('Denied')">ไม่อนุมัติ</button>

                    </div>
                </div>
            </form>
    
        
    </div>
    <div class="col-md-1 col-sm-1"></div>

    <script>
        function submitButton(action) {
            var form = document.getElementById('actionForm');
            if (action === 'pass') {
                form.action = "{{ route('ExecutivePass', $project->proID) }}";
            } else if (action === 'edit') {
                form.action = "{{ route('ExecutiveEdit', $project->proID) }}";
            }else{
                form.action = "{{ route('ExecutiveDenied', $project->proID) }}";
            }
            form.submit();
        }
    </script>

@endsection
