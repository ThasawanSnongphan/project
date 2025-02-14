<?php

namespace App\Http\Controllers;

use App\Models\Goals;
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
use App\Models\Year;
use Illuminate\Http\Request;
use Mpdf\Mpdf;
use DateTime;
use Carbon\Carbon;

class PDFKPIController extends Controller
{
    public function pdf_gen($id)
    {

        // ตรวจสอบว่า $id มีค่าหรือไม่
        if (empty($id)) {
            return response()->json(['message' => 'ไม่มีข้อมูลของโครงการ'], 400, [], JSON_UNESCAPED_UNICODE);
        }

        // ดึงข้อมูลผู้ใช้จากฐานข้อมูล
        $projects = Projects::where('proID', $id)->first();
        $years = Year::all();

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

        $htmlContent .= '
            <b>คำชี้แจง</b><br>
        ';

        $htmlContent .= '
            <b>1. ชื่อโครงการ / กิจกรรม : </b>';

        if (strlen($projects->name) > 30) { // คุณสามารถปรับตัวเลขนี้ตามความยาวที่คุณต้องการ
            $htmlContent .= '&nbsp;&nbsp;&nbsp;&nbsp;' . $projects->name . '<br>'; // ถ้าชื่อโครงการยาวเกิน 30 ตัวอักษร จะแสดงในบรรทัดใหม่
        } else {
            $htmlContent .= $projects->name; // ถ้าชื่อโครงการไม่ยาวเกิน จะแสดงในบรรทัดเดียวกัน
        }

        $htmlContent .= '
            <b>2. โครงการ / กิจกรรมนี้ตอบสนอง</b><br>
        ';

        $index = 1;

        foreach ($strategic_maps as $strategic_map) {
            if ($projects->proID == $strategic_map->proID) {
                // $htmlContent .= '<b>ข้อมูลสำหรับโครงการที่ ' . $strategic_map->proID . '</b><br>';

                // เช็คชื่อจาก straID
                foreach ($strategics as $strategic) {
                    if ($strategic->straID == $strategic_map->straID) {
                        $htmlContent .= '<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2.' . $index . ' ' . $strategic->name . '</b> <br>';
                        $index++;
                        break;
                    }
                }

                // เช็คชื่อจาก SFAID
                foreach ($strategic_issues as $strategic_issue) {
                    if ($strategic_issue->SFAID == $strategic_map->SFAID) {
                        $htmlContent .= '<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ประเด็นยุทธศาสตร์ที่ </b>' . $strategic_issue->name . '<br>';
                        break;
                    }
                }

                // เช็คชื่อจาก goalID
                foreach ($goals as $goal) {
                    if ($goal->goalID == $strategic_map->goalID) {
                        $htmlContent .= '<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เป้าประสงค์ที่ </b>' . $goal->name . '<br>';
                        break;
                    }
                }

                // เช็คชื่อจาก tacID
                foreach ($tactics as $tactic) {
                    if ($tactic->tacID == $strategic_map->tacID) {
                        $htmlContent .= '<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;กลยุทธ์ที่ </b>' . $tactic->name . '<br>';
                        break;
                    }
                }
            }
        }

        foreach ($strategic2_level_maps as $strategic2_level_map) {
            if ($projects->proID == $strategic2_level_map->proID) {
                // $htmlContent .= '<b>ข้อมูลสำหรับโครงการที่ ' . $strategic_map->proID . '</b><br>';

                // เช็คชื่อจาก stra2LVID
                foreach ($strategic2_levels as $strategic2_level) {
                    if ($strategic2_level->stra2LVID == $strategic2_level_map->stra2LVID) {
                        $htmlContent .= '<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2.' . $index . ' ' . $strategic2_level->name . '</b> <br>';
                        $index++;
                        break;
                    }
                }

                // เช็คชื่อจาก SFA2LVID
                foreach ($strategic_issue2_levels as $strategic_issue2_level) {
                    if ($strategic_issue2_level->SFA2LVID == $strategic2_level_map->SFA2LVID) {
                        $htmlContent .= '<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ประเด็นยุทธศาสตร์ที่ </b>' . $strategic2_level->name . '<br>';
                        break;
                    }
                }

                // เช็คชื่อจาก tac2LVID
                foreach ($tactic2_levels as $tactic2_level) {
                    if ($tactic2_level->tac2LVID == $strategic2_level_map->tac2LVID) {
                        $htmlContent .= '<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;กลยุทธ์ที่ </b>' . $tactic2_level->name . '<br>';
                        break;
                    }
                }
            }
        }

        foreach ($strategic1_level_maps as $strategic1_level_map) {
            if ($projects->proID == $strategic1_level_map->proID) {
                // $htmlContent .= '<b>ข้อมูลสำหรับโครงการที่ ' . $strategic_map->proID . '</b><br>';

                // เช็คชื่อจาก stra1LVID
                foreach ($strategic1_levels as $strategic1_level) {
                    if ($strategic1_level->stra1LVID == $strategic1_level_map->stra1LVID) {
                        $htmlContent .= '<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2.' . $index . ' ' . $strategic->name . '</b> <br>';
                        $index++;
                        break;
                    }
                }

                // เช็คชื่อจาก tar1LVID
                foreach ($target1_levels as $target1_level) {
                    if ($target1_level->tac1LVID == $strategic1_level_map->tac1LVID) {
                        $htmlContent .= '<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เป้าหมายที่ </b>' . $target1_level->name . '<br>';
                        break;
                    }
                }
            }
        }


        $htmlContent .= '
            <b>3. ส่วนงานที่รับผิดชอบ : </b><br>
        ';

        $htmlContent .= '
            <b>4. วิธีการดำเนินโครงการ : </b><br>
        ';

        $htmlContent .= '
            <b>5. ระยะเวลาในการดำเนินงาน : </b><br>
        ';

        $htmlContent .= '
            <b>6. วัตถุประสงค์</b><br>
        ';

        $htmlContent .= '
            <b>7. ผลการดำเนินงาน</b><br>
        ';

        $htmlContent .= '
            <b>8. ผลการดำเนินงานตามตัวชี้วัด (KPIs)</b><br>
        ';

        $htmlContent .= '
            <b>9. งบประมาณที่ใช้ดำเนินการ</b><br>
        ';

        $htmlContent .= '
            <b>10. ประโยนช์ที่ได้รับจากการดำเนินโครงการ (หลังการจัดการโครงการ)</b><br>
        ';

        $htmlContent .= '
            <b>11. ปัญหาและอุปสรรคในการดำเนินงานโครงการ</b><br>
            .........................................................................................................................................................................................<br>
            .........................................................................................................................................................................................<br>
            .........................................................................................................................................................................................<br>
            .........................................................................................................................................................................................<br>
        ';

        $htmlContent .= '
            <b>12. แนวทางการดำเนินการแก้ไข / ข้อเสนอแนะ</b><br>
            .........................................................................................................................................................................................<br>
            .........................................................................................................................................................................................<br>
            .........................................................................................................................................................................................<br>
            .........................................................................................................................................................................................<br>
        ';

        $htmlContent .= '
            <br><br><br><br>
            <div>
                <div style="width: 300px; text-align: center; float: left;">
                    ลงชื่อ ................................................. <br>
                    (               ) <br>
                    ผู้รับผิดชอบโครงการ <br>
                    วันที่ ........../......................./..........
                </div>
                <div style="width: 300px; text-align: center; float: right;">
                    ลงชื่อ ................................................. <br>
                    (               ) <br>
                    ผู้อำนวยการ <br>
                    วันที่ ........../......................./..........
                </div>
            </div>

            
        ';



        $mpdf->WriteHTML($stylesheet, 1);              // โหลด CSS  
        $mpdf->WriteHTML($htmlContent, 2);             // เขียนเนื้อหา HTML ลงใน PDF

        $mpdf->SetTitle('แบบประเมินโครงการที่ตอบสนองยุทธศาสตร์การพัฒนาสำนักคอมพิวเตอร์และเทคโนโลยีสารสนเทศประจำปีงบประมาณ');
        return $mpdf->Output('แบบประเมินโครงการที่ตอบสนองยุทธศาสตร์การพัฒนาสำนักคอมพิวเตอร์และเทคโนโลยีสารสนเทศประจำปีงบประมาณ.pdf', 'I');       // ส่งไฟล์ PDF กลับไปให้ผู้ใช้
    }
}
