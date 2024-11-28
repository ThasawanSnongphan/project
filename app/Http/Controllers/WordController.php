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

        // กำหนด default font
        // $phpWord->setDefaultFontName('TH SarabunPSK');  // เปลี่ยนเป็นฟอนต์ที่ต้องการ
        // $phpWord->setDefaultFontSize(16);       // กำหนดขนาดฟอนต์

        // กำหนดค่าการจัดหน้ากระดาษ
        // $sectionStyle = array(
        //     'orientation' => 'portrait',        // แนวตั้ง ('portrait') หรือแนวนอน ('landscape')
        //     'paperSize' => 'A4',                // ขนาดกระดาษ A4
        //     'marginTop' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(2),      // ระยะขอบด้านบน 2 ซม.
        //     'marginBottom' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(2),   // ระยะขอบด้านล่าง 2 ซม.
        //     'marginLeft' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(2),     // ระยะขอบด้านซ้าย 2 ซม.
        //     'marginRight' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(2),    // ระยะขอบด้านขวา 2 ซม.
        // );

        // กำหนดรูปแบบของ font
        // $fontStyle = ['bold' => true];
        // $centerStyle = ['alignment' => Jc::CENTER];
        // $rightStyle = ['alignment' => Jc::RIGHT];
        // $cellVAlignCenter = ['valign' => 'center'];

        // ดึงค่าฟอนต์และการตั้งค่าจาก config
        $defaultFont = config('word.default_font');
        $pageSettings = config('word.page_settings');
        $headerStyle = config('word.styles.header');
        $paragraphStyles = config('word.paragraph_styles');
        $tableStyles = config('word.table_styles');

        $section = $phpWord->addSection($paragraphStyles);

        // กำหนดเส้นทางของรูปภาพ (ที่เก็บในโฟลเดอร์ public)
        $imagePath = public_path('images/logo_kmutnb.jpg');

        // เพิ่มรูปภาพลงในเอกสาร
        $section->addImage(
            $imagePath,
            array(
                'width' => 40,              // กำหนดความกว้างของรูป
                'height' => 40,             // กำหนดความสูงของรูป
                'alignment' => Jc::CENTER   // กำหนดตำแหน่งให้รูปอยู่ตรงกลาง
            )
        );

        // เพิ่มข้อความในเอกสาร
        $section->addText(
            'แบบเสนอโครงการ ประจำปีงบประมาณ พ.ศ.' . $years->name,
            ['bold' => true],  // รูปแบบตัวอักษร
            ['alignment' => Jc::CENTER]  // รูปแบบย่อหน้า
        );

        // เพิ่มข้อความบรรทัดที่สอง
        $section->addText(
            'มหาวิทยาลัยเทคโนโลยีพระจอมเกล้าพระนครเหนือ',
            ['bold' => true, 'size' => 16],  // ตัวหนา ขนาดฟอนต์ 16
            ['alignment' => Jc::CENTER]  // จัดให้อยู่ตรงกลาง
        );

        // $section->addText(
        //     '1. ชื่อโครงการ : ' . $projects->ProjectName,
        //     ['bold' => true]
        // );

        // $section->addText(
        //     '2. สังกัด : ' . $users->department_name,
        //     ['bold' => true]
        // );

        // // การเว้นแท็บแบบจำลองด้วยการเยื้อง (indentation)
        // $section->addText(
        //     'สำนักงานผู้อำนวยการ',
        //     ['bold' => true],
        //     ['indentation' => array('left' => 920)]  // เพิ่มการเยื้อง (เทียบเท่าแท็บ)
        // );

        // $textRun = $section->addTextRun(['indentation' => array('left' => 920)]);

        // $textRun->addText('ผู้รับผิดชอบ : ', ['bold' => true]);
        // $textRun->addText($users->username); 

        // $section->addText(
        //     '3. ความเชื่อมโยงสอดคล้องกับ แผนปฏิบัติการดิจิทัล มจพ. ระยะ 3 ปี พ.ศ. 2567-2569',
        //     ['bold' => true],
        // );

        // $section->addText(
        //     '4. ลักษณะโครงการ / กิจกรรม',
        //     ['bold' => true],
        // );

        // // สร้าง TextRun ใหม่
        // $textRun = $section->addTextRun(['indentation' => ['left' => 330]]);
        // foreach ($projects_chas as $projects_cha) {
        //     // สร้างกล่อง Checkbox
        //     $textRun->addText(
        //         '☑  ' . $projects_cha->pro_cha_name,
        //         ['bold' => false]
        //     );
        // }

        // $section->addText(
        //     '5. การบูรณาการโครงการ',
        //     ['bold' => true],
        // );

        // foreach ($project_integrats as $project_integrat) {
        //     // สร้างกล่อง Checkbox
        //     $section->addText(
        //         '☑  ' . $project_integrat->name . '   ', // เปลี่ยนเป็น '☐' ถ้าต้องการกล่องว่าง
        //         ['bold' => false],
        //         ['indentation' => array('left' => 330)]  // เพิ่มการเยื้อง (เทียบเท่าแท็บ)
        //     );
        // }

        // $section->addText(
        //     '6. หลักการและเหตุผลของโครงการ',
        //     ['bold' => true],
        // );

        // $section->addText(
        //     ''. $projects->PrinciDetail,
        // );

        // $section->addTextBreak(1);

        // $section->addText(
        //     '7. วัตถุประสงค์',
        //     ['bold' => true],
        // );

        // // กำหนดตัวแปรสำหรับเก็บลำดับ
        // $counter = 1;

        // // Loop ผ่านรายการ
        // foreach ($objects as $object) {
        //     // เพิ่มข้อความในรูปแบบลำดับ
        //     $section->addText(
        //         '7.' . $counter . ' ' . $object->ObjectDetail,
        //         ['bold' => false],
        //         ['indentation' => array('left' => 330)]  // เพิ่มการเยื้อง (เทียบเท่าแท็บ)
        //     );
        //     $counter++; // เพิ่มค่าลำดับหลังจากแสดงผลแต่ละครั้ง
        // }

        // $section->addText(
        //     '8. ตัวชี้วัดความสำเร็จระดับโครงการ',
        //     ['bold' => true],
        // );

        // // สร้างตาราง
        // $table = $section->addTable([
        //     'borderSize' => 6, // ขนาดเส้นขอบ
        //     'borderColor' => '000000', // สีของเส้นขอบ
        //     'alignment' => 'center', // จัดกึ่งกลาง
        // ]);

        // // เพิ่มแถวหัวตาราง
        // $table->addRow();
        // $table->addCell(10000)->addText(
        //     'ตัวชี้วัดความสำเร็จ',
        //     ['bold' => true]
        // );

        // $table->addCell(1000)->addText(
        //     'หน่วยนับ',
        //     ['bold' => true]
        // );

        // $table->addCell(1000)->addText(
        //     'ค่าเป้าหมาย',
        //     ['bold' => true],
        //     ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]
        // );

        // // ใช้ loop เพื่อเพิ่มข้อมูลจากฐานข้อมูล
        // foreach ($user as $i) {
        //     $table->addRow();
        //     $table->addCell(4000, ['valign' => 'center'])->addText($i['id'], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]); // แสดง id
        //     $table->addCell(4000, ['valign' => 'center'])->addText($i['username'], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]); // แสดง name
        //     $table->addCell(4000, ['valign' => 'center'])->addText($i['email'], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]); // แสดง email
        // }

        // $section->addText(
        //     '9. กลุ่มเป้าหมาย (ระบุกลุ่มเป้าหมายและจำนวนกลุ่มเป้าหมายที่เข้าร่วมโครงการ)',
        //     ['bold' => true],
        // );

        // $section->addText(
        //     '10. ขั้นตอนการดำเนินงาน : ',
        //     ['bold' => true],
        // );

        // // สร้างตาราง
        // $table = $section->addTable([
        //     'borderSize' => 6, // ขนาดเส้นขอบ
        //     'borderColor' => '000000', // สีของเส้นขอบ
        //     'alignment' => 'center', // จัดกึ่งกลาง
        // ]);

        // // เพิ่มแถวสำหรับหัวข้อหลัก
        // $table->addRow();
        // $table->addCell(7000, ['gridSpan' => 1, 'valign' => 'center', 'vMerge' => 'restart'])->addText('ขั้นตอนการดำเนินการ', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        // $table->addCell(3000, ['gridSpan' => 3, 'valign' => 'center'])->addText('พ.ศ. 2567', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        // $table->addCell(6000, ['gridSpan' => 9, 'valign' => 'center'])->addText('พ.ศ. 2568', ['bold' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        // // เพิ่มแถวสำหรับเดือน
        // $table->addRow();
        // $table->addCell(4000, ['valign' => 'center'])->addText('', [], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]); // ค่าว่าง
        // $months = ['ต.ค.', 'พ.ย.', 'ธ.ค.', 'ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.'];

        // foreach ($months as $month) {
        //     $table->addCell(1000, ['valign' => 'center'])->addText($month, [], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        // }

        // $c = 1;
        // foreach ($project_integrats as $project_integrat) {
        //     $table->addRow();
        //     $table->addCell(4000, ['valign' => 'center'])->addText($c . '.' . ' ' . $project_integrat->name, [], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT]); // เพิ่มขั้นตอน
        //     for ($i = 0; $i < 12; $i++) {
        //         $table->addCell(1000, ['valign' => 'center', 'bgColor' => 'FFFF00'])->addText(''); // ค่าว่างสำหรับแต่ละเดือน
        //     }
        //     $c++;
        // }

        // // //เพิ่มสีในบางเซลล์ (เช่น ในต.ค. พ.ศ. 2567 ที่มีการเน้นสี)
        // // $table->addRow();
        // // $table->addCell(4000, ['valign' => 'center'])->addText('บูรณาการกับการเรียนการสอน');
        // // for ($i = 0; $i < 2; $i++) {
        // //     $table->addCell(1000, ['valign' => 'center'])->addText('');
        // // }
        // // $table->addCell(1000, ['valign' => 'center', 'bgColor' => 'FFFF00'])->addText(''); // ต.ค. พ.ศ. 2567 มีสีเหลือง
        // // for ($i = 0; $i < 9; $i++) {
        // //     $table->addCell(1000, ['valign' => 'center'])->addText('');
        // // }

        // $section->addText(
        //     '11. ระยะเวลาดำเนินงาน : เริ่มต้น 1 พฤษภาคม 2567 สิ้นสุด 30 กันยายน 2568',
        //     ['bold' => true],
        // );

        // $section->addText(
        //     '12. แหล่งเงิน / ประเภทงบประมาณที่ใช้ / แผนงาน',
        //     ['bold' => true],
        // );

        // $section->addText(
        //     '☐  ' . $p->pro_cha_name . '   ',
        //     ['bold' => false],
        //     ['indentation' => array('left' => 330)]
        // );

        // $section->addText(
        //     '13. ประมาณค่าใช้จ่าย : ( หน่วย : บาท )',
        //     ['bold' => true],
        // );

        // // สร้างตาราง
        // $table = $section->addTable(['borderSize' => 6, 'borderColor' => '000000']);

        // // เพิ่มแถวสอง
        // $table->addRow();
        // $table->addCell(4000, $cellVAlignCenter)->addText('ประเภทการจ่าย',  [], $centerStyle);
        // $table->addCell(1600, $cellVAlignCenter)->addText('รวม', [],  $centerStyle);
        // $table->addCell(1600, $cellVAlignCenter)->addText('ไตรมาส 1',  [], $centerStyle);
        // $table->addCell(1600, $cellVAlignCenter)->addText('ไตรมาส 2',  [], $centerStyle);
        // $table->addCell(1600, $cellVAlignCenter)->addText('ไตรมาส 3',  [], $centerStyle);
        // $table->addCell(1600, $cellVAlignCenter)->addText('ไตรมาส 4',  [], $centerStyle);

        // // เพิ่มแถวสาม
        // $table->addRow();
        // $table->addCell(4000, $cellVAlignCenter)->addText('');
        // $table->addCell(2000, $cellVAlignCenter)->addText('แผนการใช้จ่าย',  [], $centerStyle);
        // $table->addCell(2000, $cellVAlignCenter)->addText('แผนการใช้จ่าย',  [], $centerStyle);
        // $table->addCell(2000, $cellVAlignCenter)->addText('แผนการใช้จ่าย',  [], $centerStyle);
        // $table->addCell(2000, $cellVAlignCenter)->addText('แผนการใช้จ่าย',  [], $centerStyle);
        // $table->addCell(2000, $cellVAlignCenter)->addText('แผนการใช้จ่าย',  [], $centerStyle);

        // // เพิ่มแถวที่ 4 (ช่องข้อมูลที่เป็นเครื่องหมาย -)
        // $table->addRow();
        // for ($i = 0; $i <= 5; $i++) {
        //     $table->addCell(2000, $cellVAlignCenter)->addText('', [], $centerStyle);
        // }

        // // เพิ่มแถวที่ 5 (ช่องข้อมูลที่เป็นเครื่องหมาย -)
        // $table->addRow();
        // for ($i = 0; $i <= 5; $i++) {
        //     $table->addCell(2000, $cellVAlignCenter)->addText('-', [], $centerStyle);
        // }

        // // เพิ่มแถวที่ 6 (รวมเงินงบประมาณ)
        // $table->addRow();
        // $table->addCell(4000, $cellVAlignCenter)->addText('', $centerStyle);
        // for ($i = 0; $i <= 4; $i++) {
        //     $table->addCell(2000, $cellVAlignCenter)->addText('-', [], $centerStyle);
        // }

        // // เพิ่มแถวสุดท้าย (ช่องข้อมูลว่าง)
        // $table->addRow();
        // $table->addCell(4000, $cellVAlignCenter)->addText('รวมเงินงบประมาณ',  [], $centerStyle);
        // for ($i = 0; $i <= 4; $i++) {
        //     $table->addCell(2000, $cellVAlignCenter)->addText('-', [], $centerStyle);
        // }

        // $section->addText(
        //     '14. ประมาณการงบประมาณที่ใช้ : -',
        //     ['bold' => true],
        // );

        // $section->addText(
        //     '15. ประโยชน์ที่คาดว่าจะได้รับ',
        //     ['bold' => true],
        // );

        // // กำหนดตัวแปรสำหรับเก็บลำดับ
        // $counter = 1;

        // // Loop ผ่านรายการ
        // foreach ($project_integrats as $project_integrat) {
        //     // เพิ่มข้อความในรูปแบบลำดับ
        //     $section->addText(
        //         '15.' . $counter . ' ' . $project_integrat->name,
        //         ['bold' => false],
        //         ['indentation' => array('left' => 330)]  // เพิ่มการเยื้อง (เทียบเท่าแท็บ)
        //     );
        //     $counter++; // เพิ่มค่าลำดับหลังจากแสดงผลแต่ละครั้ง
        // }

        // // $section->addText('ลงชื่อ .................................................', $fontStyle, $rightStyle);
        // // $section->addText('( ' . $users->username . ' )', $fontStyle, $rightStyle);
        // // $section->addText('ผู้รับผิดชอบโครงการ', $fontStyle, $rightStyle);
        // // $section->addText('วันที่ ........../......................./..........', $fontStyle, $rightStyle);

        // // เพิ่มข้อความลายเซ็น
        // $table = $section->addTable();

        // // เพิ่มตารางลายเซ็น
        // $table = $section->addTable([
        //     $rightStyle // จัดตำแหน่งตารางไปทางขวา
        // ]);

        // // เพิ่มแถวลายเซ็น
        // $table->addRow();
        // $cell = $table->addCell(10000, ['valign' => 'center']);
        // $cell->addText('ลงชื่อ .................................................', [], $centerStyle);
        // $cell->addText('( ' . $users->username . ' )', [], $centerStyle);
        // $cell->addText('ผู้รับผิดชอบโครงการ', [], $centerStyle);
        // $cell->addText('วันที่ ........../......................./..........', [], $centerStyle);


        // // วนลูปเพื่อเพิ่มข้อมูลผู้ใช้ลงในเอกสาร
        // foreach ($projects_chas as $projects_cha) {
        //     $section->addText('ไอดี: ' . $projects_cha->id);
        //     $section->addText('ชื่อ: ' . $projects_cha->pro_cha_name);
        //     $section->addTextBreak(1); // เพิ่มช่องว่างบรรทัดใหม่
        // }

        // สร้างไฟล์ Word
        $filename = 'แบบเสนอโครงการประจำปีงบประมาณ' . $years->name . '.docx';
        $tempFile = tempnam(sys_get_temp_dir(), $filename);
        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($tempFile);

        // ส่งไฟล์ให้ผู้ใช้ดาวน์โหลด
        return response()->download($tempFile, $filename)->deleteFileAfterSend(true);
    }
}
