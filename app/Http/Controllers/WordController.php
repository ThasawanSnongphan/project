<?php

namespace App\Http\Controllers;

use App\Models\BadgetType;
use App\Models\KPIProjects;
use App\Models\Objective;
use App\Models\Objectives;
use App\Models\ProjectCharec;
use App\Models\ProjectIntegrat;
use App\Models\Projects;
use App\Models\Users;
use App\Models\Year;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
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

        $username = Users::where('id', 10)->first();
        $years = Year::all();
        $projects = Projects::where('proID', $id)->first();
        $badget_types = BadgetType::all();
        $KPI_pros = KPIProjects::all();
        $project_integrats = ProjectIntegrat::all();
        $project_charecs = ProjectCharec::all();
        $objects = Objectives::all();

        // สร้างเอกสารใหม่
        $phpWord = new PhpWord();

        // ดึงค่าฟอนต์จาก config และตรวจสอบว่าไม่เป็น null
        $fontName = config('default_font.default_font.name', 'TH SarabunPSK');  // กำหนดค่า default เป็น THSarabunPSK ถ้าค่าใน config ไม่มี
        $fontSize = config('default_font.default_font.size', 16);               // กำหนดค่า default เป็น 16 ถ้าค่าใน config ไม่มี

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

        // เพิ่มข้อความลงในเอกสาร
        $section->addText("นี่คือเอกสารที่ใช้ฟอนต์ $fontName และขนาดฟอนต์ $fontSize");

        // บันทึกเอกสารเป็นไฟล์ .docx
        $fileName = 'document_' . $id . '.docx';
        $phpWord->save(storage_path('app/public/' . $fileName), 'Word2007');

        return response()->download(storage_path('app/public/' . $fileName));
    }
}
