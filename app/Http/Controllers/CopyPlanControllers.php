<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Year;
use App\Models\Strategic3Level;
use App\Models\StrategicIssues;
use App\Models\Goals;
use Illuminate\Support\Facades\DB;

class CopyPlanControllers extends Controller
{
    function index($id){
        $data['year']=Year::all();
        $data['strategic']=DB::table('strategic3_levels')->where('stra3LVID',$id)->first();

        $data['SFA3LV'] = StrategicIssues::with('strategic')->where('stra3LVID',$data['strategic']->stra3LVID)->get();
        $data['goal'] = Goals::with('SFA')->whereIn('SFa3LVID',$data['SFA3LV']->pluck('SFA3LVID'))->get();

        
        return view('CopyPlan.index',compact('data'));
    }

    function insert(Request $request){
        
        $strategic = new Strategic3Level();
        $strategic->name = $request->input('name');
        $strategic->yearID = $request->input('yearID');
        $strategic->save();

        $SFA3LVName = $request->input('SFA3LVName');
        $stra3LVIDs = $strategic->stra3LVID;

        // dd($stra3LVIDs);

        if(!empty($SFA3LVName) ){
           foreach($SFA3LVName as $index => $SFA){
                $SFA3LV = new StrategicIssues();
                $SFA3LV->name = $SFA;
                $SFA3LV->stra3LVID = $stra3LVIDs;
                $SFA3LV->save();
           }
        }

        
        
         
        return redirect('/strategic');
    }
}
