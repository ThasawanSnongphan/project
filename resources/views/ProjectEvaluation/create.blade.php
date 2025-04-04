@extends('layout')
@section('title', 'Project Evaluation')
@section('content')
    <div class="row">
        <div class="col-md-1 col-sm-1"></div>
        <div class="col-md-10 col-sm-10">
            <div class="x_panel">
                <div class="x_title">
                    <h2>เขียนเอกสารประเมินโครงการ</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
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
                        <form method="POST" action="/fileEvaluation/{{$data['project']->proID}}" enctype="multipart/form-data">
                            @csrf
                            <h6>upload เอกสารที่เกี่ยวข้องกับการประเมินโครงการ</h6> <hr>
                            <div class="row field item form-group ">
                                <label class="col-form-lable col-md-3 col-sm-3 label-align"><b>upload เอกสารที่เกี่ยวข้อง</b></label>
                                <div class="col-md-7 col-sm-7 d-flex">
                                   <input type="file" class="form-control" name="file" required>
                                   <button type="submit" class="btn btn-primary">upload</button>
                                </div>
                            </div>
                            <div class="row field item form-group ">
                                <label class="col-form-lable col-md-3 col-sm-3 label-align"><b>เอกสารที่เกี่ยวข้อง</b></label>
                                <div class="col-md-7 col-sm-7">
                                    
                                    @foreach ($data['file'] as $item)
                                    <a href="{{ asset('files/' . $item->name) }}"
                                        target="_blank">{{ $item->name }}</a> <br>

                                    @endforeach
                                </div>
                            </div>

                        </form>
                        <form method="POST"  action="/projectSaveEvaluation/{{$data['project']->proID}}">
                            @csrf
                            <h6>เขียนเอกสารประเมินโครงการ</h6> <hr>
                            <div class="row field item form-group">
                                <label class="col-form-lable col-md-3 col-sm-3 label-align"><b>คำชี้แจง</b></label>
                                <div class="col-md-7 col-sm-7">
                                    <textarea name="statement" id="statement" class="form-control" style="height:auto; min-height: 130px; max-height: 1000px; font-size: 12px;">การประเมินโครงการในรอบ 12 เดือนนี้จัดทำเพื่อศึกษา ติดตามและวิเคราห์ถึงผลลัพธ์ของแผนงาน/โครงการตามที่มหาวิทยาลัยได้จัดสรรงยประมาณให้ ว่าสามารถดำเนินการตามที่กำหนดไว้ได้หรือไม่รวมทั้งเป็นการศึกษาปัญหาอุปสรรคของการดำเนินงานแผนงาน/โครงการ การหาแนวทางการแก้ไขปัญหา การเตรียมความพร้อมสำหรับการดำเนินงานแผนงาน/โครงการครั้งต่อไป และเป็นข้อมูลประกอบการตัดสินใจสำหรับผู้บริหารในการจัดสรรงบประมาณโครงการในปีงบประมาณต่อไปด้วย ในการนี้ สำนักคอมพิวเตอร์ฯ จึงใคร่ขอความกรุณารายงานแบบประเมินผลดำเนินงาน/โครงการ ดังนี้</textarea>
                                </div>
                            </div>
                            <div class="row field item form-group">
                                <label class="col-form-lable col-md-3 col-sm-3 label-align"><b>ชื่อโครงการ/กิจกรรม</b></label>
                                <div class="col-md-8 col-sm-8">
                                    {{$data['project']->name}}
                                </div>
                            </div>
                            <div class="row field item form-group ">
                                <label class="col-form-lable col-md-3 col-sm-3 label-align"><b>ตอบสนองยุทธศาสตร์</b></label>
                                <div class="col-md-8 col-sm-8">
                                    @if (!empty($data['stra3LVMap']))
                                    @foreach ($data['stra3LVMap'] as $item)
                                    {{$item->Stra3LV->name}} <br>
                                    <b>ประเด็นยุทธศาสตร์</b> {{$item->SFA3LV->name}} <br>
                                    <b>เป้าประสงค์</b> {{$item->goal3LV->name}} <br>
                                    <b>กลยุทธ์</b> {{$item->tac3LV->name}} <br> <br>
                                @endforeach
                                    @endif
                                   @if (!empty($data['stra2LVMap']))
                                       @foreach ($data['stra2LVMap'] as $item)
                                           {{$item->stra2LV->name}} <br>
                                           <b>ประเด็นยุทธศาสตร์</b> {{$item->SFA2LV->name}} <br>
                                           <b>กลยุทธ์</b> {{$item->tac2LV->name}} <br> <br>
                                       @endforeach
                                   @endif
                                   @if (!empty($data['stra1LVMap']))
                                       @foreach ($data['stra1LVMap'] as $item)
                                           {{$item->stra1LV->name}} <br>
                                           <b>เป้าหมาย</b> {{$item->tar1LV->name}} <br>
                                       @endforeach
                                   @endif
                                </div>
                            </div>

                            <div class="row field item form-group ">
                                <label class="col-form-lable col-md-3 col-sm-3 label-align "><b>วิธีการดำเนินโครงการ</b></label>
                                <div class="col-md-7 col-sm-7" >
                                   <textarea name="implement" id="implement" class="form-control" style="min-height: 100px; height: auto;" required></textarea>
                                </div>
                            </div>

                            <div class="row field item form-group ">
                                <label class="col-form-lable col-md-3 col-sm-3 label-align"><b>ระยะเวลาในการดำเนินงาน</b></label>
                                <div class="col-md-8 col-sm-8">
                                   <b>เริ่มต้น</b> {{$data['stepStartFormat']}} <b>สิ้นสุด</b> {{$data['stepEndFormat']}}
                                </div>
                            </div>

                            <div class="row field item form-group ">
                                <label class="col-form-lable col-md-3 col-sm-3 label-align"><b>วัตถุประสงค์</b></label>
                                <div class="col-md-8 col-sm-8">
                                   @foreach ($data['obj'] as $item)
                                       -{{$item->detail}} <br> 
                                       <input type="radio" name="obj_{{$item->objID}}" value="1"> บรรลุ  <input type="radio" name="obj_{{$item->objID}}" required value="0"> ไม่บรรลุ <br>
                                   @endforeach
                                </div>
                            </div>

                            <div class="row field item form-group ">
                                <label class="col-form-lable col-md-3 col-sm-3 label-align"><b>ผลการดำเนินงาน</b></label>
                                <div class="col-md-8 col-sm-8">
                                    @foreach ($data['operating'] as $item)
                                        <input type="radio" name="operating" value="{{$item->operID}}"  onchange="operatingRadio(this)" required> {{$item->name}} <br>
                                    @endforeach
                                </div>
                            </div>
                            <div class="row field item form-group ">
                                <label class="col-form-lable col-md-3 col-sm-3 label-align"></label>
                                <div class="col-md-7 col-sm-7 d-flex">
                                        <input type="text" name="since" class="form-control" placeholder="เนื่องจาก" id="operatingInput" style="display: none;"> 
                                </div>
                            </div>

                            <div class="row field item form-group ">
                                <label class="col-form-lable col-md-3 col-sm-3 label-align"><b>ผลการดำเนินงานตามตัวชี้วัดโครงการ</b></label>
                                <div class="col-md-7 col-sm-7">
                                   @foreach ($data['KPIProject'] as $item)
                                       -{{$item->name}} <br>
                                       <input type="text" name="result_eva[]" class="form-control" >
                                   @endforeach
                                </div>
                            </div>
                            
                            <div class="row field item form-group ">
                                <label class="col-form-lable col-md-3 col-sm-3 label-align"><b>งบประมาณที่ใช้ดำเนินการ</b></label>
                                <div class="col-md-8 col-sm-8">
                                   {{$data['project']->badgetType->name}}
                                </div>
                            </div>

                            <div class="row field item form-group ">
                                <label class="col-form-lable col-md-3 col-sm-3 label-align"><b>ที่ได้รับจัดสรร</b></label>
                                <div class="col-md-8 col-sm-8">
                                   {{$data['project']->badgetTotal}} บาท
                                </div>
                            </div>

                            {{-- <div class="row field item form-group ">
                                <label class="col-form-lable col-md-3 col-sm-3 label-align"><b>ผลการใช้จ่าย</b></label>
                                <div class="col-md-8 col-sm-8">
                                    @foreach ($data['report_quarter'] as $item)
                                        ไตรมาส{{$item->quarID}} <br>  {{$item->costResult}} บาท
                                    @endforeach
                                </div>
                            </div> --}}

                            <div class="row field item form-group ">
                                <label class="col-form-lable col-md-3 col-sm-3 label-align"><b>ใช้จริง</b></label>
                                <div class="col-md-7 col-sm-7">
                                   <input type="text" class="form-control" name="badget_use" required
                                   {{-- @foreach ($data['report_quarter'] as $item) --}}
                                        value="{{$data['costResult']}} " readonly>
                                    {{-- @endforeach  readonly> --}}
                                </div>
                            </div>

                            <div class="row field item form-group ">
                                <label class="col-form-lable col-md-3 col-sm-3 label-align "><b>ประโยชน์ที่ได้รับจากการดำเนินโครงการ (หลังการจัดโครงการ)</b></label>
                                <div class="col-md-7 col-sm-7">
                                   <textarea name="benefit" id="benefit" class="form-control" style="min-height: 100px" required></textarea>
                                </div>
                            </div>

                            <div class="row field item form-group ">
                                <label class="col-form-lable col-md-3 col-sm-3 label-align "><b>ปัญหาและอุปสรรคในการดำเนินโครงการ</b></label>
                                <div class="col-md-7 col-sm-7">
                                   <textarea name="problem" id="problem" class="form-control" style="min-height: 100px" ></textarea>
                                </div>
                            </div>

                            <div class="row field item form-group ">
                                <label class="col-form-lable col-md-3 col-sm-3 label-align "><b>แนวทางการดำเนินการแก้ไข / ข้อเสนอแนะ</b></label>
                                <div class="col-md-7 col-sm-7">
                                   <textarea name="corrective" id="corrective" class="form-control" style="min-height: 100px" ></textarea>
                                </div>
                            </div>

                            <div class="ln_solid">
                                <div class="form-group">
                                    <div class="col-md-6 offset-md-3">
                                        <button type='submit' class="btn btn-primary">ส่งข้อมูลปิดโครงการ</button>
                                    </div>
                                </div>
                            </div>


                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-1 col-sm-1"></div>
    </div>
    <script>
        function operatingRadio(radio){
            
            var operatingInput = document.getElementById("operatingInput");
            if(radio.value !== '1'){
                operatingInput.style.display = "flex";
                operatingInput.required = true;
            }else{
                operatingInput.style.display = "none";
            }
        }
    </script>
@endsection