<?php

namespace App\Http\Controllers;

use App\Models\Year;
use App\Models\Users;
use App\Models\Status;
use App\Models\Strategics;
use App\Models\StrategicMap;
use App\Models\StrategicIssues;
use App\Models\Goals;
use App\Models\Tactics;
use App\Models\KPIMains;
use App\Models\KPIProjects;
use App\Models\Projects;
use App\Models\ProjectType;
use App\Models\ProjectCharec;
use App\Models\ProjectIntegrat;
use App\Models\Targets;
use App\Models\BadgetType;
use App\Models\UniPlan;
use App\Models\Funds;
use App\Models\ExpenseBadgets;
use App\Models\CostTypes;
use App\Models\Objectives;
use App\Models\ObjectiveProjects;
use App\Models\Steps;
use App\Models\CostQuarters;
use App\Models\Benefits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    function index(){
        $project=Projects::all();
        
        $status=Status::all();
        return view('Project.index',compact('project','status'));
    }
    function create(){
        $user = Users::all();
        $year = Year::all(); // ดึงข้อมูลปี
        $strategic = Strategics::all(); // ดึงข้อมูลแผนทั้งหมด
        $SFA = StrategicIssues::all();
        $goal = Goals::all();
        $tactics = Tactics::all();
        $KPIMain=KPIMains::with('tactics.goal.SFA.strategic.year')->get();
        $projectType=ProjectType::all();
        $projectCharec=ProjectCharec::all();
        $projectIntegrat=ProjectIntegrat::all();
        $target=Targets::all();
        $badgetType=BadgetType::all();
        $uniplan=UniPlan::all();
        $fund=Funds::all();
        $expanses = ExpenseBadgets::all();
        $costTypes=CostTypes::all();
        return view('Project.create',compact('year','user','strategic','SFA','goal','tactics','KPIMain','projectType','projectCharec','projectIntegrat','target','badgetType','uniplan','fund','expanses','costTypes'));
    }

    function insert(Request $request){
        $year = Year::where('yearID',$request->input('yearID'))->first();
        $strategic = Strategics::where('straID',$request->input('straID'))->first();
        $proType = ProjectType::where('proTypeID',$request->input('proTypeID'))->first();
        $proCha = ProjectCharec::where('proChaID',$request->input('proChaID'))->first();
        $proIn = ProjectIntegrat::where('proInID',$request->input('proInID'))->first();
        $target = Targets::where('tarID',$request->input('tarID'))->first();
        $badget = BadgetType::where('badID',$request->input('badID'))->first();
        $UniPlan = UniPlan::where('planID',$request->input('planID'))->first();
        $expID = ExpenseBadgets::where('expID',$request->input('expID'))->first();
        $costID = CostTypes::where('costID',$request->input('costID'))->first();
        $status = Status::all();
        $request->validate(
            [
                'name'=>'required',
            ]
        );
        $project = new Projects();
        $project->yearID = $year->yearID;
        $project->straID = $strategic->straID;
        $project->name = $request->input('name');
        $project->format = $request->input('format');
        $project->princiDetail = $request->input('principle');
        $project->proTypeID = $proType->proTypeID;
        $project->proChaID = $proCha->proChaID;
        $project->proInID = $proIn->proInID;
        $project->proInDetail = $request->input('proInDetail');
        $project->tarID = $target->tarID;
        $project->badID = $badget->badID;
        $project->planID = $UniPlan->planID;
        $project->statusID =  16;
        $project->save();

        $project = $project->fresh();

        $obj = new Objectives();
        $obj->name = $request->input('objective');
        $obj->save();

        $straMap = new StrategicMap();
        $straMap->proID = $project->proID;
        $straMap->straID = $strategic->straID;
        $straMap->save();

        $obj = $obj->fresh();



        $objproject = new ObjectiveProjects();
        $objproject->objID = $obj->objID;
        $objproject->proID = $project->proID;
        $objproject->save();
        
        $KPIProject = new KPIProjects();
        $KPIProject->name = $request->input('KPIProject') ;
        $KPIProject->count = $request->input('countProject') ;
        $KPIProject->target = $request->input('targetProject') ;
        $KPIProject->proID = $project->proID;
        $KPIProject->save();

        $step = new Steps();
        $step->name = $request->input('stepName');
        $step->start = $request->input('stepStart');
        $step->end = $request->input('stepEnd');
        $step->proID = $project->proID;
        $step->save();

        $costQu = new CostQuarters();
        $costQu->costQu1 = $request->input('costQu1');
        $costQu->costQu2 = $request->input('costQu2');
        $costQu->costQu3 = $request->input('costQu3');
        $costQu->costQu4 = $request->input('costQu4');
        $costQu->proID = $project->proID;
        $costQu->expID = $expID->expID;
        $costQu->costID = $costID->costID;
        $costQu->save();

        $benefit = new Benefits();
        $benefit->detail = $request->input('benefit');
        $benefit->proID = $project->proID;
        $benefit->save();
        
        return redirect('/project');
    }

    function delete($id){
        DB::table('projects')->where('proID',$id)->delete();
        return redirect('/project');
    }

    function edit($id){
        $project=DB::table('projects')->where('proID',$id)->first();
        // $proStra=Projects::with('strategics')->where('proID',$id)->first();
        $year = Year::all(); // ดึงข้อมูลปี
        $strategic = Strategics::all(); // ดึงข้อมูลแผนทั้งหมด
        $SFA = StrategicIssues::all();
        $goal = Goals::all();
        $tactics = Tactics::all();
        $KPIMain=KPIMains::with('tactics.goal.SFA.strategic.year')->get();
        $projectType=ProjectType::all();
        $projectCharec=ProjectCharec::all();
        $projectIntegrat=ProjectIntegrat::all();
        $target=Targets::all();
        $badgetType=BadgetType::all();
        $uniplan=UniPlan::all();
        $fund=Funds::all();
        $expanses = ExpenseBadgets::all();
        $costTypes=CostTypes::all();
       
        return view('Project.update',compact('project','year','strategic','SFA','goal','tactics','KPIMain','projectType','projectCharec','projectIntegrat','target','badgetType','uniplan','fund','expanses','costTypes'));
    }

   
}
