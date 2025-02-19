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
use App\Models\UniPlan;
use App\Models\Users;
use App\Models\UsersMapProject;
use App\Models\Year;
use Carbon\Carbon;
use DateTime;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Shared\Converter;
use PhpOffice\PhpWord\SimpleType\Jc;

class WordController extends Controller
{
    public function createWordDoc()
    {
        // สร้างเอกสารใหม่
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        // เพิ่มข้อความ
        $section->addText('Hello, this is a Word document created with PHPWord in Laravel.');

        // สร้างไฟล์ Word
        $filename = 'example.docx';
        $tempFile = tempnam(sys_get_temp_dir(), $filename);
        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($tempFile);

        // ส่งไฟล์ให้ผู้ใช้ดาวน์โหลด
        return response()->download($tempFile, $filename)->deleteFileAfterSend(true);
    }

    public function createWordDocFromDB($id)
    {

        // ดึงข้อมูลจาก db
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

        // เว้นบรรทัด
        $section->addTextBreak();

        foreach ($years as $year) {
            if ($projects->yearID == $year->yearID) {
                $section->addText(
                    'แบบเสนอโครงการ ประจำปีงบประมาณ พ.ศ. ' . $year->name,
                    $boldTextStyle,
                    $center
                );

                $section->addText(
                    'มหาวิทยาลัยเทคโนโลยีพระจอมเกล้าพระนครเหนือ',
                    $boldTextStyle,
                    $center
                );
            }
        }

        // เว้นบรรทัด
        $section->addTextBreak();
        $textRun = $section->addTextRun();

        $textRun->addText(
            '1. ชื่อโครงการ : ',
            $boldTextStyle
        );

        $textRun->addText(
            $projects->name,
        );

        $textRun = $section->addTextRun();

        $textRun->addText(
            '2. สังกัด : ',
            $boldTextStyle
        );

        $departments = [];
        $responsibleNames = [];
        $names = [];

        foreach ($users_map as $user_map) {
            if ($projects->proID == $user_map->proID) {
                foreach ($users as $user) {
                    if ($user->userID == $user_map->userID) {
                        if (!in_array($user->department_name, $departments)) {
                            $departments[] = $user->department_name;
                        }
                        $responsibleNames[] = $user->username;
                        $names[] = $user->username;
                    }
                }
            }
        }

        if (empty($departments) && empty($responsibleNames)) {
            $section->addText('ไม่มีข้อมูล');
        } else {
            foreach ($departments as $department) {
                $section->addText($department, $boldTextStyle, $indentationMin);
            }
            if (!empty($responsibleNames)) {
                $textRun = $section->addTextRun($indentationMin);
                $textRun->addText('ผู้รับผิดชอบ : ', $boldTextStyle);
                $textRun->addText(implode(', ', $responsibleNames));
            }
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
            $section->addText("3. ความเชื่อมโยงสอดคล้องกับ {$plan['name']}", $boldTextStyle);
        } else {
            $section->addText('3. ความเชื่อมโยงสอดคล้องกับ', $boldTextStyle);
        }

        // แสดงรายละเอียดของแต่ละแผน
        foreach ($all_strategic_plans as $plan) {
            if ($totalPlans > 1) {
                $section->addText("3.$index {$plan['name']}", $boldTextStyle, $indentationMin);
                $index++;
            }

            if (!empty($plan['strategic_issue'])) {
                $textRun = $section->addTextRun($indentationMax);
                $textRun->addText("ประเด็นยุทธศาสตร์ที่ ", $boldTextStyle);
                $textRun->addText($plan['strategic_issue']);
            }

            if (!empty($plan['goal'])) {
                $textRun = $section->addTextRun($indentationMax);
                $textRun->addText("เป้าประสงค์ที่ ", $boldTextStyle);
                $textRun->addText($plan['goal']);
            }

            if (!empty($plan['tactic'])) {
                $textRun = $section->addTextRun($indentationMax);
                $textRun->addText("กลยุทธ์ที่ ", $boldTextStyle);
                $textRun->addText($plan['tactic']);
            }

            if (!empty($plan['target'])) {
                $textRun = $section->addTextRun($indentationMax);
                $textRun->addText("เป้าหมายที่ ", $boldTextStyle);
                $textRun->addText($plan['target']);
            }
        }



        // $section->addText('3. ความเชื่อมโยงสอดคล้องกับ', $boldTextStyle);
        // $all_strategic_plans = [];

        // // เช็คแผนระดับแรก
        // foreach ($strategic_maps as $strategic_map) {
        //     if ($projects->proID == $strategic_map->proID) {
        //         $all_strategic_plans[] = [
        //             'name' => collect($strategics)->firstWhere('straID', $strategic_map->straID)?->name,
        //             'strategic_issue' => collect($strategic_issues)->firstWhere('SFAID', $strategic_map->SFAID)?->name,
        //             'goal' => collect($goals)->firstWhere('goalID', $strategic_map->goalID)?->name,
        //             'tactic' => collect($tactics)->firstWhere('tacID', $strategic_map->tacID)?->name
        //         ];
        //     }
        // }

        // // เช็คแผนระดับที่สอง
        // foreach ($strategic2_level_maps as $strategic2_level_map) {
        //     if ($projects->proID == $strategic2_level_map->proID) {
        //         $all_strategic_plans[] = [
        //             'name' => collect($strategic2_levels)->firstWhere('stra2LVID', $strategic2_level_map->stra2LVID)?->name,
        //             'strategic_issue' => collect($strategic_issue2_levels)->firstWhere('SFA2LVID', $strategic2_level_map->SFA2LVID)?->name,
        //             'tactic' => collect($tactic2_levels)->firstWhere('tac2LVID', $strategic2_level_map->tac2LVID)?->name
        //         ];
        //     }
        // }

        // // เช็คแผนระดับที่สาม
        // foreach ($strategic1_level_maps as $strategic1_level_map) {
        //     if ($projects->proID == $strategic1_level_map->proID) {
        //         $all_strategic_plans[] = [
        //             'name' => collect($strategic1_levels)->firstWhere('stra1LVID', $strategic1_level_map->stra1LVID)?->name,
        //             'target' => collect($target1_levels)->firstWhere('tac1LVID', $strategic1_level_map->tac1LVID)?->name
        //         ];
        //     }
        // }

        // // เช็คจำนวนแผนทั้งหมด
        // $totalPlans = count($all_strategic_plans);
        // $index = 1;

        // // แสดงผล
        // foreach ($all_strategic_plans as $plan) {
        //     if ($totalPlans > 1) {
        //         $section->addText("3.$index {$plan['name']}", $boldTextStyle, $indentationMin);
        //         $index++;
        //     } else {
        //         $section->addText("3. {$plan['name']}", $boldTextStyle, $indentationMin);
        //     }

        //     if (!empty($plan['strategic_issue'])) {
        //         $textRun = $section->addTextRun($indentationMax);
        //         $textRun->addText("ประเด็นยุทธศาสตร์ที่ ", $boldTextStyle);
        //         $textRun->addText($plan['strategic_issue']);
        //     }

        //     if (!empty($plan['goal'])) {
        //         $textRun = $section->addTextRun($indentationMax);
        //         $textRun->addText("เป้าประสงค์ที่ ", $boldTextStyle);
        //         $textRun->addText($plan['goal']);
        //     }

        //     if (!empty($plan['tactic'])) {
        //         $textRun = $section->addTextRun($indentationMax);
        //         $textRun->addText("กลยุทธ์ที่ ", $boldTextStyle);
        //         $textRun->addText($plan['tactic']);
        //     }

        //     if (!empty($plan['target'])) {
        //         $textRun = $section->addTextRun($indentationMax);
        //         $textRun->addText("เป้าหมายที่ ", $boldTextStyle);
        //         $textRun->addText($plan['target']);
        //     }
        // }



        $section->addText('4. ลักษณะโครงการ / กิจกรรม', $boldTextStyle);

        $textRun = $section->addTextRun($indentationMin);

        foreach ($project_charecs as $project_charec) {
            $checked = ($projects->proChaID == $project_charec->proChaID) ? '☑' : '☐';

            $textRun->addText($checked . ' ' . $project_charec->name . '     ', null);
        }


        $section->addText('5. การบูรณาการโครงการ', $boldTextStyle);

        $textRun = $section->addTextRun($indentationMin);
        foreach ($project_integrats as $project_integrat) {
            $checked = ($projects->proInID == $project_integrat->proInID) ? '☑' : '☐';

            $textRun->addText($checked . ' ' . $project_integrat->name . '     ', null);
            $textRun->addTextBreak();
        }

        $section->addText('6. หลักการและเหตุผลของโครงการ', $boldTextStyle);

        // กำหนดสไตล์การจัดวางข้อความ
        $paragraphStyle = [
            'align' => 'both',       // จัดข้อความชิดซ้าย-ขวา
            'spaceAfter' => 120,     // ระยะห่างระหว่างย่อหน้า (หน่วย twip)
            'firstLineIndent' => 5000 // ย่อหน้าแรกเข้าไป
        ];

        // เพิ่มข้อความพร้อมกำหนดสไตล์
        $textRun = $section->addTextRun($paragraphStyle);
        $textRun->addText($projects->princiDetail, null);


        $section->addText('7. วัตถุประสงค์', $boldTextStyle);

        if (DB::table('objectives')->where('proID', $id)->exists()) {
            $objects = DB::table('objectives')->where('proID', $id)->get();

            $counter = 1; // ตัวแปรเก็บลำดับ
            foreach ($objects as $object) {
                $section->addText("7.$counter $object->detail", null, $indentationMin);
                $counter++;
            }
        }

        $section->addText('8. ตัวชี้วัดความสำเร็จระดับโครงการ (Output/Outcome) และ ค่าเป้าหมาย (ระบุหน่วยนับ)', $boldTextStyle);

        if (DB::table('k_p_i_projects')->where('proID', $id)->exists()) {
            $KPI_pros = DB::table('k_p_i_projects')->where('proID', $id)->get();
            $countKPI_pros = DB::table('count_k_p_i_projects')->get();

            // สร้างตาราง
            $table = $section->addTable([
                'borderSize' => 1,
                'borderColor' => '000000',
                'width' => 100 * 50, // 100% width
                'unit' => \PhpOffice\PhpWord\SimpleType\TblWidth::PERCENT,
                'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER,
                'cellMargin' => 80,
            ]);

            // หัวตาราง
            $table->addRow();
            $table->addCell(6000, ['valign' => 'center'])->addText('ตัวชี้วัดความสำเร็จ', $boldTextStyle, $center);
            $table->addCell(2000, ['valign' => 'center'])->addText('หน่วยนับ', $boldTextStyle, $center);
            $table->addCell(2000, ['valign' => 'center'])->addText('ค่าเป้าหมาย', $boldTextStyle, $center);

            // ข้อมูลในตาราง
            foreach ($KPI_pros as $KPI_pro) {
                $unitName = '-';
                foreach ($countKPI_pros as $countKPI_pro) {
                    if ($KPI_pro->countKPIProID == $countKPI_pro->countKPIProID) {
                        $unitName = $countKPI_pro->name;
                        break;
                    }
                }

                $table->addRow();
                $table->addCell(6000, ['valign' => 'center'])->addText($KPI_pro->name);
                $table->addCell(2000, ['valign' => 'center'])->addText($unitName);
                $table->addCell(2000, ['valign' => 'center'])->addText($KPI_pro->target);
            }
        }

        $pro_tars = Projects::with('target')->get();

        foreach ($pro_tars as $pro_tar) {
            $targetName = $pro_tar->target->name ?? 'N/A';
        }

        // กำหนดรูปแบบสำหรับการเว้นระยะ
        $spaceBeforeStyle = ['spaceBefore' => 200];
        $section->addText('9. กลุ่มเป้าหมาย (ระบุกลุ่มเป้าหมายและจำนวนกลุ่มเป้าหมายที่เข้าร่วมโครงการ)', $boldTextStyle, $spaceBeforeStyle);
        $section->addText('    ' . $targetName);


        $section->addText('10. ขั้นตอนการดำเนินงาน :', $boldTextStyle, ['spaceBefore' => 240]);

        if (DB::table('steps')->where('proID', $id)->exists()) {
            $pro_steps = DB::table('steps')->where('proID', $id)->get();

            $minYear = PHP_INT_MAX;
            $maxYear = PHP_INT_MIN;

            foreach ($pro_steps as $step) {
                $startDate = $step->start ?? null;
                $endDate = $step->end ?? null;
                $startYear = $startDate ? (new DateTime($startDate))->format('Y') + 543 : null;
                $endYear = $endDate ? (new DateTime($endDate))->format('Y') + 543 : null;

                if ($startYear) {
                    $minYear = min($minYear, $startYear);
                }
                if ($endYear) {
                    $maxYear = max($maxYear, $endYear);
                }
            }

            if ($minYear === PHP_INT_MAX) $minYear = 'N/A';
            if ($maxYear === PHP_INT_MIN) $maxYear = 'N/A';

            // ถ้า $minYear และ $maxYear เป็นปีเดียวกัน ให้เพิ่ม maxYear อีก 1 ปี
            if (is_numeric($minYear) && is_numeric($maxYear) && $minYear === $maxYear) {
                $maxYear += 1;
            }

            $tableStyle = [
                'borderSize' => 6,
                'borderColor' => '000000',
                'cellMargin' => 60
            ];
            $phpWord->addTableStyle('myTable', $tableStyle);
            $table = $section->addTable('myTable');

            $table->addRow();
            $table->addCell(4900, ['vMerge' => 'restart', 'valign' => 'center', 'gridSpan' => 1])
                ->addText('ขั้นตอนการดำเนินการ', $boldTextStyle, $center);
            $table->addCell(1600, ['gridSpan' => 3])
                ->addText('พ.ศ. ' . $minYear, $boldTextStyle, $center);
            $table->addCell(3500, ['gridSpan' => 9])
                ->addText('พ.ศ. ' . $maxYear, $boldTextStyle, $center);

            $table->addRow();
            $table->addCell(null, ['vMerge' => 'continue']);
            $months = ['ต.ค.', 'พ.ย.', 'ธ.ค.', 'ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.'];
            foreach ($months as $month) {
                $table->addCell(1000)->addText($month);
            }

            foreach ($pro_steps as $index => $step) {
                $stepName = $step->name ?? 'ไม่มีข้อมูล';
                $highlightMonths = [];
                $startDate = $step->start ?? null;
                $endDate = $step->end ?? null;

                if ($startDate && $endDate) {
                    $start = new DateTime($startDate);
                    $end = new DateTime($endDate);
                    while ($start <= $end) {
                        $highlightMonths[] = (int)$start->format('n');
                        $start->modify('+1 month');
                    }
                }

                $table->addRow();
                $table->addCell(4000)->addText(($index + 1) . '. ' . $stepName);

                for ($month = 10; $month <= 12; $month++) {
                    $cellStyle = in_array($month, $highlightMonths) ? ['bgColor' => 'FFFF00'] : [];
                    $table->addCell(500, $cellStyle);
                }
                for ($month = 1; $month <= 9; $month++) {
                    $cellStyle = in_array($month, $highlightMonths) ? ['bgColor' => 'FFFF00'] : [];
                    $table->addCell(500, $cellStyle);
                }
            }
        }


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

        // กำหนดรูปแบบสำหรับการเว้นระยะ
        $spaceBeforeStyle = ['spaceBefore' => 200];
        $textRun = $section->addTextRun($spaceBeforeStyle);

        $textRun->addText(
            '11. ระยะเวลาดำเนินงาน : ',
            $boldTextStyle
        );

        $textRun->addText(
            'เริ่มต้น ' . $formattedStartDate . ' สิ้นสุด ' . $formattedEndDate,
        );

        $section->addText('12. แหล่งเงิน / ประเภทงบประมาณที่ใช้ / แผนงาน', $boldTextStyle);

        $hasBudget = false;
        foreach ($badget_types as $badget_type) {
            if ($projects->badID == $badget_type->badID) {
                $hasBudget = true;
                $section->addText('☑ ' . $badget_type->name, [], ['indentation' => ['left' => 480]]);
            }
        }

        if (!$hasBudget) {
            $section->addText('ไม่มีข้อมูล', [], ['indentation' => ['left' => 480]]);
        }

        // ตรวจสอบข้อมูล
        if (!$hasBudget) {
            $section->addText('ไม่มีข้อมูล', $boldTextStyle);
        }

        $section->addText('13. ประมาณค่าใช้จ่าย : ( หน่วย : บาท )', $boldTextStyle);

        // สร้างตาราง
        $table = $section->addTable([
            'borderSize' => 6,
            'borderColor' => '000000',
            'width' => 100 * 80,
            'cellMargin' => 100


        ]);

        // หัวตาราง
        $table->addRow();
        $table->addCell(4000, ['vMerge' => 'restart', 'valign' => 'center'])->addText('ประเภทการจ่าย', [], $center);
        $table->addCell(2500)->addText('รวม', [], $center);
        $table->addCell(2500)->addText('ไตรมาส 1', [], $center);
        $table->addCell(2500)->addText('ไตรมาส 2', [], $center);
        $table->addCell(2500)->addText('ไตรมาส 3', [], $center);
        $table->addCell(2500)->addText('ไตรมาส 4', [], $center);

        $table->addRow();
        $table->addCell(null, ['vMerge' => 'continue']);
        $table->addCell(2500)->addText('แผนการใช้จ่าย', [], $center);
        $table->addCell(2500)->addText('แผนการใช้จ่าย', [], $center);
        $table->addCell(2500)->addText('แผนการใช้จ่าย', [], $center);
        $table->addCell(2500)->addText('แผนการใช้จ่าย', [], $center);
        $table->addCell(2500)->addText('แผนการใช้จ่าย', [], $center);

        $totalCost = 0;
        $sumTotal = 0;
        $sumQu1 = 0;
        $sumQu2 = 0;
        $sumQu3 = 0;
        $sumQu4 = 0;
        $counter = 1;

        foreach ($cost_quarters as $cost_quarter) {
            if ($projects->proID == $cost_quarter->proID) {
                $totalCost = $cost_quarter->costQu1 + $cost_quarter->costQu2 + $cost_quarter->costQu3 + $cost_quarter->costQu4;
                $sumTotal += $totalCost;
                $sumQu1 += $cost_quarter->costQu1;
                $sumQu2 += $cost_quarter->costQu2;
                $sumQu3 += $cost_quarter->costQu3;
                $sumQu4 += $cost_quarter->costQu4;

                foreach ($expense_badgets as $expense_badget) {
                    if ($cost_quarter->expID == $expense_badget->expID) {
                        $table->addRow();
                        $table->addCell(4000)->addText($counter . '. ' . $expense_badget->name);
                        for ($i = 0; $i < 5; $i++) $table->addCell(1200)->addText('');
                    }
                }

                $subCounter = 1;
                foreach ($cost_types as $cost_type) {
                    if ($cost_quarter->costID == $cost_type->costID) {
                        $table->addRow();
                        $table->addCell(4000)->addText($counter . '.' . $subCounter . ' ' . $cost_type->name, [], $center);
                        $table->addCell(2500)->addText($totalCost > 0 ? number_format($totalCost, 2) : '-', [], $center);
                        $table->addCell(2500)->addText($cost_quarter->costQu1 > 0 ? number_format($cost_quarter->costQu1, 2) : '-', [], $center);
                        $table->addCell(2500)->addText($cost_quarter->costQu2 > 0 ? number_format($cost_quarter->costQu2, 2) : '-', [], $center);
                        $table->addCell(2500)->addText($cost_quarter->costQu3 > 0 ? number_format($cost_quarter->costQu3, 2) : '-', [], $center);
                        $table->addCell(2500)->addText($cost_quarter->costQu4 > 0 ? number_format($cost_quarter->costQu4, 2) : '-', [], $center);
                        $subCounter++;
                        $counter++;
                    }
                }
            }
        }

        // แสดงผลรวมท้ายตาราง
        $table->addRow();
        $table->addCell(4000)->addText('รวมเงินงบประมาณ', [], $center);
        $table->addCell(2500)->addText($sumTotal > 0 ? number_format($sumTotal, 2) : '-', [], $center);
        $table->addCell(2500)->addText($sumQu1 > 0 ? number_format($sumQu1, 2) : '-', [], $center);
        $table->addCell(2500)->addText($sumQu2 > 0 ? number_format($sumQu2, 2) : '-', [], $center);
        $table->addCell(2500)->addText($sumQu3 > 0 ? number_format($sumQu3, 2) : '-', [], $center);
        $table->addCell(2500)->addText($sumQu4 > 0 ? number_format($sumQu4, 2) : '-', [], $center);


        function numberToThai($number)
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
                9 => 'เก้า',
                10 => 'สิบ',
                20 => 'ยี่สิบ',
                30 => 'สามสิบ',
                40 => 'สี่สิบ',
                50 => 'ห้าสิบ',
                60 => 'หกสิบ',
                70 => 'เจ็ดสิบ',
                80 => 'แปดสิบ',
                90 => 'เก้าสิบ',
                100 => 'ร้อย',
                1000 => 'พัน',
                10000 => 'หมื่น',
                100000 => 'แสน',
                1000000 => 'ล้าน'
            ];

            if ($number == 0) {
                return $thaiNumbers[0];
            }

            $str = '';
            $number = (int)$number;
            $units = [1000000, 100000, 10000, 1000, 100, 10, 1]; // หน่วย (ล้าน, แสน, หมื่น, พัน, ร้อย, สิบ, หน่วย)

            foreach ($units as $unit) {
                $num = (int)($number / $unit);
                $number %= $unit;

                if ($num > 0) {
                    if ($unit >= 100 && $num == 1) {
                        $str .= ($unit == 100) ? 'ร้อย' : ($unit == 1000 ? 'พัน' : '');
                    } elseif ($unit >= 10 && $num == 2) {
                        $str .= 'ยี่' . $thaiNumbers[$unit];
                    } else {
                        $str .= $thaiNumbers[$num] . $thaiNumbers[$unit];
                    }
                }
            }

            return $str . 'บาทถ้วน';
        }

        $spaceBeforeStyle = ['spaceBefore' => 200];
        $sumTotalInWords = numberToThai($sumTotal);

        $textRun = $section->addTextRun(['spaceAfter' => 240, 'spaceBefore' => 200]); // ใช้ $spaceBeforeStyle ที่นี่

        $textRun->addText('14. ประมาณการงบประมาณที่ใช้ : ', $boldTextStyle);
        $textRun->addText(number_format($sumTotal, 2) . ' บาท (' . $sumTotalInWords . ')');



        $section->addText('15. ประโยชน์ที่คาดว่าจะได้รับ', $boldTextStyle);

        $bnfs = DB::table('benefits')->where('proID', $id)->get(); // ดึงข้อมูลที่ตรงกับ proID

        if ($bnfs->isNotEmpty()) { // ถ้ามีข้อมูล
            $counter = 1;
            foreach ($bnfs as $bnf) {
                $section->addText(
                    '     15.' . $counter . ' ' . $bnf->detail,
                    [],
                    ['spaceAfter' => 120] // ตั้งค่าระยะห่างระหว่างบรรทัด
                );
                $counter++;
            }
        } else {
            $section->addText('     ไม่มีข้อมูล', [], ['spaceAfter' => 120]);
        }

        $section->addTextBreak(5);

        // กำหนดค่าเริ่มต้นให้กับชื่อ
        $signatureName = $names[0] ?? 'ไม่มีข้อมูล';

        $section->addTextBreak(2);

        $textRun = $section->addTextRun(['alignment' => 'center', 'indentation' => ['left' => 5000]]);
        $textRun->addText("ลงชื่อ ", [], ['alignment' => 'center', 'indentation' => ['left' => 5000]]);
        $textRun->addText(".................................................", [], ['alignment' => 'center', 'indentation' => ['left' => 5000]]);
        $section->addText('(' . htmlspecialchars($signatureName) . ')', [], ['alignment' => 'center', 'indentation' => ['left' => 5000]]);
        $section->addText("ผู้รับผิดชอบโครงการ", [], ['alignment' => 'center', 'indentation' => ['left' => 5000]]);
        $section->addText("วันที่ ........../......................./..........", [], ['alignment' => 'center', 'indentation' => ['left' => 5000]]);








        // บันทึกเอกสารเป็นไฟล์ .docx
        $fileName = $projects->name . '.docx';
        $phpWord->save(storage_path('app/public/' . $fileName), 'Word2007');

        return response()->download(storage_path('app/public/' . $fileName));
    }
}
