<div class="row">
    <div class="col-md-1 col-sm-1"></div>
    <div class="col-md-10 col-sm-10">
        <div class="x_panel">
            <div class="x_title">
                <h2>เพิ่มหมวดรายจ่าย </h2>
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
                <form method="POST" action="/costInsert" enctype="multipart/form-data">
                    @csrf
                    <div class="field item form-group">
                        <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">แผนงานมหาวิทยาลัย<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <select id="planID" name="planID" class="form-control" required>
                                @foreach ($plan as $item)
                                    <option value="{{ $item->planID }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">กองทุน<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <select id="fundID" name="fundID" class="form-control" required>

                            </select>
                        </div>
                    </div>

                    <div class="field item form-group">
                        <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">งบรายจ่าย<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <select id="expID" name="expID" class="form-control" required>

                            </select>
                        </div>
                    </div>
                    <script>
                        const funds = @json($fund);
                        const expenses = @json($expanses);

                        function updateFundDropdown(selectedPlanID) {
                            const fundSelect = document.getElementById('fundID');
                            fundSelect.innerHTML = '';

                            const filteredFunds = funds.filter(fund => fund.planID == selectedPlanID);

                            if (filteredFunds.length === 0) {
                                // No funds available for the selected plan
                                const noFundOption = document.createElement('option');
                                noFundOption.value = '';
                                noFundOption.textContent = 'ไม่มีกองทุน';
                                fundSelect.appendChild(noFundOption);
                                fundSelect.disabled = true; // Disable fund dropdown
                                updateExpenseDropdown(null); // Clear expense dropdown
                            } else {
                                fundSelect.disabled = false; // Enable fund dropdown
                                filteredFunds.forEach(fund => {
                                    const option = document.createElement('option');
                                    option.value = fund.fundID;
                                    option.textContent = fund.name;
                                    fundSelect.appendChild(option);
                                });
                                updateExpenseDropdown(filteredFunds[0].fundID); // Update expenses for the first fund
                            }
                        }

                        function updateExpenseDropdown(selectedFundID) {
                            const expenseSelect = document.getElementById('expID');
                            expenseSelect.innerHTML = '';

                            if (!selectedFundID) {
                                const noExpenseOption = document.createElement('option');
                                noExpenseOption.value = '';
                                noExpenseOption.textContent = 'ไม่มีงบรายจ่าย';
                                expenseSelect.appendChild(noExpenseOption);
                                expenseSelect.disabled = true; // Disable expense dropdown
                                return;
                            }

                            const filteredExpense = expenses.filter(expense => expense.fundID == selectedFundID);

                            if (filteredExpense.length === 0) {
                                const noExpenseOption = document.createElement('option');
                                noExpenseOption.value = '';
                                noExpenseOption.textContent = 'ไม่มีงบรายจ่าย';
                                expenseSelect.appendChild(noExpenseOption);
                                expenseSelect.disabled = true; // Disable expense dropdown
                            } else {
                                expenseSelect.disabled = false; // Enable expense dropdown
                                filteredExpense.forEach(expense => {
                                    const option = document.createElement('option');
                                    option.value = expense.expID;
                                    option.textContent = expense.name;
                                    expenseSelect.appendChild(option);
                                });
                            }
                        }
                        window.onload = function() {
                            const planSelect = document.getElementById('planID');
                            const fundSelect = document.getElementById('fundID');

                            // เมื่อเปลี่ยนปีงบประมาณ
                            planSelect.addEventListener('change', function() {
                                const selectedPlanID = this.value;
                                updateFundDropdown(selectedPlanID);
                            });
                            fundSelect.addEventListener('change', function() {
                                const selectedFundID = this.value;
                                updateExpenseDropdown(selectedFundID);
                            });


                            // เรียกใช้ครั้งแรกเมื่อโหลดหน้า
                            const defaultPlanID = planSelect.value;
                            if (defaultPlanID) {
                                updateFundDropdown(defaultPlanID);
                            }
                        };
                    </script>
                    <div class="field item form-group">

                        <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">หมวดรายจ่าย<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" type="text" name="name" id="name" required>
                           
                        </div>

                    </div>



                    <div class="ln_solid">
                        <div class="form-group text-center p-2">
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
