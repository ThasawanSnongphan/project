<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectEvaluation;
use App\Models\Projects;
use Illuminate\Support\Facades\DB;

class PerformanceController extends Controller
{
    function index(){
        //โครงการทั้งหมด
        $data['projectAll'] = Projects::with('projectType')->whereBetween('statusID',[4,11])->get(); 
        $data['projectCountAll']  = $data['projectAll']->count(); //นับโครงการทั้งหมด
        $data['projectEvaCompleteAll'] = $data['projectAll']->where('statusID',8)->count(); //นับโครงการที่ปิดโครงการ/เสร็จตามระยะเวลา
        $data['projectEvaDeadlineAll'] = $data['projectAll']->where('statusID',9)->count(); //นับโครงการที่ปิดโครงการ/ไม่เป็นไปตามระยะเวลา
        $data['projectEvaPostponedAll'] = $data['projectAll']->where('statusID',10)->count(); //นับโครงการที่ปิดโครงการ/ขอเลื่อน
        $data['projectEvaCancleAll'] = $data['projectAll']->where('statusID',11)->count(); //นับโครงการที่ปิดโครงการ/ขอยกเลิก
        $data['proIDAll'] =  $data['projectAll']->pluck('proID');
        $data['report_quarterAll'] = DB::table('report_quarters')->whereIn('proID',$data['proIDAll'])->get();
        $data['report_quarterCountAll'] = $data['report_quarterAll']->count();
        $data['no_ReportAll'] = $data['projectCountAll'] -  $data['report_quarterCountAll'] ;
        
        //โครงการตามแผนปฏิบัติ
        $data['projectInPlanAll'] = $data['projectAll']->whereBetween('statusID',[4,11])->where('proTypeID',3);//นับโปรเจคตามแผน
        $data['projectCountInPlan'] = $data['projectInPlanAll']->count();//นับโปรเจคตามแผน
        $data['projectEvaCompleteInPlan'] = $data['projectInPlanAll']->where('statusID',8)->count();
        $data['projectEvaDeadlineInPlan'] = $data['projectInPlanAll']->where('statusID',9)->count(); //นับโครงการที่ปิดโครงการ/ไม่เป็นไปตามระยะเวลา
        $data['projectEvaPostponedInPlan'] = $data['projectInPlanAll']->where('statusID',10)->count(); //นับโครงการที่ปิดโครงการ/ขอเลื่อน
        $data['projectEvaCancleInPlan'] = $data['projectInPlanAll']->where('statusID',11)->count(); //นับโครงการที่ปิดโครงการ/ขอยกเลิก
        $data['proIDInPlan'] =  $data['projectInPlanAll']->pluck('proID');
        $data['report_quarteInPlan'] = DB::table('report_quarters')->whereIn('proID',$data['proIDInPlan'])->get();
        $data['report_quarterCountInPlan'] = $data['report_quarteInPlan']->count();
        $data['no_ReportInPlan'] = $data['projectCountInPlan'] -  $data['report_quarterCountInPlan'] ;
        // $data['proIDInPlan'] = $data['projectInPlanAll']->pluck('proID');
        // $data['projectEvaluation'] = DB::table('projects')->whereIn('proID',$data['proIDInPlan'])->where('statusID',8)->count();
        // dd($data['proIDInPlan']);

        $data['projectOutPlanAll'] = $data['projectAll']->whereBetween('statusID',[4,11])->where('proTypeID',4);//นับโปรเจคนอกแผน
        $data['projectCountOutPlan'] = $data['projectOutPlanAll']->count();
        $data['projectEvaCompleteOutPlan'] = $data['projectOutPlanAll']->where('statusID',8)->count();
        $data['projectEvaDeadlineOutPlan'] = $data['projectOutPlanAll']->where('statusID',9)->count(); //นับโครงการที่ปิดโครงการ/ไม่เป็นไปตามระยะเวลา
        $data['projectEvaPostponedOutPlan'] = $data['projectOutPlanAll']->where('statusID',10)->count(); //นับโครงการที่ปิดโครงการ/ขอเลื่อน
        $data['projectEvaCancleOutPlan'] = $data['projectOutPlanAll']->where('statusID',11)->count(); //นับโครงการที่ปิดโครงการ/ขอยกเลิก
        $data['proIDOutPlan'] =  $data['projectOutPlanAll']->pluck('proID');
        $data['report_quarteOutPlan'] = DB::table('report_quarters')->whereIn('proID',$data['proIDOutPlan'])->get();
        $data['report_quarterCountOutPlan'] = $data['report_quarteOutPlan']->count();
        $data['no_ReportOutPlan'] = $data['projectCountOutPlan'] -  $data['report_quarterCountOutPlan'] ;
        return view('Performance.index',compact('data'));
        
    }

    function detail(Projects $id){
        
        return redirect('/Performance',compact($id));
    }
}
