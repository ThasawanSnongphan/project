<?php

namespace App\Http\Controllers;

use App\Models\Year;
use App\Models\Strategic3Level;
use App\Models\StrategicIssues;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SFAController extends Controller
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
        $year=Year::all();
        $strategic=Strategic3Level::all();
        $SFA=StrategicIssues::with(['strategic.year']) // ดึงข้อมูลสัมพันธ์
        ->get();
        return view('Strategic3Level.SFA.index',compact('strategic','year','SFA'));
    }

    function insert(Request $request){
        $strategic = Strategic3Level::where('stra3LVID',$request->input('stra3LVID'))->first();
        $request->validate(
            [
                'name'=>'required'
            ]
        );

        $SFA = new StrategicIssues();
        $SFA->name = $request->input('name');
        $SFA->stra3LVID = $strategic->stra3LVID;
        $SFA->save();
        return redirect('/SFA');

    }

    function delete($id){
        DB::table('strategic_issues')->where('SFA3LVID',$id)->delete();
        return redirect('/SFA');
    }

    function edit($id){
        $SFA = StrategicIssues::with('strategic.year')->where('SFA3LVID', $id)->first();
        $strategic = Strategic3Level::all();
        $year = Year::all(); 
        return view('Strategic3Level.SFA.update',compact('SFA','strategic','year'));
    }
    function update(Request $request,$id){
        $strategic = Strategic3Level::where('stra3LVID',$request->input('stra3LVID'))->first();
        
        $SFA=[
            'stra3LVID'=>$request->stra3LVID,
            'name'=>$request->name
        ];
        DB::table('strategic_issues')->where('SFA3LVID',$id)->update($SFA);
        return redirect('/SFA'); 
    }
}
