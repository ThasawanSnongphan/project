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

       
        // $data['quarter'] = Quarters::find($data['selectQuarID']);

            //โครงการทั้งหมด
            $data['projectAll'] = DB::table('projects')
            ->whereBetween('projects.statusID',[4,11])
            ->where('projects.yearID',$data['selectYearID'])
            ->get();
      
        // โครงการทั้งหมด

      //นับโครงการที่ปิดโครงการ/เสร็จตามระยะเวลา
        $data['projectEvaCompleteAll'] = $data['projectAll']->where('statusID',8);
       //นับโครงการที่ปิดโครงการ/ไม่เป็นไปตามระยะเวลา
        $data['projectEvaDeadlineAll'] = $data['projectAll']->where('statusID',9);
        //นับโครงการที่ปิดโครงการ/ขอเลื่อน
        $data['projectEvaPostponedAll'] = $data['projectAll']->where('statusID',10);
       //นับโครงการที่ปิดโครงการ/ขอยกเลิก
        $data['projectEvaCancleAll'] = $data['projectAll']->where('statusID',11);
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
        

        $data['projectEvaCompleteInPlan'] = $data['projectInPlanAll']->where('statusID',8);  //นับโครงการที่ปิดโครงการ/เสร็จตามระยะเวลา
        

        $data['projectEvaDeadlineInPlan'] = $data['projectInPlanAll']->where('statusID',9); //นับโครงการที่ปิดโครงการ/ไม่เป็นไปตามระยะเวลา
        $data['projectEvaPostponedInPlan'] = $data['projectInPlanAll']->where('statusID',10); //นับโครงการที่ปิดโครงการ/ขอเลื่อน
        $data['projectEvaCancleInPlan'] = $data['projectInPlanAll']->where('statusID',11); //นับโครงการที่ปิดโครงการ/ขอยกเลิก

        $data['report_quarteInPlan'] = DB::table('report_quarters as report')
        ->join('projects','projects.proID','=','report.proID')
        ->whereBetween('projects.statusID',[4,7])
        ->where([['projects.proTypeID',3],['projects.yearID',$data['selectYearID']],['report.quarID','=',$data['selectQuarID']]])->get();
        // dd($data['report_quarteInPlan']);
        $data['proIDInPlanAll'] =  $data['projectInPlanAll']->whereBetween('statusID',[4,7])->pluck('proID');
        $data['proIDInPlan'] =  $data['projectInPlanAll']->whereNotIn('proID',$data['report_quarteInPlan']->pluck('proID'))->whereBetween('statusID',[4,7])->pluck('proID');

        
        $data['no_ReportInPlan'] = $data['proIDInPlanAll']->count() -  $data['report_quarteInPlan']->count() ;
        
        //ดึงข้อมูลโครงการตามแผน
        //เสร็จตามระยะเวลา
        $data['ID_projectEvaCompleteInPlan'] = json_decode( $request->input('projectEvaCompleteInPlan'),true); 
        if(!empty($data['ID_projectEvaCompleteInPlan'])){
            $data['report'] = DB::table('report_quarters')->whereIn('proID',$data['ID_projectEvaCompleteInPlan'])->get();
            $data['datail_projectEvaCompleteInPlan'] = ProjectEvaluation::with(['project','user'])->whereIn('proID',$data['ID_projectEvaCompleteInPlan'])->get();
            $data['KPI3LV'] = KPIMainMapProjects::with('KPI')->whereIn('proID',$data['ID_projectEvaCompleteInPlan'])->get();
            $data['KPI2LV'] = KPIMain2LevelMapProject::with('KPI')->whereIn('proID',$data['ID_projectEvaCompleteInPlan'])->get();
            $data['KPIProject'] = KPIProjects::with('count')->whereIn('proID',$data['ID_projectEvaCompleteInPlan'])->get();     
        }
        //ไม่เป็นไปตามระยะเวลา
        $data['ID_projectEvaDeadlineInPlan'] = json_decode( $request->input('projectEvaDeadlineInPlan'),true); 
        if(!empty($data['ID_projectEvaDeadlineInPlan'])){
            $data['report'] = DB::table('report_quarters')->whereIn('proID',$data['ID_projectEvaDeadlineInPlan'])->get();
            $data['datail_projectEvaDeadlineInPlan'] = ProjectEvaluation::with(['project','user'])->whereIn('proID',$data['ID_projectEvaDeadlineInPlan'])->get();
            $data['KPI3LV'] = KPIMainMapProjects::with('KPI')->whereIn('proID',$data['ID_projectEvaDeadlineInPlan'])->get();
            $data['KPI2LV'] = KPIMain2LevelMapProject::with('KPI')->whereIn('proID',$data['ID_projectEvaDeadlineInPlan'])->get();
            $data['KPIProject'] = KPIProjects::with('count')->whereIn('proID',$data['ID_projectEvaDeadlineInPlan'])->get();     
        }
        //ขอเลื่อน
        $data['ID_projectEvaPostponedInPlan'] = json_decode( $request->input('projectEvaPostponedInPlan'),true); 
        if(!empty($data['ID_projectEvaPostponedInPlan'])){
            $data['report'] = DB::table('report_quarters')->whereIn('proID',$data['ID_projectEvaPostponedInPlan'])->get();
            $data['datail_projectEvaPostponedInPlan'] = ProjectEvaluation::with(['project','user'])->whereIn('proID',$data['ID_projectEvaPostponedInPlan'])->get();
            $data['KPI3LV'] = KPIMainMapProjects::with('KPI')->whereIn('proID',$data['ID_projectEvaPostponedInPlan'])->get();
            $data['KPI2LV'] = KPIMain2LevelMapProject::with('KPI')->whereIn('proID',$data['ID_projectEvaPostponedInPlan'])->get();
            $data['KPIProject'] = KPIProjects::with('count')->whereIn('proID',$data['ID_projectEvaPostponedInPlan'])->get();     
        }
        //ขอยกเลิก
        $data['ID_projectEvaCancleInPlan'] = json_decode( $request->input('projectEvaCancleInPlan'),true); 
        if(!empty($data['ID_projectEvaCancleInPlan'])){
            $data['report'] = DB::table('report_quarters')->whereIn('proID',$data['ID_projectEvaCancleInPlan'])->get();
            $data['datail_projectEvaCancleInPlan'] = ProjectEvaluation::with(['project','user'])->whereIn('proID',$data['ID_projectEvaCancleInPlan'])->get();
            $data['KPI3LV'] = KPIMainMapProjects::with('KPI')->whereIn('proID',$data['ID_projectEvaCancleInPlan'])->get();
            $data['KPI2LV'] = KPIMain2LevelMapProject::with('KPI')->whereIn('proID',$data['ID_projectEvaCancleInPlan'])->get();
            $data['KPIProject'] = KPIProjects::with('count')->whereIn('proID',$data['ID_projectEvaCancleInPlan'])->get();     
        }
        //ดำเนินการ
        $data['ID_report_quarteInPlan'] =json_decode( $request->input('detail_report_quar'),true); 
        if(!empty( $data['ID_report_quarteInPlan'])){
            $data['report'] = DB::table('report_quarters')->whereIn('proID',$data['ID_report_quarteInPlan'])->get();
            $data['detail_report_quarteInPlan'] = ReportQuarters::with(['project','user'])->whereIn('proID', $data['ID_report_quarteInPlan'])->get();
            $data['KPI3LV'] = KPIMainMapProjects::with('KPI')->whereIn('proID',$data['ID_report_quarteInPlan'])->get();
            $data['KPI2LV'] = KPIMain2LevelMapProject::with('KPI')->whereIn('proID',$data['ID_report_quarteInPlan'])->get();
            $data['KPIProject'] = KPIProjects::with('count')->whereIn('proID',$data['ID_report_quarteInPlan'])->get();
        }
        //ยังไม่รายงานผล
        $data['ID_no_ReportInPlan'] = json_decode( $request->input('no_ReportInPlan'),true);   
        if(!empty($data['ID_no_ReportInPlan'])){
            // dd($data['ID_no_ReportInPlan']);
            $data['datail_no_ReportInPlan'] = Projects::with('status')
            ->join('users_map_projects as map','map.proID','=','projects.proID')
            ->join('users','users.userID','=','map.userID')->whereIn('projects.proID',$data['ID_no_ReportInPlan'])->get();
            // dd($data['datail_no_ReportInPlan']);
            $data['KPI3LV'] = KPIMainMapProjects::with('KPI')->whereIn('proID',$data['ID_no_ReportInPlan'])->get();
            $data['KPI2LV'] = KPIMain2LevelMapProject::with('KPI')->whereIn('proID',$data['ID_no_ReportInPlan'])->get();
            $data['KPIProject'] = KPIProjects::with('count')->whereIn('proID',$data['ID_no_ReportInPlan'])->get();      
        }

        //โครงการนอกแผนปฏิบัติ
        $data['projectOutPlanAll'] = $data['projectAll']->whereBetween('statusID',[4,11])->where('proTypeID',4);//นับโปรเจคนอกแผน
        $data['projectEvaCompleteOutPlan'] = $data['projectOutPlanAll']->where('statusID',8);
        $data['projectEvaDeadlineOutPlan'] = $data['projectOutPlanAll']->where('statusID',9); //นับโครงการที่ปิดโครงการ/ไม่เป็นไปตามระยะเวลา
        $data['projectEvaPostponedOutPlan'] = $data['projectOutPlanAll']->where('statusID',10); //นับโครงการที่ปิดโครงการ/ขอเลื่อน
        $data['projectEvaCancleOutPlan'] = $data['projectOutPlanAll']->where('statusID',11); //นับโครงการที่ปิดโครงการ/ขอยกเลิก
        
        // $data['report_quarteOutPlan'] = DB::table('report_quarters')->whereIn('proID',$data['proIDOutPlan'])->get();
        $data['report_quarteOutPlan'] = DB::table('report_quarters as report')
        ->join('projects','projects.proID','=','report.proID')
        ->whereBetween('projects.statusID',[4,7])
        ->where([['projects.proTypeID',4],['projects.yearID',$data['selectYearID']],['report.quarID','=',$data['selectQuarID']]])->get();
        
        $data['proIDOutPlanAll'] =  $data['projectOutPlanAll']->whereBetween('statusID',[4,7])->pluck('proID');
        $data['proIDOutPlan'] =  $data['projectOutPlanAll']->whereNotIn('proID',$data['report_quarteOutPlan']->pluck('proID'))->whereBetween('statusID',[4,7])->pluck('proID');
        
        $data['no_ReportOutPlan'] = $data['proIDOutPlan']->count() -  $data['report_quarteOutPlan']->count() ;

        //ดึงข้อมูลโครงการนอกแผน
        //เสร็จตามระยะเวลา
        $data['ID_projectEvaCompleteOutPlan'] = json_decode( $request->input('projectEvaCompleteOutPlan'),true);
        if(!empty($data['ID_projectEvaCompleteOutPlan'])){
            $data['report'] = DB::table('report_quarters')->whereIn('proID',$data['ID_projectEvaCompleteOutPlan'])->get();
            $data['datail_projectEvaCompleteOutPlan'] = ProjectEvaluation::with(['project','user'])->whereIn('proID',$data['ID_projectEvaCompleteOutPlan'])->get();
            $data['KPI3LV'] = KPIMainMapProjects::with('KPI')->whereIn('proID',$data['ID_projectEvaCompleteOutPlan'])->get();
            $data['KPI2LV'] = KPIMain2LevelMapProject::with('KPI')->whereIn('proID',$data['ID_projectEvaCompleteOutPlan'])->get();
            $data['KPIProject'] = KPIProjects::with('count')->whereIn('proID',$data['ID_projectEvaCompleteOutPlan'])->get();
        }
        //ไม่เป้นไปตามระยะเวลา
        $data['ID_projectEvaDeadlineOutPlan'] = json_decode( $request->input('projectEvaDeadlineOutPlan'),true); 
        if(!empty($data['ID_projectEvaDeadlineOutPlan'])){
            $data['report'] = DB::table('report_quarters')->whereIn('proID',$data['ID_projectEvaDeadlineOutPlan'])->get();
            $data['datail_projectEvaDeadlineOutPlan'] = ProjectEvaluation::with(['project','user'])->whereIn('proID',$data['ID_projectEvaDeadlineOutPlan'])->get();
            $data['KPI3LV'] = KPIMainMapProjects::with('KPI')->whereIn('proID',$data['ID_projectEvaDeadlineOutPlan'])->get();
            $data['KPI2LV'] = KPIMain2LevelMapProject::with('KPI')->whereIn('proID',$data['ID_projectEvaDeadlineOutPlan'])->get();
            $data['KPIProject'] = KPIProjects::with('count')->whereIn('proID',$data['ID_projectEvaDeadlineOutPlan'])->get();     
        }
        //ขอเลื่อน
        $data['ID_projectEvaPostponedOutPlan'] = json_decode( $request->input('projectEvaPostponedOutPlan'),true); 
        if(!empty($data['ID_projectEvaPostponedOutPlan'])){
            $data['report'] = DB::table('report_quarters')->whereIn('proID',$data['ID_projectEvaPostponedOutPlan'])->get();
            $data['datail_projectEvaPostponedOutPlan'] = ProjectEvaluation::with(['project','user'])->whereIn('proID',$data['ID_projectEvaPostponedOutPlan'])->get();
            $data['KPI3LV'] = KPIMainMapProjects::with('KPI')->whereIn('proID',$data['ID_projectEvaPostponedOutPlan'])->get();
            $data['KPI2LV'] = KPIMain2LevelMapProject::with('KPI')->whereIn('proID',$data['ID_projectEvaPostponedOutPlan'])->get();
            $data['KPIProject'] = KPIProjects::with('count')->whereIn('proID',$data['ID_projectEvaPostponedOutPlan'])->get();     
        }
        //ขอยกเลิก
        $data['ID_projectEvaCancleOutPlan'] = json_decode( $request->input('projectEvaCancleOutPlan'),true); 
        if(!empty($data['ID_projectEvaCancleOutPlan'])){
            $data['report'] = DB::table('report_quarters')->whereIn('proID',$data['ID_projectEvaCancleOutPlan'])->get();
            $data['datail_projectEvaCancleOutPlan'] = ProjectEvaluation::with(['project','user'])->whereIn('proID',$data['ID_projectEvaCancleOutPlan'])->get();
            $data['KPI3LV'] = KPIMainMapProjects::with('KPI')->whereIn('proID',$data['ID_projectEvaCancleOutPlan'])->get();
            $data['KPI2LV'] = KPIMain2LevelMapProject::with('KPI')->whereIn('proID',$data['ID_projectEvaCancleOutPlan'])->get();
            $data['KPIProject'] = KPIProjects::with('count')->whereIn('proID',$data['ID_projectEvaCancleOutPlan'])->get();     
        }
        //ดำเนินการ
        $data['ID_report_quarteOutPlan'] =json_decode( $request->input('report_quarteOutPlan'),true); 
        if(!empty( $data['ID_report_quarteInPlan'])){
            $data['report'] = DB::table('report_quarters')->whereIn('proID',$data['ID_report_quarteInPlan'])->get();
            $data['detail_report_quarteInPlan'] = ReportQuarters::with(['project','user'])->whereIn('proID', $data['ID_report_quarteInPlan'])->get();
            $data['KPI3LV'] = KPIMainMapProjects::with('KPI')->whereIn('proID',$data['ID_report_quarteInPlan'])->get();
            $data['KPI2LV'] = KPIMain2LevelMapProject::with('KPI')->whereIn('proID',$data['ID_report_quarteInPlan'])->get();
            $data['KPIProject'] = KPIProjects::with('count')->whereIn('proID',$data['ID_report_quarteInPlan'])->get();
        }
        //ยังไม่รายงานผล
        $data['ID_no_ReportOutPlan'] = json_decode( $request->input('no_ReportOutPlan'),true);   
        if(!empty($data['ID_no_ReportOutPlan'])){
            $data['datail_no_ReportInPlan'] = Projects::with('status')
            ->join('users_map_projects as map','map.proID','=','projects.proID')
            ->join('users','users.userID','=','map.userID')->whereIn('projects.proID',$data['ID_no_ReportOutPlan'])->get();
            $data['KPI3LV'] = KPIMainMapProjects::with('KPI')->whereIn('proID',$data['ID_no_ReportOutPlan'])->get();
            $data['KPI2LV'] = KPIMain2LevelMapProject::with('KPI')->whereIn('proID',$data['ID_no_ReportOutPlan'])->get();
            $data['KPIProject'] = KPIProjects::with('count')->whereIn('proID',$data['ID_no_ReportOutPlan'])->get();      
        }

    return view('Performance.index',compact('data'));
    }

    function supportPlan(Request $request){
        $data['yearAll'] = Year::all();
        $data['quarterAll'] = Quarters::all();
        $data['selectYearID'] = $request->input('yearID'); //yearID
        $data['selectQuarID'] = $request->input('quarID'); //quarID

        $data['year'] = Year::find($data['selectYearID']);  //แสดงปีที่เลือก
        $data['quarter'] = Quarters::find($data['selectQuarID']);

        //KPi ทั้งหมด
        $data['report_q'] = DB::table('report_quarters')
        ->join('projects','projects.proID','=','report_quarters.proID')
        ->leftJoin('k_p_i_main_map_projects','k_p_i_main_map_projects.proID','=','projects.proID')
        ->leftJoin('k_p_i_main2_level_map_projects','k_p_i_main2_level_map_projects.proID','=','projects.proID')
        ->where('projects.yearID',$data['selectYearID'])
        ->where('quarID',$data['selectQuarID'])
        ->get();
            // dd($data['report_q']);
        
        //บรรลุ
        
        
        return view('Performance.supportPlan',compact('data'));
    }
   
}