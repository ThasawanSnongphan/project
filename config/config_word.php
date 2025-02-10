<?php

return [
    // การตั้งค่าฟอนต์เริ่มต้น
    'default_font' => [
        'name' => 'TH SarabunPSK',
        'size' => 16, // ขนาด 16 สำหรับตัวอักษรทั้งหมด
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
        'header' => ['bold' => true, 'size' => 18], // ไม่ได้กำหนดฟอนต์ใน header
        'bold_text' => ['bold' => true], // การตั้งค่าตัวหนา
        'normal_text' => ['size' => 16], // ฟอนต์ปกติที่ขนาด 16
    ],

    // การตั้งค่าตาราง
    'table_styles' => [
        'borderSize' => 6,
        'borderColor' => '000000',
        // 'align' => 'center',
        // 'valign' => 'center',
        'align' => ['align' => 'center'], // สำหรับการจัดข้อความแนวนอน
        'cell' => ['valign' => 'center'], // สำหรับการจัดข้อความแนวตั้งในเซลล์
    ],

    // การตั้งค่าการจัดย่อหน้า
    'paragraph_styles' => [
        'center' => ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER],
        'right' => ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::RIGHT],
        'left' => ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT],
        'indentation' => ['indentation' => ['left' => 920]],
        'indentationMin' => ['indentation' => ['left' => 250]],
        'indentationMax' => ['indentation' => ['left' => 500]],
    ],

    // กำหนดค่าการตั้งค่าหลายรูปแบบ
    'space_style' => [
        'default' => ['spaceAfter' => 240], // ระยะห่าง 12pt หลังข้อความ
        'doubleSpacing' => ['lineHeight' => 2.0], // บรรทัดห่าง 2 เท่า
    ],
    
];
