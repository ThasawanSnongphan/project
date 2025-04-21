@extends('layout')
@section('title', 'เป้าหมาย')
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
                                    <h2>แก้ไขเป้าหมาย </h2>
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
                                    <form method="POST" action="{{ route('target1LV.update', $target->tar1LVID) }}"
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
                                                            {{ $year->yearID == $target->strategic->year->yearID ? 'selected' : '' }}>
                                                            {{ $year->year }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="field item form-group">
                                            <label for="title"
                                                class="col-form-label col-md-3 col-sm-3  label-align">แผนยุทธศาสตร์<span
                                                    class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <select id="stra1LVID" name="stra1LVID" class="form-control" required>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="field item form-group">
                                            <label for="title"
                                                class="col-form-label col-md-3 col-sm-3  label-align">เป้าหมาย<span
                                                    class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <input class="form-control" type="text" name="name" id="name"
                                                    required
                                                    value="{{ $target->name }}" >
                                                
                                            </div>
                                        </div>

                                        <script>
                                            const strategic = @json($strategic);

                                            function updateStrategicDropdown(selectedYearID) {
                                                const planSelect = document.getElementById('stra1LVID');
                                                planSelect.innerHTML = '';

                                                const filteredPlans = strategic.filter(stra => stra.yearID == selectedYearID);

                                                if (filteredPlans.length === 0) {
                                                    const noPlanOption = document.createElement('option');
                                                    noPlanOption.value = '';
                                                    noPlanOption.textContent = 'ไม่มีแผนยุทธศาสตร์';
                                                    planSelect.appendChild(noPlanOption);
                                                    planSelect.disabled = true;
                                                } else {
                                                    planSelect.disabled = false;
                                                    filteredPlans.forEach(stra => {
                                                        const option = document.createElement('option');
                                                        option.value = stra.stra1LVID;
                                                        option.textContent = stra.name;
                                                        if (stra.stra1LVID == '{{ $target->stra1LVID }}') { // ตั้งค่าให้ตรงกับแผนที่เลือกไว้
                                                            option.selected = true;
                                                        }
                                                        planSelect.appendChild(option);
                                                    });
                                                }
                                            }
                                            window.onload = function() {
                                                const yearSelect = document.getElementById('yearID');
                                                // const planSelect = document.getElementById('stra2LVID');

                                                // เมื่อเปลี่ยนปีงบประมาณ
                                                yearSelect.addEventListener('change', function() {
                                                    const selectedYearID = this.value;
                                                    updateStrategicDropdown(selectedYearID);
                                                });

                                                // เรียกใช้ครั้งแรกเมื่อโหลดหน้า
                                                const defaultYearID = yearSelect.value;
                                                if (defaultYearID) {
                                                    updateStrategicDropdown(defaultYearID);
                                                }
                                            };
                                        </script>



                                        <div class="ln_solid">
                                            <div class="form-group text-center p-2">
                                                <div class="col-md-6 offset-md-3">
                                                    <button type='submit' class="btn btn-warning"
                                                        value="บันทึก">Edit</button>
                                                    <button type='reset' class="btn btn-danger"><a href="/target1LV" style="color: white">Back</a></button>
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
