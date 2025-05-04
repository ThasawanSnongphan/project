@extends('layout')
@section('title', 'ตัวชี้วัดของแผน')
@section('content')
    <div class="row">
        <div class="col-md-2 col-sm-2"></div>
        <div class="col-md-8 col-sm-8">
            <div class="x_panel">
                <div class="x_title">
                    <h2>แก้ไขตัวชี้วัดของแผน</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        {{-- <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                aria-expanded="false"><i class="fa fa-wrench"></i></a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#">Settings 1</a>
                                <a class="dropdown-item" href="#">Settings 2</a>
                            </div>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li> --}}
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form method="POST" action="{{ route('KPIMain.update', $KPIMain->KPIMain3LVID) }}"  enctype="multipart/form-data">
                        @csrf
                        <div class="field item form-group">
                            <label for="title" class="col-form-label col-md-3 col-sm-3 label-align">ปีงบประมาณ<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <select id="year" name="year" class="form-control" required>
                                    @foreach ($year as $item)
                                        <option value="{{ $item->yearID }}"
                                            {{ $item->yearID == $KPIMain->goal->SFA->strategic->year->yearID ? 'selected' : '' }}>
                                            {{ $item->year }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="field item form-group">
                            <label for="plan" class="col-form-label col-md-3 col-sm-3 label-align">แผนยุทธศาสตร์<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <select id="straID" name="straID" class="form-control" required>
                                    <!-- แผนจะถูกโหลดที่นี่ -->
                                </select>
                            </div>
                        </div>

                        <div class="field item form-group">
                            <label for="title"
                                class="col-form-label col-md-3 col-sm-3  label-align">ประเด็นยุทธศาสตร์<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <select id="SFAID" name="SFAID" class="form-control" required>
                                    <!-- กลยุทธ์จะถูกโหลดที่นี่ -->
                                </select>
                            </div>
                        </div>

                        <div class="field item form-group">
                            <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">เป้าประสงค์<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <select id="goalID" name="goalID" class="form-control" required>
                                    <!-- กลยุทธ์จะถูกโหลดที่นี่ -->
                                </select>
                            </div>
                        </div>


                        <script>
                            const strategic = @json($strategic); // ข้อมูลแผนยุทธศาสตร์
                            const issues = @json($SFA); // ข้อมูลประเด็นยุทธศาสตร์
                            const goals = @json($goal); // ข้อมูลเป้าประสงค์

                            // ฟังก์ชันอัปเดต dropdown ของแผน
                            function updatePlanDropdown(selectedYearID) {
                                const planSelect = document.getElementById('straID');
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
                                        option.value = plan.stra3LVID;
                                        option.textContent = plan.name;
                                        if (plan.stra3LVID == '{{ $KPIMain->goal->SFA->stra3LVID }}') {
                                            option.selected = true;
                                            updateIssueDropdown(plan.stra3LVID);
                                        }
                                        planSelect.appendChild(option);
                                    });
                                    if (!filteredPlans.some(plan => plan.stra3LVID == '{{ $KPIMain->goal->SFA->stra3LVID }}')) {
                                        updateIssueDropdown(filteredPlans[0].stra3LVID);
                                    }
                                }
                            }

                            // ฟังก์ชันอัปเดต dropdown ของประเด็นยุทธศาสตร์
                            function updateIssueDropdown(selectedPlanID) {
                                const issueSelect = document.getElementById('SFAID');
                                issueSelect.innerHTML = '';

                                if (!selectedPlanID) {
                                    const noIssueOption = document.createElement('option');
                                    noIssueOption.value = '';
                                    noIssueOption.textContent = 'ไม่มีประเด็นยุทธศาสาตร์';
                                    issueSelect.appendChild(noIssueOption);
                                    issueSelect.disabled = true;
                                    updateGoalDropdown(null);
                                    return;
                                }

                                const filteredIssues = issues.filter(issue => issue.stra3LVID == selectedPlanID);

                                if (filteredIssues.length === 0) {
                                    const noIssueOption = document.createElement('option');
                                    noIssueOption.value = '';
                                    noIssueOption.textContent = 'ไม่มีประเด็นยุทธศาสตร์';
                                    issueSelect.appendChild(noIssueOption);
                                    issueSelect.disabled = true;
                                    updateGoalDropdown(null);
                                } else {
                                    issueSelect.disabled = false;
                                    filteredIssues.forEach(issue => {
                                        const option = document.createElement('option');
                                        option.value = issue.SFA3LVID;
                                        option.textContent = issue.name;
                                        if (issue.SFA3LVID == '{{ $KPIMain->goal->SFA3LVID }}') {
                                            option.selected = true;
                                            updateGoalDropdown(issue.SFA3LVID);
                                        }
                                        issueSelect.appendChild(option);
                                    });
                                    if (!filteredIssues.some(issue => issue.SFA3LVID == '{{ $KPIMain->goal->SFA3LVID }}')) {
                                        updateGoalDropdown(filteredIssues[0].SFA3LVID);
                                    }

                                }
                            }

                            // ฟังก์ชันอัปเดต dropdown ของกลยุทธ์ผ่านการเชื่อมต่อจากประเด็นยุทธศาสตร์และเป้าประสงค์
                            function updateGoalDropdown(selectedSFAID) {
                                const goalSelect = document.getElementById('goalID');
                                goalSelect.innerHTML = '';

                                if (!selectedSFAID) {
                                    const noGoalOption = document.createElement('option');
                                    noGoalOption.value = '';
                                    noGoalOption.textContent = 'ไม่มีเป้าประสงค์';
                                    goalSelect.appendChild(noGoalOption);
                                    goalSelect.disabled = true;
                                    updateTacticsDropdown(null);
                                    return;
                                }

                                // กรองประเด็นยุทธศาสตร์ที่เชื่อมกับแผนที่เลือก
                                const filteredGoals = goals.filter(goal => goal.SFA3LVID == selectedSFAID);

                                if (filteredGoals.length === 0) {
                                    const noGoalOption = document.createElement('option');
                                    noGoalOption.value = '';
                                    noGoalOption.textContent = 'ไม่มีเป้าประสงค์';
                                    goalSelect.appendChild(noGoalOption);
                                    goalSelect.disabled = true;
                                    updateTacticsDropdown(null);
                                } else {
                                    goalSelect.disabled = false;
                                    filteredGoals.forEach(goal => {
                                        const option = document.createElement('option');
                                        option.value = goal.goal3LVID;
                                        option.textContent = goal.name;
                                        if (goal.goal3LVID == '{{ $KPIMain->goal3LVID }}') {
                                            option.selected = true;
                                        }
                                        goalSelect.appendChild(option);
                                    });


                                }
                            }

                            // Event listeners สำหรับ dropdown ต่าง ๆ
                            window.onload = function() {
                                const yearSelect = document.getElementById('year');
                                const planSelect = document.getElementById('straID');
                                const SFASelect = document.getElementById('SFAID');


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

                                SFASelect.addEventListener('change', function() {
                                    const selectedSFAID = this.value;
                                    updateGoalDropdown(selectedSFAID);
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
                                <input class="form-control" type="text" name="name" id="name" required value="{{$KPIMain->name}}">
                                
                            </div>

                        </div>
                        <div class="field item form-group">
                            <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">หน่วยนับ<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control" type="text" name="count" id="count" required value="{{$KPIMain->count}}" >
                                
                            </div>

                        </div>
                        <div class="field item form-group">
                            <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">ค่าเป้าหมาย<span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control" type="text" name="target" id="target"
                                    required value="{{$KPIMain->target}}"/>
                               
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
                                            {{ $item->displayname }}</option>
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
                                            {{ $item->displayname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>



                        <div class="ln_solid">
                            <div class="form-group text-center p-2">
                                <div class="col-md-6 offset-md-3">
                                    <button type='submit' class="btn btn-warning" value="บันทึก">Edit</button>
                                    <a href="/KPIMain" style="color: white"><button type='button' class="btn btn-danger">Back</button></a>
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
