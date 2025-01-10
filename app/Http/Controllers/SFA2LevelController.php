<?php

namespace App\Http\Controllers;

use App\Models\Year;
use App\Models\Strategic2Level;
use App\Models\StrategicIssues2Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SFA2LevelController extends Controller
{
    function index(){
        $year=Year::all();
        $strategic=Strategic2Level::all();
        $SFA=StrategicIssues2Level::with(['strategic.year'])->get();
        return view('Strategic2Level.SFA.index',compact('strategic','year','SFA'));
    }

    function insert(Request $request){
        $strategic = Strategic2Level::where('stra2LVID',$request->input('stra2LVID'))->first();
        $request->validate(
            [
                'name' => 'required'
            ]
        );
        $SFA = new StrategicIssues2Level();
        $SFA->name = $request->input('name');
        $SFA->stra2LVID = $strategic->stra2LVID;
        $SFA->save();
        return redirect('/SFA2LV');
    }

    function edit($id){
        $year = Year::all();
        $strategic = Strategic2Level::all();
        $SFA = StrategicIssues2Level::with(['strategic.year'])->where('SFA2LVID',$id)->first();
        return view('Strategic2Level.SFA.update',compact('year','strategic','SFA'));
    }

    function update(Request $request,$id){
        $strategic = Strategic2Level::where('stra2LVID',$request->input('stra2LVID'))->first();
        $SFA = [
            'stra2LVID'=>$request->stra2LVID,
            'name' => $request->name
        ];
        DB::table('strategic_issues2_levels')->where('SFA2LVID',$id)->update($SFA);
        return redirect('/SFA2LV');
    }

    function delete($id){
        DB::table('strategic_issues2_levels')->where('SFA2LVID',$id)->delete();
        return redirect('/SFA2LV');
    }
}