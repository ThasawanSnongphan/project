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

                    </ul>
                    <div class="clearfix"></div>
                </div>
                @php
                     $currentYear = date('Y') + 543;
                @endphp
                <div class="x_content">
                    <form id="actionForm" method="POST" action="" enctype="multipart/form-data">
                        @csrf
                        <div class="row field item form-group align-items-center">
                            <label for="title" class="col-form-label col-md-3 col-sm-3 label-align">ปีงบประมาณ<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                
                                <select id="year" name="yearID" class="form-control" required
                                    onchange="submitForm(event)">
                                    <option value="">--เลือกปีงบประมาณ--</option>
                                    @foreach ($year as $item)
                                        @if ($item->year >= $currentYear)
                                            <option value="{{ $item->yearID }}"
                                            {{ request('yearID') == $item->yearID ? 'selected' : '' }}>{{ $item->year }}
                                        </option>
                                        @endif
                                        
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row field item form-group align-items-center">
                            <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">ชื่อโครงการ<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                @if (session()->has('name'))
                                    <input class="form-control" type="text" name="project_name" id="project_name"
                                        value="{{ session('name') }}" required />
                                @else
                                    <input class="form-control" type="text" name="project_name" id="project_name"
                                        required />
                                @endif
                            </div>
                        </div>

                        <div class="row field item form-group align-items-center">
                            <label for="title"
                                class="col-form-label col-md-3 col-sm-3 label-align">ผู้กำกับดูแลโครงการ<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <select id="Approver" name="ApproverID" class="form-control" required>
                                    <option value="">--กรุณาเลือก--</option>
                                    @foreach ($user as $item)
                                        <option value="{{ $item->userID }}"
                                            {{ request('yearID') == $item->userID ? 'selected' : '' }}>
                                            {{ $item->displayname }}
                                        </option>
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
                                    <label for="plan"
                                        class="col-form-label col-md-3 col-sm-3 label-align">แผนยุทธศาสตร์<span
                                            class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 d-flex">
                                        @if (session()->has('stra3LVID'))
                                            <input type="checkbox" name="stra3LVID[]" value="{{ $item->stra3LVID }}"
                                                checked>
                                        @else
                                            <input type="checkbox" name="stra3LVID[]" value="{{ $item->stra3LVID }}">
                                        @endif


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
                                            <select id="SFA3LVID_{{ $index }}" name="SFA3LVID[]"
                                                class="form-control">
                                                <option value="">--เลือกประเด็นยุทธศาสตร์--</option>
                                                @if (session()->has('SFA3LVID'))
                                                    @foreach ($SFA3LVs as $SFA)
                                                        @if ($SFA->stra3LVID == $item->stra3LVID)
                                                            <option value="{{ $SFA->SFA3LVID }}"
                                                                @if ($SFA->SFA3LVID == session('SFA3LVID')[$index]) selected @endif>
                                                                {{ $SFA->name }}</option>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    @foreach ($SFA3LVs as $SFA)
                                                        @if ($SFA->stra3LVID == $item->stra3LVID)
                                                            <option value="{{ $SFA->SFA3LVID }}">
                                                                {{ $SFA->name }}</option>
                                                        @endif
                                                    @endforeach
                                                @endif


                                            </select>
                                        </div>
                                    </div>
                                    <div class="row field item form-group align-items-center">
                                        <label for="title"
                                            class="col-form-label col-md-3 col-sm-3  label-align">เป้าประสงค์<span
                                                class="required">*</span></label>
                                        <div class="col-md-8 col-sm-8">
                                            <select id="goal3LVID_{{ $index }}" name="goal3LVID[]"
                                                class="form-control">

                                                @if (session()->has('goal3LVID'))
                                                    @foreach ($goal3Level as $goal)
                                                        @if ($goal->SFA3LVID == session('SFA3LVID')[$index])
                                                            <option value="{{ $goal->goal3LVID }}"
                                                                @if ($goal->goal3LVID == session('goal3LVID')[$index]) selected @endif>
                                                                {{ $goal->name }}</option>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    <option value="">--เลือกเป้าประสงค์--</option>
                                                @endif


                                            </select>
                                        </div>
                                    </div>
                                    <div class="row field item form-group align-items-center">
                                        <label for="title"
                                            class="col-form-label col-md-3 col-sm-3  label-align">กลยุทธ์<span
                                                class="required">*</span></label>
                                        <div class="col-md-8 col-sm-8">
                                            <select id="tac3LVID_{{ $index }}" name="tac3LVID[]"
                                                class="form-control">
                                                @if (session()->has('tac3LVID'))
                                                    @foreach ($tactics3LV as $tac)
                                                        @if ($tac->goal3LVID == session('goal3LVID')[$index])
                                                            <option value="{{ $tac->tac3LVID }}"
                                                                @if ($tac->tac3LVID == session('tac3LVID')[$index]) selected @endif>
                                                                {{ $tac->name }}</option>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    <option value="">--เลือกกลยุทธ์--</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row field item form-group align-items-center">
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
                                                <select id="KPIMain3LVID_{{ $index }}" name="KPIMain3LVID[]"
                                                    class="form-control">
                                                    @if (session()->has('KPIMain3LVID'))
                                                        @foreach ($KPIMain3LV as $KPI)
                                                            @if ($KPI->goal3LVID == session('goal3LVID')[$index])
                                                                <option value="{{ $KPI->KPIMain3LVID }}"
                                                                    @if ($KPI->KPIMain3LVID == session('KPIMain3LVID')[$index]) selected @endif>
                                                                    {{ $KPI->name }}</option>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <option value="">--เลือกตัวชี้วัด--</option>
                                                    @endif
                                                </select>
                                            </div>
                                            <div class=" col-md-3 col-sm-3 m-1">
                                                <input class="form-control" type="text" name="countMain3LV[]"
                                                    id="count3LV_{{ $index }}"
                                                    @if (session()->has('KPIMain3LVID')) 
                                                        @foreach ($KPIMain3LV as $KPI)
                                                            @if ($KPI->goal3LVID == session('goal3LVID')[$index])
                                                                @if ($KPI->KPIMain3LVID == session('KPIMain3LVID')[$index]) value="{{ $KPI->count }}" @endif
                                                            @endif
                                                        @endforeach
                                                    @endif readonly>
                                            </div>
                                            <div class=" col-md-3 col-sm-3 m-1">
                                                <input class="form-control" type="text" name="targetMain3LV[]"
                                                    id="target3LV_{{ $index }}"
                                                    @if (session()->has('KPIMain3LVID')) @foreach ($KPIMain3LV as $KPI)
                                                                                    @if ($KPI->goal3LVID == session('goal3LVID')[$index])
                                                                                        @if ($KPI->KPIMain3LVID == session('KPIMain3LVID')[$index]) value="{{ $KPI->target }}" @endif
                                                    @endif
                                                @endforeach
                                                @endif readonly>
                                            </div>
                                            <div class="col-md-1 col-sm-1 m-1">
                                                <button type='button' class="btn btn-primary insert-kpi3LV-button"
                                                    data-index="{{ $index }}">เพิ่ม
                                                </button>
                            
                                            </div>
                                        </div>
                                        <div id="insertKPIMain1_{{ $index }}"></div>
                                    </div>
                                </div>
                                @php $index += 1; @endphp
                            @endforeach

                            @php $index = 0; @endphp
                            @foreach ($strategic2Level as $item)
                                <div class="row field item form-group align-items-center">
                                    <label for="plan" class="col-form-label col-md-3 col-sm-3 label-align">แผนยุทธศาสตร์<span
                                            class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 d-flex">
                                        @if (session()->has('stra2LVID'))
                                            <input type="checkbox" name="stra2LVID[]" value="{{ $item->stra2LVID }}" checked>
                                        @else
                                            <input type="checkbox" name="stra2LVID[]" value="{{ $item->stra2LVID }}">
                        
                                        @endif
                        
                                        <input class="ml-2 form-control" type="text" name="name" id="name"
                                            data-validate-length-range="8,20" value="{{ $item->name }}" readonly />
                                    </div>
                        
                                </div>
                                <div class="col-md-3"></div>
                                <div class="col-md-9 border mb-2 p-2">
                                    <div class="row field item form-group align-items-center">
                                        <label label for="title" class="col-form-label col-md-3 col-sm-3  label-align">ประเด็นยุทธศาสตร์<span
                                                class="required">*</span></label>
                                        <div class="col-md-8 col-sm-8">
                                            <select id="SFA2LVID_{{ $index }}" name="SFA2LVID[]" class="form-control">
                                                <option value="">--เลือกประเด็นยุทธศาสตร์--</option>
                                                @foreach ($SFA2LV as $SFA)
                                                    @if ($SFA->stra2LVID == $item->stra2LVID)
                                                        <option value="{{ $SFA->SFA2LVID }}">
                                                            {{ $SFA->name }}</option>
                                                    @endif
                                                @endforeach
                        
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row field item form-group align-items-center">
                                        <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">กลยุทธ์<span
                                                class="required">*</span></label>
                                        <div class="col-md-8 col-sm-8">
                                            <select id="tac2LVID_{{ $index }}" name="tac2LVID[]" class="form-control">
                                                <option value="">--เลือกกลยุทธ์--</option>
                        
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12">
                                        <div class="row col-md-4 col-sm-4 m-1 d-flex justify-content-center align-items-center">
                                            <label for="title" class="col-form-label label-align">ตัวชี้วัดความสำเร็จ</label>
                                        </div>
                                        <div class="row col-md-3 col-sm-3 m-1 d-flex justify-content-center align-items-center">
                                            <label class="col-form-label label-align ">หน่วยนับ</label>
                    
                                        </div>
                                        <div class="row col-md-3 col-sm-3 m-1 d-flex justify-content-center align-items-center">
                                            <label for="title" class="col-form-label label-align">ค่าเป้าหมาย</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12">
                                        <div class="col-md-4 col-sm-4 m-1">
                                            <select id="KPIMain2LVID_{{ $index }}" name="KPIMain2LVID[]" class="form-control">
                                                <option value="">--เลือกตัวชี้วัด--</option>
                    
                    
                                            </select>
                                        </div>
                                        <div class=" col-md-3 col-sm-3 m-1">
                    
                                            <input class="form-control" type="text" name="countMain2LV[]"
                                                id="count2LV_{{ $index }}" readonly>
                    
                                        </div>
                                        <div class=" col-md-3 col-sm-3 m-1">
                                            <input class="form-control" type="text" name="targetMain2LV[]"
                                                id="target2LV_{{ $index }}" readonly>
                                        </div>
                                        <div class="col-md-1 col-sm-1 m-1">
                                            <button type='button' class="btn btn-primary insert-kpi2LV-button"
                                                data-index="{{ $index }}">เพิ่ม
                                            </button>
                    
                                        </div>
                                    </div>
                                    <div id="insertKPIMain2_{{ $index }}"></div>
                                </div>
                                @php $index += 1; @endphp
                            @endforeach

                            @php $index = 0; @endphp
                            @foreach ($strategic1Level as $item)
                            <div class="row field item form-group align-items-center">
                                <label for="plan" class="col-form-label col-md-3 col-sm-3 label-align">แผนยุทธศาสตร์<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 d-flex">
                                    <input type="checkbox" class="strategic-checkbox" name="stra1LVID[]" value="{{ $item->stra1LVID }}"
                                        {{ session()->has('stra1LVID') ? 'checked' : '' }}>
                                    {{-- @if (session()->has('stra1LVID'))
                                        <input type="checkbox" name="stra1LVID[]" value="{{ $item->stra1LVID }}" checked>
                                    @else
                                        <input type="checkbox" name="stra1LVID[]" value="{{ $item->stra1LVID }}">
                    
                                    @endif --}}
                                    <input class="ml-2 form-control" type="text" name="name" id="name"
                                        data-validate-length-range="8,20" value="{{ $item->name }}" readonly />
                                </div>
                            </div>
                            <div class="col-md-3"></div>
                            <div class="col-md-9 border mb-2 p-2">
                                <div class="row field item form-group align-items-center">
                                    <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">เป้าหมาย<span
                                            class="required">*</span></label>
                                    <div class="col-md-8 col-sm-8">
                                        <select id="tar1LVID_{{ $index }}" name="tar1LVID[]" class="form-control">
                                            <option value="">--เลือกเป้าหมาย--</option>
                                            @foreach ($target1LV as $target)
                                                @if ($target->stra1LVID == $item->stra1LVID)
                                                    <option value="{{ $target->tar1LVID }}">
                                                        {{ $target->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @php $index += 1; @endphp
                            @endforeach

                            @if (count($strategic3Level) > 0 || count($strategic2Level) > 0 || count($strategic1Level) > 0)
                                <div class="ln_solid">
                                    <div class="form-group text-center p-2">
                                        <div class="col-md-6 offset-md-3">
                                            {{-- <button type='submit' class="btn btn-primary"
                                                onclick="submitButton('saveStrategic')">บันทึก</button> --}}
                                            <button type="submit" class="btn btn-primary" onclick="submitButton('next')">ถัดไป</button>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <p style="text-align: center">ไม่มีแผนยุทธศาสตร์ในปีนี้</p>
                            @endif
                        @endif
                    </form>
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
                // $('[id^="KPIMain3LVID_' + idIndex + '"]').prop('disabled', false); // เปิดใช้งาน dropdown

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
            mainContainer.classList.add('col-md-12', 'col-sm-12');

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
            // targetInput.id = `targetMain_${Date.now()}`;
            targetInput.id = `target3LV_${index}_${Date.now()}`;
            targetInput.name = 'targetMain3LV[]';
            targetInput.readOnly = true;

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
            mainContainer.classList.add('col-md-12', 'col-sm-12');

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



        function submitButton(action) {
            var form = document.getElementById('actionForm');
            if (action === 'saveStrategic') {
                form.action = "/projectSave1";
            } else if (action === 'next') {
                form.action = "/projectSend1";
            }
            // form.submit();
            if (form.checkValidity()) {
                form.submit(); // ส่งฟอร์มถ้าถูกต้อง
            } else {
                form.reportValidity(); // แจ้งให้เบราว์เซอร์แสดง validation error
            }
        }
    </script>
@endsection
