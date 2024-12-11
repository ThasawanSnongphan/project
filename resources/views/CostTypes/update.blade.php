@extends('layout')
@section('title', 'CostType')
@section('content')
    <div class="container body">
        <div class="main_container">
            <div role="main">
                <div class="">
                    <div class="page-title">
                        <div class="title_left">
                            <h3>แก้ไขหมวดรายจ่าย</h3>
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
                                    <h2>หมวดรายจ่าย </h2>
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
                                    <form method="POST" action="{{ route('costs.update', $cost_types->costID) }}"novalidate
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="field item form-group">
                                            <label for="title"
                                                class="col-form-label col-md-3 col-sm-3  label-align">แผนงานมหาลัย<span
                                                    class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <select id="planID" name="planID" class="form-control" required>
                                                    @foreach ($plan as $item)
                                                        <option value="{{ $item->planID }}"  @if ($item->planID == $cost_types->expense->fund->uniplan->planID) selected @endif>{{ $item->name }}</option>
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
                                            <label for="title"
                                                class="col-form-label col-md-3 col-sm-3  label-align">งบรายจ่าย<span
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
                                                        if (fund.fundID == '{{ $cost_types->expense->fundID }}') {
                                                            option.selected = true;
                                                        }
                                                        fundSelect.appendChild(option);
                                                    });
                                                    if (!filteredFunds.some(fund => fund.fundID == '{{ $cost_types->expense->fundID }}')) {
                                                        updateExpenseDropdown(filteredFunds[0].fundID); // Update expenses for the first fund
                                                    }
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
                                                        if (expense.expID == '{{ $cost_types->expID }}') {
                                                            option.selected = true;
                                                        }
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
                                            <label for="title"
                                                class="col-form-label col-md-3 col-sm-3  label-align">name<span
                                                    class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <input class="form-control" type="textt" name="costname" id="name"
                                                    required='required' data-validate-length-range="8,20"
                                                    value="{{ $cost_types->name }}" />
                                                @error('costname')
                                                    <div class="m-2">
                                                        <span class="text text-danger">{{ $message }}</span>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>



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
