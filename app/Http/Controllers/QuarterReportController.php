<?php

namespace App\Http\Controllers;

use App\Models\KPIMainMapProjects;
use App\Models\KPIMain2LevelMapProject;
use App\Models\ProgressDetails;
use App\Models\ReportQuarters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;

class QuarterReportController extends Controller
{
    // public function quarter1($id)
    // {
    //     $data['project'] = DB::table('projects')->where('proID',$id)->first();
    //     $data['steps'] = DB::table('steps')->where('proID',$id)->get();
    //     $data['KPIMain3LV']=KPIMainMapProjects::with('KPI')->where('proID',$id)->get();
    //     $data['KPIMain2LV'] = KPIMain2LevelMapProject::with('KPI')->where('proID',$id)->get();
    //     // dd($data['KPIMain2LV']);
    //     $data['KPI'] = DB::table('k_p_i_projects')->where('proID',$id)->get();
    //     $data['costQuarter']= DB::table('cost_quarters')->where('proID',$id)->get();
    //     // dd($data['costQuarter']);

    //     $data['quarterReport']=DB::table('report_quarters')->where('proID',$id)->first();
    //     if(!empty($data['quarterReport'])){
    //         $data['detail']=DB::table('progress_details')->where('reportID',$data['quarterReport']->reportID)->get();

    //     }
    //     // dd($data['detail']);
    //     return view('QuarterlyProgressReport.quarter1-4',compact('data'));
    // }

    public function reportQuarter($id, $quarter)
    {
        $data['quarter']=$quarter;
        $data['project'] = DB::table('projects')->where('proID',$id)->first();
        $data['steps'] = DB::table('steps')->where('proID',$id)->get();
        $data['KPIMain3LV']=KPIMainMapProjects::with('KPI')->where('proID',$id)->get();
        $data['KPIMain2LV'] = KPIMain2LevelMapProject::with('KPI')->where('proID',$id)->get();
    //     // dd($data['KPIMain2LV']);
        $data['KPI'] = DB::table('k_p_i_projects')->where('proID',$id)->get();
        $data['costQuarter']= DB::table('cost_quarters')->where('proID',$id)->get();
    //     // dd($data['costQuarter']);

        $data['quarterReport']=DB::table('report_quarters')->where([['proID',$id],['quarID',$quarter]])->first();
        if(!empty($data['quarterReport'])){
            $data['detail']=DB::table('progress_details')->where('reportID',$data['quarterReport']->reportID)->get();

        }
        
        $data['evaluation'] = DB::table('project_evaluations')->where([['proID',$id]])->first();
        // dd($data['evaluation']);
    //     // dd($data['detail']);
        return view('Project.reportQuarter',compact('data'));
    }

    public function saveReportQuarter(Request $request,$id,$quarter)
    {
        $project = DB::table('projects')->where('proID',$id)->first();
        $report=[
            'quarID'=>$quarter,
            'proID'=>$project->proID,
            'userID'=> Auth::id(),
            'costResult'=>$request->costResult,
            'problem'=>$request->problem,
            'created_at'=>now(),
            'updated_at'=>now()
        ];
        $reportID = Db::table('report_quarters')->insertGetId($report);

        $detail = $request->input('detail');
        if(is_array($detail)){
            foreach($detail as $index => $item){
                DB::table('progress_details')->insert([
                    'detail'=>$item,
                    'reportID' => $reportID,
                    'updated_at' => now(), // ใช้เวลาปัจจุบันที่ Laravel รองรับ
                    'created_at' => now() 
                ]);
            }
        }
        $KPIMain3LVID = $request->KPIMain3LVID;
        $result3LV = $request->result3LV;
        $column = "result" . $quarter;
        foreach($KPIMain3LVID as $index => $KPI){
            DB::table('k_p_i_main_map_projects')
            ->where('proID',$id)
            ->where('KPIMain3LVID',$KPI)
            ->update([$column=>$result3LV[$index]]);
        }
        $KPIMain2LVID = $request->KPIMain2LVID;
        $result2LV = $request->result2LV;
        if($result2LV != null){
             foreach($KPIMain2LVID as $index => $KPI){
            DB::table('k_p_i_main2_level_map_projects')
            ->where('proID',$id)
            ->where('KPIMain2LVID',$KPI)
            ->update([$column=>$result2LV[$index]]);
        }
        }
       
        $KPIProID = $request->KPIProID;
        $result = $request->result;
        foreach($KPIProID as $index => $KPI){
            DB::table('k_p_i_projects')
            ->where('proID',$id)
            ->where('KPIProID',$KPI)
            ->update([$column=>$result[$index]]);
        }

        $user = DB::table('users')->where('Planning_Analyst',1)->first();

        Mail::to($user->email)->send(new SendMail([
            'name' => $project->name ,
            'text' => 'ผู้รับผิดชอบโครงการส่งรายงานไตรมาส'.$quarter
        ] 
        ));


        return redirect('/project');


    }
}
