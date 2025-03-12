<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectEvaluation;
use App\Models\Projects;
use Illuminate\Support\Facades\DB;

class PerformanceController extends Controller
{
    function index(){
        $data['projectAll'] = ProjectS::with('projectType')->whereBetween('statusID',[4,11])->get(); //โครงการทั้งหมด
        $data['projectcount']  = $data['projectAll']->count(); //นับโครงการทั้งหมด
        $data['projectEvaComplete'] = $data['projectAll']->where('statusID',8)->count(); //นับโครงการที่ปิดโครงการ/เสร็จตามระยะเวลา
        $data['projectEvaDeadline'] = $data['projectAll']->where('statusID',9)->count(); //นับโครงการที่ปิดโครงการ/ไม่เป็นไปตามระยะเวลา
        $data['projectEvaPostponed'] = $data['projectAll']->where('statusID',10)->count(); //นับโครงการที่ปิดโครงการ/ขอเลื่อน
        $data['projectEvaCancle'] = $data['projectAll']->where('statusID',11)->count(); //นับโครงการที่ปิดโครงการ/ขอยกเลิก
        $data['proID'] =  $data['projectAll']->pluck('proID');
        // $data['']


        // dd($data['proID']);
       
        $data['projectInPlanAll'] = $data['projectAll']->whereBetween('statusID',[4,11])->where('proTypeID',3);//นับโปรเจคตามแผน
        $data['projectInPlan'] = $data['projectInPlanAll']->count();//นับโปรเจคตามแผน
        // $data['proIDInPlan'] = $data['projectInPlanAll']->pluck('proID');
        // $data['projectEvaluation'] = DB::table('projects')->whereIn('proID',$data['proIDInPlan'])->where('statusID',8)->count();
        // dd($data['proIDInPlan']);

        $data['projectOutPlan'] = DB::table('projects')->whereIn('proID',$data['proID'])->where('proTypeID',4)->count();//นับโปรเจคนอกแผน
        return view('Performance.index',compact('data'));
    }
}
