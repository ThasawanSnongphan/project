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
        $data['projectID']  = ProjectEvaluation::all()->pluck('proID'); 
       
        $data['projectInPlanAll'] = DB::table('projects')->whereIn('proID',$data['projectID'])->where('proTypeID',3)->get();//นับโปรเจคตามแผน
        $data['projectInPlan'] = $data['projectInPlanAll']->count();//นับโปรเจคตามแผน
        $data['proIDInPlan'] = $data['projectInPlanAll']->pluck('proID');
        $data['projectEvaluation'] = DB::table('projects')->whereIn('proID',$data['proIDInPlan'])->where('statusID',8)->count();
        // dd($data['proIDInPlan']);

        $data['projectOutPlan'] = DB::table('projects')->whereIn('proID',$data['projectID'])->where('proTypeID',4)->count();//นับโปรเจคนอกแผน
        return view('Performance.index',compact('data'));
    }
}
