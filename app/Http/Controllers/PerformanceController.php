<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectEvaluation;
use App\Models\Projects;
use App\Models\Year;
use App\Models\Quarters;
use App\Models\ReportQuarters;
use App\Models\KPIMainMapProjects;
use App\Models\KPIMain2LevelMapProject;
use App\Models\KPIProjects;
use Illuminate\Support\Facades\DB;

class PerformanceController extends Controller
{
    function index(Request $request){

        $data['yearAll'] = Year::all();
        $data['quarterAll'] = Quarters::all();
        $data['selectYearID'] = $request->input('yearID'); //yearID
        $data['selectQuarID'] = $request->input('quarID'); //quarID

        $data['year'] = Year::find($data['selectYearID']);  //แสดงปีที่เลือก
        $data['quarter'] = Quarters::find($data['selectQuarID']);

        //โครงการทั้งหมด
        $data['projectAll'] = DB::table('projects')
        ->join('report_quarters','report_quarters.proID','=','projects.proID')
        ->where('projects.yearID',$data['selectYearID'])
        ->where('report_quarters.quarID',$data['selectQuarID'])
        ->get();
        // dd($data['join']);
        // $data['projectAll'] = Projects::with(['projectType','status'])->where('yearID',$data['selectYearID'])->whereBetween('statusID',[4,11])->get(); 
        $data['projectCountAll']  = $data['projectAll']->count(); //นับโครงการทั้งหมด
        $data['projectEvaCompleteAll'] = $data['projectAll']->where('statusID',8)->count(); //นับโครงการที่ปิดโครงการ/เสร็จตามระยะเวลา
        $data['projectEvaDeadlineAll'] = $data['projectAll']->where('statusID',9)->count(); //นับโครงการที่ปิดโครงการ/ไม่เป็นไปตามระยะเวลา
        $data['projectEvaPostponedAll'] = $data['projectAll']->where('statusID',10)->count(); //นับโครงการที่ปิดโครงการ/ขอเลื่อน
        $data['projectEvaCancleAll'] = $data['projectAll']->where('statusID',11)->count(); //นับโครงการที่ปิดโครงการ/ขอยกเลิก
        $data['proIDAll'] =  $data['projectAll']->whereBetween('statusID',[4,7])->pluck('proID');
        $data['report_quarterAll'] = DB::table('report_quarters')->whereIn('proID',$data['proIDAll'])->get();
        $data['report_quarterCountAll'] = $data['report_quarterAll']->count();
        $data['no_ReportAll'] = $data['proIDAll']->count() -  $data['report_quarterCountAll'] ;
        
        //โครงการตามแผนปฏิบัติ
        $data['projectInPlanAll'] = $data['projectAll']->whereBetween('statusID',[4,11])->where('proTypeID',3);//นับโปรเจคตามแผน
        $data['projectCountInPlan'] = $data['projectInPlanAll']->count();//นับโปรเจคตามแผน

        $data['projectEvaCompleteInPlan'] = $data['projectInPlanAll']->where('statusID',8)->pluck('proID');  
        $data['projectEvaCompleteInPlanCount'] = $data['projectInPlanAll']->where('statusID',8)->count();  //นับโครงการที่ปิดโครงการ/เสร็จตามระยะเวลา

        $data['projectEvaDeadlineInPlan'] = $data['projectInPlanAll']->where('statusID',9)->count(); //นับโครงการที่ปิดโครงการ/ไม่เป็นไปตามระยะเวลา
        $data['projectEvaPostponedInPlan'] = $data['projectInPlanAll']->where('statusID',10)->count(); //นับโครงการที่ปิดโครงการ/ขอเลื่อน
        $data['projectEvaCancleInPlan'] = $data['projectInPlanAll']->where('statusID',11)->count(); //นับโครงการที่ปิดโครงการ/ขอยกเลิก
        $data['proIDInPlan'] =  $data['projectInPlanAll']->whereBetween('statusID',[4,7])->pluck('proID'); 
        $data['report_quarteInPlan'] = DB::table('report_quarters')->whereIn('proID',$data['proIDInPlan'])->get();
        $data['report_quarterCountInPlan'] = $data['report_quarteInPlan']->count();
        $data['no_ReportInPlan'] = $data['proIDInPlan']->count() -  $data['report_quarterCountInPlan'] ;
        //ดึงข้อมูล
        $data['ID_report_quarteInPlan'] =json_decode( $request->input('detail_report_quar'),true);
        if(!empty( $data['ID_report_quarteInPlan'])){
            $data['detail_report_quarteInPlan'] = ReportQuarters::with(['project','user'])->whereIn('proID', $data['ID_report_quarteInPlan'])->get();
            $data['KPI3LV'] = KPIMainMapProjects::with('KPI')->whereIn('proID',$data['ID_report_quarteInPlan'])->get();
            $data['KPI2LV'] = KPIMain2LevelMapProject::with('KPI')->whereIn('proID',$data['ID_report_quarteInPlan'])->get();
            $data['KPIProject'] = KPIProjects::with('count')->whereIn('proID',$data['ID_report_quarteInPlan'])->get();
        }

        $data['ID_projectEvaCompleteInPlan'] = json_decode( $request->input('projectEvaCompleteInPlan'),true);
        if(!empty($data['ID_projectEvaCompleteInPlan'])){
            $data['datail_projectEvaCompleteInPlan'] = ProjectEvaluation::with(['project','user'])->whereIn('proID',$data['ID_projectEvaCompleteInPlan'])->get();
            $data['KPI3LV'] = KPIMainMapProjects::with('KPI')->whereIn('proID',$data['ID_projectEvaCompleteInPlan'])->get();
            $data['KPI2LV'] = KPIMain2LevelMapProject::with('KPI')->whereIn('proID',$data['ID_projectEvaCompleteInPlan'])->get();
            $data['KPIProject'] = KPIProjects::with('count')->whereIn('proID',$data['ID_projectEvaCompleteInPlan'])->get();
            // dd($data['datail_projectEvaCompleteInPlan'] );
            
        }

        //โครงการนอกแผนปฏิบัติ
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

   
}
