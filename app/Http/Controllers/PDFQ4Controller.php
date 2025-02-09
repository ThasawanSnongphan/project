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
            
            .dot-line {
                display: block; /* ให้ครอบคลุมเต็มบรรทัด */
                border-bottom: 1px dotted black; /* จุดไข่ปลา */
                
                overflow: hidden; /* ป้องกันข้อความล้น */
                text-align: left; /* จัดข้อความชิดซ้าย */
                padding-left: 10px; /* เพิ่มช่องว่างระหว่างจุดไข่ปลากับข้อความ */
                width: 100%; /* ให้ span เต็มบรรทัด */
                white-space: normal; /* อนุญาตให้ขึ้นบรรทัดใหม่ */
                word-wrap: break-word; /* ตัดคำเมื่อเกินบรรทัด */
                overflow-wrap: break-word;
            }

   


            .dark-green { background-color: #003300; width: 80%; }
            .light-green { background-color: #00b300; width: 60%; }
            .red { background-color: #ff3333; width: 50%; }
            .blue { background-color: #33ccff; width: 70%; }
            .yellow { background-color: #ffcc00; width: 30%; }

        </style>";

        // white-space: nowrap; /* ห้ามตัดคำในบรรทัด */
        // logo 
        $htmlContent = '
            <div style="text-align: left; margin-bottom: 20px;">
                <img src="' . public_path('images/Garuda.png') . '" style="width: 60px; height: auto;">
                <h1 style="margin: 0; flex-grow: 1; text-align: center;">บันทึกข้อความ</h1>            
            </div>
        ';
        

        function addSpacesToEnd($text, $maxLength) {
            $currentLength = mb_strlen(strip_tags($text)); // นับความยาวของข้อความ (ไม่รวม HTML)
            $spacesToAdd = max(0, $maxLength - $currentLength); // คำนวณช่องว่างที่ต้องเพิ่ม
            return $text . str_repeat("&nbsp;", $spacesToAdd);
        }

        function wrapTextWithDots($text, $lineLength = 80) {
            $words = explode(" ", $text);
            $lines = [];
            $currentLine = "";
        
            foreach ($words as $word) {
                if (mb_strlen($currentLine . " " . $word) > $lineLength) {
                    $lines[] = $currentLine; // เก็บบรรทัดปัจจุบัน
                    $currentLine = $word; // เริ่มบรรทัดใหม่
                } else {
                    $currentLine .= ($currentLine ? " " : "") . $word;
                }
            }
            $lines[] = $currentLine; // เพิ่มบรรทัดสุดท้าย
        
            // แปลงแต่ละบรรทัดเป็น HTML พร้อมเส้นใต้จุดไข่ปลา
            return implode('<br><span class="dot-line">', $lines) . str_repeat('.', max(0, $lineLength - mb_strlen($lines[count($lines) - 1])));
        }
        
        
        
        // กำหนดความยาวสูงสุดที่ต้องการให้เส้นจุดไข่ปลาวิ่งถึง
        $maxLineLength = 100; 
        $minLineLength = 55;
        
        $htmlContent .= '
            <b style="font-size: 22pt;">ส่วนราชการ</b> 
            <span class="dot-line">' . addSpacesToEnd("สำนักคอมพิวเตอร์สารสนเทศ โทร.2215", $maxLineLength) . '</span><br>

            <b style="font-size: 22pt;">ที่</b>
            <span class="dot-line">' . addSpacesToEnd("สค ภายใน /2566", $minLineLength) . '</span>

            <b style="font-size: 22pt;">วันที่</b>
            <span class="dot-line">' . addSpacesToEnd("19 ตุลาคม 2566", $minLineLength) . '</span><br>

            <b style="font-size: 22pt;">เรื่อง</b>
            <span class="dot-line">' . addSpacesToEnd("ขอจัดส่งรายงานผลการดำเนินงานโครงการตามแผนปฏิบัติการและโครงการนอกแผนปฏิบัติการประจำปีงบประมาณ พ.ศ. 2566 (1 ตุลาคม 2565 - 30 กันยายน 2566)", $maxLineLength) . '</span><br>
            
            
        ';

        // <b style="font-size: 22pt;">เรื่อง</b>
        //     <span class="dot-line">' . wrapTextWithDots("ขอจัดส่งรายงานผลการดำเนินงานโครงการตามแผนปฏิบัติการและโครงการนอกแผนปฏิบัติการประจำปีงบประมาณ พ.ศ. 2566 (1 ตุลาคม 2565 - 30 กันยายน 2566)", 80) . '</span><br>

        

        $htmlContent .= '
            <div style="margin-top: 7px;">
                <b>เรียน</b> ผู้อํานวยการสํานักคอมพิวเตอร์และเทคโนโลยีสารสนเทศ<br>
            </div>
        ';


        $htmlContent .= ' 
            <div style="page-break-inside: avoid;">
                <div style="text-align: justify; text-indent: 2em;">
                    ' . nl2br('Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.') . ' <br>
                </div>
            </div>
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
