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
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Symfony\Component\HttpFoundation\StreamedResponse;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;


use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class ExcelEffectiveController extends Controller
{
    public function excel_gen($id)
    {
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

        // ตรวจสอบว่า $id มีค่าหรือไม่
        if (empty($id)) {
            return response()->json(['message' => 'ไม่มีข้อมูลของโครงการ'], 400, [], JSON_UNESCAPED_UNICODE);
        }

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



        // สร้าง Spreadsheet
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getDefaultStyle()->getFont()->setName('TH Sarabun New')->setSize(14);
        $sheet = $spreadsheet->getActiveSheet();

        if ($projects && $projects->yearID) {
            foreach ($years as $year) {
                if ($projects->yearID == $year->yearID) {
                    $y = $year->year; // เก็บค่าปีงบประมาณไว้ในตัวแปร $y
                    break; // เจอปีที่ตรงกันแล้วก็หยุด loop เลย ไม่ต้องวนต่อ
                }
            }
        } else {
            return redirect()->back()->with('error', 'ไม่พบข้อมูลโครงการ');
        }


        // ใส่ข้อความที่ A1 และรวมเซลล์จาก A1 ถึง D1
        $sheet->setCellValue('A1', 'การประเมินประสิทธิผล');
        $sheet->setCellValue('B1', 'โครงการ' . $projects->name);
        $sheet->setCellValue('E1', 'ปีงบประมาณ พ.ศ.' . $y);
        $sheet->mergeCells('E1:F1');
        $sheet->mergeCells(range: 'B1:D1');

        // ใช้สไตล์ที่กำหนดกับเซลล์ A1
        $sheet->getStyle('A1')->applyFromArray($centerAlignment);
        $sheet->getStyle('B1')->applyFromArray($leftAlignment);  // ใช้การจัดชิดซ้ายสำหรับ B1
        $sheet->getStyle('E1:F1')->applyFromArray($centerAlignment);  // รวมการจัดกลางแนวนอนและแนวตั้งสำหรับ C1:D1

        // ดึงข้อมูลที่ตรงกับ proID
        $objectives = DB::table('objectives')->where('proID', $id)->get();

        // ตัวแปรเก็บข้อมูลแยกแต่ละประเภท
        $objectiveNumbers = []; // เก็บลำดับ
        $objectiveDetails = []; // เก็บรายละเอียดวัตถุประสงค์
        $objectiveStatuses = []; // เก็บสถานะบรรลุ / ไม่บรรลุ

        // วนลูปเก็บค่าลงในตัวแปรที่แยกออกมา
        foreach ($objectives as $index => $objective) {
            $objectiveNumbers[] = $index + 1;
            $objectiveDetails[] = $objective->detail;
            $objectiveStatuses[] = $objective->achieve == 1 ? 'บรรลุ' : 'ไม่บรรลุ';
        }

        // รวมข้อมูลเป็น array
        $dataObjectives = [
            'ลำดับ' => $objectiveNumbers,
            'วัตถุประสงค์' => $objectiveDetails,
            'สถานะ' => $objectiveStatuses,
        ];

        // ใส่หัวตาราง
        $sheet->setCellValue('A2', 'ลำดับ');
        $sheet->setCellValue('B2', 'วัตถุประสงค์');
        $sheet->setCellValue('E2', 'บรรลุ / ไม่บรรลุ');
        $sheet->setCellValue('F2', 'หน่วย');
        $sheet->mergeCells(range: 'B2:D2');

        // กำหนดสไตล์ให้หัวตาราง
        $styleArray = [
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFFF99'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,  // จัดกลางแนวนอน
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,    // จัดกลางแนวตั้ง
            ],
        ];


        $sheet->getStyle('A2:F2')->applyFromArray($styleArray);

        // กำหนดความกว้างอัตโนมัติสำหรับคอลัมน์ B (รายละเอียด)
        $sheet->getColumnDimension('B')->setAutoSize(true);

        // กำหนดความกว้างของคอลัมน์ (ปรับขนาดให้เหมาะสม)
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setWidth(10);


        // เริ่มแสดงข้อมูลจากแถวที่ 2 เป็นต้นไป
        $row = 3;
        foreach ($dataObjectives['วัตถุประสงค์'] as $index => $obj) {
            // ใส่ข้อมูลในแต่ละเซลล์
            $achieveStatus = $dataObjectives['สถานะ'][$index] == 'บรรลุ' ? '✓' : '✗';

            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $obj);
            $sheet->setCellValue('E' . $row, $achieveStatus);
            $sheet->setCellValue('F' . $row, 'ข้อ');
            $sheet->mergeCells(range: 'B' . $row . ':D' . $row . '');

            // ใช้ตัวแปรจัดตำแหน่งในการปรับเซลล์
            $sheet->getStyle('A' . $row)->applyFromArray($centerAlignment);
            $sheet->getStyle('B' . $row)->applyFromArray($leftAlignment);
            $sheet->getStyle('E' . $row)->applyFromArray($centerAlignment);
            $sheet->getStyle('F' . $row)->applyFromArray($centerAlignment);

            // ขยับไปแถวถัดไป
            $row++;
        }

        $totalObj = count($dataObjectives['วัตถุประสงค์']);
        $achievedObj = array_count_values($dataObjectives['สถานะ'])['บรรลุ'];
        // dd($achievedObj);
        // แสดงผลรวมข้อมูล
        $sheet->setCellValue('A' . $row, 'รวมวัตถุประสงค์ทั้งหมด');
        $sheet->mergeCells('A' . $row . ':D' . $row); // รวมเซลล์ A และ B
        $sheet->getStyle('A' . $row)->applyFromArray($centerAlignment);
        $sheet->setCellValue('E' . $row, $totalObj);
        $sheet->setCellValue('F' . $row, 'ข้อ');
        $sheet->getStyle('A' . $row . ':F' . $row)->applyFromArray($styleArray); // ปรับให้แถวผลรวมอยู่ตรงกลาง
        $row++;

        $sheet->setCellValue('A' . $row, 'รวมวัตถุประสงค์ที่บรรลุ');
        $sheet->mergeCells('A' . $row . ':D' . $row); // รวมเซลล์ A และ B
        $sheet->getStyle('A' . $row)->applyFromArray($centerAlignment);
        $sheet->setCellValue('E' . $row, $achievedObj);
        $sheet->setCellValue('F' . $row, 'ข้อ');
        $sheet->getStyle('A' . $row . ':F' . $row)->applyFromArray($styleArray); // ปรับให้แถวผลรวมอยู่ตรงกลาง
        $row++;

        $statuses = array_count_values($dataObjectives['สถานะ']);
        $notAchievedCount = isset($statuses['ไม่บรรลุ']) ? $statuses['ไม่บรรลุ'] : 0; // กำหนดค่าเป็น 0 หากคีย์ไม่พบ

        $sheet->setCellValue('A' . $row, 'รวมวัตถุประสงค์ที่ไม่บรรลุ');
        $sheet->mergeCells('A' . $row . ':D' . $row); // รวมเซลล์ A และ B
        $sheet->getStyle('A' . $row)->applyFromArray($centerAlignment);
        $sheet->setCellValue('E' . $row, $notAchievedCount);
        // $sheet->setCellValue('E' . $row, array_count_values($dataObjectives['สถานะ'])['ไม่บรรลุ']);
        $sheet->setCellValue('F' . $row, 'ข้อ');
        $sheet->getStyle('A' . $row . ':F' . $row)->applyFromArray($styleArray); // ปรับให้แถวผลรวมอยู่ตรงกลาง
        $row++;

        // หาตำแหน่งแถวสุดท้ายที่มีข้อมูล และขยับไป 1 แถว
        // $row = $sheet->getHighestRow() + 1; // ขยับไป 1 แถว

        // หาตำแหน่งแถวสุดท้ายที่มีข้อมูล และขยับไป 2 แถว
        $lastRow = $sheet->getHighestRow(); // หาตำแหน่งแถวสุดท้ายที่มีข้อมูล
        $row = $lastRow + 3; // ขยับไปอีก 3 แถว (เว้นไป 2 แถว)

        // กำหนดหัวตารางที่แถวที่ $row (แถวสุดท้าย + 3)
        $sheet->setCellValue('A' . $row, 'ลำดับ');
        $sheet->setCellValue('B' . $row, 'ตัวชี้วัดโครงการ');
        $sheet->setCellValue('C' . $row, 'หน่วยนับ');
        $sheet->setCellValue('D' . $row, 'ค่าที่ได้');
        $sheet->setCellValue('E' . $row, 'ผลค่าเป้าหมาย');
        $sheet->setCellValue('F' . $row, 'รวม');

        // ใช้สไตล์ที่กำหนดให้กับหัวตาราง (A, B, C, D, E, F)
        $sheet->getStyle('A' . $row . ':F' . $row)->applyFromArray($styleArray);

        $row++; // เริ่มจากแถวถัดไป

        // ดึงข้อมูลจาก k_p_i_projects
        $KPI_pros = DB::table('k_p_i_projects')->where('proID', $id)->get();
        // ดึงข้อมูลจากตารางหน่วยนับ
        $countKPI_pros = DB::table('count_k_p_i_projects')->get();

        $counter = 1;
        // ตัวแปรนับจำนวนตัวชี้วัด
        $totalKPI = 0;
        $achievedKPI = 0;
        $notAchievedKPI = 0;

        foreach ($KPI_pros as $KPI_pro) {
            foreach ($countKPI_pros as $countKPI_pro) {
                if ($KPI_pro->countKPIProID == $countKPI_pro->countKPIProID) {
                    // นับจำนวน KPI ทั้งหมด
                    $totalKPI++;
                    // $total = $KPI_pro->target / $KPI_pro->result_eva;
                    // $scoreObj = $totalObj / $achievedObj;
                    // $scoreKPI = $totalKPI / $achievedKPI;

                    $total = ($KPI_pro->result_eva != 0) ? ($KPI_pro->target / $KPI_pro->result_eva) : 0;


                    if ($total >= 1) {
                        $achievedKPI++; // ถ้าบรรลุเป้าหมาย
                    } else {
                        $notAchievedKPI++; // ถ้าไม่บรรลุเป้าหมาย
                    }



                    // เพิ่มข้อมูลลงแถว
                    $sheet->setCellValue('A' . $row, $counter);
                    $sheet->setCellValue('B' . $row, $KPI_pro->name);
                    $sheet->setCellValue('C' . $row, $countKPI_pro->name);
                    $sheet->setCellValue('D' . $row, $KPI_pro->target);
                    $sheet->setCellValue('E' . $row, $KPI_pro->result_eva);
                    $sheet->setCellValue('F' . $row, $total);

                    // ใช้ตัวแปรจัดตำแหน่งในการปรับเซลล์
                    $sheet->getStyle('A' . $row)->applyFromArray($centerAlignment);
                    $sheet->getStyle('B' . $row)->applyFromArray($leftAlignment);
                    $sheet->getStyle('C' . $row)->applyFromArray($centerAlignment);
                    $sheet->getStyle('D' . $row)->applyFromArray($rightAlignment);
                    $sheet->getStyle('E' . $row)->applyFromArray($rightAlignment);
                    $sheet->getStyle('F' . $row)->applyFromArray($centerAlignment);

                    $counter++;
                    $row++;
                }
            }
        }

        // เพิ่ม 3 แถวสุดท้าย
        $sheet->mergeCells("A$row:D$row");
        $sheet->setCellValue("A$row", "รวมตัวชี้วัดทั้งหมด");
        $sheet->setCellValue("E$row", $totalKPI);
        $sheet->setCellValue("F$row", "ตัวชี้วัด");
        $sheet->getStyle('A' . $row . ':F' . $row)->applyFromArray($styleArray);
        $row++;

        $sheet->mergeCells("A$row:D$row");
        $sheet->setCellValue("A$row", "รวมตัวชี้วัดที่บรรลุ");
        $sheet->setCellValue("E$row", $achievedKPI);
        $sheet->setCellValue("F$row", "ตัวชี้วัด");
        $sheet->getStyle('A' . $row . ':F' . $row)->applyFromArray($styleArray);
        $row++;

        $sheet->mergeCells("A$row:D$row");
        $sheet->setCellValue("A$row", "รวมตัวชี้วัดที่ไม่บรรลุ");
        $sheet->setCellValue("E$row", $notAchievedKPI);
        $sheet->setCellValue("F$row", "ตัวชี้วัด");
        $sheet->getStyle('A' . $row . ':F' . $row)->applyFromArray($styleArray);


        $scoreObj = ($achievedObj != 0) ? ($totalObj / $achievedObj) : 0;
        $scoreKPI = ($achievedKPI != 0) ? ($totalKPI / $achievedKPI) : 0;
        $pro_effect = (($scoreObj + $scoreKPI) / 2) * 100;

        // กำหนดช่วงที่ต้องใส่เส้นขอบ
        $borderRows = [
            ['start' => 2, 'end' => 7],
            ['start' => 10, 'end' => 15]
        ];


        // เว้น 2 บรรทัดก่อนเริ่มตารางใหม่
        $row += 1;



        $row += 2;

        // ใส่หัวข้อของตารางใหม่
        $sheet->setCellValue("A{$row}", 'ลำดับ');
        $sheet->setCellValue("B{$row}", 'รายการ');
        $sheet->mergeCells("B{$row}:D{$row}");
        $sheet->setCellValue("E{$row}", 'ค่าที่ได้');
        $sheet->setCellValue("F{$row}", 'หน่วย');

        // ใช้สไตล์หัวข้อ (ใส่สีพื้นหลัง)
        $sheet->getStyle("A{$row}:F{$row}")->applyFromArray($styleArray);

        // เริ่มกำหนดข้อมูลแต่ละแถว
        $row++; // ขยับไปแถวถัดไป
        $startRow = $row; // บันทึกแถวแรก

        // แถวที่ 1
        $sheet->setCellValue("A{$row}", '1');
        $sheet->setCellValue("B{$row}", 'คะแนนวัตถุประสงค์');
        $sheet->mergeCells("B{$row}:D{$row}");
        $sheet->setCellValue("E{$row}", $scoreObj);
        $sheet->setCellValue("F{$row}", 'คะแนน');


        // ใช้ตัวแปรจัดตำแหน่งในการปรับเซลล์
        $sheet->getStyle('A' . $row)->applyFromArray($centerAlignment);
        $sheet->getStyle('E' . $row)->applyFromArray($centerAlignment);
        $sheet->getStyle('F' . $row)->applyFromArray($centerAlignment);
        $row++; // ขยับไปแถวถัดไป

        // แถวที่ 2
        $sheet->setCellValue("A{$row}", '2');
        $sheet->setCellValue("B{$row}", 'คะแนนตัวชี้วัด');
        $sheet->mergeCells("B{$row}:D{$row}");
        $sheet->setCellValue("E{$row}", $scoreKPI);
        $sheet->setCellValue("F{$row}", 'คะแนน');


        // ใช้ตัวแปรจัดตำแหน่งในการปรับเซลล์
        $sheet->getStyle('A' . $row)->applyFromArray($centerAlignment);
        $sheet->getStyle('E' . $row)->applyFromArray($centerAlignment);
        $sheet->getStyle('F' . $row)->applyFromArray($centerAlignment);
        $row++; // ขยับไปแถวถัดไป

        // แถวที่ 3
        $sheet->setCellValue("A{$row}", '3');
        $sheet->setCellValue("B{$row}", 'ประสิทธิผลของโครงการ');
        $sheet->mergeCells("B{$row}:D{$row}");
        $sheet->setCellValue("E{$row}", $pro_effect);
        $sheet->setCellValue("F{$row}", 'ร้อยละ');

        // ใช้ตัวแปรจัดตำแหน่งในการปรับเซลล์
        $sheet->getStyle('A' . $row)->applyFromArray($centerAlignment);
        $sheet->getStyle('E' . $row)->applyFromArray($centerAlignment);
        $sheet->getStyle('F' . $row)->applyFromArray($centerAlignment);
        $sheet->getStyle("A{$row}:F{$row}")->applyFromArray($styleArray);


        // ปรับความสูงของแถวทั้งหมด
        foreach (range(1, $sheet->getHighestRow()) as $row) {
            $sheet->getRowDimension($row)->setRowHeight(25);
        }

        // เพิ่มส่วนนี้ก่อนการสร้างไฟล์ Excel (ก่อน $writer = new Xlsx($spreadsheet);)

        // กำหนดสไตล์ Border
        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];


        // กำหนดช่วงแถวที่ต้องการใส่ Border (แถวที่ 2 ถึงแถวสุดท้ายที่มีข้อมูล)
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        // วนลูปทุกแถวตั้งแต่แถวที่ 2 ถึงแถวสุดท้าย
        for ($row = 2; $row <= $highestRow; $row++) {
            // วนลูปทุกคอลัมน์ (A ถึง F)
            for ($col = 'A'; $col <= 'F'; $col++) {
                $cellCoordinate = $col . $row;
                // ตรวจสอบว่ามีข้อมูลในเซลล์หรือไม่
                if ($sheet->getCell($cellCoordinate)->getValue() !== null) {
                    // ใส่ Border เฉพาะเซลล์ที่มีข้อมูล
                    $sheet->getStyle($cellCoordinate)->applyFromArray($borderStyle);
                }
            }
        }

        // สำหรับเซลล์ที่รวมกัน (merged cells) ต้องจัดการเป็นกรณีพิเศษ
        $mergedCells = $sheet->getMergeCells();
        foreach ($mergedCells as $mergedRange) {
            // ตรวจสอบว่า merged range อยู่ในแถวที่ 2 ขึ้นไปหรือไม่
            $rangeStartRow = (int) filter_var($mergedRange, FILTER_SANITIZE_NUMBER_INT);
            if ($rangeStartRow >= 2) {
                // ตรวจสอบว่า merged range มีข้อมูลหรือไม่
                $mergedCellValue = $sheet->getCell(explode(':', $mergedRange)[0])->getValue();
                if ($mergedCellValue !== null) {
                    // ใส่ Border ให้กับ merged range
                    $sheet->getStyle($mergedRange)->applyFromArray($borderStyle);
                }
            }
        }


        // กำหนดสไตล์ลบ Border (ใช้สำหรับแถวแรก)
        $noBorderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_NONE,
                ],
            ],
        ];

        // ลบ Border ทั้งหมดในแถวแรก (A1-F1)
        $sheet->getStyle('A1:F1')->applyFromArray($noBorderStyle);

        // สร้างไฟล์ Excel
        $writer = new Xlsx($spreadsheet);

        // บันทึกไฟล์
        $fileName = 'Objectives_Report.xlsx';
        $filePath = public_path($fileName);
        $writer->save($filePath);

        // ส่งกลับเป็นการดาวน์โหลดไฟล์
        return response()->download($filePath);
    }
}
