<?php

namespace App\Http\Controllers;

use App\Models\BadgetType;
use App\Models\CostQuarters;
use App\Models\CostTypes;
use App\Models\CountKPIProjects;
use App\Models\ExpenseBadgets;
use App\Models\Funds;
use App\Models\Goals;
use App\Models\KPIMain2Level;
use App\Models\KPIProjects;
use App\Models\Objectives;
use App\Models\ProjectCharec;
use App\Models\ProjectIntegrat;
use App\Models\Projects;
use App\Models\Strategic1Level;
use App\Models\Strategic1LevelMapProject;
use App\Models\Strategic2Level;
use App\Models\Strategic2LevelMapProject;
use App\Models\Strategic3Level;
use App\Models\StrategicIssues;
use App\Models\StrategicIssues2Level;
use App\Models\StrategicMap;
use App\Models\Tactic2Level;
use App\Models\Tactics;
use App\Models\Target1Level;
use App\Models\UniPlan;
use App\Models\Users;
use App\Models\UsersMapProject;
use App\Models\Year;
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


        // ดึงข้อมูลผู้ใช้จากฐานข้อมูล
        // $projects = Projects::where('proID', $id)->first();
        $projects = Projects::all();
        $years = Year::all();
        $users_map = UsersMapProject::all();
        $users = Users::all();

        $strategic_maps = StrategicMap::all();
        $strategic1_level_maps = Strategic1LevelMapProject::all();
        $strategic2_level_maps = Strategic2LevelMapProject::all();

        $strategic_issues = StrategicIssues::all();
        $strategic_issue2_levels = StrategicIssues2Level::all();

        $strategics = Strategic3Level::all();
        $strategic2_levels = Strategic2Level::all();
        $strategic1_levels = Strategic1Level::all();


        $goals = Goals::all();
        $target1_levels = Target1Level::all();

        $tactics = Tactics::all();
        $tactic2_levels = Tactic2Level::all();

        $KPI_pros = KPIProjects::all();
        $KPI_main2_levels = KPIMain2Level::all();


        $plans = UniPlan::all();
        $funds = Funds::all();
        $badget_types = BadgetType::all();
        $expense_badgets = ExpenseBadgets::all();
        $cost_quarters = CostQuarters::all();
        $cost_types = CostTypes::all();

        $badget_types = BadgetType::all();

        $countKPI_pros = CountKPIProjects::all();
        $project_integrats = ProjectIntegrat::all();
        $project_charecs = ProjectCharec::all();
        $objects = Objectives::all();


        $htmlContent = '
            <div style="text-align: center; margin-bottom: 8px;">
                <b> แผนปฏิบัติการประจำปีงบประมาณ พ.ศ.2567 <br>
                    สำนักคอมพิวเตอร์และเทคโนโลยีสารสนเทศ
                </b>
            </div>
        ';

        $htmlContent .= '
            <table border="1" style="border-collapse: collapse; width: 100%; margin-bottom: 7px;">
                <tr>
                    <th rowspan="3">ประเด็นยุทธ์ศาสตร์ / เป้าประสงค์</th>
                    <th rowspan="3">กลยุทธ์<br>(หน่วยงาน)</th>
                    <th rowspan="3">โครงการ / ตัวชี้วัดโครงการ</th>
                    <th rowspan="3">ค่าเป้าหมายโครงการ</th>
                    <th colspan="3">งบประมาณ (บาท)</th>
                    <th colspan="12">ระยะเวลาดำเนินงาน</th>
                    <th rowspan="3">ผู้รับผิดชอบ</th>
                </tr>

                <tr>
                    <th rowspan="2">เงินเหลือจาก มจพ.</th>
                    <th rowspan="2">เงินรายได้ประจำปี</th>
                    <th rowspan="2">เงินเหลือจ่ายสนง.</th>
                    <th colspan="3">พ.ศ.</th>
                    <th colspan="9">พ.ศ.</th>
                </tr>

                <tr>
                    <th>ต.ค.</th>
                    <th>พ.ย.</th>
                    <th>ธ.ค.</th>
                    <th>ม.ค.</th>
                    <th>ก.พ.</th>
                    <th>มี.ค.</th>
                    <th>เม.ย.</th>
                    <th>พ.ค.</th>
                    <th>มิ.ย.</th>
                    <th>ก.ค.</th>
                    <th>ส.ค.</th>
                    <th>ก.ย.</th>
                </tr>
            
        ';

        $currentYear = intval(date("Y")) + 543;
        // foreach ($strategic_issues as $strategic_issue) {
        //     $hasCurrentYear = false;

        //     foreach ($strategics as $strategic) {
        //         if (isset($strategic->year->year) && intval($strategic->year->year) === $currentYear) {
        //             // dd($strategic->year->year);
        //             $hasCurrentYear = true;
        //             // break;
        //         }
        //     }

        //     if ($hasCurrentYear) {
        //         $htmlContent .= '
        //             <tr>
        //                 <th colspan="20" style="text-align: left;">ประเด็น' . htmlspecialchars($strategic_issue->name) . '</th>
        //             </tr>
        //         ';
        //     }

        //     foreach($goals as $goal){
        //         $htmlContent .= '
        //             <tr>
        //                 <th colspan="20" style="text-align: left;">เป้าประสงค์ที่ ' . htmlspecialchars($goal->name) . '</th>
        //             </tr>
        //         ';
        //     }
        // }

        // foreach($strategic_maps as $strategic_map){
        foreach ($strategics as $strategic) {
            if ($strategic->year->year == $currentYear) {
                // dd($strategic->year->year);
                foreach ($strategic_issues as $strategic_issue) {
                    if ($strategic->stra3LVID == $strategic_issue->stra3LVID) {
                        $htmlContent .= '
                                <tr>
                                    <th colspan="20" style="text-align: left; background-color:rgb(249, 241, 88);">ประเด็น' . htmlspecialchars($strategic_issue->name) . '</th>
                                </tr>
                            ';
                    }
                    foreach ($goals as $goal) {
                        if ($strategic_issue->SFA3LVID == $goal->SFA3LVID) {
                            $htmlContent .= '
                                    <tr>
                                        <th colspan="20" style="text-align: left;">เป้าประสงค์ที่ ' . htmlspecialchars($goal->name) . '</th>
                                    </tr>
                                ';
                        }
                        foreach ($tactics as $tactic) {
                            if ($goal->goal3LVID == $tactic->goal3LVID) {
                                $htmlContent .= '
                                    <tr>
                                        <td></td>
                                        <td style="text-align: left;">' . htmlspecialchars($tactic->name) . '</td>
                                    </tr>
                                ';
                            }
                        }
                    }
                }
            }
        }
        // }







        $htmlContent .= '</table>';

        // $htmlContent .= '
        //     <table border="1" style="border-collapse: collapse; width: 100%; margin-bottom: 7px;">
        //         <tr>
        //             <td rowspan="2" style="width: 45%;">Project</td>
        //             <td colspan="3">พ.ศ.2566</td>
        //             <td colspan="9">พ.ศ.2567</td>
        //         </tr>

        //         <tr>
        //             <td>ต.ค.</td>
        //             <td>พ.ย.</td>
        //             <td>ธ.ค.</td>
        //             <td>ม.ค.</td>
        //             <td>ก.พ.</td>
        //             <td>มี.ค.</td>
        //             <td>เม.ย.</td>
        //             <td>พ.ค.</td>
        //             <td>มิ.ย.</td>
        //             <td>ก.ค.</td>
        //             <td>ส.ค.</td>
        //             <td>ก.ย.</td>
        //         </tr>';

        // foreach ($projects as $project) {

        //     $htmlContent .= '<tr>';
        //     $htmlContent .= '<td style="text-align: left;">' . $project->name . '</td>'; 
        //     for ($i = 0; $i < 12; $i++) {
        //         $htmlContent .= '<td></td>'; // คอลัมน์เดือนว่าง
        //     }
        //     $htmlContent .= '</tr>';
        // }

        // $htmlContent .= '</table>';


        $mpdf->WriteHTML($stylesheet, 1);              // โหลด CSS  
        $mpdf->WriteHTML($htmlContent, 2);             // เขียนเนื้อหา HTML ลงใน PDF

        $mpdf->SetTitle('แผนปฏิบัติการประจำปีงบประมาณ พ.ศ.2567');
        return $mpdf->Output('แผนปฏิบัติการประจำปีงบประมาณ พ.ศ.2567.pdf', 'I');       // ส่งไฟล์ PDF กลับไปให้ผู้ใช้
    }
}
