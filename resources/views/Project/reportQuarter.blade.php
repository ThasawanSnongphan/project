@extends('layout')
@section('title', 'QuarterReport')
@section('content')
    <div class="row">
        <div class="col-md-1 col-sm-1"></div>
        <div class="col-md-10 col-sm-10">
            <div class="x_panel">
                <div class="x_title">
                    @if (!empty($data['quarterReport']))
                        <h2>รายงานความก้าวหน้า ไตรมาส{{ $data['quarter'] }}</h2>
                    @else
                        <h2>เขียนรายงานความก้าวหน้า ไตรมาส{{ $data['quarter'] }}</h2>
                    @endif

                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        @if (!empty($data['evaluation']))
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                    aria-expanded="false"><i class="fa fa-file-text"></i></a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item"
                                        href="{{ route('detail.evaluation', $data['project']->proID) }}">รายงานผลประเมิน</a>
                                </div>
                            </li>
                        @endif
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form id="actionForm" method="POST"
                        action="{{ route('reportQuarter.save', [$data['project']->proID, $data['quarter']]) }}">
                        @csrf
                        <div class="row field item form-group align-items-center">
                            <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">ชื่อโครงการ :
                            </label>
                            <div class="col-md-6 col-sm-6">
                                {{ $data['project']->name }}
                                {{-- <input class="form-control" type="text" name="project_name" id="peoject_name"
                                    data-validate-length-range="8,20" value="{{ $project->name }}" disabled /> --}}
                            </div>
                        </div>
                        <div class="row field item form-group align-items-center">
                            <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">งบประมาณที่จัดสรร :
                            </label>
                            <div class="col-md-6 col-sm-6">
                                {{ $data['project']->badgetTotal }}
                                {{-- <input class="form-control" type="text" name="project_name" id="peoject_name"
                                    data-validate-length-range="8,20" value="{{ $project->name }}" disabled /> --}}
                            </div>
                        </div>
                        <div class="row field item form-group align-items-center">
                            <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">ผลการใช้จ่าย :
                            </label>
                            <div class="col-md-6 col-sm-6">
                                @if (!empty($data['quarterReport']))
                                    {{ $data['quarterReport']->costResult }}
                                @else
                                    <input class="form-control" type="text" name="costResult" id=""
                                        data-validate-length-range="8,20" required />
                                @endif


                            </div>
                        </div>
                        <div class="row field item form-group">
                            <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">ผลตามตัวชี้วัด :
                            </label>
                            <div class="col-md-8 col-sm-8">
                                <table class="table table-bordered">
                                    <tr style="text-align: center">
                                        <th>ตัวชี้วัด</th>
                                        <th>เป้า</th>
                                        <th>ผล</th>
                                        {{-- <th>บรรลุตามตัวชี้วัด</th> --}}
                                    </tr>
                                    @foreach ($data['KPIMain3LV'] as $item)
                                        <tr>
                                            <td>
                                                <input type="hidden" name="KPIMain3LVID[]"
                                                    value="{{ $item->KPI->KPIMain3LVID }}">
                                                {{ $item->KPI->name }}
                                            </td>
                                            <td style="text-align: center">{{ $item->KPI->target }}</td>
                                            <td style="text-align: center">
                                                @if (!empty($data['quarterReport']))
                                                    @if ($data['quarter'] == '1')
                                                        {{ $item->result1 }}
                                                    @elseif($data['quarter'] == '2')
                                                        {{ $item->result2 }}
                                                    @elseif($data['quarter'] == '3')
                                                        {{ $item->result3 }}
                                                    @else
                                                        {{ $item->result4 }}
                                                    @endif
                                                @else
                                                    <input type="text" id="result3LV" name="result3LV[]" inputmode="decimal" required>
                                                    <div class="invalid-feedback">
                                                        กรุณากรอกเฉพาะตัวเลขหรือทศนิยมเท่านั้น
                                                    </div>
                                                @endif
                                            </td>
                                            {{-- <td style="text-align: center">
                                                <input type="checkbox">
                                            </td> --}}
                                        </tr>
                                    @endforeach
                                    @foreach ($data['KPIMain2LV'] as $item)
                                        <tr>
                                            <td>
                                                <input type="hidden" name="KPIMain2LVID[]"
                                                    value="{{ $item->KPI->KPIMain2LVID }}">
                                                {{ $item->KPI->name }}
                                            </td>
                                            <td style="text-align: center">{{ $item->KPI->target ?? '-' }}</td>
                                            <td style="text-align: center">
                                                @if (!empty($data['quarterReport']))
                                                    @if ($data['quarter'] == '1')
                                                        {{ $item->result1 }}
                                                    @elseif($data['quarter'] == '2')
                                                        {{ $item->result2 }}
                                                    @elseif($data['quarter'] == '3')
                                                        {{ $item->result3 }}
                                                    @else
                                                        {{ $item->result4 }}
                                                    @endif
                                                @else
                                                    <input type="text" id="result2LV" name="result2LV[]" inputmode="decimal" required>
                                                    <div class="invalid-feedback">
                                                        กรุณากรอกเฉพาะตัวเลขหรือทศนิยมเท่านั้น
                                                    </div>
                                                @endif
                                            </td>
                                            {{-- <td style="text-align: center">
                                                <input type="checkbox">
                                            </td> --}}
                                        </tr>
                                    @endforeach
                                    @foreach ($data['KPI'] as $item)
                                        <tr>
                                            <td>
                                                <input type="hidden" name="KPIProID[]" value="{{ $item->KPIProID }}">
                                                {{ $item->name }}
                                            </td>
                                            <td style="text-align: center">{{ $item->target }}</td>
                                            <td style="text-align: center">
                                                @if (!empty($data['quarterReport']))
                                                    @if ($data['quarter'] == '1')
                                                        {{ $item->result1 }}
                                                    @elseif($data['quarter'] == '2')
                                                        {{ $item->result2 }}
                                                    @elseif($data['quarter'] == '3')
                                                        {{ $item->result3 }}
                                                    @else
                                                        {{ $item->result4 }}
                                                    @endif
                                                @else
                                                    <input type="text" id="result" name="result[]" inputmode="decimal" required>
                                                    <div class="invalid-feedback">
                                                        กรุณากรอกเฉพาะตัวเลขหรือทศนิยมเท่านั้น
                                                    </div>
                                                @endif
                                            </td>
                                            {{-- <td style="text-align: center">
                                                <input type="checkbox">
                                            </td> --}}
                                        </tr>
                                    @endforeach


                                </table>
                            </div>
                        </div>
                        <div class="row field item form-group">
                            <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">ขั้นตอนการดำเนินการ
                                : </label>
                            <div class="col-md-6 col-sm-6">
                                <table class="table table-bordered">
                                    <tr style="text-align: center">
                                        <th>รายการกิจกรรม</th>
                                        <th>เริ่มต้น</th>
                                        <th>สิ้นสุด</th>
                                    </tr>
                                    @foreach ($data['steps'] as $item)
                                        <tr>
                                            <td> {{ $item->name }} </td>
                                            <td style="text-align: center"> {{ $item->start }}</td>
                                            <td style="text-align: center"> {{ $item->end }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                        <div class="row field item form-group">
                            <label for="title"
                                class="col-form-label col-md-3 col-sm-3  label-align">รายละเอียดความก้าวหน้า : </label>
                            <div class="col-md-6 col-sm-6">
                                @if (!empty($data['quarterReport']))
                                    @foreach ($data['detail'] as $item)
                                        {{ $item->detail }} <br>
                                    @endforeach
                                @else
                                    <textarea class="form-control" type="text" name="detail[]" id="" required></textarea>
                                @endif

                            </div>
                            {{-- @if (empty($data['quarterReport']))
                                <div class=" col-md-1 col-sm-1 m-1">
                                    <button type='button' class="btn btn-primary" onclick="insertDetail()">เพิ่ม
                                    </button>

                                </div>
                            @endif --}}

                        </div>
                        <div id="insertDetail"></div>

                        <div class="row field item form-group align-items-center">
                            <label for="title" class="col-form-label col-md-3 col-sm-3  label-align">ปัญหา/อุปสรรค :
                            </label>
                            <div class="col-md-6 col-sm-6">
                                @if (!empty($data['quarterReport']))
                                    {{ $data['quarterReport']->problem }}
                                @else
                                    <input class="form-control" type="text" name="problem" id=""
                                        data-validate-length-range="8,20" required />
                                @endif

                            </div>

                        </div>
                        <div id="insertProblem"></div>
                        <div class="col-md-6 offset-md-3 text-center">
                            @if (!empty($data['quarterReport']))
                                @if (empty($data['evaluation']))
                                    <button type="button" class="btn btn-danger"
                                        onclick="submitButton('evaluation',{{ $data['project']->proID }})">กรอกข้อมูลขอปิดโครงการ</button>
                                @endif
                            @else
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">ส่งรายงานความก้าวหน้า</button>
                                </div>

                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-1 col-sm-1"></div>
    </div>

    <script>
        const input3LV = document.getElementById('result3LV');
        const feedback3LV = input3LV.nextElementSibling;
        input3LV.addEventListener('keypress', function(e) {
            const char = String.fromCharCode(e.which);

            // ถ้าไม่ใช่ตัวเลขหรือจุด
            if (!/[0-9.]/.test(char)) {
                e.preventDefault();
                input3LV.classList.add('is-invalid');
                feedback3LV.style.display = 'block';
            }

            // ถ้าเป็นจุด แล้วมีจุดอยู่แล้วใน input
            if (char === '.' && input3LV.value.includes('.')) {
                e.preventDefault();
                input3LV.classList.add('is-invalid');
                feedback3LV.style.display = 'block';
            }
        });

        input3LV.addEventListener('input', function() {
            const value = input3LV.value;

            // ตรวจสอบว่ามีแค่จุดเดียว และเป็นรูปแบบตัวเลข/ทศนิยม
            const valid = /^(\d+(\.\d*)?)?$/.test(value);

            if (valid) {
                input3LV.classList.remove('is-invalid');
                feedback3LV.style.display = 'none';
            } else {
                input3LV.classList.add('is-invalid');
                feedback3LV.style.display = 'block';
            }
        });

        // const input2LV = document.getElementById('result2LV');
        // const feedback2LV = input2LV.nextElementSibling;
        // input2LV.addEventListener('keypress', function(e) {
        //     const char = String.fromCharCode(e.which);

        //     // ถ้าไม่ใช่ตัวเลขหรือจุด
        //     if (!/[0-9.]/.test(char)) {
        //         e.preventDefault();
        //         input2LV.classList.add('is-invalid');
        //         feedback2LV.style.display = 'block';
        //     }

        //     // ถ้าเป็นจุด แล้วมีจุดอยู่แล้วใน input
        //     if (char === '.' && input2LV.value.includes('.')) {
        //         e.preventDefault();
        //         input2LV.classList.add('is-invalid');
        //         feedback2LV.style.display = 'block';
        //     }
        // });

        // input2LV.addEventListener('input', function() {
        //     const value = input2LV.value;

        //     // ตรวจสอบว่ามีแค่จุดเดียว และเป็นรูปแบบตัวเลข/ทศนิยม
        //     const valid = /^(\d+(\.\d*)?)?$/.test(value);

        //     if (valid) {
        //         input2LV.classList.remove('is-invalid');
        //         feedback2LV.style.display = 'none';
        //     } else {
        //         input2LV.classList.add('is-invalid');
        //         feedback2LV.style.display = 'block';
        //     }
        // });

        const input = document.getElementById('result');
        const feedback = input.nextElementSibling;
        input.addEventListener('keypress', function(e) {
            const char = String.fromCharCode(e.which);

            // ถ้าไม่ใช่ตัวเลขหรือจุด
            if (!/[0-9.]/.test(char)) {
                e.preventDefault();
                input.classList.add('is-invalid');
                feedback.style.display = 'block';
            }

            // ถ้าเป็นจุด แล้วมีจุดอยู่แล้วใน input
            if (char === '.' && input.value.includes('.')) {
                e.preventDefault();
                input.classList.add('is-invalid');
                feedback.style.display = 'block';
            }
        });

        input.addEventListener('input', function() {
            const value = input.value;

            // ตรวจสอบว่ามีแค่จุดเดียว และเป็นรูปแบบตัวเลข/ทศนิยม
            const valid = /^(\d+(\.\d*)?)?$/.test(value);

            if (valid) {
                input.classList.remove('is-invalid');
                feedback.style.display = 'none';
            } else {
                input.classList.add('is-invalid');
                feedback.style.display = 'block';
            }
        });

        function submitButton(action, proID) {
            var form = document.getElementById('actionForm');
            if (action === 'evaluation') {
                form.action = "/projectEvaluation/" + proID;
            }
            form.submit();
        }
    </script>
@endsection
