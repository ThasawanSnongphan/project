<?php

namespace App\Http\Controllers;

use App\Models\Year;
use App\Models\Users;
use App\Models\Projects;
use App\Models\Status;
use App\Models\CostQuarters;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SupplyAnalystController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    
    function index(){
        $year = Year::all();
        $projectYear = Projects::with('year')->get();
        
        // $project=Projects::all();
        $costQuarter = DB::table('cost_quarters')->whereIn('costID',[3,8,4])->get();
        $proIDs = $costQuarter->pluck('proID');
        // dd($proIDs);
        $project=Projects::with('status')->whereIn('proID',$proIDs)->where([['statusID','4'],['proTypeID',3]])->get();
        // $project=->get();
        // dd($project);
        $status=Status::all();
        $users = $users=DB::table('users')->get();
        return view('Supply_Analyst.project',compact('users','project','status','year','projectYear'));
    } //

    function projectOutPlan(){
        $year = Year::all();
        $projectYear = Projects::with('year')->get();
        
        // $project=Projects::all();
        $costQuarter = DB::table('cost_quarters')->whereIn('costID',[3,8,4])->get();
        $proIDs = $costQuarter->pluck('proID');
        // dd($proIDs);
        $project=Projects::with('status')->whereIn('proID',$proIDs)->where([['statusID','4'],['proTypeID',4]])->get();
        // $project=->get();
        // dd($project);
        $status=Status::all();
        $users = $users=DB::table('users')->get();
        return view('Supply_Analyst.projectOutPlan',compact('users','project','status','year','projectYear'));
    }
}
