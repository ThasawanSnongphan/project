@extends('layout')
@section('title', 'Tactics')
@section('content')
    <div class="container body">
        <div class="main_container">
            <div role="main">
                <div class="">
                    <div class="page-title">
                        <div class="title_left">
                            <h3>แก้ไขกลยุทธ์</h3>
                        </div>

                        <div class="title_right">
                            <div class="col-md-5 col-sm-5 form-group pull-right top_search">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search for...">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button">Go!</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="row">
                        <div class="col-md-3 col-sm-3"></div>
                        <div class="col-md-6 col-sm-6">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>กลยุทธ์ </h2>
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
                                    <form method="POST" action="{{ route('tactics.update', $tactics->tacID) }}"novalidate
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="field item form-group">
                                            <label for="title"
                                                class="col-form-label col-md-3 col-sm-3 label-align">ปีงบประมาณ<span
                                                    class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <select id="year" name="year" class="form-control" required>
                                                    @foreach ($year as $item)
                                                        <option value="{{ $item->yearID }}" 
                                                            {{ $item->yearID == $tactics->goal->SFA->strategic->year->yearID ? 'selected' : '' }}> 
                                                            {{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="field item form-group">
                                            <label for="plan"
                                                class="col-form-label col-md-3 col-sm-3 label-align">แผนยุทธศาสตร์<span
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
                                                    <!-- ประเด็นยุทธศาสตร์จะถูกโหลดที่นี่ -->
                                                </select>
                                            </div>
                                        </div>
                                        <div class="field item form-group">
                                            <label for="title"
                                                class="col-form-label col-md-3 col-sm-3  label-align">เป้าประสงค์<span
                                                    class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <select id="goalID" name="goalID" class="form-control" required>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="field item form-group">
                                            <label for="title"
                                                class="col-form-label col-md-3 col-sm-3  label-align">name<span
                                                    class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <input class="form-control" type="text" name="name" id="name"
                                                    required='required' data-validate-length-range="8,20"
                                                    value="{{ $tactics->name }}" />
                                                @error('name')
                                                    <div class="m-2">
                                                        <span class="text text-danger">{{ $message }}</span>
                                                    </div>
                                                @enderror
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
                                                        option.value = plan.straID;
                                                        option.textContent = plan.name;
                                                        // console.log(plan.straID , {{ $tactics->goal->SFA->straID }});
                                                        if (plan.straID == '{{ $tactics->goal->SFA->straID }}') {
                                                            option.selected = true;
                                                            updateIssueDropdown(plan.straID);
                                                        }
                                                        planSelect.appendChild(option);
                                                    });
                                                    if(!filteredPlans.some(plan => plan.straID == '{{ $tactics->goal->SFA->straID }}')) {
                                                        updateIssueDropdown(filteredPlans[0].straID);
                                                    }
                                                }
                                            }

                                            // ฟังก์ชันอัปเดต dropdown ของประเด็นยุทธศาสตร์
                                            function updateIssueDropdown(selectedPlanID) {
                                                console.log(selectedPlanID);
                                                const issueSelect = document.getElementById('SFAID');
                                                issueSelect.innerHTML = '';

                                                if (!selectedPlanID) {
                                                    const noIssueOption = document.createElement('option');
                                                    noIssueOption.value = '';
                                                    noIssueOption.textContent = 'ไม่มีประเด็นยุทธศาสตร์';
                                                    issueSelect.appendChild(noIssueOption);
                                                    issueSelect.disabled = true;
                                                    updateGoalDropdown(null);
                                                    return;
                                                }

                                                const filteredIssues = issues.filter(issue => issue.straID == selectedPlanID);

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
                                                        option.value = issue.SFAID;
                                                        option.textContent = issue.name;
                                                        // console.log(issue.SFAID , '$tactics->goal->SFAID' );
                                                        
                                                        if (issue.SFAID == '{{ $tactics->goal->SFAID }}') {
                                                            option.selected = true;
                                                            updateGoalDropdown(issue.SFAID);
                                                        } 
               
                                                        issueSelect.appendChild(option);
                                                    });
                                                    if(!filteredIssues.some(issue => issue.SFAID == '{{$tactics->goal->SFAID}}')){
                                                        updateGoalDropdown(filteredIssues[0].SFAID);
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
                                                    return;
                                                }

                                                // กรองประเด็นยุทธศาสตร์ที่เชื่อมกับแผนที่เลือก
                                                const filteredGoals = goals.filter(goal => goal.SFAID == selectedSFAID);

                                                if (filteredGoals.length === 0) {
                                                    const noGoalOption = document.createElement('option');
                                                    noGoalOption.value = '';
                                                    noGoalOption.textContent = 'ไม่มีเป้าประสงค์';
                                                    goalSelect.appendChild(noGoalOption);
                                                    goalSelect.disabled = true;
                                                } else {
                                                    goalSelect.disabled = false;
                                                    filteredGoals.forEach(goal => {
                                                        const option = document.createElement('option');
                                                        option.value = goal.goalID;
                                                        option.textContent = goal.name;
                                                        if(goal.goalID == '{{$tactics->goalID}}'){
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
                                                const issueSelect = document.getElementById('SFAID');


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

                                                issueSelect.addEventListener('change', function() {
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



                                        <div class="ln_solid">
                                            <div class="form-group ">
                                                <div class="col-md-6 offset-md-3">
                                                    <button type='submit' class="btn btn-primary"
                                                        value="บันทึก">Submit</button>
                                                    <button type='reset' class="btn btn-success">Reset</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
