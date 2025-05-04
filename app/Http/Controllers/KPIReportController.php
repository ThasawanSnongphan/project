<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KPIReportController extends Controller
{
    public function index()
{
    // ดึงข้อมูลจากฐานข้อมูล
    $data = DB::table('k_p_i_mains')->get();


    // ส่งไปยัง view
    return view('kpi.report', compact('data'));
}

}
