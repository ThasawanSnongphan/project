<?php

namespace App\Http\Controllers;

use App\Models\Year;
use App\Models\Strategics;
use App\Models\StrategicIssues;
use App\Models\Goals;
use App\Models\Tactics;
use App\Models\KPIMains;
use App\Models\KPIMainMapTactics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TacticsController extends Controller
{
    function index(){
        // $goal=DB::table('goals')->get()->keyBy('goalID');
        // $tactics=DB::table('tactics')->get();
        // $SFA=DB::table('strategic_issues')->get()->keyBy('SFAID');
        // $strategic=DB::table('strategics')->get()->keyBy('straID');
        // $year=DB::table('years')->get()->keyBy('yearID');
        // $tactics=Tactics::with('goal.SFA.strategic.year')->get();
        $year=Year::all();
        $strategic=Strategics::all();
        $SFA=StrategicIssues::all();
        $goal=Goals::all();
        $tactics=Tactics::with(['goal.SFA.strategic.year', 'KPIMain'])->get();
        // $KPIMainMap=Tactics::with('KPIMain')->get();
        $KPIMain=KPIMains::all();

        return view('Tactics.index',compact('goal','tactics','SFA','strategic','year','KPIMain'));
    }

    function insert(Request $request){
        $goal = Goals::where('goalID',$request->input('goalID'))->first();
        $KPIMain = KPIMains::where('KPIMainID',$request->input('KPIMainID'))->first();
        $request->validate(
            [
                'name'=>'required'
            ]
        );
        $tactics = new Tactics();
        $tactics->name = $request->input('name');
        $tactics->goalID = $goal->goalID;
        $tactics->save();

        $tactics = $tactics->fresh();

        $KPIMainMap = $request->input('KPIMain');
        if(is_array($KPIMainMap)){
            foreach($KPIMainMap as $index => $KPIMain ){
                $Map = new KPIMainMapTactics();
                $Map->KPIMainID = $KPIMain ?? null;
                $Map->tacId = $tactics->tacID;
                $Map->save();
            }
        }
        return redirect('/tactics');
    }

    function delete($id){
        DB::table('tactics')->where('tacID',$id)->delete();
        return redirect('/tactics');
    }

    function edit($id){
        $tactics=Tactics::with(['goal.SFA.strategic.year', 'KPIMain'])->where('tacID',$id)->first();
        $year=Year::all();
        $strategic=Strategics::all();
        $SFA=StrategicIssues::all();
        $goal=Goals::all();
        $KPIMainMap=KPIMainMapTactics::all();
        $KPIMain=KPIMains::all();
        return view('tactics.update',compact('year','strategic','SFA','goal','tactics','KPIMainMap','KPIMain'));
    }
    function update(Request $request,$id){
        $tactics=[
            'goalID'=>$request->goalID,
            'name'=>$request->name
        ];
        DB::table('tactics')->where('tacID',$id)->update($tactics);
        return redirect('/tactics'); 
    }

}