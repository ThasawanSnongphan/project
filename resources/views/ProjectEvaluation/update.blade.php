@extends('layout')
@section('title', 'Project Evaluation')
@section('content')
    <div class="row">
        <div class="col-md-1 col-sm-1"></div>
        <div class="col-md-10 col-sm-10">
            <div class="x_panel">
                <div class="x_title">
                    <h2>แก้ไขเอกสารประเมินโครงการ</h2>
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
                        @if (count($data['comment']) > 0)
                            <div class="row field item form-group " style="background-color: #FFF9B1">
                                <label class="col-form-lable col-md-3 col-sm-3 label-align"><b>ข้อเสนอแนะ :</b></label>
                                <div class="col-md-7 col-sm-7 ">
                                   @foreach ($data['comment'] as $item)
                                       <b>{{$item->user->firstname_en}} {{$item->user->lastname_en}} : </b> {{$item->detail}} <br>
                                       <b>เมื่อ</b> {{$item->created_at}} <br>
                                   @endforeach
                                </div>
                            </div>
                        @endif
                        <form method="POST" action="" enctype="multipart/form-data">
                            @csrf
                            <h6>uppload เอกสารที่เกี่ยวข้องกับการประเมินโครงการ</h6> <hr>
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
                        <form method="POST"  id="actionForm">
                            @csrf
                            <h6>เขียนเอกสารประเมินโครงการ</h6> <hr>
                            <div class="row field item form-group">
                                <label class="col-form-lable col-md-3 col-sm-3 label-align"><b>คำชี้แจง</b></label>
                                <div class="col-md-7 col-sm-7">
                                    <textarea name="statement" id="statement" class="form-control" style="height:auto; min-height: 130px; max-height: 1000px; font-size: 12px;">{{$data['evaluation']->statement}}</textarea>
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
                                   <textarea name="implement" id="implement" class="form-control" style="min-height: 100px; height: auto;" required>{{$data['evaluation']->implementation}}</textarea>
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
                                       @if ($item->achieve == 1)
                                            <input type="radio" name="obj_{{$item->objID}}" value="1" checked> บรรลุ  <input type="radio" name="obj_{{$item->objID}}" required value="0"> ไม่บรรลุ <br>
                                       @else
                                       <input type="radio" name="obj_{{$item->objID}}" value="1" > บรรลุ  <input type="radio" name="obj_{{$item->objID}}" required value="0" checked> ไม่บรรลุ <br>
                                       @endif
                                      
                                   @endforeach
                                </div>
                            </div>

                            <div class="row field item form-group ">
                                <label class="col-form-lable col-md-3 col-sm-3 label-align"><b>ผลการดำเนินงาน</b></label>
                                <div class="col-md-8 col-sm-8">
                                    @foreach ($data['operating'] as $item)
                                        <input type="radio" name="operating" value="{{$item->operID}}"  onchange="operatingRadio(this)"  
                                        @if ($data['evaluation']->operID === $item->operID) checked @endif> {{$item->name}} <br>
                                        
                                    @endforeach
                                </div>
                            </div>
                           
                            <div class="row field item form-group ">
                                <label class="col-form-lable col-md-3 col-sm-3 label-align"></label>
                                <div class="col-md-7 col-sm-7 d-flex">
                                        <input type="text" name="since" class="form-control" placeholder="เนื่องจาก" id="operatingInput"
                                        @if (!empty($data['evaluation']->since)) value="{{$data['evaluation']->since}}" style="display: flex;"  
                                        @else style="display: none;" @endif > 
                                </div>
                            </div>
                           
                           
                            

                            <div class="row field item form-group ">
                                <label class="col-form-lable col-md-3 col-sm-3 label-align"><b>ผลการดำเนินงานตามตัวชี้วัดโครงการ</b></label>
                                <div class="col-md-7 col-sm-7">
                                   @foreach ($data['KPIProject'] as $item)
                                       -{{$item->name}} <br>
                                       <input name="result_eva[]" class="form-control"  required value="{{$item->result_eva}}">
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

                            <div class="row field item form-group ">
                                <label class="col-form-lable col-md-3 col-sm-3 label-align"><b>ใช้จริง</b></label>
                                <div class="col-md-7 col-sm-7">
                                   <input type="text" class="form-control" name="badget_use" required value="{{$data['costResult']}}" readonly>
                                </div>
                            </div>

                            <div class="row field item form-group ">
                                <label class="col-form-lable col-md-3 col-sm-3 label-align "><b>ประโยชน์ที่ได้รับจากการดำเนินโครงการ (หลังการจัดโครงการ)</b></label>
                                <div class="col-md-7 col-sm-7">
                                   <textarea name="benefit" id="benefit" class="form-control" style="min-height: 100px" required>{{$data['evaluation']->benefit}}</textarea>
                                </div>
                            </div>

                            <div class="row field item form-group ">
                                <label class="col-form-lable col-md-3 col-sm-3 label-align "><b>ปัญหาและอุปสรรคในการดำเนินโครงการ</b></label>
                                <div class="col-md-7 col-sm-7">
                                   <textarea name="problem" id="problem" class="form-control" style="min-height: 100px" required>{{$data['evaluation']->problem}}</textarea>
                                </div>
                            </div>

                            <div class="row field item form-group ">
                                <label class="col-form-lable col-md-3 col-sm-3 label-align "><b>แนวทางการดำเนินการแก้ไข / ข้อเสนอแนะ</b></label>
                                <div class="col-md-7 col-sm-7">
                                   <textarea name="corrective" id="corrective" class="form-control" style="min-height: 100px" required>{{$data['evaluation']->corrective_actions}}</textarea>
                                </div>
                            </div>

                            <div class="ln_solid">
                                <div class="form-group">
                                    <div class="col-md-6 offset-md-3">
                                        <button type='button' class="btn btn-primary" onclick="submitButton('update',{{$data['project']->proID}})">บันทึก</button>
                                        <button type='button' class="btn btn-primary" onclick="submitButton('send',{{$data['project']->proID}})">ส่ง</button>
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
                operatingInput.value = '';
            }else{
                operatingInput.style.display = "none";
                operatingInput.required = false;   
            }
        }
       

        function submitButton(action,proID){
            var form = document.getElementById('actionForm');
            if(action === 'update'){
                form.action = "/UpdateEvaluation/" + proID;
            }else{
                form.action = "/SendEvaluation/" + proID;
            }
            form.submit();
        }
    </script>
@endsection