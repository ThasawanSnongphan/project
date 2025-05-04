<?php

namespace App\Http\Controllers;

use App\Models\Year;
use App\Models\Strategic3Level;
use App\Models\StrategicIssues;
use App\Models\Goals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GoalController extends Controller
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
        // $year=DB::table('years')->get()->keyBy('yearID');
        // $strategic=DB::table('strategics')->get()->keyBy('straID');
        // $SFA=DB::table('strategic_issues')->get()->keyBy('SFAID');
        $year=Year::all();
        $strategic=Strategic3Level::all();
        $SFA=StrategicIssues::all();
        $goal=DB::table('goals')->get();
        $goals=Goals::with('SFA.strategic.year')->get();
        return  view('Strategic3Level.Goal.index',compact('SFA','goal','goals','year','strategic'));
    }

    function insert(Request $request){
        $SFA = StrategicIssues::where('SFA3LVID',$request->input('SFAID'))->first();
        $request->validate(
            [
                'name'=>'required'
            ]
        );
        $goal = new Goals();
        $goal->name = $request->input('name');
        $goal->SFA3LVID = $SFA->SFA3LVID;
        $goal->save();
        return redirect('/goal');
    }

    function delete($id){
        DB::table('goals')->where('goal3LVID',$id)->delete();
        return redirect('/goal');
    }

    function edit($id){
        $goal=Goals::with('SFA.strategic.year')->where('goal3LVID',$id)->first();
        $year=Year::all();
        $SFA = StrategicIssues::all(); 
        $strategic=Strategic3Level::all();
        return view('Strategic3Level.Goal.update',compact('goal','year','SFA','strategic'));
    }
    function update(Request $request,$id){
        $goal=[
            'SFA3LVID'=>$request->SFAID,
            'name'=>$request->name
        ];
        DB::table('goals')->where('goal3LVID',$id)->update($goal);
        return redirect('/goal'); 
    }
}
