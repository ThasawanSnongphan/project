<?php

namespace App\Http\Controllers;

use App\Models\CountKPIProjects;
use App\Models\Projects;
use Illuminate\Http\Request;

use Mpdf\Mpdf;
use DateTime;
use Carbon\Carbon;

class PDFAllResultsController extends Controller
{
    public function pdf_gen()
    {
        $projects = Projects::all();

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
                
            .rotate-header {
                transform: rotate(270deg);
                white-space: nowrap;
                text-align: center;
                vertical-align: middle;
                height: 100px;
            }

            .rotate {
    writing-mode: vertical-rl;
    text-orientation: mixed;
    white-space: nowrap;
    text-align: center;
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

        $projects = Projects::all();
        $countKPI_pros = CountKPIProjects::all();

        $index = 1; 

        $htmlContent .= '
            <table border="1" cellspacing="0" cellpadding="5" width="100%">
                <thead>
                    <tr style="background-color: #B7CCE2;">
                        <th>ลำดับ</th>
                        <th>โครงการ/กิจกรรม</th>
                        <th>หน่วยนับ</th>
                        <th class="rotate">เป้าหมาย</th>
                        <th>ผล</th>
                        <th style="font-size: 14px">
                            การบรรลุ <span style="font-family: DejaVu Sans, Arial, sans-serif;">(✔ / ✖)</span>
                        </th>
                        <th>งบประมาณที่จัดสรร</th>
                        <th>ผลการใช้จ่ายเงิน</th>
                        <th>ผลการดำเนินงาน</th>
                        <th>ปัญหา/อุปสรรค</th>
                        <th>ผู้รับผิดชอบ</th>
                    </tr>
                </thead>
            <tbody>';

            foreach ($projects as $project) {
                // ค้นหาหน่วยนับที่ตรงกับ proID
                $unitName = "-"; // ค่าเริ่มต้น (ถ้าไม่มีข้อมูล)
                foreach ($countKPI_pros as $countKPI_pro) {
                    if ($project->proID == $countKPI_pro->countKPIProID) {
                        $unitName = $countKPI_pro->name;
                        break; // เจอแล้วออกจาก loop
                    }
                }
            
                // สร้างแถวข้อมูล
                $htmlContent .= '
                    <tr>
                        <td>' . $index . '</td>  
                        <td>' . $project->name . '</td>
                        <td>' . $unitName . '</td>
                    </tr>';
            
                $index++; // เพิ่มลำดับ
            }

        $htmlContent .= '
                </tbody>
            </table>
        ';













        $mpdf->WriteHTML($stylesheet, 1);              // โหลด CSS  
        $mpdf->WriteHTML($htmlContent, 2);             // เขียนเนื้อหา HTML ลงใน PDF

        $mpdf->SetTitle('ผลการดําเนินงานตามแผนปฏิบัติการประจําปีงบประมาณ พ.ศ. 2566 (1 ต.ค. 2565- 30 ก.ย. 2566)');
        return $mpdf->Output('ผลการดําเนินงานตามแผนปฏิบัติการประจําปีงบประมาณ พ.ศ. 2566 (1 ต.ค. 2565- 30 ก.ย. 2566).pdf', 'I');       // ส่งไฟล์ PDF กลับไปให้ผู้ใช้
    }
}
