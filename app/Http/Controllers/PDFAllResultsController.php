<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Mpdf\Mpdf;
use DateTime;
use Carbon\Carbon;

class PDFAllResultsController extends Controller
{
    public function pdf_gen()
    {
        $config = include(config_path('configPDF_H.php'));       // ดึงการตั้งค่าฟอนต์จาก config
        $mpdf = new Mpdf($config);

        // กำหนดความยาวของเส้นใต้ (ปรับ px ตามต้องการ)
        // $underlineLength = "300px"; 

        $stylesheet = "
        <style>
            table {
                border-collapse: collapse;
                width: 100%;
                margin-bottom: 7px;

            }
            table, th, td {
                border: 1px solid black;
                font-size: 16pt;
            }
            th, td {
                padding: 8px;
                text-align: center;
                font-size: 16pt;
            }
            tr, td {
                padding: 8px;
                text-align: center;
                font-size: 16pt;
            }
            .highlight {
                background-color: yellow;
            }

            .justified-text {
                text-align: justify;
                line-height: 1.5; /* กำหนดระยะห่างบรรทัดให้ดูอ่านง่าย */
                font-size: 14px; /* ขนาดตัวอักษร */
            }

            .progress {
                height: 20px;
                border-radius: 5px;
                text-align: center;
                color: white;
                font-weight: bold;
            }

            .underline {
                display: inline-block;
                min-width: 3000px; /* ขยายเส้นออกไป */
                border-bottom: 1px dotted black;
                text-align: left;
                padding: 5px 10px; /* เพิ่มช่องว่าง */
            }

            .underline::before,
            .underline::after {
                content: ' ';
                display: inline-block;
                width: 5000px; /* ปรับให้เส้นเลยออกจากข้อความ */
                border-bottom: 1px dotted black;
                vertical-align: middle;
            }

            .vertical-text {
                writing-mode: vertical-rl;
                text-align: center;
            }

            .vertical-header {
                writing-mode: vertical-rl;  /* หมุนแนวตั้งจากล่างขึ้นบน */
                text-align: center;
                transform: rotate(180deg); /* หมุนข้อความ 180 องศา */
                white-space: nowrap;
                padding: 10px;
            }

            .underline::before { margin-right: 5px; }
            .underline::after { margin-left: 5px; }

            .dark-green { background-color: #003300; width: 80%; }
            .light-green { background-color: #00b300; width: 60%; }
            .red { background-color: #ff3333; width: 50%; }
            .blue { background-color: #33ccff; width: 70%; }
            .yellow { background-color: #ffcc00; width: 30%; }

        </style>";


        $htmlContent = '
            <div style="text-align: center;">
                <b style="font-size: 14px;">ผลการดําเนินงานตามแผนปฏิบัติการประจําปีงบประมาณ พ.ศ. 2566 (1 ต.ค. 2565- 30 ก.ย. 2566)</b>
            </div>
        ';


        $htmlContent .= '
            <table border="1" cellspacing="0" cellpadding="5" width="100%">
                <thead>
                    <tr style="background-color: #B7CCE2;">
                        <th>ลำดับ</th>
                        <th>โครงการ/กิจกรรม</th>
                        <th>หน่วยนับ</th>
                        <th class="vertical-header">เป้าหมาย</th>
                        <th>ผล</th>
                        <th>*</th>
                        <th>งบประมาณที่จัดสรร</th>
                        <th>ผลการใช้จ่ายเงิน</th>
                        <th>ผลการดำเนินงาน</th>
                        <th>ปัญหา/อุปสรรค</th>
                        <th>ผู้รับผิดชอบ</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>
                            โครงการจัดการความรู้ (KM) ของสำนักคอมพิวเตอร์ฯ
                            <br><b>ตัวชี้วัด</b>
                            <br>1. จำนวนองค์ความรู้เผยแพร่สู่บุคลากร - 10 เรื่อง (ผล: 12 เรื่อง)
                            <br>2. จำนวนองค์ความรู้ที่นำไปใช้ในการปฏิบัติงาน - 6 เรื่อง (ผล: 12 เรื่อง)
                        </td>

                        <td>เรื่อง</td>
                        <td>10</td>
                        <td>12</td>
                        <td>✔</td>
                        <td>50,000</td>
                        <td>17,680.00</td>

                        <td>
                            <b>ปิดโครงการ</b>
                            <ul>
                                <li>มีการดำเนินกิจกรรมประกวดผลงานองค์ความรู้ และเผยแพร่องค์ความรู้...</li>
                                <li>จัดทำสื่อ Clip VDO และสื่อโปสเตอร์...</li>
                            </ul>
                        </td>
                        <td>-</td>
                        <td>สำนักฯ</td>
                    </tr>

                    <tr>
                        <td>2</td>
                        <td>
                            โครงการพัฒนาบุคลากร
                            <br><b>ตัวชี้วัด</b>
                            <br>1. ร้อยละของบุคลากรที่ได้รับการพัฒนาความสมรรถนะ KMUTNB - 85% (ผล: 100%)
                        </td>
                        <td>ร้อยละ</td>
                        <td>85</td>
                        <td>100</td>
                        <td>✔</td>
                        <td>570,000</td>
                        <td>828,645.54</td>
                        <td>
                            <b>ปิดโครงการ</b>
                            <ul>
                                <li>สำรวจความต้องการในการฝึกอบรมบุคลากร...</li>
                                <li>จัดฝึกอบรมพัฒนาบุคลากร...</li>
                            </ul>
                        </td>
                        <td>-</td>
                        <td>สำนักฯ</td>
                    </tr>

                </tbody>
            </table>

        ';

        











        $mpdf->WriteHTML($stylesheet, 1);              // โหลด CSS  
        $mpdf->WriteHTML($htmlContent, 2);             // เขียนเนื้อหา HTML ลงใน PDF

        $mpdf->SetTitle('ผลการดําเนินงานตามแผนปฏิบัติการประจําปีงบประมาณ พ.ศ. 2566 (1 ต.ค. 2565- 30 ก.ย. 2566)');
        return $mpdf->Output('ผลการดําเนินงานตามแผนปฏิบัติการประจําปีงบประมาณ พ.ศ. 2566 (1 ต.ค. 2565- 30 ก.ย. 2566).pdf', 'I');       // ส่งไฟล์ PDF กลับไปให้ผู้ใช้
    }
}
