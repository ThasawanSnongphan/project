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
                        <h6>เอกสารประเมินโครงการ</h6>
                        <hr>
                        <div class="row field item form-group">
                            <label class="col-form-lable col-md-3 col-sm-3 label-align"><b>คำชี้แจง</b></label>
                            <div class="col-md-7 col-sm-7">
                                <textarea name="statement" id="statement" class="form-control"
                                    style="height:auto; min-height: 130px; max-height: 1000px; font-size: 12px;" readonly>การประเมินโครงการในรอบ 12 เดือนนี้จัดทำเพื่อศึกษา ติดตามและวิเคราห์ถึงผลลัพธ์ของแผนงาน/โครงการตามที่มหาวิทยาลัยได้จัดสรรงยประมาณให้ ว่าสามารถดำเนินการตามที่กำหนดไว้ได้หรือไม่รวมทั้งเป็นการศึกษาปัญหาอุปสรรคของการดำเนินงานแผนงาน/โครงการ การหาแนวทางการแก้ไขปัญหา การเตรียมความพร้อมสำหรับการดำเนินงานแผนงาน/โครงการครั้งต่อไป และเป็นข้อมูลประกอบการตัดสินใจสำหรับผู้บริหารในการจัดสรรงบประมาณโครงการในปีงบประมาณต่อไปด้วย ในการนี้ สำนักคอมพิวเตอร์ฯ จึงใคร่ขอความกรุณารายงานแบบประเมินผลดำเนินงาน/โครงการ ดังนี้</textarea>
                            </div>
                        </div>
                        <div class="row field item form-group">
                            <label class="col-form-lable col-md-3 col-sm-3 label-align"><b>ชื่อโครงการ/กิจกรรม</b></label>
                            <div class="col-md-8 col-sm-8">
                                {{ $data['project']->name }}
                            </div>
                        </div>
                        <div class="row field item form-group ">
                            <label class="col-form-lable col-md-3 col-sm-3 label-align"><b>ตอบสนองยุทธศาสตร์</b></label>
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
                            <label class="col-form-lable col-md-3 col-sm-3 label-align "><b>วิธีการดำเนินโครงการ</b></label>
                            <div class="col-md-7 col-sm-7">
                                <textarea name="implement" id="implement" class="form-control" style="min-height: 100px; height: auto;" readonly>{{ $data['evaluation']->implementation }}</textarea>
                            </div>
                        </div>

                        <div class="row field item form-group ">
                            <label
                                class="col-form-lable col-md-3 col-sm-3 label-align"><b>ระยะเวลาในการดำเนินงาน</b></label>
                            <div class="col-md-8 col-sm-8">
                                <b>เริ่มต้น</b> {{ $data['stepStartFormat'] }} <b>สิ้นสุด</b> {{ $data['stepEndFormat'] }}
                            </div>
                        </div>

                        <div class="row field item form-group ">
                            <label class="col-form-lable col-md-3 col-sm-3 label-align"><b>วัตถุประสงค์</b></label>
                            <div class="col-md-8 col-sm-8">
                                @php
                                    $index = 1;
                                @endphp
                                @foreach ($data['obj'] as $item)
                                    {{ $index++ }}.{{ $item->detail }} <br>
                                    @if ($item->achieve == 1)
                                        บรรลุ
                                    @else
                                        ไม่บรรลุ
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <div class="row field item form-group ">
                            <label class="col-form-lable col-md-3 col-sm-3 label-align"><b>ผลการดำเนินงาน</b></label>
                            <div class="col-md-8 col-sm-8">
                                {{ $data['evaluation']->operating->name }} <br>
                                @if ($data['evaluation']->since != null)
                                    {{ $data['evaluation']->since }}
                                @endif
                            </div>
                        </div>


                        <div class="row field item form-group ">
                            <label
                                class="col-form-lable col-md-3 col-sm-3 label-align"><b>ผลการดำเนินงานตามตัวชี้วัดโครงการ</b></label>
                            <div class="col-md-7 col-sm-7">
                                @foreach ($data['KPIProject'] as $item)
                                    -{{ $item->name }} <br>
                                    <input name="result_eva[]" class="form-control" value="{{ $item->result_eva }}"
                                        readonly>
                                @endforeach
                            </div>
                        </div>

                        <div class="row field item form-group ">
                            <label
                                class="col-form-lable col-md-3 col-sm-3 label-align"><b>งบประมาณที่ใช้ดำเนินการ</b></label>
                            <div class="col-md-8 col-sm-8">
                                {{ $data['project']->badgetType->name }}
                            </div>
                        </div>

                        <div class="row field item form-group ">
                            <label class="col-form-lable col-md-3 col-sm-3 label-align"><b>ที่ได้รับจัดสรร</b></label>
                            <div class="col-md-8 col-sm-8">
                                {{ $data['project']->badgetTotal }} บาท
                            </div>
                        </div>


                        <div class="row field item form-group ">
                            <label class="col-form-lable col-md-3 col-sm-3 label-align"><b>ใช้จริง</b></label>
                            <div class="col-md-7 col-sm-7">
                                <input type="text" class="form-control" name="badget_use" required
                                    value="{{ $data['costResult'] }} " readonly>

                            </div>
                        </div>

                        <div class="row field item form-group ">
                            <label class="col-form-lable col-md-3 col-sm-3 label-align "><b>ประโยชน์ที่ได้รับจากการดำเนินโครงการ
                                    (หลังการจัดโครงการ)</b></label>
                            <div class="col-md-7 col-sm-7">
                                <textarea name="benefit" id="benefit" class="form-control" style="min-height: 100px" readonly>{{ $data['evaluation']->benefit }}</textarea>
                            </div>
                        </div>

                        <div class="row field item form-group ">
                            <label
                                class="col-form-lable col-md-3 col-sm-3 label-align "><b>ปัญหาและอุปสรรคในการดำเนินโครงการ</b></label>
                            <div class="col-md-7 col-sm-7">
                                <textarea name="problem" id="problem" class="form-control" style="min-height: 100px" readonly>{{ $data['evaluation']->problem }}</textarea>
                            </div>
                        </div>

                        <div class="row field item form-group ">
                            <label class="col-form-lable col-md-3 col-sm-3 label-align "><b>แนวทางการดำเนินการแก้ไข /
                                    ข้อเสนอแนะ</b></label>
                            <div class="col-md-7 col-sm-7">
                                <textarea name="corrective" id="corrective" class="form-control" style="min-height: 100px" readonly>{{ $data['evaluation']->corrective_actions }}</textarea>
                            </div>
                        </div>




                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-1 col-sm-1"></div>
    </div>

@endsection
