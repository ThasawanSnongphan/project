@extends('layout')
@section('title', 'SFA')
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
                                    <h2>แก้ๆขเป้าประสงค์ </h2>
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
                                    <form method="POST" action="{{ route('goal.update', $goal->goal3LVID) }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="field item form-group">
                                            <label for="title"
                                                class="col-form-label col-md-3 col-sm-3  label-align">ปีงบประมาณ<span
                                                    class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <select id="yearID" name="yearID" class="form-control" required>
                                                    @foreach ($year as $year)
                                                        <option value="{{ $year->yearID }}"
                                                            {{ $year->yearID == $goal->SFA->strategic->year->yearID ? 'selected' : '' }}>
                                                            {{ $year->year }}</option>
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
                                                class="col-form-label col-md-3 col-sm-3  label-align">name<span
                                                    class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <input class="form-control" type="text" name="name" id="name"
                                                    required
                                                    value="{{ $goal->name }}" >
                                                
                                            </div>
                                        </div>

                                        <script>
                                            const strategic = @json($strategic); // ข้อมูลแผนยุทธศาสตร์
                                            const issues = @json($SFA); // ข้อมูลประเด็นยุทธศาสตร์

                                            // ฟังก์ชันอัปเดต dropdown ของแผน
                                            function updatePlanDropdown(selectedYearID) {
                                                const planSelect = document.getElementById('straID');
                                                planSelect.innerHTML = '';

                                                const filteredPlans = strategic.filter(plan => plan.yearID == selectedYearID);
                                                // console.log(filteredPlans)
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
                                                        // console.log( plan.straID, {{ $goal->SFA->straID }})
                                                        if (plan.stra3LVID == '{{ $goal->SFA->stra3LVID }}') { // ตั้งค่าให้ตรงกับแผนที่เลือกไว้
                                                            option.selected = true;
                                                            // console.log('Adding Plan:', plan.straID, plan.name);
                                                            updateIssueDropdown(plan.stra3LVID);

                                                        }
                                                        planSelect.appendChild(option);
                                                    });
                                                    // ตรวจสอบให้แน่ใจว่ามีข้อมูลใน `filteredPlans` ก่อนเรียก `updateIssueDropdown`
                                                    if (!filteredPlans.some(plan => plan.stra3LVID == '{{ $goal->SFA->stra3LVID }}')) {
                                                        updateIssueDropdown(filteredPlans[0].stra3LVID);
                                                    }


                                                }
                                            }

                                            // ฟังก์ชันอัปเดต dropdown ของประเด็นยุทธศาสตร์
                                            function updateIssueDropdown(selectedPlanID) {


                                                // console.log(selectedPlanID, {{ $goal->SFA->stra3LVID }});
                                                const issueSelect = document.getElementById('SFAID');
                                                issueSelect.innerHTML = '';

                                                if (!selectedPlanID) {
                                                    const noIssueOption = document.createElement('option');
                                                    noIssueOption.value = '';
                                                    noIssueOption.textContent = 'ไม่มีประเด็นยุทธศาสตร์';
                                                    issueSelect.appendChild(noIssueOption);
                                                    issueSelect.disabled = true;
                                                    return;
                                                }
                                                const filteredIssues = issues.filter(issue => issue.stra3LVID == selectedPlanID);
                                                // console.log('Filtered Issues:', filteredIssues);

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
                                                        option.value = issue.SFA3LVID;
                                                        option.textContent = issue.name;
                                                        // console.log(issue.SFAID, {{ $goal->SFAID }});
                                                        if (issue.SFA3LVID == '{{ $goal->SFA3LVID }}') {
                                                            option.selected = true;
                                                            // console.log('Adding Plan:', issue.SFAID,issue.name);
                                                        }
                                                        issueSelect.appendChild(option);
                                                    });
                                                }


                                            }
                                            // Event listeners สำหรับ dropdown ต่าง ๆ
                                            window.onload = function() {
                                                const yearSelect = document.getElementById('yearID');
                                                const planSelect = document.getElementById('straID');
                                                // console.log(yearID);
                                                // console.log(straID);

                                                // เมื่อเปลี่ยนปีงบประมาณ
                                                yearSelect.addEventListener('change', function() {
                                                    const selectedYearID = this.value;
                                                    // const selectedPlanID = planSelect.value;
                                                    updatePlanDropdown(selectedYearID);
                                                    //  updateIssueDropdown(selectedPlanID);
                                                });

                                                // เมื่อเปลี่ยนแผนยุทธศาสตร์
                                                planSelect.addEventListener('change', function() {
                                                    const selectedPlanID = this.value;
                                                    console.log(selectedPlanID);
                                                    updateIssueDropdown(selectedPlanID);
                                                });

                                                // เรียกใช้ครั้งแรกเมื่อโหลดหน้า
                                                const defaultYearID = yearSelect.value;
                                                // const defaultPLanID = planSelect.value;
                                                if (defaultYearID) {
                                                    updatePlanDropdown(defaultYearID);

                                                }
                                                // if (defaultPlanID) {
                                                //     updateIssueDropdown(defaultPlanID);
                                                // }

                                            };
                                        </script>



                                        <div class="ln_solid">
                                            <div class="form-group text-center p-2">
                                                <div class="col-md-6 offset-md-3">
                                                    <button type='submit' class="btn btn-warning"
                                                        value="บันทึก">Edit</button>
                                                    <button type='reset' class="btn btn-danger"><a href="/goal" style="color: white">Back</a></button>
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
