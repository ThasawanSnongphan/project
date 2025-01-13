<?php

namespace App\Http\Controllers;

use App\Models\BadgetType;
use App\Models\CostQuarters;
use App\Models\CostTypes;
use App\Models\CountKPIProjects;
use App\Models\ExpenseBadgets;
use App\Models\Funds;
use App\Models\Goals;
use App\Models\KPIProjects;
use App\Models\Objective;
use App\Models\Objectives;
use App\Models\ProjectCharec;
use App\Models\ProjectIntegrat;
use App\Models\Projects;
use App\Models\StrategicIssues;
use App\Models\StrategicMap;
use App\Models\Strategics;
use App\Models\Tactics;
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
        // $users = User::all();
        // $user = User::all();
        // $users = User::find(10);
        // $years = Year::where('yearID', 5)->first();
        // $projects_chas = ProjectCharec::all();
        // $p = ProjectCharec::where('ProChaID', 4)->first();
        // $project_integrats = ProjectIntegrat::all();
        // $projects = Projects::where('ProID', 1)->first();
        // $objects = Objectives::all();

        // $username = Users::where('id', 10)->first();
        // $projects = Projects::where('proID', $id)->first();
        // $years = Year::all();
        // $badget_types = BadgetType::all();
        // $KPI_pros = KPIProjects::all();
        // $project_integrats = ProjectIntegrat::all();
        // $project_charecs = ProjectCharec::all();
        // $objects = Objectives::all();

        $projects = Projects::where('proID', $id)->first();
        $years = Year::all();
        $users_map = UsersMapProject::all();
        $users = Users::all();
        $strategic_maps = StrategicMap::all();
        $strategic_issues = StrategicIssues::all();
        $strategics = Strategics::all();
        $goals = Goals::all();
        $tactics = Tactics::all();
        $plans = UniPlan::all();
        $funds = Funds::all();
        $badget_types = BadgetType::all();
        $expense_badgets = ExpenseBadgets::all();
        $cost_quarters = CostQuarters::all();
        $cost_types = CostTypes::all();

        $badget_types = BadgetType::all();
        $KPI_pros = KPIProjects::all();
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
        // $section->addTextBreak();

        foreach ($years as $year) {
            if ($projects->yearID == $year->yearID) {
                $section->addText(
                    'แบบเสนอโครงการ ประจำปีงบประมาณ พ.ศ. ' . $year->year,
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
            $projects->name
        );

        $section->addText('2. สังกัด :', ['bold' => true]);

        // สร้างอาร์เรย์สำหรับเก็บข้อมูลสังกัดและชื่อผู้รับผิดชอบ
        $departments = [];
        $responsibleNames = [];

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
                    }
                }
            }
        }

        // แสดงข้อมูลสังกัด
        foreach ($departments as $department) {
            $section->addText(
                "    $department",
                ['bold' => true]
            );
        }

        // แสดงข้อมูลผู้รับผิดชอบในรูปแบบชื่อคั่นด้วย ","
        if (!empty($responsibleNames)) {

            $textRun = $section->addTextRun();
            $textRun->addText(
                '    ผู้รับผิดชอบ : ',
                ['bold' => true]
            );
            $textRun->addText(implode(', ', $responsibleNames));
        }


        // foreach ($strategic_maps as $strategic_map) {
        //     if ($projects->proID == $strategic_map->proID) {
        //         // ตรวจสอบและเพิ่มเนื้อหาในเอกสาร Word

        //         // เช็คชื่อจาก straID
        //         foreach ($strategics as $strategic) {
        //             if ($strategic->straID == $strategic_map->straID) {
        //                 $section->addText('3. ความเชื่อมโยงสอดคล้องกับ ' . $strategic->name, ['bold' => true]);
        //                 break; // เจอข้อมูลแล้วออกจากลูป
        //             }
        //         }

        //         // เช็คชื่อจาก SFAID
        //         foreach ($strategic_issues as $strategic_issue) {
        //             if ($strategic_issue->SFAID == $strategic_map->SFAID) {
        //                 $textRun = $section->addTextRun();
        //                 $textRun->addText('      ประเด็นยุทธศาสตร์ที่ ', ['bold' => true]);
        //                 $textRun->addText($strategic_issue->name);
        //                 break; // เจอข้อมูลแล้วออกจากลูป
        //             }
        //         }

        //         // เช็คชื่อจาก goalID
        //         foreach ($goals as $goal) {
        //             if ($goal->goalID == $strategic_map->goalID) {
        //                 $textRun = $section->addTextRun();
        //                 $textRun->addText('      เป้าประสงค์ที่ ', ['bold' => true]);
        //                 $textRun->addText($goal->name);
        //                 break; // เจอข้อมูลแล้วออกจากลูป
        //             }
        //         }

        //         // เช็คชื่อจาก tacID
        //         foreach ($tactics as $tactic) {
        //             if ($tactic->tacID == $strategic_map->tacID) {
        //                 $textRun = $section->addTextRun();
        //                 $textRun->addText('      กลยุทธ์ที่ ', ['bold' => true]);
        //                 $textRun->addText($tactic->name);
        //                 break; // เจอข้อมูลแล้วออกจากลูป
        //             }
        //         }
        //     }
        // }

        $section->addText('3. ความเชื่อมโยงสอดคล้องกับ', ['bold' => true]);

        $counter = 1;
        foreach ($strategic_maps as $strategic_map) {
            if ($projects->proID == $strategic_map->proID) {

                // เช็คชื่อจาก straID
                foreach ($strategics as $strategic) {
                    if ($strategic->straID == $strategic_map->straID) {
                        $section->addText("    3.$counter " . $strategic->name, ['bold' => true]);
                        $counter++;
                        break;
                    }
                }

                // เช็คชื่อจาก SFAID
                foreach ($strategic_issues as $strategic_issue) {
                    if ($strategic_issue->SFAID == $strategic_map->SFAID) {
                        $section->addText("        ประเด็นยุทธศาสตร์ที่ " . $strategic_issue->name);
                        break;
                    }
                }

                // เช็คชื่อจาก goalID
                foreach ($goals as $goal) {
                    if ($goal->goalID == $strategic_map->goalID) {
                        $section->addText("        เป้าประสงค์ที่ " . $goal->name);
                        break;
                    }
                }

                // เช็คชื่อจาก tacID
                foreach ($tactics as $tactic) {
                    if ($tactic->tacID == $strategic_map->tacID) {
                        $section->addText("        กลยุทธ์ที่ " . $tactic->name);
                        break;
                    }
                }
            }
        }

        $section->addText(
            '4. ลักษณะโครงการ / กิจกรรม',
            $boldTextStyle
        );

        $textLine = '';

        foreach ($project_charecs as $project_charec) {
            if ($projects->proChaID == $project_charec->proChaID) {
                // เพิ่มข้อความพร้อมเครื่องหมายถูก
                $textLine .= '☑ ' . $project_charec->name . '    ';
            } else {
                // เพิ่มข้อความโดยไม่มีเครื่องหมายถูก
                $textLine .= '☐ ' . $project_charec->name . '    ';
            }
        }

        // เพิ่มข้อความทั้งหมดในบรรทัดเดียว
        $section->addText($textLine);

        $section->addText(
            '5. การบูรณาการโครงการ',
            $boldTextStyle
        );

        foreach ($project_integrats as $project_integrat) {
            if ($projects->proInID == $project_integrat->proInID) {
                // เพิ่มข้อความพร้อมเครื่องหมายถูก
                $section->addText(
                    '☑ ' . $project_integrat->name
                );
            } else {
                // เพิ่มข้อความโดยไม่มีเครื่องหมายถูก
                $section->addText(
                    '☐ ' . $project_integrat->name
                );
            }
        }

        $section->addText(
            '6. หลักการและเหตุผลของโครงการ',
            $boldTextStyle
        );

        $section->addText(
            $projects->princiDetail
        );

        $section->addText(
            '7. วัตถุประสงค์',
            $boldTextStyle
        );

        if (DB::table('objectives')->where('proID', $id)->exists()) {
            // ดึงข้อมูลที่ตรงกับ proID
            $objects = DB::table('objectives')->where('proID', $id)->get();

            $counter = 1; // ตัวแปรเก็บลำดับ
            foreach ($objects as $object) {
                $section->addText(
                    "    7.$counter " . $object->detail
                );
                $counter++;
            }
        }

        $section->addText(
            '8. ตัวชี้วัดความสำเร็จระดับโครงการ',
            $boldTextStyle
        );

        // // สร้างตาราง
        // $table = $section->addTable([
        //     'borderSize' => 6,
        //     'borderColor' => '000000',
        //     'cellMargin' => 80,
        //     // 'bottomMargin' => 900
        // ]);

        // // เพิ่มหัวตาราง
        // $table->addRow();
        // $table->addCell(5000)->addText('ตัวชี้วัดความสำเร็จ', null, $textAlignCenter);
        // $table->addCell(2000)->addText('หน่วยนับ', null, $textAlignCenter);
        // $table->addCell(2000)->addText('ค่าเป้าหมาย', null, $textAlignCenter);

        // // ตรวจสอบข้อมูลในฐานข้อมูล
        // if (DB::table('k_p_i_projects')->where('proID', $id)->exists()) {
        //     $KPI_pros = DB::table('k_p_i_projects')->where('proID', $id)->get();

        //     // เพิ่มข้อมูลในตาราง
        //     foreach ($KPI_pros as $KPI_pro) {
        //         $table->addRow();
        //         $table->addCell(5000)->addText($KPI_pro->name);
        //         $table->addCell(2000)->addText($KPI_pro->count);
        //         $table->addCell(2000)->addText($KPI_pro->target);
        //     }
        // }

        // $section->addText(
        //     '9. กลุ่มเป้าหมาย (ระบุกลุ่มเป้าหมายและจำนวนกลุ่มเป้าหมายที่เข้าร่วมโครงการ)',
        //     $boldTextStyle
        // );

        // $pro_tars = Projects::with('target')->get();

        // foreach ($pro_tars as $pro_tar) {
        //     $tarID = $pro_tar->tarID;
        //     $targetName = $pro_tar->target->name ?? 'N/A'; // ใช้ข้อมูลจากตาราง targets

        // }

        // // เพิ่มข้อมูลกลุ่มเป้าหมายในเอกสาร
        // $section->addText(
        //     '    ' . $targetName, // เพิ่มการย่อหน้าเพื่อให้ตรงกับรูปแบบ
        // );

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
