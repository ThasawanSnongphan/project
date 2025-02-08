<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mpdf\Mpdf;
use DateTime;
use Carbon\Carbon;

Carbon::setLocale('th');

class PDFQ4Controller extends Controller
{
    public function pdf_gen()
    {
        $config = include(config_path('configPDF_V.php'));       // ดึงการตั้งค่าฟอนต์จาก config
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

            .underline::before { margin-right: 5px; }
            .underline::after { margin-left: 5px; }

            .dark-green { background-color: #003300; width: 80%; }
            .light-green { background-color: #00b300; width: 60%; }
            .red { background-color: #ff3333; width: 50%; }
            .blue { background-color: #33ccff; width: 70%; }
            .yellow { background-color: #ffcc00; width: 30%; }

        </style>";

        // logo 
        $htmlContent = '
            <div style="text-align: left; margin-bottom: 20px;">
                <img src="' . public_path('images/Garuda.png') . '" style="width: 60px; height: auto;">
                <h1 style="margin: 0; flex-grow: 1; text-align: center;">บันทึกข้อความ</h1>            
            </div>
        ';

        $htmlContent .= '
            <b style="font-size: 22pt;">ส่วนราชการ</b> 
            <span class="underline">สำนักคอมพิวเตอร์สารสนเทศ โทร.2215</span><br>
            <b style="font-size: 22pt;">ที่</b>
            <span class="underline">สค ภายใน /2566</span>
            <b style="font-size: 22pt;">วันที่</b>
            <span class="underline">19 ตุลาคม 2566</span><br>
            <b style="font-size: 22pt;">เรื่อง</b>
            <span class="underline">ขอจัดส่งรายงานผลการดําเนินงานโครงการตามแผนปฏิบัติการ และโครงการนอกแผนปฏิบัติการประจําปีงบประมาณ พ.ศ. 2566 ( 1 ตุลาคม 2565 - 30 กันยายน 2566)</span><br>
        ';

        $htmlContent .= '
            <b>เรียน</b><br>
        ';

        $htmlContent .= '
            <div style="text-align: center;">
                <b>แผนประจำปีงบประมาณ พ.ศ.2566</b>
            </div>
        ';

        $htmlContent .= '
            <table border="1" style="border-collapse: collapse; width: 100%; margin-bottom: 7px;">
                <tr>
                    <th>ผลการดำเนินงาน</th>
                    <th>จำนวนโครงการ</th>
                </tr>

                <tr>
                    <td></td>
                </tr>

                <tr>
                    <th>รวม</th>
                    <th></th>
                </tr>

            </table>

        ';

        $htmlContent .= '
            <div style="text-align: center;">
                <b>โครงการนอกแผนปฏิบัติการประจําปีงบประมาณ พ.ศ. 2566</b>
            </div>
        ';

        $htmlContent .= '
            <table border="1" style="border-collapse: collapse; width: 100%; margin-bottom: 7px;">
                <tr>
                    <th>ผลการดำเนินงาน</th>
                    <th>จำนวนโครงการ</th>
                </tr>

                <tr>
                    <td></td>
                </tr>

                <tr>
                    <th>รวม</th>
                    <th></th>
                </tr>

            </table>

        ';

        $htmlContent .= '
            <div style="text-align: center;">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;จึงเรียนมาเพื่อโปรดทราบ <u>และเห็นควรนําเสนอคณะกรรมการบริหารสํานักคอมพิวเตอร์ฯ เพื่อพิจารณาต่อไป</u>
            </div>
        ';

        $htmlContent .= '
            <div style="text-align: right;">
                <div style="width: 300px; text-align: center; float: right;">
                    <br><br><br>
                    (นางศรินญา พงศ์สุริยา) <br>
                    นักวิเคราะห์นโยบายและแผน <br>
                </div>
            </div>
        ';











        $mpdf->WriteHTML($stylesheet, 1);              // โหลด CSS  
        $mpdf->WriteHTML($htmlContent, 2);             // เขียนเนื้อหา HTML ลงใน PDF

        $mpdf->SetTitle('บันทึกขอจัดส่งผลการดำเนินงานตามแผนปฏิบัติการไตรมาส4');
        return $mpdf->Output('บันทึกขอจัดส่งผลการดำเนินงานตามแผนปฏิบัติการไตรมาส4.pdf', 'I');       // ส่งไฟล์ PDF กลับไปให้ผู้ใช้
    }
}
