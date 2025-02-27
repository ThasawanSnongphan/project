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
    }
}
