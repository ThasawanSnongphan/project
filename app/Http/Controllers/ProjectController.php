<?php

namespace App\Http\Controllers;

use App\Models\Year;
use App\Models\Status;
use App\Models\Strategics;
use App\Models\StrategicIssues;
use App\Models\Goals;
use App\Models\Tactics;
use App\Models\KPIMains;
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
        return view('Project.create',compact('year','strategic','SFA','goal','tactics','KPIMain','projectType','projectCharec','projectIntegrat','target','badgetType','uniplan','fund','expanses','costTypes'));
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
        return redirect('/project');
    }

    function delete($id){
        DB::table('projects')->where('proID',$id)->delete();
        return redirect('/project');
    }

    function edit($id){
        $project=DB::table('projects')->where('proID',$id)->first();
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
