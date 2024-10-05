<div class="row">
    <div class="col-md-1 col-sm-1"></div>
    <div class="col-md-10 col-sm-10">
        <div class="x_panel">
            <div class="x_title">
                <h2>เพิ่มเป้าประสงค์</h2>
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
                <form method="POST" action="/goalInsert"novalidate enctype="multipart/form-data">
                    @csrf
                    <div class="field item form-group">
                        <label for="title" class="col-form-label col-md-3 col-sm-3 label-align">ปีงบประมาณ<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <select id="year" name="year" class="form-control" required>
                                @foreach ($year as $item)
                                    <option value="{{ $item->yearID }}">
                                        {{ $item->name }}</option>
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
                                <!-- ประเด็นยุทธศาสตร์จะถูกโหลดที่นี่ -->
                            </select>
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
                            filteredPlans.forEach(plan => {
                                const option = document.createElement('option');
                                option.value = plan.straID;
                                option.textContent = plan.name;
                                planSelect.appendChild(option);
                            });
                            if (filteredPlans.length > 0) {
                                updateIssueDropdown(filteredPlans[0].straID);
                            }
                        }

                        // ฟังก์ชันอัปเดต dropdown ของประเด็นยุทธศาสตร์
                        function updateIssueDropdown(selectedPlanID) {
                            const issueSelect = document.getElementById('SFAID');
                            issueSelect.innerHTML = '';

                            const filteredIssues = issues.filter(issue => issue.straID == selectedPlanID);
                            filteredIssues.forEach(issue => {
                                const option = document.createElement('option');
                                option.value = issue.SFAID;
                                option.textContent = issue.name;
                                issueSelect.appendChild(option);
                            });

                        }

                        

                        // Event listeners สำหรับ dropdown ต่าง ๆ
                        window.onload = function() {
                            const yearSelect = document.getElementById('year');
                            const planSelect = document.getElementById('straID');


                            // เมื่อเปลี่ยนปีงบประมาณ
                            yearSelect.addEventListener('change', function() {
                                const selectedYearID = this.value;
                                // const selectedPlanID = planSelect.value;
                                updatePlanDropdown(selectedYearID);
                                // updateIssueDropdown(selectedPlanID);
                            });

                            // เมื่อเปลี่ยนแผนยุทธศาสตร์
                            planSelect.addEventListener('change', function() {
                                const selectedPlanID = this.value;
                                updateIssueDropdown(selectedPlanID);
                            });

                            // เรียกใช้ครั้งแรกเมื่อโหลดหน้า
                            const defaultYearID = yearSelect.value;
                            const defaultPLanID = planSelect.value;
                            if (defaultYearID  ) {
                                updatePlanDropdown(defaultYearID);
                               
                            }

                        };
                    </script>
                    <div class="field item form-group">
                        <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">เป้าประสงค์<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="textt" name="name" id="name" required='required'
                                data-validate-length-range="8,20" />
                            @error('name')
                                <div class="m-2">
                                    <span class="text text-danger">{{ $message }}</span>
                                </div>
                            @enderror
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
    <div class="col-md-1 col-sm-1"></div>
</div>
