<?php

namespace App\Http\Controllers;

use App\Models\Year;
use App\Models\Strategics;
use App\Models\StrategicIssues;
use App\Models\Goals;
use App\Models\Tactics;
use App\Models\KPIMains;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KPIMainController extends Controller
{
    function index(){
        // $year=DB::table('years')->get()->keyBy('yearID');
        // $strategic=DB::table('strategics')->get()->keyBy('straID');
        // $tactics=DB::table('tactics')->get()->keyBy('tacID');

        $year = Year::all(); // ดึงข้อมูลปี
        $strategic = Strategics::all(); // ดึงข้อมูลแผนทั้งหมด
        $SFA = StrategicIssues::all();
        $goal = Goals::all();
        $tactics = Tactics::all();
        $KPIMain=KPIMains::with('tactics.goal.SFA.strategic.year')->get();
        return view('KPIMain.index',compact('year','strategic','tactics','SFA','goal','KPIMain'));
    }

    function insert(Request $request){
        $tactics = Tactics::where('tacID',$request->input('tacID'))->first();
        $request->validate(
            [
                'name'=>'required',
                'count'=>'required',
                'target'=>'required'
            ]
        );
        $KPIMain = new KPIMains();
        $KPIMain->name = $request->input('name');
        $KPIMain->count = $request->input('count');
        $KPIMain->target = $request->input('target');
        $KPIMain->tacID = $tactics->tacID;
        $KPIMain->save();
        return redirect('/KPIMain');
    }
}
