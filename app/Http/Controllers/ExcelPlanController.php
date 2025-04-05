<?php

namespace App\Http\Controllers;

use App\Models\BadgetType;
use App\Models\CountKPIProjects;
use App\Models\Goals;
use App\Models\KPIMain2Level;
use App\Models\KPIProjects;
use App\Models\OperatingResults;
use App\Models\ProjectEvaluation;
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
use App\Models\Users;
use App\Models\UsersMapProject;
use App\Models\Year;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Symfony\Component\HttpFoundation\StreamedResponse;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Illuminate\Support\Facades\Log;



use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;


class ExcelPlanController extends Controller
{
    public function excel_gen($id)
    {

        // สร้าง Spreadsheet
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getDefaultStyle()->getFont()->setName('TH Sarabun New')->setSize(14);
        $sheet = $spreadsheet->getActiveSheet();

        // ดึงข้อมูลผู้ใช้จากฐานข้อมูล
        $all_projects = Projects::all();
        $years = Year::where('yearID', $id)->first();
        $users_map = UsersMapProject::all();
        $users = Users::all();


        $strategic_maps = StrategicMap::all();
        // $strategic_maps = StrategicMap::with(['SFA3LV', 'goal3LV', 'tac3LV', 'proID', 'stra3LV'])->get();
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



        // สร้างตัวแปรเก็บสไตล์การจัดตำแหน่ง
        $centerAlignment = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,  // จัดกลางแนวนอน
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,    // จัดกลางแนวตั้ง
            ],
        ];

        $leftAlignment = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,  // จัดชิดซ้าย
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,    // จัดกลางแนวตั้ง
            ],
        ];

        $rightAlignment = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT, // จัดชิดขวา
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,    // จัดกลางแนวตั้ง
            ],
        ];

        $currentYear = $years->year - 543;
        $year1 = ($years->year - 543) - 1;
        $year2 = $years->year - 543;

        $row = 1;

        // ตั้งค่าหัวข้อเอกสาร
        $sheet->setCellValue('A' . $row, "แผนปฏิบัติการประจำปีงบประมาณ พ.ศ." . $currentYear + 543);
        $sheet->mergeCells('A' . $row . ':R' . $row);
        $sheet->getStyle('A' . $row)->applyFromArray($centerAlignment);


        $row++;
        $sheet->setCellValue('A' . $row, "สำนักคอมพิวเตอร์และเทคโนโลยีสารสนเทศ");
        $sheet->mergeCells('A' . $row . ':R' . $row);
        $sheet->getStyle('A' . $row)->applyFromArray($centerAlignment);

        $row += 2;
        $sheet->setCellValue('A' . $row, 'ประเด็นยุทธ์ศาสตร์ / เป้าประสงค์');
        $sheet->setCellValue('B' . $row, 'กลยุทธ์ (หน่วยงาน)');
        $sheet->setCellValue('C' . $row, 'โครงการ / ตัวชี้วัดโครงการ');
        $sheet->setCellValue('D' . $row, 'ค่าเป้าหมายโครงการ');
        $sheet->setCellValue('E' . $row, 'เงินที่จัดสรร (บาท)');
        $sheet->setCellValue('F' . $row, 'ระยะเวลาดำเนินงาน');
        $sheet->setCellValue('R' . $row, 'ผู้รับผิดชอบ');

        $sheet->mergeCells('F' . $row . ':' . 'Q' . $row);

        $sheet->mergeCells('A' . $row . ':' . 'A6');
        $sheet->mergeCells('B' . $row . ':' . 'B6');
        $sheet->mergeCells('C' . $row . ':' . 'C6');
        $sheet->mergeCells('D' . $row . ':' . 'D6');
        $sheet->mergeCells('E' . $row . ':' . 'E6');
        $sheet->mergeCells('R' . $row . ':' . 'R6');

        // เปิด Wrap Text ให้ทุกเซลล์ในหัวตาราง
        $sheet->getStyle('A' . $row . ':' . 'G' . $row)->getAlignment()->setWrapText(true);
        $sheet->getStyle('A' . $row . ':' . 'R' . $row)->applyFromArray($centerAlignment);

        $row++;

        $sheet->setCellValue('F' . $row, 'พ.ศ.' . $year1);
        $sheet->setCellValue('I' . $row, 'พ.ศ.' . $year2);

        $sheet->mergeCells('F' . $row . ':' . 'H' . $row);
        $sheet->mergeCells('I' . $row . ':' . 'Q' . $row);

        // $sheet->mergeCells('F5:H5');
        // $sheet->mergeCells('I5:Q5');

        $sheet->getStyle('F' . $row . ':' . 'R' . $row)->applyFromArray($centerAlignment);

        $months = ["ต.ค.", "พ.ย.", "ธ.ค.", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย."];
        $col = 'F';
        $row++;
        foreach ($months as $month) {
            $cell = $col . $row;
            $sheet->setCellValue($cell, $month);
            $sheet->getStyle($cell)->applyFromArray($centerAlignment);
            $col++; // เพิ่มคอลัมน์ถัดไป

        }

        $row++;

        foreach ($data_strategic_issues as $issue) {
            // $sheet->setCellValue('A' . $row, 'ประเด็น: ' . $issue['name']);
            // $row++;

            $yearID = null;
            foreach ($data_strategic3_levels as $level) {
                if ($level['stra3LVID'] == $issue['stra3LVID']) {
                    $yearID = $level['yearID'];
                    // dd($yearID);
                    break;
                }
            }

            // $year = null;
            // foreach ($data_years as $yearRow) {
            //     if ($yearRow['yearID'] == $yearID) {
            //         $year = $yearRow['year'];
            //         break; //  จบลูปทันทีเมื่อเจอค่า
            //     }   
            // }

            $year = ($data_years['yearID'] == $yearID) ? $data_years['year'] - 543 : null;

            // dd($currentYear);

            if ($year == $currentYear) {
                $sheet->setCellValue('A' . $row, 'ประเด็น: ' . $issue['name']);
                $sheet->mergeCells('A' . $row . ':' . 'R' . $row);
                // ตั้งค่าสีพื้นหลัง
                $sheet->getStyle('A' . $row . ':' . 'R' . $row)
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('FFFF00'); // สีเหลือง (รูปแบบ ARGB)

                $row++;

                foreach ($data_goals as $goal) {
                    if ($goal['SFA3LVID'] == $issue['SFA3LVID']) {
                        $sheet->setCellValue('A' . $row, 'เป้าประสงค์ที่: ' . $goal['name']);
                        $sheet->mergeCells('A' . $row . ':' . 'R' . $row);

                        $row++;
                    }

                    foreach ($data_tactics as $tactic) {
                        if ($tactic['goal3LVID'] == $goal['goal3LVID']) {
                            $projectRows = [];

                            $months = ["ต.ค.", "พ.ย.", "ธ.ค.", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย."];

                            foreach ($data_projects as $project) {
                                if ($project['yearID'] == $yearID) {
                                    foreach ($data_strategic_maps as $map) {
                                        if ($map['tac3LVID'] == $tactic['tac3LVID'] && $map['proID'] == $project['proID']) {
                                            dd($map['proID']);

                                            $badgetTotal = isset($project['badgetTotal']) ? number_format($project['badgetTotal'], 2) : "-";

                                            $kpiNames = [];
                                            $kpiTargets = [];

                                            foreach ($data_kpi_projects as $kpi) {
                                                if ($kpi['proID'] == $project['proID']) {
                                                    $kpiNames[] = '- ' . ($kpi['name'] ?? '-');

                                                    $targetLabel = "";
                                                    foreach ($data_count_kpi_projects as $countKpi) {
                                                        if ($countKpi['countKPIProID'] == $kpi['countKPIProID']) {
                                                            $targetLabel = '- ' . $countKpi['name'];
                                                            break;
                                                        }
                                                    }

                                                    $targetValue = "";
                                                    $targetValue = "";
                                                    if (!empty($targetLabel) && isset($kpi['target'])) {
                                                        $targetValue = "$targetLabel " . number_format($kpi['target'], 2);
                                                    }
                                                    $kpiTargets[] = $targetValue;
                                                }
                                            }
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
                                            // สร้าง array เพื่อเก็บข้อมูลโครงการ
                                            $projectData = [];

                                            foreach ($data_projects as $project) {
                                                // เก็บข้อมูลพื้นฐานโครงการ
                                                $projectItem = [
                                                    'name' => $project['name'] ?? '-',
                                                    'budget' => $project['badgetTotal'] ?? 0,
                                                    'kpis' => [],
                                                    'targets' => []
                                                ];

                                                // เก็บข้อมูล KPI
                                                foreach ($data_kpi_projects as $kpi) {
                                                    if ($kpi['proID'] == $project['proID']) {
                                                        $countKpi = collect($data_count_kpi_projects)
                                                            ->where('countKPIProID', $kpi['countKPIProID'])
                                                            ->first();

                                                        $projectItem['kpis'][] = $kpi['name'] ?? '-';
                                                        $projectItem['targets'][] = ($countKpi['name'] ?? '') . ' ' . number_format($kpi['target'], 2);
                                                    }
                                                }

                                                // เก็บข้อมูลผู้รับผิดชอบ
                                                $userMap = collect($data_users_map)
                                                    ->where('proID', $project['proID'])
                                                    ->first();

                                                $user = $userMap ? collect($data_users)
                                                    ->where('userID', $userMap['userID'])
                                                    ->first() : null;

                                                $projectItem['responsible'] = $user['displayname'] ?? '-';

                                                // เก็บข้อมูลระยะเวลา
                                                $step = collect($data_steps)
                                                    ->where('proID', $project['proID'])
                                                    ->first();

                                                if ($step) {
                                                    $projectItem['start'] = $step['start'];
                                                    $projectItem['end'] = $step['end'];
                                                }

                                                // เพิ่มโครงการลงใน array หลัก
                                                $projectData[] = $projectItem;
                                            }

                                            // ตัวอย่างการนำไปใช้แสดงผลทีหลัง
                                            foreach ($projectData as $project) {
                                                // แสดงชื่อโครงการ (ตัวหนา)
                                                $sheet->setCellValue('C' . $row, $project['name']);
                                                $sheet->getStyle('C' . $row)->getFont()->setBold(true);

                                                // แสดง KPI และค่าเป้าหมาย
                                                foreach ($project['kpis'] as $index => $kpi) {
                                                    $row++;
                                                    $sheet->setCellValue('C' . $row, '- ' . $kpi);
                                                    $sheet->setCellValue('D' . $row, $project['targets'][$index] ?? '');
                                                }

                                                // แสดงข้อมูลอื่นๆ
                                                $sheet->setCellValue('E' . $row, number_format($project['budget'], 2));
                                                $sheet->setCellValue('R' . $row, $project['responsible']);

                                                $row++;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }










        // dd($data_strategic_issues);

        // foreach ($data_strategic_issues as $issue) {
        //     // $sheet->setCellValue('A'. $row, ($issue['name'] ?? '-'));
        //     // Log::info("Writing to cell A$row with value: " . ($issue['name'] ?? '-'));

        //     // Log::info($issue);
        //     // ดึง YearID ของ strategic_issues ผ่าน strategic3_levels
        //     $yearID = null;
        //     foreach ($data_strategic3_levels as $level) {
        //         if ($level['stra3LVID'] == $issue['stra3LVID']) {
        //             $yearID = $level['yearID'];
        //             break;
        //         }
        //     }

        //     // หา YearID ในตาราง years แล้วลบ 543
        //     $year = null;
        //     foreach ($data_years as $yearRow) {
        //         if ($yearRow['yearID'] == $yearID) {
        //             $year = $yearRow['year'] - 543;
        //             break; //  จบลูปทันทีเมื่อเจอค่า
        //         }
        //     }
        // // dd('555555'.$row);

        //     //  เช็คว่า Year ตรงกับปีปัจจุบันหรือไม่
        //     if ($year == $currentYear) {
        //         // $htmlContent .= "
        //         //     <tbody>
        //         //         <tr>
        //         //             <th colspan='20' style='text-align: left; background-color: #ddd;'>ประเด็น: " . ($issue['name'] ?? '-') . "</th>
        //         //         </tr>";


        //         $sheet->setCellValue('A'. $row, ($issue['name'] ?? '-'));

        //         //  ลูปข้อมูลเป้าประสงค์ที่สัมพันธ์กับประเด็นยุทธศาสตร์นี้
        //         foreach ($data_goals as $goal) {
        //             $row++;
        //             if ($goal['SFA3LVID'] == $issue['SFA3LVID']) { // เชื่อมโยง FK
        //                 // $htmlContent .= "
        //                 // <tr>
        //                 //     <th colspan='20' style='text-align: left;'>เป้าประสงค์ที่: " . ($goal['name'] ?? '-') . "</th>
        //                 // </tr>";

        //                 $sheet->setCellValue('A'. $row, ($goal['name'] ?? '-'));
        //                 $row++;


        //                 //  ลูปข้อมูลกลยุทธ์ที่สัมพันธ์กับเป้าประสงค์นี้
        //                 foreach ($data_tactics as $tactic) {
        //                     if ($tactic['goal3LVID'] == $goal['goal3LVID']) { // เชื่อมโยง FK
        //                         $projectRows = [];

        //                         // ตัวแปรปี
        //                         $year1 = 2024;
        //                         $year2 = 2025;

        //                         // รายชื่อเดือนที่ใช้ในตาราง (ต.ค. - ก.ย.)
        //                         $months = ["ต.ค.", "พ.ย.", "ธ.ค.", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย."];

        //                         foreach ($data_projects as $project) {
        //                             if ($project['yearID'] == $yearID) {
        //                                 foreach ($data_strategic_maps as $map) {
        //                                     if ($map['tac3LVID'] == $tactic['tac3LVID'] && $map['proID'] == $project['proID']) {
        //                                         //  ดึง badgetTotal
        //                                         $badgetTotal = isset($project['badgetTotal']) ? number_format($project['badgetTotal'], 2) : "-";

        //                                         //  ลูปดึงข้อมูลจาก k_p_i_projects
        //                                         $kpiNames = [];
        //                                         $kpiTargets = [];
        //                                         foreach ($data_kpi_projects as $kpi) {
        //                                             if ($kpi['proID'] == $project['proID']) {
        //                                                 $kpiNames[] = '- ' . ($kpi['name'] ?? '-');

        //                                                 //  หาค่า name จาก count_k_p_i_projects
        //                                                 $targetLabel = "";
        //                                                 foreach ($data_count_kpi_projects as $countKpi) {
        //                                                     if ($countKpi['countKPIProID'] == $kpi['countKPIProID']) {
        //                                                         $targetLabel = '- ' . $countKpi['name'];
        //                                                         break; // หาค่าแรกที่ตรงกันแล้วหยุด
        //                                                     }
        //                                                 }

        //                                                 //  คำนวณค่าเป้าหมายโครงการ
        //                                                 $targetValue = "";
        //                                                 if (!empty($targetLabel) && isset($kpi['target'])) {
        //                                                     $targetValue = "$targetLabel " . number_format($kpi['target'], 2);
        //                                                 }
        //                                                 $kpiTargets[] = $targetValue;
        //                                             }
        //                                         }

        //                                         //  ดึงข้อมูลจาก steps
        //                                         $startMonth = null;
        //                                         $endMonth = null;
        //                                         foreach ($data_steps as $step) {
        //                                             if ($step['proID'] == $project['proID']) {
        //                                                 //  ใช้ปี ค.ศ. โดยตรง
        //                                                 $startDate = new DateTime($step['start']);
        //                                                 $endDate = new DateTime($step['end']);

        //                                                 $startYear = (int)$startDate->format('Y'); // ใช้ ค.ศ.
        //                                                 $endYear = (int)$endDate->format('Y');

        //                                                 $startMonth = (int)$startDate->format('m');
        //                                                 $endMonth = (int)$endDate->format('m');
        //                                             }
        //                                         }

        //  รวมโครงการและตัวชี้วัดให้อยู่ในคอลัมน์เดียวกัน
        //                                         $projectDetails = "<b>" . ($project['name'] ?? '-') . "</b><br>" . implode("<br>", $kpiNames);
        //                                         $projectTargetDetails = "<br>" . implode("<br>", $kpiTargets); // เพิ่มช่องว่างบรรทัดแรก


        //                                         //  สร้างแถวของโปรเจค
        //                                         $projectRows[] = [
        //                                             'details' => $projectDetails,
        //                                             'target' => $projectTargetDetails,
        //                                             'badgetTotal' => $badgetTotal,
        //                                             'startMonth' => $startMonth,
        //                                             'endMonth' => $endMonth,
        //                                             'startYear' => $startYear,
        //                                             'endYear' => $endYear
        //                                         ];
        //                                         //  dd($projectRows);

        //                                     }
        //                                 }
        //                                 foreach ($data_users_map as $user_map) {
        //                                     if ($project['proID'] == $user_map['proID']) {
        //                                         foreach ($data_users as $user) {
        //                                             if ($user_map['userID'] == $user['userID']) {
        //                                                 $name = $user['displayname'];
        //                                             }
        //                                         }
        //                                     }
        //                                 }
        //                             }
        //                         }

        //                         // $rowTac = $row; // ให้เริ่มต้นต่อจาก $row แทนการรีเซ็ตเป็น 9
        //                         //  ใช้ rowspan ให้กลยุทธ์แค่แถวแรก
        //                         $firstRow = true;
        //                         foreach ($projectRows as $projectData) {
        //                             // $htmlContent .= "<tr>";

        //                             //  แสดงกลยุทธ์แค่แถวแรกเท่านั้น
        //                             if ($firstRow) {
        //                                 // $htmlContent .= "<td></td><td style='text-align: left; vertical-align: top;'>" . ($tactic['name'] ?? '-') . "</td>";
        //                                 $sheet->setCellValue('B'. $row, ($tactic['name'] ?? '-'));

        //                                 $firstRow = false;
        //                             } else {
        //                                 // $htmlContent .= "<td></td><td></td>"; // ช่องว่างเมื่อเป็นแถวที่ 2 ขึ้นไป
        //                                 $row+=2;
        //                             }

        //                             //  แสดงข้อมูลโครงการและตัวชี้วัด
        //                             // $htmlContent .= "<td style='text-align: left; vertical-align: top;'>{$projectData['details']}</td>";
        //                             $sheet->setCellValue('C'. $row, $projectData['details']);



        //                             //  แสดงค่าเป้าหมายโครงการ
        //                             // $htmlContent .= "<td style='text-align: left; vertical-align: top;'>{$projectData['target']}</td>";
        //                             $sheet->setCellValue('D'. $row, $projectData['target']);


        //                             //  ช่องที่ 6 badgetTotal
        //                             // $htmlContent .= "<td style='text-align: center; vertical-align: top;'>{$projectData['badgetTotal']}</td>";
        //                             $sheet->setCellValue('B'. $row, ($projectData['badgetTotal'] ?? '-'));


        //                             //  ช่องเดือน ต.ค. - ก.ย.
        //                             for ($i = 0; $i < count($months); $i++) {
        //                                 $currentMonth = ($i + 10) % 12; // แปลง index เป็นเดือน (ต.ค. = 10)
        //                                 if ($currentMonth == 0) {
        //                                     $currentMonth = 12; // แก้ปัญหา ธ.ค.
        //                                 }
        //                                 $currentYear = $i >= 3 ? $year2 : $year1; // ปี 2024 = index 0-2, ปี 2025 = index 3-11

        //                                 //  เช็คว่าข้อมูลของ step ครอบคลุมเดือนนี้หรือไม่
        //                                 $highlight = "";
        //                                 if ($projectData['startYear'] && $projectData['endYear']) {
        //                                     $stepStart = ($projectData['startYear'] * 12) + $projectData['startMonth']; // แปลงเป็นตัวเลขเดือนทั้งหมด
        //                                     $stepEnd = ($projectData['endYear'] * 12) + $projectData['endMonth'];
        //                                     $current = ($currentYear * 12) + $currentMonth;

        //                                     if ($current >= $stepStart && $current <= $stepEnd) {
        //                                         $highlight = "style='background-color: yellow;'"; // ✅ ไฮไลต์ช่องสีเหลือง
        //                                     }
        //                                 }

        //                                 // $htmlContent .= "<td $highlight></td>";

        //                             }
        //                             // $htmlContent .= "<td>" . $name . "</td>";
        //                             $sheet->setCellValue('R'. $row, $name);


        //                             // $htmlContent .= "</tr>";
        //                         }

        //                         //  ถ้าไม่มีโครงการเลย ให้แสดง "-"
        //                         if (empty($projectRows)) {
        //                             // $htmlContent .= "
        //                             //     <tr>
        //                             //         <td></td>
        //                             //         <td style='text-align: left;'>" . ($tactic['name'] ?? '-') . "</td>
        //                             //         <td></td>
        //                             //         <td></td>
        //                             //         <td></td>
        //                             // ";
        //                             $sheet->setCellValue('B'. $row, ($tactic['name'] ?? '-'));


        //                             //  ช่องเดือน (ต.ค. - ก.ย.)
        //                             for ($i = 0; $i < count($months); $i++) {
        //                                 // $htmlContent .= "<td></td>";
        //                                 $row++;
        //                             }
        //                             $row++;
        //                             // $htmlContent .= "<td></td>";
        //                             // $htmlContent .= "</tr>";
        //                         }
        //                     }
        //                 }
        //             }
        //         }
        //         // dd($goal['SFA3LVID']);
        //     }
        // }
        // // dd($issue['name']);







        // สร้างไฟล์ Excel
        $writer = new Xlsx($spreadsheet);

        // บันทึกไฟล์
        $fileName = 'Objectives_Report.xlsx';
        $filePath = public_path($fileName);
        $writer->save($filePath);

        // ส่งกลับเป็นการดาวน์โหลดไฟล์
        return response()->download($filePath);
    }







    // public function excel_gen()
    // {
    //     // สร้าง Spreadsheet
    //     $spreadsheet = new Spreadsheet();
    //     $spreadsheet->getDefaultStyle()->getFont()->setName('TH Sarabun New')->setSize(14);
    //     $sheet = $spreadsheet->getActiveSheet();

    //     $currentYear = date('Y') + 543;
    //     $year1 = 2024 + 543;
    //     $year2 = 2025 + 543;

    //     // ดึงข้อมูลจากฐานข้อมูล (ใช้ Eloquent โดยตรง ไม่ต้องแปลงเป็น array)
    //     $all_projects = Projects::all();
    //     $years = Year::all();
    //     $users_map = UsersMapProject::all();
    //     $users = Users::all();
    //     $strategic_maps = StrategicMap::with(['SFA3LV', 'goal3LV', 'tac3LV'])->get();
    //     $strategic_issues = StrategicIssues::all();
    //     $strategics = Strategic3Level::all();
    //     $goals = Goals::all();
    //     $tactics = Tactics::all();
    //     $steps = Steps::all();
    //     $KPI_pros = KPIProjects::all();
    //     $countKPI_pros = CountKPIProjects::all();

    //     // ตั้งค่าหัวข้อเอกสาร
    //     $sheet->setCellValue('A1', "แผนปฏิบัติการประจำปีงบประมาณ พ.ศ. $currentYear");
    //     $sheet->setCellValue('A2', "สำนักคอมพิวเตอร์และเทคโนโลยีสารสนเทศ");
    //     $sheet->mergeCells('A1:R1');
    //     $sheet->mergeCells('A2:R2');
    //     $sheet->getStyle('A1:R2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    //     // ตั้งค่าหัวตาราง
    //     $headerRow = 4;
    //     $sheet->setCellValue('A' . $headerRow, 'ประเด็นยุทธ์ศาสตร์ / เป้าประสงค์');
    //     $sheet->setCellValue('B' . $headerRow, 'กลยุทธ์ (หน่วยงาน)');
    //     $sheet->setCellValue('C' . $headerRow, 'โครงการ / ตัวชี้วัดโครงการ');
    //     $sheet->setCellValue('D' . $headerRow, 'ค่าเป้าหมายโครงการ');
    //     $sheet->setCellValue('E' . $headerRow, 'เงินที่จัดสรร (บาท)');
    //     $sheet->setCellValue('F' . $headerRow, 'ระยะเวลาดำเนินงาน');
    //     $sheet->setCellValue('R' . $headerRow, 'ผู้รับผิดชอบ');

    //     // Merge cells สำหรับหัวตาราง
    //     $sheet->mergeCells('F' . $headerRow . ':Q' . $headerRow);
    //     $sheet->mergeCells('A' . $headerRow . ':A' . ($headerRow + 2));
    //     $sheet->mergeCells('B' . $headerRow . ':B' . ($headerRow + 2));
    //     $sheet->mergeCells('C' . $headerRow . ':C' . ($headerRow + 2));
    //     $sheet->mergeCells('D' . $headerRow . ':D' . ($headerRow + 2));
    //     $sheet->mergeCells('E' . $headerRow . ':E' . ($headerRow + 2));
    //     $sheet->mergeCells('R' . $headerRow . ':R' . ($headerRow + 2));

    //     // ตั้งค่าปีในหัวตาราง
    //     $yearHeaderRow = $headerRow + 1;
    //     $sheet->setCellValue('F' . $yearHeaderRow, 'พ.ศ.' . $year1);
    //     $sheet->setCellValue('I' . $yearHeaderRow, 'พ.ศ.' . $year2);
    //     $sheet->mergeCells('F' . $yearHeaderRow . ':H' . $yearHeaderRow);
    //     $sheet->mergeCells('I' . $yearHeaderRow . ':Q' . $yearHeaderRow);

    //     // ตั้งค่าชื่อเดือน
    //     $monthRow = $headerRow + 2;
    //     $months = ["ต.ค.", "พ.ย.", "ธ.ค.", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย."];
    //     $col = 'F';
    //     foreach ($months as $month) {
    //         $sheet->setCellValue($col . $monthRow, $month);
    //         $sheet->getStyle($col . $monthRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    //         $col++;
    //     }

    //     // เริ่มเขียนข้อมูล
    //     $dataRow = $monthRow + 1;

    //     foreach ($strategic_issues as $issue) {
    //         // หา yearID จาก strategic3_levels
    //         $strategic3_level = $strategics->where('stra3LVID', $issue->stra3LVID)->first();
    //         $yearID = $strategic3_level ? $strategic3_level->yearID : null;

    //         // หาปีจาก yearID
    //         $year = $years->where('yearID', $yearID)->first();
    //         $yearValue = $year ? ($year->year - 543) : null;

    //         if ($yearValue == $currentYear) {
    //             $sheet->setCellValue('A' . $dataRow, $issue->name ?? '-');

    //             foreach ($goals->where('SFA3LVID', $issue->SFA3LVID) as $goal) {
    //                 $dataRow++;
    //                 $sheet->setCellValue('A' . $dataRow, $goal->name ?? '-');
    //                 $dataRow++;

    //                 foreach ($tactics->where('goal3LVID', $goal->goal3LVID) as $tactic) {
    //                     $hasProjects = false;

    //                     foreach ($strategic_maps->where('tac3LVID', $tactic->tac3LVID) as $map) {
    //                         $project = $all_projects->where('proID', $map->proID)->where('yearID', $yearID)->first();

    //                         if ($project) {
    //                             $hasProjects = true;

    //                             // ดึงข้อมูล KPI
    //                             $kpiNames = [];
    //                             $kpiTargets = [];
    //                             foreach ($KPI_pros->where('proID', $project->proID) as $kpi) {
    //                                 $countKpi = $countKPI_pros->where('countKPIProID', $kpi->countKPIProID)->first();
    //                                 $kpiNames[] = '- ' . ($kpi->name ?? '-');
    //                                 $kpiTargets[] = '- ' . ($countKpi ? $countKpi->name . ' ' . number_format($kpi->target, 2) : '');
    //                             }

    //                             // ดึงข้อมูลระยะเวลา
    //                             $step = $steps->where('proID', $project->proID)->first();
    //                             $startDate = $step ? new DateTime($step->start) : null;
    //                             $endDate = $step ? new DateTime($step->end) : null;

    //                             // ดึงข้อมูลผู้รับผิดชอบ
    //                             $userMap = $users_map->where('proID', $project->proID)->first();
    //                             $user = $userMap ? $users->where('userID', $userMap->userID)->first() : null;
    //                             $userName = $user ? $user->displayname : '';

    //                             // เขียนข้อมูลโครงการ
    //                             $sheet->setCellValue('B' . $dataRow, $tactic->name ?? '-');
    //                             $sheet->setCellValue('C' . $dataRow, ($project->name ?? '-') . "\n" . implode("\n", $kpiNames));
    //                             $sheet->setCellValue('D' . $dataRow, implode("\n", $kpiTargets));
    //                             $sheet->setCellValue('E' . $dataRow, $project->badgetTotal ? number_format($project->badgetTotal, 2) : '-');
    //                             $sheet->setCellValue('R' . $dataRow, $userName);

    //                             // ระบายสีเดือนที่ดำเนินการ
    //                             if ($startDate && $endDate) {
    //                                 $startYear = (int)$startDate->format('Y');
    //                                 $startMonth = (int)$startDate->format('m');
    //                                 $endYear = (int)$endDate->format('Y');
    //                                 $endMonth = (int)$endDate->format('m');

    //                                 $col = 'F';
    //                                 for ($i = 0; $i < count($months); $i++) {
    //                                     $currentMonth = ($i + 10) % 12;
    //                                     if ($currentMonth == 0) $currentMonth = 12;
    //                                     $currentYear = $i >= 3 ? 2025 : 2024;

    //                                     $stepStart = ($startYear * 12) + $startMonth;
    //                                     $stepEnd = ($endYear * 12) + $endMonth;
    //                                     $current = ($currentYear * 12) + $currentMonth;

    //                                     if ($current >= $stepStart && $current <= $stepEnd) {
    //                                         $sheet->getStyle($col . $dataRow)->getFill()
    //                                             ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    //                                             ->getStartColor()->setARGB('FFFF00');
    //                                     }
    //                                     $col++;
    //                                 }
    //                             }

    //                             $dataRow++;
    //                         }
    //                     }

    //                     if (!$hasProjects) {
    //                         $sheet->setCellValue('B' . $dataRow, $tactic->name ?? '-');
    //                         $dataRow++;
    //                     }
    //                 }
    //             }
    //         }
    //     }

    //     // ปรับความกว้างของคอลัมน์
    //     foreach (range('A', 'R') as $col) {
    //         $sheet->getColumnDimension($col)->setAutoSize(true);
    //     }

    //     // บันทึกไฟล์
    //     $writer = new Xlsx($spreadsheet);
    //     $fileName = 'Objectives_Report_' . date('YmdHis') . '.xlsx';
    //     $filePath = public_path($fileName);
    //     $writer->save($filePath);

    //     return response()->download($filePath)->deleteFileAfterSend(true);
    // }
}
