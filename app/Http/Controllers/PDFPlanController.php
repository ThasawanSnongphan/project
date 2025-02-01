<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Mpdf\Mpdf;
use DateTime;
use Carbon\Carbon;

Carbon::setLocale('th');

class PDFPlanController extends Controller
{
    public function pdf_gen()
    {
        $config = include(config_path('configPDF_H.php'));       // ดึงการตั้งค่าฟอนต์จาก config
        $mpdf = new Mpdf($config);

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

            .dark-green { background-color: #003300; width: 80%; }
            .light-green { background-color: #00b300; width: 60%; }
            .red { background-color: #ff3333; width: 50%; }
            .blue { background-color: #33ccff; width: 70%; }
            .yellow { background-color: #ffcc00; width: 30%; }

        </style>";

        $projects = Projects::all();

        // ตั้งค่าระยะห่าง (แก้ปัญหา Header ทับตาราง)
        // $mpdf->SetMargins(10, 40, 10); // (ซ้าย, บน, ขวา)

        $mpdf->SetHTMLHeader('
            <h1 style="text-align: center; margin-bottom: 8px;">แผนปฏิบัติการประจำปีงบประมาณ พ.ศ.2567</h1>
        ');


        // $htmlContent = '
        //     <h1 style="text-align: center; margin-bottom: 8px;">แผนปฏิบัติการประจำปีงบประมาณ พ.ศ.2567</h1><br>
        // ';

        $htmlContent = '
            <br><br><br>
            <table border="1" style="border-collapse: collapse; width: 100%; margin-bottom: 7px;">
                <tr>
                    <td rowspan="2" style="width: 45%;">Project</td>
                    <td colspan="3">พ.ศ.2566</td>
                    <td colspan="9">พ.ศ.2567</td>
                </tr>

                <tr>
                    <td>ต.ค.</td>
                    <td>พ.ย.</td>
                    <td>ธ.ค.</td>
                    <td>ม.ค.</td>
                    <td>ก.พ.</td>
                    <td>มี.ค.</td>
                    <td>เม.ย.</td>
                    <td>พ.ค.</td>
                    <td>มิ.ย.</td>
                    <td>ก.ค.</td>
                    <td>ส.ค.</td>
                    <td>ก.ย.</td>
                </tr>';

        foreach ($projects as $project) {
            
            $htmlContent .= '<tr>';
            $htmlContent .= '<td style="text-align: left;">' . $project->name . '</td>'; 
            for ($i = 0; $i < 12; $i++) {
                $htmlContent .= '<td></td>'; // คอลัมน์เดือนว่าง
            }
            $htmlContent .= '</tr>';
        }

        $htmlContent .= '</table>';
        

        $mpdf->WriteHTML($stylesheet, 1);              // โหลด CSS  
        $mpdf->WriteHTML($htmlContent, 2);             // เขียนเนื้อหา HTML ลงใน PDF

        $mpdf->SetTitle('แผนปฏิบัติการประจำปีงบประมาณ พ.ศ.2567');
        return $mpdf->Output('แผนปฏิบัติการประจำปีงบประมาณ พ.ศ.2567.pdf', 'I');       // ส่งไฟล์ PDF กลับไปให้ผู้ใช้
    }
}
