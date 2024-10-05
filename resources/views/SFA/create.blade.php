<div class="row">
    <div class="col-md-3 col-sm-3"></div>
    <div class="col-md-6 col-sm-6">
        <div class="x_panel">
            <div class="x_title">
                <h2>เพิ่มประเด็นยุทธศาสตร์ </h2>
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
                <form method="POST" action="/SFAInsert"novalidate enctype="multipart/form-data">
                    @csrf
                    <div class="field item form-group">
                        <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">ปีงบประมาณ<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <select id="yearID" name="yearID" class="form-control" required>
                                @foreach ($year as $item)
                                    <option value="{{ $item->yearID }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">แผนยุทธศาสตร์<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <select id="straID" name="straID" class="form-control" required>
                            </select>
                        </div>
                    </div>
                    <div class="field item form-group">

                        <label for="title"
                            class="col-form-label col-md-3 col-sm-3  label-align">ประเด็นยุทธศาสตร์<span
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

                <script>
                    const strategic = @json($strategic);

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

                        // เรียกใช้ฟังก์ชันเพื่ออัปเดตกกลยุทธ์โดยอิงจากแผนที่เลือกแรก
                        if (filteredPlans.length > 0) {
                            updateTacticsDropdown(filteredPlans[0].straID); // ใช้ straID ของแผนแรก
                        }
                    }
                    window.onload = function() {
                        const yearSelect = document.getElementById('yearID');
                        const planSelect = document.getElementById('straID');

                        // เมื่อเปลี่ยนปีงบประมาณ
                        yearSelect.addEventListener('change', function() {
                            const selectedYearID = this.value;
                            updatePlanDropdown(selectedYearID);
                        });

                        // เมื่อเปลี่ยนแผนยุทธศาสตร์
                        planSelect.addEventListener('change', function() {
                            const selectedPlanID = this.value;
                            updateTacticsDropdown(selectedPlanID);
                        });

                        // เรียกใช้ครั้งแรกเมื่อโหลดหน้า
                        const defaultYearID = yearSelect.value;
                        if (defaultYearID) {
                            updatePlanDropdown(defaultYearID);
                        }
                    };
                </script>

            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-3"></div>
</div>
