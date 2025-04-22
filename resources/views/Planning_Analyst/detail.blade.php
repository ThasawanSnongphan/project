@extends('layout')
@section('title', 'Project')
@section('content')
    {{-- <div>
        <form action="{{ route('project.PDF', $data['project']->proID) }}" method="GET" target="_blank">
            <button type="submit" class="btn btn-danger">Export PDF</button>
        </form>
    </div>

    <div>
        <form action="{{ route('project.Word', $data['project']->proID) }}" method="GET">
            <button type="submit" class="btn btn-primary">Export Word</button>
        </form>
    </div> --}}

    <div class="col-md-1 col-sm-1"></div>
    <div class="col-md-10 col-sm-10">
        <div class="x_panel">
            <div class="x_title">
                <h2>เอกสารเสนอโครงการ</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                            aria-expanded="false"><i class="fa fa-file-text"></i></a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{ route('project.PDF', $data['project']->proID) }}" target="_blank"><i class="fa fa-file-pdf-o text-danger"></i> PDF</a>
                            <a class="dropdown-item" href="{{ route('project.Word', $data['project']->proID) }}"><i class="fa fa-file-word-o text-primary"></i> Word</a>
                        </div>
                    </li>
                    <li><a href="/project"><i class="fa fa-arrow-left"></i></a>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="POST">
                    @csrf

                    <div class="row field item form-group">
                        <label class="col-form-lable col-md-3 col-sm-3 label-align"><b>สถานะ :</b></label>
                        <div class="col-md-7 col-sm-7">
                            {{ $data['project']->status->name }}
                        </div>
                    </div>

                    <div class="row field item form-group">
                        <label class="col-form-lable col-md-3 col-sm-3 label-align"><b>ปีงบประมาณ :</b></label>
                        <div class="col-md-7 col-sm-7">
                            {{ $data['project']->year->year }}
                        </div>
                    </div>
                    <div class="row field item form-group">
                        <label class="col-form-lable col-md-3 col-sm-3 label-align"><b>ชื่อโครงการ :</b></label>
                        <div class="col-md-8 col-sm-8">
                            {{ $data['project']->name }}
                        </div>
                    </div>
                    <div class="row field item form-group">
                        <label class="col-form-lable col-md-3 col-sm-3 label-align"><b>เจ้าของโครงการ :</b></label>
                        <div class="col-md-8 col-sm-8">
                            @php
                                $index = 1;
                            @endphp
                            @foreach ($data['user'] as $item)
                                {{ $index++ }}. {{ $item->users->displayname }} สังกัด
                                {{ $item->users->faculty_name }}<br>
                            @endforeach
                        </div>
                    </div>
                    <div class="row field item form-group">
                        <label class="col-form-lable col-md-3 col-sm-3 label-align"><b>ผู้กำกับดูแลโครงการ :</b></label>
                        <div class="col-md-7 col-sm-7">
                            {{ $data['project']->Approver->displayname }}
                        </div>
                    </div>
                    <div class="row field item form-group">
                        <label class="col-form-lable col-md-3 col-sm-3 label-align"><b>format :</b></label>
                        <div class="col-md-8 col-sm-8">
                            {{ $data['project']->format }}
                        </div>
                    </div>


                    <div class="row field item form-group ">
                        <label class="col-form-lable col-md-3 col-sm-3 label-align"><b>ความสอดคล้องของแผน :</b></label>
                        <div class="col-md-9 col-sm-9">
                            @if (count($data['stra3LVMap']) > 0)
                                @foreach ($data['stra3LVMap'] as $item)
                                    <b>{{ $item->Stra3LV->name }}</b> <br>
                                    <b>ประเด็นยุทธศาสตร์</b> {{ $item->SFA3LV->name }} <br>
                                    <b>เป้าประสงค์</b> {{ $item->goal3LV->name }} <br>
                                    <b>กลยุทธ์</b> {{ $item->tac3LV->name }} <br>
                                @endforeach
                                <table class="table table-bordered">
                                    <tr style="text-align: center">
                                        <th>ตัวชี้วัดของแผน</th>
                                        <th>หน่วยนับ</th>
                                        <th>ค่าเป้าหมาย</th>

                                    </tr>
                                    @foreach ($data['KPI3LVMap'] as $item)
                                        <tr>
                                            <td>{{ $item->KPI->name }}</td>
                                            <td>{{ $item->KPI->count }}</td>
                                            <td>{{ $item->KPI->target }}</td>
                                        </tr>
                                    @endforeach
                                </table>

                            @endif
                            @if (count($data['stra2LVMap']) > 0)
                                @foreach ($data['stra2LVMap'] as $item)
                                    <br>
                                    <b>{{ $item->stra2LV->name }}</b> <br>
                                    <b>ประเด็นยุทธศาสตร์</b> {{ $item->SFA2LV->name }} <br>
                                    <b>กลยุทธ์</b> {{ $item->tac2LV->name }} <br> <br>
                                @endforeach
                                <table class="table table-bordered">
                                    <tr style="text-align: center">
                                        <th>ตัวชี้วัดของแผน</th>
                                        <th>หน่วยนับ</th>
                                        <th>ค่าเป้าหมาย</th>

                                    </tr>

                                    @foreach ($data['KPI2LVMap'] as $item)
                                        <tr>
                                            <td>{{ $item->KPI->name }}</td>
                                            <td> {{ $item->KPI->count ?? '-' }}</td>
                                            <td> {{ $item->KPI->target ?? '-' }} </td>
                                        </tr>
                                    @endforeach
                                </table>
                            @endif
                            @if (count($data['stra1LVMap']) > 0)
                                @foreach ($data['stra1LVMap'] as $item)
                                    <b>{{ $item->stra1LV->name }}</b> <br>
                                    <b>เป้าหมาย</b> {{ $item->tar1LV->name }}
                                @endforeach
                            @endif
                        </div>
                    </div>


                    <div class="row field item form-group ">
                        <label class="col-form-lable col-md-3 col-sm-3 label-align "><b>ประเภทโครงการ :</b></label>
                        <div class="col-md-7 col-sm-7">
                            {{ $data['project']->projectType->name }}
                        </div>
                    </div>

                    <div class="row field item form-group ">
                        <label class="col-form-lable col-md-3 col-sm-3 label-align"><b>ลักษณะโครงการ :</b></label>
                        <div class="col-md-8 col-sm-8">
                            {{ $data['project']->projectCharecter->name }}
                        </div>
                    </div>
                    <div class="row field item form-group ">
                        <label class="col-form-lable col-md-3 col-sm-3 label-align"><b>การบูรณาการ :</b></label>
                        <div class="col-md-8 col-sm-8">
                            {{ $data['project']->projectIntegrat->name }}
                            @if ($data['project']->proInDetail != null)
                                <br> เรื่อง {{ $data['project']->proInDetail }}
                            @endif
                        </div>
                    </div>
                    <div class="row field item form-group ">
                        <label class="col-form-lable col-md-3 col-sm-3 label-align"><b>หลักการและเหตุผล :</b></label>
                        <div class="col-md-8 col-sm-8">
                            {{ $data['project']->princiDetail }}
                        </div>
                    </div>

                    <div class="row field item form-group ">
                        <label class="col-form-lable col-md-3 col-sm-3 label-align"><b>วัตถุประสงค์ :</b></label>
                        <div class="col-md-8 col-sm-8">
                            @php
                                $index = 1;
                            @endphp
                            @foreach ($data['obj'] as $item)
                                {{ $index++ }}.{{ $item->detail }} <br>
                            @endforeach
                        </div>
                    </div>


                    <div class="row field item form-group ">
                        <label class="col-form-lable col-md-3 col-sm-3 label-align"><b>ตัวชี้วัดความสำเร็จ :</b></label>
                        <div class="col-md-8 col-sm-8">
                            <table class="table table-bordered">
                                <tr style="text-align: center">
                                    <th>ตัวชี้วัดความสำเร็จ</th>
                                    <th>หน่วยนับ</th>
                                    <th>ค่าเป้าหมาย</th>
                                </tr>
                                @foreach ($data['KPIProject'] as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->count->name }}</td>
                                        <td>{{ $item->target }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>

                    <div class="row field item form-group ">
                        <label class="col-form-lable col-md-3 col-sm-3 label-align"><b>กลุ่มเป้าหมาย :</b></label>
                        <div class="col-md-8 col-sm-8">
                            {{ $data['project']->target->name }}
                        </div>
                    </div>

                    <div class="row field item form-group ">
                        <label class="col-form-lable col-md-3 col-sm-3 label-align"><b>ขั้นตอนการดำเนินการ :</b></label>
                        <div class="col-md-8 col-sm-8">
                            <table class="table table-bordered">
                                <tr style="text-align: center">
                                    <th>รายการกิจกรรม</th>
                                    <th>เริ่มต้น</th>
                                    <th>สิ้นสุด</th>
                                </tr>

                                @foreach ($data['step'] as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->start }}</td>
                                        <td>{{ $item->end }}</td>
                                    </tr>
                                @endforeach


                            </table>
                        </div>
                    </div>


                    <div class="row field item form-group ">
                        <label class="col-form-lable col-md-3 col-sm-3 label-align"><b>แหล่งเงินประเภทงบประมาณที่ใช้
                                :</b></label>
                        <div class="col-md-8 col-sm-8">
                            {{ $data['project']->badgetType->name }}
                        </div>
                    </div>

                    <div class="row field item form-group ">
                        <label class="col-form-lable col-md-3 col-sm-3 label-align"><b>แผนงาน :</b></label>
                        <div class="col-md-8 col-sm-8">
                            {{ $data['project']->UniPlan->name }}
                        </div>
                    </div>


                    <div class="row field item form-group ">
                        <label class="col-form-lable col-md-3 col-sm-3 label-align"><b>ประเภทค่าใช้จ่าย :</b></label>
                        <div class="col-md-7 col-sm-7">
                            <table class="table table-bordered">
                                <tr>
                                    <th>งบรายจ่าย / หมวดรายจ่าย</th>
                                    <th>ไตรมาส1</th>
                                    <th>ไตรมาส2</th>
                                    <th>ไตรมาส3</th>
                                    <th>ไตรมาส4</th>
                                </tr>
                                @foreach ($data['costQuarter'] as $item)
                                    <tr>
                                        <td>
                                            {{ $item->exp->name }} <br>
                                            {{ $item->cost->name }}
                                        </td>
                                        <td><br>{{ $item->costQu1 }}</td>
                                        <td><br>{{ $item->costQu2 }}</td>
                                        <td><br>{{ $item->costQu3 }}</td>
                                        <td><br>{{ $item->costQu4 }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>

                    <div class="row field item form-group ">
                        <label class="col-form-lable col-md-3 col-sm-3 label-align "><b>ประมาณการงบประมาณที่ใช้
                            </b></label>
                        <div class="col-md-7 col-sm-7">
                            {{ $data['project']->badgetTotal }}
                        </div>
                    </div>

                    <div class="row field item form-group ">
                        <label class="col-form-lable col-md-3 col-sm-3 label-align "><b>ประโยชน์ที่คาดว่าจะได้รับ
                                :</b></label>
                        <div class="col-md-7 col-sm-7">
                            @php
                                $index = 1;
                            @endphp
                            @foreach ($data['benefit'] as $item)
                                {{ $index++ }}.{{ $item->detail }} <br>
                            @endforeach
                        </div>
                    </div>
                    @if (count($data['file']) > 0)
                        <div class="row field item form-group ">
                        <label class="col-form-lable col-md-3 col-sm-3 label-align "><b>ไฟล์เอกสารประกอบโครงการ
                                :</b></label>
                        <div class="col-md-7 col-sm-7">
                            @foreach ($data['file'] as $item)
                                <a href="{{ asset('files/' . $item->name) }}" target="_blank">{{ $item->name }}</a>
                                <br>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                </form>

                {{-- <div class="ln_solid"> --}}
                @if (count($data['comment']) > 0)
                    <div class="row field item form-group ">
                        <label for="comment" class="col-form-lable col-md-3 col-sm-3 label-align"><b>ข้อเสนอแนะ
                                :</b></label>
                        <div class="col-md-6 col-sm-6" style="background-color: #FFF9B1;">
                            @foreach ($data['comment'] as $item)
                                <b>{{ $item->user->displayname }}</b> :
                                {{ $item->detail }} <br>
                                <b>เมื่อ</b> {{ $item->created_at }} <br>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <form action="" method="POST" id="actionForm">
                    @csrf
                    <div class="row field item form-group ">
                        <label for="comment" class="col-form-lable col-md-3 col-sm-3 label-align">
                            @if (count($data['comment']) == 0)
                                <b>ข้อเสนอแนะ
                                    :</b>
                            @endif
                        </label>
                        <div class="col-md-6 col-sm-6">
                            <textarea name="comment" id="comment" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="form-group mt-2">
                        <div class="col-md-6 offset-md-3 d-flex justify-content-center">

                            <button type="submit" class="btn btn-success" onclick="submitButton('pass')">ผ่าน</button>


                        </div>
                    </div>
                </form>
                {{-- </div> --}}
            </div>
            <div class="clearfix"></div> 
        </div>
        {{-- <table class="table table-bordered">
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
            @if (count($strategic3LVMap) > 0)
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

            @if (count($strategic2LVMap) > 0)
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

            @if (count($strategic1LVMap) > 0)
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
                    @php
                        $index = 1;
                    @endphp
                    @foreach ($projectOBJ as $item)
                        @if ($project->proID === $item->proID)
                            {{$index++}}. {{ $item->detail }} <br>
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
                        <td colspan="3">{{ $item->name }}</td>
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
                    @php
                        $index = 1;
                    @endphp
                    @foreach ($projectStep as $item)
                        {{$index++}}. {{ $item->name }} <br>
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
                        - {{ $item->exp->name }} <br>
                    @endforeach
                </td>
                <td>
                    @foreach ($projectCostQuarter as $item)
                        - {{ $item->cost->name }} <br>
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
                    @php
                        $index = 1;
                    @endphp
                    @foreach ($projectBenefit as $item)
                        {{$index++}}. {{ $item->detail }} <br>
                    @endforeach
                </td>
            </tr>
            <tr>
                <th>ไฟล์เอกสารประกอบโครงการ</th>
                <td colspan="5">
                    @foreach ($file as $item)
                        <a href="{{ asset('files/' . $item->name) }}" target="_blank">{{ $item->name }}</a> <br>
                    @endforeach

                </td>
            </tr>
        </table> --}}





        <div class="col-md-1 col-sm-1"></div>

        <script>
            function submitButton(action) {
                var form = document.getElementById('actionForm');
                if (action === 'pass') {
                    form.action = "{{ route('planningPass', $data['project']->proID) }}";
                }
                form.submit();
            }
        </script>

    @endsection
