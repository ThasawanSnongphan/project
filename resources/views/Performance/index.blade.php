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
                <div class="card border-secondary mb-3" style="width: 30%;">
                    <div class="card-header">
                        <h4>โครงการทั้งหมด</h4>
                    </div>
                    <div class="card-body text-secondary">
                        <h5 class="card-title">{{ $data['projectAll'] }}</h5>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <p class="card-text" style="text-align: left">ปิดโครงการ/เสร็จตามระยะเวลา</p>
                            <p class="card-text" style="text-align: right"></p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="card-text" style="text-align: left">ปิดโครงการ/ไม่เป็นไปตามระยาเวลา</p>
                            <p class="card-text" style="text-align: right"></p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="card-text" style="text-align: left">ปิดโครงการ/ขอยกเลิก</p>
                            <p class="card-text" style="text-align: right"></p>
                        </div>
                    </div>
                </div>
                <div class="card border-secondary mb-3" style="width: 30%;">
                    <div class="card-header">
                        <h4>โครงการตามแผนปฏิบัติการ</h4>
                    </div>
                    <div class="card-body text-secondary">
                        <h5 class="card-title">{{ $data['projectInPlan'] }}</h5>
                        <hr>
                        <p class="card-text"></p>
                    </div>
                </div>
                <div class="card border-secondary mb-3" style="width: 30%;">
                    <div class="card-header">
                        <h4>โครงการนอกแผนปฏิบัติการ</h4>
                    </div>
                    <div class="card-body text-secondary">
                        <h5 class="card-title">{{ $data['projectOutPlan'] }}</h5>
                        <hr>
                        <p class="card-text"></p>
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
