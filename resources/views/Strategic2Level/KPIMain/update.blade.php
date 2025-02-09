@extends('layout')
@section('title', 'Tactics')
@section('content')
    <div class="row">
        <div class="col-md-2 col-sm-2"></div>
        <div class="col-md-8 col-sm-8">
            <div class="x_panel">
                <div class="x_title">
                    <h2>เพิ่มตัวชี้วัดของแผน</h2>
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
                    <form method="POST" action="{{ route('KPIMain2LV.update', $KPIMain->KPIMain2LVID) }}" novalidate enctype="multipart/form-data">
                        @csrf
                        <div class="field item form-group">
                            <label for="title" class="col-form-label col-md-3 col-sm-3 label-align">ปีงบประมาณ<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <select id="year" name="year" class="form-control" required>
                                    @foreach ($year as $item)
                                        <option value="{{ $item->yearID }}"
                                            {{ $item->yearID == $KPIMain->SFA->strategic->year->yearID ? 'selected' : '' }}>
                                            {{ $item->year }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="field item form-group">
                            <label for="plan" class="col-form-label col-md-3 col-sm-3 label-align">แผนยุทธศาสตร์<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <select id="stra2LVID" name="stra2LVID" class="form-control" required>
                                    <!-- แผนจะถูกโหลดที่นี่ -->
                                </select>
                            </div>
                        </div>

                        <div class="field item form-group">
                            <label for="title"
                                class="col-form-label col-md-3 col-sm-3  label-align">ประเด็นยุทธศาสตร์<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <select id="SFA2LVID" name="SFA2LVID" class="form-control" required>
                                    <!-- กลยุทธ์จะถูกโหลดที่นี่ -->
                                </select>
                            </div>
                        </div>


                        <script>
                            const strategic = @json($strategic); // ข้อมูลแผนยุทธศาสตร์
                            const issues = @json($SFA); // ข้อมูลประเด็นยุทธศาสตร์

                            // ฟังก์ชันอัปเดต dropdown ของแผน
                            function updatePlanDropdown(selectedYearID) {
                                const planSelect = document.getElementById('stra2LVID');
                                planSelect.innerHTML = '';

                                const filteredPlans = strategic.filter(plan => plan.yearID == selectedYearID);

                                if (filteredPlans.length === 0) {
                                    const noPlanOption = document.createElement('option');
                                    noPlanOption.value = '';
                                    noPlanOption.textContent = 'ไม่มีแผนยุทธศาสตร์';
                                    planSelect.appendChild(noPlanOption);
                                    planSelect.disabled = true;
                                    updateIssueDropdown(null);
                                } else {
                                    planSelect.disabled = false;
                                    filteredPlans.forEach(plan => {
                                        const option = document.createElement('option');
                                        option.value = plan.stra2LVID;
                                        option.textContent = plan.name;
                                        if (plan.stra2LVID == '{{ $KPIMain->SFA->stra2LVID }}') {
                                            option.selected = true;
                                            updateIssueDropdown(plan.stra2LVID);
                                        }
                                        planSelect.appendChild(option);
                                    });
                                    if (!filteredPlans.some(plan => plan.stra2LVID == '{{ $KPIMain->SFA->stra2LVID }}')) {
                                        updateIssueDropdown(filteredPlans[0].stra2LVID);
                                    }
                                }
                            }

                            // ฟังก์ชันอัปเดต dropdown ของประเด็นยุทธศาสตร์
                            function updateIssueDropdown(selectedPlanID) {
                                const issueSelect = document.getElementById('SFA2LVID');
                                issueSelect.innerHTML = '';

                                if (!selectedPlanID) {
                                    const noIssueOption = document.createElement('option');
                                    noIssueOption.value = '';
                                    noIssueOption.textContent = 'ไม่มีประเด็นยุทธศาสาตร์';
                                    issueSelect.appendChild(noIssueOption);
                                    issueSelect.disabled = true;
                                    return;
                                }

                                const filteredIssues = issues.filter(issue => issue.stra2LVID == selectedPlanID);

                                if (filteredIssues.length === 0) {
                                    const noIssueOption = document.createElement('option');
                                    noIssueOption.value = '';
                                    noIssueOption.textContent = 'ไม่มีประเด็นยุทธศาสตร์';
                                    issueSelect.appendChild(noIssueOption);
                                    issueSelect.disabled = true;
                                } else {
                                    issueSelect.disabled = false;
                                    filteredIssues.forEach(issue => {
                                        const option = document.createElement('option');
                                        option.value = issue.SFA2LVID;
                                        option.textContent = issue.name;
                                        if (issue.SFA2LVID == '{{ $KPIMain->SFA2LVID }}') {
                                            option.selected = true;
                                        }
                                        issueSelect.appendChild(option);
                                    });

                                }
                            }

                           

                            // Event listeners สำหรับ dropdown ต่าง ๆ
                            window.onload = function() {
                                const yearSelect = document.getElementById('year');
                                const planSelect = document.getElementById('stra2LVID');


                                // เมื่อเปลี่ยนปีงบประมาณ
                                yearSelect.addEventListener('change', function() {
                                    const selectedYearID = this.value;
                                    updatePlanDropdown(selectedYearID);
                                });

                                // เมื่อเปลี่ยนแผนยุทธศาสตร์
                                planSelect.addEventListener('change', function() {
                                    const selectedPlanID = this.value;
                                    updateIssueDropdown(selectedPlanID);

                                });


                                // เรียกใช้ครั้งแรกเมื่อโหลดหน้า
                                const defaultYearID = yearSelect.value;
                                if (defaultYearID) {
                                    updatePlanDropdown(defaultYearID);
                                }
                            };
                        </script>


                        <div class="field item form-group">
                            <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">KPI<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control" type="text" name="name" id="name" required='required'
                                    data-validate-length-range="8,20"  value="{{$KPIMain->name}}"/>
                                @error('KPI')
                                    <div class="m-2">
                                        <span class="text text-danger">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                        </div>
                        <div class="field item form-group">
                            <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">หน่วยนับ<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control" type="text" name="count" id="count" required='required'
                                    data-validate-length-range="8,20" value="{{$KPIMain->count}}" />
                                @error('count')
                                    <div class="m-2">
                                        <span class="text text-danger">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                        </div>
                        <div class="field item form-group">
                            <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">ค่าเป้าหมาย<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control" type="text" name="target" id="target"
                                    required='required' data-validate-length-range="8,20" value="{{$KPIMain->target}}"/>
                                @error('target')
                                    <div class="m-2">
                                        <span class="text text-danger">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                        </div>

                        <div class="field item form-group">
                            <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">ผู้กำกับ<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <select id="director" name="director" class="form-control" required>
                                    <option value="">---เลือกผู้กำกับ---</option>
                                    @foreach ($user as $item)
                                        <option value="{{ $item->userID }}"
                                            {{ $item->userID == $KPIMain->directorID ? 'selected' : '' }}>
                                            {{ $item->firstname_en }} {{$item->lastname_en }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
    
                        <div class="field item form-group">
                            <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">ผู้บันทึกข้อมูล<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <select id="recorder" name="recorder" class="form-control" required>
                                    <option value="">---เลือกผู้บันทึกข้อมูล---</option>
                                    @foreach ($user as $item)
                                        <option value="{{ $item->userID }}"
                                            {{ $item->userID == $KPIMain->recorderID ? 'selected' : '' }}>
                                            {{ $item->firstname_en }} {{$item->lastname_en }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>



                        <div class="ln_solid">
                            <div class="form-group ">
                                <div class="col-md-6 offset-md-3">
                                    <button type='submit' class="btn btn-primary" value="บันทึก">Submit</button>
                                    <button type='reset' class="btn btn-success">Reset</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-sm-2"></div>
    </div>

@endsection
