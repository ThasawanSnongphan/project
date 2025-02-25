<?php

namespace App\Http\Controllers;

use App\Models\Objectives;
use App\Models\Projects;
use App\Models\StrategicMap;
use App\Models\Strategic2LevelMapProject;
use App\Models\Strategic1LevelMapProject;
use App\Models\OperatingResults;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProjectEvalutionController extends Controller
{
    public function evaluation($id){
        $data['project'] = Projects::with('badgetType')->where('proID',$id)->first();
        // dd($data['project']);
        $data['file'] = DB::table('files')->where('proID',$id)->get();

        $data['stra3LVMap'] = StrategicMap::with(['Stra3LV','SFA3LV','goal3LV','tac3LV'])->where('proID',$id)->get();
        $data['stra2LVMap']=Strategic2LevelMapProject::with(['stra2LV','SFA2LV','tac2LV'])->where('proID',$id)->get();
        $data['stra1LVMap'] = Strategic1LevelMapProject::with(['stra1LV','tar1LV'])->where('proID',$id)->get();
        
        $data['stepStart'] = DB::table('steps')->where('proID',$id)->orderBy('start' ,'ASC')->first();
        $data['stepStartFormat'] = Carbon::parse($data['stepStart']->start)
        ->locale('th')  // ตั้งค่าภาษาไทย
        ->translatedFormat('j F Y');
        
        $data['stepEnd']= DB::table('steps')->where('proID',$id)->orderBy('end' ,'desc')->first();
        $data['stepEndFormat'] = Carbon::parse($data['stepEnd']->end)
        ->locale('th')  // ตั้งค่าภาษาไทย
        ->translatedFormat('j F Y');
        
        // dd($data['stepStart'],$data['stepEnd']);
        $data['obj']=DB::table('objectives')->where('proID',$id)->get();
        $data['operating'] = OperatingResults::all();
        $data['KPIProject']=DB::table('k_p_i_projects')->where('proID',$id)->get();
        return view('ProjectEvaluation.create',compact('data'));
    }

    public function savefile(Request $request, $id)
    {
        if($request->hasFile('file')){
            $file = $request->file('file');
            // dd($file);
            $files=[
                'name' => $file->getClientOriginalName(),
                'proID' => $id,
                'updated_at' => now(), 
                'created_at' => now(),
            ];
            DB::table('files')->insert($files);
            $file->move(public_path('files'),$file->getClientOriginalName());
        }

        return redirect('/projectEvaluation/'. $id);
       
    }
    public function save(Request $request, $id)
    {
        $evaluation = [
            'proID' => $id,
            'statement' => $request->input('statement'),
            'implementation' => $request->input('implement'),
            'operID' => $request->operating,
            'since'=> $request->input('since') ?? null,
            'badget_use' => $request->input('badget_use'),
            'benefit' => $request->input('benefit'),
            'problem' => $request->input('problem'),
            'corrective_actions' => $request->input('corrective'),
            'created_at' => now(),
            'updated_at'=> now()
        ];
        DB::table('project_evaluations')->insert($evaluation);
        
        $data['obj'] = DB::table('objectives')->where('proID',$id)->get();
        foreach($data['obj'] as $index => $item){
            $obj_achieve[$index] = $request->input('obj_'.$item->objID);
            DB::table('objectives')->where('objID',$item->objID)->update(['achieve' => $obj_achieve[$index]]);
        }

        $data['KPI'] = DB::table('k_p_i_projects')->where('proID',$id)->get();
        foreach($data['KPI'] as $index =>  $item){
            $result_eva = $request->input('result_eva');
            DB::table('k_p_i_projects')->where('KPIProID',$item->KPIProID)->update(['result_eva' => $result_eva[$index]]);
        }
        // dd($data['result_eva']);
       
        // dd($obj_achieve);

        return  redirect('/project');
    }

    public function edit($id){
        $data['file'] = DB::table('files')->where('proID',$id)->get();

        $data['project']= Projects::with('badgetType')->where('proID',$id)->first();
        $data['stra3LVMap'] = StrategicMap::with(['Stra3LV','SFA3LV','goal3LV','tac3LV'])->where('proID',$id)->get();
        $data['stra2LVMap']=Strategic2LevelMapProject::with(['stra2LV','SFA2LV','tac2LV'])->where('proID',$id)->get();
        $data['stra1LVMap'] = Strategic1LevelMapProject::with(['stra1LV','tar1LV'])->where('proID',$id)->get();
        $data['evaluation'] = DB::table('project_evaluations')->where('proID',$id)->first();

        $data['stepStart'] = DB::table('steps')->where('proID',$id)->orderBy('start' ,'ASC')->first();
        $data['stepStartFormat'] = Carbon::parse($data['stepStart']->start)
        ->locale('th')  // ตั้งค่าภาษาไทย
        ->translatedFormat('j F Y');
        
        $data['stepEnd']= DB::table('steps')->where('proID',$id)->orderBy('end' ,'desc')->first();
        $data['stepEndFormat'] = Carbon::parse($data['stepEnd']->end)
        ->locale('th')  // ตั้งค่าภาษาไทย
        ->translatedFormat('j F Y');

        $data['obj']=DB::table('objectives')->where('proID',$id)->get();
        $data['operating'] = OperatingResults::all();
        $data['KPIProject']=DB::table('k_p_i_projects')->where('proID',$id)->get();



        return view('ProjectEvaluation.update',compact('data'));
    }

    public function update(Request $request, $id){
        $evaluation = [
            'implementation' => $request->input('implement'),
            'operID' => $request->input('operating'),
            'since' => $request->input('since'),
            'badget_use' => $request->input('badget_use'),
            'benefit' => $request->input('benefit'),
            'problem' => $request->input('problem'),
            'corrective_actions' => $request->input('corrective'),
            'created_at' => now(),
            'updated_at' => now()
        ];
        DB::table('project_evaluations')->where('proID',$id)->update($evaluation);  


        $data['obj'] = DB::table('objectives')->where('proID',$id)->get();
        foreach($data['obj'] as $index => $item){
            $obj_achieve[$index] = $request->input('obj_'.$item->objID);
            DB::table('objectives')->where('objID',$item->objID)->update(['achieve' => $obj_achieve[$index]]);
        }

        $data['KPI'] = DB::table('k_p_i_projects')->where('proID',$id)->get();
        foreach($data['KPI'] as $index =>  $item){
            $result_eva = $request->input('result_eva');
            DB::table('k_p_i_projects')->where('KPIProID',$item->KPIProID)->update(['result_eva' => $result_eva[$index]]);
        }
            
        return redirect('/project');
    }

    public function send(Request $request ,$id){
        DB::table('projects')->where('proID',$id)->update(['statusID' => '8']);

        $evaluation = [
            'implementation' => $request->input('implement'),
            'operID' => $request->input('operating'),
            'since' => $request->input('since'),
            'badget_use' => $request->input('badget_use'),
            'benefit' => $request->input('benefit'),
            'problem' => $request->input('problem'),
            'corrective_actions' => $request->input('corrective'),
            'created_at' => now(),
            'updated_at' => now()
        ];
        DB::table('project_evaluations')->where('proID',$id)->update($evaluation);  


        $data['obj'] = DB::table('objectives')->where('proID',$id)->get();
        foreach($data['obj'] as $index => $item){
            $obj_achieve[$index] = $request->input('obj_'.$item->objID);
            DB::table('objectives')->where('objID',$item->objID)->update(['achieve' => $obj_achieve[$index]]);
        }

        $data['KPI'] = DB::table('k_p_i_projects')->where('proID',$id)->get();
        foreach($data['KPI'] as $index =>  $item){
            $result_eva = $request->input('result_eva');
            DB::table('k_p_i_projects')->where('KPIProID',$item->KPIProID)->update(['result_eva' => $result_eva[$index]]);
        }
            
        return redirect('/project');
    }
}
