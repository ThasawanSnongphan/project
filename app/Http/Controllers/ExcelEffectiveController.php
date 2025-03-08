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

        // สร้าง Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

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
        $sheet->setCellValue('A1', 'ลำดับ');
        $sheet->setCellValue('B1', 'วัตถุประสงค์');
        $sheet->setCellValue('C1', 'สถานะ');
        $sheet->setCellValue('D1', 'ข้อ');

        // กำหนดสไตล์ให้หัวตาราง
        $styleArray = [
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => '4CAF50'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,  // จัดกลางแนวนอน
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,    // จัดกลางแนวตั้ง
            ],
        ];

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
        $sheet->getStyle('A1:D1')->applyFromArray($styleArray);

        // กำหนดความกว้างอัตโนมัติสำหรับคอลัมน์ B (รายละเอียด)
        $sheet->getColumnDimension('B')->setAutoSize(true);

        // กำหนดความกว้างของคอลัมน์ (ปรับขนาดให้เหมาะสม)
        $sheet->getColumnDimension('A')->setWidth(10);  // ความกว้างของคอลัมน์ A
        $sheet->getColumnDimension('C')->setWidth(10);  // ความกว้างของคอลัมน์ C
        $sheet->getColumnDimension('D')->setWidth(10);  // ความกว้างของคอลัมน์ D

        // เริ่มแสดงข้อมูลจากแถวที่ 2 เป็นต้นไป
        $row = 2;
        foreach ($dataObjectives['วัตถุประสงค์'] as $index => $obj) {
            // ใส่ข้อมูลในแต่ละเซลล์
            $achieveStatus = $dataObjectives['สถานะ'][$index] == 'บรรลุ' ? '✓' : '✗';

            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $obj);
            $sheet->setCellValue('C' . $row, $achieveStatus);
            $sheet->setCellValue('D' . $row, 'ข้อ');

            // ใช้ตัวแปรจัดตำแหน่งในการปรับเซลล์
            $sheet->getStyle('A' . $row)->applyFromArray($centerAlignment);
            $sheet->getStyle('B' . $row)->applyFromArray($leftAlignment);  // ใช้การจัดชิดซ้ายสำหรับรายละเอียด
            $sheet->getStyle('C' . $row)->applyFromArray($centerAlignment);
            $sheet->getStyle('D' . $row)->applyFromArray($centerAlignment);

            // ขยับไปแถวถัดไป
            $row++;
        }

        // แสดงผลรวมข้อมูล
        $sheet->setCellValue('A' . $row, 'รวมวัตถุประสงค์ทั้งหมด');
        $sheet->mergeCells('A' . $row . ':B' . $row); // รวมเซลล์ A และ B
        $sheet->getStyle('A' . $row)->applyFromArray($centerAlignment);
        $sheet->setCellValue('C' . $row, count($dataObjectives['วัตถุประสงค์']));
        $sheet->setCellValue('D' . $row, 'ข้อ');
        $sheet->getStyle('A' . $row . ':D' . $row)->applyFromArray($centerAlignment); // ปรับให้แถวผลรวมอยู่ตรงกลาง
        $row++;

        $sheet->setCellValue('A' . $row, 'รวมที่บรรลุวัตถุประสงค์');
        $sheet->mergeCells('A' . $row . ':B' . $row); // รวมเซลล์ A และ B
        $sheet->getStyle('A' . $row)->applyFromArray($centerAlignment);
        $sheet->setCellValue('C' . $row, array_count_values($dataObjectives['สถานะ'])['บรรลุ']);
        $sheet->setCellValue('D' . $row, 'ข้อ');
        $sheet->getStyle('A' . $row . ':D' . $row)->applyFromArray($centerAlignment); // ปรับให้แถวผลรวมอยู่ตรงกลาง
        $row++;

        $sheet->setCellValue('A' . $row, 'รวมที่ไม่บรรลุวัตถุประสงค์');
        $sheet->mergeCells('A' . $row . ':B' . $row); // รวมเซลล์ A และ B
        $sheet->getStyle('A' . $row)->applyFromArray($centerAlignment);
        $sheet->setCellValue('C' . $row, array_count_values($dataObjectives['สถานะ'])['ไม่บรรลุ']);
        $sheet->setCellValue('D' . $row, 'ข้อ');
        $sheet->getStyle('A' . $row . ':D' . $row)->applyFromArray($centerAlignment); // ปรับให้แถวผลรวมอยู่ตรงกลาง
        $row++;

        // สร้างไฟล์ Excel
        $writer = new Xlsx($spreadsheet);

        // บันทึกไฟล์
        $fileName = 'Objectives_Report.xlsx';
        $filePath = public_path($fileName);
        $writer->save($filePath);

        // ส่งกลับเป็นการดาวน์โหลดไฟล์
        return response()->download($filePath);


        // // สร้างไฟล์ให้ดาวน์โหลด
        // $writer = new Xlsx($spreadsheet);
        // $response = new StreamedResponse(function () use ($writer) {
        //     $writer->save('php://output');
        // });

        // // กำหนด header สำหรับดาวน์โหลดไฟล์
        // $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        // $response->headers->set('Content-Disposition', 'attachment; filename="การประเมินประสิทธิผล.xlsx"');
        // $response->headers->set('Cache-Control', 'max-age=0');

        // return $response;
    }
}
