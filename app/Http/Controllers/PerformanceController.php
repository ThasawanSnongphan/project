<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectEvaluation;
use App\Models\Projects;
use Illuminate\Support\Facades\DB;

class PerformanceController extends Controller
{
    function index(){
        $data['projectAll'] = ProjectEvaluation::with('project.projectType')->count(); //นับโปรเจคทั้งหมด
        $data['projectID']  = ProjectEvaluation::all()->pluck('proID'); //นับโปรเจคตามแผน
        $data['projectInPlan'] = DB::table('projects')->where([['proID',$data['projectID']],['proTypeID',3]])->count();
        // dd($data['projectInPlan']);
        $data['projectOutPlan'] = DB::table('projects')->where([['proID',$data['projectID']],['proTypeID',4]])->count();
        return view('Performance.index',compact('data'));
    }
}
