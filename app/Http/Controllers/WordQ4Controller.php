<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DateTime;

use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\PhpWord;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Shared\Converter;
use PhpOffice\PhpWord\SimpleType\Jc;


class WordQ4Controller extends Controller
{
    public function createWordDocFromDB()
    {
        // สร้างเอกสารใหม่
        $phpWord = new PhpWord();
        // $id = request('id', uniqid()); // ใช้ ID จาก request ถ้ามี
        // ดึงค่า ID ล่าสุดจาก session และเพิ่มค่า
        $id = Session::get('word_doc_id', 1);
        Session::put('word_doc_id', $id + 1);



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


        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        // Logo
        $imagePath = public_path('images/Garuda.png');
        $section->addImage($imagePath, [
            'width' => 60,
            'height' => null,
            'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT,
        ]);

        // Title
        $section->addText(
            'บันทึกข้อความ',
            array_merge(['size' => 30], $boldTextStyle),
            $center
        );

        function addSpacesToEnd($text, $maxLength)
        {
            $currentLength = mb_strlen(strip_tags($text)); // นับความยาวของข้อความ (ไม่รวม HTML)
            $spacesToAdd = max(0, $maxLength - $currentLength); // คำนวณช่องว่างที่ต้องเพิ่ม
            return $text . str_repeat(" ", $spacesToAdd);
        }

        function wrapTextWithDots($text, $lineLength = 80)
        {
            $words = explode(" ", $text);
            $lines = [];
            $currentLine = "";

            foreach ($words as $word) {
                if (mb_strlen($currentLine . " " . $word) > $lineLength) {
                    $lines[] = $currentLine; // เก็บบรรทัดปัจจุบัน
                    $currentLine = $word; // เริ่มบรรทัดใหม่
                } else {
                    $currentLine .= ($currentLine ? " " : "") . $word;
                }
            }
            $lines[] = $currentLine; // เพิ่มบรรทัดสุดท้าย

            // แปลงแต่ละบรรทัดเป็นข้อความ พร้อมเส้นจุดไข่ปลา
            return implode("\n", array_map(fn($line) => $line . str_repeat('.', max(0, $lineLength - mb_strlen($line))), $lines));
        }

        // กำหนดความยาวสูงสุดที่ต้องการให้เส้นจุดไข่ปลาวิ่งถึง
        $maxLineLength = 100;
        $minLineLength = 55;


        $textRun = $section->addTextRun();

        // ส่วนราชการ (ตัวหนา ขนาด 22)
        $textRun->addText(
            'ส่วนราชการ ',
            array_merge(['size' => 22], $boldTextStyle)
        );

        $textRun->addText(
            'สำนักคอมพิวเตอร์สารสนเทศ โทร.2215',
            ['underline' => 'dotted']
        );

        $textRun = $section->addTextRun();

        // ส่วนราชการ (ตัวหนา ขนาด 22)
        $textRun->addText(
            'ที่ ',
            array_merge(['size' => 22], $boldTextStyle)
        );

        $textRun->addText(
            'สค ภายใน /2566',
            ['underline' => 'dotted']
        );
        

        $textRun->addText(
            ' วันที่ ',
            array_merge(['size' => 22], $boldTextStyle)
        );

        $textRun->addText(
            addSpacesToEnd("19 ตุลาคม 2566", $minLineLength),
            ['underline' => 'dotted']
        );

        $textRun = $section->addTextRun();

        $textRun->addText(
            'เรื่อง ',
            array_merge(['size' => 22], $boldTextStyle)
        );

        $textRun->addText(
            addSpacesToEnd("ขอจัดส่งรายงานผลการดำเนินงานโครงการตามแผนปฏิบัติการและโครงการนอกแผนปฏิบัติการประจำปีงบประมาณ พ.ศ. 2566 (1 ตุลาคม 2565 - 30 กันยายน 2566)", $maxLineLength),
            ['underline' => 'dotted']
        );

        $textRun = $section->addTextRun();

        $textRun->addText(
            'เรียน ',
            $boldTextStyle
        );
        
        $textRun->addText(
            'ผู้อำนวยการสำนักคอมพิวเตอร์และเทคโนโลยีสารสนเทศ'
        );

        $section->addTextBreak();

        $section->addText(
            'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
            [],
            [
                        'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH, 
                        'indentation' => ['firstLine' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(2)]
                    ]
        );

        $section->addTextBreak(1);

        $section->addText(
            'แผนประจำปีงบประมาณ พ.ศ.2566',
            $boldTextStyle,
            ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]
        );

        $table = $section->addTable([
            'borderSize' => 6, 
            'borderColor' => '000000',
            'cellMargin' => 60,
            'width' => 100 * 50, 
            'unit' => \PhpOffice\PhpWord\SimpleType\TblWidth::PERCENT, 
            'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER]
        );

        // Header row
        $table->addRow();
        $table->addCell()->addText('ผลการดำเนินงาน', $boldTextStyle, $center);
        $table->addCell()->addText('จำนวนโครงการ', $boldTextStyle, $center);

        // Empty row
        $table->addRow();
        $table->addCell()->addText('');
        $table->addCell()->addText('');

        // Summary row
        $table->addRow();
        $table->addCell()->addText('รวม', $boldTextStyle, $center);
        $table->addCell()->addText('');


        $section->addText(
            'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
            [],
            [
                        'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH, 
                        'indentation' => ['firstLine' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(2)]
                    ]
        );

        $section->addTextBreak(1);

        // Centered bold title
        $section->addText(
            'โครงการนอกแผนปฏิบัติการประจำปีงบประมาณ พ.ศ. 2566',
            $boldTextStyle,
            ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]
        );


        $table = $section->addTable([
            'borderSize' => 6,
            'borderColor' => '000000',
            'cellMargin' => 60,
            'width' => 100 * 50, // 100% width
            'unit' => \PhpOffice\PhpWord\SimpleType\TblWidth::PERCENT,
            'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER
        ]);

        // Header row
        $table->addRow();
        $table->addCell()->addText('ผลการดำเนินงาน', $boldTextStyle, $center);
        $table->addCell()->addText('จำนวนโครงการ',  $boldTextStyle, $center);

        // Empty row
        $table->addRow();
        $table->addCell()->addText('');
        $table->addCell()->addText('');

        // Summary row
        $table->addRow();
        $table->addCell()->addText('รวม', $boldTextStyle, $center);
        $table->addCell()->addText('');

        $section->addText(
            'จึงเรียนมาเพื่อโปรดทราบ และเห็นควรนําเสนอคณะกรรมการบริหารสํานักคอมพิวเตอร์ฯ เพื่อพิจารณาต่อไป'
            
        );

        $section->addTextBreak(3); // เว้นบรรทัด

        $section->addText(
            '( นางศรินญา พงศ์สุริยา )',
            [],
            ['alignment' => 'center', 'indentation' => ['left' => 5000]]
        );

        $section->addText(
            "นักวิเคราะห์นโยบายและแผน",
            [],
            ['alignment' => 'center', 'indentation' => ['left' => 5000]]
        );








        // บันทึกเอกสารเป็นไฟล์ .docx
        $fileName = 'บันทึกขอจัดส่งผลการดำเนินงานตามแผนปฏิบัติการไตรมาส4' . '.docx';
        $phpWord->save(storage_path('app/public/' . $fileName), 'Word2007');

        return response()->download(storage_path('app/public/' . $fileName));
    }
}
