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
use App\Models\KPIProjectMap;
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
use App\Models\Steps;
use App\Models\CostQuarters;
use App\Models\Benefits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    function index(){
        $year = Year::all();
        $projectYear = Projects::with('year')->get();
        $project=Projects::all();
        $status=Status::all();
        return view('Project.index',compact('project','status','year','projectYearๅ'));
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
        $SFA = StrategicIssues::where('SFAID',$request->input('SFAID'))->first();
        $goal = Goals::where('goalID',$request->input('goalID'))->first();
        $tactics = Tactics::where('tacID',$request->input('tacID'))->first();
        $KPIMain = KPIMains::where('KPIMainID',$request->input('KPIMainID'))->first();
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

        
       
            


        $objDetail = $request->input('obj');
    if(is_array($objDetail)) {
        foreach($objDetail as $index => $obj){
            $objs = new Objectives();
            $objs->name = $obj;
            $objs->proID = $project->proID;
            $objs->save();
        }
    }
        $straMap = new StrategicMap();
        $straMap->proID = $project->proID;
        $straMap->straID = $strategic->straID;
        $straMap->SFAID = $SFA->SFAID;
        $straMap->goalID = $goal->goalID;
        $straMap->tacID = $tactics->tacID;
        if ($request->has('KPIMainID') && !empty($request->input('KPIMainID'))) {
        $straMap->KPIMainID = $KPIMain->KPIMainID;
        }
        $straMap->save();

        $KPIName = $request->input('KPIProject') ;
        $KPICount =  $request->input('countProject') ;
        $KPITarget =  $request->input('targetProject') ;

        if(is_array($KPIName) && is_array($KPICount) && is_array($KPITarget)){
            foreach ($KPIName as $index => $KPI){
                $KPIProject = new KPIProjects();
                $KPIProject->name = $KPI;
                $KPIProject->count =  $KPICount[$index] ?? null;
                $KPIProject->target = $KPITarget[$index] ?? null;
                $KPIProject->save();

                $KPIProject = $KPIProject->fresh();

                $KPIProjectMap = new KPIProjectMap();
                $KPIProjectMap->KPIProID = $KPIProject->KPIProID;
                $KPIProjectMap->ProID = $project->proID;
                $KPIProjectMap->save();
            }
        }

        $stepName = $request->input('stepName');
        $stepStart = $request->input('stepStart');
        $stepEnd = $request->input('stepEnd');
        if(is_array($stepName) && is_array($stepStart) && is_array($stepEnd)){
            foreach($stepName as $index => $name){
                $step = new Steps();
                $step->name = $name;
                $step->start = $stepStart[$index] ?? null;
                $step->end = $stepEnd[$index] ?? null;
                $step->proID = $project->proID;
                $step->save();
            }
        }

       
        $costQu1 = $request->input('costQu1');
        $costQu2= $request->input('costQu2');
        $costQu3= $request->input('costQu3');
        $costQu4= $request->input('costQu4');

        if(is_array($costQu1) && is_array($costQu2) && is_array($costQu3) && is_array($costQu4)){
            foreach($costQu1 as $index => $cost1){
                $costQu = new CostQuarters();
                $costQu->costQu1 = $cost1;
                $costQu->costQu2 = $costQu2[$index];
                $costQu->costQu3 = $costQu3[$index];
                $costQu->costQu4 = $costQu4[$index];
                $costQu->proID = $project->proID;
                $costQu->expID = $expID->expID;
                $costQu->costID = $costID->costID;
                $costQu->save();
            }
        }
       

        $benefits = $request->input('benefit');
        if(is_array($benefits)){
            foreach($benefits as $index => $bnf){
                $benefit = new Benefits();
                $benefit->detail = $bnf;
                $benefit->proID = $project->proID;
                $benefit->save();
            }
        }
        return redirect('/project');
    }

    function delete($id){
        DB::table('projects')->where('proID',$id)->delete();
        return redirect('/project');
    }

    function edit($id){
        // $project = Projects::with('strategicMap')->find($proID);
        // $project=DB::table('projects')->where('proID',$id)->first();
        $project=Projects::with('strategicMap')->where('proID',$id)->first();
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
