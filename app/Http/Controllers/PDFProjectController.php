<?php

namespace App\Http\Controllers;

use App\Models\KPIMain2Level;
use App\Models\Strategic1Level;
use App\Models\Strategic1LevelMapProject;
use App\Models\Strategic2Level;
use App\Models\Strategic2LevelMapProject;
use App\Models\Strategic3Level;
use App\Models\StrategicIssues2Level;
use App\Models\Tactic2Level;
use App\Models\Target1Level;
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

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Mpdf\Finance\Finance;
use Mpdf\Mpdf;
use DateTime;
use Carbon\Carbon;

Carbon::setLocale('th');

class PDFProjectController extends Controller
{
    public function db_gen($id)
    {
        // ตรวจสอบว่า $id มีค่าหรือไม่
        if (empty($id)) {
            return response()->json(['message' => 'ไม่มีข้อมูลของโครงการ'], 400, [], JSON_UNESCAPED_UNICODE);
        }

        // ดึงข้อมูลผู้ใช้จากฐานข้อมูล
        $projects = Projects::where('proID', $id)->first();
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


        $config = include(config_path('configPDF_V.php'));       // ดึงการตั้งค่าฟอนต์จาก config
        $mpdf = new Mpdf($config);                            // สร้าง instance ของ Mpdf ด้วยการตั้งค่าจาก config

        // กำหนดระยะห่างระหว่างโลโก้และเนื้อหา
        $mpdf->SetY(60);                                            // ตั้งระยะห่างจากขอบบนก่อนที่จะเริ่มเขียนเนื้อหา

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
                !important;
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

        // ตรวจสอบว่าพบข้อมูลโครงการหรือไม่
        if (!$projects) {
            return response()->json(['message' => 'ไม่มีข้อมูลของโครงการ'], 400, [], JSON_UNESCAPED_UNICODE);
        }

        if ($projects && $projects->yearID) {
            foreach ($years as $year) {
                if ($projects->yearID == $year->yearID) {
                    $htmlContent .= '
                        <p style="text-align: center; font-weight: bold;">แบบเสนอโครงการ ประจำปีงบประมาณ พ.ศ.' . $year->year . '
                            <br>มหาวิทยาลัยเทคโนโลยีพระจอมเกล้าพระนครเหนือ
                        </p>
                    ';
                    $mpdf->SetTitle($projects->name);
                }
            }
        } else {
            return redirect()->back()->with('error', 'ไม่พบข้อมูลโครงการ');
        }



        $htmlContent .= '
        <b>1. ชื่อโครงการ : </b>' . $projects->name . '<br>
        ';

        $htmlContent .= '<b>2. สังกัด : </b><br>';

        // สร้างอาร์เรย์สำหรับเก็บข้อมูลสังกัดและชื่อผู้รับผิดชอบ
        $departments = [];
        $responsibleNames = [];
        $names = [];  // เพิ่มอาร์เรย์เพื่อเก็บชื่อ


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
                        $responsibleNames[] = $user->displayname;
                        $names[] = $user->displayname;
                    }
                }
            }
        }
        // dd($departments);



        // ตรวจสอบว่ามีข้อมูลหรือไม่
        if (empty($departments) && empty($responsibleNames)) {
            $htmlContent .= 'ไม่มีข้อมูล <br>';
        } else {

            // แสดงข้อมูลสังกัด
            foreach ($departments as $department) {
                $htmlContent .= '<b>&nbsp;&nbsp;&nbsp;&nbsp;' . $department . '</b><br>';
            }

            // แสดงข้อมูลผู้รับผิดชอบในรูปแบบชื่อคั่นด้วย ","
            if (!empty($responsibleNames)) {
                $htmlContent .= '<b>&nbsp;&nbsp;&nbsp;&nbsp;ผู้รับผิดชอบ :</b> ' . implode(', ', $responsibleNames) . '<br>';
            }
        }

        $htmlContent .= '<b>3. ความเชื่อมโยงสอดคล้องกับ </b>';
        $plans = [];

        foreach ($strategic_maps as $strategic_map) {
            if ($projects->proID == $strategic_map->proID) {
                $planDetails = [];
                foreach ($strategics as $strategic) {
                    if ($strategic->stra3LVID == $strategic_map->stra3LVID) {
                        $planDetails[] = '<b>' . $strategic->name . '</b>';
                        break;
                    }
                }
                foreach ($strategic_issues as $strategic_issue) {
                    if ($strategic_issue->SFAID == $strategic_map->SFAID) {
                        $planDetails[] = '<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ประเด็นยุทธศาสตร์ที่ </b>' . $strategic_issue->name;
                        break;
                    }
                }
                foreach ($goals as $goal) {
                    if ($goal->goalID == $strategic_map->goalID) {
                        $planDetails[] = '<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เป้าประสงค์ที่ </b>' . $goal->name;
                        break;
                    }
                }
                foreach ($tactics as $tactic) {
                    if ($tactic->tacID == $strategic_map->tacID) {
                        $planDetails[] = '<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;กลยุทธ์ที่ </b>' . $tactic->name;
                        break;
                    }
                }
                $plans[] = implode('<br>', $planDetails);
            }
        }

        foreach ($strategic2_level_maps as $strategic2_level_map) {
            if ($projects->proID == $strategic2_level_map->proID) {
                $planDetails = [];
                foreach ($strategic2_levels as $strategic2_level) {
                    if ($strategic2_level->stra2LVID == $strategic2_level_map->stra2LVID) {
                        $planDetails[] = '<b>' . $strategic2_level->name . '</b>';
                        break;
                    }
                }
                foreach ($strategic_issue2_levels as $strategic_issue2_level) {
                    if ($strategic_issue2_level->SFA2LVID == $strategic2_level_map->SFA2LVID) {
                        $planDetails[] = '<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ประเด็นยุทธศาสตร์ที่ </b>' . $strategic_issue2_level->name;
                        break;
                    }
                }
                foreach ($tactic2_levels as $tactic2_level) {
                    if ($tactic2_level->tac2LVID == $strategic2_level_map->tac2LVID) {
                        $planDetails[] = '<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;กลยุทธ์ที่ </b>' . $tactic2_level->name;
                        break;
                    }
                }
                $plans[] = implode('<br>', $planDetails);
            }
        }

        foreach ($strategic1_level_maps as $strategic1_level_map) {
            if ($projects->proID == $strategic1_level_map->proID) {
                $planDetails = [];
                foreach ($strategic1_levels as $strategic1_level) {
                    if ($strategic1_level->stra1LVID == $strategic1_level_map->stra1LVID) {
                        $planDetails[] = '<b>' . $strategic1_level->name . '</b>';
                        break;
                    }
                }
                foreach ($target1_levels as $target1_level) {
                    if ($target1_level->tac1LVID == $strategic1_level_map->tac1LVID) {
                        $planDetails[] = '<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เป้าหมายที่ </b>' . $target1_level->name;
                        break;
                    }
                }
                $plans[] = implode('<br>', $planDetails);
            }
        }

        if (count($plans) == 1) {
            $htmlContent .= $plans[0] . '<br>';
        } elseif (count($plans) > 1) {
            $htmlContent .= '<br>';
            $index = 1;
            foreach ($plans as $plan) {
                $htmlContent .= '<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3.' . $index . ' ' . '</b>' . $plan . '<br>';
                $index++;
            }
        }

        $htmlContent .= '
            <div style="page-break-inside: avoid;">
                <b>4. ลักษณะโครงการ / กิจกรรม</b> <br>
                &nbsp;&nbsp;&nbsp;&nbsp;
        ';

        foreach ($project_charecs as $project_charec) {
            $checked = ($projects->proChaID == $project_charec->proChaID) ? '☑' : '☐';

            $htmlContent .= '
                <span style="font-family: DejaVu Sans, Arial, sans-serif;">' . $checked . '</span> &nbsp; ' . $project_charec->name . ' &nbsp;
            ';
        }

        $htmlContent .= '</div>';

        $htmlContent .= '
            <div style="page-break-inside: avoid;">
                <b>5. การบูรณาการโครงการ </b> <br>
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

        $htmlContent .= '</div>';

        $htmlContent .= '
            <div style="page-break-inside: avoid;">
                <b>6. หลักการและเหตุผลของโครงการ</b> <br>
                <div style="text-align: justify; text-indent: 2em;">
                    ' . nl2br($projects->princiDetail) . ' <br>
                </div>
            </div>
        ';


        $htmlContent .= '
            <div style="page-break-inside: avoid;">
                <b>7. วัตถุประสงค์ </b> <br>
        ';


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

        $htmlContent .= '</div>';

        $htmlContent .= '
            <div style="page-break-inside: avoid;">
            <b>8. ตัวชี้วัดความสำเร็จระดับโครงการ (Output/Outcome) และ ค่าเป้าหมาย (ระบุหน่วยนับ)</b> <br>';

        if (DB::table('k_p_i_projects')->where('proID', $id)->exists()) {
            // ดึงข้อมูลจาก k_p_i_projects
            $KPI_pros = DB::table('k_p_i_projects')->where('proID', $id)->get();

            // ดึงข้อมูลจากตารางหน่วยนับ
            $countKPI_pros = DB::table('count_k_p_i_projects')->get();

            // เริ่มสร้าง HTML ตาราง
            $htmlContent .= '
                <body>
                    <table border="1" style="border-collapse: collapse; width: 100%; margin-bottom: 7px; ">
                        <thead>
                            <tr>
                                <th style="padding: 8px; width: 60%; font-size: 18pt;">ตัวชี้วัดความสำเร็จ</th>
                                <th style="padding: 8px; width: 20%; font-size: 18pt;">หน่วยนับ</th>
                                <th style="padding: 8px; width: 20%; font-size: 18pt;">ค่าเป้าหมาย</th>
                            </tr>
                        </thead>
                    <tbody>
                ';



            foreach ($KPI_pros as $KPI_pro) {
                $unitName = '-';

                // เช็คว่ามีหน่วยนับที่ countKPIProID ตรงกันหรือไม่
                foreach ($countKPI_pros as $countKPI_pro) {
                    if ($KPI_pro->countKPIProID == $countKPI_pro->countKPIProID) {
                        $unitName = $countKPI_pro->name;
                        break;
                    }
                }

                // เพิ่มแถวในตาราง
                $htmlContent .= '
                    <tr>
                        <td style="padding: 8px; text-align: left; font-size: 18pt;">' . $KPI_pro->name . '</td>
                        <td style="padding: 8px; text-align: left; font-size: 18pt;">' . $unitName . '</td>
                        <td style="padding: 8px; text-align: left; font-size: 18pt;">' . $KPI_pro->target . '</td>
                    </tr>';
            }

            $htmlContent .= '
                        </tbody>
                        </table>
                    </body>
                </div>
            ';
        }


        $pro_tars = Projects::with('target')->get();

        foreach ($pro_tars as $pro_tar) {
            // $tarID = $pro_tar->tarID;
            $targetName = $pro_tar->target->name ?? 'N/A'; // ใช้ข้อมูลจากตาราง targets
        }

        $htmlContent .= '
            <div style="page-break-inside: avoid;">
                <b>9. กลุ่มเป้าหมาย (ระบุกลุ่มเป้าหมายและจำนวนกลุ่มเป้าหมายที่เข้าร่วมโครงการ) </b> <br>
                &nbsp;&nbsp;&nbsp;&nbsp; ' . $targetName . ' <br>
            </div>
        ';

        $htmlContent .= '
            <div style="page-break-inside: avoid;">
                <b>10. ขั้นตอนการดำเนินงาน : </b> <br>
        ';

        $pro_steps = DB::table('steps')->where('proID', $id)->get();
        if (DB::table('steps')->where('proID', $id)->exists()) {

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

            // ถ้า $minYear และ $maxYear เป็นปีเดียวกัน ให้เพิ่ม maxYear อีก 1 ปี
            if (is_numeric($minYear) && is_numeric($maxYear) && $minYear === $maxYear) {
                $maxYear += 1;
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
                    <td style="text-align: left;">' . ($index + 1) . '. ' . (!empty($stepName) ? $stepName : 'ไม่มีข้อมูล') . '</td>
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

        $htmlContent .= '</div>';

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


        $htmlContent .= '
            <div style="page-break-inside: avoid;">
                <b>11. ระยะเวลาดำเนินงาน : </b> เริ่มต้น ' . $formattedStartDate . ' สิ้นสุด ' . $formattedEndDate . ' <br>
            </div>
        ';



        $htmlContent .= '
            <div style="page-break-inside: avoid;">
                <b>12. แหล่งเงิน / ประเภทงบประมาณที่ใช้ / แผนงาน</b><br>
        ';

        $hasBudget = false; // ตรวจสอบว่ามีข้อมูลหรือไม่

        foreach ($badget_types as $badget_type) {
            if ($projects->badID == $badget_type->badID) {
                $hasBudget = true;
                $htmlContent .= '
                    <div>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-family: DejaVu Sans, Arial, sans-serif;">☑</span> &nbsp; ' . $badget_type->name . '<br>
                    </div>
                ';
            }
        }

        // ถ้าไม่มีข้อมูล ให้แสดง "ไม่มีข้อมูล"
        if (!$hasBudget) {
            $htmlContent .= '<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ไม่มีข้อมูล</div>';
        }

        $htmlContent .= '</div>';


        $htmlContent .= '
            <div style="page-break-inside: avoid;">
                <b>13. ประมาณค่าใช้จ่าย : ( หน่วย : บาท ) </b><br>
        ';

        $htmlContent .= '
            <div style="page-break-inside: avoid;">
                <table border="1" style="border-collapse: collapse; width: 100%; text-align: center; margin-bottom: 7px;">
                    <thead>
                        <tr>
                            <td rowspan="3" style="width: 24%;">ประเภทการจ่าย</td>
                            <td rowspan="2">รวม</td>
                        </tr>
                        <tr>
                            <td>ไตรมาส 1</td>
                            <td>ไตรมาส 2</td>
                            <td>ไตรมาส 3</td>
                            <td>ไตรมาส 4</td>
                        </tr>
                        <tr>
                            <td style="width: 16%;">แผนการใช้จ่าย</td>
                            <td style="width: 16%;">แผนการใช้จ่าย</td>
                            <td style="width: 16%;">แผนการใช้จ่าย</td>
                            <td style="width: 16%;">แผนการใช้จ่าย</td>
                            <td style="width: 16%;">แผนการใช้จ่าย</td>
                        </tr>
                    </thead>
                    <tbody>';


        $totalCost = 0;
        $sumTotal = 0;
        $sumQu1 = 0;
        $sumQu2 = 0;
        $sumQu3 = 0;
        $sumQu4 = 0;

        $counter = 1;
        $subCounter = 1;
        $prevExpenseName = '';
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
                        // ตรวจสอบชื่อของงบประมาณ
                        if ($prevExpenseName != $expense_badget->name) {
                            $htmlContent .= '
                        <tr>
                            <td style="text-align: left;">' . $counter . '. ' . $expense_badget->name . '</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    ';
                            $subCounter = 1;
                            $counter++;
                        }
                        $prevExpenseName = $expense_badget->name;
                    }
                }

                foreach ($cost_types as $cost_type) {
                    if ($cost_quarter->costID == $cost_type->costID) {
                        $htmlContent .= '
                    <tr>
                        <td style="text-align: left;">&nbsp;&nbsp;&nbsp;' . ($counter - 1) . '.' . $subCounter . ' ' .  $cost_type->name . '</td>
                        <td>' . ($totalCost == 0 ? '-' : number_format($totalCost, 2)) . '</td>
                        <td>' . ($cost_quarter->costQu1 == 0 ? '-' : number_format($cost_quarter->costQu1, 2)) . '</td>
                        <td>' . ($cost_quarter->costQu2 == 0 ? '-' : number_format($cost_quarter->costQu2, 2)) . '</td>
                        <td>' . ($cost_quarter->costQu3 == 0 ? '-' : number_format($cost_quarter->costQu3, 2)) . '</td>
                        <td>' . ($cost_quarter->costQu4 == 0 ? '-' : number_format($cost_quarter->costQu4, 2)) . '</td>
                    </tr>
                ';
                        $subCounter++;
                    }
                }
            }
        }


        function bahtText($number)
        {
            $thaiNumbers = [
                0 => 'ศูนย์',
                1 => 'หนึ่ง',
                2 => 'สอง',
                3 => 'สาม',
                4 => 'สี่',
                5 => 'ห้า',
                6 => 'หก',
                7 => 'เจ็ด',
                8 => 'แปด',
                9 => 'เก้า'
            ];

            $unitNames = ['', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน'];

            $numberStr = strval((int)$number);
            $length = strlen($numberStr);
            $result = '';

            for ($i = 0; $i < $length; $i++) {
                $digit = (int)$numberStr[$i];
                $position = $length - $i - 1;

                if ($digit == 0) continue;

                if ($position == 6) {
                    if ($digit != 1) {
                        $result .= $thaiNumbers[$digit];
                    }
                    $result .= 'ล้าน';
                    continue;
                }

                if ($position == 7 && $digit == 1) {
                    $result .= 'สิบ';
                    continue;
                }

                if ($position == 1 && $digit == 1) {
                    $result .= 'สิบ';
                } elseif ($position == 1 && $digit == 2) {
                    $result .= 'ยี่สิบ';
                } elseif ($position == 0 && $digit == 1 && $length > 1) {
                    $result .= 'เอ็ด';
                } else {
                    $result .= $thaiNumbers[$digit] . ($position > 0 ? $unitNames[$position % 6] : '');
                }
            }

            return $result . 'บาทถ้วน';
        }

        $sumTotalInWords = bahtText($sumTotal);

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
        </div>
        ';

        $htmlContent .= '</div>';


        $htmlContent .= '
            <div style="page-break-inside: avoid;">
                <b>14. ประมาณการงบประมาณที่ใช้ : </b> ' . number_format($sumTotal, 2) . ' บาท    (' . $sumTotalInWords . ')<br>
            </div>

        ';

        $htmlContent .= '
            <div style="page-break-inside: avoid;">
                <b>15. ประโยชน์ที่คาดว่าจะได้รับ </b><br>

        ';


        $bnfs = DB::table('benefits')->where('proID', $id)->get(); // ดึงข้อมูลที่ตรงกับ proID

        if ($bnfs->isNotEmpty()) { // ถ้ามีข้อมูล
            $counter = 1;
            foreach ($bnfs as $bnf) {
                $htmlContent .= '
                    &nbsp;&nbsp;&nbsp;&nbsp;15.' . $counter . ' ' . $bnf->detail . ' <br>
                ';
                $counter++;
            }
        } else {
            $htmlContent .= '&nbsp;&nbsp;&nbsp;&nbsp;ไม่มีข้อมูล<br>'; // ถ้าไม่มีข้อมูล
        }



        $htmlContent .= '
            <div style="width: 100%; height: 100px;"></div>
            <div style="width: 50%; height: 50px;"></div>

        ';


        $signatureName = $names[0] ?? 'ไม่มีข้อมูล';

        $htmlContent .= '
            <div style="text-align: right;">
                <div style="width: 300px; text-align: center; display: inline-block; margin-left: auto; margin-right: 0;">
                    ลงชื่อ ................................................. <br>
                    ( ' . htmlspecialchars($signatureName) . ' ) <br>
                    ผู้รับผิดชอบโครงการ <br>
                    วันที่ ........../......................./..........
                </div>
            </div>
        ';

        $htmlContent .= '</div>';



        $mpdf->WriteHTML($stylesheet, 1);              // โหลด CSS
        $mpdf->WriteHTML($htmlContent, 2);             // เขียนเนื้อหา HTML ลงใน PDF

        return $mpdf->Output('' . $projects->name . '.pdf', 'I');       // ส่งไฟล์ PDF กลับไปให้ผู้ใช้
    }
}
