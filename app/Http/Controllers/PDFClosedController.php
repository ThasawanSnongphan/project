<?php

namespace App\Http\Controllers;

use App\Models\BadgetType;
use App\Models\Goals;
use App\Models\OperatingResults;
use App\Models\ProjectEvaluation;
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
use App\Models\Users;
use App\Models\UsersMapProject;
use App\Models\Year;
use Illuminate\Http\Request;
use Mpdf\Mpdf;
use DateTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

Carbon::setLocale('th');

class PDFClosedController extends Controller
{
    public function pdf_gen($id)
    {

        // ตรวจสอบว่า $id มีค่าหรือไม่
        if (empty($id)) {
            return response()->json(['message' => 'ไม่มีข้อมูลของโครงการ'], 400, [], JSON_UNESCAPED_UNICODE);
        }

        // ดึงข้อมูลผู้ใช้จากฐานข้อมูล
        $projects = Projects::where('proID', $id)->first();
        $project_evaluations = ProjectEvaluation::all();
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

        $operating_results = OperatingResults::all();
        $badget_types = BadgetType::all();


        $config = include(config_path('configPDF_V.php'));       // ดึงการตั้งค่าฟอนต์จาก config
        $mpdf = new Mpdf($config);
        $mpdf->SetY(60);

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

        if ($projects && $projects->yearID) {
            foreach ($years as $year) {
                if ($projects->yearID == $year->yearID) {
                    $htmlContent .= '
                        <p style="text-align: center;">
                            <b>แบบประเมินโครงการที่ตอบสนองยุทธศาสตร์การพัฒนาสำนักคอมพิวเตอร์และเทคโนโลนีสารสนเทศ</b><br>
                            <b>ประจำปีงบประมาณ ' . $year->year . '</b><br>
                        </p>
                    ';
                    $mpdf->SetTitle('แบบประเมินโครงการที่ตอบสนองยุทธศาสตร์การพัฒนาสำนักคอมพิวเตอร์และเทคโนโลยีสารสนเทศประจำปีงบประมาณ');
                }
            }
        } else {
            return redirect()->back()->with('error', 'ไม่พบข้อมูลโครงการ');
        }

        foreach ($project_evaluations as $project_evaluation) {
            if ($projects->proID == $project_evaluation->proID) {
                $htmlContent .= '
                    <div style="page-break-inside: avoid;">
                        <b>คำชี้แจง</b><br>
                        <div style="text-align: justify; text-indent: 2em;">
                            ' . nl2br($project_evaluation->statement) . ' <br>
                        </div>
                    </div>
                ';
                $implementation = $project_evaluation->implementation;
                $problem = $project_evaluation->problem;
                $benefit = $project_evaluation->benefit;
                $corrective_actions = $project_evaluation->corrective_actions;
                // dd($implementation);
            }
            // foreach($users as $user){
            //     if($project_evaluation->userID == $user->userID){
            //         // เพิ่มสังกัดในอาร์เรย์ หากยังไม่มี
            //         if (!in_array($user->department_name, $departments)) {
            //             $departments[] = $user->department_name;
            //         }
            //         $responsibleNames[] = $user->username;
            //         $names[] = $user->username;
            //     }
            // }
        }

        $htmlContent .= '
            <b>1. ชื่อโครงการ / กิจกรรม : </b>';

        if (strlen($projects->name) > 30) { // คุณสามารถปรับตัวเลขนี้ตามความยาวที่คุณต้องการ
            $htmlContent .= '&nbsp;&nbsp;&nbsp;&nbsp;' . $projects->name . '<br>'; // ถ้าชื่อโครงการยาวเกิน 30 ตัวอักษร จะแสดงในบรรทัดใหม่
        } else {
            $htmlContent .= $projects->name . '<br>'; // ถ้าชื่อโครงการไม่ยาวเกิน จะแสดงในบรรทัดเดียวกัน
        }

        $htmlContent .= '<b>2. โครงการ / กิจกรรมนี้ตอบสนอง</b>';
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
                        $planDetails[] = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ประเด็น' . $strategic_issue->name;
                        break;
                    }
                }
                foreach ($goals as $goal) {
                    if ($goal->goalID == $strategic_map->goalID) {
                        $planDetails[] = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เป้าประสงค์ที่ ' . $goal->name;
                        break;
                    }
                }
                foreach ($tactics as $tactic) {
                    if ($tactic->tacID == $strategic_map->tacID) {
                        $planDetails[] = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;กลยุทธ์ที่ ' . $tactic->name;
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
                        $planDetails[] = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ประเด็น' . $strategic_issue2_level->name;
                        break;
                    }
                }
                foreach ($tactic2_levels as $tactic2_level) {
                    if ($tactic2_level->tac2LVID == $strategic2_level_map->tac2LVID) {
                        $planDetails[] = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;กลยุทธ์ที่ ' . $tactic2_level->name;
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
                        $planDetails[] = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เป้าหมายที่ ' . $target1_level->name;
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
                $htmlContent .= '<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2.' . $index . ' ' . '</b>' . $plan . '<br>';
                $index++;
            }
        }

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
                        $responsibleNames[] = $user->username;
                        $names[] = $user->username;
                        // dd($names);
                    }
                }
            }
        }


        // ตรวจสอบว่ามีข้อมูลหรือไม่
        if (empty($departments) && empty($responsibleNames)) {
            $htmlContent .= 'ไม่มีข้อมูล <br>';
        } else {

            // แสดงข้อมูลสังกัด
            foreach ($departments as $department) {
                $htmlContent .= '<b>3. ส่วนงานที่รับผิดชอบ : </b>' . $department . '</br><br>';
            }
        }

        $htmlContent .= '
            <div style="page-break-inside: avoid;">   
                <b>4. วิธีการดำเนินโครงการ : </b> ' . $implementation . '<br>
            </div>
        ';


        $pro_steps = DB::table('steps')->where('proID', $id)->get();

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
            <b>5. ระยะเวลาในการดำเนินงาน : </b>เริ่มต้น ' . $formattedStartDate . ' สิ้นสุด ' . $formattedEndDate . ' <br>
        ';

        $htmlContent .= '
            <div style="page-break-inside: avoid;">
                <b>6. วัตถุประสงค์</b><br>
            
        ';

        if (DB::table('objectives')->where('proID', $id)->exists()) {
            // ดึงข้อมูลที่ตรงกับ proID
            $objects = DB::table('objectives')->where('proID', $id)->get();
            $counter = 1; // ตัวแปรเก็บลำดับ
            foreach ($objects as $object) {
                if ($projects->proID == $object->proID) {
                    $htmlContent .= '
                        <div style="page-break-inside: avoid;">
                            <div style="text-indent: 20px;">
                                6.' . $counter . ' ' . $object->detail . ' <br>
                            </div>
                            <div style="text-indent: 20px;">
                                <span>( ' . ($object->achieve == 1 ? '<span style="font-family: \'DejaVu Sans\';">✓</span>' : '&nbsp;&nbsp;') . ' ) บรรลุ</span>
                                <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;( ' . ($object->achieve == 1 ? '&nbsp;&nbsp;' : '<span style="font-family: \'DejaVu Sans\';">✓</span>') . ' ) ไม่บรรลุ</span>
                            </div>
                        </div>
                    ';
                    $counter++;
                }
            }
        }

        $htmlContent .= '</div>';

        $htmlContent .= '
            <div class="checkbox" style="page-break-inside: avoid;">
                <b>7. ผลการดำเนินงาน</b><br>
        ';

        foreach ($operating_results as $operating_result) {
            $checked = '';
            foreach ($project_evaluations as $project_evaluation) {
                if ($project_evaluation->operID == $operating_result->operID) {
                    $checked = '✓';
                    break; // หยุด loop ทันทีเมื่อเจอค่า match
                }
            }
            $htmlContent .= '
                &nbsp;&nbsp;&nbsp;&nbsp;(
                <span style="font-family: DejaVu Sans, Arial, sans-serif;">
                    ' . ($checked ?: '&nbsp;&nbsp;') . '
                </span> ) ' . $operating_result->name . ' <br>
            ';
        }

        $htmlContent .= '</div>';

        $htmlContent .= '
            <div style="page-break-inside: avoid;">
                <b>8. ผลการดำเนินงานตามตัวชี้วัด (KPIs)</b><br>
        ';

        if (DB::table('k_p_i_projects')->where('proID', $id)->exists()) {
            // ดึงข้อมูลจาก k_p_i_projects
            $KPI_pros = DB::table('k_p_i_projects')->where('proID', $id)->get();

            // ดึงข้อมูลจากตารางหน่วยนับ 
            $countKPI_pros = DB::table('count_k_p_i_projects')->get();

            $counter = 1;
            foreach ($KPI_pros as $KPI_pro) {
                // เช็คว่ามีหน่วยนับที่ countKPIProID ตรงกันหรือไม่
                foreach ($countKPI_pros as $countKPI_pro) {
                    if ($KPI_pro->countKPIProID == $countKPI_pro->countKPIProID) {
                        // $unitName = $countKPI_pro->name;
                        $htmlContent .= '
                            &nbsp;&nbsp;&nbsp;&nbsp;8.' . $counter . ' ตัวชี้วัดโครงการ ' . $KPI_pro->name . ' <br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $KPI_pro->result_eva . ' <br>
                        ';
                        $counter++;
                        break;
                    }
                }
            }
        }

        $htmlContent .= '</div>';

        $htmlContent .= '
            <div style="page-break-inside: avoid;">
                <b>9. งบประมาณที่ใช้ดำเนินการ</b><br>
        ';

        // ตรวจสอบว่ามีข้อมูลโครงการหรือไม่
        if (!empty($projects) && isset($projects->badID)) {
            foreach ($badget_types as $badget_type) {
                $checked = (isset($badget_type->badID) && $projects->badID == $badget_type->badID) ? '✓' : '&nbsp;&nbsp;';

                $htmlContent .= '
                    &nbsp;&nbsp;&nbsp;&nbsp;(
                    <span style="font-family: DejaVu Sans, Arial, sans-serif;">
                        ' . $checked . '
                    </span> ) ' . htmlspecialchars($badget_type->name);

                // ตรวจสอบว่าชื่อเป็น "ไม่ได้ใช้งบประมาณ" หรือไม่
                if (isset($badget_type->badID) && $projects->badID == $badget_type->badID && $badget_type->name !== "ไม่ได้ใช้งบประมาณ") {
                    // ดึงงบที่ได้รับจัดสรรและที่ใช้จริง
                    $allocated = isset($projects->badgetTotal) ? number_format($projects->badgetTotal, 2) : "0.00";
                    $used = isset($project_evaluations[0]->badget_use) ? number_format($project_evaluations[0]->badget_use, 2) : "0.00";

                    // แสดงงบประมาณ ถ้าไม่ได้เป็น "ไม่ได้ใช้งบประมาณ"
                    $htmlContent .= ' <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ที่ได้รับจัดสรร ' . $allocated . ' บาท&nbsp;&nbsp;&nbsp;&nbsp;ใช้จริง ' . $used . ' บาท';
                }

                $htmlContent .= '<br>';
            }
        } else {
            $htmlContent .= 'ไม่มีข้อมูลงบประมาณ<br>';
        }

        $htmlContent .= '</div>';






        $htmlContent .= '
            <div style="page-break-inside: avoid;">
                <b>10. ประโยนช์ที่ได้รับจากการดำเนินโครงการ (หลังการจัดการโครงการ)</b><br>
                <div style="text-align: justify; text-indent: 2em;">
                    ' . nl2br($benefit) . ' <br>
                </div>
            </div>
        ';

        $htmlContent .= '
            <div style="page-break-inside: avoid;">
                <b>11. ปัญหาและอุปสรรคในการดำเนินงานโครงการ</b><br>
                <div style="text-align: justify; text-indent: 2em;">
                    ' . nl2br($problem) . ' <br>
                </div>
            </div>
        ';

        $htmlContent .= '
            <div style="page-break-inside: avoid;">
                <b>12. แนวทางการดำเนินการแก้ไข / ข้อเสนอแนะ</b><br>
                <div style="text-align: justify; text-indent: 2em;">
                    ' . nl2br($corrective_actions) . ' <br>
                </div>
            </div>
        ';

        $htmlContent .= '
            <div style="page-break-before: avoid;">
                <br><br><br><br>
                <div>
                    <div style="width: 300px; text-align: center; float: left;">
                        ลงชื่อ ................................................. <br>
                        (  ' .  $names[0] . '  ) <br>
                        ผู้รับผิดชอบโครงการ <br>
                        วันที่ ........../......................./..........
                    </div>
                    <div style="width: 300px; text-align: center; float: right;">
                        ลงชื่อ ................................................. <br>
                        ( ................................................. ) <br>
                        ผู้อำนวยการ <br>
                        วันที่ ........../......................./..........
                    </div>
                </div>
            </div>
        ';


        $mpdf->WriteHTML($stylesheet, 1);              // โหลด CSS  
        $mpdf->WriteHTML($htmlContent, 2);             // เขียนเนื้อหา HTML ลงใน PDF

        $mpdf->SetTitle('แบบประเมินโครงการที่ตอบสนองยุทธศาสตร์การพัฒนาสำนักคอมพิวเตอร์และเทคโนโลยีสารสนเทศประจำปีงบประมาณ');
        return $mpdf->Output('แบบประเมินโครงการที่ตอบสนองยุทธศาสตร์การพัฒนาสำนักคอมพิวเตอร์และเทคโนโลยีสารสนเทศประจำปีงบประมาณ.pdf', 'I');       // ส่งไฟล์ PDF กลับไปให้ผู้ใช้
    }
}
