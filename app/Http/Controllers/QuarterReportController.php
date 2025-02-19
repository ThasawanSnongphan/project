<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuarterReportController extends Controller
{
    public function quarter2($id)
    {
        $data['project'] = DB::table('projects')->where('proID',$id)->first();
        $data['steps'] = DB::table('steps')->where('proID',$id)->get();
        $data['KPI'] = DB::table('k_p_i_projects')->where('proID',$id)->get();
        $data['costQuarter']= DB::table('cost_quarters')->where('proID',$id)->get();
        // dd($data['costQuarter']);
        return view('QuarterlyProgressReport.quarter2',compact('data'));
    }
}
