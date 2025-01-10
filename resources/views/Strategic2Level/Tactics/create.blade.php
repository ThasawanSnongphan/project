<div class="row">
    <div class="col-md-1 col-sm-1"></div>
    <div class="col-md-10 col-sm-10">
        <div class="x_panel">
            <div class="x_title">
                <h2>เพิ่มกลยุทธ์</h2>
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
                <form method="POST" action="/tactic2LVInsert"novalidate enctype="multipart/form-data">
                    @csrf
                    <div class="field item form-group">
                        <label for="title" class="col-form-label col-md-3 col-sm-3 label-align">ปีงบประมาณ<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <select id="year" name="year" class="form-control" required>
                                @foreach ($year as $item)
                                    <option value="{{ $item->yearID }}">
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
                                <!-- ประเด็นยุทธศาสตร์จะถูกโหลดที่นี่ -->
                            </select>
                        </div>
                    </div>

                    <div class="field item form-group">
                        <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">กลยุทธ์<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="text" name="name" id="name" required='required'
                                data-validate-length-range="8,20" />
                            @error('name')
                                <div class="m-2">
                                    <span class="text text-danger">{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                    </div>

                    <div class="field item form-group">
                        <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">ตัวชี้วัด<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <select id="KPIMain2LVID" name="KPIMain[]" class="form-control" required>
                            </select>
                        </div>
                        <div class="col-md-1 col-sm-1 ">
                            <button type='button' class="btn btn-primary" id="addKPIButton"
                                onclick="insertKPIMain()">เพิ่ม</button>
                        </div>
                    </div>
                    <div id="insertKPIMain"></div>


                    <script>
                        const strategic = @json($strategic); // ข้อมูลแผนยุทธศาสตร์
                        const issues = @json($SFA); // ข้อมูลเป้าประสงค์
                        const KPIMains = @json($KPIMain);

                        function insertKPIMain() {
                            const mainContainer = document.createElement('div');
                            mainContainer.classList.add('field', 'item', 'form-group');

                            const KPIMainLabel = document.createElement('label');
                            KPIMainLabel.setAttribute('for', 'KPIIMainInput'); // ตั้งค่า for ให้ตรงกับ input หรือ select ที่จะใช้
                            KPIMainLabel.classList.add('col-form-label', 'col-md-3', 'col-sm-3', 'label-align');
                            KPIMainLabel.textContent = 'ตัวชี้วัด*'; // ตั้งข้อความใน label

                            mainContainer.appendChild(KPIMainLabel);

                            const colKPIMain = document.createElement('div');
                            colKPIMain.classList.add('col-md-6', 'col-sm-6');

                            const KPIMainDropdown = document.createElement('select');
                            KPIMainDropdown.classList.add('form-control');
                            KPIMainDropdown.id = `KPIMain2LVID_${Date.now()}`;
                            KPIMainDropdown.name = 'KPIMain[]';

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
                                    planSelect.appendChild(option);
                                });
                                updateIssueDropdown(filteredPlans[0].stra2LVID);
                            }
                        }

                        // ฟังก์ชันอัปเดต dropdown ของประเด็นยุทธศาสตร์
                        function updateIssueDropdown(selectedPlanID) {
                            const issueSelect = document.getElementById('SFA2LVID');
                            issueSelect.innerHTML = '';

                            if (!selectedPlanID) {
                                const noIssueOption = document.createElement('option');
                                noIssueOption.value = '';
                                noIssueOption.textContent = 'ไม่มีประเด็นยุทธศาสตร์';
                                issueSelect.appendChild(noIssueOption);
                                issueSelect.disabled = true;
                                updateKPIMainDropdown(null);
                                return;
                            }

                            const filteredIssues = issues.filter(issue => issue.stra2LVID == selectedPlanID);

                            if (filteredIssues.length === 0) {
                                const noIssueOption = document.createElement('option');
                                noIssueOption.value = '';
                                noIssueOption.textContent = 'ไม่มีประเด็นยุทธศาสตร์';
                                issueSelect.appendChild(noIssueOption);
                                issueSelect.disabled = true;
                                updateKPIMainDropdown(null);
                            } else {
                                issueSelect.disabled = false;
                                filteredIssues.forEach(issue => {
                                    const option = document.createElement('option');
                                    option.value = issue.SFA2LVID;
                                    option.textContent = issue.name;
                                    issueSelect.appendChild(option);
                                });
                                updateKPIMainDropdown(filteredIssues[0].SFA2LVID);
                            }
                        }


                        function updateKPIMainDropdown(selectedSFAID) {
                            const KPIMainSelect = document.getElementById('KPIMain2LVID');
                            KPIMainSelect.innerHTML = '';

                            if (!selectedSFAID) {
                                const noKPIMainOption = document.createElement('option');
                                noKPIMainOption.value = '';
                                noKPIMainOption.textContent = 'ไม่มีตัวชี้วัด';
                                KPIMainSelect.appendChild(noKPIMainOption);
                                KPIMainSelect.disabled = true;
                                return;
                            }

                            const filteredKPIMain = KPIMains.filter(KPIMain => KPIMain.SFA2LVID == selectedSFAID);

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
                                updateKPIMainDropdown(selectedSFAID);
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
                                <button type='submit' class="btn btn-primary" value="บันทึก">Submit</button>
                                <button type='reset' class="btn btn-success">Reset</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-1 col-sm-1"></div>
</div>
