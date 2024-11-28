<?php

namespace App\Http\Controllers;

use App\Models\Benefits;
use App\Models\KPIProjects;
use App\Models\Objectives;
use App\Models\Users;
use App\Models\Year;
use App\Models\ProjectCharec;
use App\Models\ProjectIntegrat;
use App\Models\Projects;
use App\Models\Targets;
use App\Models\BadgetType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mpdf\Mpdf;
use DateTime;
use Carbon\Carbon;

Carbon::setLocale('th');


class PDFController extends Controller
{
    public function generatePDF()
    {

        $config = include(config_path('config_pdf.php'));
        $mpdf = new Mpdf($config);

        // เพิ่มเนื้อหาที่ต้องการใน PDF
        $htmlContent = '<h1>นี่คือ PDF ที่สร้างจาก MPDF ใน Laravel</h1>';
        $mpdf->WriteHTML($htmlContent);

        $mpdf->SetFont('THSarabunNew Bold');

        // ส่งไฟล์ PDF กลับไปให้ผู้ใช้
        return $mpdf->Output('example.pdf', 'I');
    }

    public function db_gen($id)
    {
        // ดึงข้อมูลผู้ใช้จากฐานข้อมูล
        $username = Users::where('id', 10)->first();
        $years = Year::all();
        $projects = Projects::where('proID', $id)->first();
        $badget_types = BadgetType::all();
        $KPI_pros = KPIProjects::all();
        $project_integrats = ProjectIntegrat::all();
        $project_charecs = ProjectCharec::all();
        $objects = Objectives::all();



        $config = include(config_path('config_pdf.php'));       // ดึงการตั้งค่าฟอนต์จาก config
        $mpdf = new Mpdf($config);                            // สร้าง instance ของ Mpdf ด้วยการตั้งค่าจาก config

        // กำหนดระยะห่างระหว่างโลโก้และเนื้อหา
        $mpdf->SetY(60);                                            // ตั้งระยะห่างจากขอบบนก่อนที่จะเริ่มเขียนเนื้อหา
        // $currentDate = date('Y-m-d');
        // ตั้งชื่อไฟล์ PDF
        // $fileName = $username . '_report_' . '.pdf';

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
           
            .checkbox {
                display: inline-block;
                width: 10px;
                height: 10px;
                border: 1px solid #000;
                text-align: center;
                vertical-align: middle;
                line-height: 24px;
                font-size: 13px;
                font-family: DejaVu Sans, sans-serif;

            }
            .checked {
                background-color: #000;
                color: white;

            .highlight {
                background-color: yellow; /* สีพื้นหลังสำหรับไฮไลต์ */
            }

        </style>";

        

        // logo kmutnb
        $htmlContent = '
        <div style="text-align: center; margin-bottom: 20px;">
            <img src="' . public_path('images/logo_kmutnb.png') . '" style="width: 60px; height: auto;">
        </div>
        ';

        foreach ($years as $year) {
            if ($projects->yearID == $year->yearID) {
                $htmlContent .= '
                    <p style="text-align: center; font-weight: bold;">แบบเสนอโครงการ ประจำปีงบประมาณ พ.ศ.' . $year->name . '
                        <br>มหาวิทยาลัยเทคโนโลยีพระจอมเกล้าพระนครเหนือ
                    </p>
                ';
                $mpdf->SetTitle('แบบเสนอโครงการประจำปีงบประมาณ ' . $year->name);
            }
        }
        
        

        

        $htmlContent .= '
        <b>1. ชื่อโครงการ : </b>' . $projects->name . '<br>
        <b>2. สังกัด : </b>
        <b>' . $username->department_name . '</b> <br>
        <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;สำนักงานผู้อำนวยการ</b> <br>
        <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ผู้รับผิดชอบ : </b>' . $username->username . '<br>
        <b>3. ความเชื่อมโยงสอดคล้องกับ แผนปฏิบัติการดิจิทัล มจพ. ระยะ 3 ปี พ.ศ. 2567-2569</b> <br>
        <b>4. ลักษณะโครงการ / กิจกรรม</b> <br>
        &nbsp;&nbsp;&nbsp;&nbsp;

        
        ';


        foreach ($project_charecs as $project_charec) {
            if ($projects->proChaID == $project_charec->proChaID) {
                $htmlContent .= '
                    <span class="checkbox">  ✓ </span> &nbsp; ' . $project_charec->pro_cha_name . ' &nbsp;
                ';
            } else {
                $htmlContent .= '
                    <input type="checkbox"> &nbsp; ' . $project_charec->pro_cha_name . ' &nbsp;
                ';
            }
        }

        $htmlContent .= '
        <br><b>5. การบูรณาการโครงการ </b> <br> 
        ';

        foreach ($project_integrats as $project_integrat) {
            if ($projects->proInID == $project_integrat->proInID) {
                $htmlContent .= '
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="checkbox"> ✓ </span> &nbsp; ' . $project_integrat->name . '<br>
                ';
            } else {
                $htmlContent .= '
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox"> &nbsp; ' . $project_integrat->name . '<br>
                ';
            }
        }



        $htmlContent .= '
        <b>6. หลักการและเหตุผลของโครงการ </b> <br> 
        &nbsp;&nbsp;&nbsp;' . $projects->princiDetail . '  <br>
        <b>7. วัตถุประสงค์ </b> <br> 
        ';


        // $counter = 1;           // ตัวแปรสำหรับเก็บลำดับ
        // foreach ($objects as $object) {
        //     $htmlContent .= '
        //         &nbsp;&nbsp;&nbsp;&nbsp;7.' . $counter . ' ' . $object->name . ' <br>
        //     ';
        //     $counter++;         // เพิ่มค่าลำดับหลังจากแสดงผลแต่ละครั้ง
        // }

        $htmlContent .= '';

        if (DB::table('objectives')->where('proID', $id)->exists()) {
            // ดึงข้อมูลที่ตรงกับ proID
            $objects = DB::table('objectives')->where('proID', $id)->get();

            $counter = 1; // ตัวแปรเก็บลำดับ
            foreach ($objects as $object) {
                $htmlContent .= '
                    &nbsp;&nbsp;&nbsp;&nbsp;7.' . $counter . ' ' . $object->name . ' <br>
                ';
                $counter++;
            }
        }

        $htmlContent .= '
        <b>8. ตัวชี้วัดความสำเร็จระดับโครงการ </b> <br>
        <table border="1" style="border-collapse: collapse; width: 100%; margin-bottom: 7px;">
            <thead>
                <tr>
                    <td style="padding: 8px; width: 60% ">ตัวชี้วัดความสำเร็จ</td>
                    <td style="padding: 8px; width: 20% ">หน่วยนับ</td>
                    <td style="padding: 8px; width: 20% ">ค่าเป้าหมาย</td>
                </tr>
            </thead>
            <tbody>';


        if (DB::table('k_p_i_projects')->where('proID', $id)->exists()) {
            $KPI_pros = DB::table('k_p_i_projects')->where('proID', $id)->get();
            foreach ($KPI_pros as $KPI_pro) {
                $htmlContent .= '
                    <tr>
                        <td style="padding: 8px; text-align: left;">' . $KPI_pro->name . '</td>
                        <td style="padding: 8px; text-align: left;">' . $KPI_pro->count . '</td>
                        <td style="padding: 8px; text-align: left;">' . $KPI_pro->target . '</td>
                    </tr>';
            }
        }

        $htmlContent .= '
            </tbody>
        </table>';

        $pro_tars = Projects::with('target')->get();

        foreach ($pro_tars as $pro_tar) {
            $tarID = $pro_tar->tarID;
            $targetName = $pro_tar->target->name ?? 'N/A'; // ใช้ข้อมูลจากตาราง targets
        }

        $htmlContent .= '
        <b>9. กลุ่มเป้าหมาย (ระบุกลุ่มเป้าหมายและจำนวนกลุ่มเป้าหมายที่เข้าร่วมโครงการ) </b> <br>
        &nbsp;&nbsp;&nbsp;&nbsp; ' . $targetName . ' <br>
        <b>10. ขั้นตอนการดำเนินงาน : </b> <br> 

        ';


        if (DB::table('steps')->where('proID', $id)->exists()) {
            $pro_steps = DB::table('steps')->where('proID', $id)->get();

            $minYear = PHP_INT_MAX; // ค่าเริ่มต้นของปีที่น้อยที่สุด
            $maxYear = PHP_INT_MIN; // ค่าเริ่มต้นของปีที่มากที่สุด

            foreach ($pro_steps as $index => $step) {
                $startDate = $step->start ?? null; // วันที่เริ่มต้น
                $endDate = $step->end ?? null; // วันที่สิ้นสุด
                $startYear = $startDate ? (new DateTime($startDate))->format('Y') + 543 : null;
                $endYear = $endDate ? (new DateTime($endDate))->format('Y') + 543 : null;

                // อัปเดตค่า $minYear และ $maxYear
                if ($startYear) {
                    $minYear = min($minYear, $startYear);
                }
                if ($endYear) {
                    $maxYear = max($maxYear, $endYear);
                }
            }

            // ตรวจสอบค่า $minYear และ $maxYear หลังจากประมวลผลเสร็จ
            if ($minYear === PHP_INT_MAX) {
                $minYear = 'N/A'; // ถ้าไม่มีข้อมูลใด ๆ
            }
            if ($maxYear === PHP_INT_MIN) {
                $maxYear = 'N/A'; // ถ้าไม่มีข้อมูลใด ๆ
            }

            // สร้าง HTML ของส่วนหัวตารางหลังคำนวณเสร็จ
            $htmlContent .= '
            <body>
                <table border="1" style="border-collapse: collapse; width: 100%; margin-bottom: 7px;">
                    <thead>
                        <tr>
                            <td rowspan="2">ขั้นตอนการดำเนินการ</td>
                            <td colspan="3">พ.ศ. ' . $minYear . '</td>
                            <td colspan="12">พ.ศ. ' . $maxYear . '</td>
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
                        </tr>
                    </thead>
                    <tbody>
            ';

            foreach ($pro_steps as $index => $step) {
                $stepName = $step->name ?? 'N/A';
                $highlightMonths = []; // เก็บเดือนที่ต้องไฮไลต์
                $startDate = $step->start ?? null;
                $endDate = $step->end ?? null;

                if ($startDate && $endDate) {
                    $start = new DateTime($startDate);
                    $end = new DateTime($endDate);

                    while ($start <= $end) {
                        $highlightMonths[] = $start->format('n'); // ดึงเดือน (1-12)
                        $start->modify('+1 month'); // เลื่อนเดือนเพิ่มทีละ 1
                    }
                }
                // dd($highlightMonths);


                $htmlContent .= '
                <tr>
                    <td style="text-align: left;">' . ($index + 1) . '. ' . $stepName . '</td>
                    <td' . (in_array(10, $highlightMonths) ? ' class="highlight"' : '') . '></td>
                    <td' . (in_array(11, $highlightMonths) ? ' class="highlight"' : '') . '></td>
                    <td' . (in_array(12, $highlightMonths) ? ' class="highlight"' : '') . '></td>
                    <td' . (in_array(1, $highlightMonths) ? ' class="highlight"' : '') . '></td>
                    <td' . (in_array(2, $highlightMonths) ? ' class="highlight"' : '') . '></td>
                    <td' . (in_array(3, $highlightMonths) ? ' class="highlight"' : '') . '></td>
                    <td' . (in_array(4, $highlightMonths) ? ' class="highlight"' : '') . '></td>
                    <td' . (in_array(5, $highlightMonths) ? ' class="highlight"' : '') . '></td>
                    <td' . (in_array(6, $highlightMonths) ? ' class="highlight"' : '') . '></td>
                    <td' . (in_array(7, $highlightMonths) ? ' class="highlight"' : '') . '></td>
                    <td' . (in_array(8, $highlightMonths) ? ' class="highlight"' : '') . '></td>
                    <td' . (in_array(9, $highlightMonths) ? ' class="highlight"' : '') . '></td>
                </tr>
                ';
            }

            $htmlContent .= '
                    </tbody>
                </table>
            </body>
            ';
        }

        $minStartDate = null; // เก็บวันที่เริ่มต้นที่น้อยที่สุด
        $maxEndDate = null;   // เก็บวันที่สิ้นสุดที่มากที่สุด

        foreach ($pro_steps as $step) {
            $startDate = $step->start ?? null; // วันที่เริ่มต้น
            $endDate = $step->end ?? null;    // วันที่สิ้นสุด

            if ($startDate) {
                $start = Carbon::parse($startDate);
                // อัปเดต $minStartDate ถ้า $start น้อยกว่า หรือ $minStartDate ยังเป็น null
                if (!$minStartDate || $start->lessThan($minStartDate)) {
                    $minStartDate = $start;
                }
            }

            if ($endDate) {
                $end = Carbon::parse($endDate);
                // อัปเดต $maxEndDate ถ้า $end มากกว่า หรือ $maxEndDate ยังเป็น null
                if (!$maxEndDate || $end->greaterThan($maxEndDate)) {
                    $maxEndDate = $end;
                }
            }
        }

        // ตรวจสอบผลลัพธ์
        if ($minStartDate) {
            $startDay = $minStartDate->day;
            $startMonth = $minStartDate->translatedFormat('F');
            $startYear = $minStartDate->year + 543;
            $formattedStartDate = "{$startDay} {$startMonth} {$startYear}";
        } else {
            $formattedStartDate = 'ไม่มีวันที่เริ่มต้น';
        }

        if ($maxEndDate) {
            $endDay = $maxEndDate->day;
            $endMonth = $maxEndDate->translatedFormat('F');
            $endYear = $maxEndDate->year + 543;
            $formattedEndDate = "{$endDay} {$endMonth} {$endYear}";
        } else {
            $formattedEndDate = 'ไม่มีวันที่สิ้นสุด';
        }

        // สร้างข้อความแสดงผล
        $htmlContent .= '
        <b>11. ระยะเวลาดำเนินงาน : </b> เริ่มต้น ' . $formattedStartDate .
            ' สิ้นสุด ' . $formattedEndDate . ' <br>';


        $htmlContent .= '
            <b>12. แหล่งเงิน / ประเภทงบประมาณที่ใช้ / แผนงาน </b><br>
        ';



        foreach ($badget_types as $badget_type) {
            if ($projects->badID == $badget_type->badID) {
                // if ($projects && $badget_types && $projects->badID == $badget_types->badID) {
                $htmlContent .= '
                <div>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="checkbox"> ✓ </span> &nbsp; ' . $badget_type->name . '<br>
                </div>
                
            ';
            }
        }


        $htmlContent .= '
            <b>13. ประมาณค่าใช้จ่าย : ( หน่วย : บาท ) </b><br>
        ';

        $htmlContent .= '
        <body>
            <table border="1" style="border-collapse: collapse; width: 100%; text-align: center; margin-bottom: 7px;">
                <thead>
                    <tr>
                        <td rowspan="3">ประเภทการจ่าย</td>
                        <td rowspan="2">รวม</td>
                    </tr>
                    <tr>
                        <td>ไตรมาส 1</td>
                        <td>ไตรมาส 2</td>
                        <td>ไตรมาส 3</td>
                        <td>ไตรมาส 4</td>
                    </tr>
                    <tr>
                        <td>แผนการใช้จ่าย</td>
                        <td>แผนการใช้จ่าย</td>
                        <td>แผนการใช้จ่าย</td>
                        <td>แผนการใช้จ่าย</td>
                        <td>แผนการใช้จ่าย</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>-</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>รวมเงินงบประมาณ</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                </tbody>
            </table>
        </body>
        ';

        $htmlContent .= '
            <b>14. ประมาณการงบประมาณที่ใช้ : </b> - <br>
            <b>15. ประโยชน์ที่คาดว่าจะได้รับ </b><br>
        
        ';

        $htmlContent .= '';

        if (DB::table('benefits')->where('proID', $id)->exists()) {
            // ดึงข้อมูลที่ตรงกับ proID
            $bnfs = DB::table('benefits')->where('proID', $id)->get();

            $counter = 1; // ตัวแปรเก็บลำดับ
            foreach ($bnfs as $bnf) {
                $htmlContent .= '
                    &nbsp;&nbsp;&nbsp;&nbsp;15.' . $counter . ' ' . $bnf->detail . ' <br>
                ';
                $counter++;
            }
        }


        $htmlContent .= '
            <div style="width: 100%; height: 100px;"></div>
            <div style="width: 50%; height: 50px;"></div>

        ';

        $htmlContent .= '
        <div style="text-align: right;">
            <div style="width: 300px; text-align: center; float: right;">
                ลงชื่อ ................................................. <br>
                ( ' . $username->username . ' ) <br>
                ผู้รับผิดชอบโครงการ <br>
                วันที่ ........../......................./..........
            </div>
        </div>
        ';


        $mpdf->WriteHTML($stylesheet, 1);              // โหลด CSS  
        $mpdf->WriteHTML($htmlContent, 2);             // เขียนเนื้อหา HTML ลงใน PDF

        return $mpdf->Output('แบบเสนอโครงการประจำปีงบประมาณ.pdf', 'I');       // ส่งไฟล์ PDF กลับไปให้ผู้ใช้
    }
}
