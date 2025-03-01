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
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\SimpleType\Jc;

class WordClosedController extends Controller
{
    public function word_gen($id)
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

        // สร้างเอกสารใหม่
        $phpWord = new PhpWord();

        // ดึงค่าฟอนต์จาก config และตรวจสอบว่าไม่เป็น null
        $fontName = config('default_font.default_font.name', 'TH SarabunPSK');  // กำหนดค่า default เป็น THSarabunPSK ถ้าค่าใน config ไม่มี
        $fontSize = config('default_font.default_font.size', 16);               // กำหนดค่า default เป็น 16 ถ้าค่าใน config ไม่มี
        $boldTextStyle = config('config_word.styles.bold_text');
        $center = config('config_word.paragraph_styles.center');
        $indentation = config('config_word.paragraph_styles.indentation');
        $indentationMin = config('config_word.paragraph_styles.indentationMin');
        $indentationMax = config('config_word.paragraph_styles.indentationMax');
        $table_center = config('config_word.table_styles.align');
        $textAlignCenter = config('config_word.table_styles.align');
        $cellStyleCenter = config('config_word.table_styles.cell');

        Carbon::setLocale('th');

        // ตรวจสอบว่าฟอนต์เป็น string ที่ถูกต้อง
        if (!is_string($fontName)) {
            $fontName = 'THSarabunPSK'; // ฟอนต์เริ่มต้น
        }

        // ตั้งค่าฟอนต์เริ่มต้น
        $phpWord->setDefaultFontName($fontName);
        $phpWord->setDefaultFontSize($fontSize);

        // ดึงค่าการตั้งค่าหน้ากระดาษจาก config
        $pageSettings = config('default_font.page_settings', [
            'orientation' => 'portrait',        // แนวตั้ง
            'paperSize' => 'A4',                // ขนาดกระดาษ A4
            'margins' => [
                'top' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(2),
                'bottom' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(2),
                'left' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(2),
                'right' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(2),
            ]
        ]);


        // ตั้งค่าหน้ากระดาษ
        $sectionStyle = [
            'orientation' => $pageSettings['orientation'] === 'landscape'
                ? 'landscape'  // ใช้ 'landscape' แทน
                : 'portrait',   // ใช้ 'portrait' แทน
            'paperSize' => $pageSettings['paperSize'],
            'marginTop' => $pageSettings['margins']['top'],
            'marginBottom' => $pageSettings['margins']['bottom'],
            'marginLeft' => $pageSettings['margins']['left'],
            'marginRight' => $pageSettings['margins']['right'],
        ];

        // เพิ่มหน้าใหม่และตั้งค่าหน้ากระดาษ
        $section = $phpWord->addSection($sectionStyle);

        // กำหนดเส้นทางของรูปภาพ (ที่เก็บในโฟลเดอร์ public)
        $imagePath = public_path('images/logo_kmutnb.png');

        // เพิ่มรูปภาพลงในเอกสาร
        $section->addImage(
            $imagePath,
            array(
                'width' => 50,              // กำหนดความกว้างของรูป
                'height' => 50,             // กำหนดความสูงของรูป
                'alignment' => Jc::CENTER   // กำหนดตำแหน่งให้รูปอยู่ตรงกลาง
            )
        );

        if ($projects && $projects->yearID) {
            foreach ($years as $year) {
                if ($projects->yearID == $year->yearID) {
                    $text = "แบบประเมินโครงการที่ตอบสนองยุทธศาสตร์การพัฒนาสำนักคอมพิวเตอร์และเทคโนโลยีสารสนเทศ\nประจำปีงบประมาณ " . $year->year;
                    $section->addText(
                        $text,
                        $boldTextStyle,
                        ['alignment' => 'center']
                    );

                    $phpWord->getDocInfo()->setTitle('แบบประเมินโครงการที่ตอบสนองยุทธศาสตร์การพัฒนาสำนักคอมพิวเตอร์และเทคโนโลยีสารสนเทศประจำปีงบประมาณ');
                }
            }
        } else {
            return redirect()->back()->with('error', 'ไม่พบข้อมูลโครงการ');
        }

        foreach ($project_evaluations as $project_evaluation) {
            if ($projects->proID == $project_evaluation->proID) {
                $section->addText('คำชี้แจง', $boldTextStyle);
                $section->addText($project_evaluation->statement, [], ['alignment' => 'both', 'spaceAfter' => 240, 'indentation' => ['firstLine' => 480]]);

                $implementation = $project_evaluation->implementation;
                $problem = $project_evaluation->problem;
                $benefit = $project_evaluation->benefit;
                $corrective_actions = $project_evaluation->corrective_actions;
                // dd($implementation);
            }

            // foreach ($users as $user) {
            //     if ($project_evaluation->userID == $user->userID) {
            //         // เพิ่มสังกัดในอาร์เรย์ หากยังไม่มี
            //         if (!in_array($user->department_name, $departments)) {
            //             $departments[] = $user->department_name;
            //         }
            //         $responsibleNames[] = $user->username;
            //         $names[] = $user->username;
            //     }
            // }
        }

        $textrun = $section->addTextRun();
        $textrun->addText(
            '1. ชื่อโครงการ / กิจกรรม : ',
            $boldTextStyle
        );

        if (strlen($projects->name) > 30) { // คุณสามารถปรับตัวเลขนี้ตามความยาวที่คุณต้องการ
            $section->addText($projects->name, [], ['spaceBefore' => 240]); // ถ้าชื่อโครงการยาวเกิน 30 ตัวอักษร จะแสดงในบรรทัดใหม่
        } else {
            $textrun->addText(' ' . $projects->name); // ถ้าชื่อโครงการไม่ยาวเกิน จะแสดงในบรรทัดเดียวกัน
        }

        $all_strategic_plans = [];

        // รวมแผนทุกระดับที่ proID ตรงกัน
        foreach ($strategic_maps as $strategic_map) {
            if ($projects->proID == $strategic_map->proID) {
                $all_strategic_plans[] = [
                    'name' => collect($strategics)->firstWhere('straID', $strategic_map->straID)?->name,
                    'strategic_issue' => collect($strategic_issues)->firstWhere('SFAID', $strategic_map->SFAID)?->name,
                    'goal' => collect($goals)->firstWhere('goalID', $strategic_map->goalID)?->name,
                    'tactic' => collect($tactics)->firstWhere('tacID', $strategic_map->tacID)?->name
                ];
            }
        }

        foreach ($strategic2_level_maps as $strategic2_level_map) {
            if ($projects->proID == $strategic2_level_map->proID) {
                $all_strategic_plans[] = [
                    'name' => collect($strategic2_levels)->firstWhere('stra2LVID', $strategic2_level_map->stra2LVID)?->name,
                    'strategic_issue' => collect($strategic_issue2_levels)->firstWhere('SFA2LVID', $strategic2_level_map->SFA2LVID)?->name,
                    'tactic' => collect($tactic2_levels)->firstWhere('tac2LVID', $strategic2_level_map->tac2LVID)?->name
                ];
            }
        }

        foreach ($strategic1_level_maps as $strategic1_level_map) {
            if ($projects->proID == $strategic1_level_map->proID) {
                $all_strategic_plans[] = [
                    'name' => collect($strategic1_levels)->firstWhere('stra1LVID', $strategic1_level_map->stra1LVID)?->name,
                    'target' => collect($target1_levels)->firstWhere('tac1LVID', $strategic1_level_map->tac1LVID)?->name
                ];
            }
        }

        // เช็คจำนวนแผนทั้งหมด
        $totalPlans = count($all_strategic_plans);
        $index = 1;

        if ($totalPlans === 1) {
            // ถ้ามีแค่ 1 แผน ให้แสดงชื่อแผนในบรรทัดเดียวกับหัวข้อ
            $plan = $all_strategic_plans[0];
            $section->addText("2. โครงการ / กิจกรรมนี้ตอบสนอง {$plan['name']}", $boldTextStyle);
        } else {
            $section->addText('2. โครงการ / กิจกรรมนี้ตอบสนอง', $boldTextStyle);
        }

        // แสดงรายละเอียดของแต่ละแผน
        foreach ($all_strategic_plans as $plan) {
            if ($totalPlans > 1) {
                $section->addText("2.$index {$plan['name']}", $boldTextStyle, $indentationMin);
                $index++;
            }

            if (!empty($plan['strategic_issue'])) {
                $textRun = $section->addTextRun($indentationMax);
                $textRun->addText("ประเด็น");
                $textRun->addText($plan['strategic_issue']);
            }

            if (!empty($plan['goal'])) {
                $textRun = $section->addTextRun($indentationMax);
                $textRun->addText("เป้าประสงค์ที่ ");
                $textRun->addText($plan['goal']);
            }

            if (!empty($plan['tactic'])) {
                $textRun = $section->addTextRun($indentationMax);
                $textRun->addText("กลยุทธ์ที่ ");
                $textRun->addText($plan['tactic']);
            }

            if (!empty($plan['target'])) {
                $textRun = $section->addTextRun($indentationMax);
                $textRun->addText("เป้าหมายที่ ");
                $textRun->addText($plan['target']);
            }
        }

        // สร้างอาร์เรย์สำหรับเก็บข้อมูลสังกัดและชื่อผู้รับผิดชอบ
        $departments = [];
        $responsibleNames = [];
        $names = []; // เพิ่มอาร์เรย์เพื่อเก็บชื่อ

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
                    }
                }
            }
        }

        // ตรวจสอบว่ามีข้อมูลหรือไม่
        if (empty($departments) && empty($responsibleNames)) {
            $section->addText('ไม่มีข้อมูล');
        } else {
            // แสดงข้อมูลสังกัด
            foreach ($departments as $department) {
                $textrun = $section->addTextRun();
                $textrun->addText('3. ส่วนงานที่รับผิดชอบ : ', $boldTextStyle);
                $textrun->addText($department);
            }
        }

        $textrun = $section->addTextRun();
        $textrun->addText('4. วิธีการดำเนินโครงการ : ', $boldTextStyle);
        $textrun->addText($implementation);

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

        $textrun = $section->addTextRun();
        $textrun->addText('5. ระยะเวลาในการดำเนินงาน : ', $boldTextStyle);
        $textrun->addText('เริ่มต้น ' . $formattedStartDate . ' สิ้นสุด ' . $formattedEndDate);

        $section->addText('6. วัตถุประสงค์', $boldTextStyle);

        $objects = DB::table('objectives')->where('proID', $id)->get();

        if ($objects->isNotEmpty()) {
            $counter = 1;

            foreach ($objects as $object) {
                // เพิ่มข้อความวัตถุประสงค์
                $textrun = $section->addTextRun();
                $textrun->addText("6.$counter ");
                $textrun->addText($object->detail);

                // แสดงตัวเลือก บรรลุ / ไม่บรรลุ
                $textrun = $section->addTextRun();
                $textrun->addText("( ");
                $textrun->addText(($object->achieve == 1 ? '✓' : ' '), $boldTextStyle);
                $textrun->addText(" ) บรรลุ");

                // เพิ่มช่องว่างระหว่างตัวเลือก
                $textrun->addText(str_repeat(' ', 15)); // ปรับจำนวน space ให้เหมาะสม

                $textrun->addText("( ");
                $textrun->addText(($object->achieve == 1 ? ' ' : '✓'), $boldTextStyle);
                $textrun->addText(" ) ไม่บรรลุ");

                $counter++;
            }
        }

        $section->addText('7. ผลการดำเนินงาน', $boldTextStyle);

        foreach ($operating_results as $operating_result) {
            $checked = false;
            foreach ($project_evaluations as $project_evaluation) {
                if ($project_evaluation->operID == $operating_result->operID) {
                    $checked = true;
                    break; // หยุด loop ทันทีเมื่อเจอค่า match
                }
            }

            // เพิ่มตัวเลือก (✓) หรือช่องว่าง
            $textrun = $section->addTextRun();
            $textrun->addText("    ( ");
            $textrun->addText($checked ? '✓' : '  ', ['bold' => true]);
            $textrun->addText(" ) " . $operating_result->name);
        }

        $section->addText('8. ผลการดำเนินงานตามตัวชี้วัด (KPIs)', $boldTextStyle);

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
                        // เพิ่มตัวชี้วัดโครงการ
                        $textrun = $section->addTextRun();
                        $textrun->addText("    8.$counter ตัวชี้วัดโครงการ ");
                        $textrun->addText($KPI_pro->name);

                        // เพิ่มผลการประเมิน
                        $section->addText("        " . $KPI_pro->result_eva);

                        $counter++;
                        break;
                    }
                }
            }
        }


        $section->addText('9. งบประมาณที่ใช้ดำเนินการ', $boldTextStyle);

        // ตรวจสอบว่ามีข้อมูลโครงการหรือไม่
        if (!empty($projects) && isset($projects->badID)) {
            foreach ($badget_types as $badget_type) {
                $checked = (isset($badget_type->badID) && $projects->badID == $badget_type->badID) ? '✓' : '  ';

                $textRun = $section->addTextRun();
                $textRun->addText("    ({$checked})   " . htmlspecialchars($badget_type->name));

                // ตรวจสอบว่าชื่อเป็น "ไม่ได้ใช้งบประมาณ" หรือไม่
                if (isset($badget_type->badID) && $projects->badID == $badget_type->badID && $badget_type->name !== "ไม่ได้ใช้งบประมาณ") {
                    // ดึงงบที่ได้รับจัดสรรและที่ใช้จริง
                    $allocated = isset($projects->badgetTotal) ? number_format($projects->badgetTotal, 2) : "0.00";
                    $used = isset($project_evaluations[0]->badget_use) ? number_format($project_evaluations[0]->badget_use, 2) : "0.00";

                    // แสดงงบประมาณ ถ้าไม่ได้เป็น "ไม่ได้ใช้งบประมาณ"
                    $section->addText("        ที่ได้รับจัดสรร {$allocated} บาท    ใช้จริง {$used} บาท");
                }
            }
        } else {
            $section->addText('ไม่มีข้อมูลงบประมาณ');
        }

        // กำหนดสไตล์การจัดวางข้อความ
        $paragraphStyle = [
            'align' => 'both',       // จัดข้อความชิดซ้าย-ขวา
            'spaceAfter' => 120,     // ระยะห่างระหว่างย่อหน้า (หน่วย twip)
            'firstLineIndent' => 500  // ย่อหน้าแรกเข้าไป (0.5 ซม.)
        ];

        $section->addText('10. ประโยชน์ที่ได้รับจากการดำเนินโครงการ (หลังการจัดการโครงการ)', $boldTextStyle);

        // เพิ่มเนื้อหาพร้อมจัดให้มีการเยื้องบรรทัดแรก
        $textRun = $section->addTextRun($paragraphStyle);
        $textRun->addText(htmlspecialchars($benefit), ['indentation' => ['firstLine' => 480]]);

        $section->addText('11. ปัญหาและอุปสรรคในการดำเนินงานโครงการ', $boldTextStyle);

        $textRun = $section->addTextRun($paragraphStyle);
        $textRun->addText(htmlspecialchars($problem), ['indentation' => ['firstLine' => 480]]);

        $section->addText('12. แนวทางการดำเนินการแก้ไข / ข้อเสนอแนะ', $boldTextStyle);

        $textRun = $section->addTextRun($paragraphStyle);
        $textRun->addText(htmlspecialchars($corrective_actions), ['indentation' => ['firstLine' => 480]]);

        $section->addTextBreak(4);

        // สร้างตารางสำหรับลายเซ็น
        $table = $section->addTable();

        // สร้างแถวในตาราง
        $table->addRow();

        // คอลัมน์ซ้าย - ผู้รับผิดชอบโครงการ
        $cellLeft = $table->addCell(4000, ['align' => 'center']);
        $cellLeft->addText('ลงชื่อ .................................................', [], ['align' => 'center']);
        $cellLeft->addText('( ' . $names[0] . ' )', [], ['align' => 'center']);
        $cellLeft->addText('ผู้รับผิดชอบโครงการ', [], ['align' => 'center']);
        $cellLeft->addText('วันที่ ........../......................./..........', [], ['align' => 'center']);

        // คอลัมน์ขวา - ผู้อำนวยการ
        $cellRight = $table->addCell(4000, ['align' => 'center']);
        $cellRight->addText('ลงชื่อ .................................................', [], ['align' => 'center']);
        $cellRight->addText('( ................................................. )', [], ['align' => 'center']);
        $cellRight->addText('ผู้อำนวยการ', [], ['align' => 'center']);
        $cellRight->addText('วันที่ ........../......................./..........', [], ['align' => 'center']);









        // บันทึกเอกสารเป็นไฟล์ .docx
        $fileName = $projects->name . '.docx';
        $phpWord->save(storage_path('app/public/' . $fileName), 'Word2007');

        return response()->download(storage_path('app/public/' . $fileName));
    }
}
