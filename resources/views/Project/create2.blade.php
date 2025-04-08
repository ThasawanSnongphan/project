@extends('layout')
@section('title', 'Project')
@section('content')
    <div class="row">
        <div class="col-md-1 col-sm-1"></div>
        <div class="col-md-10 col-sm-10">
            <div class="x_panel">
                <div class="x_title">
                    <h2>สร้างโครงการ</h2>
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
                    <form id="actionForm" method="POST" action="/projectSave2" enctype="multipart/form-data">
                        @csrf
                        <div class="row field item form-group align-items-center">
                            <label for="title" class="col-form-label col-md-3 col-sm-3 label-align">ปีงบประมาณ<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <input type="hidden" name="yearID" id="yearID" value="{{ session('yearID') }}">
                                <input class="form-control" type="text" name="year" id="year"
                                    data-validate-length-range="8,20"
                                    @foreach ($years as $item)
                                        @if (session('yearID') == $item->yearID)
                                            value="{{ $item->year }}" 
                                        @endif @endforeach
                                    readonly />
                            </div>
                        </div>

                        <div class="row field item form-group align-items-center">
                            <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">ชื่อโครงการ<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control" type="text" name="project_name" id="project_name"
                                    data-validate-length-range="8,20" value="{{ session('name') }}" readonly />

                            </div>
                        </div>
                        <div class="row field item form-group align-items-center">
                            <label for="title"
                                class="col-form-label col-md-3 col-sm-3  label-align">ผู้กำกับดูแลโครงการ<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <input type="hidden" name="approverID" value="{{ session('approverID') }}">
                                <input class="form-control" type="text" name="approver" data-validate-length-range="8,20"
                                    @foreach ($user as $item)
                                    @if (session('approverID') == $item->userID)
                                        value=" {{ $item->displayname }} "
                                    @endif @endforeach
                                    readonly />

                            </div>
                        </div>
                        {{-- ถ้ามีหลายคนก็เเก้ไขได้ --}}
                        <div class="row field item form-group align-items-center">
                            <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">เจ้าของโครงการ<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <input type="hidden" name="userID[]" value="{{ Auth::user()->userID }}" />
                                <input class="form-control" type="text" name="user" id="user"
                                    value="{{ Auth::user()->displayname }}" data-validate-length-range="8,20" disabled />

                            </div>

                            <div class="col-md-3 col-sm-3">
                                <button type='button' class="btn btn-primary"
                                    onclick="addNewUserDropdown()">เพิ่มผู้รับผิดชอบ</button>
                            </div>
                        </div>

                        <div id="userDropdownContainer"></div>



                        <div class="row field item form-group align-items-center">
                            <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">สังกัด<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control" type="text" name="faculty" id="faculty"
                                    data-validate-length-range="8,20" disabled
                                    value="{{ Auth::user()->department_name }}" />
                            </div>

                        </div>
                        <div class="row field item form-group align-items-center">
                            <label for="format" class="col-form-label col-md-3 col-sm-3 label-align">format<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <select id="format" name="format" class="form-control">
                                    <option value="team"
                                        {{ old('format', request('format')) == 'team' ? 'selected' : '' }}>team</option>
                                    <option value="department"
                                        {{ old('format', request('format')) == 'department' ? 'selected' : '' }}>department
                                    </option>
                                </select>
                            </div>
                        </div>


                        @if (session()->has('stra3LVID'))
                            @foreach (session('stra3LVID') as $index => $item)
                                <div class="row field item form-group align-items-center">
                                    <label for="plan"
                                        class="col-form-label col-md-3 col-sm-3 label-align">ชื่อแผน</label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="hidden" name="stra3LVID[]" value="{{ $item }}">

                                        @foreach ($strategic as $stra)
                                            @if ($stra->stra3LVID == $item)
                                                <input class="form-control" type="text" id="stra3LV"
                                                    data-validate-length-range="8,20" value="{{ $stra->name }}"
                                                    readonly />
                                            @endif
                                        @endforeach

                                    </div>

                                </div>
                                <div class="col-md-3"></div>
                                <div class="col-md-9 border mb-2 p-2">
                                    <div class="row field item form-group align-items-center">
                                        <label for="title"
                                            class="col-form-label col-md-3 col-sm-3  label-align">ประเด็นยุทธศาสตร์<span
                                                class="required">*</span></label>
                                        <div class="row col-md-8 col-sm-8">
                                            @foreach ($SFAs as $SFA)
                                                @if (isset($sessionSFA3LVID) && is_array($sessionSFA3LVID))
                                                    @foreach ($sessionSFA3LVID as $SFA3LVID)
                                                        @if ($SFA->SFA3LVID == $SFA3LVID && $SFA->stra3LVID == $item)
                                                            <input type="hidden" name="SFA3LVID[]"
                                                                value="{{ $SFA->SFA3LVID }}">
                                                            <input class="form-control" type="text" id="SFA3LVID"
                                                                value="{{ $SFA->name }}" readonly>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach

                                        </div>
                                    </div>
                                    <div class="row field item form-group align-items-center">
                                        <label for="title"
                                            class="col-form-label col-md-3 col-sm-3  label-align">เป้าประสงค์<span
                                                class="required">*</span></label>
                                        <div class="row col-md-8 col-sm-8">
                                            @foreach ($goals as $goal)
                                                @if (isset($sessiongoal3LVID) && is_array($sessiongoal3LVID))
                                                    @foreach ($sessiongoal3LVID as $goal3LVID)
                                                        @if ($goal->goal3LVID == $goal3LVID && $goal->SFA3LVID == $sessionSFA3LVID[$index])
                                                            <input type="hidden" name="goal3LVID[]"
                                                                value="{{ $goal->goal3LVID }}">
                                                            <input class="form-control" type="text" id="goal3LVID"
                                                                value="{{ $goal->name }}" readonly>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="row field item form-group align-items-center">
                                        <label for="title"
                                            class="col-form-label col-md-3 col-sm-3  label-align">กลยุทธ์<span
                                                class="required">*</span></label>
                                        <div class="row col-md-8 col-sm-8">
                                            @foreach ($tactics as $tactic)
                                                @if (isset($sessiontac3LVID) && is_array($sessiontac3LVID))
                                                    @foreach ($sessiontac3LVID as $tac3LVID)
                                                        @if ($tactic->tac3LVID == $tac3LVID && $tactic->goal3LVID == $sessiongoal3LVID[$index])
                                                            <input type="hidden" name="tac3LVID[]"
                                                                value="{{ $tactic->tac3LVID }}">
                                                            <input class="form-control" type="text" id="tac3LVID"
                                                                value="{{ $tactic->name }}" readonly>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="row field item form-group align-items-center">
                                        <label for="title"
                                            class="col-form-label col-md-3 col-sm-3  label-align">ตัวชีวัดของแผน<span
                                                class="required">*</span></label>
                                        <div class="row col-md-8 col-sm-8 ">

                                            @foreach ($KPIMains as $KPI)
                                                @if (isset($sessionKPIMain3LVID) && is_array($sessionKPIMain3LVID))
                                                    @foreach ($sessionKPIMain3LVID as $KPIMain3LVID)
                                                        @if ($KPI->KPIMain3LVID == $KPIMain3LVID && $KPI->goal3LVID == $sessiongoal3LVID[$index])
                                                            <div class="d-flex mt-2">
                                                                <input type="hidden" name="goalMap[]"
                                                                    value="{{ $KPI->goal3LVID }}">
                                                                <input type="hidden" name="KPIMain3LVID[]"
                                                                    value="{{ $KPI->KPIMain3LVID }}">
                                                                <input class="form-control mr-2" type="text"
                                                                    id="KPIMain3LVID" value="{{ $KPI->name }}"
                                                                    readonly>
                                                                <input class="form-control mr-2" type="text"
                                                                    name="count3LVID" id="count3LVID"
                                                                    value="{{ $KPI->count }}" readonly>
                                                                <input class="form-control" type="text"
                                                                    name="target3LVID" id="target3LVID"
                                                                    value="{{ $KPI->target }}" readonly>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach


                                        </div>
                                    </div>

                                </div>
                            @endforeach
                        @endif
                        @if (session()->has('stra2LVID'))
                            @foreach (session('stra2LVID') as $index => $item)
                                <div class="row field item form-group align-items-center">
                                    <label for="plan"
                                        class="col-form-label col-md-3 col-sm-3 label-align">แผนยุทธศาสตร์<span
                                            class="required">*</span></label>
                                    <div class=" col-md-6 col-sm-6">
                                        <input type="hidden" name="stra2LVID[]" value="{{ $item }}">
                                        @foreach ($strategic2LV as $stra)
                                            @if ($stra->stra2LVID == $item)
                                                <input class="form-control" type="text" id="stra2LVID"
                                                    data-validate-length-range="8,20" value="{{ $stra->name }}"
                                                    readonly />
                                            @endif
                                        @endforeach

                                    </div>

                                </div>
                                <div class="col-md-3"></div>
                                <div class="col-md-9 border mb-2 p-2">
                                    <div class="row field item form-group align-items-center">
                                        <label for="title"
                                            class="col-form-label col-md-3 col-sm-3  label-align">ประเด็นยุทธศาสตร์<span
                                                class="required">*</span></label>
                                        <div class="row col-md-8 col-sm-8">
                                            @foreach ($SFA2Lv as $SFA)
                                                @if (session()->has('SFA2LVID') && is_array(session('SFA2LVID')))
                                                    @foreach (session('SFA2LVID') as $index => $SFA2LVID)
                                                        @if ($SFA->SFA2LVID == $SFA2LVID && $SFA->stra2LVID == $item)
                                                            <input type="hidden" name="SFA2LVID[]"
                                                                value="{{ $SFA->SFA2LVID }}">
                                                            <input class="form-control" type="text" id="SFA2LVID"
                                                                data-validate-length-range="8,20"
                                                                value="{{ $SFA->name }}" readonly />
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="row field item form-group align-items-center">
                                        <label for="title"
                                            class="col-form-label col-md-3 col-sm-3  label-align">กลยุทธ์<span
                                                class="required">*</span></label>
                                        <div class="row col-md-8 col-sm-8">
                                            @foreach ($tactics2LV as $tactic)
                                                @if (session()->has('tac2LVID') && is_array(session('tac2LVID')))
                                                    @foreach (session('tac2LVID') as $tac2LVID)
                                                        @if ($tactic->tac2LVID == $tac2LVID && $tactic->SFA2LVID == session('SFA2LVID')[$index])
                                                            <input type="hidden" name="tac2LVID[]"
                                                                value="{{ $tactic->tac2LVID }}">
                                                            <input class="form-control" type="text" id="tac2LVID"
                                                                data-validate-length-range="8,20"
                                                                value="{{ $tactic->name }}" readonly />
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="row field item form-group align-items-center">
                                        <label for="title"
                                            class="col-form-label col-md-3 col-sm-3  label-align">ตัวชีวัดของแผน<span
                                                class="required">*</span></label>
                                        <div class="row col-md-8 col-sm-8 ">
                                            @foreach ($KPIMain2LV as $KPI)
                                                @if (session()->has('KPIMain2LVID') && is_array(session('KPIMain2LVID')))
                                                    @foreach (session('KPIMain2LVID') as $KPIMain2LVID)
                                                        @if ($KPI->KPIMain2LVID == $KPIMain2LVID && $KPI->SFA2LVID == session('SFA2LVID')[$index])
                                                            <div class="mt-2 d-flex">
                                                                <input type="hidden" name="SFAMap[]"
                                                                    value="{{ $KPI->SFA2LVID }}">
                                                                <input type="hidden" name="KPIMain2LVID[]"
                                                                    value="{{ $KPI->KPIMain2LVID }}">
                                                                <input class="form-control mr-2" type="text"
                                                                    id="KPIMain2LVID" value="{{ $KPI->name }}"
                                                                    readonly>
                                                                <input class="form-control mr-2" type="text"
                                                                    name="count2LVID[]" id="count2LVID"
                                                                    value="{{ $KPI->count ?? '-' }}" readonly>
                                                                <input class="form-control" type="text"
                                                                    name="target2LVID[]" id="target2LVID"
                                                                    value="{{ $KPI->target ?? '-' }}" readonly>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach


                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        @if (session()->has('stra1LVID'))
                            @foreach (session('stra1LVID') as $index => $item)
                                {{-- {{dd(session('stra1LVID'))}} --}}
                                <div class="row field item form-group align-items-center">
                                    <label for="plan"
                                        class="col-form-label col-md-3 col-sm-3 label-align">แผนยุทธศาสตร์<span
                                            class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="hidden" name="stra1LVID[]" value="{{ $item }}">
                                        @foreach ($strategic1LV as $stra)
                                            @if ($stra->stra1LVID == $item)
                                                <input class="form-control" type="text" id="stra1LVID"
                                                    data-validate-length-range="8,20" value="{{ $stra->name }}"
                                                    readonly />
                                            @endif
                                        @endforeach

                                    </div>

                                </div>
                                <div class="col-md-3"></div>
                                <div class="col-md-9 border mb-2 p-2">
                                    <div class="row field item form-group align-items-center">
                                        <label for="title"
                                            class="col-form-label col-md-3 col-sm-3  label-align">เป้าหมาย<span
                                                class="required">*</span></label>
                                        <div class="col-md-8 col-sm-8">

                                            @foreach ($target1LV as $tar)
                                                @if (session()->has('tar1LVID') && is_array(session('tar1LVID')))
                                                    @foreach (session('tar1LVID') as $tar1LVID)
                                                        @if ($tar->tar1LVID == $tar1LVID && $tar->stra1LVID == $item)
                                                            <input type="hidden" name="tar1LVID[]"
                                                                value="{{ $tar->tar1LVID }}">
                                                            <input class="form-control" type="text" id="tar1LV"
                                                                data-validate-length-range="8,20"
                                                                value="{{ $tar->name }}" readonly />
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        @php
                            $currentDate = date('Y-m-d');

                        @endphp

                        <div class="row field item form-group align-items-center">
                            <label for="title" class="col-form-label col-md-2 col-sm-2 label-align">ประเภทโครงการ<span
                                    class="required">*</span></label>
                            <div class="col-md-4 col-sm-4">

                                <select id="type" name="proTypeID" class="form-control">
                                    @foreach ($projectType as $item)
                                        @if ($item->proTypeID == 3)
                                            @if ($currentDate >= $dateInPlan->startDate && $currentDate <= $dateInPlan->endDate)
                                                <option value="{{ $item->proTypeID }}">
                                                    {{ $item->name }}
                                                </option>
                                            @endif
                                        @else
                                            <option value="{{ $item->proTypeID }}">
                                                {{ $item->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <label for="title" class="col-form-label col-md-2 col-sm-2 label-align">ลักษณะโครงการ<span
                                    class="required">*</span></label>
                            <div class="col-md-4 col-sm-4">
                                <select id="charecter" name="proChaID" class="form-control">
                                    @foreach ($projectCharec as $item)
                                        <option value="{{ $item->proChaID }}">
                                            {{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row field item form-group align-items-center">
                            <label for="integrat" class="col-form-label col-md-3 col-sm-3 label-align">การบูรณาการ<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <select id="integrat" name="proInID" class="form-control" onclick="toggleTextarea()">
                                    @foreach ($projectIntegrat as $item)
                                        <option value="{{ $item->proInID }}">
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row field item form-group align-items-center" style="display: none"
                            id="otherTextContainer">
                            <label for="otherText" class="col-form-label col-md-3 col-sm-3 label-align"></label>
                            <div class="col-md-6 col-sm-6">
                                <textarea id="proInDetail" name="proInDetail" class="form-control" placeholder="เรื่อง"></textarea>
                            </div>
                        </div>


                        <div class="row field item form-group align-items-center">
                            <label for="title"
                                class="col-form-label col-md-3 col-sm-3  label-align">หลักการและเหตุผล<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 d-flex">
                                <textarea class="form-control" name="principle" id="principle" required></textarea>
                            </div>
                        </div>


                        <div class="row field item form-group align-items-center">
                            <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">วัตถุประสงค์<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control" type="text" name="obj[]" id="obj" required />
                            </div>
                            <div class="col-md-3 col-sm-3">
                                <button type='button' class="btn btn-primary" onclick="insertObj()">เพิ่ม</button>
                            </div>
                        </div>

                        <div id="insertObj"></div>

                        <div class="row field item form-group align-items-center">
                            <label for="title"
                                class="col-form-label col-md-2 col-sm-2 label-align">ตัวชี้วัดความสำเร็จโครงการ<span
                                    class="required">*</span></label>
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
                                <div class="col-md-12 col-sm-12">
                                    <div class="row col-md-4 col-sm-4 m-1">
                                        <input class="form-control" type="text" name="KPIProject[]" id=""
                                            required>
                                    </div>
                                    <div class="row col-md-3 col-sm-3 m-1">
                                        <select id="countKPIProject" name="countKPIProject[]" class="form-control"
                                            required>
                                            <option value="">--</option>
                                            @foreach ($CountKPIProjects as $item)
                                                <option value="{{ $item->countKPIProID }}">
                                                    {{ $item->name }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="row col-md-3 col-sm-3 m-1">
                                        <input class="form-control" type="text" name="targetProject[]"
                                            inputmode="decimal" pattern="[0-9]*" id="targetKPI" required>
                                        <div class="invalid-feedback">
                                            กรุณากรอกเฉพาะตัวเลขหรือทศนิยมเท่านั้น
                                        </div>
                                    </div>
                                    <div class="col-md-1 col-sm-1 m-1">
                                        <button type='button' class="btn btn-primary"
                                            onclick="insertKPIProject()">เพิ่ม</button>

                                    </div>
                                </div>
                                <div id="insertKPIProject"></div>
                            </div>
                        </div>



                        <div class="row field item form-group align-items-center">
                            <label for="title" class="col-form-label col-md-3 col-sm-3 label-align">กลุ่มเป้าหมาย<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <select id="target" name="tarID" class="form-control" required>
                                    @foreach ($target as $item)
                                        <option value="{{ $item->tarID }}">
                                            {{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <div class="row field item form-group align-items-center">
                            <label for="title"
                                class="col-form-label col-md-2 col-sm-2 label-align">ขั้นตอนการดำเนินการ</label>
                            <div class="row col-md-9 col-sm-9 border m-1">
                                <div class="col-md-12 col-sm-12">
                                    <div
                                        class="row col-md-4 col-sm-4 m-1 d-flex justify-content-center align-items-center">
                                        <label for="title" class="col-form-label label-align">รายการกิจกรรม</label>
                                    </div>
                                    <div
                                        class="row col-md-3 col-sm-3 m-1 d-flex justify-content-center align-items-center">
                                        <label class="col-form-label label-align ">เริ่มต้น</label>

                                    </div>
                                    <div
                                        class="row col-md-3 col-sm-3 m-1 d-flex justify-content-center align-items-center">
                                        <label for="title" class="col-form-label label-align">สิ้นสุด</label>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="row col-md-4 col-sm-4 m-1">
                                        <input class="form-control" type="text" name="stepName[]" id=""
                                            required>
                                        @error('stepName.*')
                                            <div class="m-2">
                                                <span class="text text-danger">{{ $message }}</span>
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="row col-md-3 col-sm-3 m-1">
                                        <input class="form-control" type="date" name="stepStart[]" id=""
                                            required>
                                        @error('stepStart.*')
                                            <div class="m-2">
                                                <span class="text text-danger">{{ $message }}</span>
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="row col-md-3 col-sm-3 m-1">
                                        <input class="form-control" type="date" name="stepEnd[]" id=""
                                            required>
                                        @error('stepEnd.*')
                                            <div class="m-2">
                                                <span class="text text-danger">{{ $message }}</span>
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-1 col-sm-1 m-1">
                                        <button type='button' class="btn btn-primary"
                                            onclick="insertStep()">เพิ่ม</button>
                                    </div>
                                </div>
                                <div id="insertStep"></div>
                            </div>
                        </div>

                        <div class="row field item form-group align-items-center">
                            <label for="title"
                                class="col-form-label col-md-3 col-sm-3 label-align">แหล่งเงินประเภทงบประมาณที่ใช้<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <select id="badget" name="badID" class="form-control" required>
                                    @foreach ($badgetType as $item)
                                        <option value="{{ $item->badID }}">
                                            {{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row field item form-group align-items-center">
                            <label for="title" class="col-form-label col-md-3 col-sm-3 label-align">แผนงาน<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <select id="planID" name="planID" class="form-control" required>
                                    @foreach ($uniplan as $item)
                                        <option value="{{ $item->planID }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-form-label col-md-2 col-sm-2">ประเภทค่าใช้จ่าย</label>
                        </div>

                        <div class="row field item form-group align-items-center">
                            <div class=" col-md-12 col-sm-12 border p-1">
                                <div class="col-md-12 col-sm-12">
                                    <div
                                        class="row col-md-3 col-sm-3 mr-1 d-flex justify-content-center align-items-center">
                                        <label for="title" class="col-form-label label-align"></label>
                                    </div>
                                    <div
                                        class="row col-md-2 col-sm-2 mr-1 d-flex justify-content-center align-items-center">
                                        <label class="col-form-label label-align ">ไตรมาส 1 (ต.ค-ธ.ค)</label>

                                    </div>
                                    <div
                                        class="row col-md-2 col-sm-2 mr-1 d-flex justify-content-center align-items-center">
                                        <label for="title" class="col-form-label label-align">ไตรมาส 2
                                            (ม.ค-มี.ค)</label>
                                    </div>
                                    <div
                                        class="row col-md-2 col-sm-2 mr-1 d-flex justify-content-center align-items-center">
                                        <label for="title" class="col-form-label label-align">ไตรมาส 3
                                            (เม.ย-มิ.ย)</label>
                                    </div>
                                    <div
                                        class="row col-md-2 col-sm-2 mr-1 d-flex justify-content-center align-items-center">
                                        <label for="title" class="col-form-label label-align">ไตรมาส 4
                                            (ก.ค-ก.ย)</label>
                                    </div>
                                </div>


                                <div class="col-md-12 col-sm-12 ">
                                    <div
                                        class="row col-md-3 col-sm-3 mr-1 d-flex justify-content-center align-items-center">
                                        <label for="title" class="col-form-label label-align">ประเภทรายจ่าย</label>
                                    </div>
                                    <div
                                        class="row col-md-2 col-sm-2 mr-1 d-flex justify-content-center align-items-center">
                                        <label class="col-form-label label-align ">แผนการใช้จ่าย</label>

                                    </div>
                                    <div
                                        class="row col-md-2 col-sm-2 mr-1 d-flex justify-content-center align-items-center">
                                        <label for="title" class="col-form-label label-align">แผนการใช้จ่าย</label>
                                    </div>
                                    <div
                                        class="row col-md-2 col-sm-2 mr-1 d-flex justify-content-center align-items-center">
                                        <label for="title" class="col-form-label label-align">แผนการใช้จ่าย</label>
                                    </div>
                                    <div
                                        class="row col-md-2 col-sm-2 mr-1 d-flex justify-content-center align-items-center">
                                        <label for="title" class="col-form-label label-align">แผนการใช้จ่าย</label>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 ">

                                    <div class="row col-md-3 col-sm-3 mr-1">
                                        <select id="expID" name="expID[]" class="form-control">
                                            @foreach ($expanses as $item)
                                                <option value="{{ $item->expID }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 mt-2">
                                    <div class="row col-md-3 col-sm-3 mr-1">
                                        <select id="costType" name="costID[]" class="form-control">
                                            @foreach ($costTypes as $item)
                                                <option value="{{ $item->costTypeID }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="row col-md-2 col-sm-2 mr-1">
                                        <input class="form-control cost-input" type="text" name="costQu1[]"
                                            id="" required>
                                        {{-- @error('costQu1.*')
                                            <div class="m-2">
                                                <span class="text text-danger">{{ $message }}</span>
                                            </div>
                                        @enderror --}}
                                    </div>
                                    <div class="row col-md-2 col-sm-2 mr-1">
                                        <input class="form-control cost-input" type="text" name="costQu2[]"
                                            id="" required>
                                        {{-- @error('costQu2.*')
                                            <div class="m-2">
                                                <span class="text text-danger">{{ $message }}</span>
                                            </div>
                                        @enderror --}}
                                    </div>
                                    <div class="row col-md-2 col-sm-2 mr-1">
                                        <input class="form-control cost-input" type="text" name="costQu3[]"
                                            id="" required>
                                        {{-- @error('costQu3.*')
                                            <div class="m-2">
                                                <span class="text text-danger">{{ $message }}</span>
                                            </div>
                                        @enderror --}}
                                    </div>
                                    <div class="row col-md-2 col-sm-2 mr-1">
                                        <input class="form-control cost-input" type="text" name="costQu4[]"
                                            id="" required>
                                        {{-- @error('costQu4.*')
                                            <div class="m-2">
                                                <span class="text text-danger">{{ $message }}</span>
                                            </div>
                                        @enderror --}}
                                    </div>
                                    <div class="col-md-1 col-sm-1 ">
                                        <button type='button' class="btn btn-primary"
                                            onclick="insertCostType()">เพิ่ม</button>
                                    </div>
                                </div>

                                <div id="insertExpense"></div>
                                <div id="insertCostType"></div>
                            </div>
                        </div>




                        <div class="row field item form-group align-items-center">
                            <label for="title"
                                class="col-form-label col-md-3 col-sm-3  label-align">ประมาณการงบประมาณที่ใช้<span
                                    class="required">*</span></label>
                            <div class="col-md-3 col-sm-3">
                                <input class="form-control" type="text" name="badgetTotal" id="badgetTotal"
                                    data-validate-length-range="8,20" readonly oninput="updateText()" />

                            </div>
                            <div class="col-md-5 col-sm-5">
                                <input class="form-control" type="text" name="badgetTotalText" id="badgetTotalText"
                                    data-validate-length-range="8,20" disabled />

                            </div>

                        </div>

                        <div class="row field item form-group align-items-center">
                            <label for="title"
                                class="col-form-label col-md-3 col-sm-3  label-align">ประโยชน์ที่คาดว่าจะได้รับ<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control" type="text" name="benefit[]" id="benefit" required>
                                {{-- @error('benefit.*')
                                    <div class="m-2">
                                        <span class="text text-danger">{{ $message }}</span>
                                    </div>
                                @enderror --}}
                            </div>
                            <div class="col-md-1 col-sm-1 ">
                                <button type='button' class="btn btn-primary" onclick="insertBenefit()">เพิ่ม</button>

                            </div>
                        </div>
                        <div id="insertBenefit"></div>
                        {{-- ยังไม่ต้องฟิก ถ้าเลือกครุภัณฑ์ต้องแนบไฟล์ --}}
                        <div class="row field item form-group align-items-center">
                            <label for="title"
                                class="col-form-label col-md-3 col-sm-3  label-align">ไฟล์เอกสารประกอบโครงการ</label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control" type="file" name="file[]" id="file">

                            </div>
                            {{-- เช็คจากค่าใช้สอย กับค่า ครุภัณฑ์  --}}
                            <div class="col-md-1 col-sm-1 ">
                                <button type='button' class="btn btn-primary" onclick="insertFile()">เพิ่ม</button>
                            </div>
                        </div>
                        <div id="insertFile"></div>


                        <div class="ln_solid">
                            <div class="form-group ">
                                <div class="col-md-6 offset-md-3">
                                    <button type='submit' class="btn btn-primary">บันทึก</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-1 col-sm-1"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
        const funds = @json($fund);
        const expenses = @json($expanses);
        const costTypes = @json($costTypes);
        const proIn = @json($projectIntegrat);



        const users = @json($user);
        const currentUserId = {{ Auth::user()->userID }};

        const input = document.getElementById('targetKPI');
        const feedback = document.getElementById('targetKPI-feedback');

        input.addEventListener('keypress', function(e) {
            const char = String.fromCharCode(e.which);

            // ถ้าไม่ใช่ตัวเลขหรือจุด
            if (!/[0-9.]/.test(char)) {
                e.preventDefault();
                input.classList.add('is-invalid');
                feedback.style.display = 'block';
            }

            // ถ้าเป็นจุด แล้วมีจุดอยู่แล้วใน input
            if (char === '.' && input.value.includes('.')) {
                e.preventDefault();
                input.classList.add('is-invalid');
                feedback.style.display = 'block';
            }
        });

        input.addEventListener('input', function() {
            const value = input.value;

            // ตรวจสอบว่ามีแค่จุดเดียว และเป็นรูปแบบตัวเลข/ทศนิยม
            const valid = /^(\d+(\.\d*)?)?$/.test(value);

            if (valid) {
                input.classList.remove('is-invalid');
                feedback.style.display = 'none';
            } else {
                input.classList.add('is-invalid');
                feedback.style.display = 'block';
            }
        });

        function calculateTotal() {
            // ดึงค่าจากช่อง input ที่มี class "cost-input"
            const inputs = document.querySelectorAll('.cost-input');
            let total = 0;

            // รวมค่าของแต่ละช่อง
            inputs.forEach(input => {
                const value = parseFloat(input.value) || 0; // แปลงค่าเป็นตัวเลข ถ้าไม่มีให้ใช้ 0
                total += value;
            });

            // แสดงผลรวมในช่อง badgetTotal
            document.getElementById('badgetTotal').value = total.toFixed(2); // แสดงผลแบบทศนิยม 2 ตำแหน่ง
            updateText();
        }

        // เพิ่ม event listener ให้ช่อง input ที่มี class "cost-input"
        document.querySelectorAll('.cost-input').forEach(input => {
            input.addEventListener('input', calculateTotal);
        });

        // เรียกคำนวณครั้งแรก (กรณีมีค่าเริ่มต้นในช่อง input)
        calculateTotal();

        function updateText() {
            const numberInput = document.getElementById("badgetTotal").value;
            const textOutput = document.getElementById("badgetTotalText");
            textOutput.value = convertNumberToThaiText(numberInput);
        }

        function convertNumberToThaiText(num) {
            if (!num || isNaN(num)) return '';
            const thaiNumbers = ['ศูนย์', 'หนึ่ง', 'สอง', 'สาม', 'สี่', 'ห้า', 'หก', 'เจ็ด', 'แปด', 'เก้า'];
            const thaiUnits = ['', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน'];

            num = parseFloat(num).toFixed(2); // ทำให้เป็นทศนิยม 2 ตำแหน่ง
            const [integerPart, decimalPart] = num.split('.'); // แยกส่วนจำนวนเต็มและทศนิยม

            let result = '';
            const len = integerPart.length;

            // แปลงส่วนจำนวนเต็ม
            for (let i = 0; i < len; i++) {
                const digit = parseInt(integerPart[i]);
                const position = len - i - 1;

                if (digit === 0) continue;
                if (position === 1 && digit === 1) result += 'สิบ';
                else if (position === 1 && digit === 2) result += 'ยี่สิบ';
                else if (position === 0 && digit === 1 && len > 1) result += 'เอ็ด';
                else result += thaiNumbers[digit] + thaiUnits[position % 6];
            }

            // แปลงส่วนทศนิยม
            if (decimalPart && decimalPart !== '00') {
                result += 'บาท' + ' ' + 'จุด';
                for (let digit of decimalPart) {
                    result += thaiNumbers[parseInt(digit)];
                }
                result += 'สตางค์';
            } else {
                result += 'บาทถ้วน';
            }

            return result;
        }


        function addNewUserDropdown() {
            const dropdownCount = document.querySelectorAll('.userDropdown').length + 1;

            const mainContainer = document.createElement('div');
            mainContainer.classList.add('row', 'field', 'item', 'form-group', 'align-items-center');

            const colMd3 = document.createElement('div');
            colMd3.classList.add('col-md-3', 'col-sm-3');
            // ใส่ข้อความหรือเนื้อหา

            const dropdownCol = document.createElement('div');
            dropdownCol.classList.add('col-md-6', 'col-sm-6');

            const userDropdown = document.createElement('select');
            userDropdown.classList.add('form-control', 'userDropdown'); // เพิ่มคลาสเพื่อทำให้สามารถระบุได้ง่ายขึ้น
            userDropdown.id = `userID${dropdownCount}`;
            userDropdown.innerHTML = '';
            userDropdown.name = 'userID[]';

            users.forEach(user => {
                if (user.userID != currentUserId) {
                    const option = document.createElement('option');
                    option.value = user.userID;
                    option.textContent = user.displayname;
                    userDropdown.appendChild(option);
                }
            });

            dropdownCol.appendChild(userDropdown);
            mainContainer.appendChild(colMd3);
            mainContainer.appendChild(dropdownCol);

            const deleteButton = document.createElement('button');
            deleteButton.type = 'button';
            deleteButton.classList.add('btn', 'btn-danger', 'ml-2'); // เพิ่มคลาส Bootstrap
            deleteButton.textContent = 'ลบ';
            deleteButton.onclick = function() {
                mainContainer.remove(); // ลบ mainContainer เมื่อคลิกปุ่ม
            };

            // เพิ่มปุ่มลบลงใน mainContainer
            mainContainer.appendChild(deleteButton);

            document.getElementById('userDropdownContainer').appendChild(mainContainer);
        }




        function insertObj() {
            const mainContainer = document.createElement('div');
            mainContainer.classList.add('row', 'field', 'item', 'form-group', 'align-items-center');

            const colMD3 = document.createElement('div');
            colMD3.classList.add('col-md-3', 'col-sm-3');

            const colMD6 = document.createElement('div');
            colMD6.classList.add('col-md-6', 'col-sm-6');

            const InputObjt = document.createElement('input');
            InputObjt.classList.add('form-control');
            InputObjt.type = 'text';
            InputObjt.name = 'obj[]';

            mainContainer.appendChild(colMD3);
            mainContainer.appendChild(colMD6);
            colMD6.appendChild(InputObjt);

            const deleteButton = document.createElement('button');
            deleteButton.type = 'button';
            deleteButton.classList.add('btn', 'btn-danger', 'ml-2'); // เพิ่มคลาส Bootstrap
            deleteButton.textContent = 'ลบ';
            deleteButton.onclick = function() {
                mainContainer.remove(); // ลบ mainContainer เมื่อคลิกปุ่ม
            };

            // เพิ่มปุ่มลบลงใน mainContainer
            mainContainer.appendChild(deleteButton);

            document.getElementById('insertObj').appendChild(mainContainer);

        }





        function insertKPIProject() {
            const mainContainer = document.createElement('div');
            mainContainer.classList.add('col-md-12', 'col-sm-12');
            mainContainer.style.display = "flex";

            const colKPI = document.createElement('div');
            colKPI.classList.add('col-md-4', 'col-sm-4', 'm-1');

            const KPIInput = document.createElement('input');
            KPIInput.classList.add('form-control');
            KPIInput.type = 'text';
            KPIInput.name = 'KPIProject[]';

            const colCount = document.createElement('div');
            colCount.classList.add('col-md-3', 'col-sm-3', 'm-1');

            const countInput = document.createElement('select');
            countInput.classList.add('form-control');
            countInput.id = 'countKPIProject';
            countInput.name = 'countKPIProject[]';

            const originalOptions = document.querySelector('#countKPIProject').innerHTML;
            countInput.innerHTML = originalOptions;

            const colTarget = document.createElement('div');
            colTarget.classList.add('col-md-3', 'col-sm-3', 'm-1');

            const targetInput = document.createElement('input');
            targetInput.classList.add('form-control');
            targetInput.type = 'text';
            targetInput.name = 'targetProject[]';

            // เพิ่มข้อความแจ้งเตือน (feedback)
            const feedback = document.createElement('div');
            feedback.classList.add('invalid-feedback');
            feedback.style.display = 'none';
            feedback.textContent = 'กรุณากรอกเฉพาะตัวเลขและทศนิยม';

            // วาง targetInput และ feedback ใน colTarget
            colTarget.appendChild(feedback); // ขยับ feedback ไปอยู่ด้านล่างของ targetInput
            colTarget.appendChild(targetInput);
            
            // เพิ่ม event listener ให้ targetInput
            targetInput.addEventListener('keypress', function(e) {
                const char = String.fromCharCode(e.which);

                // ถ้าไม่ใช่ตัวเลขหรือจุด
                if (!/[0-9.]/.test(char)) {
                    e.preventDefault();
                    targetInput.classList.add('is-invalid');
                    feedback.style.display = 'block';
                }

                // ถ้าเป็นจุด แล้วมีจุดอยู่แล้วใน input
                if (char === '.' && targetInput.value.includes('.')) {
                    e.preventDefault();
                    targetInput.classList.add('is-invalid');
                    feedback.style.display = 'block';
                }
            });

            targetInput.addEventListener('input', function() {
                const value = targetInput.value;

                // ตรวจสอบว่ามีแค่จุดเดียว และเป็นรูปแบบตัวเลข/ทศนิยม
                const valid = /^(\d+(\.\d*)?)?$/.test(value);

                if (valid) {
                    targetInput.classList.remove('is-invalid');
                    feedback.style.display = 'none';
                } else {
                    targetInput.classList.add('is-invalid');
                    feedback.style.display = 'block';
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
            colKPI.appendChild(KPIInput);
            colCount.appendChild(countInput);
            colTarget.appendChild(targetInput);
            colDelete.appendChild(deleteButton);
            // เพิ่มปุ่มลบลงใน mainContainer
            document.getElementById('insertKPIProject').appendChild(mainContainer);
        }

        function insertStep() {
            const mainContainer = document.createElement('div');
            mainContainer.classList.add('col-md-12', 'col-sm-12');

            const colName = document.createElement('div');
            colName.classList.add('col-md-4', 'col-sm-4', 'm-1');

            const NameInput = document.createElement('input');
            NameInput.classList.add('form-control');
            NameInput.type = 'text';
            NameInput.name = 'stepName[]';

            const colStart = document.createElement('div');
            colStart.classList.add('col-md-3', 'col-sm-3', 'm-1');

            const startInput = document.createElement('input');
            startInput.classList.add('form-control');
            startInput.type = 'date';
            startInput.name = 'stepStart[]';

            const colEnd = document.createElement('div');
            colEnd.classList.add('col-md-3', 'col-sm-3', 'm-1');

            const EndInput = document.createElement('input');
            EndInput.classList.add('form-control');
            EndInput.type = 'date';
            EndInput.name = 'stepEnd[]';

            const colDelete = document.createElement('div');
            colDelete.classList.add('col-md-1', 'col-sm-1', 'm-1');

            const deleteButton = document.createElement('button');
            deleteButton.type = 'button';
            deleteButton.classList.add('btn', 'btn-danger'); // เพิ่มคลาส Bootstrap
            deleteButton.textContent = 'ลบ';
            deleteButton.onclick = function() {
                mainContainer.remove(); // ลบ mainContainer เมื่อคลิกปุ่ม
            };
            mainContainer.appendChild(colName);
            mainContainer.appendChild(colStart);
            mainContainer.appendChild(colEnd);
            mainContainer.appendChild(colDelete);
            colName.appendChild(NameInput);
            colStart.appendChild(startInput);
            colEnd.appendChild(EndInput);
            colDelete.appendChild(deleteButton);
            // เพิ่มปุ่มลบลงใน mainContainer
            document.getElementById('insertStep').appendChild(mainContainer);
        }


        $(document).ready(function() {
            // $('planID').change(function(event){
            //     var planID = this.value;
            //     console.log(planID);
            //     // $('[id^="expID_"]');
            //     $('exp');
            //     $.ajax({
            //         url: "/projectfund",
            //         type: "POST",
            //         dataType: 'json',
            //         data:{
            //             planID: planID,
            //             _token: "{{ csrf_token() }}"
            //         },
            //         success: function(response) {
            //             $('expID').html('<option value="">--</option>');
            //         }
            //     });
            // })

        })

        function insertCostType() {
            const dropdownCount = document.querySelectorAll('.Expense').length + 1;

            const mainExpenseContainer = document.createElement('div');
            mainExpenseContainer.classList.add('col-md-12', 'col-sm-12');

            const colExpense = document.createElement('div');
            colExpense.classList.add('col-md-3', 'col-sm-3', 'mr-1');
            // ใส่ข้อความหรือเนื้อหา

            const ExpenseDropdown = document.createElement('select');
            ExpenseDropdown.classList.add('form-control'); // เพิ่มคลาสเพื่อทำให้สามารถระบุได้ง่ายขึ้น
            ExpenseDropdown.id = `expID_${Date.now()}`;
            ExpenseDropdown.name = 'expID[]';
            // ExpenseDropdown.innerHTML = '';

            const selectedPlanID = document.getElementById('planID').value;

            const relatedFunds = funds.filter(fund => fund.planID == selectedPlanID);

            const filteredExpenses = expenses.filter(expense =>
                relatedFunds.some(fund => fund.fundID == expense.fundID)
            );

            if (filteredExpenses.length === 0) {
                const noExpenseOption = document.createElement('option');
                noExpenseOption.value = '';
                noExpenseOption.textContent = 'ไม่มีงบรายจ่าย';
                ExpenseDropdown.appendChild(noExpenseOption);
                ExpenseDropdown.disabled = true; // Disable expense dropdown
            } else {
                ExpenseDropdown.disabled = false; // Enable expense dropdown
                filteredExpenses.forEach(expense => {
                    const option = document.createElement('option');
                    option.value = expense.expID;
                    option.textContent = expense.name;
                    ExpenseDropdown.appendChild(option);
                });

            }
            //
            colExpense.appendChild(ExpenseDropdown);
            mainExpenseContainer.appendChild(colExpense);

            const mainCostTypeContainer = document.createElement('div');
            mainCostTypeContainer.classList.add('col-md-12', 'col-sm-12', 'mt-2');

            const colCostType = document.createElement('div');
            colCostType.classList.add('row', 'col-md-3', 'col-sm-3', 'mr-1');

            const costTypeDropdown = document.createElement('select');
            costTypeDropdown.classList.add('form-control'); // เพิ่มคลาสเพื่อทำให้สามารถระบุได้ง่ายขึ้น
            costTypeDropdown.id = `costType_${Date.now()}`;
            costTypeDropdown.name = 'costID[]';
            costTypeDropdown.innerHTML = '';

            const updateCostTypeDropdown = () => {
                const selectedEXPID = ExpenseDropdown.value;
                costTypeDropdown.innerHTML = '';

                // กรองกองทุนที่เชื่อมกับแผน
                const filteredCostType = costTypes.filter(costType => costType.expID == selectedEXPID);

                if (filteredCostType.length === 0) {
                    const noCostTypeOption = document.createElement('option');
                    noCostTypeOption.value = '';
                    noCostTypeOption.textContent = 'ไม่มีหมวดรายจ่าย';
                    costTypeDropdown.appendChild(noCostTypeOption);
                    costTypeDropdown.disabled = true; // Disable expense dropdown
                } else {
                    costTypeDropdown.disabled = false; // Enable expense dropdown
                    filteredCostType.forEach(costType => {
                        const option = document.createElement('option');
                        option.value = costType.costID;
                        option.textContent = costType.name;
                        costTypeDropdown.appendChild(option);
                    });
                }
            };

            ExpenseDropdown.addEventListener('change', updateCostTypeDropdown);
            updateCostTypeDropdown();

            colCostType.appendChild(costTypeDropdown);
            mainCostTypeContainer.appendChild(colCostType);

            const colCostQu1 = document.createElement('div');
            colCostQu1.classList.add('row', 'col-md-2', 'col-sm-2', 'mr-1');

            const CostQu1Input = document.createElement('input');
            CostQu1Input.classList.add('form-control', 'cost-input');
            CostQu1Input.type = 'text';
            CostQu1Input.name = 'costQu1[]';
            CostQu1Input.addEventListener('input', calculateTotal);

            colCostQu1.appendChild(CostQu1Input);
            mainCostTypeContainer.appendChild(colCostQu1);

            const colCostQu2 = document.createElement('div');
            colCostQu2.classList.add('row', 'col-md-2', 'col-sm-2', 'mr-1');

            const CostQu2Input = document.createElement('input');
            CostQu2Input.classList.add('form-control', 'cost-input');
            CostQu2Input.type = 'text';
            CostQu2Input.name = 'costQu2[]';
            CostQu2Input.addEventListener('input', calculateTotal);

            colCostQu2.appendChild(CostQu2Input);
            mainCostTypeContainer.appendChild(colCostQu2);

            const colCostQu3 = document.createElement('div');
            colCostQu3.classList.add('row', 'col-md-2', 'col-sm-2', 'mr-1');

            const CostQu3Input = document.createElement('input');
            CostQu3Input.classList.add('form-control', 'cost-input');
            CostQu3Input.type = 'text';
            CostQu3Input.name = 'costQu3[]';
            CostQu3Input.addEventListener('input', calculateTotal);

            colCostQu3.appendChild(CostQu3Input);
            mainCostTypeContainer.appendChild(colCostQu3);


            const colCostQu4 = document.createElement('div');
            colCostQu4.classList.add('row', 'col-md-2', 'col-sm-2', 'mr-1');

            const CostQu4Input = document.createElement('input');
            CostQu4Input.classList.add('form-control', 'cost-input');
            CostQu4Input.type = 'text';
            CostQu4Input.name = 'costQu4[]';
            CostQu4Input.addEventListener('input', calculateTotal);

            colCostQu4.appendChild(CostQu4Input);
            mainCostTypeContainer.appendChild(colCostQu4);


            const deleteButton = document.createElement('button');
            deleteButton.type = 'button';
            deleteButton.classList.add('btn', 'btn-danger', 'ml-2'); // เพิ่มคลาส Bootstrap
            deleteButton.textContent = 'ลบ';
            deleteButton.onclick = function() {
                mainExpenseContainer.remove();
                mainCostTypeContainer.remove(); // ลบ mainContainer เมื่อคลิกปุ่ม
            };

            // เพิ่มปุ่มลบลงใน mainContainer
            mainCostTypeContainer.appendChild(deleteButton);

            document.getElementById('insertExpense').appendChild(mainExpenseContainer);
            document.getElementById('insertExpense').appendChild(mainCostTypeContainer);
        }

        function toggleTextarea() {
            var select = document.getElementById("integrat");
            var otherTextContainer = document.getElementById("otherTextContainer");

            if (select.value === '6') {
                otherTextContainer.style.display = "flex";
                otherTextContainer.required = true;
            } else {
                otherTextContainer.style.display = "none";
            }
        }


        function insertBenefit() {
            const mainContainer = document.createElement('div');
            mainContainer.classList.add('row', 'field', 'item', 'form-group', 'align-items-center');

            const colMD3 = document.createElement('div');
            colMD3.classList.add('col-md-3', 'col-ssm-3');

            const colMD6 = document.createElement('div');
            colMD6.classList.add('col-md-6', 'col-sm-6');

            const InputBenefit = document.createElement('input');
            InputBenefit.classList.add('form-control');
            InputBenefit.type = 'text';
            InputBenefit.name = 'benefit[]';

            mainContainer.appendChild(colMD3);
            mainContainer.appendChild(colMD6);
            colMD6.appendChild(InputBenefit);

            const deleteButton = document.createElement('button');
            deleteButton.type = 'button';
            deleteButton.classList.add('btn', 'btn-danger', 'ml-2'); // เพิ่มคลาส Bootstrap
            deleteButton.textContent = 'ลบ';
            deleteButton.onclick = function() {
                mainContainer.remove(); // ลบ mainContainer เมื่อคลิกปุ่ม
            };

            // เพิ่มปุ่มลบลงใน mainContainer
            mainContainer.appendChild(deleteButton);

            document.getElementById('insertBenefit').appendChild(mainContainer);

        }

        function insertFile() {
            const mainContainer = document.createElement('div');
            mainContainer.classList.add('row', 'field', 'item', 'form-group', 'align-items-center');

            const colMD3 = document.createElement('div');
            colMD3.classList.add('col-md-3', 'col-sm-3');

            const colMD6 = document.createElement('div');
            colMD6.classList.add('col-md-6', 'col-sm-6');

            const inputFile = document.createElement('input');
            inputFile.classList.add('form-control');
            inputFile.type = 'file';
            inputFile.name = 'file[]';

            mainContainer.appendChild(colMD3);
            mainContainer.appendChild(colMD6);
            colMD6.appendChild(inputFile);


            const deleteButton = document.createElement('button');
            deleteButton.type = 'button';
            deleteButton.classList.add('btn', 'btn-danger', 'ml-2'); // เพิ่มคลาส Bootstrap
            deleteButton.textContent = 'ลบ';
            deleteButton.onclick = function() {
                mainContainer.remove(); // ลบ mainContainer เมื่อคลิกปุ่ม
            };

            // เพิ่มปุ่มลบลงใน mainContainer
            mainContainer.appendChild(deleteButton);

            document.getElementById('insertFile').appendChild(mainContainer);

        }



        function updateExpenseDropdown(selectedPlanID) {
            console.log(selectedPlanID);


            const expenseSelect = document.getElementById('expID');
            expenseSelect.innerHTML = '';

            // กรองกองทุนที่เชื่อมกับแผน
            const relatedFunds = funds.filter(fund => fund.planID == selectedPlanID);

            // กรองงบรายจ่ายตามกองทุนที่เชื่อมกับแผน
            const filteredExpenses = expenses.filter(expense =>
                relatedFunds.some(fund => fund.fundID == expense.fundID)
            );

            if (filteredExpenses.length === 0) {
                const noExpenseOption = document.createElement('option');
                noExpenseOption.value = '';
                noExpenseOption.textContent = 'ไม่มีงบรายจ่าย';
                expenseSelect.appendChild(noExpenseOption);
                updateCostTypeDropdown(null);
                expenseSelect.disabled = true; // Disable expense dropdown
            } else {
                expenseSelect.disabled = false; // Enable expense dropdown
                filteredExpenses.forEach(expense => {
                    const option = document.createElement('option');
                    option.value = expense.expID;
                    option.textContent = expense.name;
                    expenseSelect.appendChild(option);
                });
                updateCostTypeDropdown(filteredExpenses[0].expID);
            }
        }

        function updateCostTypeDropdown(selectedEXPID) {
            const costTypeSelect = document.getElementById('costType');
            costTypeSelect.innerHTML = '';

            // กรองกองทุนที่เชื่อมกับแผน
            const filteredCostType = costTypes.filter(costType => costType.expID == selectedEXPID);

            if (filteredCostType.length === 0) {
                const noCostTypeOption = document.createElement('option');
                noCostTypeOption.value = '';
                noCostTypeOption.textContent = 'ไม่มีหมวดรายจ่าย';
                costTypeSelect.appendChild(noCostTypeOption);
                costTypeSelect.disabled = true; // Disable expense dropdown
            } else {
                costTypeSelect.disabled = false; // Enable expense dropdown
                filteredCostType.forEach(costType => {
                    const option = document.createElement('option');
                    option.value = costType.costID;
                    option.textContent = costType.name;
                    costTypeSelect.appendChild(option);
                });
            }
        }

        function submitButton() {
            var form = document.getElementById('actionForm');
            var costID = document.getElementById('[id^="costType"]');

            console.log(costID);


            form.action = "";

            form.submit();
        }

        // Event listeners สำหรับ dropdown ต่าง ๆ
        window.onload = function() {

            const planSelect = document.getElementById('planID');
            const EXPSelect = document.getElementById('expID');
            planSelect.addEventListener('change', function() {
                const selectedPlanID = this.value;
                console.log(selectedPlanID);
                updateExpenseDropdown(selectedPlanID);
            });
            EXPSelect.addEventListener('change', function() {
                const selectedEXPID = this.value;
                updateCostTypeDropdown(selectedEXPID);
            });


            const defaultPlanID = planSelect.value;
            if (defaultPlanID) {
                updateExpenseDropdown(defaultPlanID);
            }
        };
    </script>
@endsection
