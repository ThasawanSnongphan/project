<?php

namespace App\Http\Controllers;

use App\Models\Goals;
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
use Carbon\Carbon;
use DateTime;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Shared\Converter;
use PhpOffice\PhpWord\SimpleType\Jc;

class WordKPIController extends Controller
{
    public function word_gen($id)
    {
        // ตรวจสอบว่า $id มีค่าหรือไม่
        if (empty($id)) {
            return response()->json(['message' => 'ไม่มีข้อมูลของโครงการ'], 400, [], JSON_UNESCAPED_UNICODE);
        }

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

        // สร้างเอกสารใหม่
        $phpWord = new PhpWord();

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
                    'แบบประเมินโครงการที่ตอบสนองยุทธศาสตร์การพัฒนาสำนักคอมพิวเตอร์และเทคโนโลนีสารสนเทศ' . $year->name,
                    $boldTextStyle,
                    $center
                );

                $section->addText(
                    'ประจำปีงบประมาณ ' . $year->year . '',
                    $boldTextStyle,
                    $center
                );
            } else {
                return redirect()->back()->with('error', 'ไม่มีข้อมูลของโครงการ');
            }
        }

        $section->addText(
            'คำชี้แจง',
            $boldTextStyle
        );

        $section->addText(
            '2. โครงการ / กิจกรรมนี้ตอบสนอง',
            $boldTextStyle
        );

        // $all_strategic_plans = [];

        // // รวมแผนทุกระดับที่ proID ตรงกัน
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

        // foreach ($strategic2_level_maps as $strategic2_level_map) {
        //     if ($projects->proID == $strategic2_level_map->proID) {
        //         $all_strategic_plans[] = [
        //             'name' => collect($strategic2_levels)->firstWhere('stra2LVID', $strategic2_level_map->stra2LVID)?->name,
        //             'strategic_issue' => collect($strategic_issue2_levels)->firstWhere('SFA2LVID', $strategic2_level_map->SFA2LVID)?->name,
        //             'tactic' => collect($tactic2_levels)->firstWhere('tac2LVID', $strategic2_level_map->tac2LVID)?->name
        //         ];
        //     }
        // }

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

        // if ($totalPlans === 1) {
        //     // ถ้ามีแค่ 1 แผน ให้แสดงชื่อแผนในบรรทัดเดียวกับหัวข้อ
        //     $plan = $all_strategic_plans[0];
        //     $section->addText("2. โครงการ / กิจกรรมนี้ตอบสนอง {$plan['name']}", $boldTextStyle);
        // } else {
        //     $section->addText('2. โครงการ / กิจกรรมนี้ตอบสนอง', $boldTextStyle);
        // }

        // // แสดงรายละเอียดของแต่ละแผน
        // foreach ($all_strategic_plans as $plan) {
        //     if ($totalPlans > 1) {
        //         $section->addText("3.$index {$plan['name']}", $boldTextStyle, $indentationMin);
        //         $index++;
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





        // บันทึกเอกสารเป็นไฟล์ .docx
        $fileName = 'แบบประเมินโครงการที่ตอบสนองยุทธศาสตร์การพัฒนาสำนักคอมพิวเตอร์และเทคโนโลนีสารสนเทศ.docx';
        $phpWord->save(storage_path('app/public/' . $fileName), 'Word2007');

        return response()->download(storage_path('app/public/' . $fileName));
    }
}
