<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Year;
use App\Models\Users;
use App\Models\UsersMapProject;
use App\Models\Status;
use App\Models\Projects;
use App\Models\StrategicMap;
use App\Models\KPIMainMapProjects;
use App\Models\Strategic2LevelMapProject;
use App\Models\KPIMain2LevelMapProject;
use App\Models\Strategic1LevelMapProject;
use App\Models\KPIProjects;
use App\Models\ProjectType;
use App\Models\ProjectCharec;
use App\Models\ProjectIntegrat;
use Illuminate\Http\Request;
use App\Models\Targets;
use App\Models\BadgetType;
use App\Models\UniPlan;
use App\Models\ExpenseBadgets;
use App\Models\CostTypes;
use App\Models\Objectives;
use App\Models\Steps;
use App\Models\CostQuarters;
use App\Models\Benefits;
use App\Models\Files;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;

class Department_Head extends Controller
{
    function index(){
        $year = Year::all();
        $projectYear = Projects::with('year')->get();
        $project= DB::table('projects')->whereIn('statusID',[1,5])->get();
        // dd($project);
        $status=Status::all();
        $users = $users=DB::table('users')->get();
        return view('Department_Head.project',compact('users','project','status','year','projectYear'));
    }

    function report($id){
        $project=DB::table('projects')->where('proID',$id)->first();
        $user=Users::all();
        $userMap = UsersMapProject::with('users')->where('proID',$id)->get();
        $status = DB::table('statuses')->where('statusID',$project->statusID)->first();
        $strategic3LVMap=StrategicMap::with(['Stra3LV','SFA3LV','goal3LV','tac3LV'])->where('proID',$id)->get();
        $KPI3LVMap = KPIMainMapProjects::with('KPI')->where('proID',$id)->get();
        $strategic2LVMap=Strategic2LevelMapProject::with(['stra2LV','SFA2LV','tac2LV'])->where('proID',$id)->get();
        $KPI2LVMap = KPIMain2LevelMapProject::with('KPI')->where('proID',$id)->get();
        $strategic1LVMap = Strategic1LevelMapProject::with(['stra1LV','tar1LV'])->where('proID',$id)->get();
        $KPIProject = KPIProjects::with('count')->where('proId',$id)->get();
        $projectYear=Year::all();
        $projectType=ProjectType::all();
        $projectCharector=ProjectCharec::all();
        $projectIntegrat=ProjectIntegrat::all();
        $projectOBJ=Objectives::all();
        $projectTarget=Targets::all();
        $projectStep=DB::table('steps')->where('proID',$id)->get();
        $projectBadgetType=BadgetType::all();
        $projectUniPlan=UniPlan::all();
        $projectCostQuarter=CostQuarters::with(['exp','cost'])->where('proID',$id)->get();
        $peojectEXP=ExpenseBadgets::all();
        $projectCostType=CostTypes::all();
        $projectBenefit=DB::table('benefits')->where('proID',$id)->get();
        $file = DB::table('files')->where('proID',$id)->get();
        $comment = Comment::with('user')->where('proID',$id)->get();

        return view('Department_Head.detail',compact('status','user','userMap','project','strategic3LVMap','KPI3LVMap','strategic2LVMap','KPI2LVMap','strategic1LVMap','KPIProject','projectYear','projectType','projectCharector','projectIntegrat','projectOBJ','projectTarget','projectStep','projectBadgetType','projectUniPlan','projectCostQuarter','peojectEXP','projectCostType','projectBenefit','file','comment'));
    }

    function departmentPass(Request $request, $id){
        DB::table('projects')->where('proID',$id)->update(['statusID' => '2']);
        $detail = $request->input('comment');
        if(!empty($detail)){
            $userID = Auth::id();
            DB::table('comments')->insert(
                [
                    'proID' => $id,
                    'detail' => $detail,
                    'userID' => $userID,
                    'updated_at' => now(), 
                    'created_at' => now() 
                ]);
        }
        return redirect('/DepartmentHeadProject');
    }

    function departmentEdit(Request $request,$id){
        $request->validate([
            'comment'=>'required'
        ]);
        DB::table('projects')->where('proID',$id)->update(['statusID' => '12']);
        $detail = $request->input('comment');
        $userID = Auth::id();
        DB::table('comments')->insert(
            [
                'proID' => $id,
                'detail' => $detail,
                'userID' => $userID,
                'updated_at' => now(), 
                'created_at' => now() 
            ]);
        return redirect('/DepartmentHeadProject');
    }
}
