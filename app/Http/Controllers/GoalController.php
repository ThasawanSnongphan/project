<?php

namespace App\Http\Controllers;

use App\Models\Year;
use App\Models\Strategics;
use App\Models\StrategicIssues;
use App\Models\Goals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GoalController extends Controller
{
    function index(){
        // $year=DB::table('years')->get()->keyBy('yearID');
        // $strategic=DB::table('strategics')->get()->keyBy('straID');
        // $SFA=DB::table('strategic_issues')->get()->keyBy('SFAID');
        $year=Year::all();
        $strategic=Strategics::all();
        $SFA=StrategicIssues::all();
        $goal=DB::table('goals')->get();
        $goals=Goals::with('SFA.strategic.year')->get();
        return  view('Strategic3Level.Goal.index',compact('SFA','goal','goals','year','strategic'));
    }

    function insert(Request $request){
        $SFA = StrategicIssues::where('SFAID',$request->input('SFAID'))->first();
        $request->validate(
            [
                'name'=>'required'
            ]
        );
        $goal = new Goals();
        $goal->name = $request->input('name');
        $goal->SFAID = $SFA->SFAID;
        $goal->save();
        return redirect('/goal');
    }

    function delete($id){
        DB::table('goals')->where('goalID',$id)->delete();
        return redirect('/goal');
    }

    function edit($id){
        $goal=Goals::with('SFA.strategic.year')->where('goalID',$id)->first();
        $year=Year::all();
        $SFA = StrategicIssues::all(); 
        $strategic=Strategics::all();
        return view('Strategic3Level.Goal.update',compact('goal','year','SFA','strategic'));
    }
    function update(Request $request,$id){
        $goal=[
            'SFAID'=>$request->SFAID,
            'name'=>$request->name
        ];
        DB::table('goals')->where('goalID',$id)->update($goal);
        return redirect('/goal'); 
    }
}
