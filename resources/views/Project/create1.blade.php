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
                            <label for="title" class="col-form-label col-md-3 col-sm-3 label-align">ปีงบประมาณ<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                {{-- <input type="text" value="{{session('selectYear')}}"> --}}
                                <select id="year" name="yearID" class="form-control" required oninput="submitForm(event)">
                                    <option value="">--เลือกปีงบประมาณ--</option>
                                    @foreach ($year as $item)
                                        <option value="{{ $item->yearID }}"
                                            {{ request('yearID') == $item->yearID ? 'selected' : '' }}
                                            >{{ $item->year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row field item form-group align-items-center">
                            <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">ชื่อโครงการ<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control" type="text" name="name" id="name" required='required'
                                    data-validate-length-range="8,20" oninput="submitForm(event)"
                                    value="{{ old('name', $name ?? '') }}" />
                                @error('name')
                                    <div class="m-2">
                                        <span class="text text-danger">{{ $message }}</span>
                                    </div>
                                @enderror
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
                                            value="{{ $item->name }}">
                                    </div>
                                </div>

                                <div class="col-md-9 border m-2 p-2">
                                    <div class="row field item form-group align-items-center">
                                        <label for="title"
                                            class="col-form-label col-md-3 col-sm-3  label-align">ประเด็นยุทธศาสตร์<span
                                                class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6">
                                            <input type="hidden" value="{{ $index }}">
                                            <select id="SFA3LVID_{{ $index }}" name="SFA3LVID[]" class="form-control"
                                                required 
                                                >
                                                <option value="">--เลือกประเด็นยุทธศาสตร์--</option>
                                                @foreach ($SFA3LVs as $SFA)
                                                    @if ($SFA->stra3LVID == $item->stra3LVID)
                                                        <option value="{{ $SFA->SFA3LVID }}"
                                                            {{-- {{ isset($selectSFA3Level) && in_array($SFA->SFA3LVID, (array) $selectSFA3Level) ? 'selected' : '' }} --}}
                                                            >{{ $SFA->name }}</option>
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

                                            <select id="goal3LVID_{{ $index }}" name="goal3LVID[]"
                                                class="form-control" required >
                                                <option value="">--เลือกเป้าประสงค์--</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row field item form-group align-items-center">
                                        <label for="title"
                                            class="col-form-label col-md-3 col-sm-3  label-align">กลยุทธ์<span
                                                class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6">
                                            <select id="tac3LVID_{{ $index }}" name="tac3LVID[]"
                                                class="form-control" required >
                                                <option value="">--เลือกกลยุทธ์--</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                </div>
                <div class="row field item form-group align-items-center">
                    <label for="title"
                        class="col-form-label col-md-2 col-sm-2 label-align">ตัวชี้วัดของ{{ $item->name }}</label>
                    <div class="row col-md-9 col-sm-9 border m-1">
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
                                <select id="KPIMain3LVID_{{ $index }}" name="KPIMain3LVID[]" class="form-control"
                                   required>
                                    <option value="">--เลือกตัวชี้วัด--</option>
                                   
                                </select>
                            </div>
                            <div class=" col-md-3 col-sm-3 m-1">
                                <input class="form-control" type="text" name="countMain3LV[]"
                                    id="count3LV_{{ $index }}" readonly >

                            </div>
                            <div class=" col-md-3 col-sm-3 m-1">
                                <input class="form-control" type="text" name="targetMain3LV[]"
                                    id="target3LV_{{ $index }}" readonly>
                            </div>
                            <div class="col-md-1 col-sm-1 m-1">
                                <button type='button' class="btn btn-primary insert-kpi-button"
                                    data-index="{{ $index }}">เพิ่ม
                                </button>

                            </div>
                        </div>
                        <div id="insertKPIMain_{{ $index }}"></div>
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
                    <div class="row field item form-group align-items-center">
                        <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">แผนยุทธศาสตร์<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 d-flex">
                            <input type="checkbox" name="stra2LVID[]"
                                {{ in_array($item->stra2LVID, old('stra2LVID', $selectStra2LV ?? [])) ? 'checked' : '' }}
                                value="{{ $item->stra2LVID }}">

                            <input class="ml-2 form-control" type="text" id="straID_{{ $index }}"
                                required='required' data-validate-length-range="8,20" value="{{ $item->name }}"
                                readonly>
                        </div>
                        <div class="col-md-9 border mb-2 p-2">
                            <div class="row field item form-group align-items-center">
                                <label for="title"
                                    class="col-form-label col-md-3 col-sm-3  label-align">ประเด็นยุทธศาสตร์<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <select id="SFA2LVID_{{ $index }}" name="SFA2LVID[]" class="form-control"
                                        required>
                                        <option value="">--เลือกประเด็นยุทธศาสตร์--</option>

                                        @foreach ($SFA2LV as $SFA)
                                            @if ($SFA->stra2LVID == $item->stra2LVID)
                                                <option value="{{ $SFA->SFA2LVID }}"
                                                    {{-- {{ isset($selectSFA2Level) && in_array($SFA->SFA2LVID, (array) $selectSFA2Level) ? 'selected' : '' }} --}}
                                                    >{{ $SFA->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row field item form-group align-items-center">
                                <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">กลยุทธ์<span
                                        class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <select id="tac2LVID_{{ $index }}" name="tac2LVID[]" class="form-control"
                                        required>
                                        <option value="">--เลือกกลยุทธ์--</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row field item form-group align-items-center" id="KPIMainNone" style="display: flex;">
                        <label for="title"
                            class="col-form-label col-md-2 col-sm-2 label-align">ตัวชี้วัดของแผนดิจิทัล</label>
                        <div class="row col-md-9 col-sm-9 border m-1">
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
                                    <select id="KPIMain2LVID_{{ $index }}" name="KPIMain2LVID[]" class="form-control"
                                        required>
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
                                    <button type='button' class="btn btn-primary" onclick="insertKPIMain()">เพิ่ม
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
                @php
                    $index = 0;
                @endphp
                @foreach ($strategic1Level as $item)
                    <div class="row field item form-group align-items-center">
                        <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">แผนยุทธศาสตร์<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 d-flex">
                            <input type="checkbox" name="stra1LVID[]"
                                {{ in_array($item->stra1LVID, old('stra1LVID', $selectStra1LV ?? [])) ? 'checked' : '' }}
                                value="{{ $item->stra1LVID }}">

                            <input class="ml-2 form-control" type="text" id="straID_{{ $index }}"
                                required='required' data-validate-length-range="8,20" value="{{ $item->name }}"
                                readonly>
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                    <div class="col-md-9 border mb-2 p-2">
                        <div class="row field item form-group align-items-center">
                            <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">เป้าหมาย<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <select id="tar1LVID_{{ $index }}" name="tar1LVID[]" class="form-control"
                                     required>
                                    <option value="">--เลือกเป้าหมาย--</option>
                                    @foreach ($target1LV as $target)
                                        @if ($target->stra1LVID == $item->stra1LVID)
                                            <option value="{{ $target->tar1LVID }}"
                                                {{-- {{ isset($selectTarget1LV) && in_array($target->tar1LVID, (array) $selectTarget1LV) ? 'selected' : '' }} --}}
                                                >{{ $target->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
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
                            <button type="submit" class="btn btn-primary" onclick="submitButton('send1')">ถัดไป</button>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('[id^="SFA3LVID_"]').change(function(event){
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
                    data: {SFA3LVID: SFA3LVID,_token:"{{csrf_token()}}"},
                    success:function(response){
                        // console.log(response);
                        // $('#goal3LVID_'+idIndex).html('');
                        $('#goal3LVID_'+idIndex).html('<option value="">--เลือกเป้าประสงค์--</option>');
                        $.each(response.goal3LV,function(index,val){
                            $('#goal3LVID_'+idIndex).append('<option value="'+val.goal3LVID+'"> '+val.name+' </option>');
                            // console.log(val.goal3LVID);
                        });
                        $('#tac3LVID_'+idIndex).html('<option value="">--เลือกกลยุทธ์--</option>');
                        $('#KPIMain3LVID_'+idIndex).html('<option value="">--เลือกตัวชี้วัด--</option>');
                        $('#count3LV_'+idIndex).val('');
                        $('#target3LV_'+idIndex).val('');
                    }
                })
            });
            $('[id^="goal3LVID_"]').change(function(event){
                var goal3LVID = this.value;
                var dropdownID = $(this).attr('id');
                var idIndex = dropdownID.split("_")[1];
                $('[id^="tac3LVID_"]');
               
                $.ajax({
                    url: "/projecttactics3LV",
                    type: 'POST',
                    dataType: 'json',
                    data: {goal3LVID: goal3LVID,_token:"{{csrf_token()}}"},
                    success:function(response){
                        $('#tac3LVID_'+idIndex).html('<option value="">--เลือกกลยุทธ์--</option>');
                        $.each(response.tactics3LV,function(index,val){
                            $('#tac3LVID_'+idIndex).append('<option value="'+val.tac3LVID+'"> '+val.name+' </option>')
                        });
                        
                    }
                });
            });
            $('[id^="goal3LVID_"]').change(function(event){
                var goal3LVID = this.value;
                var dropdownID = $(this).attr('id');
                var idIndex = dropdownID.split("_")[1];
                $('[id^="KPIMain3LVID_"]');
                $.ajax({
                    url: "/projectKPIMain3LV",
                    type: 'POST',
                    dataType: 'json',
                    data: {goal3LVID: goal3LVID,_token:"{{csrf_token()}}"},
                    success:function(response){
                        $('#KPIMain3LVID_'+idIndex).html('<option value="">--เลือกตัวชี้วัด--</option>');
                        $.each(response.KPIMain3LV,function(index,val){
                            $('#KPIMain3LVID_'+idIndex).append('<option value="'+val.KPIMain3LVID+'"> '+val.name+' </option>')
                        })
                        $('#count3LV_'+idIndex).val('');
                        $('#target3LV_'+idIndex).val('');
                    }
                });
            });
            $('[id^="KPIMain3LVID_"]').change(function(event){
                var KPIMain3LVID = this.value;
                var dropdownID = $(this).attr('id');
                var idIndex = dropdownID.split("_")[1];
                $('[id^="count3LV_"]');
                $('[id^="target3LV_"]');
                $.ajax({
                    url: '/projectcount_target3LV',
                    type: 'POST',
                    dataType: 'json',
                    data: {KPIMain3LVID: KPIMain3LVID,_token:"{{csrf_token()}}"},
                    success:function(response){
                        $.each(response.count_target,function(index,val){
                            
                            $('#count3LV_'+idIndex).val(val.count);
                            $('#target3LV_'+idIndex).val(val.target);
                        });
                    }
                })
            });
            $('[id^="SFA2LVID_"]').change(function(event){
                var SFA2LVID = this.value;
                var dropdownID = $(this).attr('id');
                var idIndex = dropdownID.split("_")[1];
                $('[id^="tac2LVID_"]');
               
                $.ajax({
                    url: "/projecttactics2LV",
                    type: 'POST',
                    dataType: 'json',
                    data: {SFA2LVID: SFA2LVID,_token:"{{csrf_token()}}"},
                    success:function(response){
                        $('#tac2LVID_'+idIndex).html('<option value="">--เลือกกลยุทธ์--</option>');
                        $.each(response.tactics2LV,function(index,val){
                            $('#tac2LVID_'+idIndex).append('<option value="'+val.tac2LVID+'"> '+val.name+' </option>')
                        });
                        
                    }
                });
            });
            $('[id^="SFA2LVID_"]').change(function(event){
                var SFA2LVID = this.value;
                var dropdownID = $(this).attr('id');
                var idIndex = dropdownID.split("_")[1];
                $('[id^="KPIMain2LVID_"]');
               
                $.ajax({
                    url: "/projectKPIMain2LV",
                    type: 'POST',
                    dataType: 'json',
                    data: {SFA2LVID: SFA2LVID,_token:"{{csrf_token()}}"},
                    success:function(response){
                        $('#KPIMain2LVID_'+idIndex).html('<option value="">--เลือกตัวชี้วัด--</option>');
                        $.each(response.KPIMain2LV,function(index,val){
                            $('#KPIMain2LVID_'+idIndex).append('<option value="'+val.KPIMain2LVID+'"> '+val.name+' </option>')
                        })
                        $('#count2LV_'+idIndex).val('');
                        $('#target2LV_'+idIndex).val('');
                        
                    }
                });
            });
            $('[id^="KPIMain2LVID_"]').change(function(event){
                var KPIMain2LVID = this.value;
                var dropdownID = $(this).attr('id');
                var idIndex = dropdownID.split("_")[1];
                $('[id^="count2LV_"]');
                $('[id^="target2LV_"]');
                $.ajax({
                    url: '/projectcount_target2LV',
                    type: 'POST',
                    dataType: 'json',
                    data: {KPIMain2LVID: KPIMain2LVID,_token:"{{csrf_token()}}"},
                    success:function(response){
                        $.each(response.count_target2LV,function(index,val){
                            
                            $('#count2LV_'+idIndex).val(val.count ?? '-');
                            $('#target2LV_'+idIndex).val(val.target ?? '-');
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
       

        function submitButton(action) {
            var form = document.getElementById('actionForm');
            if (action === 'save1') {
                form.action = "/projectSave1";
            } else if (action === 'send1') {
                form.action = "/projectSend1";
            }
            form.submit();
        }
        document.addEventListener('DOMContentLoaded', function() {
            document.body.addEventListener('click', function(event) {
                if (event.target.classList.contains('insert-kpi-button')) {
                    const index = event.target.getAttribute('data-index');
                    insertKPIMain(index);
                }
            });
        });


        function insertKPIMain(index) {
            const mainContainer = document.createElement('div');
            mainContainer.classList.add('col-md-12', 'col-sm-12');

            const colKPI = document.createElement('div');
            colKPI.classList.add('col-md-4', 'col-sm-4', 'm-1');

            const KPIDropdown = document.createElement('select');
            KPIDropdown.classList.add('form-control');
            KPIDropdown.id = `KPIMainID_${Date.now()}`;
            KPIDropdown.name = 'KPIMain3LVID[]';
            KPIDropdown.innerHTML = '';

            const colCount = document.createElement('div');
            colCount.classList.add('col-md-3', 'col-sm-3', 'm-1');

            const countInput = document.createElement('input');
            countInput.classList.add('form-control');
            countInput.type = 'text';
            countInput.id = `countMain_${Date.now()}`;
            countInput.name = 'countMain3LV[]';

            const colTarget = document.createElement('div');
            colTarget.classList.add('col-md-3', 'col-sm-3', 'm-1');

            const targetInput = document.createElement('input');
            targetInput.classList.add('form-control');
            targetInput.type = 'text';
            targetInput.id = `targetMain_${Date.now()}`;
            targetInput.name = 'targetMain3LV[]';

            // const selectedGoalID = document.getElementById('goal3LVID').value;
            // const filteredKPIMains = KPIMains.filter(KPIMain => KPIMain.goal3LVID == selectedGoalID);
            // if (filteredKPIMains.length === 0) {
            //     const noKPIMainOption = document.createElement('option');
            //     noKPIMainOption.value = '';
            //     noKPIMainOption.textContent = 'ไม่มีตัวชี้วัดของแผน';
            //     KPIDropdown.appendChild(noKPIMainOption);
            //     KPIDropdown.disabled = true;
            //     countInput.value = 'ไม่มีหน่วยนับ';
            //     targetInput.value = 'ไม่มีค่าเป้าหมาย';
            // } else {
            //     // เปิดใช้งาน dropdown และเพิ่ม KPI ในตัวเลือก
            //     KPIDropdown.disabled = false;
            //     filteredKPIMains.forEach(KPIMain => {
            //         const option = document.createElement('option');
            //         option.value = KPIMain.KPIMainID;
            //         option.textContent = KPIMain.name;
            //         KPIDropdown.appendChild(option);
            //     });

            //     // กำหนดค่าเริ่มต้นให้กับ input
            //     const firstKPIMain = filteredKPIMains[0];
            //     countInput.value = firstKPIMain.count || 'ไม่มีหน่วยนับ';
            //     targetInput.value = firstKPIMain.target || 'ไม่มีค่าเป้าหมาย';
            // }
            // KPIDropdown.addEventListener('change', function() {
            //     const selectedKPIMainID = this.value;
            //     const selectedKPIMain = KPIMains.find(KPIMain => KPIMain.KPIMainID == selectedKPIMainID);
            //     if (selectedKPIMain) {
            //         countInput.value = selectedKPIMain.count || 'ไม่มีหน่วยนับ';
            //         targetInput.value = selectedKPIMain.target || 'ไม่มีค่าเป้าหมาย';
            //     }
            // });

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
            const targetContainer = document.getElementById(`insertKPIMain_${index}`);
            if (targetContainer) {
                targetContainer.appendChild(mainContainer);
            } else {
                console.error(`ไม่พบ <div id="insertKPIMain_${index}"> ใน DOM`);
            }
        }
    </script>
@endsection
