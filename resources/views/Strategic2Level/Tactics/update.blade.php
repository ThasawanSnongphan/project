@extends('layout')
@section('title', 'กลยุทธ์')
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
                                    <h2>แก้ไขกลยุทธ์ </h2>
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
                                    <form method="POST"
                                        action="{{ route('tactic2LV.update', $tactics->tac2LVID) }}"
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
                                                            {{ $item->yearID == $tactics->SFA->strategic->year->yearID ? 'selected' : '' }}>
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
                                                    <!-- ประเด็นยุทธศาสตร์จะถูกโหลดที่นี่ -->
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
                                            <div class="col-md-6 col-sm-6">
                                                <input type="hidden" value="{{ $KPIMainMap->KPIMain2LVID ?? '0' }}">
                                                <select id="KPIMain2LVID_{{ $KPIMainMap->KPIMain2LVID ?? '0' }}"
                                                    name="KPIMain2LVID[]" class="form-control" required>

                                                </select>
                                            </div>
                                            <div class="col-md-1 col-sm-1 ">
                                                <button type='button' class="btn btn-primary" id="addKPIButton"
                                                    onclick="insertKPIMain()">เพิ่ม</button>
                                            </div>
                                        </div>

                                        @foreach ($KPIMainMaps as $item)
                                            @if (
                                                !empty($item->KPIMain2LVID) &&
                                                    $item->KPIMain2LVID != $KPIMainMap->KPIMain2LVID &&
                                                    $item->tac2LVID == $tactics->tac2LVID)
                                                <div class="i field item form-group">
                                                    <label for="title"
                                                        class="col-form-label col-md-3 col-sm-3  label-align"></label>
                                                    <div class="col-md-6 col-sm-6">
                                                        <input type="hidden" value="{{ $item->KPIMain2LVID }}">
                                                        <select id="KPIMain2LVID_{{ $item->KPIMain2LVID }}"
                                                            name="KPIMain2LVID[]" class="form-control" required>

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
                                                KPIMainDropdown.id = `KPIMain2LVID_${index+=1}`;
                                                KPIMainDropdown.name = 'KPIMain2LVID[]';

                                                // updateKPIMainDropdown(selectedgoalID, KPIMainDropdown);
                                                // KPIMainDropdown.innerHTML = '';

                                                const selectedSFA2LVID = document.getElementById('SFA2LVID').value;
                                                KPIMainDropdown.innerHTML = '';

                                                if (!selectedSFA2LVID) {
                                                    const noKPIMainOption = document.createElement('option');
                                                    noKPIMainOption.value = '';
                                                    noKPIMainOption.textContent = 'ไม่มีตัวชี้วัด';
                                                    KPIMainDropdown.appendChild(noKPIMainOption);
                                                    KPIMainDropdown.disabled = true;
                                                    return;
                                                }

                                                const filteredKPIMain = KPIMains.filter(KPIMain => KPIMain.SFA2LVID == selectedSFA2LVID);

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
                                                        option.value = KPIMain.KPIMain2LVID;
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
                                                        if (plan.stra2LVID == '{{ $tactics->SFA->stra2LVID }}') {
                                                            option.selected = true;
                                                            updateIssueDropdown(plan.stra2LVID);
                                                        }
                                                        planSelect.appendChild(option);
                                                    });
                                                    if (!filteredPlans.some(plan => plan.stra2LVID == '{{ $tactics->SFA->stra2LVID }}')) {
                                                        updateIssueDropdown(filteredPlans[0].stra2LVID);
                                                    }
                                                }
                                            }

                                            // ฟังก์ชันอัปเดต dropdown ของประเด็นยุทธศาสตร์
                                            function updateIssueDropdown(selectedPlanID) {
                                                // console.log(selectedPlanID);
                                                const issueSelect = document.getElementById('SFA2LVID');
                                                issueSelect.innerHTML = '';
                                                const kpiMains = document.querySelectorAll('[id^="KPIMain2LVID_"]');

                                                if (!selectedPlanID) {
                                                    const noIssueOption = document.createElement('option');
                                                    noIssueOption.value = '';
                                                    noIssueOption.textContent = 'ไม่มีประเด็นยุทธศาสตร์';
                                                    issueSelect.appendChild(noIssueOption);
                                                    issueSelect.disabled = true;
                                                    // updateKPIMainDropdown(null, 'KPIMain2LVID_' + {{ $KPIMainMap->KPIMain2LVID ?? '0' }});
                                                    kpiMains.forEach(function(KPIMain) {
                                                        updateKPIMainDropdown(null, KPIMain.id);
                                                    });
                                                    return;
                                                }

                                                const filteredIssues = issues.filter(issue => issue.stra2LVID == selectedPlanID);

                                                if (filteredIssues.length === 0) {
                                                    const noIssueOption = document.createElement('option');
                                                    noIssueOption.value = '';
                                                    noIssueOption.textContent = 'ไม่มีประเด็นยุทธศาสตร์';
                                                    issueSelect.appendChild(noIssueOption);
                                                    issueSelect.disabled = true;
                                                    // updateKPIMainDropdown(null, 'KPIMain2LVID_' + {{ $KPIMainMap->KPIMain2LVID ?? '0' }});
                                                    kpiMains.forEach(function(KPIMain) {
                                                        updateKPIMainDropdown(null, KPIMain.id);
                                                    });
                                                } else {
                                                    issueSelect.disabled = false;
                                                    filteredIssues.forEach(issue => {
                                                        const option = document.createElement('option');
                                                        option.value = issue.SFA2LVID;
                                                        option.textContent = issue.name;
                                                        // console.log(issue.SFAID , '$tactics->goal->SFAID' );

                                                        if (issue.SFA2LVID == '{{ $tactics->SFA2LVID }}') {
                                                            option.selected = true;
                                                            // updateKPIMainDropdown(issue.SFA2LVID, 'KPIMain2LVID_' + {{ $KPIMainMap->KPIMain2LVID ?? '0' }});
                                                            kpiMains.forEach(function(KPIMain) {
                                                                updateKPIMainDropdown(issue.SFA2LVID, KPIMain.id);
                                                            });
                                                        }

                                                        issueSelect.appendChild(option);
                                                    });
                                                    if (!filteredIssues.some(issue => issue.SFA2LVID == '{{ $tactics->SFA2LVID }}')) {
                                                        // updateKPIMainDropdown(filteredIssues[0].SFA2LVID, 'KPIMain2LVID_' + {{ $KPIMainMap->KPIMain2LVID ?? '0' }});
                                                        kpiMains.forEach(function(KPIMain) {
                                                        updateKPIMainDropdown(filteredIssues[0].SFA2LVID, KPIMain.id);
                                                    });
                                                    }
                                                }
                                            }

                                            document.addEventListener('DOMContentLoaded', function() {
                                                @foreach ($KPIMainMaps as $item)
                                                    @if ($item->tac2LVID === $tactics->tac2LVID && $item->KPIMain2LVID != $KPIMainMap->KPIMain2LVID)
                                                        updateKPIMainDropdown('{{ $tactics->SFA2LVID }}', 'KPIMain2LVID_{{ $item->KPIMain2LVID }}');
                                                    @endif
                                                @endforeach
                                            });

                                            function updateKPIMainDropdown(selectedgoalID, selectID) {
                                                const KPIMainSelect = document.getElementById(selectID);
                                                KPIMainSelect.innerHTML = '';

                                                if (selectID === 'KPIMain2LVID_0') {
                                                    const defaultOption = document.createElement('option');
                                                    defaultOption.value = '';
                                                    defaultOption.textContent = '--เลือกตัวชี้วัด--'; // ข้อความ "เลือก"
                                                    defaultOption.selected = true; // ตั้งให้เป็นตัวเลือกเริ่มต้น
                                                    defaultOption.disabled = true; // ปิดการเลือกตัวเลือกนี้
                                                    KPIMainSelect.appendChild(defaultOption);
                                                }

                                                if (!selectedgoalID) {
                                                    const noKPIMainOption = document.createElement('option');
                                                    noKPIMainOption.value = '';
                                                    noKPIMainOption.textContent = 'ไม่มีตัวชี้วัด';
                                                    KPIMainSelect.appendChild(noKPIMainOption);
                                                    KPIMainSelect.disabled = true;
                                                    return;
                                                }

                                                const filteredKPIMain = KPIMains.filter(KPIMain => KPIMain.SFA2LVID == selectedgoalID);

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
                                                        option.value = KPIMain.KPIMain2LVID;
                                                        option.textContent = KPIMain.name;
                                                        const map = tacticMap.find(map => map.KPIMain2LVID == KPIMain.KPIMain2LVID);
                                                        if (map && selectID === 'KPIMain2LVID_' + map.KPIMain2LVID) {
                                                            option.selected = true;
                                                        }
                                                        KPIMainSelect.appendChild(option);
                                                    });
                                                }
                                            }

                                            // Event listeners สำหรับ dropdown ต่าง ๆ
                                            window.onload = function() {
                                                const yearSelect = document.getElementById('year');
                                                const planSelect = document.getElementById('stra2LVID');
                                                const issueSelect = document.getElementById('SFA2LVID');

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
                                                    const kpiMains = document.querySelectorAll('[id^="KPIMain2LVID_"]');
                                                    kpiMains.forEach(function(KPIMain) {
                                                        updateKPIMainDropdown(selectedSFAID, KPIMain.id);
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
                                                    <a href="/tactic2LV" style="color: white"><button type='button' class="btn btn-danger">Back</button></a>
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
