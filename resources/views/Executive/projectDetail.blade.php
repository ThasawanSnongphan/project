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
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
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
                                {{ $index++ }}. {{ $item->users->displayname }} <b>สังกัด</b>
                                {{ $item->users->department_name }}<br>
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
                                    <b>เป้าหมาย</b> {{ $item->tar1LV->name }} <br>
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
                                    <a href="{{ asset('files/' . $item->name) }}"
                                        target="_blank">{{ $item->name }}</a> <br>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </form>
                @if (count($data['comment']) > 0)
                    <div class="row field item form-group ">
                        <label for="comment" class="col-form-lable col-md-3 col-sm-3 label-align"><b>ข้อเสนอแนะ
                                :</b></label>
                        <div class="col-md-6 col-sm-6" style="background-color: #FFF9B1;">
                            @foreach ($data['comment'] as $item)
                                <b>{{ $item->user->displayname }} </b> : {{ $item->detail }} <br>
                                <b>เมื่อ</b> {{ $item->created_at }} <br>
                            @endforeach
                        </div>
                    </div>
                @endif
                <form action="" method="POST" id="actionForm">
                    @csrf
                    <div class="row field item form-group ">
                        <label for="comment" class="col-form-lable col-md-3 col-sm-3 label-align">
                            @if (count($data['comment']) < 0)
                                <b>ข้อเสนอแนะ
                                    :</b>
                            @endif
                        </label>
                        <div class="col-md-6 col-sm-6">
                            <textarea name="comment" id="comment" class="form-control"></textarea>
                        </div>
                    </div>

                    @if ($data['project']->statusID == 1)
                        <div class="form-group mt-2">
                            <div class="col-md-6 offset-md-3 d-flex justify-content-center">

                                <button type="submit" class="btn btn-success"
                                    onclick="submitButton('pass')">ผ่าน</button>
                                <button type="submit" class="btn btn-danger"
                                    onclick="submitButton('edit')">กลับไปแก้ไข</button>

                            </div>
                        </div>
                    @else
                        <div class="form-group mt-2">
                            <div class="col-md-6 offset-md-3 d-flex justify-content-center">

                                <button type="submit" class="btn btn-success"
                                    onclick="submitButton('approve')">อนุมัติ</button>
                                <button type="submit" class="btn btn-danger"
                                    onclick="submitButton('Denied')">ไม่อนุมัติ</button>
                                <button type="submit" class="btn btn-warning"
                                    onclick="submitButton('edit')">กลับไปแก้ไข</button>

                            </div>
                        </div>
                    @endif
                </form>
            </div>
        </div>

      



    </div>
    <div class="col-md-1 col-sm-1"></div>

    <script>
        function submitButton(action) {
            var form = document.getElementById('actionForm');
            if (action === 'pass') {
                form.action = "{{ route('ExecutivePass', $data['project']->proID) }}";
                form.submit();
            }else if (action === 'approve'){
                form.action = "{{ route('ExecutiveApprove', $data['project']->proID) }}";
                form.submit();
            }
             else if (action === 'edit') {
                document.getElementById('comment').required = true;
                var comment = document.getElementById('comment').value.trim();
                if (comment !== "") {
                    form.action = "{{ route('ExecutiveEdit', $data['project']->proID) }}";
                    form.submit();
                }
            } else {
                document.getElementById('comment').required = true;
                var comment = document.getElementById('comment').value.trim();
                if (comment !== "") {
                    form.action = "{{ route('ExecutiveDenied', $data['project']->proID) }}";
                    form.submit();
                }
            }
        }
    </script>

@endsection
