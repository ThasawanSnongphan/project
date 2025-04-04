@extends('layout')
@section('title', 'Project Evaluation')
@section('content')
    <div class="row">
        <div class="col-md-1 col-sm-1"></div>
        <div class="col-md-10 col-sm-10">
            <div class="x_panel">
                <div class="x_title">
                    <h2>เอกสารประเมินโครงการ</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                aria-expanded="false"><i class="fa fa-wrench"></i></a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#">Settings 1</a>
                                <a class="dropdown-item" href="#">Settings 2</a>
                            </div>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </ul>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">
                    @if (count($data['file']) > 0)
                        <form method="POST" enctype="multipart/form-data">
                            @csrf
                            <h6>เอกสารที่เกี่ยวข้องกับการประเมินโครงการ</h6>
                            <hr>
                            <div class="row field item form-group ">
                                <label
                                    class="col-form-lable col-md-3 col-sm-3 label-align"><b>เอกสารที่เกี่ยวข้อง</b></label>
                                <div class="col-md-7 col-sm-7">
                                    @foreach ($data['file'] as $item)
                                        <a href="{{ asset('files/' . $item->name) }}"
                                            target="_blank">{{ $item->name }}</a> <br>
                                    @endforeach
                                </div>
                            </div>
                        </form>
                    @endif
                    <form method="POST">
                        @csrf
                        @if (count($data['file']) > 0)
                            <h6>เอกสารประเมินโครงการ</h6>
                            <hr>
                        @endif
                        <div class="row field item form-group">
                            <label class="col-form-lable col-md-4 col-sm-4 label-align"><b>สถานะ :</b></label>
                            <div class="col-md-7 col-sm-7">
                                {{ $data['status']->name }}
                            </div>
                        </div>

                        <div class="row field item form-group">
                            <label class="col-form-lable col-md-4 col-sm-4 label-align"><b>คำชี้แจง :</b></label>
                            <div class="col-md-7 col-sm-7">
                                {{ $data['evaluation']->statement }}
                            </div>
                        </div>
                        <div class="row field item form-group">
                            <label class="col-form-lable col-md-4 col-sm-4 label-align"><b>ชื่อโครงการ/กิจกรรม :</b></label>
                            <div class="col-md-8 col-sm-8">
                                {{ $data['project']->name }}
                            </div>
                        </div>
                        <div class="row field item form-group ">
                            <label class="col-form-lable col-md-4 col-sm-4 label-align"><b>ตอบสนองยุทธศาสตร์ :</b></label>
                            <div class="col-md-8 col-sm-8">
                                @if (count($data['stra3LVMap']) > 0)
                                    @foreach ($data['stra3LVMap'] as $item)
                                        {{ $item->Stra3LV->name }} <br>
                                        <b>ประเด็นยุทธศาสตร์</b> {{ $item->SFA3LV->name }} <br>
                                        <b>เป้าประสงค์</b> {{ $item->goal3LV->name }} <br>
                                        <b>กลยุทธ์</b> {{ $item->tac3LV->name }} <br> <br>
                                    @endforeach
                                @endif
                                @if (count($data['stra2LVMap']) > 0)
                                    @foreach ($data['stra2LVMap'] as $item)
                                        {{ $item->stra2LV->name }} <br>
                                        <b>ประเด็นยุทธศาสตร์</b> {{ $item->SFA2LV->name }} <br>
                                        <b>กลยุทธ์</b> {{ $item->tac2LV->name }} <br> <br>
                                    @endforeach
                                @endif
                                @if (count($data['stra1LVMap']) > 0)
                                    @foreach ($data['stra1LVMap'] as $item)
                                        {{ $item->stra1LV->name }} <br>
                                        <b>เป้าหมาย</b> {{ $item->tar1LV->name }} <br>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <div class="row field item form-group ">
                            <label class="col-form-lable col-md-4 col-sm-4 label-align "><b>วิธีการดำเนินโครงการ
                                    :</b></label>
                            <div class="col-md-7 col-sm-7">
                                {{ $data['evaluation']->implementation }}
                            </div>
                        </div>

                        <div class="row field item form-group ">
                            <label class="col-form-lable col-md-4 col-sm-4 label-align"><b>ระยะเวลาในการดำเนินงาน
                                    :</b></label>
                            <div class="col-md-8 col-sm-8">
                                <b>เริ่มต้น</b> {{ $data['stepStartFormat'] }} <b>สิ้นสุด</b> {{ $data['stepEndFormat'] }}
                            </div>
                        </div>

                        <div class="row field item form-group ">
                            <label class="col-form-lable col-md-4 col-sm-4 label-align"><b>วัตถุประสงค์ :</b></label>
                            <div class="col-md-8 col-sm-8">
                                @php
                                    $index = 1;
                                @endphp
                                @foreach ($data['obj'] as $item)
                                    {{ $index++ }}.{{ $item->detail }} <br>
                                    @if ($item->achieve == 1)
                                        บรรลุ <br>
                                    @else
                                        ไม่บรรลุ <br>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <div class="row field item form-group ">
                            <label class="col-form-lable col-md-4 col-sm-4 label-align"><b>ผลการดำเนินงาน :</b></label>
                            <div class="col-md-8 col-sm-8">
                                {{ $data['evaluation']->operating->name }} <br>
                                @if ($data['evaluation']->since != null)
                                    <b>เนื่องจาก</b> {{ $data['evaluation']->since }}
                                @endif
                            </div>
                        </div>


                        <div class="row field item form-group ">
                            <label class="col-form-lable col-md-4 col-sm-4 label-align"><b>ผลการดำเนินงานตามตัวชี้วัดโครงการ
                                    :</b></label>
                            <div class="col-md-7 col-sm-7">
                                @foreach ($data['KPIProject'] as $item)
                                    -{{ $item->name }} <br>
                                    {{ $item->result_eva }} <br>
                                @endforeach
                            </div>
                        </div>

                        <div class="row field item form-group ">
                            <label class="col-form-lable col-md-4 col-sm-4 label-align"><b>งบประมาณที่ใช้ดำเนินการ
                                    :</b></label>
                            <div class="col-md-8 col-sm-8">
                                {{ $data['project']->badgetType->name }}
                            </div>
                        </div>

                        <div class="row field item form-group ">
                            <label class="col-form-lable col-md-4 col-sm-4 label-align"><b>ที่ได้รับจัดสรร :</b></label>
                            <div class="col-md-8 col-sm-8">
                                {{ $data['project']->badgetTotal }} บาท
                            </div>
                        </div>


                        <div class="row field item form-group ">
                            <label class="col-form-lable col-md-4 col-sm-4 label-align"><b>ใช้จริง :</b></label>
                            <div class="col-md-7 col-sm-7">
                                {{ $data['costResult'] }} บาท
                            </div>
                        </div>

                        <div class="row field item form-group ">
                            <label class="col-form-lable col-md-4 col-sm-4 label-align "><b>ประโยชน์ที่ได้รับจากการดำเนินโครงการ
                                    <br>
                                    (หลังการจัดโครงการ) :</b></label>
                            <div class="col-md-7 col-sm-7">
                                {{ $data['evaluation']->benefit }}
                            </div>
                        </div>

                        <div class="row field item form-group ">
                            <label class="col-form-lable col-md-4 col-sm-4 label-align "><b>ปัญหาและอุปสรรคในการดำเนินโครงการ
                                    :</b></label>
                            <div class="col-md-7 col-sm-7">
                                {{ $data['evaluation']->problem }}
                            </div>
                        </div>

                        <div class="row field item form-group ">
                            <label class="col-form-lable col-md-4 col-sm-4 label-align "><b>แนวทางการดำเนินการแก้ไข /
                                    ข้อเสนอแนะ :</b></label>
                            <div class="col-md-7 col-sm-7">
                                {{ $data['evaluation']->corrective_actions }}
                            </div>
                        </div>
                    </form>

                    <form action="" method="POST" id="actionForm">
                        @csrf
                        @if (count($data['comment']) > 0)
                        <div class="row field item form-group " style="background-color: #FFF9B1">
                            <label for="comment" class="col-form-lable col-md-4 col-sm-4 label-align" ><b>ข้อเสนอแนะ
                                    :</b></label>
                            <div class="col-md-6 col-sm-6">
                               @foreach ($data['comment'] as $item)
                                <b>{{$item->user->displayname}} : </b> {{$item->detail}} <br>
                                <b>เมื่อ</b> {{$item->created_at}} <br>
                               @endforeach
                            </div>
                        </div>
                        @endif
                        <div class="row field item form-group ">
                            <label for="comment" class="col-form-lable col-md-4 col-sm-4 label-align"> @if (count($data['comment']) == 0)
                                <b>ข้อเสนอแนะ
                                    :</b>
                            @endif</label>
                            <div class="col-md-6 col-sm-6">
                                <textarea name="comment" id="comment" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="form-group mt-2">
                            <div class="col-md-6 offset-md-3 d-flex justify-content-center">

                                <button type="submit" class="btn btn-success" onclick="submitButton('pass')">อนุมัติปิดโครงการ</button>
                                <button type="submit" class="btn btn-danger"
                                    onclick="submitButton('Denied')">ไม่อนุมัติ</button>

                                <button type="submit" class="btn btn-warning"
                                    onclick="submitButton('edit')">กลับไปแก้ไข</button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-1 col-sm-1"></div>
    </div>

    <script>
        function submitButton(action) {
            var form = document.getElementById('actionForm');
            if (action === 'pass') {
                form.action = "{{ route('Executive.PassEvaluation', $data['project']->proID) }}";
                form.submit();
            } else if (action === 'edit') {
                document.getElementById('comment').required = true;
                var comment = document.getElementById('comment').value.trim();
                if (comment !== "") {
                    form.action = "{{ route('Executive.EditEvaluation', $data['project']->proID) }}";
                    form.submit();
                }
            } else {
                document.getElementById('comment').required = true;
                var comment = document.getElementById('comment').value.trim();
                if (comment !== ""){
                    form.action = "{{ route('Executive.DeniedEvaluation', $data['project']->proID) }}";
                    form.submit();
                }  
            }
        }
    </script>
@endsection
