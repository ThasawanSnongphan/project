<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

use Illuminate\Http\Request;

class ExcelAllResultsController extends Controller
{
    public function exportExcel()
    {
        // ✅ ดึงข้อมูลพร้อมเปลี่ยน ID เป็นชื่อโครงการ และกำหนดลำดับเริ่มต้นที่ 1
        $projects = Projects::all()->map(function ($project, $index) {
            return [
                'ลำดับ' => $index + 1,  // ลำดับเริ่มที่ 1
                'โครงการ / กิจกรรม' => $project->name,  // ใช้ชื่อโครงการแทน ID
                // 'หน่วยนับ' => $project->unit ?? '',
                // 'เป้าหมาย' => $project->target ?? '',
                // 'ผล' => $project->result ?? '',
                // 'การบรรลุ (✔ / ✖)' => $project->achieved ?? '',
                // 'งบประมาณที่จัดสรร' => $project->budget_allocated ?? '',
                // 'ผลการใช้จ่ายเงิน' => $project->budget_spent ?? '',
                // 'ผลการดำเนินงาน' => $project->progress ?? '',
                // 'ปัญหา/อุปสรรค' => $project->issues ?? '',
                // 'ผู้รับผิดชอบ' => $project->responsible_person ?? '',
            ];
        })->toArray();

        return Excel::download(new class($projects) implements FromArray, WithHeadings, WithStyles, WithColumnWidths {
            protected $data;

            public function __construct(array $data)
            {
                $this->data = $data;
            }

            public function array(): array
            {
                return $this->data;
            }

            // เพิ่มหัวตาราง
            public function headings(): array
            {
                return ["ลำดับ", "โครงการ / กิจกรรม", "หน่วยนับ", "เป้าหมาย", "ผล", "การบรรลุ (✔ / ✖)", "งบประมาณที่จัดสรร", "ผลการใช้จ่ายเงิน", "ผลการดำเนินงาน", "ปัญหา/อุปสรรค", "ผู้รับผิดชอบ"];
            }

            // ✅ กำหนดความกว้างของคอลัมน์
            public function columnWidths(): array
            {
                return [
                    'A' => 10,  // ลำดับ
                    'B' => 100,  // โครงการ / กิจกรรม
                    'C' => 15,  // หน่วยนับ
                    'D' => 5,  // เป้าหมาย
                    'E' => 10,  // ผล
                    'F' => 5,  // การบรรลุ (✔ / ✖)
                    'G' => 20,  // งบประมาณที่จัดสรร
                    'H' => 20,  // ผลการใช้จ่ายเงิน
                    'I' => 30,  // ผลการดำเนินงาน
                    'J' => 30,  // ปัญหา/อุปสรรค
                    'K' => 25,  // ผู้รับผิดชอบ
                ];
            }

            // จัดสไตล์ให้กับตาราง
            public function styles(Worksheet $sheet)
            {
                // ✅ กำหนดจำนวนแถวที่มีข้อมูล (รวมถึงหัวตาราง)
                $rowCount = count($this->data) + 1;
                $columnCount = 'K'; // ✅ คอลัมน์สุดท้าย (แก้ไขได้หากมีการเพิ่มคอลัมน์)



                // ✅ ใส่เส้นขอบสีดำให้ทุกเซลล์ที่มีข้อมูล
                $sheet->getStyle("A1:{$columnCount}{$rowCount}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);

                // ✅ หมุนคอลัมน์ "เป้าหมาย" เป็นแนวตั้ง (D1:D{$rowCount})
                $sheet->getStyle("D1:F{$rowCount}")->applyFromArray([
                    'alignment' => [
                        'textRotation' => 90, // 🔄 หมุนข้อความ 90 องศา
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER, // จัดกึ่งกลางแนวตั้ง
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER // จัดกึ่งกลางแนวนอน
                    ]
                ]);

                return [
                    1 => ['font' => ['bold' => true]], // ทำให้หัวตารางเป็นตัวหนา

                    // เติมสีพื้นหลังของหัวตารางเป็น #B7CCE2
                    'A1:K1' => [
                        'fill' => [
                            'fillType' => 'solid',
                            'startColor' => ['rgb' => 'B7CCE2']
                        ]
                    ],

                    // จัดกึ่งกลางให้ทุกคอลัมน์
                    'A:K' => [
                        'alignment' => ['horizontal' => 'center']
                    ],
                ];
            }
        }, 'projects.xlsx');
    }
}
