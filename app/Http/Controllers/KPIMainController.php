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

    function edit($id){
        $year = Year::all(); // ดึงข้อมูลปี
        $strategic = Strategics::all(); // ดึงข้อมูลแผนทั้งหมด
        $SFA = StrategicIssues::all();
        $goal = Goals::all();
        $tactics = Tactics::all();
        
        $KPIMain=KPIMains::with(['tactics.goal.SFA.strategic.year'])->where('KPIMainID',$id)->first();
        return view('KPIMain.update',compact('year','strategic','tactics','SFA','goal','KPIMain'));
    }
    function update(Request $request,$id){
        // $tacID = Tactics::where('tacID',$request->input('tacID'))->first();
        $KPIMain=[
            'tacID'=>$request->tacID,
            'name'=>$request->name,
            'count'=>$request->count,
            'target'=>$request->target
        ];
        DB::table('k_p_i_mains')->where('KPIMainID',$id)->update($KPIMain);
        return redirect('/KPIMain'); 
    }
}
