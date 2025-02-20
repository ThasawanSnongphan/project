<?php

namespace App\Http\Controllers;

use App\Models\KPIMainMapProjects;
use App\Models\KPIMain2LevelMapProject;
use App\Models\ProgressDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuarterReportController extends Controller
{
    public function quarter2($id)
    {
        $data['project'] = DB::table('projects')->where('proID',$id)->first();
        $data['steps'] = DB::table('steps')->where('proID',$id)->get();
        $data['KPIMain3LV']=KPIMainMapProjects::with('KPI')->where('proID',$id)->get();
        $data['KPIMain2LV'] = KPIMain2LevelMapProject::with('KPI')->where('proID',$id)->get();
        // dd($data['KPIMain2LV']);
        $data['KPI'] = DB::table('k_p_i_projects')->where('proID',$id)->get();
        $data['costQuarter']= DB::table('cost_quarters')->where('proID',$id)->get();
        // dd($data['costQuarter']);
        return view('QuarterlyProgressReport.quarter2',compact('data'));
    }

    public function saveQuarter2(Request $request,$id)
    {
        $project = DB::table('projects')->where('proID',$id)->first();
        $report=[
            'quarID'=>2,
            'proID'=>$project->proID,
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
        foreach($KPIMain3LVID as $index => $KPI){
            DB::table('k_p_i_main_map_projects')
            ->where('proID',$id)
            ->where('KPIMain3LVID',$KPI)
            ->update(['result2'=>$result3LV[$index]]);
        }
        $KPIMain2LVID = $request->KPIMain2LVID;
        $result2LV = $request->result2LV;
        foreach($KPIMain2LVID as $index => $KPI){
            DB::table('k_p_i_main2_level_map_projects')
            ->where('proID',$id)
            ->where('KPIMain2LVID',$KPI)
            ->update(['result2'=>$result2LV[$index]]);
        }
        $KPIProID = $request->KPIProID;
        $result = $request->result;
        foreach($KPIProID as $index => $KPI){
            DB::table('k_p_i_projects')
            ->where('proID',$id)
            ->where('KPIProID',$KPI)
            ->update(['result2'=>$result[$index]]);
        }


        return redirect('/project');


    }
}
