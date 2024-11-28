<?php

return [
    // การตั้งค่าฟอนต์เริ่มต้น
    'default_font' => [
        'name' => 'TH SarabunPSK',
        'size' => 16,
    ],

    // การตั้งค่าหน้ากระดาษ
    'page_settings' => [
        'orientation' => 'portrait',
        'paperSize' => 'A4',
        'margins' => [
            'top' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(2),
            'bottom' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(2),
            'left' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(2),
            'right' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(2),
        ],
    ],

    // รูปแบบข้อความ
    'styles' => [
        'header' => ['bold' => true, 'size' => 18],
        'bold_text' => ['bold' => true],
        'normal_text' => ['size' => 16],
    ],

    // การตั้งค่าตาราง
    'table_styles' => [
        'borderSize' => 6,
        'borderColor' => '000000',
        'alignment' => 'center',
    ],

    // การตั้งค่าการจัดย่อหน้า
    'paragraph_styles' => [
        'center' => ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER],
        'right' => ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::RIGHT],
        'left' => ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT],
        'indentation' => ['indentation' => ['left' => 920]],
    ],
];
