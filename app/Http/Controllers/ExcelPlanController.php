<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

use Illuminate\Http\Request;

class ExcelPlanController extends Controller
{
    public function excel_gen(){
        
    }
}
