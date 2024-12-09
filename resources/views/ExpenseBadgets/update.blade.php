@extends('layout')
@section('title', 'ExpenseBadget')
@section('content')
    <div class="container body">
        <div class="main_container">
            <div role="main">
                <div class="">
                    <div class="page-title">
                        <div class="title_left">
                            <h3>แก้ไขงบรายจ่าย</h3>
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
                                    <h2>งบรายจ่าย </h2>
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
                                    <form method="POST" action="{{ route('ex.update', $expanse->expID) }}"novalidate
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="field item form-group">
                                            <label for="title"
                                                class="col-form-label col-md-3 col-sm-3  label-align">แผนงานมหาลัย<span
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
                                            <label for="title"
                                                class="col-form-label col-md-3 col-sm-3  label-align">name<span
                                                    class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <input class="form-control" type="textt" name="name" id="name"
                                                    required='required' data-validate-length-range="8,20"
                                                    value="{{ $expanse->name }}" />
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

    <script>
        const funds = @json($fund);

        function updateFundDropdown(selectedPlanID) {
            const fundSelect = document.getElementById('fundID');
            fundSelect.innerHTML = '';
            const filteredFunds = funds.filter(fund => fund.planID == selectedPlanID);

            if (filteredFunds.length === 0) {
                const noFundOption = document.createElement('option');
                noFundOption.value = '';
                noFundOption.textContent = 'ไม่มีกองทุน';
                fundSelect.appendChild(noFundOption);
                fundSelect.disabled = true;
            } else {
                fundSelect.disabled = false;
                filteredFunds.forEach(fund => {
                    const option = document.createElement('option');
                    option.value = fund.fundID;
                    option.textContent = fund.name;
                    fundSelect.appendChild(option);
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

            // เรียกใช้ครั้งแรกเมื่อโหลดหน้า
            const defaultPlanID = planSelect.value;
            if (defaultPlanID) {
                updateFundDropdown(defaultPlanID);
            }
        };
    </script>
@endsection
