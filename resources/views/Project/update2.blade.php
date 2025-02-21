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
                    <form id="actionForm" method="POST" action=""novalidate enctype="multipart/form-data">
                        @csrf
                        {{-- <input type="hidden" id="proID" name="proID" value="{{$project->proID}}"> --}}
                        <div class="row field item form-group align-items-center">
                            <label for="title" class="col-form-label col-md-3 col-sm-3 label-align">ปีงบประมาณ<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <input type="hidden" name="yearID" value="{{ session('yearID') }}">
                                <input class="form-control" type="text" id="yearID" data-validate-length-range="8,20"
                                    @foreach ($years as $item)
                                        @if ($item->yearID == $project->yearID)
                                        value="{{ $item->year }}" 
                                        @endif @endforeach
                                    disabled />
                            </div>
                        </div>

                        <div class="row field item form-group align-items-center">
                            <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">ชื่อโครงการ<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                @if (session()->has('name'))
                                    <input class="form-control" type="text" name="name" id="name"
                                        data-validate-length-range="8,20" value="{{ session('name') }}" readonly />
                                @else
                                    <input class="form-control" type="text" name="name" id="name"
                                        data-validate-length-range="8,20" value="{{ $project->name }}" readonly />
                                @endif


                            </div>
                        </div>
                        {{-- ถ้ามีหลายคนก็เเก้ไขได้ --}}
                        <div class="row field item form-group align-items-center">
                            <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">เจ้าของโครงการ<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <input type="hidden" name="userID[]" value="{{ Auth::user()->userID }}" />
                                <input class="form-control" type="text" name="user" id="user" required='required'
                                    value="{{ Auth::user()->firstname_en }}" data-validate-length-range="8,20" disabled />

                            </div>

                            <div class="col-md-3 col-sm-3">
                                <button type='button' class="btn btn-primary"
                                    onclick="addNewUserDropdown()">เพิ่มผู้รับผิดชอบ</button>
                            </div>
                        </div>
                        @foreach ($userMap as $index => $item)
                            @if ($index > 0 && $item->proID == $project->proID)
                                <div class="row field item form-group align-items-center">
                                    <div class="col-md-3 col-sm-3"></div>
                                    <div class="col-md-6 col-sm-6">
                                        <select name="userID[]" id="userID" class="form-control">
                                            @foreach ($user as $users)
                                                @if ($users->userID !== Auth::user()->userID)
                                                    <option value="{{ $users->userID }}"
                                                        @if ($users->userID === $item->userID) selected @endif>
                                                        {{ $users->firstname_en }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 col-sm-3">
                                        <button type="button" class="btn btn-danger "
                                            onclick="this.closest('.row').remove()">ลบ</button>
                                    </div>
                                </div>
                            @endif
                        @endforeach

                        <div id="userDropdownContainer"></div>



                        <div class="row field item form-group align-items-center">
                            <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">สังกัด<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control" type="text" name="faculty" id="faculty" required='required'
                                    data-validate-length-range="8,20" disabled value="{{ Auth::user()->faculty_name }}" />
                            </div>

                        </div>
                        <div class="row field item form-group align-items-center">
                            <label for="format" class="col-form-label col-md-3 col-sm-3 label-align">format<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <select id="format" name="format" class="form-control" required>
                                    <option value="team" {{ $project->format == 'team' ? 'selected' : '' }}>team</option>
                                    <option value="department" {{ $project->format == 'department' ? 'selected' : '' }}>
                                        department
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
                                        @foreach ($strategicMap as $map)
                                            @if ($map->stra3LVID == $item)
                                                <input type="hidden" name="straMapID[]" value="{{ $map->straMapID }}">
                                            @endif
                                        @endforeach

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
                                                @if (session()->has('SFA3LVID') && is_array(session('SFA3LVID')))
                                                    @foreach (session('SFA3LVID') as $SFA3LVID)
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
                                            {{-- <input type="text" value="{{session('goal3LVID')[$index]}}"> --}}
                                            @foreach ($goals as $goal)
                                                @if (session()->has('goal3LVID') && is_array(session('goal3LVID')))
                                                
                                                    @foreach (session('goal3LVID') as $goal3LVID)
                                                        @if ($goal->goal3LVID == $goal3LVID && $goal->SFA3LVID == session('SFA3LVID')[$index])
                                                            <input type="hidden" name="goal3LVID[]"
                                                                value="{{ $goal->goal3LVID }}">
                                                            <input class="form-control" type="text" id="goal3LVID"
                                                                value="{{ $goal->name }}" 
                                                                readonly>
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
                                                @if (session()->has('tac3LVID') && is_array(session('tac3LVID')))
                                                    @foreach (session('tac3LVID') as $tac3LVID)
                                                        @if ($tactic->tac3LVID == $tac3LVID && $tactic->goal3LVID == session('goal3LVID')[$index])
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
                                        <div class="row col-md-8 col-sm-8">

                                            @foreach ($KPIMains as $KPI)
                                                @if (session()->has('KPIMain3LVID') && is_array(session('KPIMain3LVID')))
                                                    @foreach (session('KPIMain3LVID') as $KPIMain3LVID)
                                                        @if ($KPI->KPIMain3LVID == $KPIMain3LVID && $KPI->goal3LVID == session('goal3LVID')[$index])
                                                            <div class="mt-2 d-flex">
                                                                <input type="hidden" name="goalMap[]" value="{{$KPI->goal3LVID}}">
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
                            {{-- @else
                            @foreach ($strategicMap as $item)
                                @if ($item->proID == $project->proID)
                                    <div class="row field item form-group align-items-center">
                                        <label for="plan"
                                            class="col-form-label col-md-3 col-sm-3 label-align">แผนยุทธศาสตร์<span
                                                class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6">
                                            <input class="form-control" type="text" name="name" id="name"
                                                data-validate-length-range="8,20"
                                                @foreach ($strategic as $stra)
                                                @if ($stra->stra3LVID == $item->stra3LVID)
                                                    value="{{ $stra->name }}" 
                                                @endif @endforeach
                                                readonly />
                                        </div>

                                    </div>
                                    <div class="col-md-3"></div>
                                    <div class="col-md-9 border mb-2 p-2">
                                        <div class="row field item form-group align-items-center">
                                            <label for="title"
                                                class="col-form-label col-md-3 col-sm-3  label-align">ประเด็นยุทธศาสตร์<span
                                                    class="required">*</span></label>
                                            <div class="col-md-8 col-sm-8">
                                                <input class="form-control" type="text" name="name" id="name"
                                                    data-validate-length-range="8,20"
                                                    @foreach ($SFAs as $SFA)
                                                    @if ($SFA->SFA3LVID == $item->SFA3LVID)
                                                         value="{{ $SFA->name }}" 
                                                    @endif @endforeach
                                                    readonly />
                                            </div>
                                        </div>
                                        <div class="row field item form-group align-items-center">
                                            <label for="title"
                                                class="col-form-label col-md-3 col-sm-3  label-align">เป้าประสงค์<span
                                                    class="required">*</span></label>
                                            <div class="col-md-8 col-sm-8">
                                                <input class="form-control" type="text" name="name" id="name"
                                                    data-validate-length-range="8,20"
                                                    @foreach ($goals as $goal)
                                                   @if ($goal->goal3LVID == $item->goal3LVID)
                                                        value="{{ $goal->name }}"
                                                       
                                                   @endif @endforeach
                                                    readonly />
                                            </div>
                                        </div>
                                        <div class="row field item form-group align-items-center">
                                            <label for="title"
                                                class="col-form-label col-md-3 col-sm-3  label-align">กลยุทธ์<span
                                                    class="required">*</span></label>
                                            <div class="col-md-8 col-sm-8">
                                                <input class="form-control" type="text" name="name" id="name"
                                                    data-validate-length-range="8,20"
                                                    @foreach ($tactics as $tactic)
                                                    @if ($tactic->tac3LVID == $item->tac3LVID)
                                                        value="{{ $tactic->name }}" 
                                                        
                                                    @endif @endforeach
                                                    readonly />
                                            </div>
                                        </div>
                                        <div class="row field item form-group align-items-center">
                                            <label for="title"
                                                class="col-form-label col-md-3 col-sm-3  label-align">ตัวชีวัดของแผน<span
                                                    class="required">*</span></label>
                                            <div class="col-md-4 col-sm-4">
                                                @foreach ($KPIMainMapProject as $KPIMap)
                                                    @if ($KPIMap->proID == $project->proID)
                                                        @if ($item->stra3LVID == $KPIMap->stra3LVID)
                                                            <input class="form-control" type="text" name="name"
                                                                id="name"
                                                                @foreach ($KPIMains as $KPI)
                                                            @if ($KPI->KPIMain3LVID == $KPIMap->KPIMain3LVID)
                                                                 value= "{{ $KPI->name }}"
                                                                
                                                            @endif @endforeach
                                                                readonly />
                                                        @endif
                                                    @endif
                                                @endforeach

                                            </div>
                                        </div>

                                    </div>
                                @endif
                            @endforeach --}}
                        @endif

                        @if (session()->has('stra2LVID'))
                            @foreach (session('stra2LVID') as $index => $item)
                                <div class="row field item form-group align-items-center">
                                    <label for="plan"
                                        class="col-form-label col-md-3 col-sm-3 label-align">ชื่อแผน<span
                                            class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
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
                                                    @foreach (session('SFA2LVID') as $SFA2LVID)
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
                                        <div class="row col-md-8 col-sm-8">
                                            @foreach ($KPIMain2LV as $KPI)
                                                @if (session()->has('KPIMain2LVID') && is_array(session('KPIMain2LVID')))
                                                    @foreach (session('KPIMain2LVID') as $KPIMain2LVID)
                                                        @if ($KPI->KPIMain2LVID == $KPIMain2LVID)
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
                            {{-- @else
                        @foreach ($strategic2LVMap as $item)
                        @if ($item->proID == $project->proID)
                            <div class="row field item form-group align-items-center">
                                <label for="plan"
                                    class="col-form-label col-md-3 col-sm-3 label-align">แผนยุทธศาสตร์<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" type="text" name="name" id="name"
                                        data-validate-length-range="8,20"
                                        @foreach ($strategic2LV as $stra)
                                            @if ($stra->stra2LVID == $item->stra2LVID)
                                                value="{{ $stra->name }}" 
                                            @endif @endforeach
                                        readonly />
                                </div>

                            </div>
                            <div class="col-md-3"></div>
                            <div class="col-md-9 border mb-2 p-2">
                                <div class="row field item form-group align-items-center">
                                    <label for="title"
                                        class="col-form-label col-md-3 col-sm-3  label-align">ประเด็นยุทธศาสตร์<span
                                            class="required">*</span></label>
                                    <div class="col-md-8 col-sm-8">
                                        <input class="form-control" type="text" name="name" id="name"
                                            data-validate-length-range="8,20"
                                            @foreach ($SFA2Lv as $SFA)
                                                @if ($SFA->SFA2LVID == $item->SFA2LVID)
                                                     value="{{ $SFA->name }}" 
                                                @endif @endforeach
                                            readonly />
                                    </div>
                                </div>
                                <div class="row field item form-group align-items-center">
                                    <label for="title"
                                        class="col-form-label col-md-3 col-sm-3  label-align">กลยุทธ์<span
                                            class="required">*</span></label>
                                    <div class="col-md-8 col-sm-8">
                                        <input class="form-control" type="text" name="name" id="name"
                                            data-validate-length-range="8,20"
                                            @foreach ($tactics2LV as $tactic)
                                                @if ($tactic->tac2LVID == $item->tac2LVID)
                                                    value="{{ $tactic->name }}" 
                                                    
                                                @endif @endforeach
                                            readonly />
                                    </div>
                                </div>
                                <div class="row field item form-group align-items-center">
                                    <label for="title"
                                        class="col-form-label col-md-3 col-sm-3  label-align">ตัวชีวัดของแผน<span
                                            class="required">*</span></label>
                                    <div class="col-md-4 col-sm-4">
                                        @foreach ($KPIMain2LVMap as $KPIMap)
                                            @if ($KPIMap->proID == $project->proID)
                                                @if ($item->stra2LVID == $KPIMap->stra2LVID)
                                                    <input class="form-control" type="text" name="name"
                                                        id="name"
                                                        @foreach ($KPIMain2LV as $KPI)
                                                        @if ($KPI->KPIMain2LVID == $KPIMap->KPIMain2LVID)
                                                             value= "{{ $KPI->name }}"
                                                            
                                                        @endif @endforeach
                                                        readonly />
                                                @endif
                                            @endif
                                        @endforeach

                                    </div>
                                </div>

                            </div>
                        @endif
                    @endforeach --}}
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
                        {{-- @foreach ($strategic1LVMap as $item)
                            @if ($item->proID == $project->proID)
                                <div class="row field item form-group align-items-center">
                                    <label for="plan"
                                        class="col-form-label col-md-3 col-sm-3 label-align">แผนยุทธศาสตร์<span
                                            class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input class="form-control" type="text" name="name" id="name"
                                            data-validate-length-range="8,20"
                                            @foreach ($strategic1LV as $stra)
                                                @if ($stra->stra1LVID == $item->stra1LVID)
                                                    value="{{ $stra->name }}" 
                                                @endif @endforeach
                                            readonly />
                                    </div>

                                </div>
                                <div class="col-md-3"></div>
                                <div class="col-md-9 border mb-2 p-2">
                                    <div class="row field item form-group align-items-center">
                                        <label for="title"
                                            class="col-form-label col-md-3 col-sm-3  label-align">เป้าหมาย<span
                                                class="required">*</span></label>
                                        <div class="col-md-8 col-sm-8">
                                            <input class="form-control" type="text" name="name" id="name"
                                                data-validate-length-range="8,20"
                                                @foreach ($target1LV as $tar)
                                                    @if ($tar->tar1LVID == $item->tar1LVID)
                                                         value="{{ $tar->name }}" 
                                                    @endif @endforeach
                                                readonly />
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach --}}
                        <div class="row field item form-group align-items-center">
                            <label for="title" class="col-form-label col-md-2 col-sm-2 label-align">ประเภทโครงการ<span
                                    class="required">*</span></label>
                            <div class="col-md-4 col-sm-4">
                                <select id="type" name="proTypeID" class="form-control" required>
                                    @foreach ($projectType as $item)
                                        <option value="{{ $item->proTypeID }}"
                                            @if ($project->proTypeID == $item->proTypeID) selected @endif>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="title" class="col-form-label col-md-2 col-sm-2 label-align">ลักษณะโครงการ<span
                                    class="required">*</span></label>
                            <div class="col-md-4 col-sm-4">
                                <select id="charecter" name="proChaID" class="form-control" required>
                                    @foreach ($projectCharec as $item)
                                        <option value="{{ $item->proChaID }}"
                                            @if ($project->proChaID == $item->proChaID) selected @endif>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row field item form-group align-items-center">
                            <label for="integrat" class="col-form-label col-md-3 col-sm-3 label-align">การบูรณาการ<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <select id="integrat" name="proInID" class="form-control" onchange=" toggleTextarea()"
                                    required>
                                    @foreach ($projectIntegrat as $item)
                                        <option value="{{ $item->proInID }}"
                                            @if ($project->proInID == $item->proInID) selected @endif>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                       
                        <div class="row field item form-group align-items-center" style="none;" id="otherTextContainer">
                            <label for="otherText" class="col-form-label col-md-3 col-sm-3 label-align"></label>
                            <div class="col-md-6 col-sm-6">
                                <textarea id="proInDetail" name="proInDetail" class="form-control" placeholder="เรื่อง">{{ $project->proInDetail }}</textarea>
                            </div>
                        </div>
                       

                        <div class="row field item form-group align-items-center">
                            <label for="title"
                                class="col-form-label col-md-3 col-sm-3  label-align">หลักการและเหตุผล<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 d-flex">
                                <textarea class="form-control" name="principle" id="principle" required='required'
                                    data-validate-length-range="8,20">{{ $project->princiDetail }}</textarea>
                                @error('principle')
                                    <div class="m-2">
                                        <span class="text text-danger">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                        </div>


                        <div class="row field item form-group align-items-center">
                            <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">วัตถุประสงค์<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control" type="text" name="obj[]" id="obj"
                                    required='required' data-validate-length-range="8,20"
                                    value="{{ $objProject->detail ?? '' }}" />
                                @error('obj.*')
                                    <div class="m-2">
                                        <span class="text text-danger">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-3 col-sm-3">
                                <button type='button' class="btn btn-primary" onclick="insertObj()">เพิ่ม</button>
                            </div>
                        </div>
                        @if (!empty($obj))


                            @foreach ($obj as $index => $item)
                                @if ($index > 0 && $item->proID == $project->proID && $item->objID != $objProject->objID)
                                    <div class="row field item form-group align-items-center">
                                        <div class="col-md-3 col-sm-3"></div>
                                        <div class="col-md-6 col-sm-6">
                                            <input class="form-control" type="text" name="obj[]"
                                                value="{{ $item->detail }}" required="required" />
                                            <input type="hidden" name="objID[]" value="{{ $item->objID }}">

                                        </div>
                                        <div class="col-md-3 col-sm-3">
                                            <button type="button" class="btn btn-danger "
                                                onclick="this.closest('.row').remove()">ลบ</button>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif


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
                                        <input type="hidden" name="KPIProID[]" value="{{ $KPIProject->KPIProID }}">
                                        <input class="form-control" type="text" name="KPIProject[]" id=""
                                            value="{{ $KPIProject->name ?? '' }}">
                                    </div>
                                    <div class="row col-md-3 col-sm-3 m-1">
                                        <select id="countKPIProject" name="countKPIProject[]" class="form-control"
                                            required>
                                            <option value="">--</option>
                                            @foreach ($CountKPIProjects as $count)
                                                @if ($count->countKPIProID == $KPIProject->countKPIProID)
                                                    <option value="{{ $count->countKPIProID }}" selected>
                                                        {{ $count->name }}</option>
                                                @else
                                                    <option value="{{ $count->countKPIProID }}"> {{ $count->name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="row col-md-3 col-sm-3 m-1">
                                        <input class="form-control" type="text" name="targetProject[]" id=""
                                            value="{{ $KPIProject->target ?? '' }}">
                                    </div>
                                    <div class="col-md-1 col-sm-1 m-1">
                                        <button type='button' class="btn btn-primary"
                                            onclick="insertKPIProject()">เพิ่ม</button>

                                    </div>
                                </div>
                                @if (!empty($KPIProjects))
                                    @foreach ($KPIProjects as $index => $item)
                                        @if ($index > 0 && $item->proID == $project->proID && $item->KPIProID != $KPIProject->KPIProID)
                                            {{-- <div class="row field item form-group align-items-center"> --}}
                                            <div class="row col-md-12 col-sm-12">
                                                <div class="row col-md-4 col-sm-4 m-1">
                                                    <input class="form-control" type="hidden" name="KPIProID[]"
                                                        id="" value="{{ $item->KPIProID }}">
                                                    <input class="form-control" type="text" name="KPIProject[]"
                                                        id="" value="{{ $item->name }}">
                                                </div>
                                                <div class="row col-md-3 col-sm-3 m-1">
                                                    <select id="countKPIProject" name="countKPIProject[]"
                                                        class="form-control" required>
                                                        <option value="">--</option>
                                                        @foreach ($CountKPIProjects as $count)
                                                            @if ($count->countKPIProID == $item->countKPIProID)
                                                                <option value="{{ $count->countKPIProID }}" selected>
                                                                    {{ $count->name }}</option>
                                                            @else
                                                                <option value="{{ $count->countKPIProID }}">
                                                                    {{ $count->name }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>

                                                </div>
                                                <div class="row col-md-3 col-sm-3 m-1">
                                                    <input class="form-control" type="text" name="targetProject[]"
                                                        id="" value="{{ $item->target }}">
                                                </div>
                                                <div class="col-md-1 col-sm-1 m-1">
                                                    <button type="button" class="btn btn-danger "
                                                        onclick="this.closest('.row').remove()">ลบ</button>
                                                </div>
                                            </div>
                                            {{-- </div> --}}
                                        @endif
                                    @endforeach
                                @endif
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
                                            value="{{ $step->name ?? '' }}">
                                        @error('stepName.*')
                                            <div class="m-2">
                                                <span class="text text-danger">{{ $message }}</span>
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="row col-md-3 col-sm-3 m-1">
                                        <input class="form-control" type="date" name="stepStart[]" id=""
                                            value="{{ $step->start ?? '' }}">
                                        @error('stepStart.*')
                                            <div class="m-2">
                                                <span class="text text-danger">{{ $message }}</span>
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="row col-md-3 col-sm-3 m-1">
                                        <input class="form-control" type="date" name="stepEnd[]" id=""
                                            value="{{ $step->end ?? '' }}">
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
                                    @if (!empty($step))
                                        @foreach ($steps as $index => $item)
                                            @if ($index > 0 && $item->proID == $project->proID && $item->stepID != $step->stepID)
                                                <div class="row col-md-12 col-sm-12">
                                                    <div class="row col-md-4 col-sm-4 m-1">
                                                        <input class="form-control" type="hidden" name="stepID[]"
                                                            id="" value="{{ $item->stepID }}">
                                                        <input class="form-control" type="text" name="stepName[]"
                                                            id="" value="{{ $item->name }}">
                                                    </div>
                                                    <div class="row col-md-3 col-sm-3 m-1">
                                                        <input class="form-control" type="date" name="stepStart[]"
                                                            id="" value="{{ $item->start }}">

                                                    </div>
                                                    <div class="row col-md-3 col-sm-3 m-1">
                                                        <input class="form-control" type="date" name="stepEnd[]"
                                                            id="" value="{{ $item->end }}">
                                                    </div>
                                                    <div class="col-md-1 col-sm-1 m-1">
                                                        <button type="button" class="btn btn-danger "
                                                            onclick="this.closest('.row').remove()">ลบ</button>
                                                    </div>
                                                </div>

                                </div>
                                @endif
                                @endforeach
                                @endif
                                <div id="insertStep"></div>
                            </div>

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
                            <div class="row col-md-3 col-sm-3 mr-1 d-flex justify-content-center align-items-center">
                                <label for="title" class="col-form-label label-align"></label>
                            </div>
                            <div class="row col-md-2 col-sm-2 mr-1 d-flex justify-content-center align-items-center">
                                <label class="col-form-label label-align ">ไตรมาส 1 (ต.ค-ธ.ค)</label>

                            </div>
                            <div class="row col-md-2 col-sm-2 mr-1 d-flex justify-content-center align-items-center">
                                <label for="title" class="col-form-label label-align">ไตรมาส 2
                                    (ม.ค-มี.ค)</label>
                            </div>
                            <div class="row col-md-2 col-sm-2 mr-1 d-flex justify-content-center align-items-center">
                                <label for="title" class="col-form-label label-align">ไตรมาส 3
                                    (เม.ย-มิ.ย)</label>
                            </div>
                            <div class="row col-md-2 col-sm-2 mr-1 d-flex justify-content-center align-items-center">
                                <label for="title" class="col-form-label label-align">ไตรมาส 4
                                    (ก.ค-ก.ย)</label>
                            </div>
                        </div>


                        <div class="col-md-12 col-sm-12 ">
                            <div class="row col-md-3 col-sm-3 mr-1 d-flex justify-content-center align-items-center">
                                <label for="title" class="col-form-label label-align">ประเภทรายจ่าย</label>
                            </div>
                            <div class="row col-md-2 col-sm-2 mr-1 d-flex justify-content-center align-items-center">
                                <label class="col-form-label label-align ">แผนการใช้จ่าย</label>

                            </div>
                            <div class="row col-md-2 col-sm-2 mr-1 d-flex justify-content-center align-items-center">
                                <label for="title" class="col-form-label label-align">แผนการใช้จ่าย</label>
                            </div>
                            <div class="row col-md-2 col-sm-2 mr-1 d-flex justify-content-center align-items-center">
                                <label for="title" class="col-form-label label-align">แผนการใช้จ่าย</label>
                            </div>
                            <div class="row col-md-2 col-sm-2 mr-1 d-flex justify-content-center align-items-center">
                                <label for="title" class="col-form-label label-align">แผนการใช้จ่าย</label>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 ">

                            <div class="row col-md-3 col-sm-3 mr-1">
                                <select id="expID" name="expID[]" class="form-control" required>

                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 mt-2">
                            <div class="row col-md-3 col-sm-3 mr-1">
                                <select id="costType" name="costID[]" class="form-control" required>

                                </select>
                            </div>
                            <div class="row col-md-2 col-sm-2 mr-1">
                                <input type="hidden" name="costQuID[]" value="{{ $costQuarter->costQuID }}">
                                <input class="form-control cost-input" type="text" name="costQu1[]" id=""
                                    value="{{ $costQuarter->costQu1 ?? '' }}">
                                @error('costQu1.*')
                                    <div class="m-2">
                                        <span class="text text-danger">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                            <div class="row col-md-2 col-sm-2 mr-1">
                                <input class="form-control cost-input" type="text" name="costQu2[]" id=""
                                    value="{{ $costQuarter->costQu2 ?? '' }}">
                                @error('costQu2.*')
                                    <div class="m-2">
                                        <span class="text text-danger">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                            <div class="row col-md-2 col-sm-2 mr-1">
                                <input class="form-control cost-input" type="text" name="costQu3[]" id=""
                                    value="{{ $costQuarter->costQu3 ?? '' }}">
                                @error('costQu3.*')
                                    <div class="m-2">
                                        <span class="text text-danger">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                            <div class="row col-md-2 col-sm-2 mr-1">
                                <input class="form-control cost-input" type="text" name="costQu4[]" id=""
                                    value="{{ $costQuarter->costQu4 ?? '' }}">
                                @error('costQu4.*')
                                    <div class="m-2">
                                        <span class="text text-danger">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-1 col-sm-1 ">
                                <button type='button' class="btn btn-primary" onclick="insertCostType()">เพิ่ม</button>
                            </div>
                        </div>
                        @if (!empty($costQuarters))
                            @foreach ($costQuarters as $index => $item)
                                @if ($index > 0 && $item->proID == $project->proID && $item->costQuID != $costQuarter->costQuID)
                                    <div class="exp-group">
                                        <div class="row col-md-12 col-sm-12">
                                            <div class="row col-md-3 col-sm-3 mr-1">
                                                <select id="expID_{{ $index }}" name="expID[]"
                                                    class="form-control" required>
                                                    @foreach ($expanses as $exp)
                                                        <option value="{{ $exp->expID }}"
                                                            @if ($exp->expID == $item->expID) selected @endif>
                                                            {{ $exp->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row col-md-12 col-sm-12 mt-2">
                                            <div class="row col-md-3 col-sm-3 mr-1">
                                                <select id="costType_{{ $index }}" name="costID[]"
                                                    class="form-control" required>
                                                    @foreach ($costTypes as $cost)
                                                        @if ($cost->expID == $item->expID)
                                                            <option value="{{ $cost->costID }}"
                                                                @if ($cost->costID == $item->costID) selected @endif>
                                                                {{ $cost->name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="row col-md-2 col-sm-2 mr-1">
                                                <input class="form-control" type="hidden" name="costQuID[]"
                                                    id="" value="{{ $item->costQuID }}">
                                                <input class="form-control cost-input" type="text" name="costQu1[]"
                                                    id="" value="{{ $item->costQu1 }}">
                                            </div>
                                            <div class="row col-md-2 col-sm-2 mr-1">
                                                <input class="form-control cost-input" type="text" name="costQu2[]"
                                                    id="" value="{{ $item->costQu2 }}">
                                            </div>
                                            <div class="row col-md-2 col-sm-2 mr-1">
                                                <input class="form-control cost-input" type="text" name="costQu3[]"
                                                    id="" value="{{ $item->costQu3 }}">
                                            </div>
                                            <div class="row col-md-2 col-sm-2 mr-1">
                                                <input class="form-control cost-input" type="text" name="costQu4[]"
                                                    id="" value="{{ $item->costQu4 }}">
                                            </div>
                                            <div class="col-md-1 col-sm-1 m-1">
                                                <button type="button" class="btn btn-danger "
                                                    onclick="this.closest('.exp-group').remove()">ลบ</button>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
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
                            required='required' data-validate-length-range="8,20"
                            value="{{ $project->badgetTotal ?? '' }}" readonly oninput="updateText()" />

                    </div>
                    <div class="col-md-5 col-sm-5">
                        <input class="form-control" type="text" name="badgetTotalText" id="badgetTotalText"
                            required='required' data-validate-length-range="8,20" disabled />

                    </div>

                </div>

                <div class="row field item form-group align-items-center">
                    <label for="title"
                        class="col-form-label col-md-3 col-sm-3  label-align">ประโยชน์ที่คาดว่าจะได้รับ<span
                            class="required">*</span></label>
                    <div class="col-md-6 col-sm-6">
                        <input class="form-control" type="text" name="benefit[]" id="benefit" required='required'
                            data-validate-length-range="8,20" value="{{ $benefit->detail ?? '' }}" />
                        @error('benefit.*')
                            <div class="m-2">
                                <span class="text text-danger">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-1 col-sm-1 ">
                        <button type='button' class="btn btn-primary" onclick="insertBenefit()">เพิ่ม</button>

                    </div>
                </div>
                @foreach ($benefits as $index => $item)
                    @if ($index > 0 && $item->proID == $project->proID && $item->bnfID != $benefit->bnfID)
                        <div class="row field item form-group align-items-center">
                            <div class="col-md-3 col-sm-3"></div>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control" type="hidden" name="bnfID[]" id="benefit"
                                    required='required' data-validate-length-range="8,20"
                                    value="{{ $item->bnfID }}" />
                                <input class="form-control" type="text" name="benefit[]" id="benefit"
                                    required='required' data-validate-length-range="8,20"
                                    value="{{ $item->detail }}" />

                            </div>
                            <div class="col-md-3 col-sm-3">
                                <button type="button" class="btn btn-danger "
                                    onclick="this.closest('.row').remove()">ลบ</button>
                            </div>
                        </div>
                    @endif
                @endforeach
                <div id="insertBenefit"></div>
                {{-- ยังไม่ต้องฟิก ถ้าเลือกครุภัณฑ์ต้องแนบไฟล์ --}}
                <div class="row field item form-group align-items-center">
                    <label for="title"
                        class="col-form-label col-md-3 col-sm-3  label-align">ไฟล์เอกสารประกอบโครงการ</label>
                    <div class="col-md-6 col-sm-6">


                        <input class="form-control" type="file" name="file[]" id="file" required='required'
                            data-validate-length-range="8,20" />
                        @error('file')
                            <div class="m-2">
                                <span class="text text-danger">{{ $message }}</span>
                            </div>
                        @enderror
                        @if (!empty($files))
                            @foreach ($files as $item)
                                <div class="row m-2">
                                    <div class="col-md-6 col-sm-6">
                                        <input type="hidden" name="oldfileID[]" value="{{ $item->fileID }}">
                                        <input type="hidden" name="oldfile[]" value="{{ $item->name }}">
                                        <a href="{{ asset('files/' . $item->name) }}"
                                            target="_blank">{{ $item->name }}</a>
                                    </div>
                                    <div class="col-md-3 col-sm-3">
                                        <button type="button" onclick="this.closest('.row').remove()">ลบ</button>
                                    </div>
                                </div>
                            @endforeach
                        @endif
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
                            <button type='submit' class="btn btn-primary"
                                onclick="submitButton('save2',{{ $project->proID }})">บันทึก</button>
                            <button type='button' class="btn btn-primary"
                                onclick="submitButton('send2',{{ $project->proID }})">ส่ง</button>
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
        $(document).ready(function() {
            $('[id^="expID_"]').change(function(event) {
                var expID = this.value;
                var dropdownID = $(this).attr('id');
                var idIndex = dropdownID.split("_")[1];
                // alert(idIndex);
                $('[id^="costType_"]')
                $.ajax({
                    url: "/projectcostType",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        expID: expID,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $('#costType_' + idIndex).html('');
                        $.each(response.costType, function(index, val) {
                            $('#costType_' + idIndex).append('<option value="' + val
                                .costID + '">' + val.name + '</option>');
                        });
                    }
                });
            });
            
        });


        const funds = @json($fund);
        const expenses = @json($expanses);
        const costTypes = @json($costTypes);
        const proIn = @json($projectIntegrat);



        const users = @json($user);
        const currentUserId = {{ Auth::user()->userID }};

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
                    option.textContent = user.firstname_th;
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


        let dropdownCount = 10;

        function insertCostType() {


            const dropdownCount = document.querySelectorAll('.Expense').length + 1;

            const mainExpenseContainer = document.createElement('div');
            mainExpenseContainer.classList.add('col-md-12', 'col-sm-12');

            const colExpense = document.createElement('div');
            colExpense.classList.add('col-md-3', 'col-sm-3', 'mr-1');
            // ใส่ข้อความหรือเนื้อหา

            const ExpenseDropdown = document.createElement('select');
            ExpenseDropdown.classList.add('form-control'); // เพิ่มคลาสเพื่อทำให้สามารถระบุได้ง่ายขึ้น
            ExpenseDropdown.id = `expID_${dropdownCount}`;
            ExpenseDropdown.name = 'expID[]';
            // ExpenseDropdown.innerHTML = '';
            console.log("Dropdown ID:", ExpenseDropdown.id);


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
            costTypeDropdown.id = `costType_${dropdownCount}`;
            costTypeDropdown.name = 'costID[]';
            costTypeDropdown.innerHTML = '';

            console.log("Dropdown ID:", costTypeDropdown.id);

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
            } else {
                otherTextContainer.style.display = "none";
                var textarea = document.getElementById('proInDetail');
                textarea.value = ''; 
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

            // const colMD1 = document.createElement('div');
            // colMD1.classList.add('col-md-1', 'col-sm-1');

            // const checkboxDiv = document.createElement('div');
            // checkboxDiv.classList.add('checkbox');

            // const checkboxLabel = document.createElement('label');
            // const checkboxInput = document.createElement('input');
            // checkboxInput.type = 'checkbox';
            // checkboxInput.name = 'TOR[]';
            // checkboxInput.value = 'TOR';

            // mainContainer.appendChild(colMD1);
            // colMD1.appendChild(checkboxDiv);
            // checkboxDiv.appendChild(checkboxLabel);
            // checkboxLabel.appendChild(checkboxInput);
            // checkboxLabel.appendChild(document.createTextNode(' TOR'));

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

        function submitButton(action, proID) {
            var form = document.getElementById('actionForm');
            if (action === 'save2') {
                form.action = "/projectSaveUpdate2/" + proID;
            } else if (action === 'send2') {
                form.action = "/projectSendUpdate2/" + proID;
            }
            form.submit();
        }

        // Event listeners สำหรับ dropdown ต่าง ๆ
        window.onload = function() {
            // const yearSelect = document.getElementById('year');
            // const StrategicSelect = document.getElementById('straID');
            // const SFASelect = document.getElementById('SFAID');
            // const goalSelect = document.getElementById('goalID');
            // const tacSelect = document.getElementById('tacID');
            const planSelect = document.getElementById('planID');
            const EXPSelect = document.getElementById('expID');



            // เมื่อเปลี่ยนปีงบประมาณ
            // yearSelect.addEventListener('change', function() {
            //     const selectedYearID = this.value;
            //     updatePlanDropdown(selectedYearID);
            // });

            // // เมื่อเปลี่ยนแผนยุทธศาสตร์
            // StrategicSelect.addEventListener('change', function() {
            //     const selectedStraID = this.value;
            //     updateIssueDropdown(selectedStraID);

            // });

            // SFASelect.addEventListener('change', function() {
            //     const selectedSFAID = this.value;
            //     updateGoalDropdown(selectedSFAID);
            // });

            // goalSelect.addEventListener('change', function() {
            //     const selectedGoalID = this.value;
            //     updateTacticsDropdown(selectedGoalID);
            //     updateKPIMain(selectedGoalID);
            // });
            // tacSelect.addEventListener('change',function(){
            //     const selectedTacID = this.value;
            //     updateKPIMain(selectedTacID);
            // });



            planSelect.addEventListener('change', function() {
                const selectedPlanID = this.value;
                console.log(selectedPlanID);
                updateExpenseDropdown(selectedPlanID);
            });
            EXPSelect.addEventListener('change', function() {
                const selectedEXPID = this.value;
                updateCostTypeDropdown(selectedEXPID);
            });

            // เรียกใช้ครั้งแรกเมื่อโหลดหน้า
            // const defaultYearID = yearSelect.value;
            // if (defaultYearID) {
            //     updatePlanDropdown(defaultYearID);
            // }

            const defaultPlanID = planSelect.value;
            if (defaultPlanID) {
                updateExpenseDropdown(defaultPlanID);
            }
        };
    </script>
@endsection
