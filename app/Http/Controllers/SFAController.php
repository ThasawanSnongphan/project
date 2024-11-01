<?php

namespace App\Http\Controllers;

use App\Models\Year;
use App\Models\Strategics;
use App\Models\StrategicIssues;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SFAController extends Controller
{
    function index(){
        $year=Year::all();
        $strategic=Strategics::all();
        $SFA=StrategicIssues::with(['strategic.year']) // ดึงข้อมูลสัมพันธ์
        ->get();
        return view('SFA.index',compact('strategic','year','SFA'));
    }

    function insert(Request $request){
        $strategic = Strategics::where('straID',$request->input('straID'))->first();
        $request->validate(
            [
                'name'=>'required'
            ]
        );

        $SFA = new StrategicIssues();
        $SFA->name = $request->input('name');
        $SFA->straID = $strategic->straID;
        $SFA->save();
        return redirect('/SFA');

    }

    function delete($id){
        DB::table('strategic_issues')->where('SFAID',$id)->delete();
        return redirect('/SFA');
    }

    function edit($id){
        $SFA = StrategicIssues::with('strategic.year')->where('SFAID', $id)->first();
        $strategic = Strategics::all();
        $year = Year::all(); 
        return view('SFA.update',compact('SFA','strategic','year'));
    }
    function update(Request $request,$id){
        $strategic = Strategics::where('straID',$request->input('straID'))->first();
        
        $SFA=[
            'straID'=>$request->straID,
            'name'=>$request->name
        ];
        DB::table('strategic_issues')->where('SFAID',$id)->update($SFA);
        return redirect('/SFA'); 
    }
}
