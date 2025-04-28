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
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;



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
        $KPI_pros = KPIProjects::all();
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

        $startRow = $row;

        $sheet->setCellValue('A' . $row, 'ประเด็นยุทธ์ศาสตร์ / เป้าประสงค์');
        $sheet->setCellValue('B' . $row, 'กลยุทธ์ (หน่วยงาน)');
        $sheet->setCellValue('C' . $row, 'โครงการ / ตัวชี้วัดโครงการ');
        $sheet->setCellValue('D' . $row, 'ค่าเป้าหมายโครงการ');
        $sheet->setCellValue('E' . $row, 'เงินที่จัดสรร (บาท)');
        $sheet->setCellValue('F' . $row, 'ระยะเวลาดำเนินงาน');
        $sheet->setCellValue('R' . $row, 'ผู้รับผิดชอบ');
        // dd($row);

        $sheet->mergeCells('F' . $row . ':' . 'Q' . $row);
        $row2 = $row + 2;
        $sheet->mergeCells('A' . $row . ':' . 'A' . $row2);
        $sheet->mergeCells('B' . $row . ':' . 'B' . $row2);
        $sheet->mergeCells('C' . $row . ':' . 'C' . $row2);
        $sheet->mergeCells('D' . $row . ':' . 'D' . $row2);
        $sheet->mergeCells('E' . $row . ':' . 'E' . $row2);
        $sheet->mergeCells('R' . $row . ':' . 'R' . $row2);

        // เปิด Wrap Text ให้ทุกเซลล์ในหัวตาราง
        $sheet->getStyle('A' . $row . ':' . 'G' . $row)->getAlignment()->setWrapText(true);
        $sheet->getStyle('A' . $row . ':' . 'R' . $row)->applyFromArray($centerAlignment);

        $row++;

        $sheet->setCellValue('F' . $row, 'พ.ศ.' . $year1 + 543);
        $sheet->setCellValue('I' . $row, 'พ.ศ.' . $year2 + 543);

        $sheet->mergeCells('F' . $row . ':' . 'H' . $row);
        $sheet->mergeCells('I' . $row . ':' . 'Q' . $row);

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

            $yearID = null;
            foreach ($data_strategic3_levels as $level) {
                if ($level['stra3LVID'] == $issue['stra3LVID']) {
                    $yearID = $level['yearID'];
                    // dd($yearID);
                    break;
                }
            }

            $year = ($data_years['yearID'] == $yearID) ? $data_years['year'] - 543 : null;
            if ($year == $currentYear) {
                // แผน
                $sheet->setCellValue('A' . $row, 'ประเด็น: ' . $issue['name']);
                // ตั้งค่าสีพื้นหลัง
                $sheet->getStyle('A' . $row . ':' . 'R' . $row)
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('DDDDDD');
                $sheet->mergeCells('A' . $row . ':' . 'R' . $row);
                $row++;

                // $goalIndex = 1;
                foreach ($data_goals as $goal) {
                    //  เป้าประสงค์ที่อยู่ภายใต้แผนนี้เท่านั้น
                    if ($goal['SFA3LVID'] == $issue['SFA3LVID']) {
                        $sheet->setCellValue('A' . $row, "เป้าประสงค์ที่ " . $goal['name']);
                        $sheet->mergeCells('A' . $row . ':' . 'R' . $row);
                        $row++;

                        // $tacticIndex = 1;
                        foreach ($data_tactics as $tactic) {
                            if ($tactic['goal3LVID'] == $goal['goal3LVID']) {
                                $sheet->setCellValue('B' . $row, $tactic['name']);
                                // dd($row);
                                foreach ($data_strategic_maps as $map) {
                                    if ($map['tac3LVID'] == $tactic['tac3LVID']) {
                                        foreach ($data_projects as $project) {
                                            if ($project['proID'] == $map['proID']) {
                                                // ชื่อโครงการ
                                                $projectText = $project['name'] ?? '-';

                                                // ดึง KPI
                                                $kpiText = "";
                                                $targetText = "";
                                                foreach ($data_kpi_projects as $kpi) {
                                                    if ($kpi['proID'] == $project['proID']) {
                                                        $kpiText = ($kpi['name'] ?? '-');
                                                        // $kpiText .= "\n- " . ($kpi['name'] ?? '-');


                                                        // หาค่าเป้าหมายจาก count_k_p_i_projects
                                                        $countName = '';
                                                        foreach ($data_count_kpi_projects as $countKPI) {
                                                            if ($countKPI['countKPIProID'] == $kpi['countKPIProID']) {
                                                                $countName = $countKPI['name'];
                                                                break;
                                                            }
                                                        }

                                                        // $targetText .= "\n- " . $countName . " " . number_format($kpi['target'] ?? 0, 2);
                                                        $targetText .= "- " . $countName . " " . number_format($kpi['target'] ?? 0, 2);
                                                    }
                                                }
                                                // $sheet->setCellValue('C' . $row, $projectText . $kpiText);


                                                // รวมชื่อโครงการกับ KPI (Text Wrap)
                                                $sheet->setCellValue('C' . $row, $projectText);
                                                $row++;
                                                $sheet->setCellValue('C' . $row,  "- " . $kpiText);
                                                $sheet->getStyle('C' . $row)->getAlignment()->setWrapText(true);


                                                // แสดงค่าเป้าหมาย
                                                $sheet->setCellValue('D' . $row, $targetText);
                                                $sheet->getStyle('D' . $row)->getAlignment()->setWrapText(true);


                                                // งบประมาณ
                                                $sheet->setCellValue('E' . $row, number_format($project['badgetTotal'] ?? 0, 2));


                                                // ระบายเดือน
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

                                                $excelMonthOrder = [10, 11, 12, 1, 2, 3, 4, 5, 6, 7, 8, 9];

                                                foreach ($excelMonthOrder as $i => $month) {
                                                    $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(6 + $i); // คอลัมน์ F เริ่มที่ index 6

                                                    // ถ้า index 0-2 -> ต.ค. - ธ.ค. = year1, 3 ขึ้นไป = year2
                                                    $currentYear = ($i >= 3) ? $year2 : $year1;

                                                    if ($startYear && $endYear && $startMonth && $endMonth) {
                                                        $stepStart = ($startYear * 12) + $startMonth;
                                                        $stepEnd = ($endYear * 12) + $endMonth;
                                                        $current = ($currentYear * 12) + $month;

                                                        if ($current >= $stepStart && $current <= $stepEnd) {
                                                            $sheet->getStyle($col . $row)->getFill()
                                                                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                                                ->getStartColor()->setARGB('FFFF00');
                                                        }
                                                    }
                                                }


                                                // ผู้รับผิดชอบ
                                                $responsible = '-';
                                                foreach ($data_users_map as $user_map) {
                                                    if ($user_map['proID'] == $project['proID']) {
                                                        foreach ($data_users as $user) {
                                                            if ($user['userID'] == $user_map['userID']) {
                                                                $responsible = $user['displayname'];
                                                                break 2;
                                                            }
                                                        }
                                                    }
                                                }

                                                $sheet->setCellValue('R' . $row, $responsible);
                                                $sheet->getStyle('R' . $row)->applyFromArray($centerAlignment);
                                                $sheet->getStyle('R' . $row)->getAlignment()->setWrapText(true);

                                                // dd($row);
                                                $row++; // เฉพาะเมื่อเจอโครงการใหม่
                                            }
                                        }
                                    }
                                }

                                $row++; // ขึ้นแถวใหม่เมื่อเปลี่ยนกลยุทธ์
                            }
                        }
                    }
                }
            }
        }

        // กำหนดช่วงของตารางที่ต้องการใส่ border (ตั้งแต่แถว 4 ถึงแถวสุดท้าย)
        // $startRow = 4;
        $endRow = $row - 1; // $row คือตำแหน่งแถวสุดท้ายที่ใช้

        $sheet->getStyle('A' . $startRow . ':R' . $endRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);


        // แผนระดับที่ 2
        $row++;

        // ตั้งค่าหัวข้อเอกสาร
        $sheet->setCellValue('A' . $row, "แผนปฏิบัติการประจำปีงบประมาณ พ.ศ." . $currentYear + 543);
        $sheet->mergeCells('A' . $row . ':R' . $row);
        $sheet->getStyle('A' . $row)->applyFromArray($centerAlignment);


        $row++;
        $sheet->setCellValue('A' . $row, "สำนักคอมพิวเตอร์และเทคโนโลยีสารสนเทศ");
        $sheet->mergeCells('A' . $row . ':R' . $row);
        $sheet->getStyle('A' . $row)->applyFromArray($centerAlignment);

        $row += 2;

        //กำหนดช่วงของตารางที่ต้องการใส่ border (ตั้งแต่แถว 4 ถึงแถวสุดท้าย)
        $startRow = $row;
        // dd($endRow);

        $sheet->setCellValue('A' . $row, 'ประเด็นยุทธ์ศาสตร์');
        $sheet->setCellValue('B' . $row, 'กลยุทธ์ (หน่วยงาน)');
        $sheet->setCellValue('C' . $row, 'โครงการ / ตัวชี้วัดโครงการ');
        $sheet->setCellValue('D' . $row, 'ค่าเป้าหมายโครงการ');
        $sheet->setCellValue('E' . $row, 'เงินที่จัดสรร (บาท)');
        $sheet->setCellValue('F' . $row, 'ระยะเวลาดำเนินงาน');
        $sheet->setCellValue('R' . $row, 'ผู้รับผิดชอบ');
        // dd($row);

        $sheet->mergeCells('F' . $row . ':' . 'Q' . $row);
        $row2 = $row + 2;
        $sheet->mergeCells('A' . $row . ':' . 'A' . $row2);
        $sheet->mergeCells('B' . $row . ':' . 'B' . $row2);
        $sheet->mergeCells('C' . $row . ':' . 'C' . $row2);
        $sheet->mergeCells('D' . $row . ':' . 'D' . $row2);
        $sheet->mergeCells('E' . $row . ':' . 'E' . $row2);
        $sheet->mergeCells('R' . $row . ':' . 'R' . $row2);

        // เปิด Wrap Text ให้ทุกเซลล์ในหัวตาราง
        $sheet->getStyle('A' . $row . ':' . 'G' . $row)->getAlignment()->setWrapText(true);
        $sheet->getStyle('A' . $row . ':' . 'R' . $row)->applyFromArray($centerAlignment);

        $row++;

        $sheet->setCellValue('F' . $row, 'พ.ศ.' . $year1 + 543);
        $sheet->setCellValue('I' . $row, 'พ.ศ.' . $year2 + 543);

        $sheet->mergeCells('F' . $row . ':' . 'H' . $row);
        $sheet->mergeCells('I' . $row . ':' . 'Q' . $row);

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

        foreach ($data_strategic2_issues as $issue) {

            $yearID = null;
            foreach ($data_strategic2_levels as $level) {
                if ($level['stra2LVID'] == $issue['stra2LVID']) {
                    $yearID = $level['yearID'];
                    // dd($yearID);
                    break;
                }
            }

            $year = ($data_years['yearID'] == $yearID) ? $data_years['year'] - 543 : null;
            if ($year == $currentYear) {
                // แผน
                $sheet->setCellValue('A' . $row, 'ประเด็น: ' . $issue['name']);
                // ตั้งค่าสีพื้นหลัง
                $sheet->getStyle('A' . $row . ':' . 'R' . $row)
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('DDDDDD');
                $sheet->mergeCells('A' . $row . ':' . 'R' . $row);
                $row++;

                foreach ($data_tactic2_levels as $tactic) {
                    if ($tactic['SFA2LVID'] == $issue['SFA2LVID']) {
                        $sheet->setCellValue('B' . $row, $tactic['name']);
                        // dd($row);
                        foreach ($data_strategic2_level_maps  as $map) {
                            if ($map['tac2LVID'] == $tactic['tac2LVID']) {
                                foreach ($data_projects as $project) {
                                    if ($project['proID'] == $map['proID']) {
                                        // ชื่อโครงการ
                                        $projectText = $project['name'] ?? '-';

                                        // ดึง KPI
                                        $kpiText = "";
                                        $targetText = "";
                                        foreach ($data_kpi_projects as $kpi) {
                                            if ($kpi['proID'] == $project['proID']) {
                                                $kpiText = ($kpi['name'] ?? '-');
                                                // $kpiText .= "\n- " . ($kpi['name'] ?? '-');


                                                // หาค่าเป้าหมายจาก count_k_p_i_projects
                                                $countName = '';
                                                foreach ($data_count_kpi_projects as $countKPI) {
                                                    if ($countKPI['countKPIProID'] == $kpi['countKPIProID']) {
                                                        $countName = $countKPI['name'];
                                                        break;
                                                    }
                                                }

                                                // $targetText .= "\n- " . $countName . " " . number_format($kpi['target'] ?? 0, 2);
                                                $targetText .= "- " . $countName . " " . number_format($kpi['target'] ?? 0, 2);
                                            }
                                        }


                                        // รวมชื่อโครงการกับ KPI (Text Wrap)
                                        $sheet->setCellValue('C' . $row, $projectText);
                                        $row++;
                                        $sheet->setCellValue('C' . $row,  "- " . $kpiText);
                                        $sheet->getStyle('C' . $row)->getAlignment()->setWrapText(true);


                                        // แสดงค่าเป้าหมาย
                                        $sheet->setCellValue('D' . $row, $targetText);
                                        $sheet->getStyle('D' . $row)->getAlignment()->setWrapText(true);


                                        // งบประมาณ
                                        $sheet->setCellValue('E' . $row, number_format($project['badgetTotal'] ?? 0, 2));


                                        // ระบายเดือน
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

                                        $excelMonthOrder = [10, 11, 12, 1, 2, 3, 4, 5, 6, 7, 8, 9];

                                        foreach ($excelMonthOrder as $i => $month) {
                                            $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(6 + $i); // คอลัมน์ F เริ่มที่ index 6

                                            // ถ้า index 0-2 -> ต.ค. - ธ.ค. = year1, 3 ขึ้นไป = year2
                                            $currentYear = ($i >= 3) ? $year2 : $year1;

                                            if ($startYear && $endYear && $startMonth && $endMonth) {
                                                $stepStart = ($startYear * 12) + $startMonth;
                                                $stepEnd = ($endYear * 12) + $endMonth;
                                                $current = ($currentYear * 12) + $month;

                                                if ($current >= $stepStart && $current <= $stepEnd) {
                                                    $sheet->getStyle($col . $row)->getFill()
                                                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                                        ->getStartColor()->setARGB('FFFF00');
                                                }
                                            }
                                        }


                                        // ผู้รับผิดชอบ
                                        $responsible = '-';
                                        foreach ($data_users_map as $user_map) {
                                            if ($user_map['proID'] == $project['proID']) {
                                                foreach ($data_users as $user) {
                                                    if ($user['userID'] == $user_map['userID']) {
                                                        $responsible = $user['displayname'];
                                                        break 2;
                                                    }
                                                }
                                            }
                                        }

                                        $sheet->setCellValue('R' . $row, $responsible);
                                        $sheet->getStyle('R' . $row)->applyFromArray($centerAlignment);
                                        $sheet->getStyle('R' . $row)->getAlignment()->setWrapText(true);

                                        $row++; // เฉพาะเมื่อเจอโครงการใหม่
                                    }
                                }
                            }
                        }

                        $row++; // ขึ้นแถวใหม่เมื่อเปลี่ยนกลยุทธ์
                    }
                }
            }
        }
        // dd($row);


        //กำหนดช่วงของตารางที่ต้องการใส่ border (ตั้งแต่แถว 4 ถึงแถวสุดท้าย)
        // $startRow = $row;
        $endRow = $row - 1; // $row คือตำแหน่งแถวสุดท้ายที่ใช้

        // dd($startRow);

        $sheet->getStyle('A' . $startRow . ':R' . $endRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);



        // แผนระดับที่ 1
        $row++;

        // ตั้งค่าหัวข้อเอกสาร
        $sheet->setCellValue('A' . $row, "แผนปฏิบัติการประจำปีงบประมาณ พ.ศ." . $currentYear + 543);
        $sheet->mergeCells('A' . $row . ':R' . $row);
        $sheet->getStyle('A' . $row)->applyFromArray($centerAlignment);


        $row++;
        $sheet->setCellValue('A' . $row, "สำนักคอมพิวเตอร์และเทคโนโลยีสารสนเทศ");
        $sheet->mergeCells('A' . $row . ':R' . $row);
        $sheet->getStyle('A' . $row)->applyFromArray($centerAlignment);

        $row += 2;

        //กำหนดช่วงของตารางที่ต้องการใส่ border (ตั้งแต่แถว 4 ถึงแถวสุดท้าย)
        $startRow = $row;

        $sheet->setCellValue('A' . $row, 'ประเด็นยุทธ์ศาสตร์');
        $sheet->setCellValue('B' . $row, 'กลยุทธ์ (หน่วยงาน)');
        $sheet->setCellValue('C' . $row, 'โครงการ / ตัวชี้วัดโครงการ');
        $sheet->setCellValue('D' . $row, 'ค่าเป้าหมายโครงการ');
        $sheet->setCellValue('E' . $row, 'เงินที่จัดสรร (บาท)');
        $sheet->setCellValue('F' . $row, 'ระยะเวลาดำเนินงาน');
        $sheet->setCellValue('R' . $row, 'ผู้รับผิดชอบ');
        // dd($row);

        $sheet->mergeCells('F' . $row . ':' . 'Q' . $row);
        $row2 = $row + 2;
        $sheet->mergeCells('A' . $row . ':' . 'A' . $row2);
        $sheet->mergeCells('B' . $row . ':' . 'B' . $row2);
        $sheet->mergeCells('C' . $row . ':' . 'C' . $row2);
        $sheet->mergeCells('D' . $row . ':' . 'D' . $row2);
        $sheet->mergeCells('E' . $row . ':' . 'E' . $row2);
        $sheet->mergeCells('R' . $row . ':' . 'R' . $row2);

        // เปิด Wrap Text ให้ทุกเซลล์ในหัวตาราง
        $sheet->getStyle('A' . $row . ':' . 'G' . $row)->getAlignment()->setWrapText(true);
        $sheet->getStyle('A' . $row . ':' . 'R' . $row)->applyFromArray($centerAlignment);

        $row++;

        $sheet->setCellValue('F' . $row, 'พ.ศ.' . $year1 + 543);
        $sheet->setCellValue('I' . $row, 'พ.ศ.' . $year2 + 543);

        $sheet->mergeCells('F' . $row . ':' . 'H' . $row);
        $sheet->mergeCells('I' . $row . ':' . 'Q' . $row);

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

        foreach ($data_strategic1_levels as $level) {
            $yearID = null;
            $yearID = $level['yearID'];
        }

        $year = ($data_years['yearID'] == $yearID) ? $data_years['year'] - 543 : null;
        if ($year == $currentYear) {
            // แผน
            $sheet->setCellValue('A' . $row, 'ประเด็น: ' . $issue['name']);
            // ตั้งค่าสีพื้นหลัง
            $sheet->getStyle('A' . $row . ':' . 'R' . $row)
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB('DDDDDD');
            $sheet->mergeCells('A' . $row . ':' . 'R' . $row);
            $row++;

            foreach ($data_target1_levels as $target) {
                if ($target['stra1LVID'] == $level['stra1LVID']) {
                    $sheet->setCellValue('B' . $row, $target['name']);
                    // dd($row);
                    foreach ($data_strategic1_level_maps  as $map) {
                        if ($map['tar1LVID'] == $target['tar1LVID']) {
                            foreach ($data_projects as $project) {
                                if ($project['proID'] == $map['proID']) {
                                    // ชื่อโครงการ
                                    $projectText = $project['name'] ?? '-';

                                    // ดึง KPI
                                    $kpiText = "";
                                    $targetText = "";
                                    foreach ($data_kpi_projects as $kpi) {
                                        if ($kpi['proID'] == $project['proID']) {
                                            $kpiText = ($kpi['name'] ?? '-');
                                            // $kpiText .= "\n- " . ($kpi['name'] ?? '-');


                                            // หาค่าเป้าหมายจาก count_k_p_i_projects
                                            $countName = '';
                                            foreach ($data_count_kpi_projects as $countKPI) {
                                                if ($countKPI['countKPIProID'] == $kpi['countKPIProID']) {
                                                    $countName = $countKPI['name'];
                                                    break;
                                                }
                                            }

                                            // $targetText .= "\n- " . $countName . " " . number_format($kpi['target'] ?? 0, 2);
                                            $targetText .= "- " . $countName . " " . number_format($kpi['target'] ?? 0, 2);
                                        }
                                    }


                                    // รวมชื่อโครงการกับ KPI (Text Wrap)
                                    $sheet->setCellValue('C' . $row, $projectText);
                                    $row++;
                                    $sheet->setCellValue('C' . $row,  "- " . $kpiText);
                                    $sheet->getStyle('C' . $row)->getAlignment()->setWrapText(true);


                                    // แสดงค่าเป้าหมาย
                                    $sheet->setCellValue('D' . $row, $targetText);
                                    $sheet->getStyle('D' . $row)->getAlignment()->setWrapText(true);


                                    // งบประมาณ
                                    $sheet->setCellValue('E' . $row, number_format($project['badgetTotal'] ?? 0, 2));


                                    // ระบายเดือน
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

                                    $excelMonthOrder = [10, 11, 12, 1, 2, 3, 4, 5, 6, 7, 8, 9];

                                    foreach ($excelMonthOrder as $i => $month) {
                                        $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(6 + $i); // คอลัมน์ F เริ่มที่ index 6

                                        // ถ้า index 0-2 -> ต.ค. - ธ.ค. = year1, 3 ขึ้นไป = year2
                                        $currentYear = ($i >= 3) ? $year2 : $year1;

                                        if ($startYear && $endYear && $startMonth && $endMonth) {
                                            $stepStart = ($startYear * 12) + $startMonth;
                                            $stepEnd = ($endYear * 12) + $endMonth;
                                            $current = ($currentYear * 12) + $month;

                                            if ($current >= $stepStart && $current <= $stepEnd) {
                                                $sheet->getStyle($col . $row)->getFill()
                                                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                                    ->getStartColor()->setARGB('FFFF00');
                                            }
                                        }
                                    }


                                    // ผู้รับผิดชอบ
                                    $responsible = '-';
                                    foreach ($data_users_map as $user_map) {
                                        if ($user_map['proID'] == $project['proID']) {
                                            foreach ($data_users as $user) {
                                                if ($user['userID'] == $user_map['userID']) {
                                                    $responsible = $user['displayname'];
                                                    break 2;
                                                }
                                            }
                                        }
                                    }

                                    $sheet->setCellValue('R' . $row, $responsible);
                                    $sheet->getStyle('R' . $row)->applyFromArray($centerAlignment);
                                    $sheet->getStyle('R' . $row)->getAlignment()->setWrapText(true);

                                    // dd($row);
                                    $row++; // เฉพาะเมื่อเจอโครงการใหม่
                                }
                            }
                        }
                    }

                    $row++; // ขึ้นแถวใหม่เมื่อเปลี่ยนกลยุทธ์
                }
            }
        }


        $endRow = $row - 1; // $row คือตำแหน่งแถวสุดท้ายที่ใช้

        $sheet->getStyle('A' . $startRow . ':R' . $endRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);









        $writer = new Xlsx($spreadsheet);

        return response()->streamDownload(function () use ($writer, $spreadsheet) {
            $writer->save('php://output');
        }, "แผนปฏิบัติการประจำปีงบประมาณ พ.ศ." . ($currentYear + 543) . ".xlsx");
    }
}
