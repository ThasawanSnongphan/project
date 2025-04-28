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
                                aria-expanded="false"><i class="fa fa-file-text"></i></a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="{{route('closed.PDF', $data['project']->proID) }}" target="_blank"><i class="fa fa-file-pdf-o text-danger"></i> PDF</a>
                                    
                                </div>
                        </li>
                        {{-- <li><a class="close-link"><i class="fa fa-close"></i></a> --}}
                    </ul>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">
                    @if (Auth::check() && count($data['comment']) > 0)
                    <div class="row field item form-group " style="background-color: #FFF9B1">
                        <label
                            class="col-form-lable col-md-4 col-sm-4 label-align"><b>ข้อเสนอแนะ :</b></label>
                        <div class="col-md-7 col-sm-7">
                            @foreach ($data['comment'] as $item)
                                <b>{{$item->user->displayname}}  : </b> {{$item->detail}} <br>
                                <b>เมื่อ</b> {{$item->created_at}} <br>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    @if (count($data['file']) > 0)
                        <form method="POST" enctype="multipart/form-data">
                            @csrf
                            <h6>เอกสารที่เกี่ยวข้องกับการประเมินโครงการ</h6>
                            <hr>
                            <div class="row field item form-group ">
                                <label
                                    class="col-form-lable col-md-4 col-sm-4 label-align"><b>เอกสารที่เกี่ยวข้อง :</b></label>
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
                                {{$data['status']->name}}
                            </div>
                        </div>

                        <div class="row field item form-group">
                            <label class="col-form-lable col-md-4 col-sm-4 label-align"><b>คำชี้แจง :</b></label>
                            <div class="col-md-7 col-sm-7">
                                {{$data['evaluation']->statement}}
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
                            <label class="col-form-lable col-md-4 col-sm-4 label-align "><b>วิธีการดำเนินโครงการ :</b></label>
                            <div class="col-md-7 col-sm-7">
                                {{ $data['evaluation']->implementation }}
                            </div>
                        </div>

                        <div class="row field item form-group ">
                            <label
                                class="col-form-lable col-md-4 col-sm-4 label-align"><b>ระยะเวลาในการดำเนินงาน :</b></label>
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
                                        บรรลุ
                                    @else
                                        ไม่บรรลุ
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <div class="row field item form-group ">
                            <label class="col-form-lable col-md-4 col-sm-4 label-align"><b>ผลการดำเนินงาน :</b></label>
                            <div class="col-md-8 col-sm-8">
                                {{ $data['evaluation']->operating->name }} <br>
                                @if ($data['evaluation']->since != null)
                                    {{ $data['evaluation']->since }}
                                @endif
                            </div>
                        </div>


                        <div class="row field item form-group ">
                            <label
                                class="col-form-lable col-md-4 col-sm-4 label-align"><b>ผลการดำเนินงานตามตัวชี้วัดโครงการ :</b></label>
                            <div class="col-md-7 col-sm-7">
                                @foreach ($data['KPIProject'] as $item)
                                    -{{ $item->name }} <br>
                                    {{ $item->result_eva }}
                                @endforeach
                            </div>
                        </div>

                        <div class="row field item form-group ">
                            <label
                                class="col-form-lable col-md-4 col-sm-4 label-align"><b>งบประมาณที่ใช้ดำเนินการ :</b></label>
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
                               {{ $data['costResult'] }}
                            </div>
                        </div>

                        <div class="row field item form-group ">
                            <label class="col-form-lable col-md-4 col-sm-4 label-align "><b>ประโยชน์ที่ได้รับจากการดำเนินโครงการ <br>
                                    (หลังการจัดโครงการ) :</b></label>
                            <div class="col-md-7 col-sm-7">
                                {{ $data['evaluation']->benefit }}
                            </div>
                        </div>

                        <div class="row field item form-group ">
                            <label
                                class="col-form-lable col-md-4 col-sm-4 label-align "><b>ปัญหาและอุปสรรคในการดำเนินโครงการ :</b></label>
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
                </div>
            </div>
        </div>
        <div class="col-md-1 col-sm-1"></div>
    </div>

@endsection
