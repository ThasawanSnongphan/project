@extends('layout')
@section('title', 'ผลการดำเนินงาน')
@section('content')
    <div class="row">
        <div class="col-md-1 col-sm-1"></div>
        <div class="col-md-10 col-sm-10">
            <h4 style="text-align: center">รายงานผลการดำเนินงานโครงการตามแผนปฏิบัติการ และโครงการนอกแผนปฏิบัติการ
                ประจำปีงบประมาณ พ.ศ.2567</h4>
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
                            <p class="card-text" style="text-align: right">{{$data['projectEvaCompleteAll']}}</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="card-text" style="text-align: left">ปิดโครงการ/ไม่เป็นไปตามระยาเวลา</p>
                            <p class="card-text" style="text-align: right"> {{$data['projectEvaDeadlineAll']}} </p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="card-text" style="text-align: left">ปิดโครงการ/ขอเลื่อน</p>
                            <p class="card-text" style="text-align: right"> {{$data['projectEvaPostponedAll']}} </p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="card-text" style="text-align: left">ปิดโครงการ/ขอยกเลิก</p>
                            <p class="card-text" style="text-align: right"> {{$data['projectEvaCancleAll']}} </p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="card-text" style="text-align: left">อยู่ระหว่างดำเนินการ</p>
                            <p class="card-text" style="text-align: right"> {{$data['report_quarterCountAll']}} </p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="card-text" style="text-align: left">ยังไม่รายงานผล</p>
                            <p class="card-text" style="text-align: right">{{$data['no_ReportAll']}} </p>
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
                        <div class="d-flex justify-content-between">
                            <p class="card-text" style="text-align: left">ปิดโครงการ/เสร็จตามระยะเวลา</p>
                            <p class="card-text" style="text-align: right"><a href="">{{$data['projectEvaCompleteInPlan']}}</a></p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="card-text" style="text-align: left">ปิดโครงการ/ไม่เป็นไปตามระยาเวลา</p>
                            <p class="card-text" style="text-align: right"><a href=""> {{$data['projectEvaDeadlineInPlan']}}</a> </p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="card-text" style="text-align: left">ปิดโครงการ/ขอเลื่อน</p>
                            <p class="card-text" style="text-align: right"><a href=""> {{$data['projectEvaPostponedInPlan']}}</a> </p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="card-text" style="text-align: left">ปิดโครงการ/ขอยกเลิก</p>
                            <p class="card-text" style="text-align: right"> <a href="">{{$data['projectEvaCancleInPlan']}} </a></p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="card-text" style="text-align: left">อยู่ระหว่างดำเนินการ</p>
                            <p class="card-text" style="text-align: right"><a href=""> {{$data['report_quarterCountInPlan'] }}</a> </p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="card-text" style="text-align: left">ยังไม่รายงานผล</p>
                            <p class="card-text" style="text-align: right"><a href=""> {{$data['no_ReportInPlan'] }}</a> </p>
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
                            <p class="card-text" style="text-align: right"><a href="">{{$data['projectEvaCompleteOutPlan']}}</a></p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="card-text" style="text-align: left">ปิดโครงการ/ไม่เป็นไปตามระยาเวลา</p>
                            <p class="card-text" style="text-align: right"><a href="">{{$data['projectEvaDeadlineOutPlan']}} </a></p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="card-text" style="text-align: left">ปิดโครงการ/ขอเลื่อน</p>
                            <p class="card-text" style="text-align: right"><a href="">{{$data['projectEvaPostponedOutPlan']}}</a> </p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="card-text" style="text-align: left">ปิดโครงการ/ขอยกเลิก</p>
                            <p class="card-text" style="text-align: right"><a href="">{{ $data['projectEvaCancleOutPlan']}}</a></p>
                        </div>
                        <div class="d-flex justify-content-between">
                            {{-- นับจากที่กรอกรายงานไตรมาส --}}
                            <p class="card-text" style="text-align: left">อยู่ระหว่างดำเนินการ</p>
                            <p class="card-text" style="text-align: right"><a href="">{{$data['report_quarterCountOutPlan']}} </a></p>
                        </div>
                        <div class="d-flex justify-content-between">
                            {{-- นับจากรายงานรายไตรมาส --}}
                            <p class="card-text" style="text-align: left">ยังไม่รายงานผล</p> 
                            <p class="card-text" style="text-align: right"><a href="">{{$data['no_ReportOutPlan'] }}</a></p>
                        </div>
                    </div>
                </div>
            </div>




            <table id="example" class="display">
                <thead>
                    <tr>
                        <td>#</td>
                        <td>ชื่อโครงการ</td>
                        <td>หน่วยนับ</td>
                        <td>เป้าหมาย</td>
                        <td>ผล</td>
                        <td>สถานะตัวชี้วัด</td>
                        <td>งบจัดสรร</td>
                        <td>ผลใช้จ่ายเงิน</td>
                        <td>ปัญหา/อุปสรรค</td>
                        <td>ผู้รับผิดชอบโครงการ</td>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
        <div class="col-md-1 col-sm-1"></div>
    </div>
@endsection
