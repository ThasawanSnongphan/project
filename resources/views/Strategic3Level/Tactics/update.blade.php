@extends('layout')
@section('title', 'Tactics')
@section('content')
    <div class="container body">
        <div class="main_container">
            <div role="main">
                <div class="">
                    

                    <div class="row">
                        <div class="col-md-1 col-sm-1"></div>
                        <div class="col-md-10 col-sm-10">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>กลยุทธ์ </h2>
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
                                    <form method="POST" action="{{ route('tactics.update', $tactics->tac3LVID) }}"
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
                                                            {{ $item->year }}</option>
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
                                                    required
                                                    value="{{ $tactics->name }}" >
                                               
                                            </div>
                                        </div>

                                        <div class="field item form-group">
                                            <label for="title"
                                                class="col-form-label col-md-3 col-sm-3  label-align">ตัวชี้วัด<span
                                                    class="required">*</span></label>
                                            @if (!empty($KPIMainMap->KPiMain3LVID))
                                                <input type="hidden" value="{{ $KPIMainMap->KPIMain3LVID }}">
                                            @endif
                                            <div class="col-md-6 col-sm-6">
                                                <select id="KPIMainID_{{ $KPIMainMap->KPIMain3LVID }}" name="KPIMain[]" class="form-control" required>

                                                </select>
                                            </div>
                                            <div class="col-md-1 col-sm-1 ">
                                                <button type='button' class="btn btn-primary" id="addKPIButton"
                                                    onclick="insertKPIMain()">เพิ่ม</button>
                                            </div>
                                        </div>

                                        @foreach ($KPIMainMaps as $item)
                                            @if (!empty($item->KPIMain3LVID) && $item->tac3LVID === $tactics->tac3LVID && $item->KPIMain3LVID != $KPIMainMap->KPIMain3LVID)
                                                <div class="i field item form-group ">
                                                    <div class="col-md-3 col-sm-3"></div>
                                                    <input type="hidden" value="{{ $item->KPIMain3LVID }}">
                                                    <div class="col-md-6 col-sm-6">
                                                        <select id="KPIMainID_{{ $item->KPIMain3LVID }}" name="KPIMain[]"
                                                            class="form-control" required>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 col-sm-3">
                                                        <button type="button" class="btn btn-danger "
                                                            onclick="this.closest('.i').remove()">ลบ</button>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach

                                        <div id="insertKPIMain"></div>

                                        <script>
                                            const strategic = @json($strategic); // ข้อมูลแผนยุทธศาสตร์
                                            const issues = @json($SFA); // ข้อมูลประเด็นยุทธศาสตร์
                                            const goals = @json($goal); // ข้อมูลเป้าประสงค์
                                            const KPIMains = @json($KPIMain);
                                            const tacticMap = @json($tactics->KPIMain);
                                            let index = 2;

                                            function insertKPIMain() {
                                                const mainContainer = document.createElement('div');
                                                mainContainer.classList.add('field', 'item', 'form-group');

                                                const KPIMainLabel = document.createElement('label');
                                                KPIMainLabel.setAttribute('for', 'KPIIMainInput'); // ตั้งค่า for ให้ตรงกับ input หรือ select ที่จะใช้
                                                KPIMainLabel.classList.add('col-form-label', 'col-md-3', 'col-sm-3', 'label-align');
                                                KPIMainLabel.textContent = ''; // ตั้งข้อความใน label

                                                mainContainer.appendChild(KPIMainLabel);

                                                const colKPIMain = document.createElement('div');
                                                colKPIMain.classList.add('col-md-6', 'col-sm-6');

                                                const KPIMainDropdown = document.createElement('select');
                                                KPIMainDropdown.classList.add('form-control');
                                                KPIMainDropdown.id = `KPIMainID_${index+=1}`;
                                                KPIMainDropdown.name = 'KPIMain[]';

                                                // updateKPIMainDropdown(selectedgoalID, KPIMainDropdown);
                                                // KPIMainDropdown.innerHTML = '';

                                                const selectedgoalID = document.getElementById('goalID').value;
                                                KPIMainDropdown.innerHTML = '';

                                                if (!selectedgoalID) {
                                                    const noKPIMainOption = document.createElement('option');
                                                    noKPIMainOption.value = '';
                                                    noKPIMainOption.textContent = 'ไม่มีตัวชี้วัด';
                                                    KPIMainDropdown.appendChild(noKPIMainOption);
                                                    KPIMainDropdown.disabled = true;
                                                    return;
                                                }

                                                const filteredKPIMain = KPIMains.filter(KPIMain => KPIMain.goal3LVID == selectedgoalID);

                                                if (filteredKPIMain.length === 0) {
                                                    const noKPIMainOption = document.createElement('option');
                                                    noKPIMainOption.value = '';
                                                    noKPIMainOption.textContent = 'ไม่มีตัวชี้วัด';
                                                    KPIMainDropdown.appendChild(noKPIMainOption);
                                                    KPIMainDropdown.disabled = true;
                                                } else {
                                                    KPIMainDropdown.disabled = false;
                                                    filteredKPIMain.forEach(KPIMain => {
                                                        const option = document.createElement('option');
                                                        option.value = KPIMain.KPIMain3LVID;
                                                        option.textContent = KPIMain.name;
                                                        KPIMainDropdown.appendChild(option);
                                                    });
                                                }

                                                colKPIMain.appendChild(KPIMainDropdown);
                                                mainContainer.appendChild(colKPIMain);

                                                const deleteButton = document.createElement('button');
                                                deleteButton.type = 'button';
                                                deleteButton.classList.add('btn', 'btn-danger', 'ml-2'); // เพิ่มคลาส Bootstrap
                                                deleteButton.textContent = 'ลบ';
                                                deleteButton.onclick = function() {
                                                    mainContainer.remove(); // ลบ mainContainer เมื่อคลิกปุ่ม
                                                };
                                                // เพิ่มปุ่มลบลงใน mainContainer
                                                mainContainer.appendChild(deleteButton);
                                                document.getElementById('insertKPIMain').appendChild(mainContainer);
                                            }

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
                                                        // console.log(plan.straID , {{ $tactics->goal->SFA->straID }});
                                                        if (plan.stra3LVID == '{{ $tactics->goal->SFA->stra3LVID }}') {
                                                            option.selected = true;
                                                            updateIssueDropdown(plan.stra3LVID);
                                                        }
                                                        planSelect.appendChild(option);
                                                    });
                                                    if (!filteredPlans.some(plan => plan.stra3LVID == '{{ $tactics->goal->SFA->stra3LVID }}')) {
                                                        updateIssueDropdown(filteredPlans[0].stra3LVID);
                                                    }
                                                }
                                            }

                                            // ฟังก์ชันอัปเดต dropdown ของประเด็นยุทธศาสตร์
                                            function updateIssueDropdown(selectedPlanID) {
                                                // console.log(selectedPlanID);
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
                                                        // console.log(issue.SFAID , '$tactics->goal->SFAID' );

                                                        if (issue.SFA3LVID == '{{ $tactics->goal->SFA3LVID }}') {
                                                            option.selected = true;
                                                            updateGoalDropdown(issue.SFA3LVID);
                                                        }

                                                        issueSelect.appendChild(option);
                                                    });
                                                    if (!filteredIssues.some(issue => issue.SFA3LVID == '{{ $tactics->goal->SFA3LVID }}')) {
                                                        updateGoalDropdown(filteredIssues[0].SFA3LVID);
                                                    }
                                                }
                                            }

                                            // ฟังก์ชันอัปเดต dropdown ของกลยุทธ์ผ่านการเชื่อมต่อจากประเด็นยุทธศาสตร์และเป้าประสงค์
                                            function updateGoalDropdown(selectedSFAID) {
                                                const goalSelect = document.getElementById('goalID');
                                                goalSelect.innerHTML = '';
                                                const kpiMainElements = document.querySelectorAll('[id^="KPIMainID_"]');
                                                


                                                if (!selectedSFAID) {
                                                    const noGoalOption = document.createElement('option');
                                                    noGoalOption.value = '';
                                                    noGoalOption.textContent = 'ไม่มีเป้าประสงค์';
                                                    goalSelect.appendChild(noGoalOption);
                                                    goalSelect.disabled = true;

                                                    // updateKPIMainDropdown(null, 'KPIMainID_'+{{ $KPIMainMap->KPIMainID }});
                                                    // const kpiMainElements = document.querySelectorAll('[id^="KPIMainID_"]');
                                                    kpiMainElements.forEach(function(kpiMainElement) {
                                                        updateKPIMainDropdown(null, kpiMainElement.id);
                                                    });
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
                                                    // updateKPIMainDropdown(null, 'KPIMainID_'+{{ $KPIMainMap->KPIMainID }});
                                                   
                                                    kpiMainElements.forEach(function(kpiMainElement) {
                                                        updateKPIMainDropdown(null, kpiMainElement.id);
                                                    });
                                                } else {
                                                    goalSelect.disabled = false;
                                                    filteredGoals.forEach(goal => {
                                                        const option = document.createElement('option');
                                                        option.value = goal.goal3LVID;
                                                        option.textContent = goal.name;
                                                        if (goal.goal3LVID == '{{ $tactics->goal3LVID }}') {
                                                            option.selected = true;
                                                            // updateKPIMainDropdown(goal.goalID, 'KPIMainID_'+{{ $KPIMainMap->KPIMainID }});
                                                            kpiMainElements.forEach(function(kpiMainElement) {
                                                        updateKPIMainDropdown(goal.goal3LVID, kpiMainElement.id);
                                                    });
                                                        }
                                                        goalSelect.appendChild(option);
                                                    });
                                                    if (!filteredGoals.some(goal => goal.goal3LVID == '{{ $tactics->goal3LVID }}')) {
                                                        // updateKPIMainDropdown(filteredGoals[0].goalID, 'KPIMainID_'+{{ $KPIMainMap->KPIMainID }});
                                                        kpiMainElements.forEach(function(kpiMainElement) {
                                                        updateKPIMainDropdown(filteredGoals[0].goal3LVID, kpiMainElement.id);
                                                    });
                                                    }
                                                }

                                            }


                                            document.addEventListener('DOMContentLoaded', function() {
                                                @foreach ($KPIMainMaps as $item)
                                                    @if ($item->tac3LVID === $tactics->tac3LVID && $item->KPIMain3LVID != $KPIMainMap->KPIMain3LVID)
                                                        updateKPIMainDropdown('{{ $tactics->goal3LVID }}', 'KPIMainID_{{ $item->KPIMain3LVID }}');
                                                    @endif
                                                @endforeach
                                            });

                                            function updateKPIMainDropdown(selectedgoalID, selectID) {
                                                const KPIMainSelect = document.getElementById(selectID);
                                                console.log(selectID);
                                                KPIMainSelect.innerHTML = '';

                                                if (!selectedgoalID) {
                                                    const noKPIMainOption = document.createElement('option');
                                                    noKPIMainOption.value = '';
                                                    noKPIMainOption.textContent = 'ไม่มีตัวชี้วัด';
                                                    KPIMainSelect.appendChild(noKPIMainOption);
                                                    KPIMainSelect.disabled = true;
                                                    return;
                                                }

                                                const filteredKPIMain = KPIMains.filter(KPIMain => KPIMain.goal3LVID ==
                                                    selectedgoalID);



                                                if (filteredKPIMain.length === 0) {
                                                    const noKPIMainOption = document.createElement('option');
                                                    noKPIMainOption.value = '';
                                                    noKPIMainOption.textContent = 'ไม่มีตัวชี้วัด';
                                                    KPIMainSelect.appendChild(noKPIMainOption);
                                                    KPIMainSelect.disabled = true;
                                                } else {
                                                    KPIMainSelect.disabled = false;

                                                    filteredKPIMain.forEach(KPIMain => {
                                                        const option = document.createElement('option');
                                                        option.value = KPIMain.KPIMain3LVID;
                                                        option.textContent = KPIMain.name;
                                                        const map = tacticMap.find(map => map.KPIMain3LVID == KPIMain.KPIMain3LVID);
                                                        
                                                        if ((map && selectID === 'KPIMainID_' + map.KPIMain3LVID) ) {

                                                            option.selected = true; // Set the option selected if matched
                                                            // console.log('Selected option for', selectID, map , 'KPIMainID_'+map.KPIMainID);
                                                        }
                                                        KPIMainSelect.appendChild(option);
                                                    });
                                                }
                                            }

                                            // Event listeners สำหรับ dropdown ต่าง ๆ
                                            window.onload = function() {
                                                const yearSelect = document.getElementById('year');
                                                const planSelect = document.getElementById('straID');
                                                const issueSelect = document.getElementById('SFAID');
                                                const goalSelect = document.getElementById('goalID');


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

                                                goalSelect.addEventListener('change', function() {
                                                    const selectedgoalID = this.value;

                                                    const kpiMainElements = document.querySelectorAll('[id^="KPIMainID_"]');
                                                    kpiMainElements.forEach(function(kpiMainElement) {
                                                        updateKPIMainDropdown(selectedgoalID, kpiMainElement.id);
                                                    });

                                                });



                                                // เรียกใช้ครั้งแรกเมื่อโหลดหน้า
                                                const defaultYearID = yearSelect.value;
                                                if (defaultYearID) {
                                                    updatePlanDropdown(defaultYearID);
                                                }
                                            };
                                        </script>



                                        <div class="ln_solid">
                                            <div class="form-group text-center p-2">
                                                <div class="col-md-6 offset-md-3">
                                                    <button type='submit' class="btn btn-warning"
                                                        value="บันทึก">Edit</button>
                                                    <button type='reset' class="btn btn-danger"><a href="/tactics" style="color: white">Back</a></button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1 col-sm-1"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
