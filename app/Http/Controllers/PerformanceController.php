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

       
            $data['quarter'] = Quarters::find($data['selectQuarID']);

            //โครงการทั้งหมด
            $data['projectAll'] = DB::table('projects')
            ->whereBetween('projects.statusID',[4,11])
            ->where('projects.yearID',$data['selectYearID'])
            ->get();
            
            // $data['proID'] = $data['projectAll']->pluck('proID');
            // dd($data['proID']);
        // โครงการทั้งหมด

        // $data['projectEvaCompleteAll'] = DB::table('projects')
        // ->join('report_quarters as report','report.proID','=','projects.proID')
        // ->join('project_evaluations as eva','eva.proID','=','projects.proID')
        // ->whereBetween('projects.statusID',[4,11])
        // ->where([['projects.statusID',8],['projects.yearID',$data['selectYearID']],['report.quarID','=',$data['selectQuarID']]])
        // ->get(); //นับโครงการที่ปิดโครงการ/เสร็จตามระยะเวลา
        $data['projectEvaCompleteAll'] = $data['projectAll']->where('statusID',8);
        // dd($data['projectEvaCompleteAll']);
        // dd($data['projectEvaCompleteAll']);

        // $data['projectEvaDeadlineAll'] = DB::table('projects')
        // ->join('report_quarters as report','report.proID','=','projects.proID')
        // ->join('project_evaluations as eva','eva.proID','=','projects.proID')
        // ->whereBetween('projects.statusID',[4,11])
        // ->where([['projects.statusID',9],['projects.yearID',$data['selectYearID']],['report.quarID','=',$data['selectQuarID']]])
        // ->get(); //นับโครงการที่ปิดโครงการ/ไม่เป็นไปตามระยะเวลา
        $data['projectEvaDeadlineAll'] = $data['projectAll']->where('statusID',9);

        // $data['projectEvaPostponedAll'] = DB::table('projects')
        // ->join('report_quarters as report','report.proID','=','projects.proID')
        // ->join('project_evaluations as eva','eva.proID','=','projects.proID')
        // ->whereBetween('projects.statusID',[4,11])
        // ->where([['projects.statusID',10],['projects.yearID',$data['selectYearID']],['report.quarID','=',$data['selectQuarID']]])
        // ->get(); //นับโครงการที่ปิดโครงการ/ขอเลื่อน
        $data['projectEvaPostponedAll'] = $data['projectAll']->where('statusID',10);

        // $data['projectEvaCancleAll'] = DB::table('projects')
        // ->join('report_quarters as report','report.proID','=','projects.proID')
        // ->join('project_evaluations as eva','eva.proID','=','projects.proID')
        // ->whereBetween('projects.statusID',[4,11])
        // ->where([['projects.statusID',11],['projects.yearID',$data['selectYearID']],['report.quarID','=',$data['selectQuarID']]])
        // ->get(); //นับโครงการที่ปิดโครงการ/ขอยกเลิก
        $data['projectEvaCancleAll'] = $data['projectAll']->where('statusID',11);
        
        // $data['proIDAll'] = $data['projectAll']->whereBetween('statusID',[4,7])->pluck('proID');
        // $data['proIDAll'] = DB::table('projects')
        // ->whereBetween('statusID',[4,7])
        // ->where([['projects.yearID',$data['selectYearID']],['report.quarID','=',$data['selectQuarID']]])
        // ->get();
        // dd($data['proIDAll'] );
       
        // dd($data['xx'] );
        $data['report_quarterAll'] = DB::table('report_quarters as report')
        ->join('projects','projects.proID','=','report.proID')
        ->whereBetween('projects.statusID',[4,7])
        ->where([['projects.yearID',$data['selectYearID']],['report.quarID','=',$data['selectQuarID']]])->get();
        // dd($data['report_quarterAll']);
        // ->where('proID',$data['proIDAll'])->get();
        $data['xx'] = DB::table('projects')
        ->whereBetween('statusID',[4,7])
        ->where('yearID',$data['selectYearID'])->get();
        $data['no_ReportAll'] = $data['xx']->count() -  $data['report_quarterAll']->count() ;
        
        //โครงการตามแผนปฏิบัติ
        $data['projectInPlanAll'] = $data['projectAll']->whereBetween('statusID',[4,11])->where('proTypeID',3);//นับโปรเจคตามแผน
        

        $data['projectEvaCompleteInPlan'] = $data['projectInPlanAll']->where('statusID',8)->pluck('proID');  
        $data['projectEvaCompleteInPlanCount'] = $data['projectInPlanAll']->where('statusID',8)->count();  //นับโครงการที่ปิดโครงการ/เสร็จตามระยะเวลา

        $data['projectEvaDeadlineInPlan'] = $data['projectInPlanAll']->where('statusID',9)->count(); //นับโครงการที่ปิดโครงการ/ไม่เป็นไปตามระยะเวลา
        $data['projectEvaPostponedInPlan'] = $data['projectInPlanAll']->where('statusID',10)->count(); //นับโครงการที่ปิดโครงการ/ขอเลื่อน
        $data['projectEvaCancleInPlan'] = $data['projectInPlanAll']->where('statusID',11)->count(); //นับโครงการที่ปิดโครงการ/ขอยกเลิก

        $data['report_quarteInPlan'] = DB::table('report_quarters as report')
        ->join('projects','projects.proID','=','report.proID')
        ->whereBetween('projects.statusID',[4,7])
        ->where([['projects.proTypeID',3],['projects.yearID',$data['selectYearID']],['report.quarID','=',$data['selectQuarID']]])->get();
        
        $data['proIDInPlan'] =  $data['projectInPlanAll']->whereBetween('statusID',[4,7])->pluck('proID'); 
        // $data['report_quarteInPlan'] = DB::table('report_quarters')->whereIn('proID',$data['proIDInPlan'])->get();
        $data['report_quarterCountInPlan'] = $data['report_quarteInPlan']->count();
        $data['no_ReportInPlan'] = $data['proIDInPlan']->count() -  $data['report_quarterCountInPlan'] ;
        
        //ดึงข้อมูลโครงการตามแผน
        $data['ID_report_quarteInPlan'] =json_decode( $request->input('detail_report_quar'),true); 
        // dd($data['ID_report_quarteInPlan']);
        if(!empty( $data['ID_report_quarteInPlan'])){
            $data['report'] = DB::table('report_quarters')->whereIn('proID',$data['ID_report_quarteInPlan'])->get();
            $data['detail_report_quarteInPlan'] = ReportQuarters::with(['project','user'])->whereIn('proID', $data['ID_report_quarteInPlan'])->get();
            $data['KPI3LV'] = KPIMainMapProjects::with('KPI')->whereIn('proID',$data['ID_report_quarteInPlan'])->get();
            $data['KPI2LV'] = KPIMain2LevelMapProject::with('KPI')->whereIn('proID',$data['ID_report_quarteInPlan'])->get();
            $data['KPIProject'] = KPIProjects::with('count')->whereIn('proID',$data['ID_report_quarteInPlan'])->get();
        }

        $data['ID_projectEvaCompleteInPlan'] = json_decode( $request->input('projectEvaCompleteInPlan'),true);
        
        if(!empty($data['ID_projectEvaCompleteInPlan'])){
            $data['report'] = DB::table('report_quarters')->whereIn('proID',$data['ID_projectEvaCompleteInPlan'])->get();
            $data['datail_projectEvaCompleteInPlan'] = ProjectEvaluation::with(['project','user'])->whereIn('proID',$data['ID_projectEvaCompleteInPlan'])->get();
            $data['KPI3LV'] = KPIMainMapProjects::with('KPI')->whereIn('proID',$data['ID_projectEvaCompleteInPlan'])->get();
            $data['KPI2LV'] = KPIMain2LevelMapProject::with('KPI')->whereIn('proID',$data['ID_projectEvaCompleteInPlan'])->get();
            $data['KPIProject'] = KPIProjects::with('count')->whereIn('proID',$data['ID_projectEvaCompleteInPlan'])->get();
            // dd($data['datail_projectEvaCompleteInPlan'] );
            
        }

        //โครงการนอกแผนปฏิบัติ
        $data['projectOutPlanAll'] = $data['projectAll']->whereBetween('statusID',[4,11])->where('proTypeID',4);//นับโปรเจคนอกแผน
        $data['projectEvaCompleteOutPlan'] = $data['projectOutPlanAll']->where('statusID',8);
        $data['projectEvaDeadlineOutPlan'] = $data['projectOutPlanAll']->where('statusID',9); //นับโครงการที่ปิดโครงการ/ไม่เป็นไปตามระยะเวลา
        $data['projectEvaPostponedOutPlan'] = $data['projectOutPlanAll']->where('statusID',10); //นับโครงการที่ปิดโครงการ/ขอเลื่อน
        $data['projectEvaCancleOutPlan'] = $data['projectOutPlanAll']->where('statusID',11); //นับโครงการที่ปิดโครงการ/ขอยกเลิก
        $data['proIDOutPlan'] =  $data['projectOutPlanAll']->whereBetween('statusID',[4,7])->pluck('proID');
        
        // $data['report_quarteOutPlan'] = DB::table('report_quarters')->whereIn('proID',$data['proIDOutPlan'])->get();
        $data['report_quarteOutPlan'] = DB::table('report_quarters as report')
        ->join('projects','projects.proID','=','report.proID')
        ->whereBetween('projects.statusID',[4,7])
        ->where([['projects.proTypeID',4],['projects.yearID',$data['selectYearID']],['report.quarID','=',$data['selectQuarID']]])->get();
        
        // $data['proIDOutPlan'] = 
        $data['no_ReportOutPlan'] = $data['proIDOutPlan']->count() -  $data['report_quarteOutPlan']->count() ;

        //ดึงข้อมูลโครงการนอกแผน
        $data['ID_projectEvaCompleteOutPlan'] = json_decode( $request->input('projectEvaCompleteOutPlan'),true);
        // dd($data['ID_projectEvaCompleteOutPlan']);
        if(!empty($data['ID_projectEvaCompleteOutPlan'])){
            $data['report'] = DB::table('report_quarters')->whereIn('proID',$data['ID_projectEvaCompleteOutPlan'])->get();
            // dd($data['report']);
            $data['datail_projectEvaCompleteOutPlan'] = ProjectEvaluation::with(['project','user'])->whereIn('proID',$data['ID_projectEvaCompleteOutPlan'])->get();
            $data['KPI3LV'] = KPIMainMapProjects::with('KPI')->whereIn('proID',$data['ID_projectEvaCompleteOutPlan'])->get();
            $data['KPI2LV'] = KPIMain2LevelMapProject::with('KPI')->whereIn('proID',$data['ID_projectEvaCompleteOutPlan'])->get();
            $data['KPIProject'] = KPIProjects::with('count')->whereIn('proID',$data['ID_projectEvaCompleteOutPlan'])->get();
            // dd($data['datail_projectEvaCompleteInPlan'] );     
        }

    return view('Performance.index',compact('data'));
    }

   
}