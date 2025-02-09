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
                $section->addText('ผู้รับผิดชอบ : ' . implode(', ', $responsibleNames), [], $indentationMin);
            }
        }

        $section->addText('3. ความเชื่อมโยงสอดคล้องกับ', $boldTextStyle);
        $index = 1;

        foreach ($strategic_maps as $strategic_map) {
            if ($projects->proID == $strategic_map->proID) {
                foreach ($strategics as $strategic) {
                    if ($strategic->straID == $strategic_map->straID) {
                        $section->addText("3.$index $strategic->name", $boldTextStyle, $indentationMin);
                        $index++;
                        break;
                    }
                }
                foreach ($strategic_issues as $strategic_issue) {
                    if ($strategic_issue->SFAID == $strategic_map->SFAID) {
                        $textRun = $section->addTextRun($indentationMax);
                        $textRun->addText("ประเด็นยุทธศาสตร์ที่ ", $boldTextStyle);
                        $textRun->addText($strategic_issue->name);
                        break;
                    }
                }
                foreach ($goals as $goal) {
                    if ($goal->goalID == $strategic_map->goalID) {
                        $textRun = $section->addTextRun($indentationMax);
                        $textRun->addText("เป้าประสงค์ที่ ", $boldTextStyle);
                        $textRun->addText($goal->name);
                        break;
                    }
                }
                foreach ($tactics as $tactic) {
                    if ($tactic->tacID == $strategic_map->tacID) {
                        $textRun = $section->addTextRun($indentationMax);
                        $textRun->addText("กลยุทธ์ที่ ", $boldTextStyle);
                        $textRun->addText($tactic->name);
                        break;
                    }
                }
            }
        }

        foreach ($strategic2_level_maps as $strategic2_level_map) {
            if ($projects->proID == $strategic2_level_map->proID) {
                foreach ($strategic2_levels as $strategic2_level) {
                    if ($strategic2_level->stra2LVID == $strategic2_level_map->stra2LVID) {
                        $section->addText("3.$index $strategic2_level->name", $boldTextStyle, $indentationMin);
                        $index++;
                        break;
                    }
                }
                foreach ($strategic_issue2_levels as $strategic_issue2_level) {
                    if ($strategic_issue2_level->SFA2LVID == $strategic2_level_map->SFA2LVID) {
                        $textRun = $section->addTextRun($indentationMax);
                        $textRun->addText("ประเด็นยุทธศาสตร์ที่ ", $boldTextStyle);
                        $textRun->addText($strategic_issue2_level->name);
                        break;
                    }
                }
                foreach ($tactic2_levels as $tactic2_level) {
                    if ($tactic2_level->tac2LVID == $strategic2_level_map->tac2LVID) {
                        $textRun = $section->addTextRun($indentationMax);
                        $textRun->addText("กลยุทธ์ที่ ", $boldTextStyle);
                        $textRun->addText($tactic2_level->name);
                        break;
                    }
                }
            }
        }

        foreach ($strategic1_level_maps as $strategic1_level_map) {
            if ($projects->proID == $strategic1_level_map->proID) {
                foreach ($strategic1_levels as $strategic1_level) {
                    if ($strategic1_level->stra1LVID == $strategic1_level_map->stra1LVID) {
                        $section->addText("3.$index $strategic1_level->name", $boldTextStyle, $indentationMin);
                        $index++;
                        break;
                    }
                }
                foreach ($target1_levels as $target1_level) {
                    if ($target1_level->tac1LVID == $strategic1_level_map->tac1LVID) {
                        $textRun = $section->addTextRun($indentationMax);
                        $textRun->addText("เป้าหมายที่ ", $boldTextStyle);
                        $textRun->addText($target1_level->name);
                        break;
                    }
                }
            }
        }


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

        $textRun = $section->addTextRun($indentationMin);
        $textRun->addText($projects->princiDetail, null, ['align' => 'both', 'firstLineIndent' => 800]);


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

        $pro_steps = DB::table('steps')->where('proID', $id)->get();

        if ($pro_steps->isNotEmpty()) {
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

            $section->addText('10. ขั้นตอนการดำเนินงาน :', ['bold' => true], ['spaceBefore' => 240]);

            $table = $section->addTable(['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50]);

            // Header row
            $table->addRow();
            $table->addCell(4000, ['vMerge' => 'restart'])->addText('ขั้นตอนการดำเนินการ', ['bold' => true]);
            $table->addCell(2000, ['gridSpan' => 3])->addText('พ.ศ. ' . $minYear, ['bold' => true]);
            $table->addCell(6000, ['gridSpan' => 12])->addText('พ.ศ. ' . $maxYear, ['bold' => true]);

            // Month row
            $table->addRow();
            $months = ['ต.ค.', 'พ.ย.', 'ธ.ค.', 'ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.'];
            $table->addCell(null, ['vMerge' => 'continue']);
            foreach ($months as $month) {
                $table->addCell(500)->addText($month);
            }

            // Data rows
            foreach ($pro_steps as $index => $step) {
                $stepName = $step->name ?? 'ไม่มีข้อมูล';
                $highlightMonths = [];
                $startDate = $step->start ?? null;
                $endDate = $step->end ?? null;

                if ($startDate && $endDate) {
                    $start = new DateTime($startDate);
                    $end = new DateTime($endDate);
                    while ($start <= $end) {
                        $highlightMonths[] = $start->format('n');
                        $start->modify('+1 month');
                    }
                }

                $table->addRow();
                $table->addCell(4000)->addText(($index + 1) . '. ' . $stepName);

                for ($i = 10; $i <= 12; $i++) {
                    $table->addCell(500, ['bgColor' => in_array($i, $highlightMonths) ? 'yellow' : null]);
                }
                for ($i = 1; $i <= 9; $i++) {
                    $table->addCell(500, ['bgColor' => in_array($i, $highlightMonths) ? 'yellow' : null]);
                }
            }
        }



        // $section->addText(
        //     '10. ขั้นตอนการดำเนินงาน : ',
        //     $boldTextStyle
        // );


        // if (DB::table('steps')->where('proID', $id)->exists()) {
        //     $pro_steps = DB::table('steps')->where('proID', $id)->get();

        //     $minYear = PHP_INT_MAX;
        //     $maxYear = PHP_INT_MIN;

        //     foreach ($pro_steps as $step) {
        //         $startDate = $step->start ?? null;
        //         $endDate = $step->end ?? null;
        //         $startYear = $startDate ? (new DateTime($startDate))->format('Y') + 543 : null;
        //         $endYear = $endDate ? (new DateTime($endDate))->format('Y') + 543 : null;

        //         if ($startYear) {
        //             $minYear = min($minYear, $startYear);
        //         }
        //         if ($endYear) {
        //             $maxYear = max($maxYear, $endYear);
        //         }
        //     }

        //     if ($minYear === PHP_INT_MAX) {
        //         $minYear = 'N/A';
        //     }
        //     if ($maxYear === PHP_INT_MIN) {
        //         $maxYear = 'N/A';
        //     }


        //     // กำหนด style ของตาราง
        //     $tableStyle = [
        //         'borderSize' => 6,
        //         'borderColor' => '000000',
        //         'cellMargin' => 50
        //     ];
        //     $phpWord->addTableStyle('myTable', $tableStyle);

        //     // เพิ่มตารางในเอกสาร
        //     $table = $section->addTable('myTable');

        //     // เพิ่มหัวตาราง
        //     $table->addRow();
        //     $table->addCell(null, ['vMerge' => 'restart', 'valign' => 'center', 'gridSpan' => 1])
        //         ->addText('ขั้นตอนการดำเนินการ');
        //     $table->addCell(null, ['gridSpan' => 3, 'valign' => 'center'])
        //         ->addText('พ.ศ. ' . $minYear);
        //     $table->addCell(null, ['gridSpan' => 9, 'valign' => 'center'])
        //         ->addText('พ.ศ. ' . $maxYear);

        //     $table->addRow();
        //     $table->addCell(); // เว้น cell ว่าง
        //     $table->addCell()->addText('ต.ค.');
        //     $table->addCell()->addText('พ.ย.');
        //     $table->addCell()->addText('ธ.ค.');
        //     $table->addCell()->addText('ม.ค.');
        //     $table->addCell()->addText('ก.พ.');
        //     $table->addCell()->addText('มี.ค.');
        //     $table->addCell()->addText('เม.ย.');
        //     $table->addCell()->addText('พ.ค.');
        //     $table->addCell()->addText('มิ.ย.');
        //     $table->addCell()->addText('ก.ค.');
        //     $table->addCell()->addText('ส.ค.');
        //     $table->addCell()->addText('ก.ย.');

        //     // เพิ่มข้อมูลในตาราง
        //     foreach ($pro_steps as $index => $step) {
        //         $stepName = $step->name ?? 'N/A';
        //         $highlightMonths = [];
        //         $startDate = $step->start ?? null;
        //         $endDate = $step->end ?? null;

        //         if ($startDate && $endDate) {
        //             $start = new DateTime($startDate);
        //             $end = new DateTime($endDate);

        //             while ($start <= $end) {
        //                 $highlightMonths[] = $start->format('n'); // ดึงเดือน (1-12)
        //                 $start->modify('+1 month'); // เลื่อนเดือนเพิ่มทีละ 1
        //             }
        //         }

        //         $table->addRow();
        //         $table->addCell()->addText(($index + 1) . '. ' . $stepName);

        //         for ($month = 1; $month <= 12; $month++) {
        //             $cellStyle = in_array($month, $highlightMonths) ? ['bgColor' => 'FFFF00'] : []; // ไฮไลต์เซลล์
        //             $table->addCell(null, $cellStyle);
        //         }
        //     }
        // }


        // $minStartDate = null; // เก็บวันที่เริ่มต้นที่น้อยที่สุด
        // $maxEndDate = null;   // เก็บวันที่สิ้นสุดที่มากที่สุด

        // foreach ($pro_steps as $step) {
        //     $startDate = $step->start ?? null; // วันที่เริ่มต้น
        //     $endDate = $step->end ?? null;    // วันที่สิ้นสุด

        //     if ($startDate) {
        //         $start = Carbon::parse($startDate);
        //         // อัปเดต $minStartDate ถ้า $start น้อยกว่า หรือ $minStartDate ยังเป็น null
        //         if (!$minStartDate || $start->lessThan($minStartDate)) {
        //             $minStartDate = $start;
        //         }
        //     }

        //     if ($endDate) {
        //         $end = Carbon::parse($endDate);
        //         // อัปเดต $maxEndDate ถ้า $end มากกว่า หรือ $maxEndDate ยังเป็น null
        //         if (!$maxEndDate || $end->greaterThan($maxEndDate)) {
        //             $maxEndDate = $end;
        //         }
        //     }
        // }


        // // ตรวจสอบผลลัพธ์
        // if ($minStartDate) {
        //     $startDay = $minStartDate->day;
        //     $startMonth = $minStartDate->translatedFormat('F');
        //     $startYear = $minStartDate->year + 543;
        //     $formattedStartDate = "{$startDay} {$startMonth} {$startYear}";
        // } else {
        //     $formattedStartDate = 'ไม่มีวันที่เริ่มต้น';
        // }

        // if ($maxEndDate) {
        //     $endDay = $maxEndDate->day;
        //     $endMonth = $maxEndDate->translatedFormat('F');
        //     $endYear = $maxEndDate->year + 543;
        //     $formattedEndDate = "{$endDay} {$endMonth} {$endYear}";
        // } else {
        //     $formattedEndDate = 'ไม่มีวันที่สิ้นสุด';
        // }

        // $textRun = $section->addTextRun();

        // $textRun->addText(
        //     '11. ระยะเวลาดำเนินงาน : ',
        //     $boldTextStyle
        // );

        // $textRun->addText(
        //     'เริ่มต้น ' . $formattedStartDate . ' สิ้นสุด ' . $formattedEndDate,
        // );




        // บันทึกเอกสารเป็นไฟล์ .docx
        $fileName = 'document_' . $id . '.docx';
        $phpWord->save(storage_path('app/public/' . $fileName), 'Word2007');

        return response()->download(storage_path('app/public/' . $fileName));
    }
}
