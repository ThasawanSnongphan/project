@extends('layout')
@section('title', 'Project')
@section('content')
    <div class="row">
        <div class="col-md-1 col-sm-1"></div>
        <div class="col-md-10 col-sm-10">
            <div class="x_panel">
                <div class="x_title">
                    <h2>เขียนโครงการ</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                aria-expanded="false"><i class="fa fa-wrench"></i></a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#">Settings 1</a>
                                <a class="dropdown-item" href="#">Settings 2</a>
                            </div>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form id="actionForm" method="POST" action="" novalidate enctype="multipart/form-data">
                        @csrf
                       
                        @if (count($comment) > 0)
                            <div class="row field item form-group align-items-center">
                                <label for="title"
                                    class="col-form-label col-md-3 col-sm-3 label-align">ข้อเสนอแนะ</label>
                                <div class="col-md-6 col-sm-6">
                                    <table >
                                        <td style="padding: 2px">
                                            @foreach ($comment as $item)
                                                 {{ $item->user->firstname_en }} {{ $item->user->lastname_en }} :
                                                 {{ $item->detail }} <br> เมื่อ {{$item->created_at}}<br>
                                            @endforeach
                                        </td>
                                    </table>
                                </div>
                            </div>
                        @endif
                        <div class="row field item form-group align-items-center">
                            <label for="title" class="col-form-label col-md-3 col-sm-3 label-align">ปีงบประมาณ<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <select id="year" name="yearID" class="form-control" required>

                                    @foreach ($year as $item)
                                        @if ($project->yearID == $item->yearID)
                                            <option value="{{ $item->yearID }}" selected>{{ $item->year }}</option>
                                        @else
                                            <option value="{{ $item->yearID }}">{{ $item->year }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row field item form-group align-items-center">
                            <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">ชื่อโครงการ<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control" type="text" name="project_name" id="project_name"
                                    data-validate-length-range="8,20" value="{{ $project->name }}" />

                            </div>
                        </div>

                        @php
                            $index = 0;

                        @endphp

                        {{-- @if (!empty($selectYear)) --}}
                        @foreach ($strategic3Level as $item)
                            {{-- @if ($item->proID == $project->proID) --}}
                            <div class="row field item form-group align-items-center">
                                <label for="plan"
                                    class="col-form-label col-md-3 col-sm-3 label-align">แผนยุทธศาสตร์<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 d-flex">

                                    <input type="checkbox" name="stra3LVID[]" value="{{ $item->stra3LVID }}"
                                        @foreach ($strategic3LVMap as $map)
                                            @if ($item->stra3LVID == $map->stra3LVID)
                                                    checked 
                                            @endif @endforeach>




                                    <input class="ml-2 form-control" type="text" id="straID_{{ $index }}"
                                        required='required' data-validate-length-range="8,20" readonly
                                        value="{{ $item->name }}">
                                </div>

                            </div>
                            <div class="col-md-3"></div>
                            <div class="col-md-9 border mb-2 p-2">
                                <div class="row field item form-group align-items-center">
                                    <label for="title"
                                        class="col-form-label col-md-3 col-sm-3  label-align">ประเด็นยุทธศาสตร์<span
                                            class="required">*</span></label>
                                    <div class="col-md-8 col-sm-8">
                                        {{-- <input type="text" value="{{$SFA3LVMap[$index] ?? ''}}"> --}}

                                        <select id="SFA3LVID_{{ $index }}" name="SFA3LVID[]" class="form-control"
                                            required>
                                            <option value="">--เลือกประเด็นยุทธศาสตร์--</option>

                                            @foreach ($SFA3LVs as $SFA)
                                                @if ($SFA->stra3LVID == $item->stra3LVID)
                                                    @if ($SFA->SFA3LVID == ($SFA3LVMap[$index] ?? ''))
                                                        <option value="{{ $SFA->SFA3LVID }}" selected>
                                                            {{ $SFA->name }}</option>
                                                    @else
                                                        <option value="{{ $SFA->SFA3LVID }}">
                                                            {{ $SFA->name }}</option>
                                                    @endif
                                                @endif
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="row field item form-group align-items-center">
                                    <label for="title"
                                        class="col-form-label col-md-3 col-sm-3  label-align">เป้าประสงค์<span
                                            class="required">*</span></label>
                                    <div class="col-md-8 col-sm-8">
                                        <select id="goal3LVID_{{ $index }}" name="goal3LVID[]" class="form-control"
                                            required>
                                            <option value="">--เลือกเป้าประสงค์--</option>
                                            @foreach ($goal3Level as $goal)
                                                @if ($goal->SFA3LVID == ($SFA3LVMap[$index] ?? ''))
                                                    @if ($goal->goal3LVID == $goal3LVMap[$index])
                                                        <option value="{{ $goal->goal3LVID }}"selected>{{ $goal->name }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $goal->goal3LVID }}">{{ $goal->name }}
                                                        </option>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row field item form-group align-items-center">
                                    <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">กลยุทธ์<span
                                            class="required">*</span></label>
                                    <div class="col-md-8 col-sm-8">
                                        <select id="tac3LVID_{{ $index }}" name="tac3LVID[]" class="form-control"
                                            required>
                                            <option value="">--เลือกกลยุทธ์--</option>
                                            @foreach ($tactics3LV as $tac)
                                                @if ($tac->goal3LVID == ($goal3LVMap[$index] ?? ''))
                                                    @if ($tac->tac3LVID == $tac3LVMap[$index])
                                                        <option value="{{ $tac->tac3LVID }}"selected>{{ $tac->name }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $tac->tac3LVID }}">{{ $tac->name }}
                                                        </option>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            {{-- @endif --}}
                            <div class="row field item form-group align-items-center">
                                <label for="title"
                                    class="col-form-label col-md-2 col-sm-2 label-align">ตัวชี้วัดของ{{ $item->name }}</label>
                                <div class="row col-md-9 col-sm-9 border m-1">
                                    <div class="col-md-12 col-sm-12">
                                        <div
                                            class="row col-md-4 col-sm-4 m-1 d-flex justify-content-center align-items-center">
                                            <label for="title"
                                                class="col-form-label label-align">ตัวชี้วัดความสำเร็จ</label>
                                        </div>
                                        <div
                                            class="row col-md-3 col-sm-3 m-1 d-flex justify-content-center align-items-center">
                                            <label class="col-form-label label-align ">หน่วยนับ</label>

                                        </div>
                                        <div
                                            class="row col-md-3 col-sm-3 m-1 d-flex justify-content-center align-items-center">
                                            <label for="title" class="col-form-label label-align">ค่าเป้าหมาย</label>
                                        </div>
                                    </div>
                                    @if (isset($KPIMain3LVMapFirst[$index]) && $KPIMain3LVMapFirst[$index]->goal3LVID == $goal3LVMap[$index])
                                        @foreach ($KPIMain3LVMaps as $KPIMap)
                                            @if ($KPIMap->goal3LVID == ($goal3LVMap[$index] ?? ''))
                                                <div class="row col-md-12 col-sm-12">
                                                    <div class="col-md-4 col-sm-4 m-1">
                                                        <input type="hidden" name="goal3LVID[]"   value="{{$goal3LVMap[$index]}}">
                                                        <select id="KPIMain3LVID_{{ $index }}"
                                                            name="KPIMain3LVID[]" class="form-control" required>
                                                            <option value="">--เลือกตัวชี้วัด--</option>
                                                            @foreach ($KPIMain3LV as $KPI)
                                                                @if ($KPI->goal3LVID == ($goal3LVMap[$index] ?? ''))
                                                                    @if ($KPI->KPIMain3LVID == $KPIMap->KPIMain3LVID)
                                                                        <option value="{{ $KPI->KPIMain3LVID }}" selected>
                                                                            {{ $KPI->name }}</option>
                                                                    @else
                                                                        <option value="{{ $KPI->KPIMain3LVID }}">
                                                                            {{ $KPI->name }}</option>
                                                                    @endif
                                                                @endif
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                    <div class=" col-md-3 col-sm-3 m-1">
                                                        <input class="form-control" type="text" name="countMain3LV[]"
                                                            id="count3LV_{{ $index }}"
                                                            @foreach ($KPIMain3LV as $KPI)
                                                @if ($KPI->goal3LVID == ($goal3LVMap[$index] ?? ''))
                                                    @if ($KPI->KPIMain3LVID == ($KPIMap->KPIMain3LVID ?? ''))
                                                        value="{{ $KPI->count ?? '-' }}"
                                                    @endif
                                                @endif @endforeach
                                                            readonly>

                                                    </div>
                                                    <div class=" col-md-3 col-sm-3 m-1">
                                                        <input class="form-control" type="text" name="targetMain3LV[]"
                                                            id="target3LV_{{ $index }}"
                                                            @foreach ($KPIMain3LV as $KPI)
                                                @if ($KPI->goal3LVID == ($goal3LVMap[$index] ?? ''))
                                                    @if ($KPI->KPIMain3LVID == ($KPIMap->KPIMain3LVID ?? ''))
                                                        value="{{ $KPI->target ?? '-' }}"
                                                    @endif
                                                @endif @endforeach
                                                            readonly>
                                                    </div>

                                                    @if ($KPIMap->KPIMain3LVID == $KPIMain3LVMapFirst[$index]->KPIMain3LVID)
                                                        <div class="col-md-1 col-sm-1 m-1">
                                                            <button type='button'
                                                                class="btn btn-primary insert-kpi3LV-button"
                                                                data-index="{{ $index }}">เพิ่ม
                                                            </button>

                                                        </div>
                                                    @else
                                                        <div class="col-md-1 col-sm-1 m-1">
                                                            <button type="button" class="btn btn-danger "
                                                                onclick="this.closest('.row').remove()">ลบ</button>

                                                        </div>
                                                    @endif
                                                </div>
                                                {{-- @else --}}
                                            @endif
                                        @endforeach
                                    @else
                                        <div class="row col-md-12 col-sm-12">
                                            <div class="col-md-4 col-sm-4 m-1">
                                                {{-- <input type="text" value="{{$goal3LVMap[$index]}}"> --}}
                                                <select id="KPIMain3LVID_{{ $index }}" name="KPIMain3LVID[]"
                                                    class="form-control" required>
                                                    <option value="">--เลือกตัวชี้วัด--</option>
                                                   

                                                </select>
                                            </div>
                                            <div class=" col-md-3 col-sm-3 m-1">
                                                <input class="form-control" type="text" name="countMain3LV[]"
                                                    id="count3LV_{{ $index }}" {{-- @foreach ($KPIMain3LV as $KPI)
                                                    @if ($KPI->goal3LVID == ($goal3LVMap[$index] ?? ''))
                                                        @if ($KPI->KPIMain3LVID == ($KPIMain3LVMapFirst ?? ''))
                                                            value="{{ $KPI->count ?? '-' }}"
                                                        @endif
                                                    @endif @endforeach --}}
                                                    value ='' readonly>

                                            </div>
                                            <div class=" col-md-3 col-sm-3 m-1">
                                                <input class="form-control" type="text" name="targetMain3LV[]"
                                                    id="target3LV_{{ $index }}" {{-- @foreach ($KPIMain3LV as $KPI)
                                                @if ($KPI->goal3LVID == ($goal3LVMap[$index] ?? ''))
                                                    @if ($KPI->KPIMain3LVID == ($KPIMain3LVMapFirst ?? ''))
                                                        value="{{ $KPI->target ?? '-' }}"
                                                    @endif
                                                @endif @endforeach --}}
                                                    value='' readonly>
                                            </div>
                                            <div class="col-md-1 col-sm-1 m-1">
                                                <button type='button' class="btn btn-primary insert-kpi3LV-button"
                                                    data-index="{{ $index }}">เพิ่ม
                                                </button>

                                            </div>
                                        </div>
                                    @endif
                                    <div id="insertKPIMain1_{{ $index }}"></div>
                                    {{-- @else --}}

                                    {{-- <div id="insertKPIMain1_{{ $index }}"></div> --}}
                                    {{-- @endif --}}
                                </div>
                            </div>

                            @php
                                $index += 1;
                            @endphp
                        @endforeach

                        @php
                            $index = 0;
                        @endphp
                        @foreach ($strategic2Level as $item)
                            {{-- @if ($item->proID == $project->proID) --}}
                            <div class="row field item form-group align-items-center">
                                <label for="plan"
                                    class="col-form-label col-md-3 col-sm-3 label-align">แผนยุทธศาสตร์<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 d-flex">
                                    <input type="checkbox" name="stra2LVID[]" value="{{ $item->stra2LVID }}"
                                        @foreach ($strategic2LVMap as $map)
                                        @if ($item->stra2LVID == $map->stra2LVID)
                                                checked
                                        @endif @endforeach>

                                    <input class="ml-2 form-control" type="text" name="name" id="name"
                                        data-validate-length-range="8,20" value="{{ $item->name }}" readonly />
                                </div>

                            </div>
                            <div class="col-md-3"></div>
                            <div class="col-md-9 border mb-2 p-2">
                                <div class="row field item form-group align-items-center">
                                    <label for="title"
                                        class="col-form-label col-md-3 col-sm-3  label-align">ประเด็นยุทธศาสตร์<span
                                            class="required">*</span></label>
                                    <div class="col-md-8 col-sm-8">
                                        <select id="SFA2LVID_{{ $index }}" name="SFA2LVID[]" class="form-control"
                                            required>
                                            <option value="">--เลือกประเด็นยุทธศาสตร์--</option>
                                            @foreach ($SFA2LV as $SFA)
                                                @if ($SFA->stra2LVID == $item->stra2LVID)
                                                    @if ($SFA->SFA2LVID == ($SFA2LVMap[$index] ?? ''))
                                                        <option value="{{ $SFA->SFA2LVID }}" selected>
                                                            {{ $SFA->name }}</option>
                                                    @else
                                                        <option value="{{ $SFA->SFA2LVID }}">
                                                            {{ $SFA->name }}</option>
                                                    @endif
                                                @endif
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="row field item form-group align-items-center">
                                    <label for="title"
                                        class="col-form-label col-md-3 col-sm-3  label-align">กลยุทธ์<span
                                            class="required">*</span></label>
                                    <div class="col-md-8 col-sm-8">
                                        <select id="tac2LVID_{{ $index }}" name="tac2LVID[]" class="form-control"
                                            required>
                                            <option value="">--เลือกกลยุทธ์--</option>
                                            @foreach ($tactics2LV as $tac)
                                                @if ($tac->SFA2LVID == ($SFA2LVMap[$index] ?? ''))
                                                    @if ($tac->tac2LVID == $tac2LVMap[$index])
                                                        <option value="{{ $tac->tac2LVID }}"selected>
                                                            {{ $tac->name }}</option>
                                                    @else
                                                        <option value="{{ $tac->tac2LVID }}">
                                                            {{ $tac->name }}</option>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row field item form-group align-items-center">
                                <label for="title"
                                    class="col-form-label col-md-2 col-sm-2 label-align">ตัวชี้วัดของ{{ $item->name }}</label>
                                <div class="row col-md-9 col-sm-9 border m-1">
                                    <div class="col-md-12 col-sm-12">
                                        <div
                                            class="row col-md-4 col-sm-4 m-1 d-flex justify-content-center align-items-center">
                                            <label for="title"
                                                class="col-form-label label-align">ตัวชี้วัดความสำเร็จ</label>
                                        </div>
                                        <div
                                            class="row col-md-3 col-sm-3 m-1 d-flex justify-content-center align-items-center">
                                            <label class="col-form-label label-align ">หน่วยนับ</label>

                                        </div>
                                        <div
                                            class="row col-md-3 col-sm-3 m-1 d-flex justify-content-center align-items-center">
                                            <label for="title" class="col-form-label label-align">ค่าเป้าหมาย</label>
                                        </div>
                                    </div>

                                    @if (isset($KPIMain2LVMapFirst[$index]) && $KPIMain2LVMapFirst[$index]->SFA2LVID == $SFA2LVMap[$index])
                                        @foreach ($KPIMain2LVMaps as $KPIMap)
                                            @if ($KPIMap->SFA2LVID == ($SFA2LVMap[$index] ?? ''))
                                                <div class="row col-md-12 col-sm-12">
                                                    <div class="col-md-4 col-sm-4 m-1">
                                                        
                                                        <select id="KPIMain2LVID_{{ $index }}"
                                                            name="KPIMain2LVID[]" class="form-control" required>
                                                            <option value="">--เลือกตัวชี้วัด--</option>
                                                            @foreach ($KPIMain2LV as $KPI)
                                                                @if ($KPI->SFA2LVID == ($SFA2LVMap[$index] ?? ''))
                                                                    @if ($KPI->KPIMain2LVID == $KPIMap->KPIMain2LVID)
                                                                        <option value="{{ $KPI->KPIMain2LVID }}" selected>
                                                                            {{ $KPI->name }}</option>
                                                                    @else
                                                                        <option value="{{ $KPI->KPIMain2LVID }}">
                                                                            {{ $KPI->name }}</option>
                                                                    @endif
                                                                @endif
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                    <div class=" col-md-3 col-sm-3 m-1">

                                                        <input class="form-control" type="text" name="countMain2LV[]"
                                                            id="count2LV_{{ $index }}"
                                                            @foreach ($KPIMain2LV as $KPI)
                                                        @if ($KPI->SFA2LVID == ($SFA2LVMap[$index] ?? ''))
                                                            @if ($KPI->KPIMain2LVID == ($KPIMap->KPIMain2LVID ?? ''))
                                                                value="{{ $KPI->count ?? '-' }}"
                                                           
                                                            @endif
                                                        @endif @endforeach
                                                            readonly>

                                                    </div>
                                                    <div class=" col-md-3 col-sm-3 m-1">
                                                        <input class="form-control" type="text" name="targetMain2LV[]"
                                                            id="target2LV_{{ $index }}"
                                                            @foreach ($KPIMain2LV as $KPI)
                                                        @if ($KPI->SFA2LVID == ($SFA2LVMap[$index] ?? ''))
                                                            @if ($KPI->KPIMain2LVID == $KPIMap->KPIMain2LVID)
                                                                value="{{ $KPI->target ?? '-' }}"
                                                            
                                                            @endif
                                                        @endif @endforeach
                                                            readonly>
                                                    </div>

                                                    @if ($KPIMap->KPIMain2LVID == $KPIMain2LVMapFirst[$index]->KPIMain2LVID)
                                                        <div class="col-md-1 col-sm-1 m-1">
                                                            <button type='button'
                                                                class="btn btn-primary insert-kpi2LV-button"
                                                                data-index="{{ $index }}">เพิ่ม
                                                            </button>
                                                        </div>
                                                    @else
                                                        <div class="col-md-1 col-sm-1 m-1">
                                                            <button type="button" class="btn btn-danger "
                                                                onclick="this.closest('.row').remove()">ลบ</button>

                                                        </div>
                                                    @endif

                                                </div>
                                            @endif
                                        @endforeach
                                    @else
                                    <div class="row col-md-12 col-sm-12">
                                        <div class="col-md-4 col-sm-4 m-1">
                                           
                                            <select id="KPIMain2LVID_{{ $index }}"
                                                name="KPIMain2LVID[]" class="form-control" required>
                                                <option value="">--เลือกตัวชี้วัด--</option>
                                            </select>
                                        </div>
                                        <div class=" col-md-3 col-sm-3 m-1">

                                            <input class="form-control" type="text" name="countMain2LV[]"
                                                id="count2LV_{{ $index }}"
                                               
                                                readonly>

                                        </div>
                                        <div class=" col-md-3 col-sm-3 m-1">
                                            <input class="form-control" type="text" name="targetMain2LV[]"
                                                id="target2LV_{{ $index }}"
                                                
                                                readonly>
                                        </div>

                                       
                                            <div class="col-md-1 col-sm-1 m-1">
                                                <button type='button'
                                                    class="btn btn-primary insert-kpi2LV-button"
                                                    data-index="{{ $index }}">เพิ่ม
                                                </button>
                                            </div>
                                       

                                    </div>
                                    @endif

                                    <div id="insertKPIMain2_{{ $index }}"></div>
                                </div>
                            </div>
                            @php
                                $index += 1;
                            @endphp
                            {{-- @endif --}}
                        @endforeach

                        @php
                            $index = 0;
                        @endphp
                        @foreach ($strategic1Level as $item)
                            {{-- @if ($item->proID == $project->proID) --}}
                            <div class="row field item form-group align-items-center">
                                <label for="plan"
                                    class="col-form-label col-md-3 col-sm-3 label-align">แผนยุทธศาสตร์<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 d-flex">
                                    <input type="checkbox" name="stra1LVID[]" value="{{ $item->stra1LVID }}"
                                        @foreach ($strategic1LVMap as $map)
                                        @if ($item->stra1LVID == $map->stra1LVID)
                                                checked
                                        @endif @endforeach>
                                    <input class="ml-2 form-control" type="text" name="name" id="name"
                                        data-validate-length-range="8,20" value="{{ $item->name }}" readonly />
                                </div>

                            </div>
                            <div class="col-md-3"></div>
                            <div class="col-md-9 border mb-2 p-2">
                                <div class="row field item form-group align-items-center">
                                    <label for="title"
                                        class="col-form-label col-md-3 col-sm-3  label-align">เป้าหมาย<span
                                            class="required">*</span></label>
                                    <div class="col-md-8 col-sm-8">
                                        <select id="tar1LVID_{{ $index }}" name="tar1LVID[]" class="form-control"
                                            required>
                                            <option value="">--เลือกเป้าหมาย--</option>
                                            @foreach ($target1LV as $target)
                                                @if ($target->stra1LVID == $item->stra1LVID)
                                                    @if ($target->tar1LVID == ($target1LVMap[$index] ?? ''))
                                                        <option value="{{ $target->tar1LVID }}"selected>
                                                            {{ $target->name }}</option>
                                                    @else
                                                        <option value="{{ $target->tar1LVID }}">
                                                            {{ $target->name }}</option>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            {{-- @endif --}}
                            @php
                                $index += 1;
                            @endphp
                        @endforeach

                        {{-- <div class="ln_solid"> --}}
                        <div class="form-group ">
                            <div class="col-md-6 offset-md-3">
                                <button type='submit' class="btn btn-primary"
                                    onclick="submitButton('saveUpdate1',{{ $project->proID }})">บันทึก</button>
                                <button type='button' class="btn btn-primary"
                                    onclick="submitButton('sendUpdate1',{{ $project->proID }})">ถัดไป</button>
                            </div>
                        </div>
                        {{-- </div> --}}
                    </form>
                    {{-- @endif --}}
                </div>
            </div>
        </div>
        <div class="col-md-1 col-sm-1"></div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('[id^="SFA3LVID_"]').change(function(event) {
                var SFA3LVID = this.value;
                var dropdownID = $(this).attr('id');
                var idIndex = dropdownID.split("_")[1];
                // alert(idIndex);
                // alert(SFA3LVID);
                $('[id^="goal3LVID_"]');
                $.ajax({
                    url: "/projectgoal3LV",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        SFA3LVID: SFA3LVID,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        // console.log(response);
                        // $('#goal3LVID_'+idIndex).html('');
                        $('#goal3LVID_' + idIndex).html(
                            '<option value="">--เลือกเป้าประสงค์--</option>');
                        $.each(response.goal3LV, function(index, val) {
                            $('#goal3LVID_' + idIndex).append('<option value="' + val
                                .goal3LVID + '"> ' + val.name + ' </option>');
                            // console.log(val.goal3LVID);
                        });
                        $('#tac3LVID_' + idIndex).html(
                            '<option value="">--เลือกกลยุทธ์--</option>');
                        $('#KPIMain3LVID_' + idIndex).html(
                            '<option value="">--เลือกตัวชี้วัด--</option>');
                        $('#count3LV_' + idIndex).val('');
                        $('#target3LV_' + idIndex).val('');
                    }
                })
            });
            $('[id^="goal3LVID_"]').change(function(event) {
                var goal3LVID = this.value;
                var dropdownID = $(this).attr('id');
                var idIndex = dropdownID.split("_")[1];
                $('[id^="tac3LVID_"]');

                $.ajax({
                    url: "/projecttactics3LV",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        goal3LVID: goal3LVID,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $('#tac3LVID_' + idIndex).html(
                            '<option value="">--เลือกกลยุทธ์--</option>');
                        $.each(response.tactics3LV, function(index, val) {
                            $('#tac3LVID_' + idIndex).append('<option value="' + val
                                .tac3LVID + '"> ' + val.name + ' </option>')
                        });

                    }
                });
            });
            $('[id^="goal3LVID_"]').change(function(event) {
                var goal3LVID = this.value;
                var dropdownID = $(this).attr('id');
                var idIndex = dropdownID.split("_")[1];
                $('[id^="KPIMain3LVID_"]');
                $.ajax({
                    url: "/projectKPIMain3LV",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        goal3LVID: goal3LVID,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $('#KPIMain3LVID_' + idIndex).html(
                            '<option value="">--เลือกตัวชี้วัด--</option>');
                        $.each(response.KPIMain3LV, function(index, val) {
                            $('#KPIMain3LVID_' + idIndex).append('<option value="' + val
                                .KPIMain3LVID + '"> ' + val.name + ' </option>')
                        })
                        $('#count3LV_' + idIndex).val('');
                        $('#target3LV_' + idIndex).val('');
                    }
                });
            });
            $('[id^="KPIMain3LVID_"]').change(function(event) {
                var KPIMain3LVID = this.value;
                var dropdownID = $(this).attr('id');
                var idIndex = dropdownID.split("_")[1];
                $('[id^="count3LV_"]');
                $('[id^="target3LV_"]');
                $.ajax({
                    url: '/projectcount_target3LV',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        KPIMain3LVID: KPIMain3LVID,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $.each(response.count_target, function(index, val) {

                            $('#count3LV_' + idIndex).val(val.count);
                            $('#target3LV_' + idIndex).val(val.target);
                        });
                    }
                })
            });
            $('[id^="SFA2LVID_"]').change(function(event) {
                var SFA2LVID = this.value;
                var dropdownID = $(this).attr('id');
                var idIndex = dropdownID.split("_")[1];
                $('[id^="tac2LVID_"]');

                $.ajax({
                    url: "/projecttactics2LV",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        SFA2LVID: SFA2LVID,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $('#tac2LVID_' + idIndex).html(
                            '<option value="">--เลือกกลยุทธ์--</option>');
                        $.each(response.tactics2LV, function(index, val) {
                            $('#tac2LVID_' + idIndex).append('<option value="' + val
                                .tac2LVID + '"> ' + val.name + ' </option>')
                        });

                    }
                });
            });
            $('[id^="SFA2LVID_"]').change(function(event) {
                var SFA2LVID = this.value;
                var dropdownID = $(this).attr('id');
                var idIndex = dropdownID.split("_")[1];
                $('[id^="KPIMain2LVID_"]');

                $.ajax({
                    url: "/projectKPIMain2LV",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        SFA2LVID: SFA2LVID,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $('#KPIMain2LVID_' + idIndex).html(
                            '<option value="">--เลือกตัวชี้วัด--</option>');
                        $.each(response.KPIMain2LV, function(index, val) {
                            $('#KPIMain2LVID_' + idIndex).append('<option value="' + val
                                .KPIMain2LVID + '"> ' + val.name + ' </option>')
                        })
                        $('#count2LV_' + idIndex).val('');
                        $('#target2LV_' + idIndex).val('');

                    }
                });
            });
            $('[id^="KPIMain2LVID_"]').change(function(event) {
                var KPIMain2LVID = this.value;
                var dropdownID = $(this).attr('id');
                var idIndex = dropdownID.split("_")[1];
                $('[id^="count2LV_"]');
                $('[id^="target2LV_"]');
                $.ajax({
                    url: '/projectcount_target2LV',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        KPIMain2LVID: KPIMain2LVID,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $.each(response.count_target2LV, function(index, val) {

                            $('#count2LV_' + idIndex).val(val.count ?? '-');
                            $('#target2LV_' + idIndex).val(val.target ?? '-');
                        });
                    }
                })
            });
        });

        function submitForm(event) {
            event.preventDefault();
            document.getElementById('actionForm').submit();
            return false;
        }



        document.addEventListener('DOMContentLoaded', function() {
            document.body.addEventListener('click', function(event) {
                if (event.target.classList.contains('insert-kpi3LV-button')) {
                    const index = event.target.getAttribute('data-index');
                    insertKPIMain1(index);
                }

                if (event.target.classList.contains('insert-kpi2LV-button')) {
                    const index = event.target.getAttribute('data-index');
                    insertKPIMain2(index);
                }
            });
        });
        const KPIMains = @json($KPIMain3LV);

        function insertKPIMain1(index) {
            // const i=1;
            const mainContainer = document.createElement('div');
            mainContainer.classList.add('row', 'col-md-12', 'col-sm-12');

            const colKPI = document.createElement('div');
            colKPI.classList.add('col-md-4', 'col-sm-4', 'm-1');

            const KPIDropdown = document.createElement('select');
            KPIDropdown.classList.add('form-control');
            // KPIDropdown.id = `KPIMain3LVID_${Date.now()}`;
            // KPIDropdown.id = `KPIMain3LVID_${index}`;
            KPIDropdown.id = `KPIMain3LVID_${index}_${Date.now()}`;

            KPIDropdown.name = 'KPIMain3LVID[]';
            KPIDropdown.innerHTML = '';

            console.log("สร้าง dropdown ID:", KPIDropdown.id);

            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = '--เลือกตัวชี้วัด--';
            defaultOption.disabled = true;
            defaultOption.selected = true;
            KPIDropdown.appendChild(defaultOption);

            const colCount = document.createElement('div');
            colCount.classList.add('col-md-3', 'col-sm-3', 'm-1');

            const countInput = document.createElement('input');
            countInput.classList.add('form-control');
            countInput.type = 'text';
            // countInput.id = `countMain_${Date.now()}`;
            countInput.id = `count3LV_${index}_${Date.now()}`;
            countInput.name = 'countMain3LV[]';
            countInput.readOnly = true;

            const colTarget = document.createElement('div');
            colTarget.classList.add('col-md-3', 'col-sm-3', 'm-1');

            const targetInput = document.createElement('input');
            targetInput.classList.add('form-control');
            targetInput.type = 'text';
            targetInput.id = `target3LV_${index}_${Date.now()}`;
            targetInput.name = 'targetMain3LV[]';
            targetInput.readOnly = true;

            const goalInput = document.createElement('input');
            goalInput.classList.add('form-control');
            goalInput.type = 'hidden';
            goalInput.name = 'goal3LVID[]';
            goalInput.readOnly = true;

            const selectedGoalID = document.getElementById('goal3LVID_' + index).value;

            const filteredKPIMains = KPIMains.filter(KPIMain => KPIMain.goal3LVID == selectedGoalID);

            // เปิดใช้งาน dropdown และเพิ่ม KPI ในตัวเลือก
            KPIDropdown.disabled = false;
            filteredKPIMains.forEach(KPIMain => {
                const option = document.createElement('option');
                option.value = KPIMain.KPIMain3LVID;
                option.textContent = KPIMain.name;
                KPIDropdown.appendChild(option);
            });


            KPIDropdown.addEventListener('change', function() {
                console.log('KPIDropdown changed:', this.value);
                const selectedKPIMainID = this.value;
                const selectedKPIMain = KPIMains.find(KPIMain => KPIMain.KPIMain3LVID == selectedKPIMainID);
                if (selectedKPIMain) {
                    countInput.value = selectedKPIMain.count || 'ไม่มีหน่วยนับ';
                    targetInput.value = selectedKPIMain.target || 'ไม่มีค่าเป้าหมาย';
                    goalInput.value = selectedKPIMain.goal3LVID || '';
                }
            });



            const colDelete = document.createElement('div');
            colDelete.classList.add('col-md-1', 'col-sm-1', 'm-1');

            const deleteButton = document.createElement('button');
            deleteButton.type = 'button';
            deleteButton.classList.add('btn', 'btn-danger'); // เพิ่มคลาส Bootstrap
            deleteButton.textContent = 'ลบ';
            deleteButton.onclick = function() {
                mainContainer.remove(); // ลบ mainContainer เมื่อคลิกปุ่ม
            };


            mainContainer.appendChild(colKPI);
            mainContainer.appendChild(colCount);
            mainContainer.appendChild(colTarget);
            mainContainer.appendChild(colDelete);
            colKPI.appendChild(KPIDropdown);
            colCount.appendChild(countInput);
            colTarget.appendChild(targetInput);
            colTarget.appendChild(goalInput);
            colDelete.appendChild(deleteButton);
            // เพิ่มปุ่มลบลงใน mainContainer
            // document.getElementById('insertKPIMain').appendChild(mainContainer);
            const targetContainer = document.getElementById(`insertKPIMain1_${index}`);
            if (targetContainer) {
                targetContainer.appendChild(mainContainer);
            } else {
                console.error(`ไม่พบ <div id="insertKPIMain_${index}"> ใน DOM`);
            }
        }

        const KPIMain2LVs = @json($KPIMain2LV);

        function insertKPIMain2(index) {
            // const i=1;
            const mainContainer = document.createElement('div');
            mainContainer.classList.add('row', 'col-md-12', 'col-sm-12');

            const colKPI = document.createElement('div');
            colKPI.classList.add('col-md-4', 'col-sm-4', 'm-1');

            const KPIDropdown = document.createElement('select');
            KPIDropdown.classList.add('form-control');
            // KPIDropdown.id = `KPIMain3LVID_${Date.now()}`;
            // KPIDropdown.id = `KPIMain3LVID_${index}`;
            KPIDropdown.id = `KPIMain2LVID_${index}_${Date.now()}`;

            KPIDropdown.name = 'KPIMain2LVID[]';
            KPIDropdown.innerHTML = '';

            console.log("สร้าง dropdown ID:", KPIDropdown.id);

            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = '--เลือกตัวชี้วัด--';
            defaultOption.disabled = true;
            defaultOption.selected = true;
            KPIDropdown.appendChild(defaultOption);

            const colCount = document.createElement('div');
            colCount.classList.add('col-md-3', 'col-sm-3', 'm-1');

            const countInput = document.createElement('input');
            countInput.classList.add('form-control');
            countInput.type = 'text';
            // countInput.id = `countMain_${Date.now()}`;
            countInput.id = `count2LV_${index}_${Date.now()}`;
            countInput.name = 'countMain2LV[]';
            countInput.readOnly = true;

            const colTarget = document.createElement('div');
            colTarget.classList.add('col-md-3', 'col-sm-3', 'm-1');

            const targetInput = document.createElement('input');
            targetInput.classList.add('form-control');
            targetInput.type = 'text';
            // targetInput.id = `targetMain_${Date.now()}`;
            targetInput.id = `target2LV_${index}_${Date.now()}`;
            targetInput.name = 'targetMain2LV[]';
            targetInput.readOnly = true;

            const SFAInput = document.createElement('input');
            SFAInput.classList.add('form-control');
            SFAInput.type = 'hidden';
            SFAInput.name = 'SFA2LVID[]';

            const selectedSFAID = document.getElementById('SFA2LVID_' + index).value;

            const filteredKPIMains = KPIMain2LVs.filter(KPIMain => KPIMain.SFA2LVID == selectedSFAID);

            // เปิดใช้งาน dropdown และเพิ่ม KPI ในตัวเลือก
            KPIDropdown.disabled = false;
            filteredKPIMains.forEach(KPIMain => {
                const option = document.createElement('option');
                option.value = KPIMain.KPIMain2LVID;
                option.textContent = KPIMain.name;
                KPIDropdown.appendChild(option);
            });


            KPIDropdown.addEventListener('change', function() {
                console.log('KPIDropdown changed:', this.value);
                const selectedKPIMainID = this.value;
                const selectedKPIMain = KPIMain2LVs.find(KPIMain => KPIMain.KPIMain2LVID == selectedKPIMainID);
                if (selectedKPIMain) {
                    countInput.value = selectedKPIMain.count || '-';
                    targetInput.value = selectedKPIMain.target || '-';
                    SFAInput.value = selectedKPIMain.SFA2LVID || '';
                }
            });



            const colDelete = document.createElement('div');
            colDelete.classList.add('col-md-1', 'col-sm-1', 'm-1');

            const deleteButton = document.createElement('button');
            deleteButton.type = 'button';
            deleteButton.classList.add('btn', 'btn-danger'); // เพิ่มคลาส Bootstrap
            deleteButton.textContent = 'ลบ';
            deleteButton.onclick = function() {
                mainContainer.remove(); // ลบ mainContainer เมื่อคลิกปุ่ม
            };


            mainContainer.appendChild(colKPI);
            mainContainer.appendChild(colCount);
            mainContainer.appendChild(colTarget);
            mainContainer.appendChild(colDelete);
            colKPI.appendChild(KPIDropdown);
            colCount.appendChild(countInput);
            colTarget.appendChild(targetInput);
            colTarget.appendChild(SFAInput);
            colDelete.appendChild(deleteButton);
            // เพิ่มปุ่มลบลงใน mainContainer
            // document.getElementById('insertKPIMain').appendChild(mainContainer);
            const targetContainer = document.getElementById(`insertKPIMain2_${index}`);
            if (targetContainer) {
                targetContainer.appendChild(mainContainer);
            } else {
                console.error(`ไม่พบ <div id="insertKPIMain_${index}"> ใน DOM`);
            }
        }


        function submitButton(action, proID) {
            var form = document.getElementById('actionForm');
            if (action === 'saveUpdate1') {
                form.action = "/projectsaveUpdate1/" + proID;
            } else if (action === 'sendUpdate1') {
                form.action = "/projectsendUpdate1/" + proID;
            }
            form.submit();
        }
    </script>
@endsection
