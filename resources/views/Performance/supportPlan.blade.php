@extends('layout')
@section('title', 'ผลการดำเนินงานตามแผนสนับสนุนฯ')
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
                            <form action="/PerformanceSupportPlan" id="actionForm">
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
                            </form>
                            @if (!empty($data['selectYearID']) && !empty($data['selectQuarID']))
                                <h3 style="text-align: center">รายงานผลการดำเนินงานโครงการตามแผนสนับสนุน
                                    ประจำปีงบประมาณ พ.ศ. {{ $data['year']->year }} - {{ $data['quarter']->name }}</h3>
                                <h4 style="text-align: center">สำนักคอมพิวเตอร์และเทคโนโลยีสารสนเทศ มจพ.</h4> <br>
                                <div class="row justify-content-center" style="text-align: center">
                                    <div class="col-10 col-md-5">
                                        <div class="p-3 mb-3 bg-light text-dark rounded border">
                                            <h3 class="border rounded bg-white p-2">จำนวน KPI ทั้งสิ้น {{$data['report_q']->count()}} ตัวชี้วัด</h3>
                                            <h4 class="border rounded bg-white p-2" style="color: green">บรรลุ ตามค่าเป้าหมาย <br></h4>
                                            <h4 class="border rounded bg-white p-2" style="color: darkred">ไม่บรรลุ ตามค่าเป้าหมาย <br></h4>
                                        </div>
                                    </div>
                                    <div class="col-10 col-md-5">
                                        <div class="p-3 mb-3 bg-light text-dark rounded border"></div>
                                    </div>
                                </div>
                                <br>
                                <hr>
                                <table id="example" class="display">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>KPI</th>
                                            <th>หน่วยนับ</th>
                                            <th>ค่าเป้าหมาย</th>
                                            <th>ผลลัพธ์</th>
                                            <th>สถานะ</th>
                                            <th>รายละเอียดผลการดำเนินงาน</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
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

        function clearTable() {
            document.querySelector("#data tbody").innerHTML = "";
        }

    </script>
@endsection
