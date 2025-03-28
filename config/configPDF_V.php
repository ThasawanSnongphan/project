<?php

$fontDirs = (new \Mpdf\Config\ConfigVariables())->getDefaults()['fontDir'];
$fontData = (new \Mpdf\Config\FontVariables())->getDefaults()['fontdata'];

return [
    'fontDir' => array_merge($fontDirs, [
        resource_path('fonts/'), // กำหนด path ของฟอนต์ที่เก็บใน resources/fonts/
    ]),
    'fontdata' => $fontData + [
        'thsarabun' => [
            'R' => 'THSarabunNew.ttf',
            'I' => 'THSarabunNew Italic.ttf',
            'B' => 'THSarabunNew Bold.ttf',
            'BI' => 'THSarabunNew BoldItalic.ttf',
        ],
    ],
    'default_font' => 'thsarabun', // กำหนดฟอนต์เริ่มต้นเป็น THSarabunNew
    'default_font_size' => 16,
    'format' => 'A4',
    'orientation' => 'P',     // แนวกระดาษ (P = แนวตั้ง, L = แนวนอน)
    'margin_top' => 16,       // ระยะขอบบน (หน่วยเป็น mm)
    'margin_bottom' => 16,    // ระยะขอบล่าง
    'margin_left' => 20,      // ระยะขอบซ้าย
    'margin_right' => 20,     // ระยะขอบขวา
];
