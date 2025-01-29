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
                    <form method="POST" id="actionForm" action="/projectcreate1"novalidate enctype="multipart/form-data">
                        @csrf
                        <div class="row field item form-group align-items-center">
                            <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">ชื่อโครงการ<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control" type="text" name="name" id="name" required='required'
                                    data-validate-length-range="8,20" oninput="this.form.submit()"
                                    value="{{ old('name', $name ?? '') }}" />
                                @error('name')
                                    <div class="m-2">
                                        <span class="text text-danger">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row field item form-group align-items-center">
                            <label for="title" class="col-form-label col-md-3 col-sm-3 label-align">ปีงบประมาณ<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <select id="year" name="yearID" class="form-control" onchange="this.form.submit()"
                                    required>
                                    <option value="">--เลือกปีงบประมาณ--</option>
                                    @foreach ($year as $item)
                                        <option value="{{ $item->yearID }}"
                                            {{ isset($selectYear) && $selectYear == $item->yearID ? 'selected' : '' }}>
                                            {{ $item->year }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        @php
                            $index = 0;
                        @endphp
                        @if (!empty($selectYear))
                            @foreach ($strategic3Level as $item)
                                <div class="row field item form-group align-items-center">
                                    <label for="title"
                                        class="col-form-label col-md-3 col-sm-3  label-align">แผนยุทธศาสตร์<span
                                            class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 d-flex">
                                        <input type="checkbox" name="stra3LVID[]"
                                            {{ in_array($item->stra3LVID, old('stra3LVID', $selectStra3LV ?? [])) ? 'checked' : '' }}
                                            value="{{ $item->stra3LVID }}">
                                       
                                        <input type="hidden" value="{{ $index }}">
                                        <input class="ml-2 form-control" type="text" id="straID_{{ $index }}"
                                            required='required' data-validate-length-range="8,20" readonly
                                            value="{{ $item->name }}"  >
                                    </div>


                                    <div class="col-md-9 border m-2 p-2">
                                        <div class="row field item form-group align-items-center">
                                            <label for="title"
                                                class="col-form-label col-md-3 col-sm-3  label-align">ประเด็นยุทธศาสตร์<span
                                                    class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <input type="hidden" value="{{ $index }}">
                                                <select id="SFAID_{{ $index }}" name="SFA3LVID[]"
                                                    class="form-control" onchange="this.form.submit()" required>
                                                    <option value="">--เลือกประเด็นยุทธศาสตร์--</option>
                                                    @foreach ($SFA3LVs as $SFA)
                                                        @if ($SFA->stra3LVID == $item->stra3LVID)
                                                            <option value="{{ $SFA->SFA3LVID }}"
                                                                {{ isset($selectSFA3Level) && in_array($SFA->SFA3LVID, (array) $selectSFA3Level) ? 'selected' : '' }}>
                                                                {{ $SFA->name }}</option>
                                                        @endif
                                                    @endforeach

                                                </select>

                                            </div>
                                        </div>
                                        <div class="row field item form-group align-items-center">
                                            <label for="title"
                                                class="col-form-label col-md-3 col-sm-3  label-align">เป้าประสงค์<span
                                                    class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">

                                                <select id="goalID_{{ $index }}" name="goal3LVID[]"
                                                    class="form-control" required onchange="this.form.submit()">

                                                    <option value="">--เลือกเป้าประสงค์--</option>


                                                    @foreach ($goal3Level as $goal)
                                                        @if (!empty($selectSFA3Level[$index]) && $goal->SFA3LVID == $selectSFA3Level[$index])
                                                            <option value="{{ $goal->goal3LVID }}"
                                                                {{ isset($selectGoal3Level) && in_array($goal->goal3LVID, (array) $selectGoal3Level) ? 'selected' : '' }}>
                                                                {{ $goal->name }}</option>
                                                        @endif
                                                    @endforeach




                                                </select>
                                            </div>
                                        </div>
                                        <div class="row field item form-group align-items-center">
                                            <label for="title"
                                                class="col-form-label col-md-3 col-sm-3  label-align">กลยุทธ์<span
                                                    class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <select id="tacID_{{ $index }}" name="tac3LVID[]"
                                                    class="form-control" required onchange="this.form.submit()">
                                                    <option value="">--เลือกกลยุทธ์--</option>
                                                    @if (!empty($selectGoal3Level[$index]) && !empty($selectSFA3Level[$index]))
                                                        @foreach ($tactics3LV as $tactics)
                                                            @if ($tactics->goal3LVID == $selectGoal3Level[$index])
                                                                <option value="{{ $tactics->tac3LVID }}"
                                                                    {{ isset($selectTactics3LV) && in_array($tactics->tac3LVID, (array) $selectTactics3LV) ? 'selected' : '' }}>
                                                                    {{ $tactics->name }}</option>
                                                            @endif
                                                        @endforeach
                                                    @endif

                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="row field item form-group align-items-center" id="KPIMainNone"
                                    style="display: flex;">
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
                                                <label for="title"
                                                    class="col-form-label label-align">ค่าเป้าหมาย</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12">
                                            <div class="col-md-4 col-sm-4 m-1">
                                                <select id="KPIMain_{{ $index }}" name="KPIMain3LVID[]"
                                                    class="form-control" onchange="this.form.submit()" required>
                                                    <option value="">--เลือกตัวชี้วัด--</option>
                                                    @if (!empty($selectGoal3Level[$index]) && !empty($selectSFA3Level[$index]))
                                                        @foreach ($KPIMain3LV as $KPI)
                                                            @if ($KPI->goal3LVID == $selectGoal3Level[$index])
                                                                <option value="{{ $KPI->KPIMain3LVID }}"
                                                                    {{ isset($selectKPIMain) && in_array($KPI->KPIMain3LVID, (array) $selectKPIMain) ? 'selected' : '' }}>
                                                                    {{ $KPI->name }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class=" col-md-3 col-sm-3 m-1">
                                                <input class="form-control" type="text" name="countMain3LV[]"
                                                    id="countMain_{{ $index }}" disabled
                                                    @foreach ($KPIMain3LV as $KPI)
                                                    @if (!empty($selectKPIMain[$index]) && $selectKPIMain[$index] == $KPI->KPIMain3LVID)
                                                        value= {{ $KPI->count ?? 'null' }}
                                                    @endif @endforeach>

                                            </div>
                                            <div class=" col-md-3 col-sm-3 m-1">
                                                <input class="form-control" type="text" name="targetMain3LV[]"
                                                    id="targetMain_{{ $index }}" disabled
                                                    @foreach ($KPIMain3LV as $KPI)
                                                    @if (!empty($selectKPIMain[$index]) && $selectKPIMain[$index] == $KPI->KPIMain3LVID)
                                                       value= {{ $KPI->target }}  
                                                    @endif @endforeach>
                                            </div>
                                            <div class="col-md-1 col-sm-1 m-1">
                                                <button type='button' class="btn btn-primary"
                                                    onclick="insertKPIMain()">เพิ่ม
                                                </button>

                                            </div>
                                        </div>
                                        <div id="insertKPIMain"></div>
                                    </div>
                                </div>
                                @php
                                    $index += 1;
                                @endphp
                            @endforeach
                        
                        
                        @foreach ($strategic2Level as $item)
                            <div class="row field item form-group align-items-center">
                                <label for="title"
                                    class="col-form-label col-md-3 col-sm-3  label-align">แผนยุทธศาสตร์<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 d-flex">
                                    <input type="checkbox" name="straID[]" value="{{ $item->stra2LVID }}">

                                    <input class="ml-2 form-control" type="text" id="straID_{{ $index }}"
                                        required='required' data-validate-length-range="8,20"
                                        value="{{ $item->name }}" readonly>
                                </div>
                                <div class="col-md-9 border mb-2 p-2">
                                    <div class="row field item form-group align-items-center">
                                        <label for="title"
                                            class="col-form-label col-md-3 col-sm-3  label-align">ประเด็นยุทธศาสตร์<span
                                                class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6">
                                            @if (!empty($selectSFA3Level[$index]))
                                                <input type="text" value="{{ $selectSFA3Level[$index] }}">
                                            @endif
                                            <select id="SFAID_{{ $index }}" name="SFAID[]" class="form-control"
                                                onchange="this.form.submit()" required>
                                                <option value="">--เลือกประเด็นยุทธศาสตร์--</option>

                                                @foreach ($SFA2LV as $SFA)
                                                    @if ($SFA->stra2LVID == $item->stra2LVID)
                                                        <option value="{{ $SFA->SFA2LVID }}"
                                                            {{ isset($selectSFA3Level) && in_array($SFA->SFA2LVID, (array) $selectSFA3Level) ? 'selected' : '' }}>
                                                            {{ $SFA->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row field item form-group align-items-center">
                                        <label for="title"
                                            class="col-form-label col-md-3 col-sm-3  label-align">กลยุทธ์<span
                                                class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6">
                                            <select id="tacID_{{ $index }}" name="tacID[]" class="form-control"
                                                required onchange="this.form.submit()">
                                                <option value="">--เลือกกลยุทธ์--</option>

                                                @foreach ($tactics2LV as $tactics)
                                                    @if (!empty($selectSFA3Level[$index]) && $tactics->SFA2LVID == $selectSFA3Level[$index])
                                                        <option value="{{ $tactics->tac2LVID }}"
                                                            {{ isset($selectTactics3LV) && in_array($tactics->tacID, (array) $selectTactics3LV) ? 'selected' : '' }}>
                                                            {{ $tactics->name }}</option>
                                                    @endif
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row field item form-group align-items-center" id="KPIMainNone"
                                style="display: flex;">
                                <label for="title"
                                    class="col-form-label col-md-2 col-sm-2 label-align">ตัวชี้วัดของแผนดิจิทัล</label>
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
                                        <div class="col-md-4 col-sm-4 m-1">
                                            <select id="KPIMain_{{ $index }}" name="KPIMainID[]"
                                                class="form-control" required>
                                                <option value="">--เลือกตัวชี้วัด--</option>
                                                @if (!empty($selectSFA3Level[$index]))
                                                    @foreach ($KPIMain2LV as $KPI)
                                                        @if ($KPI->SFA2LVID == $selectSFA3Level[$index])
                                                            <option value="{{ $KPI->KPIMain2LVID }}">{{ $KPI->name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class=" col-md-3 col-sm-3 m-1">
                                            <input class="form-control" type="text" name="countMain[]"
                                                id="countMain_{{ $index }}" disabled
                                                @foreach ($KPIMain2LV as $KPI)
                                                    @if (!empty($selectKPIMain[$index]) && $selectKPIMain[$index] == $KPI->KPIMain2LVID)
                                                        value= {{ $KPI->count }}
                                                    @endif @endforeach>

                                        </div>
                                        <div class=" col-md-3 col-sm-3 m-1">
                                            <input class="form-control" type="text" name="targetMain[]"
                                                id="targetMain_{{ $index }}" disabled
                                                @foreach ($KPIMain2LV as $KPI)
                                                    @if (!empty($selectKPIMain[$index]) && $selectKPIMain[$index] == $KPI->KPIMain2LVID)
                                                        value= {{ $KPI->target }}
                                                    @endif @endforeach>
                                        </div>
                                        <div class="col-md-1 col-sm-1 m-1">
                                            <button type='button' class="btn btn-primary"
                                                onclick="insertKPIMain()">เพิ่ม
                                            </button>

                                        </div>
                                    </div>
                                    <div id="insertKPIMain"></div>
                                </div>
                            </div>
                            @php
                                $index += 1;
                            @endphp
                        @endforeach
                        @foreach ($strategic1Level as $item)
                            <div class="row field item form-group align-items-center">
                                <label for="title"
                                    class="col-form-label col-md-3 col-sm-3  label-align">แผนยุทธศาสตร์<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 d-flex">
                                    <input type="checkbox" name="straID[]" value="{{ $item->stra1LVID }}">

                                    <input class="ml-2 form-control" type="text" id="straID_{{ $index }}"
                                        required='required' data-validate-length-range="8,20"
                                        value="{{ $item->name }}" readonly>


                                </div>
                                <div class="col-md-9 border mb-2 p-2">
                                    <div class="row field item form-group align-items-center">
                                        <label for="title"
                                            class="col-form-label col-md-3 col-sm-3  label-align">เป้าหมาย<span
                                                class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6">
                                            <select id="SFAID_{{ $index }}" name="SFAID[]" class="form-control"
                                                onchange="this.form.submit()" required>
                                                <option value="">--เลือกเป้าหมาย--</option>
                                                @foreach ($target1LV as $target)
                                                    @if ($target->stra1LVID == $item->stra1LVID)
                                                        <option value="{{ $target->tar1LVID }}"
                                                            {{ isset($selectSFA3Level) && in_array($target->tar1LVID, (array) $selectSFA3Level) ? 'selected' : '' }}>
                                                            {{ $target->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            @php
                                $index += 1;
                            @endphp
                        @endforeach
                       



                   
                        <div class="ln_solid">
                            <div class="form-group ">
                                <div class="col-md-6 offset-md-3 ">
                                    <button type='submit' class="btn btn-primary"
                                        onclick="submitButton('save1')">บันทึก</button>
                                    <button type="submit" class="btn btn-primary"
                                        onclick="submitButton('send1')">ถัดไป</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-1 col-sm-1"></div>
    </div>


<script>
    function submitButton(action) {
        var form = document.getElementById('actionForm');
        if (action === 'save1') {
            form.action = "/projectSave1";
        } else if (action === 'send1') {
            form.action = "/projectcreate2";
        }
        form.submit();
    }
</script>
@endsection
