<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Year;
use App\Models\Users;
use App\Models\Status;
use App\Models\Projects;
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
use Illuminate\Support\Facades\DB;

class PlanningAnalyst extends Controller
{
    function index(){
        $year = Year::all();
        $projectYear = Projects::with('year')->get();
        $project=Projects::all();
        $status=Status::all();
        $users = $users=DB::table('users')->get();
        return view('Planning_Analyst.project',compact('users','project','status','year','projectYear'));
    }

    function report($id){
        $user=Users::all();
        $project=DB::table('projects')->where('proID',$id)->first();
        $projectYear=Year::all();
        $projectType=ProjectType::all();
        $projectCharector=ProjectCharec::all();
        $projectIntegrat=ProjectIntegrat::all();
        $projectOBJ=Objectives::all();
        $projectTarget=Targets::all();
        $projectStep=Steps::all();
        $projectBadgetType=BadgetType::all();
        $projectUniPlan=UniPlan::all();
        $projectCostQuarter=CostQuarters::all();
        $peojectEXP=ExpenseBadgets::all();
        $projectCostType=CostTypes::all();
        $projectBenefit=Benefits::all();
        return view('Planning_Analyst.detail',compact('user','project','projectYear','projectType','projectCharector','projectIntegrat','projectOBJ','projectTarget','projectStep','projectBadgetType','projectUniPlan','projectCostQuarter','peojectEXP','projectCostType','projectBenefit'));
    }

    function planningPass(Request $request,$id){
        DB::table('projects')->where('proID',$id)->update(['statusID' => '6']);
        $detail = $request->input('comment');
        $userID = Auth::id();
        if(!empty($detail)){
            DB::table('comments')->insert(
                [
                    'proID' => $id,
                    'detail' => $detail,
                    'userID' => $userID,
                    'updated_at' => now(), 
                    'created_at' => now() 
                ]);
        }
        return redirect('/PlanningAnalystProject');
    }

    function planningEdit(Request $request,$id){
        DB::table('projects')->where('proID',$id)->update(['statusID' => '14']);
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
        return redirect('/PlanningAnalystProject');
    }
}
