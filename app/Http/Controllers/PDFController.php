<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Mpdf\Mpdf;
use DateTime;
use Carbon\Carbon;

use App\Models\Benefits;
use App\Models\CostQuarters;
use App\Models\CostTypes;
use App\Models\ExpenseBadgets;
use App\Models\Funds;
use App\Models\Goals;
use App\Models\KPIProjects;
use App\Models\Objectives;
use App\Models\StrategicIssues;
use App\Models\StrategicMap;
use App\Models\Strategics;
use App\Models\Tactics;
use App\Models\UniPlan;
use App\Models\Users;
use App\Models\Year;
use App\Models\ProjectCharec;
use App\Models\ProjectIntegrat;
use App\Models\Projects;
use App\Models\Targets;
use App\Models\BadgetType;
use App\Models\CountKPIProjects;
use App\Models\UsersMapProject;

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
        $projects = Projects::where('proID', $id)->first();
        $years = Year::all();
        $users_map = UsersMapProject::all();
        $users = Users::all();
        $strategic_maps = StrategicMap::all();
        $strategic_issues = StrategicIssues::all();
        $strategics = Strategics::all();
        $goals = Goals::all();
        $tactics = Tactics::all();
        $plans = UniPlan::all();
        $funds = Funds::all();
        $badget_types = BadgetType::all();
        $expense_badgets = ExpenseBadgets::all();
        $cost_quarters = CostQuarters::all();
        $cost_types = CostTypes::all();

        $badget_types = BadgetType::all();
        $KPI_pros = KPIProjects::all();
        $countKPI_pros = CountKPIProjects::all();
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

            .justified-text {
                text-align: justify;
                line-height: 1.5; /* กำหนดระยะห่างบรรทัดให้ดูอ่านง่าย */
                font-size: 14px; /* ขนาดตัวอักษร */
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
                    <p style="text-align: center; font-weight: bold;">แบบเสนอโครงการ ประจำปีงบประมาณ พ.ศ.' . $year->year . '
                        <br>มหาวิทยาลัยเทคโนโลยีพระจอมเกล้าพระนครเหนือ
                    </p>
                ';
                $mpdf->SetTitle('แบบเสนอโครงการประจำปีงบประมาณ ' . $year->year);
            }
        }


        $htmlContent .= '
        <b>1. ชื่อโครงการ : </b>' . $projects->name . '<br>
        ';


        // foreach ($users_map as $user_map) {
        //     if ($projects->proID == $user_map->proID) {
        //         foreach ($users as $user) {
        //             if ($user->userID == $user_map->userID) {
        //                 $htmlContent .= '
        //                     <b>2. สังกัด :  </b><br>
        //                     <b>&nbsp;&nbsp;&nbsp;&nbsp;' . $user->department_name . ' </b><br>
        //                     <b>&nbsp;&nbsp;&nbsp;&nbsp;ผู้รับผิดชอบ : </b>' . $user->username . ' <br>
        //                 ';
        //                 $name = $user->username;
        //                 // dd($name);
        //             }
        //         }
        //     }
        // }

        // $htmlContent .= '<b>2. สังกัด :</b><br>';

        // // สร้างอาร์เรย์สำหรับเก็บข้อมูลสังกัดและชื่อผู้รับผิดชอบ
        // $departments = [];
        // $responsibleNames = [];

        // // วนลูปเพื่อดึงข้อมูลจาก users_map และ users
        // foreach ($users_map as $user_map) {
        //     if ($projects->proID == $user_map->proID) {
        //         foreach ($users as $user) {
        //             if ($user->userID == $user_map->userID) {
        //                 // เพิ่มสังกัดในอาร์เรย์ หากยังไม่มี
        //                 if (!in_array($user->department_name, $departments)) {
        //                     $departments[] = $user->department_name;
        //                 }
        //                 // เพิ่มชื่อในอาร์เรย์ผู้รับผิดชอบ
        //                 $responsibleNames[] = $user->username;
        //             }
        //         }
        //     }
        // }

        // // แสดงข้อมูลสังกัด
        // foreach ($departments as $department) {
        //     $htmlContent .= '<b>&nbsp;&nbsp;&nbsp;&nbsp;' . $department . '</b><br>';
        // }

        // // แสดงข้อมูลผู้รับผิดชอบ
        // $htmlContent .= '<b>&nbsp;&nbsp;&nbsp;&nbsp;ผู้รับผิดชอบ :</b>';
        // foreach ($responsibleNames as $name) {
        //     $htmlContent .= '&nbsp;&nbsp;&nbsp;&nbsp;' . $name . '<br>';
        // }

        $htmlContent .= '<b>2. สังกัด :</b><br>';

        // สร้างอาร์เรย์สำหรับเก็บข้อมูลสังกัดและชื่อผู้รับผิดชอบ
        $departments = [];
        $responsibleNames = [];

        // วนลูปเพื่อดึงข้อมูลจาก users_map และ users
        foreach ($users_map as $user_map) {
            if ($projects->proID == $user_map->proID) {
                foreach ($users as $user) {
                    if ($user->userID == $user_map->userID) {
                        // เพิ่มสังกัดในอาร์เรย์ หากยังไม่มี
                        if (!in_array($user->department_name, $departments)) {
                            $departments[] = $user->department_name;
                        }
                        // เพิ่มชื่อในอาร์เรย์ผู้รับผิดชอบ
                        $responsibleNames[] = $user->username;
                        $name = $user->username;
                    }
                }
            }
        }

        // แสดงข้อมูลสังกัด
        foreach ($departments as $department) {
            $htmlContent .= '<b>&nbsp;&nbsp;&nbsp;&nbsp;' . $department . '</b><br>';
        }

        // แสดงข้อมูลผู้รับผิดชอบในรูปแบบชื่อคั่นด้วย ","
        if (!empty($responsibleNames)) {
            $htmlContent .= '<b>&nbsp;&nbsp;&nbsp;&nbsp;ผู้รับผิดชอบ :</b> ' . implode(', ', $responsibleNames) . '<br>';
        }




        foreach ($strategic_maps as $strategic_map) {
            if ($projects->proID == $strategic_map->proID) {
                // $htmlContent .= '<b>ข้อมูลสำหรับโครงการที่ ' . $strategic_map->proID . '</b><br>';

                // เช็คชื่อจาก straID
                foreach ($strategics as $strategic) {
                    if ($strategic->straID == $strategic_map->straID) {
                        $htmlContent .= '<b>3. ความเชื่อมโยงสอดคล้องกับ ' . $strategic->name . '</b> <br>';
                        break; // เจอข้อมูลแล้วออกจากลูป
                    }
                }

                // เช็คชื่อจาก SFAID
                foreach ($strategic_issues as $strategic_issue) {
                    if ($strategic_issue->SFAID == $strategic_map->SFAID) {
                        $htmlContent .= '<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ประเด็นยุทธศาสตร์ที่ </b>' . $strategic_issue->name . '<br>';
                        break; // เจอข้อมูลแล้วออกจากลูป
                    }
                }

                // เช็คชื่อจาก goalID
                foreach ($goals as $goal) {
                    if ($goal->goalID == $strategic_map->goalID) {
                        $htmlContent .= '<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เป้าประสงค์ที่ </b>' . $goal->name . '<br>';
                        break; // เจอข้อมูลแล้วออกจากลูป
                    }
                }

                // เช็คชื่อจาก tacID
                foreach ($tactics as $tactic) {
                    if ($tactic->tacID == $strategic_map->tacID) {
                        $htmlContent .= '<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;กลยุทธ์ที่ </b>' . $tactic->name . '<br>';
                        break; // เจอข้อมูลแล้วออกจากลูป
                    }
                }
            }
        }



        $htmlContent .= '
            <b>4. ลักษณะโครงการ / กิจกรรม</b> <br>
            &nbsp;&nbsp;&nbsp;&nbsp;
        ';


        foreach ($project_charecs as $project_charec) {
            if ($projects->proChaID == $project_charec->proChaID) {
                $htmlContent .= '
                    <span style="font-family: DejaVu Sans, Arial, sans-serif;">☑</span> &nbsp; ' . $project_charec->name . ' &nbsp;
                ';
            } else {
                $htmlContent .= '
                    <span style="font-family: DejaVu Sans, Arial, sans-serif;">☐</span> &nbsp; ' . $project_charec->name . ' &nbsp;
                ';
            }
        }

        $htmlContent .= '
        <br><b>5. การบูรณาการโครงการ </b> <br> 
        ';

        foreach ($project_integrats as $project_integrat) {
            if ($projects->proInID == $project_integrat->proInID) {
                $htmlContent .= '
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-family: DejaVu Sans, Arial, sans-serif;">☑</span> &nbsp; ' . $project_integrat->name . '<br>
                ';
            } else {
                $htmlContent .= '
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-family: DejaVu Sans, Arial, sans-serif;">☐</span> &nbsp; ' . $project_integrat->name . '<br>
                ';
            }
        }

        // &nbsp;&nbsp;&nbsp;&nbsp;' . $projects->princiDetail . ' <br>

        $htmlContent .= '
            <b>6. หลักการและเหตุผลของโครงการ </b> <br> 
            &nbsp;&nbsp;&nbsp;&nbsp;' . $projects->princiDetail . ' <br>
            <b>7. วัตถุประสงค์ </b> <br> 
        ';

        $htmlContent .= '';
        if (DB::table('objectives')->where('proID', $id)->exists()) {
            // ดึงข้อมูลที่ตรงกับ proID
            $objects = DB::table('objectives')->where('proID', $id)->get();

            $counter = 1; // ตัวแปรเก็บลำดับ
            foreach ($objects as $object) {
                $htmlContent .= '
                    &nbsp;&nbsp;&nbsp;&nbsp;7.' . $counter . ' ' . $object->detail . ' <br>
                ';
                $counter++;
            }
        }

        $htmlContent .= '
        <b>8. ตัวชี้วัดความสำเร็จระดับโครงการ </b> <br>';

        if (DB::table('k_p_i_projects')->where('proID', $id)->exists()) {
            // ดึงข้อมูลจาก k_p_i_projects
            $KPI_pros = DB::table('k_p_i_projects')->where('proID', $id)->get();

            // ดึงข้อมูลจากตารางหน่วยนับ 
            $countKPI_pros = DB::table('count_k_p_i_projects')->get();

            // เริ่มสร้าง HTML ตาราง
            $htmlContent .= '
                <table border="1" style="border-collapse: collapse; width: 100%; margin-bottom: 7px;">
                    <thead>
                        <tr>
                            <th style="padding: 8px; width: 60%; ">ตัวชี้วัดความสำเร็จ</th>
                            <th style="padding: 8px; width: 20%; ">หน่วยนับ</th>
                            <th style="padding: 8px; width: 20%; ">ค่าเป้าหมาย</th>
                        </tr>
                    </thead>
                    <tbody>
            ';

            foreach ($KPI_pros as $KPI_pro) {
                // เริ่มต้นค่าเริ่มต้นของหน่วยนับ
                $unitName = '-';

                // เช็คว่ามีหน่วยนับที่ countKPIProID ตรงกันหรือไม่
                foreach ($countKPI_pros as $countKPI_pro) {
                    if ($KPI_pro->countKPIProID == $countKPI_pro->countKPIProID) {
                        $unitName = $countKPI_pro->name; // ดึงชื่อหน่วยนับ
                        break; // ออกจาก loop เมื่อเจอข้อมูลที่ตรงกัน
                    }
                }

                // เพิ่มแถวในตาราง
                $htmlContent .= '
                    <tr>
                        <td style="padding: 8px; text-align: left;">' . $KPI_pro->name . '</td>
                        <td style="padding: 8px; text-align: left;">' . $unitName . '</td>
                        <td style="padding: 8px; text-align: left;">' . $KPI_pro->target . '</td>
                    </tr>';
            }

            $htmlContent .= '
                    </tbody>
                </table>';
        }


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
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-family: DejaVu Sans, Arial, sans-serif;">☑</span> &nbsp; ' . $badget_type->name . '<br>
                </div>
                
            ';
            }
        }


        $htmlContent .= '
            <b>13. ประมาณค่าใช้จ่าย : ( หน่วย : บาท ) </b><br>
        ';

        // foreach($plans as $plan){
        //     if($project->planID == $plan->planID)
        //     foreach($funds as $fund){

        //     }
        // }

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
                    <tbody>';

        // สมมติว่ามีข้อมูลจากตาราง cost_types และ expense_badgets
        $totalCost = 0;
        $sumTotal = 0;
        $sumQu1 = 0;
        $sumQu2 = 0;
        $sumQu3 = 0;
        $sumQu4 = 0;


        foreach ($cost_quarters as $cost_quarter) {
            if ($projects->proID == $cost_quarter->proID) {

                $totalCost = $cost_quarter->costQu1 + $cost_quarter->costQu2 + $cost_quarter->costQu3 + $cost_quarter->costQu4;

                // สะสมค่าในตัวแปรผลรวม
                $sumTotal += $totalCost;
                $sumQu1 += $cost_quarter->costQu1;
                $sumQu2 += $cost_quarter->costQu2;
                $sumQu3 += $cost_quarter->costQu3;
                $sumQu4 += $cost_quarter->costQu4;

                foreach ($expense_badgets as $expense_badget) {
                    if ($cost_quarter->expID == $expense_badget->expID) {

                        $htmlContent .= '
                    <tr>
                        <td style="text-align: left;">' . $expense_badget->name . '</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                    
                ';
                    }
                }

                foreach ($cost_types as $cost_type) {
                    if ($cost_quarter->costID == $cost_type->costID) {
                        $htmlContent .= '
                            <tr>
                                <td style="text-align: left;">' .  $cost_type->name . '</td>
                                <td>' . number_format($totalCost, 2) . '</td>
                                <td>' . number_format($cost_quarter->costQu1, 2) . '</td>
                                <td>' . number_format($cost_quarter->costQu2, 2) . '</td>
                                <td>' . number_format($cost_quarter->costQu3, 2) . '</td>
                                <td>' . number_format($cost_quarter->costQu4, 2) . '</td>
                            </tr>
                        ';
                    }
                }
            }
        }

        // รวมเงินงบประมาณทั้งหมด
        $htmlContent .= '
            <tr>
                <td>รวมเงินงบประมาณ</td>
                <td>' . number_format($sumTotal, 2) . '</td>
                <td>' . number_format($sumQu1, 2) . '</td>
                <td>' . number_format($sumQu2, 2) . '</td>
                <td>' . number_format($sumQu3, 2) . '</td>
                <td>' . number_format($sumQu4, 2) . '</td>
            </tr>
            </tbody>
        </table>
        </body>
        ';


        $htmlContent .= '
            <b>14. ประมาณการงบประมาณที่ใช้ : </b> ' . number_format($sumTotal, 2) . ' บาท<br>
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
                ( ' . $name . ' ) <br>
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
