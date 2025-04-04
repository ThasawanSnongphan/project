@extends('layout')
@section('title', 'ผลการดำเนินงาน')
@section('content')
    <div class="row">
        <div class="col-md-1 col-sm-1"></div>

        <div class="col-md-10 col-sm-10">
            {{-- <div class="field item form-group ">
                <label class="col-form-label col-md-1 col-sm-1 " for="heard">ปีงบประมาณ*</label>
                <div class="col-md-2 col-sm-2 m-2 ">
                    <select name="year" id="yearID" class="form-control">
                        @foreach ($data['year'] as $year)
                            <option value="{{ $year->yearID }}" data-year="{{ $year->year }}">
                                {{ $year->year }}</option>
                        @endforeach
                    </select>
                </div>
            </div> --}}
            <form action="/Performance" id="actionForm">
                <div class="row field item form-group ">
                    <label for="title" class="col-form-label col-md-1 col-sm-1 label-align">ปีงบประมาณ<span
                            class="required">*</span></label>
                    <div class="col-md-3 col-sm-3">
                        <select id="yearID" name="yearID" class="form-control" required 
                        {{-- onchange="submitForm()" --}}
                        >
                            <option value="">--เลือกปีงบประมาณ--</option>
                            @foreach ($data['yearAll'] as $item)
                                <option value="{{ $item->yearID }}"
                                    {{ request('yearID') == $item->yearID ? 'selected' : '' }}>{{ $item->year }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row field item form-group ">
                    <label for="title" class="col-form-label col-md-1 col-sm-1 label-align">ไตรมาส<span
                            class="required">*</span></label>
                    <div class="col-md-3 col-sm-3">
                        <select id="quarID" name="quarID" class="form-control" required 
                        {{-- onchange="submitForm()" --}}
                        >
                            <option value="">--เลือกไตรมาส--</option>
                            @foreach ($data['quarterAll'] as $item)
                                <option value="{{ $item->quarID }}"
                                    {{ request('quarID') == $item->quarID ? 'selected' : '' }}>{{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row field item form-group ">
                    <label for="title" class="col-form-label col-md-1 col-sm-1 label-align"></label>
                    <div class="col-md-3 col-sm-3">
                        <button class="btn btn-primary" type="submit">serch</button>
                    </div>
                </div>
                
            </form>

            @if (!empty($data['selectYearID']) && !empty($data['selectQuarID']))


                <h4 style="text-align: center">รายงานผลการดำเนินงานโครงการตามแผนปฏิบัติการ และโครงการนอกแผนปฏิบัติการ
                    ประจำปีงบประมาณ พ.ศ. {{ $data['year']->year }} </h4>
                <h6 style="text-align: center">ข้อมูลจากระบบ ... ณ {{ now() }}</h6> <br>

                <div class="d-flex justify-content-center" style="text-align: center">
                    <div class="card border-secondary mb-3" style="width: 33%;">
                        <div class="card-header">
                            <h4>โครงการทั้งหมด</h4>
                        </div>
                        <div class="card-body text-secondary">
                            <h5 class="card-title">{{ $data['projectCountAll'] }}</h5>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <p class="card-text" style="text-align: left">ปิดโครงการ/เสร็จตามระยะเวลา</p>
                                <p class="card-text" style="text-align: right">{{ $data['projectEvaCompleteAll'] }}</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="card-text" style="text-align: left">ปิดโครงการ/ไม่เป็นไปตามระยาเวลา</p>
                                <p class="card-text" style="text-align: right"> {{ $data['projectEvaDeadlineAll'] }}
                                </p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="card-text" style="text-align: left">ปิดโครงการ/ขอเลื่อน</p>
                                <p class="card-text" style="text-align: right"> {{ $data['projectEvaPostponedAll'] }}
                                </p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="card-text" style="text-align: left">ปิดโครงการ/ขอยกเลิก</p>
                                <p class="card-text" style="text-align: right"> {{ $data['projectEvaCancleAll'] }} </p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="card-text" style="text-align: left">อยู่ระหว่างดำเนินการ</p>
                                <p class="card-text" style="text-align: right"> {{ $data['report_quarterCountAll'] }}
                                </p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="card-text" style="text-align: left">ยังไม่รายงานผล</p>
                                <p class="card-text" style="text-align: right">{{ $data['no_ReportAll'] }} </p>
                            </div>
                        </div>
                    </div>


                    <div class="card border-secondary mb-3" style="width: 33%;">
                        <div class="card-header">
                            <h4>โครงการตามแผนปฏิบัติการ</h4>
                        </div>
                        <div class="card-body text-secondary">
                            <h5 class="card-title"><a href="">{{ $data['projectCountInPlan'] }}</a> </h5>
                            <hr>

                            <form action="/Performance" id="projectEvaCompleteInPlan">
                                <input type="hidden" name="yearID" value="{{ request('yearID') }}">
                                <input type="hidden" name="projectEvaCompleteInPlan"
                                    value="{{ $data['projectEvaCompleteInPlan'] }}">
                                <div class="d-flex justify-content-between">
                                    <p class="card-text" style="text-align: left">ปิดโครงการ/เสร็จตามระยะเวลา</p>
                                    <p class="card-text" style="text-align: right"><a href="#"
                                            onclick="projectEvaCompleteInPlan()">{{ $data['projectEvaCompleteInPlanCount'] }}</a>
                                    </p>
                                </div>
                            </form>
                            <div class="d-flex justify-content-between">
                                <p class="card-text" style="text-align: left">ปิดโครงการ/ไม่เป็นไปตามระยาเวลา</p>
                                <p class="card-text" style="text-align: right"><a href="">
                                        {{ $data['projectEvaDeadlineInPlan'] }}</a> </p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="card-text" style="text-align: left">ปิดโครงการ/ขอเลื่อน</p>
                                <p class="card-text" style="text-align: right"><a href="">
                                        {{ $data['projectEvaPostponedInPlan'] }}</a> </p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="card-text" style="text-align: left">ปิดโครงการ/ขอยกเลิก</p>
                                <p class="card-text" style="text-align: right"> <a
                                        href="">{{ $data['projectEvaCancleInPlan'] }} </a></p>
                            </div>

                            <form action="/Performance" id="submit">
                                <input type="hidden" name="yearID" value="{{ request('yearID') }}">
                                <div class="d-flex justify-content-between">
                                    <p class="card-text" style="text-align: left">อยู่ระหว่างดำเนินการ</p>
                                    <input type="hidden" id="input"
                                        name="detail_report_quar"value="{{ $data['report_quarteInPlan']->pluck('proID') }}">
                                    <p class="card-text" style="text-align: right"><a href="#" onclick="submit()">
                                            {{ $data['report_quarterCountInPlan'] }}</a> </p>
                                </div>
                            </form>

                            <div class="d-flex justify-content-between">
                                <p class="card-text" style="text-align: left">ยังไม่รายงานผล</p>
                                <p class="card-text" style="text-align: right"><a href="">
                                        {{ $data['no_ReportInPlan'] }}</a> </p>
                            </div>

                        </div>
                    </div>

                    <div class="card border-secondary mb-3" style="width: 33%;">
                        <div class="card-header">
                            <h4>โครงการนอกแผนปฏิบัติการ</h4>
                        </div>
                        <div class="card-body text-secondary">
                            <h5 class="card-title">{{ $data['projectCountOutPlan'] }}</h5>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <p class="card-text" style="text-align: left">ปิดโครงการ/เสร็จตามระยะเวลา</p>
                                <p class="card-text" style="text-align: right"><a
                                        href="">{{ $data['projectEvaCompleteOutPlan'] }}</a></p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="card-text" style="text-align: left">ปิดโครงการ/ไม่เป็นไปตามระยาเวลา</p>
                                <p class="card-text" style="text-align: right"><a
                                        href="">{{ $data['projectEvaDeadlineOutPlan'] }} </a></p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="card-text" style="text-align: left">ปิดโครงการ/ขอเลื่อน</p>
                                <p class="card-text" style="text-align: right"><a
                                        href="">{{ $data['projectEvaPostponedOutPlan'] }}</a> </p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="card-text" style="text-align: left">ปิดโครงการ/ขอยกเลิก</p>
                                <p class="card-text" style="text-align: right"><a
                                        href="">{{ $data['projectEvaCancleOutPlan'] }}</a></p>
                            </div>
                            <div class="d-flex justify-content-between">
                                {{-- นับจากที่กรอกรายงานไตรมาส --}}
                                <p class="card-text" style="text-align: left">อยู่ระหว่างดำเนินการ</p>
                                <p class="card-text" style="text-align: right"><a
                                        href="">{{ $data['report_quarterCountOutPlan'] }} </a></p>
                            </div>
                            <div class="d-flex justify-content-between">
                                {{-- นับจากรายงานรายไตรมาส --}}
                                <p class="card-text" style="text-align: left">ยังไม่รายงานผล</p>
                                <p class="card-text" style="text-align: right"><a
                                        href="">{{ $data['no_ReportOutPlan'] }}</a></p>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div style="text-align: center">
                    <a href="#" onclick="clearTable()">Reset Data</a>
                </div>

                <table class="table mt-2" id="data">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th style="width: 25%">ชื่อโครงการ</th>
                            <th>สถานะ</th>
                            <th>งบจัดสรร</th>
                            <th>ผลใช้จ่ายเงิน</th>
                            <th>ปัญหา/อุปสรรค</th>
                            <th>ผู้รับผิดชอบโครงการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $index = 1;
                        @endphp
                        @if (!empty($data['ID_projectEvaCompleteInPlan']))
                            @foreach ($data['datail_projectEvaCompleteInPlan'] as $item)
                                <tr style="background-color: gainsboro">
                                    <td>{{ $index++ }}</td>
                                    <td>{{ $item->project->name }}</td>
                                    <td>{{ $item->project->status->name }}</td>
                                    <td>{{ $item->project->badgetTotal }}</td>
                                    <td>{{ $item->badget_use }}</td>
                                    <td>{{ $item->problem }}</td>
                                    <td>{{ $item->user->displayname }}</td>
                                </tr>
                                @foreach ($data['KPI3LV'] as $KPI3LV)
                                    @if ($item->proID == $KPI3LV->proID)
                                        <tr>
                                            <td></td>
                                            <td><u>ตัวชี้วัด</u> <br> {{ $KPI3LV->KPI->name }}</td>
                                            <td><u>หน่วยนับ</u> <br>{{ $KPI3LV->KPI->count }} </td>
                                            <td><u>เป้าหมาย</u><br>{{ $KPI3LV->KPI->target }} </td>
                                            <td><u>ผล</u> <br> {{$KPI3LV->result2}}<br></td>
                                            <td><u>สถานะตัวชี้วัด</u> <br>
                                                @if ($KPI3LV->KPI->target == $KPI3LV->result2 )
                                                    บรรลุ
                                                @else
                                                    ไม่บรรลุ
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                @foreach ($data['KPI2LV'] as $KPI2LV)
                                    @if ($item->proID == $KPI2LV->proID)
                                        <tr>
                                            <td></td>
                                            <td>{{ $KPI2LV->KPI->name }}</td>
                                            <td>{{ $KPI2LV->KPI->count }} </td>
                                            <td>{{ $KPI2LV->KPI->target }} </td>
                                            <td><u>ผล</u> <br> {{$KPI2LV->result2}}<br></td>
                                            <td><u>สถานะตัวชี้วัด</u> <br>
                                                @if ($KPI2LV->KPI->target == $KPI2LV->result2 )
                                                    บรรลุ
                                                @else
                                                    ไม่บรรลุ
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                @foreach ($data['KPIProject'] as $KPIProject)
                                    @if ($item->proID == $KPIProject->proID)
                                        <tr>
                                            <td></td>
                                            <td>{{ $KPIProject->name }}</td>
                                            <td>{{ $KPIProject->count->name }} </td>
                                            <td>{{ $KPIProject->target }} </td>
                                            <td>{{$KPIProject->result2}}<br></td>
                                            <td>
                                                @if ($KPIProject->target == $KPIProject->result2 )
                                                    บรรลุ
                                                @else
                                                    ไม่บรรลุ
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endforeach

                        @endif
                        @if (!empty($data['ID_report_quarteInPlan']))
                            @foreach ($data['detail_report_quarteInPlan'] as $item)
                                <tr style="background-color: gainsboro">
                                    <td>{{ $index++ }}</td>
                                    <td>{{ $item->project->name }}</td>
                                    <td>{{ $item->project->status->name }}</td>
                                    <td>{{ $item->project->badgetTotal }}</td>
                                    <td>{{ $item->costResult }}</td>
                                    <td>{{ $item->problem }}</td>
                                    <td>{{ $item->user->displayname }}</td>
                                </tr>
                                @foreach ($data['KPI3LV'] as $KPI3LV)
                                    @if ($item->proID == $KPI3LV->proID)
                                        <tr>
                                            <td></td>
                                            <td><u>ตัวชี้วัด</u> <br> {{ $KPI3LV->KPI->name }}</td>
                                            <td><u>หน่วยนับ</u> <br>{{ $KPI3LV->KPI->count }} </td>
                                            <td><u>เป้าหมาย</u><br>{{ $KPI3LV->KPI->target }} </td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    @endif
                                @endforeach
                                @foreach ($data['KPI2LV'] as $KPI2LV)
                                    @if ($item->proID == $KPI2LV->proID)
                                        <tr>
                                            <td></td>
                                            <td>{{ $KPI2LV->KPI->name }}</td>
                                            <td>{{ $KPI2LV->KPI->count }} </td>
                                            <td>{{ $KPI2LV->KPI->target }} </td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    @endif
                                @endforeach
                                @foreach ($data['KPIProject'] as $KPIProject)
                                    @if ($item->proID == $KPIProject->proID)
                                        <tr>
                                            <td></td>
                                            <td>{{ $KPIProject->name }}</td>
                                            <td>{{ $KPIProject->count->name }} </td>
                                            <td>{{ $KPIProject->target }} </td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endforeach
                        @endif
                    </tbody>

                </table>



                {{-- <table id="example" class="display">
                    <thead>
                        <tr>
                            <td>#</td>
                            <td>ชื่อโครงการ</td>
                            <td>สถานะ</td>
                            <td>งบจัดสรร</td>
                            <td>ผลใช้จ่ายเงิน</td>
                            <td>ปัญหา/อุปสรรค</td>
                            <td>ผู้รับผิดชอบโครงการ</td>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $index = 1;
                        @endphp
                        @if (!empty($data['ID_report_quarteInPlan']))
                            @foreach ($data['detail_report_quarteInPlan'] as $item)
                                <tr>
                                    <td>{{ $index++ }}</td>
                                    <td>{{ $item->project->name }} <br>
                                        @foreach ($data['KPI3LV'] as $KPI3LV)
                                            @if ($item->proID == $KPI3LV->proID)
                                                {{ $KPI3LV->KPI->name }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>{{ $item->project->status->name }} <br>
                                        @foreach ($data['KPI3LV'] as $KPI3LV)
                                            @if ($item->proID == $KPI3LV->proID)
                                                {{ $KPI3LV->KPI->count }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>{{ $item->project->badgetTotal }} <br>
                                        @foreach ($data['KPI3LV'] as $KPI3LV)
                                            @if ($item->proID == $KPI3LV->proID)
                                                {{ $KPI3LV->KPI->target }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>{{ $item->costResult }} <br>
                                    </td>
                                    <td>{{ $item->problem }} <br>
                                    </td>
                                    <td>{{ $item->user->displayname }}
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                    </tbody>
                </table> --}}
            @endif
        </div>
        <div class="col-md-1 col-sm-1"></div>
    </div>
    <script>
        function submitForm() {

            document.getElementById('actionForm').submit();

        }

        function projectEvaCompleteInPlan() {

            document.getElementById('projectEvaCompleteInPlan').submit();

        }

        function submit() {

            document.getElementById('submit').submit();

        }

        function clearTable() {
            document.querySelector("#data tbody").innerHTML = "";
        }


        // window.onload = function() {
        //     const year = document.getElementById('yearID');
        //     const defaultYear = year.value;
        //     var displayYear = document.getElementById('displayYear')
        //     displayYear.textContent = defaultYear;
        //     year.addEventListener('change', function() {
        //         const selectYear = this.value;
        //         displayYear.textContent = selectYear;
        //     }); 
        // }
    </script>
@endsection
