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
use App\Models\Steps;
use App\Models\Strategic1Level;
use App\Models\Strategic1LevelMapProject;
use App\Models\Strategic2Level;
use App\Models\Strategic2LevelMapProject;
use App\Models\Strategic3Level;
use App\Models\StrategicIssues;
use App\Models\StrategicIssues2Level;
use App\Models\StrategicMap;
use App\Models\Tactic2Level;
use App\Models\Tactic2LevelMapKPIMain2Level;
use App\Models\Tactics;
use App\Models\Target1Level;
use App\Models\UniPlan;
use App\Models\Users;
use App\Models\UsersMapProject;
use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Mpdf\Mpdf;

use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;

use DateTime;
use Carbon\Carbon;

Carbon::setLocale('th');

class PDFPlanController extends Controller
{
    public function pdf_gen()
    {
        $config = include(config_path('configPDF_H.php'));       // ดึงการตั้งค่าฟอนต์จาก config

        // ตั้งค่า Temp Directory เพื่อลดการใช้ RAM
        $config['tempDir'] = storage_path('app/mpdf_tmp');

        // ปรับขนาด backtrack_limit ให้สูงขึ้น
        ini_set("pcre.backtrack_limit", "10000000");
        ini_set("memory_limit", "2048M"); // เพิ่ม memory limit

        $customConfig = [
            'tempDir' => storage_path('app/mpdf_tmp'), // ใช้ temp directory
            'mode' => 'utf-8',
            'allow_output_buffering' => true
        ];

        $mergedConfig = array_merge($config, $customConfig); // รวมค่า config
        $mpdf = new \Mpdf\Mpdf($mergedConfig);

        $stylesheet = "
        <style>
            table {
                border-collapse: collapse;
                width: 100%;
                margin-bottom: 5px;

            }
            table, th, td {
                border: 1px solid black;
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

        $mpdf->WriteHTML($stylesheet, 1);              // โหลด CSS


        // ดึงข้อมูลผู้ใช้จากฐานข้อมูล
        // $projects = Projects::where('proID', $id)->first();
        $all_projects = Projects::all();
        $years = Year::all();
        $users_map = UsersMapProject::all();
        $users = Users::all();

        // $strategic_maps = StrategicMap::all();
        $strategic_maps = StrategicMap::with(['SFA3LV', 'goal3LV', 'tac3LV'])->get();
        $strategic1_level_maps = Strategic1LevelMapProject::all();
        $strategic2_level_maps = Strategic2LevelMapProject::all();

        $strategic_issues = StrategicIssues::all();
        $strategic_issue2_levels = StrategicIssues2Level::all();

        $strategics = Strategic3Level::all();
        $strategic2_levels = Strategic2Level::all();
        $strategic1_levels = Strategic1Level::all();

        $steps = Steps::all();

        $goals = Goals::all();
        $target1_levels = Target1Level::all();

        $tactics = Tactics::all();
        $tactic2_levels = Tactic2Level::all();
        $tactic2_level_maps = Tactic2LevelMapKPIMain2Level::all();

        $KPI_pros = KPIProjects::all();
        $KPI_main2_levels = KPIMain2Level::all();

        $countKPI_pros = CountKPIProjects::all();


        $currentYear = date('Y');

        $headerContent = '
            <div style="text-align: center; margin-bottom: 8px;">
                <b>แผนปฏิบัติการประจำปีงบประมาณ พ.ศ.' . $currentYear + 543 . ' <br>
                สำนักคอมพิวเตอร์และเทคโนโลยีสารสนเทศ</b>
            </div>
        ';

        $mpdf->WriteHTML($headerContent, 2);

        $year1 = 2024;
        $year2 = 2025;

        $htmlContent = '
            <table border="1" style="border-collapse: collapse; width: 100%; margin-bottom: 7px; font-weight: 12pt;">
                <tr>
                    <th rowspan="3">ประเด็นยุทธ์ศาสตร์ / เป้าประสงค์</th>
                    <th rowspan="3">กลยุทธ์<br>(หน่วยงาน)</th>
                    <th rowspan="3">โครงการ / ตัวชี้วัดโครงการ</th>
                    <th rowspan="3">ค่าเป้าหมายโครงการ</th>
                    <th rowspan="3">เงินที่จัดสรร (บาท)</th>
                    <th colspan="12">ระยะเวลาดำเนินงาน</th>
                    <th rowspan="3">ผู้รับผิดชอบ</th>
                </tr>

                <tr>

                    <th colspan="3">พ.ศ. ' . $year1 + 543 . '</th>
                    <th colspan="9">พ.ศ. ' . $year2 + 543 . '</th>
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

        // แปลงข้อมูลเป็นอาร์เรย์
        $data_strategic_maps = $strategic_maps->toArray();
        $data_strategic_issues = $strategic_issues->toArray();
        $data_strategic3_levels = $strategics->toArray();
        $data_projects = $all_projects->toArray();
        $data_years = $years->toArray();
        $data_goals = $goals->toArray();
        $data_tactics = $tactics->toArray();
        $data_kpi_projects = $KPI_pros->toArray();
        $data_count_kpi_projects = $countKPI_pros->toArray();
        $data_users_map = $users_map->toArray();
        $data_users = $users->toArray();
        $data_steps = $steps->toArray();

        $data_strategic2_level_maps = $strategic2_level_maps->toArray();
        $data_strategic2_issues = $strategic_issue2_levels->toArray();
        $data_strategic2_levels = $strategic2_levels->toArray();
        $data_tactic2_levels = $tactic2_levels->toArray();

        $data_strategic1_levels = $strategic1_levels->toArray();
        $data_target1_levels = $target1_levels->toArray();
        $data_strategic1_level_maps = $strategic1_level_maps->toArray();




        foreach ($data_strategic_issues as $issue) {
            // ดึง YearID ของ strategic_issues ผ่าน strategic3_levels
            $yearID = null;
            foreach ($data_strategic3_levels as $level) {
                if ($level['stra3LVID'] == $issue['stra3LVID']) {
                    $yearID = $level['yearID'];
                    break;
                }
            }

            // หา YearID ในตาราง years แล้วลบ 543
            $year = null;
            foreach ($data_years as $yearRow) {
                if ($yearRow['yearID'] == $yearID) {
                    $year = $yearRow['year'] - 543;
                    break; //  จบลูปทันทีเมื่อเจอค่า
                }
            }

            //  เช็คว่า Year ตรงกับปีปัจจุบันหรือไม่
            if ($year == $currentYear) {
                $htmlContent .= "
                    <tbody>
                        <tr>
                            <th colspan='20' style='text-align: left; background-color: #ddd;'>ประเด็น: " . ($issue['name'] ?? '-') . "</th>
                        </tr>";

                //  ลูปข้อมูลเป้าประสงค์ที่สัมพันธ์กับประเด็นยุทธศาสตร์นี้
                foreach ($data_goals as $goal) {
                    if ($goal['SFA3LVID'] == $issue['SFA3LVID']) { // เชื่อมโยง FK
                        $htmlContent .= "
                        <tr>
                            <th colspan='20' style='text-align: left;'>เป้าประสงค์ที่: " . ($goal['name'] ?? '-') . "</th>
                        </tr>";

                        //  ลูปข้อมูลกลยุทธ์ที่สัมพันธ์กับเป้าประสงค์นี้
                        foreach ($data_tactics as $tactic) {
                            if ($tactic['goal3LVID'] == $goal['goal3LVID']) { // เชื่อมโยง FK
                                $projectRows = [];

                                // ตัวแปรปี
                                $year1 = 2024;
                                $year2 = 2025;

                                // รายชื่อเดือนที่ใช้ในตาราง (ต.ค. - ก.ย.)
                                $months = ["ต.ค.", "พ.ย.", "ธ.ค.", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย."];

                                foreach ($data_projects as $project) {
                                    if ($project['yearID'] == $yearID) {
                                        foreach ($data_strategic_maps as $map) {
                                            if ($map['tac3LVID'] == $tactic['tac3LVID'] && $map['proID'] == $project['proID']) {
                                                //  ดึง badgetTotal
                                                $badgetTotal = isset($project['badgetTotal']) ? number_format($project['badgetTotal'], 2) : "-";

                                                //  ลูปดึงข้อมูลจาก k_p_i_projects
                                                $kpiNames = [];
                                                $kpiTargets = [];
                                                foreach ($data_kpi_projects as $kpi) {
                                                    if ($kpi['proID'] == $project['proID']) {
                                                        $kpiNames[] = '- ' . ($kpi['name'] ?? '-');

                                                        //  หาค่า name จาก count_k_p_i_projects
                                                        $targetLabel = "";
                                                        foreach ($data_count_kpi_projects as $countKpi) {
                                                            if ($countKpi['countKPIProID'] == $kpi['countKPIProID']) {
                                                                $targetLabel = '- ' . $countKpi['name'];
                                                                break; // หาค่าแรกที่ตรงกันแล้วหยุด
                                                            }
                                                        }

                                                        //  คำนวณค่าเป้าหมายโครงการ
                                                        $targetValue = "";
                                                        if (!empty($targetLabel) && isset($kpi['target'])) {
                                                            $targetValue = "$targetLabel " . number_format($kpi['target'], 2);
                                                        }
                                                        $kpiTargets[] = $targetValue;
                                                    }
                                                }

                                                //  ดึงข้อมูลจาก steps
                                                $startMonth = null;
                                                $endMonth = null;
                                                foreach ($data_steps as $step) {
                                                    if ($step['proID'] == $project['proID']) {
                                                        //  ใช้ปี ค.ศ. โดยตรง
                                                        $startDate = new DateTime($step['start']);
                                                        $endDate = new DateTime($step['end']);

                                                        $startYear = (int)$startDate->format('Y'); // ใช้ ค.ศ.
                                                        $endYear = (int)$endDate->format('Y');

                                                        $startMonth = (int)$startDate->format('m');
                                                        $endMonth = (int)$endDate->format('m');
                                                    }
                                                }

                                                //  รวมโครงการและตัวชี้วัดให้อยู่ในคอลัมน์เดียวกัน
                                                $projectDetails = "<b>" . ($project['name'] ?? '-') . "</b><br>" . implode("<br>", $kpiNames);
                                                $projectTargetDetails = "<br>" . implode("<br>", $kpiTargets); // เพิ่มช่องว่างบรรทัดแรก


                                                //  สร้างแถวของโปรเจค
                                                $projectRows[] = [
                                                    'details' => $projectDetails,
                                                    'target' => $projectTargetDetails,
                                                    'badgetTotal' => $badgetTotal,
                                                    'startMonth' => $startMonth,
                                                    'endMonth' => $endMonth,
                                                    'startYear' => $startYear,
                                                    'endYear' => $endYear
                                                ];
                                            }
                                        }
                                        foreach ($data_users_map as $user_map) {
                                            if ($project['proID'] == $user_map['proID']) {
                                                foreach ($data_users as $user) {
                                                    if ($user_map['userID'] == $user['userID']) {
                                                        $name = $user['displayname'];
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }

                                //  ใช้ rowspan ให้กลยุทธ์แค่แถวแรก
                                $firstRow = true;
                                foreach ($projectRows as $projectData) {
                                    $htmlContent .= "<tr>";

                                    //  แสดงกลยุทธ์แค่แถวแรกเท่านั้น
                                    if ($firstRow) {
                                        $htmlContent .= "<td></td><td style='text-align: left; vertical-align: top;'>" . ($tactic['name'] ?? '-') . "</td>";
                                        $firstRow = false;
                                    } else {
                                        $htmlContent .= "<td></td><td></td>"; // ช่องว่างเมื่อเป็นแถวที่ 2 ขึ้นไป
                                    }

                                    //  แสดงข้อมูลโครงการและตัวชี้วัด
                                    $htmlContent .= "<td style='text-align: left; vertical-align: top;'>{$projectData['details']}</td>";

                                    //  แสดงค่าเป้าหมายโครงการ
                                    $htmlContent .= "<td style='text-align: left; vertical-align: top;'>{$projectData['target']}</td>";

                                    //  ช่องที่ 6 badgetTotal
                                    $htmlContent .= "<td style='text-align: center; vertical-align: top;'>{$projectData['badgetTotal']}</td>";

                                    //  ช่องเดือน ต.ค. - ก.ย.
                                    for ($i = 0; $i < count($months); $i++) {
                                        $currentMonth = ($i + 10) % 12; // แปลง index เป็นเดือน (ต.ค. = 10)
                                        if ($currentMonth == 0) {
                                            $currentMonth = 12; // แก้ปัญหา ธ.ค.
                                        }
                                        $currentYear = $i >= 3 ? $year2 : $year1; // ปี 2024 = index 0-2, ปี 2025 = index 3-11

                                        //  เช็คว่าข้อมูลของ step ครอบคลุมเดือนนี้หรือไม่
                                        $highlight = "";
                                        if ($projectData['startYear'] && $projectData['endYear']) {
                                            $stepStart = ($projectData['startYear'] * 12) + $projectData['startMonth']; // แปลงเป็นตัวเลขเดือนทั้งหมด
                                            $stepEnd = ($projectData['endYear'] * 12) + $projectData['endMonth'];
                                            $current = ($currentYear * 12) + $currentMonth;

                                            if ($current >= $stepStart && $current <= $stepEnd) {
                                                $highlight = "style='background-color: yellow;'"; // ✅ ไฮไลต์ช่องสีเหลือง
                                            }
                                        }

                                        $htmlContent .= "<td $highlight></td>";
                                    }
                                    $htmlContent .= "<td>" . $name . "</td>";

                                    $htmlContent .= "</tr>";
                                }

                                //  ถ้าไม่มีโครงการเลย ให้แสดง "-"
                                if (empty($projectRows)) {
                                    $htmlContent .= "
                                        <tr>
                                            <td></td>
                                            <td style='text-align: left;'>" . ($tactic['name'] ?? '-') . "</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                    ";

                                    //  ช่องเดือน (ต.ค. - ก.ย.)
                                    for ($i = 0; $i < count($months); $i++) {
                                        $htmlContent .= "<td></td>";
                                    }
                                    $htmlContent .= "<td></td>";
                                    $htmlContent .= "</tr>";
                                }
                            }
                        }
                    }
                }
            }
        }

        $htmlContent .= '</tbody></table>';


        $htmlContent .= '<pagebreak />';


        $htmlContent .= '
            <div style="text-align: center; margin-bottom: 8px;">
                <b>แผนปฏิบัติการประจำปีงบประมาณ พ.ศ.' . $currentYear + 543 . ' <br>
                สำนักคอมพิวเตอร์และเทคโนโลยีสารสนเทศ</b>
            </div>
        ';

        $mpdf->WriteHTML($htmlContent, 2);

        $year1 = 2024;
        $year2 = 2025;

        $htmlContent = '
            <table border="1" style="border-collapse: collapse; width: 100%; margin-bottom: 7px; font-weight: 12pt;">
                <tr>
                    <th rowspan="3">ประเด็นยุทธ์ศาสตร์ / เป้าประสงค์</th>
                    <th rowspan="3">กลยุทธ์<br>(หน่วยงาน)</th>
                    <th rowspan="3">โครงการ / ตัวชี้วัดโครงการ</th>
                    <th rowspan="3">ค่าเป้าหมายโครงการ</th>
                    <th rowspan="3">เงินที่จัดสรร (บาท)</th>
                    <th colspan="12">ระยะเวลาดำเนินงาน</th>
                    <th rowspan="3">ผู้รับผิดชอบ</th>
                </tr>

                <tr>

                    <th colspan="3">พ.ศ. ' . $year1 + 543 . '</th>
                    <th colspan="9">พ.ศ. ' . $year2 + 543 . '</th>
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


        foreach ($data_strategic2_issues as $issue) {
            // ดึง YearID ของ strategic_issues ผ่าน strategic3_levels
            $yearID = null;
            foreach ($data_strategic2_levels as $level) {
                if ($level['stra2LVID'] == $issue['stra2LVID']) {
                    $yearID = $level['yearID'];
                    break;
                }
            }

            // หา YearID ในตาราง years แล้วลบ 543
            $year = null;
            foreach ($data_years as $yearRow) {
                if ($yearRow['yearID'] == $yearID) {
                    $year = $yearRow['year'] - 543;
                    break; //  จบลูปทันทีเมื่อเจอค่า
                }
            }

            //  เช็คว่า Year ตรงกับปีปัจจุบันหรือไม่
            if ($year == $currentYear) {
                $htmlContent .= "
                    <tbody>
                        <tr>
                            <th colspan='20' style='text-align: left; background-color: #ddd;'>ประเด็น: " . ($issue['name'] ?? '-') . "</th>
                        </tr>";



                //  ลูปข้อมูลกลยุทธ์ที่สัมพันธ์กับเป้าประสงค์นี้
                foreach ($data_tactic2_levels as $tactic) {
                    if ($tactic['SFA2LVID'] == $issue['SFA2LVID']) { // เชื่อมโยง FK
                        $projectRows = [];

                        // ตัวแปรปี
                        $year1 = 2024;
                        $year2 = 2025;

                        // รายชื่อเดือนที่ใช้ในตาราง (ต.ค. - ก.ย.)
                        $months = ["ต.ค.", "พ.ย.", "ธ.ค.", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย."];

                        foreach ($data_projects as $project) {
                            if ($project['yearID'] == $yearID) {
                                foreach ($data_strategic2_level_maps as $map) {
                                    if ($map['tac2LVID'] == $tactic['tac2LVID'] && $map['proID'] == $project['proID']) {
                                        //  ดึง badgetTotal
                                        $badgetTotal = isset($project['badgetTotal']) ? number_format($project['badgetTotal'], 2) : "-";

                                        //  ลูปดึงข้อมูลจาก k_p_i_projects
                                        $kpiNames = [];
                                        $kpiTargets = [];
                                        foreach ($data_kpi_projects as $kpi) {
                                            if ($kpi['proID'] == $project['proID']) {
                                                $kpiNames[] = '- ' . ($kpi['name'] ?? '-');

                                                //  หาค่า name จาก count_k_p_i_projects
                                                $targetLabel = "";
                                                foreach ($data_count_kpi_projects as $countKpi) {
                                                    if ($countKpi['countKPIProID'] == $kpi['countKPIProID']) {
                                                        $targetLabel = '- ' . $countKpi['name'];
                                                        break; // หาค่าแรกที่ตรงกันแล้วหยุด
                                                    }
                                                }

                                                //  คำนวณค่าเป้าหมายโครงการ
                                                $targetValue = "";
                                                if (!empty($targetLabel) && isset($kpi['target'])) {
                                                    $targetValue = "$targetLabel " . number_format($kpi['target'], 2);
                                                }
                                                $kpiTargets[] = $targetValue;
                                            }
                                        }

                                        //  ดึงข้อมูลจาก steps
                                        $startMonth = null;
                                        $endMonth = null;
                                        foreach ($data_steps as $step) {
                                            if ($step['proID'] == $project['proID']) {
                                                //  ใช้ปี ค.ศ. โดยตรง
                                                $startDate = new DateTime($step['start']);
                                                $endDate = new DateTime($step['end']);

                                                $startYear = (int)$startDate->format('Y'); // ใช้ ค.ศ.
                                                $endYear = (int)$endDate->format('Y');

                                                $startMonth = (int)$startDate->format('m');
                                                $endMonth = (int)$endDate->format('m');
                                            }
                                        }

                                        //  รวมโครงการและตัวชี้วัดให้อยู่ในคอลัมน์เดียวกัน
                                        $projectDetails = "<b>" . ($project['name'] ?? '-') . "</b><br>" . implode("<br>", $kpiNames);
                                        $projectTargetDetails = "<br>" . implode("<br>", $kpiTargets); // เพิ่มช่องว่างบรรทัดแรก


                                        //  สร้างแถวของโปรเจค
                                        $projectRows[] = [
                                            'details' => $projectDetails,
                                            'target' => $projectTargetDetails,
                                            'badgetTotal' => $badgetTotal,
                                            'startMonth' => $startMonth,
                                            'endMonth' => $endMonth,
                                            'startYear' => $startYear,
                                            'endYear' => $endYear
                                        ];
                                    }
                                }
                                foreach ($data_users_map as $user_map) {
                                    if ($project['proID'] == $user_map['proID']) {
                                        foreach ($data_users as $user) {
                                            if ($user_map['userID'] == $user['userID']) {
                                                $name = $user['displayname'];
                                            }
                                        }
                                    }
                                }
                            }
                        }

                        //  ใช้ rowspan ให้กลยุทธ์แค่แถวแรก
                        $firstRow = true;
                        foreach ($projectRows as $projectData) {
                            $htmlContent .= "<tr>";

                            //  แสดงกลยุทธ์แค่แถวแรกเท่านั้น
                            if ($firstRow) {
                                $htmlContent .= "<td></td><td style='text-align: left; vertical-align: top;'>" . ($tactic['name'] ?? '-') . "</td>";
                                $firstRow = false;
                            } else {
                                $htmlContent .= "<td></td><td></td>"; // ช่องว่างเมื่อเป็นแถวที่ 2 ขึ้นไป
                            }

                            //  แสดงข้อมูลโครงการและตัวชี้วัด
                            $htmlContent .= "<td style='text-align: left; vertical-align: top;'>{$projectData['details']}</td>";

                            //  แสดงค่าเป้าหมายโครงการ
                            $htmlContent .= "<td style='text-align: left; vertical-align: top;'>{$projectData['target']}</td>";

                            //  ช่องที่ 6 badgetTotal
                            $htmlContent .= "<td style='text-align: center; vertical-align: top;'>{$projectData['badgetTotal']}</td>";

                            //  ช่องเดือน ต.ค. - ก.ย.
                            for ($i = 0; $i < count($months); $i++) {
                                $currentMonth = ($i + 10) % 12; // แปลง index เป็นเดือน (ต.ค. = 10)
                                if ($currentMonth == 0) {
                                    $currentMonth = 12; // แก้ปัญหา ธ.ค.
                                }
                                $currentYear = $i >= 3 ? $year2 : $year1; // ปี 2024 = index 0-2, ปี 2025 = index 3-11

                                //  เช็คว่าข้อมูลของ step ครอบคลุมเดือนนี้หรือไม่
                                $highlight = "";
                                if ($projectData['startYear'] && $projectData['endYear']) {
                                    $stepStart = ($projectData['startYear'] * 12) + $projectData['startMonth']; // แปลงเป็นตัวเลขเดือนทั้งหมด
                                    $stepEnd = ($projectData['endYear'] * 12) + $projectData['endMonth'];
                                    $current = ($currentYear * 12) + $currentMonth;

                                    if ($current >= $stepStart && $current <= $stepEnd) {
                                        $highlight = "style='background-color: yellow;'"; // ✅ ไฮไลต์ช่องสีเหลือง
                                    }
                                }

                                $htmlContent .= "<td $highlight></td>";
                            }
                            $htmlContent .= "<td>" . $name . "</td>";

                            $htmlContent .= "</tr>";
                        }

                        //  ถ้าไม่มีโครงการเลย ให้แสดง "-"
                        if (empty($projectRows)) {
                            $htmlContent .= "
                                        <tr>
                                            <td></td>
                                            <td style='text-align: left;'>" . ($tactic['name'] ?? '-') . "</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                    ";

                            //  ช่องเดือน (ต.ค. - ก.ย.)
                            for ($i = 0; $i < count($months); $i++) {
                                $htmlContent .= "<td></td>";
                            }
                            $htmlContent .= "<td></td>";
                            $htmlContent .= "</tr>";
                        }
                    }
                }
                // }
                // }
            }
        }

        $htmlContent .= '</tbody></table>';

        $htmlContent .= '<pagebreak />';

        $htmlContent .= '
            <div style="text-align: center; margin-bottom: 8px;">
                <b>แผนปฏิบัติการประจำปีงบประมาณ พ.ศ.' . $currentYear + 543 . ' <br>
                สำนักคอมพิวเตอร์และเทคโนโลยีสารสนเทศ</b>
            </div>
        ';

        $mpdf->WriteHTML($htmlContent, 2);

        $year1 = 2024;
        $year2 = 2025;

        $htmlContent = '
            <table border="1" style="border-collapse: collapse; width: 100%; margin-bottom: 7px; font-weight: 12pt;">
                <tr>
                    <th rowspan="3">แผนยุทธ์ศาสตร์</th>
                    <th rowspan="3">เป้าหมาย</th>
                    <th rowspan="3">โครงการ / ตัวชี้วัดโครงการ</th>
                    <th rowspan="3">ค่าเป้าหมายโครงการ</th>
                    <th rowspan="3">เงินที่จัดสรร (บาท)</th>
                    <th colspan="12">ระยะเวลาดำเนินงาน</th>
                    <th rowspan="3">ผู้รับผิดชอบ</th>
                </tr>

                <tr>

                    <th colspan="3">พ.ศ. ' . $year1 + 543 . '</th>
                    <th colspan="9">พ.ศ. ' . $year2 + 543 . '</th>
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


        foreach ($data_strategic1_levels as $level) {
            // ดึง YearID ของ strategic_issues ผ่าน strategic3_levels
            $yearID = null;
            $yearID = $level['yearID'];


            // foreach ($data_strategic1_levels as $level) {
            //     // if ($level['stra2LVID'] == $issue['stra2LVID']) {
            //         // break;
            //     // }
            // }

            // หา YearID ในตาราง years แล้วลบ 543
            $year = null;
            foreach ($data_years as $yearRow) {
                if ($yearRow['yearID'] == $yearID) {
                    $year = $yearRow['year'] - 543;
                    break; //  จบลูปทันทีเมื่อเจอค่า
                }
            }

            //  เช็คว่า Year ตรงกับปีปัจจุบันหรือไม่
            if ($year == $currentYear) {
                $htmlContent .= "
                    <tbody>
                        <tr>
                            <th colspan='20' style='text-align: left; background-color: #ddd;'>แผนยุทธ์ศาสตร์: " . ($level['name'] ?? '-') . "</th>
                        </tr>";

                //  ลูปข้อมูลเป้าประสงค์ที่สัมพันธ์กับประเด็นยุทธศาสตร์นี้
                // foreach ($data_goals as $goal) {
                // if ($goal['SFA3LVID'] == $issue['SFA3LVID']) { // เชื่อมโยง FK
                // $htmlContent .= "
                // <tr>
                //     <th colspan='20' style='text-align: left;'>เป้าประสงค์ที่: " . ($goal['name'] ?? '-') . "</th>
                // </tr>";

                //  ลูปข้อมูลกลยุทธ์ที่สัมพันธ์กับเป้าประสงค์นี้
                foreach ($data_target1_levels as $target) {
                    if ($target['stra1LVID'] == $level['stra1LVID']) { // เชื่อมโยง FK
                        $projectRows = [];

                        // ตัวแปรปี
                        $year1 = 2024;
                        $year2 = 2025;

                        // รายชื่อเดือนที่ใช้ในตาราง (ต.ค. - ก.ย.)
                        $months = ["ต.ค.", "พ.ย.", "ธ.ค.", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย."];

                        foreach ($data_projects as $project) {
                            if ($project['yearID'] == $yearID) {
                                foreach ($data_strategic1_level_maps as $map) {
                                    if ($map['tar1LVID'] == $target['tar1LVID'] && $map['proID'] == $project['proID']) {
                                        //  ดึง badgetTotal
                                        $badgetTotal = isset($project['badgetTotal']) ? number_format($project['badgetTotal'], 2) : "-";

                                        //  ลูปดึงข้อมูลจาก k_p_i_projects
                                        $kpiNames = [];
                                        $kpiTargets = [];
                                        foreach ($data_kpi_projects as $kpi) {
                                            if ($kpi['proID'] == $project['proID']) {
                                                $kpiNames[] = '- ' . ($kpi['name'] ?? '-');

                                                //  หาค่า name จาก count_k_p_i_projects
                                                $targetLabel = "";
                                                foreach ($data_count_kpi_projects as $countKpi) {
                                                    if ($countKpi['countKPIProID'] == $kpi['countKPIProID']) {
                                                        $targetLabel = '- ' . $countKpi['name'];
                                                        break; // หาค่าแรกที่ตรงกันแล้วหยุด
                                                    }
                                                }

                                                //  คำนวณค่าเป้าหมายโครงการ
                                                $targetValue = "";
                                                if (!empty($targetLabel) && isset($kpi['target'])) {
                                                    $targetValue = "$targetLabel " . number_format($kpi['target'], 2);
                                                }
                                                $kpiTargets[] = $targetValue;
                                            }
                                        }

                                        //  ดึงข้อมูลจาก steps
                                        $startMonth = null;
                                        $endMonth = null;
                                        foreach ($data_steps as $step) {
                                            if ($step['proID'] == $project['proID']) {
                                                //  ใช้ปี ค.ศ. โดยตรง
                                                $startDate = new DateTime($step['start']);
                                                $endDate = new DateTime($step['end']);

                                                $startYear = (int)$startDate->format('Y'); // ใช้ ค.ศ.
                                                $endYear = (int)$endDate->format('Y');

                                                $startMonth = (int)$startDate->format('m');
                                                $endMonth = (int)$endDate->format('m');
                                            }
                                        }

                                        //  รวมโครงการและตัวชี้วัดให้อยู่ในคอลัมน์เดียวกัน
                                        $projectDetails = "<b>" . ($project['name'] ?? '-') . "</b><br>" . implode("<br>", $kpiNames);
                                        $projectTargetDetails = "<br>" . implode("<br>", $kpiTargets); // เพิ่มช่องว่างบรรทัดแรก


                                        //  สร้างแถวของโปรเจค
                                        $projectRows[] = [
                                            'details' => $projectDetails,
                                            'target' => $projectTargetDetails,
                                            'badgetTotal' => $badgetTotal,
                                            'startMonth' => $startMonth,
                                            'endMonth' => $endMonth,
                                            'startYear' => $startYear,
                                            'endYear' => $endYear
                                        ];
                                    }
                                }
                                foreach ($data_users_map as $user_map) {
                                    if ($project['proID'] == $user_map['proID']) {
                                        foreach ($data_users as $user) {
                                            if ($user_map['userID'] == $user['userID']) {
                                                $name = $user['displayname'];
                                            }
                                        }
                                    }
                                }
                            }
                        }

                        //  ใช้ rowspan ให้กลยุทธ์แค่แถวแรก
                        $firstRow = true;
                        foreach ($projectRows as $projectData) {
                            $htmlContent .= "<tr>";

                            //  แสดงกลยุทธ์แค่แถวแรกเท่านั้น
                            if ($firstRow) {
                                $htmlContent .= "<td></td><td style='text-align: left; vertical-align: top;'>" . ($target['name'] ?? '-') . "</td>";
                                $firstRow = false;
                            } else {
                                $htmlContent .= "<td></td><td></td>"; // ช่องว่างเมื่อเป็นแถวที่ 2 ขึ้นไป
                            }

                            //  แสดงข้อมูลโครงการและตัวชี้วัด
                            $htmlContent .= "<td style='text-align: left; vertical-align: top;'>{$projectData['details']}</td>";

                            //  แสดงค่าเป้าหมายโครงการ
                            $htmlContent .= "<td style='text-align: left; vertical-align: top;'>{$projectData['target']}</td>";

                            //  ช่องที่ 6 badgetTotal
                            $htmlContent .= "<td style='text-align: center; vertical-align: top;'>{$projectData['badgetTotal']}</td>";

                            //  ช่องเดือน ต.ค. - ก.ย.
                            for ($i = 0; $i < count($months); $i++) {
                                $currentMonth = ($i + 10) % 12; // แปลง index เป็นเดือน (ต.ค. = 10)
                                if ($currentMonth == 0) {
                                    $currentMonth = 12; // แก้ปัญหา ธ.ค.
                                }
                                $currentYear = $i >= 3 ? $year2 : $year1; // ปี 2024 = index 0-2, ปี 2025 = index 3-11

                                //  เช็คว่าข้อมูลของ step ครอบคลุมเดือนนี้หรือไม่
                                $highlight = "";
                                if ($projectData['startYear'] && $projectData['endYear']) {
                                    $stepStart = ($projectData['startYear'] * 12) + $projectData['startMonth']; // แปลงเป็นตัวเลขเดือนทั้งหมด
                                    $stepEnd = ($projectData['endYear'] * 12) + $projectData['endMonth'];
                                    $current = ($currentYear * 12) + $currentMonth;

                                    if ($current >= $stepStart && $current <= $stepEnd) {
                                        $highlight = "style='background-color: yellow;'"; // ✅ ไฮไลต์ช่องสีเหลือง
                                    }
                                }

                                $htmlContent .= "<td $highlight></td>";
                            }
                            $htmlContent .= "<td>" . $name . "</td>";

                            $htmlContent .= "</tr>";
                        }

                        //  ถ้าไม่มีโครงการเลย ให้แสดง "-"
                        if (empty($projectRows)) {
                            $htmlContent .= "
                                        <tr>
                                            <td></td>
                                            <td style='text-align: left;'>" . ($tactic['name'] ?? '-') . "</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                    ";

                            //  ช่องเดือน (ต.ค. - ก.ย.)
                            for ($i = 0; $i < count($months); $i++) {
                                $htmlContent .= "<td></td>";
                            }
                            $htmlContent .= "<td></td>";
                            $htmlContent .= "</tr>";
                        }
                    }
                }
                // }
                // }
            }
        }

        $htmlContent .= '</tbody></table>';









        $mpdf->WriteHTML($htmlContent, 2);
        $mpdf->SetTitle('แผนปฏิบัติการประจำปีงบประมาณ พ.ศ.' . $year + 543);
        return $mpdf->Output('แผนปฏิบัติการประจำปีงบประมาณ พ.ศ.' . ($year + 543) . '.pdf', 'I');
    }
}
