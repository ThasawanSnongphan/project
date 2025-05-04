@extends('layout')
@section('title', 'ผลการดำเนินงาน')
@section('content')
    <div class="main_container">
        <div role="main">
            <div class="row">

                <div class="col-md-12 col-sm-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>โครงการประจำปี</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <form action="/Performance" id="actionForm">
                                {{-- <div class="d-flex justify-content-around"> --}}
                                <div class=" field item form-group ">
                                    <label class="col-form-label col-md-1 col-sm-1">ปีงบประมาณ*</label>
                                    <div class="col-md-2 col-sm-2 m-2 ">
                                        <select id="yearID" name="yearID" class="form-control" required
                                            {{-- onchange="submitForm()" --}}>
                                            <option value="">--เลือกปีงบประมาณ--</option>
                                            @foreach ($data['yearAll'] as $item)
                                                <option value="{{ $item->yearID }}"
                                                    {{ request('yearID') == $item->yearID ? 'selected' : '' }}>
                                                    {{ $item->year }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <label class="col-form-label col-md-1 col-sm-1">ไตรมาส*</label>
                                    <div class="col-md-2 col-sm-2 m-2 ">
                                        <select id="quarID" name="quarID" class="form-control" required
                                            {{-- onchange="submitForm()" --}}>
                                            <option value="">--เลือกไตรมาส--</option>
                                            @foreach ($data['quarterAll'] as $item)
                                                <option value="{{ $item->quarID }}"
                                                    {{ request('quarID') == $item->quarID ? 'selected' : '' }}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 col-sm-3 m-2">
                                        <button class="btn btn-primary" type="submit">search</button>
                                    </div>
                                </div>


                                {{-- </div> --}}

                            </form>
                            @if (!empty($data['selectYearID']) && !empty($data['selectQuarID']))
                                <h3 style="text-align: center">รายงานผลการดำเนินงานโครงการตามแผนปฏิบัติการ
                                    และโครงการนอกแผนปฏิบัติการ
                                    ประจำปีงบประมาณ พ.ศ. {{ $data['year']->year }} ({{ $data['quarter']->name }})</h3>
                                <h6 style="text-align: center">ข้อมูลจากระบบ E-planning ณ
                                    {{ now()->setTimezone('Asia/Bangkok') }}</h6> <br>


                                <div class="row justify-content-center" style="text-align: center">
                                    <div class="col-10 col-md-3">
                                        <div class="card border-secondary ">
                                            <div class="card-header">
                                                <h4>โครงการทั้งหมด</h4>
                                            </div>
                                            <div class="card-body text-secondary">
                                                <h1 class="card-title">{{ $data['projectAll']->count() }}</h1>
                                                <hr>
                                                <div class="d-flex justify-content-between">
                                                    <p class="card-text" style="text-align: left">
                                                        ปิดโครงการ/เสร็จตามระยะเวลา
                                                    </p>
                                                    <p class="card-text" style="text-align: right">
                                                        {{ $data['projectEvaCompleteAll']->count() }}
                                                    </p>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <p class="card-text" style="text-align: left">
                                                        ปิดโครงการ/ไม่เป็นไปตามระยาเวลา</p>
                                                    <p class="card-text" style="text-align: right">
                                                        {{ $data['projectEvaDeadlineAll']->count() }}
                                                    </p>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <p class="card-text" style="text-align: left">ปิดโครงการ/ขอเลื่อน</p>
                                                    <p class="card-text" style="text-align: right">
                                                        {{ $data['projectEvaPostponedAll']->count() }}
                                                    </p>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <p class="card-text" style="text-align: left">ปิดโครงการ/ขอยกเลิก</p>
                                                    <p class="card-text" style="text-align: right">
                                                        {{ $data['projectEvaCancleAll']->count() }}
                                                    </p>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <p class="card-text" style="text-align: left">อยู่ระหว่างดำเนินการ</p>
                                                    <p class="card-text" style="text-align: right">
                                                        {{ $data['report_quarterAll']->count() }}
                                                    </p>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <p class="card-text" style="text-align: left">ยังไม่รายงานผล</p>
                                                    <p class="card-text" style="text-align: right">
                                                        {{ $data['no_ReportAll'] }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-10 col-md-3">
                                        <div class="card border-secondary">
                                            <div class="card-header">
                                                <h4>โครงการตามแผนปฏิบัติการ</h4>
                                            </div>
                                            <div class="card-body text-secondary">
                                                <h1 class="card-title"><a
                                                        href="#">{{ $data['projectInPlanAll']->count() }}</a>
                                                </h1>
                                                <hr>

                                                <form action="/Performance" id="projectEvaCompleteInPlan">
                                                    <input type="hidden" name="yearID" value="{{ request('yearID') }}">
                                                    <input type="hidden" name="quarID" value="{{ request('quarID') }}">
                                                    <input type="hidden" name="projectEvaCompleteInPlan"
                                                        value="{{ $data['projectEvaCompleteInPlan']->pluck('proID') }}">
                                                    <div class="d-flex justify-content-between">
                                                        <p class="card-text" style="text-align: left">
                                                            ปิดโครงการ/เสร็จตามระยะเวลา</p>
                                                        <p class="card-text" style="text-align: right"><a href="#"
                                                                onclick="projectEvaCompleteInPlan()">{{ $data['projectEvaCompleteInPlan']->count() }}</a>
                                                        </p>
                                                    </div>
                                                </form>
                                                <form action="/Performance" id="projectEvaDeadlineInPlan">
                                                    <input type="hidden" name="yearID" value="{{ request('yearID') }}">
                                                    <input type="hidden" name="quarID" value="{{ request('quarID') }}">
                                                    <input type="hidden" name="projectEvaDeadlineInPlan"
                                                        value="{{ $data['projectEvaDeadlineInPlan'] }}">
                                                    <div class="d-flex justify-content-between">
                                                        <p class="card-text" style="text-align: left">
                                                            ปิดโครงการ/ไม่เป็นไปตามระยาเวลา</p>
                                                        <p class="card-text" style="text-align: right"><a href="#"
                                                                onclick="projectEvaDeadlineInPlan()">
                                                                {{ $data['projectEvaDeadlineInPlan']->count() }}</a> </p>
                                                    </div>
                                                </form>
                                                <form action="/Performance" id="projectEvaPostponedInPlan">
                                                    <input type="hidden" name="yearID"
                                                        value="{{ request('yearID') }}">
                                                    <input type="hidden" name="quarID"
                                                        value="{{ request('quarID') }}">
                                                    <input type="hidden" name="projectEvaPostponedInPlan"
                                                        value="{{ $data['projectEvaPostponedInPlan']->pluck('proID') }}">
                                                    <div class="d-flex justify-content-between">
                                                        <p class="card-text" style="text-align: left">ปิดโครงการ/ขอเลื่อน
                                                        </p>
                                                        <p class="card-text" style="text-align: right"><a href="#"
                                                                onclick="projectEvaPostponedInPlan()">
                                                                {{ $data['projectEvaPostponedInPlan']->count() }}</a> </p>
                                                    </div>
                                                </form>
                                                <form action="/Performance" id="projectEvaCancleInPlan">
                                                    <input type="hidden" name="yearID"
                                                        value="{{ request('yearID') }}">
                                                    <input type="hidden" name="quarID"
                                                        value="{{ request('quarID') }}">
                                                    <input type="hidden" name="projectEvaCancleInPlan"
                                                        value="{{ $data['projectEvaCancleInPlan']->pluck('proID') }}">
                                                    <div class="d-flex justify-content-between">
                                                        <p class="card-text" style="text-align: left">ปิดโครงการ/ขอยกเลิก
                                                        </p>
                                                        <p class="card-text" style="text-align: right"> <a href="#"
                                                                onclick="projectEvaCancleInPlan()">{{ $data['projectEvaCancleInPlan']->count() }}
                                                            </a></p>
                                                    </div>
                                                </form>

                                                <form action="/Performance" id="report_quarteInPlan">
                                                    <input type="hidden" name="yearID"
                                                        value="{{ request('yearID') }}">
                                                    <input type="hidden" name="quarID"
                                                        value="{{ request('quarID') }}">
                                                    <div class="d-flex justify-content-between">
                                                        <p class="card-text" style="text-align: left">อยู่ระหว่างดำเนินการ
                                                        </p>
                                                        <input type="hidden" id="input"
                                                            name="detail_report_quar"value="{{ $data['report_quarteInPlan']->pluck('proID') }}">
                                                        <p class="card-text" style="text-align: right"><a href="#"
                                                                onclick="report_quarteInPlan()">
                                                                {{ $data['report_quarteInPlan']->count() }}</a> </p>
                                                    </div>
                                                </form>
                                                <form action="/Performance" id="no_ReportInPlan">
                                                    <input type="hidden" name="yearID"
                                                        value="{{ request('yearID') }}">
                                                    <input type="hidden" name="quarID"
                                                        value="{{ request('quarID') }}">
                                                    <input type="hidden" name="no_ReportInPlan"
                                                        value="{{ $data['proIDInPlan'] }}">
                                                    <div class="d-flex justify-content-between">
                                                        <p class="card-text" style="text-align: left">ยังไม่รายงานผล</p>
                                                        <p class="card-text" style="text-align: right"><a href="#"
                                                                onclick="no_ReportInPlan()">
                                                                {{ $data['no_ReportInPlan'] }}</a> </p>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-10 col-md-3 mb-3">
                                        <div class="card border-secondary">
                                            <div class="card-header">
                                                <h4>โครงการนอกแผนปฏิบัติการ</h4>
                                            </div>
                                            <div class="card-body text-secondary">
                                                <h1 class="card-title">{{ $data['projectOutPlanAll']->count() }}</h1>
                                                <hr>
                                                <form action="/Performance" id="projectEvaCompleteOutPlan">
                                                    <input type="hidden" name="yearID"
                                                        value="{{ request('yearID') }}">
                                                    <input type="hidden" name="quarID"
                                                        value="{{ request('quarID') }}">
                                                    <input type="hidden" name="projectEvaCompleteOutPlan"
                                                        value="{{ $data['projectEvaCompleteOutPlan']->pluck('proID') }}">
                                                    <div class="d-flex justify-content-between">
                                                        <p class="card-text" style="text-align: left">
                                                            ปิดโครงการ/เสร็จตามระยะเวลา
                                                        </p>
                                                        <p class="card-text" style="text-align: right"><a href="#"
                                                                onclick="projectEvaCompleteOutPlan()">{{ $data['projectEvaCompleteOutPlan']->count() }}</a>
                                                        </p>
                                                    </div>
                                                </form>
                                                <form action="/Performance" id="projectEvaDeadlineOutPlan">
                                                    <input type="hidden" name="yearID"
                                                        value="{{ request('yearID') }}">
                                                    <input type="hidden" name="quarID"
                                                        value="{{ request('quarID') }}">
                                                    <input type="hidden" name="projectEvaDeadlineOutPlan"
                                                        value="{{ $data['projectEvaDeadlineOutPlan']->pluck('proID') }}">
                                                    <div class="d-flex justify-content-between">
                                                        <p class="card-text" style="text-align: left">
                                                            ปิดโครงการ/ไม่เป็นไปตามระยาเวลา</p>
                                                        <p class="card-text" style="text-align: right"><a
                                                                href="#"onclick="projectEvaDeadlineOutPlan()">{{ $data['projectEvaDeadlineOutPlan']->count() }}
                                                            </a></p>
                                                    </div>
                                                </form>
                                                <form action="/Performance" id="projectEvaPostponedOutPlan">
                                                    <input type="hidden" name="yearID"
                                                        value="{{ request('yearID') }}">
                                                    <input type="hidden" name="quarID"
                                                        value="{{ request('quarID') }}">
                                                    <input type="hidden" name="projectEvaPostponedOutPlan"
                                                        value="{{ $data['projectEvaPostponedOutPlan']->pluck('proID') }}">
                                                    <div class="d-flex justify-content-between">
                                                        <p class="card-text" style="text-align: left">ปิดโครงการ/ขอเลื่อน
                                                        </p>
                                                        <p class="card-text" style="text-align: right"><a
                                                                href="#" onclick="projectEvaPostponedOutPlan()">{{ $data['projectEvaPostponedOutPlan']->count() }}</a>
                                                        </p>
                                                    </div>
                                                </form>
                                                <form action="/Performance" id="projectEvaCancleOutPlan">
                                                    <input type="hidden" name="yearID"
                                                        value="{{ request('yearID') }}">
                                                    <input type="hidden" name="quarID"
                                                        value="{{ request('quarID') }}">
                                                    <input type="hidden" name="projectEvaCancleOutPlan"
                                                        value="{{ $data['projectEvaCancleOutPlan']->pluck('proID') }}">
                                                    <div class="d-flex justify-content-between">
                                                        <p class="card-text" style="text-align: left">ปิดโครงการ/ขอยกเลิก
                                                        </p>
                                                        <p class="card-text" style="text-align: right"><a
                                                                href="#" onclick="projectEvaCancleOutPlan()">{{ $data['projectEvaCancleOutPlan']->count() }}</a>
                                                        </p>
                                                    </div>
                                                </form>
                                                <form action="/Performance" id="report_quarteOutPlan">
                                                    <input type="hidden" name="yearID"
                                                        value="{{ request('yearID') }}">
                                                    <input type="hidden" name="quarID"
                                                        value="{{ request('quarID') }}">
                                                    <input type="hidden" name="report_quarteOutPlan"
                                                        value="{{ $data['report_quarteOutPlan']->pluck('proID') }}">
                                                    <div class="d-flex justify-content-between">
                                                        {{-- นับจากที่กรอกรายงานไตรมาส --}}
                                                        <p class="card-text" style="text-align: left">อยู่ระหว่างดำเนินการ
                                                        </p>
                                                        <p class="card-text" style="text-align: right"><a
                                                                href="#" onclick="report_quarteOutPlan()">{{ $data['report_quarteOutPlan']->count() }}
                                                            </a>
                                                        </p>
                                                    </div>
                                                </form>
                                                <form action="/Performance" id="no_ReportOutPlan">
                                                    <input type="hidden" name="yearID"
                                                        value="{{ request('yearID') }}">
                                                    <input type="hidden" name="quarID"
                                                        value="{{ request('quarID') }}">
                                                    <input type="hidden" name="no_ReportOutPlan"
                                                        value="{{ $data['proIDOutPlan'] }}">
                                                    <div class="d-flex justify-content-between">
                                                        {{-- นับจากรายงานรายไตรมาส --}}
                                                        <p class="card-text" style="text-align: left">ยังไม่รายงานผล</p>
                                                        <p class="card-text" style="text-align: right"><a
                                                                href="#" onclick="no_ReportOutPlan()">{{ $data['no_ReportOutPlan'] }}</a></p>
                                                    </div>
                                                </form>
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

                                        {{-- แสดงข้อมูลโครงการตามแผนเสร็จตามระยะเวลา --}}
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
                                                        @php
                                                            $quarter1 = false;
                                                            $quarter2 = false;
                                                            $quarter3 = false;
                                                            $quarter4 = false;
                                                            foreach ($data['report'] as $report) {
                                                                if ($report->quarID == 4) {
                                                                    $quarter4 = true;
                                                                    break;
                                                                } elseif ($report->quarID == 3) {
                                                                    $quarter3 = true;
                                                                    break;
                                                                } elseif ($report->quarID == 2) {
                                                                    $quarter2 = true;
                                                                    break;
                                                                } else {
                                                                    $quarter1 = true;
                                                                    break;
                                                                }
                                                            }
                                                        @endphp
                                                        <tr>
                                                            <td></td>
                                                            <td><u>ตัวชี้วัด</u> <br> {{ $KPI3LV->KPI->name }}</td>
                                                            <td><u>หน่วยนับ</u> <br>{{ $KPI3LV->KPI->count }} </td>
                                                            <td><u>เป้าหมาย</u><br>{{ $KPI3LV->KPI->target }} </td>
                                                            <td><u>ผล</u> <br>
                                                                @if (request('quarID') == 1)
                                                                    {{ $KPI3LV->result1 }}
                                                                @elseif(request('quarID') == 2)
                                                                    @if ($quarter2)
                                                                        {{ $KPI3LV->result2 }}
                                                                    @else
                                                                        {{ $KPI3LV->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 3)
                                                                    @if ($quarter3)
                                                                        {{ $KPI3LV->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPI3LV->result2 }}
                                                                    @else
                                                                        {{ $KPI3LV->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 4)
                                                                    @if ($quarter4)
                                                                        {{ $KPI4LV->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPI3LV->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPI3LV->result2 }}
                                                                    @else
                                                                        {{ $KPI3LV->result1 }}
                                                                    @endif
                                                                @endif
                                                                <br>
                                                            </td>
                                                            <td><u>สถานะตัวชี้วัด</u> <br>
                                                                @if ($quarter4)
                                                                    @if ($KPI3LV->KPI->target <= $KPI3LV->result4)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @elseif($quarter3)
                                                                    @if ($KPI3LV->KPI->target <= $KPI3LV->result3)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @elseif($quarter2)
                                                                    @if ($KPI3LV->KPI->target <= $KPI3LV->result2)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @else
                                                                    @if ($KPI3LV->KPI->target <= $KPI3LV->result1)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
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
                                                            <td><u>ผล</u>
                                                                <br>
                                                                @if (request('quarID') == 1)
                                                                    {{ $KPI2LV->result1 }}
                                                                @elseif(request('quarID') == 2)
                                                                    @if ($quarter2)
                                                                        {{ $KPI2LV->result2 }}
                                                                    @else
                                                                        {{ $KPI2LV->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 3)
                                                                    @if ($quarter3)
                                                                        {{ $KPI2LV->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPI2LV->result2 }}
                                                                    @else
                                                                        {{ $KPI2LV->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 4)
                                                                    @if ($quarter4)
                                                                        {{ $KPI2LV->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPI2LV->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPI2LV->result2 }}
                                                                    @else
                                                                        {{ $KPI2LV->result1 }}
                                                                    @endif
                                                                @endif
                                                                <br>
                                                            </td>
                                                            <td><u>สถานะตัวชี้วัด</u> <br>
                                                                @if ($quarter4)
                                                                    @if ($KPI2LV->KPI->target <= $KPI2LV->result4)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @elseif($quarter3)
                                                                    @if ($KPI2LV->KPI->target <= $KPI2LV->result3)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @elseif($quarter2)
                                                                    @if ($KPI2LV->KPI->target <= $KPI2LV->result2)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @else
                                                                    @if ($KPI2LV->KPI->target <= $KPI2LV->result1)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
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
                                                            <td>
                                                                @if (request('quarID') == 1)
                                                                    {{ $KPIProject->result1 }}
                                                                @elseif(request('quarID') == 2)
                                                                    @if ($quarter2)
                                                                        {{ $KPIProject->result2 }}
                                                                    @else
                                                                        {{ $KPIProject->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 3)
                                                                    @if ($quarter3)
                                                                        {{ $KPIProject->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPIProject->result2 }}
                                                                    @else
                                                                        {{ $KPIProject->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 4)
                                                                    @if ($quarter4)
                                                                        {{ $KPIProject->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPIProject->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPIProject->result2 }}
                                                                    @else
                                                                        {{ $KPIProject->result1 }}
                                                                    @endif
                                                                @endif
                                                                <br>
                                                            </td>
                                                            <td>
                                                                @if ($quarter4)
                                                                    @if ($KPIProject->target <= $KPIProject->result4)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @elseif($quarter3)
                                                                    @if ($KPIProject->target <= $KPIProject->result3)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @elseif($quarter2)
                                                                    @if ($KPIProject->target <= $KPIProject->result2)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @else
                                                                    @if ($KPIProject->target <= $KPIProject->result1)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        @endif
                                        {{-- ไม่เป็นไปตามระยะเวลา --}}
                                        @if (!empty($data['ID_projectEvaDeadlineInPlan']))
                                            @foreach ($data['datail_projectEvaDeadlineInPlan'] as $item)
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
                                                        @php
                                                            $quarter1 = false;
                                                            $quarter2 = false;
                                                            $quarter3 = false;
                                                            $quarter4 = false;
                                                            foreach ($data['report'] as $report) {
                                                                if ($report->quarID == 4) {
                                                                    $quarter4 = true;
                                                                    break;
                                                                } elseif ($report->quarID == 3) {
                                                                    $quarter3 = true;
                                                                    break;
                                                                } elseif ($report->quarID == 2) {
                                                                    $quarter2 = true;
                                                                    break;
                                                                } else {
                                                                    $quarter1 = true;
                                                                    break;
                                                                }
                                                            }
                                                        @endphp
                                                        <tr>
                                                            <td></td>
                                                            <td><u>ตัวชี้วัด</u> <br> {{ $KPI3LV->KPI->name }}</td>
                                                            <td><u>หน่วยนับ</u> <br>{{ $KPI3LV->KPI->count }} </td>
                                                            <td><u>เป้าหมาย</u><br>{{ $KPI3LV->KPI->target }} </td>
                                                            <td><u>ผล</u> <br>
                                                                @if (request('quarID') == 1)
                                                                    {{ $KPI3LV->result1 }}
                                                                @elseif(request('quarID') == 2)
                                                                    @if ($quarter2)
                                                                        {{ $KPI3LV->result2 }}
                                                                    @else
                                                                        {{ $KPI3LV->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 3)
                                                                    @if ($quarter3)
                                                                        {{ $KPI3LV->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPI3LV->result2 }}
                                                                    @else
                                                                        {{ $KPI3LV->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 4)
                                                                    @if ($quarter4)
                                                                        {{ $KPI4LV->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPI3LV->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPI3LV->result2 }}
                                                                    @else
                                                                        {{ $KPI3LV->result1 }}
                                                                    @endif
                                                                @endif
                                                                <br>
                                                            </td>
                                                            <td><u>สถานะตัวชี้วัด</u> <br>
                                                                @if ($quarter4)
                                                                    @if ($KPIProject->target <= $KPIProject->result4)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @elseif($quarter3)
                                                                    @if ($KPIProject->target <= $KPIProject->result3)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @elseif($quarter2)
                                                                    @if ($KPIProject->target <= $KPIProject->result2)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @else
                                                                    @if ($KPIProject->target <= $KPIProject->result1)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
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
                                                            <td><u>ผล</u>
                                                                <br>
                                                                @if (request('quarID') == 1)
                                                                    {{ $KPI2LV->result1 }}
                                                                @elseif(request('quarID') == 2)
                                                                    @if ($quarter2)
                                                                        {{ $KPI2LV->result2 }}
                                                                    @else
                                                                        {{ $KPI2LV->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 3)
                                                                    @if ($quarter3)
                                                                        {{ $KPI2LV->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPI2LV->result2 }}
                                                                    @else
                                                                        {{ $KPI2LV->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 4)
                                                                    @if ($quarter4)
                                                                        {{ $KPI2LV->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPI2LV->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPI2LV->result2 }}
                                                                    @else
                                                                        {{ $KPI2LV->result1 }}
                                                                    @endif
                                                                @endif
                                                                <br>
                                                            </td>
                                                            <td><u>สถานะตัวชี้วัด</u> <br>
                                                                @if ($quarter4)
                                                                    @if ($KPIProject->target <= $KPIProject->result4)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @elseif($quarter3)
                                                                    @if ($KPIProject->target <= $KPIProject->result3)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @elseif($quarter2)
                                                                    @if ($KPIProject->target <= $KPIProject->result2)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @else
                                                                    @if ($KPIProject->target <= $KPIProject->result1)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
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
                                                            <td>
                                                                @if (request('quarID') == 1)
                                                                    {{ $KPIProject->result1 }}
                                                                @elseif(request('quarID') == 2)
                                                                    @if ($quarter2)
                                                                        {{ $KPIProject->result2 }}
                                                                    @else
                                                                        {{ $KPIProject->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 3)
                                                                    @if ($quarter3)
                                                                        {{ $KPIProject->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPIProject->result2 }}
                                                                    @else
                                                                        {{ $KPIProject->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 4)
                                                                    @if ($quarter4)
                                                                        {{ $KPIProject->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPIProject->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPIProject->result2 }}
                                                                    @else
                                                                        {{ $KPIProject->result1 }}
                                                                    @endif
                                                                @endif
                                                                <br>
                                                            </td>
                                                            <td>
                                                                @if ($quarter4)
                                                                    @if ($KPIProject->target <= $KPIProject->result4)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @elseif($quarter3)
                                                                    @if ($KPIProject->target <= $KPIProject->result3)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @elseif($quarter2)
                                                                    @if ($KPIProject->target <= $KPIProject->result2)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @else
                                                                    @if ($KPIProject->target <= $KPIProject->result1)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        @endif
                                        {{-- ขอเลื่อน --}}
                                        @if (!empty($data['ID_projectEvaPostponedInPlan']))
                                            @foreach ($data['ID_projectEvaPostponedInPlan'] as $item)
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
                                                        @php
                                                            $quarter1 = false;
                                                            $quarter2 = false;
                                                            $quarter3 = false;
                                                            $quarter4 = false;
                                                            foreach ($data['report'] as $report) {
                                                                if ($report->quarID == 4) {
                                                                    $quarter4 = true;
                                                                    break;
                                                                } elseif ($report->quarID == 3) {
                                                                    $quarter3 = true;
                                                                    break;
                                                                } elseif ($report->quarID == 2) {
                                                                    $quarter2 = true;
                                                                    break;
                                                                } else {
                                                                    $quarter1 = true;
                                                                    break;
                                                                }
                                                            }
                                                        @endphp
                                                        <tr>
                                                            <td></td>
                                                            <td><u>ตัวชี้วัด</u> <br> {{ $KPI3LV->KPI->name }}</td>
                                                            <td><u>หน่วยนับ</u> <br>{{ $KPI3LV->KPI->count }} </td>
                                                            <td><u>เป้าหมาย</u><br>{{ $KPI3LV->KPI->target }} </td>
                                                            <td><u>ผล</u> <br>
                                                                @if (request('quarID') == 1)
                                                                    {{ $KPI3LV->result1 }}
                                                                @elseif(request('quarID') == 2)
                                                                    @if ($quarter2)
                                                                        {{ $KPI3LV->result2 }}
                                                                    @else
                                                                        {{ $KPI3LV->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 3)
                                                                    @if ($quarter3)
                                                                        {{ $KPI3LV->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPI3LV->result2 }}
                                                                    @else
                                                                        {{ $KPI3LV->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 4)
                                                                    @if ($quarter4)
                                                                        {{ $KPI4LV->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPI3LV->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPI3LV->result2 }}
                                                                    @else
                                                                        {{ $KPI3LV->result1 }}
                                                                    @endif
                                                                @endif
                                                                <br>
                                                            </td>
                                                            <td><u>สถานะตัวชี้วัด</u> <br>
                                                                @if ($quarter4)
                                                                    @if ($KPIProject->target <= $KPIProject->result4)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @elseif($quarter3)
                                                                    @if ($KPIProject->target <= $KPIProject->result3)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @elseif($quarter2)
                                                                    @if ($KPIProject->target <= $KPIProject->result2)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @else
                                                                    @if ($KPIProject->target <= $KPIProject->result1)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
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
                                                            <td><u>ผล</u>
                                                                <br>
                                                                @if (request('quarID') == 1)
                                                                    {{ $KPI2LV->result1 }}
                                                                @elseif(request('quarID') == 2)
                                                                    @if ($quarter2)
                                                                        {{ $KPI2LV->result2 }}
                                                                    @else
                                                                        {{ $KPI2LV->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 3)
                                                                    @if ($quarter3)
                                                                        {{ $KPI2LV->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPI2LV->result2 }}
                                                                    @else
                                                                        {{ $KPI2LV->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 4)
                                                                    @if ($quarter4)
                                                                        {{ $KPI2LV->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPI2LV->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPI2LV->result2 }}
                                                                    @else
                                                                        {{ $KPI2LV->result1 }}
                                                                    @endif
                                                                @endif
                                                                <br>
                                                            </td>
                                                            <td><u>สถานะตัวชี้วัด</u> <br>
                                                                @if ($quarter4)
                                                                    @if ($KPIProject->target <= $KPIProject->result4)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @elseif($quarter3)
                                                                    @if ($KPIProject->target <= $KPIProject->result3)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @elseif($quarter2)
                                                                    @if ($KPIProject->target <= $KPIProject->result2)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @else
                                                                    @if ($KPIProject->target <= $KPIProject->result1)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
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
                                                            <td>
                                                                @if (request('quarID') == 1)
                                                                    {{ $KPIProject->result1 }}
                                                                @elseif(request('quarID') == 2)
                                                                    @if ($quarter2)
                                                                        {{ $KPIProject->result2 }}
                                                                    @else
                                                                        {{ $KPIProject->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 3)
                                                                    @if ($quarter3)
                                                                        {{ $KPIProject->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPIProject->result2 }}
                                                                    @else
                                                                        {{ $KPIProject->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 4)
                                                                    @if ($quarter4)
                                                                        {{ $KPIProject->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPIProject->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPIProject->result2 }}
                                                                    @else
                                                                        {{ $KPIProject->result1 }}
                                                                    @endif
                                                                @endif
                                                                <br>
                                                            </td>
                                                            <td>
                                                                @if ($quarter4)
                                                                    @if ($KPIProject->target <= $KPIProject->result4)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @elseif($quarter3)
                                                                    @if ($KPIProject->target <= $KPIProject->result3)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @elseif($quarter2)
                                                                    @if ($KPIProject->target <= $KPIProject->result2)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @else
                                                                    @if ($KPIProject->target <= $KPIProject->result1)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        @endif
                                        {{-- ขอยกเลิก --}}
                                        @if (!empty($data['ID_projectEvaCancleInPlan']))
                                            @foreach ($data['datail_projectEvaCancleInPlan'] as $item)
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
                                                        @php
                                                            $quarter1 = false;
                                                            $quarter2 = false;
                                                            $quarter3 = false;
                                                            $quarter4 = false;
                                                            foreach ($data['report'] as $report) {
                                                                if ($report->quarID == 4) {
                                                                    $quarter4 = true;
                                                                    break;
                                                                } elseif ($report->quarID == 3) {
                                                                    $quarter3 = true;
                                                                    break;
                                                                } elseif ($report->quarID == 2) {
                                                                    $quarter2 = true;
                                                                    break;
                                                                } else {
                                                                    $quarter1 = true;
                                                                    break;
                                                                }
                                                            }
                                                        @endphp
                                                        <tr>
                                                            <td></td>
                                                            <td><u>ตัวชี้วัด</u> <br> {{ $KPI3LV->KPI->name }}</td>
                                                            <td><u>หน่วยนับ</u> <br>{{ $KPI3LV->KPI->count }} </td>
                                                            <td><u>เป้าหมาย</u><br>{{ $KPI3LV->KPI->target }} </td>
                                                            <td><u>ผล</u> <br>
                                                                @if (request('quarID') == 1)
                                                                    {{ $KPI3LV->result1 }}
                                                                @elseif(request('quarID') == 2)
                                                                    @if ($quarter2)
                                                                        {{ $KPI3LV->result2 }}
                                                                    @else
                                                                        {{ $KPI3LV->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 3)
                                                                    @if ($quarter3)
                                                                        {{ $KPI3LV->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPI3LV->result2 }}
                                                                    @else
                                                                        {{ $KPI3LV->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 4)
                                                                    @if ($quarter4)
                                                                        {{ $KPI4LV->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPI3LV->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPI3LV->result2 }}
                                                                    @else
                                                                        {{ $KPI3LV->result1 }}
                                                                    @endif
                                                                @endif
                                                                <br>
                                                            </td>
                                                            <td><u>สถานะตัวชี้วัด</u> <br>
                                                                @if ($quarter4)
                                                                    @if ($KPIProject->target <= $KPIProject->result4)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @elseif($quarter3)
                                                                    @if ($KPIProject->target <= $KPIProject->result3)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @elseif($quarter2)
                                                                    @if ($KPIProject->target <= $KPIProject->result2)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @else
                                                                    @if ($KPIProject->target <= $KPIProject->result1)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
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
                                                            <td><u>ผล</u>
                                                                <br>
                                                                @if (request('quarID') == 1)
                                                                    {{ $KPI2LV->result1 }}
                                                                @elseif(request('quarID') == 2)
                                                                    @if ($quarter2)
                                                                        {{ $KPI2LV->result2 }}
                                                                    @else
                                                                        {{ $KPI2LV->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 3)
                                                                    @if ($quarter3)
                                                                        {{ $KPI2LV->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPI2LV->result2 }}
                                                                    @else
                                                                        {{ $KPI2LV->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 4)
                                                                    @if ($quarter4)
                                                                        {{ $KPI2LV->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPI2LV->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPI2LV->result2 }}
                                                                    @else
                                                                        {{ $KPI2LV->result1 }}
                                                                    @endif
                                                                @endif
                                                                <br>
                                                            </td>
                                                            <td><u>สถานะตัวชี้วัด</u> <br>
                                                                @if ($quarter4)
                                                                    @if ($KPIProject->target <= $KPIProject->result4)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @elseif($quarter3)
                                                                    @if ($KPIProject->target <= $KPIProject->result3)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @elseif($quarter2)
                                                                    @if ($KPIProject->target <= $KPIProject->result2)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @else
                                                                    @if ($KPIProject->target <= $KPIProject->result1)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
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
                                                            <td>
                                                                @if (request('quarID') == 1)
                                                                    {{ $KPIProject->result1 }}
                                                                @elseif(request('quarID') == 2)
                                                                    @if ($quarter2)
                                                                        {{ $KPIProject->result2 }}
                                                                    @else
                                                                        {{ $KPIProject->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 3)
                                                                    @if ($quarter3)
                                                                        {{ $KPIProject->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPIProject->result2 }}
                                                                    @else
                                                                        {{ $KPIProject->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 4)
                                                                    @if ($quarter4)
                                                                        {{ $KPIProject->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPIProject->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPIProject->result2 }}
                                                                    @else
                                                                        {{ $KPIProject->result1 }}
                                                                    @endif
                                                                @endif
                                                                <br>
                                                            </td>
                                                            <td>
                                                                @if ($quarter4)
                                                                    @if ($KPIProject->target <= $KPIProject->result4)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @elseif($quarter3)
                                                                    @if ($KPIProject->target <= $KPIProject->result3)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @elseif($quarter2)
                                                                    @if ($KPIProject->target <= $KPIProject->result2)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @else
                                                                    @if ($KPIProject->target <= $KPIProject->result1)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        @endif
                                        {{-- ดำเนินการ --}}
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
                                                        @php
                                                            $quarter1 = false;
                                                            $quarter2 = false;
                                                            $quarter3 = false;
                                                            $quarter4 = false;
                                                            foreach ($data['report'] as $report) {
                                                                if ($report->quarID == 4) {
                                                                    $quarter4 = true;
                                                                    break;
                                                                } elseif ($report->quarID == 3) {
                                                                    $quarter3 = true;
                                                                    break;
                                                                } elseif ($report->quarID == 2) {
                                                                    $quarter2 = true;
                                                                    break;
                                                                } else {
                                                                    $quarter1 = true;
                                                                    break;
                                                                }
                                                            }
                                                        @endphp
                                                        <tr>
                                                            <td></td>
                                                            <td><u>ตัวชี้วัด</u> <br> {{ $KPI3LV->KPI->name }}</td>
                                                            <td><u>หน่วยนับ</u> <br>{{ $KPI3LV->KPI->count }} </td>
                                                            <td><u>เป้าหมาย</u><br>{{ $KPI3LV->KPI->target }} </td>
                                                            <td><u>ผล</u><br>
                                                                @if (request('quarID') == 1)
                                                                    {{ $KPI3LV->result1 }}
                                                                @elseif(request('quarID') == 2)
                                                                    @if ($quarter2)
                                                                        {{ $KPI3LV->result2 }}
                                                                    @else
                                                                        {{ $KPI3LV->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 3)
                                                                    @if ($quarter3)
                                                                        {{ $KPI3LV->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPI3LV->result2 }}
                                                                    @else
                                                                        {{ $KPI3LV->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 4)
                                                                    @if ($quarter4)
                                                                        {{ $KPI4LV->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPI3LV->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPI3LV->result2 }}
                                                                    @else
                                                                        {{ $KPI3LV->result1 }}
                                                                    @endif
                                                                @endif
                                                                <br>
                                                            </td>
                                                            <td><u>สถานะตัวชี้วัด</u> <br>
                                                                @if ($quarter4)
                                                                    @if ($KPI3LV->KPI->target <= $KPI3LV->result4)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @elseif($quarter3)
                                                                    @if ($KPI3LV->KPI->target <= $KPI3LV->result3)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @elseif($quarter2)
                                                                    @if ($KPI3LV->KPI->target <= $KPI3LV->result2)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @else
                                                                    @if ($KPI3LV->KPI->target <= $KPI3LV->result1)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
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
                                                            <td><u>ผล</u>
                                                                <br>
                                                                @if (request('quarID') == 1)
                                                                    {{ $KPI2LV->result1 }}
                                                                @elseif(request('quarID') == 2)
                                                                    @if ($quarter2)
                                                                        {{ $KPI2LV->result2 }}
                                                                    @else
                                                                        {{ $KPI2LV->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 3)
                                                                    @if ($quarter3)
                                                                        {{ $KPI2LV->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPI2LV->result2 }}
                                                                    @else
                                                                        {{ $KPI2LV->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 4)
                                                                    @if ($quarter4)
                                                                        {{ $KPI2LV->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPI2LV->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPI2LV->result2 }}
                                                                    @else
                                                                        {{ $KPI2LV->result1 }}
                                                                    @endif
                                                                @endif
                                                                <br>
                                                            </td>
                                                            <td>
                                                                <u>สถานะตัวชี้วัด</u> <br>
                                                                @if ($quarter4)
                                                                    @if ($KPI2LV->target <= $KPIProject->result4)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @elseif($quarter3)
                                                                    @if ($KPI2LV->target <= $KPI2LV->result3)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @elseif($quarter2)
                                                                    @if ($KPI2LV->target <= $KPI2LV->result2)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @else
                                                                    @if ($KPI2LV->target <= $KPI2LV->result1)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
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
                                                            <td>
                                                                @if (request('quarID') == 1)
                                                                    {{ $KPIProject->result1 }}
                                                                @elseif(request('quarID') == 2)
                                                                    @if ($quarter2)
                                                                        {{ $KPIProject->result2 }}
                                                                    @else
                                                                        {{ $KPIProject->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 3)
                                                                    @if ($quarter3)
                                                                        {{ $KPIProject->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPIProject->result2 }}
                                                                    @else
                                                                        {{ $KPIProject->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 4)
                                                                    @if ($quarter4)
                                                                        {{ $KPIProject->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPIProject->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPIProject->result2 }}
                                                                    @else
                                                                        {{ $KPIProject->result1 }}
                                                                    @endif
                                                                @endif
                                                                <br>
                                                            </td>
                                                            <td>
                                                                @if ($quarter4)
                                                                    @if ($KPIProject->target <= $KPIProject->result4)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @elseif($quarter3)
                                                                    @if ($KPIProject->target <= $KPIProject->result3)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @elseif($quarter2)
                                                                    @if ($KPIProject->target <= $KPIProject->result2)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @else
                                                                    @if ($KPIProject->target <= $KPIProject->result1)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        @endif

                                        {{-- ยังไม่รายงานผล --}}
                                        @if (!empty($data['ID_no_ReportInPlan']))
                                            @foreach ($data['datail_no_ReportInPlan'] as $item)
                                                <tr style="background-color: gainsboro">
                                                    <td>{{ $index++ }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->status->name }}</td>
                                                    <td>{{ $item->badgetTotal ?? '-' }}</td>
                                                    <td>{{ '-' }}</td>
                                                    <td>{{ '-' }}</td>
                                                    <td>{{ $item->displayname }}</td>
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

                                        {{-- แสดงข้อมูลโครงการนอกแผน --}}
                                        {{-- เสร็จตามระยะเวลา --}}
                                        @if (!empty($data['ID_projectEvaCompleteOutPlan']))

                                            @foreach ($data['datail_projectEvaCompleteOutPlan'] as $item)
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
                                                        @php
                                                            $quarter1 = false;
                                                            $quarter2 = false;
                                                            $quarter3 = false;
                                                            $quarter4 = false;
                                                            foreach ($data['report'] as $report) {
                                                                if ($report->quarID == 4) {
                                                                    $quarter4 = true;
                                                                    break;
                                                                } elseif ($report->quarID == 3) {
                                                                    $quarter3 = true;
                                                                    break;
                                                                } elseif ($report->quarID == 2) {
                                                                    $quarter2 = true;
                                                                    break;
                                                                } else {
                                                                    $quarter1 = true;
                                                                    break;
                                                                }
                                                            }
                                                        @endphp
                                                        <tr>
                                                            <td></td>
                                                            <td><u>ตัวชี้วัด</u> <br> {{ $KPI3LV->KPI->name }}</td>
                                                            <td><u>หน่วยนับ</u> <br>{{ $KPI3LV->KPI->count }} </td>
                                                            <td><u>เป้าหมาย</u><br>{{ $KPI3LV->KPI->target }} </td>
                                                            <td><u>ผล</u>
                                                                <br>

                                                                @if (request('quarID') == 1)
                                                                    @if ($quarter4)
                                                                        {{ $KPI4LV->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPI3LV->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPI3LV->result2 }}
                                                                    @else
                                                                        {{ $KPI3LV->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 2)
                                                                    @if ($quarter4)
                                                                        {{ $KPI4LV->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPI3LV->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPI3LV->result2 }}
                                                                    @else
                                                                        {{ $KPI3LV->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 3)
                                                                    @if ($quarter4)
                                                                        {{ $KPI4LV->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPI3LV->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPI3LV->result2 }}
                                                                    @else
                                                                        {{ $KPI3LV->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 4)
                                                                    @if ($quarter4)
                                                                        {{ $KPI4LV->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPI3LV->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPI3LV->result2 }}
                                                                    @else
                                                                        {{ $KPI3LV->result1 }}
                                                                    @endif
                                                                @endif
                                                                <br>
                                                            </td>
                                                            <td><u>สถานะตัวชี้วัด</u> <br>
                                                                @if ($quarter4)
                                                                @if ($KPI3LV->KPI->target <= $KPI3LV->result4)
                                                                    บรรลุ
                                                                @else
                                                                    ไม่บรรลุ
                                                                @endif
                                                            @elseif($quarter3)
                                                                @if ($KPI3LV->KPI->target <= $KPI3LV->result3)
                                                                    บรรลุ
                                                                @else
                                                                    ไม่บรรลุ
                                                                @endif
                                                            @elseif($quarter2)
                                                                @if ($KPI3LV->KPI->target <= $KPI3LV->result2)
                                                                    บรรลุ
                                                                @else
                                                                    ไม่บรรลุ
                                                                @endif
                                                            @else
                                                                @if ($KPI3LV->KPI->target <= $KPI3LV->result1)
                                                                    บรรลุ
                                                                @else
                                                                    ไม่บรรลุ
                                                                @endif
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
                                                            <td><u>ผล</u>
                                                                <br>
                                                                @if (request('quarID') == 1)
                                                                    {{ $KPI2LV->result1 }}
                                                                @elseif(request('quarID') == 2)
                                                                    @if ($quarter2)
                                                                        {{ $KPI2LV->result2 }}
                                                                    @else
                                                                        {{ $KPI2LV->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 3)
                                                                    @if ($quarter3)
                                                                        {{ $KPI2LV->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPI2LV->result2 }}
                                                                    @else
                                                                        {{ $KPI2LV->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 4)
                                                                    @if ($quarter4)
                                                                        {{ $KPI2LV->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPI2LV->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPI2LV->result2 }}
                                                                    @else
                                                                        {{ $KPI2LV->result1 }}
                                                                    @endif
                                                                @endif

                                                                <br>
                                                            </td>
                                                            <td><u>สถานะตัวชี้วัด</u> <br>
                                                                @if ($quarter4)
                                                                    @if ($KPI2LV->KPI->target <= $KPI2LV->result4)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @elseif($quarter3)
                                                                    @if ($KPI2LV->KPI->target <= $KPI2LV->result3)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @elseif($quarter2)
                                                                    @if ($KPI2LV->KPI->target <= $KPI2LV->result2)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @else
                                                                    @if ($KPI2LV->KPI->target <= $KPI2LV->result1)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
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
                                                            <td>
                                                                @if (request('quarID') == 1)
                                                                    @if ($quarter4)
                                                                        {{ $KPIProject->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPIProject->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPIProject->result2 }}
                                                                    @else
                                                                        {{ $KPIProject->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 2)
                                                                    @if ($quarter4)
                                                                        {{ $KPIProject->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPIProject->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPIProject->result2 }}
                                                                    @else
                                                                        {{ $KPIProject->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 3)
                                                                    @if ($quarter4)
                                                                        {{ $KPIProject->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPIProject->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPIProject->result2 }}
                                                                    @else
                                                                        {{ $KPIProject->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 4)
                                                                    @if ($quarter4)
                                                                        {{ $KPIProject->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPIProject->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPIProject->result2 }}
                                                                    @else
                                                                        {{ $KPIProject->result1 }}
                                                                    @endif
                                                                @endif
                                                                <br>
                                                            </td>
                                                            <td>
                                                                @if ($quarter4)
                                                                    @if ($KPIProject->target <= $KPIProject->result4)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @elseif($quarter3)
                                                                    @if ($KPIProject->target <= $KPIProject->result3)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @elseif($quarter2)
                                                                    @if ($KPIProject->target <= $KPIProject->result2)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @else
                                                                    @if ($KPIProject->target <= $KPIProject->result1)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @endif

                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        @endif

                                        {{-- ไม่เป็นไปตามระยะเวลา --}}
                                        @if (!empty($data['ID_projectEvaDeadlineOutPlan']))

                                            @foreach ($data['datail_projectEvaDeadlineOutPlan'] as $item)
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
                                                        @php
                                                            $quarter1 = false;
                                                            $quarter2 = false;
                                                            $quarter3 = false;
                                                            $quarter4 = false;
                                                            foreach ($data['report'] as $report) {
                                                                if ($report->quarID == 4) {
                                                                    $quarter4 = true;
                                                                    break;
                                                                } elseif ($report->quarID == 3) {
                                                                    $quarter3 = true;
                                                                    break;
                                                                } elseif ($report->quarID == 2) {
                                                                    $quarter2 = true;
                                                                    break;
                                                                } else {
                                                                    $quarter1 = true;
                                                                    break;
                                                                }
                                                            }
                                                        @endphp
                                                        <tr>
                                                            <td></td>
                                                            <td><u>ตัวชี้วัด</u> <br> {{ $KPI3LV->KPI->name }}</td>
                                                            <td><u>หน่วยนับ</u> <br>{{ $KPI3LV->KPI->count }} </td>
                                                            <td><u>เป้าหมาย</u><br>{{ $KPI3LV->KPI->target }} </td>
                                                            <td><u>ผล</u>
                                                                <br>

                                                                @if (request('quarID') == 1)
                                                                    @if ($quarter4)
                                                                        {{ $KPI4LV->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPI3LV->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPI3LV->result2 }}
                                                                    @else
                                                                        {{ $KPI3LV->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 2)
                                                                    @if ($quarter4)
                                                                        {{ $KPI4LV->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPI3LV->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPI3LV->result2 }}
                                                                    @else
                                                                        {{ $KPI3LV->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 3)
                                                                    @if ($quarter4)
                                                                        {{ $KPI4LV->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPI3LV->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPI3LV->result2 }}
                                                                    @else
                                                                        {{ $KPI3LV->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 4)
                                                                    @if ($quarter4)
                                                                        {{ $KPI4LV->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPI3LV->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPI3LV->result2 }}
                                                                    @else
                                                                        {{ $KPI3LV->result1 }}
                                                                    @endif
                                                                @endif
                                                                <br>
                                                            </td>
                                                            <td><u>สถานะตัวชี้วัด</u> <br>
                                                                @if ($quarter4)
                                                                @if ($KPI3LV->KPI->target <= $KPI3LV->result4)
                                                                    บรรลุ
                                                                @else
                                                                    ไม่บรรลุ
                                                                @endif
                                                            @elseif($quarter3)
                                                                @if ($KPI3LV->KPI->target <= $KPI3LV->result3)
                                                                    บรรลุ
                                                                @else
                                                                    ไม่บรรลุ
                                                                @endif
                                                            @elseif($quarter2)
                                                                @if ($KPI3LV->KPI->target <= $KPI3LV->result2)
                                                                    บรรลุ
                                                                @else
                                                                    ไม่บรรลุ
                                                                @endif
                                                            @else
                                                                @if ($KPI3LV->KPI->target <= $KPI3LV->result1)
                                                                    บรรลุ
                                                                @else
                                                                    ไม่บรรลุ
                                                                @endif
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
                                                            <td><u>ผล</u>
                                                                <br>
                                                                @if (request('quarID') == 1)
                                                                    {{ $KPI2LV->result1 }}
                                                                @elseif(request('quarID') == 2)
                                                                    @if ($quarter2)
                                                                        {{ $KPI2LV->result2 }}
                                                                    @else
                                                                        {{ $KPI2LV->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 3)
                                                                    @if ($quarter3)
                                                                        {{ $KPI2LV->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPI2LV->result2 }}
                                                                    @else
                                                                        {{ $KPI2LV->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 4)
                                                                    @if ($quarter4)
                                                                        {{ $KPI2LV->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPI2LV->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPI2LV->result2 }}
                                                                    @else
                                                                        {{ $KPI2LV->result1 }}
                                                                    @endif
                                                                @endif

                                                                <br>
                                                            </td>
                                                            <td><u>สถานะตัวชี้วัด</u> <br>
                                                                @if ($quarter4)
                                                                    @if ($KPI2LV->KPI->target <= $KPI2LV->result4)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @elseif($quarter3)
                                                                    @if ($KPI2LV->KPI->target <= $KPI2LV->result3)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @elseif($quarter2)
                                                                    @if ($KPI2LV->KPI->target <= $KPI2LV->result2)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @else
                                                                    @if ($KPI2LV->KPI->target <= $KPI2LV->result1)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
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
                                                            <td>
                                                                @if (request('quarID') == 1)
                                                                    @if ($quarter4)
                                                                        {{ $KPIProject->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPIProject->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPIProject->result2 }}
                                                                    @else
                                                                        {{ $KPIProject->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 2)
                                                                    @if ($quarter4)
                                                                        {{ $KPIProject->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPIProject->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPIProject->result2 }}
                                                                    @else
                                                                        {{ $KPIProject->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 3)
                                                                    @if ($quarter4)
                                                                        {{ $KPIProject->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPIProject->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPIProject->result2 }}
                                                                    @else
                                                                        {{ $KPIProject->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 4)
                                                                    @if ($quarter4)
                                                                        {{ $KPIProject->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPIProject->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPIProject->result2 }}
                                                                    @else
                                                                        {{ $KPIProject->result1 }}
                                                                    @endif
                                                                @endif
                                                                <br>
                                                            </td>
                                                            <td>
                                                                @if ($quarter4)
                                                                    @if ($KPIProject->target <= $KPIProject->result4)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @elseif($quarter3)
                                                                    @if ($KPIProject->target <= $KPIProject->result3)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @elseif($quarter2)
                                                                    @if ($KPIProject->target <= $KPIProject->result2)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @else
                                                                    @if ($KPIProject->target <= $KPIProject->result1)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @endif

                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        @endif
                                        {{-- ขอเลื่อน --}}
                                        @if (!empty($data['ID_projectEvaPostponedOutPlan']))

                                            @foreach ($data['datail_projectEvaPostponedOutPlan'] as $item)
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
                                                        @php
                                                            $quarter1 = false;
                                                            $quarter2 = false;
                                                            $quarter3 = false;
                                                            $quarter4 = false;
                                                            foreach ($data['report'] as $report) {
                                                                if ($report->quarID == 4) {
                                                                    $quarter4 = true;
                                                                    break;
                                                                } elseif ($report->quarID == 3) {
                                                                    $quarter3 = true;
                                                                    break;
                                                                } elseif ($report->quarID == 2) {
                                                                    $quarter2 = true;
                                                                    break;
                                                                } else {
                                                                    $quarter1 = true;
                                                                    break;
                                                                }
                                                            }
                                                        @endphp
                                                        <tr>
                                                            <td></td>
                                                            <td><u>ตัวชี้วัด</u> <br> {{ $KPI3LV->KPI->name }}</td>
                                                            <td><u>หน่วยนับ</u> <br>{{ $KPI3LV->KPI->count }} </td>
                                                            <td><u>เป้าหมาย</u><br>{{ $KPI3LV->KPI->target }} </td>
                                                            <td><u>ผล</u>
                                                                <br>

                                                                @if (request('quarID') == 1)
                                                                    @if ($quarter4)
                                                                        {{ $KPI4LV->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPI3LV->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPI3LV->result2 }}
                                                                    @else
                                                                        {{ $KPI3LV->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 2)
                                                                    @if ($quarter4)
                                                                        {{ $KPI4LV->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPI3LV->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPI3LV->result2 }}
                                                                    @else
                                                                        {{ $KPI3LV->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 3)
                                                                    @if ($quarter4)
                                                                        {{ $KPI4LV->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPI3LV->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPI3LV->result2 }}
                                                                    @else
                                                                        {{ $KPI3LV->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 4)
                                                                    @if ($quarter4)
                                                                        {{ $KPI4LV->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPI3LV->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPI3LV->result2 }}
                                                                    @else
                                                                        {{ $KPI3LV->result1 }}
                                                                    @endif
                                                                @endif
                                                                <br>
                                                            </td>
                                                            <td><u>สถานะตัวชี้วัด</u> <br>
                                                                @if ($quarter4)
                                                                @if ($KPI3LV->KPI->target <= $KPI3LV->result4)
                                                                    บรรลุ
                                                                @else
                                                                    ไม่บรรลุ
                                                                @endif
                                                            @elseif($quarter3)
                                                                @if ($KPI3LV->KPI->target <= $KPI3LV->result3)
                                                                    บรรลุ
                                                                @else
                                                                    ไม่บรรลุ
                                                                @endif
                                                            @elseif($quarter2)
                                                                @if ($KPI3LV->KPI->target <= $KPI3LV->result2)
                                                                    บรรลุ
                                                                @else
                                                                    ไม่บรรลุ
                                                                @endif
                                                            @else
                                                                @if ($KPI3LV->KPI->target <= $KPI3LV->result1)
                                                                    บรรลุ
                                                                @else
                                                                    ไม่บรรลุ
                                                                @endif
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
                                                            <td><u>ผล</u>
                                                                <br>
                                                                @if (request('quarID') == 1)
                                                                    {{ $KPI2LV->result1 }}
                                                                @elseif(request('quarID') == 2)
                                                                    @if ($quarter2)
                                                                        {{ $KPI2LV->result2 }}
                                                                    @else
                                                                        {{ $KPI2LV->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 3)
                                                                    @if ($quarter3)
                                                                        {{ $KPI2LV->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPI2LV->result2 }}
                                                                    @else
                                                                        {{ $KPI2LV->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 4)
                                                                    @if ($quarter4)
                                                                        {{ $KPI2LV->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPI2LV->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPI2LV->result2 }}
                                                                    @else
                                                                        {{ $KPI2LV->result1 }}
                                                                    @endif
                                                                @endif

                                                                <br>
                                                            </td>
                                                            <td><u>สถานะตัวชี้วัด</u> <br>
                                                                @if ($quarter4)
                                                                    @if ($KPI2LV->KPI->target <= $KPI2LV->result4)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @elseif($quarter3)
                                                                    @if ($KPI2LV->KPI->target <= $KPI2LV->result3)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @elseif($quarter2)
                                                                    @if ($KPI2LV->KPI->target <= $KPI2LV->result2)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @else
                                                                    @if ($KPI2LV->KPI->target <= $KPI2LV->result1)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
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
                                                            <td>
                                                                @if (request('quarID') == 1)
                                                                    @if ($quarter4)
                                                                        {{ $KPIProject->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPIProject->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPIProject->result2 }}
                                                                    @else
                                                                        {{ $KPIProject->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 2)
                                                                    @if ($quarter4)
                                                                        {{ $KPIProject->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPIProject->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPIProject->result2 }}
                                                                    @else
                                                                        {{ $KPIProject->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 3)
                                                                    @if ($quarter4)
                                                                        {{ $KPIProject->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPIProject->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPIProject->result2 }}
                                                                    @else
                                                                        {{ $KPIProject->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 4)
                                                                    @if ($quarter4)
                                                                        {{ $KPIProject->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPIProject->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPIProject->result2 }}
                                                                    @else
                                                                        {{ $KPIProject->result1 }}
                                                                    @endif
                                                                @endif
                                                                <br>
                                                            </td>
                                                            <td>
                                                                @if ($quarter4)
                                                                    @if ($KPIProject->target <= $KPIProject->result4)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @elseif($quarter3)
                                                                    @if ($KPIProject->target <= $KPIProject->result3)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @elseif($quarter2)
                                                                    @if ($KPIProject->target <= $KPIProject->result2)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @else
                                                                    @if ($KPIProject->target <= $KPIProject->result1)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @endif

                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        @endif
                                        {{-- ขอยกเลิก --}}
                                        @if (!empty($data['ID_projectEvaCancleOutPlan']))

                                            @foreach ($data['datail_projectEvaCancleOutPlan'] as $item)
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
                                                        @php
                                                            $quarter1 = false;
                                                            $quarter2 = false;
                                                            $quarter3 = false;
                                                            $quarter4 = false;
                                                            foreach ($data['report'] as $report) {
                                                                if ($report->quarID == 4) {
                                                                    $quarter4 = true;
                                                                    break;
                                                                } elseif ($report->quarID == 3) {
                                                                    $quarter3 = true;
                                                                    break;
                                                                } elseif ($report->quarID == 2) {
                                                                    $quarter2 = true;
                                                                    break;
                                                                } else {
                                                                    $quarter1 = true;
                                                                    break;
                                                                }
                                                            }
                                                        @endphp
                                                        <tr>
                                                            <td></td>
                                                            <td><u>ตัวชี้วัด</u> <br> {{ $KPI3LV->KPI->name }}</td>
                                                            <td><u>หน่วยนับ</u> <br>{{ $KPI3LV->KPI->count }} </td>
                                                            <td><u>เป้าหมาย</u><br>{{ $KPI3LV->KPI->target }} </td>
                                                            <td><u>ผล</u>
                                                                <br>

                                                                @if (request('quarID') == 1)
                                                                    @if ($quarter4)
                                                                        {{ $KPI4LV->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPI3LV->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPI3LV->result2 }}
                                                                    @else
                                                                        {{ $KPI3LV->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 2)
                                                                    @if ($quarter4)
                                                                        {{ $KPI4LV->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPI3LV->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPI3LV->result2 }}
                                                                    @else
                                                                        {{ $KPI3LV->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 3)
                                                                    @if ($quarter4)
                                                                        {{ $KPI4LV->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPI3LV->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPI3LV->result2 }}
                                                                    @else
                                                                        {{ $KPI3LV->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 4)
                                                                    @if ($quarter4)
                                                                        {{ $KPI4LV->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPI3LV->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPI3LV->result2 }}
                                                                    @else
                                                                        {{ $KPI3LV->result1 }}
                                                                    @endif
                                                                @endif
                                                                <br>
                                                            </td>
                                                            <td><u>สถานะตัวชี้วัด</u> <br>
                                                                @if ($quarter4)
                                                                @if ($KPI3LV->KPI->target <= $KPI3LV->result4)
                                                                    บรรลุ
                                                                @else
                                                                    ไม่บรรลุ
                                                                @endif
                                                            @elseif($quarter3)
                                                                @if ($KPI3LV->KPI->target <= $KPI3LV->result3)
                                                                    บรรลุ
                                                                @else
                                                                    ไม่บรรลุ
                                                                @endif
                                                            @elseif($quarter2)
                                                                @if ($KPI3LV->KPI->target <= $KPI3LV->result2)
                                                                    บรรลุ
                                                                @else
                                                                    ไม่บรรลุ
                                                                @endif
                                                            @else
                                                                @if ($KPI3LV->KPI->target <= $KPI3LV->result1)
                                                                    บรรลุ
                                                                @else
                                                                    ไม่บรรลุ
                                                                @endif
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
                                                            <td><u>ผล</u>
                                                                <br>
                                                                @if (request('quarID') == 1)
                                                                    {{ $KPI2LV->result1 }}
                                                                @elseif(request('quarID') == 2)
                                                                    @if ($quarter2)
                                                                        {{ $KPI2LV->result2 }}
                                                                    @else
                                                                        {{ $KPI2LV->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 3)
                                                                    @if ($quarter3)
                                                                        {{ $KPI2LV->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPI2LV->result2 }}
                                                                    @else
                                                                        {{ $KPI2LV->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 4)
                                                                    @if ($quarter4)
                                                                        {{ $KPI2LV->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPI2LV->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPI2LV->result2 }}
                                                                    @else
                                                                        {{ $KPI2LV->result1 }}
                                                                    @endif
                                                                @endif

                                                                <br>
                                                            </td>
                                                            <td><u>สถานะตัวชี้วัด</u> <br>
                                                                @if ($quarter4)
                                                                    @if ($KPI2LV->KPI->target <= $KPI2LV->result4)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @elseif($quarter3)
                                                                    @if ($KPI2LV->KPI->target <= $KPI2LV->result3)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @elseif($quarter2)
                                                                    @if ($KPI2LV->KPI->target <= $KPI2LV->result2)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @else
                                                                    @if ($KPI2LV->KPI->target <= $KPI2LV->result1)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
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
                                                            <td>
                                                                @if (request('quarID') == 1)
                                                                    @if ($quarter4)
                                                                        {{ $KPIProject->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPIProject->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPIProject->result2 }}
                                                                    @else
                                                                        {{ $KPIProject->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 2)
                                                                    @if ($quarter4)
                                                                        {{ $KPIProject->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPIProject->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPIProject->result2 }}
                                                                    @else
                                                                        {{ $KPIProject->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 3)
                                                                    @if ($quarter4)
                                                                        {{ $KPIProject->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPIProject->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPIProject->result2 }}
                                                                    @else
                                                                        {{ $KPIProject->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 4)
                                                                    @if ($quarter4)
                                                                        {{ $KPIProject->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPIProject->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPIProject->result2 }}
                                                                    @else
                                                                        {{ $KPIProject->result1 }}
                                                                    @endif
                                                                @endif
                                                                <br>
                                                            </td>
                                                            <td>
                                                                @if ($quarter4)
                                                                    @if ($KPIProject->target <= $KPIProject->result4)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @elseif($quarter3)
                                                                    @if ($KPIProject->target <= $KPIProject->result3)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @elseif($quarter2)
                                                                    @if ($KPIProject->target <= $KPIProject->result2)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @else
                                                                    @if ($KPIProject->target <= $KPIProject->result1)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @endif

                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        @endif
                                        {{-- ดำเนินการ --}}
                                        @if (!empty($data['ID_report_quarteOutPlan']))

                                            @foreach ($data['detail_report_quarteInPlan'] as $item)
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
                                                        @php
                                                            $quarter1 = false;
                                                            $quarter2 = false;
                                                            $quarter3 = false;
                                                            $quarter4 = false;
                                                            foreach ($data['report'] as $report) {
                                                                if ($report->quarID == 4) {
                                                                    $quarter4 = true;
                                                                    break;
                                                                } elseif ($report->quarID == 3) {
                                                                    $quarter3 = true;
                                                                    break;
                                                                } elseif ($report->quarID == 2) {
                                                                    $quarter2 = true;
                                                                    break;
                                                                } else {
                                                                    $quarter1 = true;
                                                                    break;
                                                                }
                                                            }
                                                        @endphp
                                                        <tr>
                                                            <td></td>
                                                            <td><u>ตัวชี้วัด</u> <br> {{ $KPI3LV->KPI->name }}</td>
                                                            <td><u>หน่วยนับ</u> <br>{{ $KPI3LV->KPI->count }} </td>
                                                            <td><u>เป้าหมาย</u><br>{{ $KPI3LV->KPI->target }} </td>
                                                            <td><u>ผล</u>
                                                                <br>

                                                                @if (request('quarID') == 1)
                                                                    @if ($quarter4)
                                                                        {{ $KPI4LV->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPI3LV->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPI3LV->result2 }}
                                                                    @else
                                                                        {{ $KPI3LV->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 2)
                                                                    @if ($quarter4)
                                                                        {{ $KPI4LV->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPI3LV->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPI3LV->result2 }}
                                                                    @else
                                                                        {{ $KPI3LV->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 3)
                                                                    @if ($quarter4)
                                                                        {{ $KPI4LV->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPI3LV->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPI3LV->result2 }}
                                                                    @else
                                                                        {{ $KPI3LV->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 4)
                                                                    @if ($quarter4)
                                                                        {{ $KPI4LV->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPI3LV->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPI3LV->result2 }}
                                                                    @else
                                                                        {{ $KPI3LV->result1 }}
                                                                    @endif
                                                                @endif
                                                                <br>
                                                            </td>
                                                            <td><u>สถานะตัวชี้วัด</u> <br>
                                                                @if ($quarter4)
                                                                @if ($KPI3LV->KPI->target <= $KPI3LV->result4)
                                                                    บรรลุ
                                                                @else
                                                                    ไม่บรรลุ
                                                                @endif
                                                            @elseif($quarter3)
                                                                @if ($KPI3LV->KPI->target <= $KPI3LV->result3)
                                                                    บรรลุ
                                                                @else
                                                                    ไม่บรรลุ
                                                                @endif
                                                            @elseif($quarter2)
                                                                @if ($KPI3LV->KPI->target <= $KPI3LV->result2)
                                                                    บรรลุ
                                                                @else
                                                                    ไม่บรรลุ
                                                                @endif
                                                            @else
                                                                @if ($KPI3LV->KPI->target <= $KPI3LV->result1)
                                                                    บรรลุ
                                                                @else
                                                                    ไม่บรรลุ
                                                                @endif
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
                                                            <td><u>ผล</u>
                                                                <br>
                                                                @if (request('quarID') == 1)
                                                                    {{ $KPI2LV->result1 }}
                                                                @elseif(request('quarID') == 2)
                                                                    @if ($quarter2)
                                                                        {{ $KPI2LV->result2 }}
                                                                    @else
                                                                        {{ $KPI2LV->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 3)
                                                                    @if ($quarter3)
                                                                        {{ $KPI2LV->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPI2LV->result2 }}
                                                                    @else
                                                                        {{ $KPI2LV->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 4)
                                                                    @if ($quarter4)
                                                                        {{ $KPI2LV->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPI2LV->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPI2LV->result2 }}
                                                                    @else
                                                                        {{ $KPI2LV->result1 }}
                                                                    @endif
                                                                @endif

                                                                <br>
                                                            </td>
                                                            <td><u>สถานะตัวชี้วัด</u> <br>
                                                                @if ($quarter4)
                                                                    @if ($KPI2LV->KPI->target <= $KPI2LV->result4)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @elseif($quarter3)
                                                                    @if ($KPI2LV->KPI->target <= $KPI2LV->result3)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @elseif($quarter2)
                                                                    @if ($KPI2LV->KPI->target <= $KPI2LV->result2)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @else
                                                                    @if ($KPI2LV->KPI->target <= $KPI2LV->result1)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
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
                                                            <td>
                                                                @if (request('quarID') == 1)
                                                                    @if ($quarter4)
                                                                        {{ $KPIProject->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPIProject->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPIProject->result2 }}
                                                                    @else
                                                                        {{ $KPIProject->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 2)
                                                                    @if ($quarter4)
                                                                        {{ $KPIProject->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPIProject->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPIProject->result2 }}
                                                                    @else
                                                                        {{ $KPIProject->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 3)
                                                                    @if ($quarter4)
                                                                        {{ $KPIProject->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPIProject->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPIProject->result2 }}
                                                                    @else
                                                                        {{ $KPIProject->result1 }}
                                                                    @endif
                                                                @elseif(request('quarID') == 4)
                                                                    @if ($quarter4)
                                                                        {{ $KPIProject->result4 }}
                                                                    @elseif($quarter3)
                                                                        {{ $KPIProject->result3 }}
                                                                    @elseif($quarter2)
                                                                        {{ $KPIProject->result2 }}
                                                                    @else
                                                                        {{ $KPIProject->result1 }}
                                                                    @endif
                                                                @endif
                                                                <br>
                                                            </td>
                                                            <td>
                                                                @if ($quarter4)
                                                                    @if ($KPIProject->target <= $KPIProject->result4)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @elseif($quarter3)
                                                                    @if ($KPIProject->target <= $KPIProject->result3)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @elseif($quarter2)
                                                                    @if ($KPIProject->target <= $KPIProject->result2)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @else
                                                                    @if ($KPIProject->target <= $KPIProject->result1)
                                                                        บรรลุ
                                                                    @else
                                                                        ไม่บรรลุ
                                                                    @endif
                                                                @endif

                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        @endif
                                        {{-- ยังไม่รายงานผล --}}
                                        @if (!empty($data['ID_no_ReportOutPlan']))
                                            @foreach ($data['datail_no_ReportInPlan'] as $item)
                                                <tr style="background-color: gainsboro">
                                                    <td>{{ $index++ }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->status->name }}</td>
                                                    <td>{{ $item->badgetTotal ?? '-' }}</td>
                                                    <td>{{ '-' }}</td>
                                                    <td>{{ '-' }}</td>
                                                    <td>{{ $item->displayname }}</td>
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
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function submitForm() {
            document.getElementById('actionForm').submit();
        }

        //โครงการตามแผน
        function projectEvaCompleteInPlan() {
            document.getElementById('projectEvaCompleteInPlan').submit();
        }

        function projectEvaDeadlineInPlan() {
            document.getElementById('projectEvaDeadlineInPlan').submit();
        }

        function projectEvaPostponedInPlan() {
            document.getElementById('projectEvaPostponedInPlan').submit();
        }

        function projectEvaCancleInPlan() {
            document.getElementById('projectEvaCancleInPlan').submit();
        }

        function report_quarteInPlan() {
            document.getElementById('report_quarteInPlan').submit();
        }

        function no_ReportInPlan() {
            document.getElementById('no_ReportInPlan').submit();
        }

        //โครงการนอกแผน
        function projectEvaCompleteOutPlan() {
            document.getElementById('projectEvaCompleteOutPlan').submit();
        }
        function projectEvaDeadlineOutPlan() {
            document.getElementById('projectEvaDeadlineOutPlan').submit();
        }

        function projectEvaPostponedOutPlan() {
            document.getElementById('projectEvaPostponedOutPlan').submit();
        }

        function projectEvaCancleOutPlan() {
            document.getElementById('projectEvaCancleOutPlan').submit();
        }

        function report_quarteOutPlan() {
            document.getElementById('report_quarteOutPlan').submit();
        }

        function no_ReportOutPlan() {
            document.getElementById('no_ReportOutPlan').submit();
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
