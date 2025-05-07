<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Year;
use App\Models\Strategic3Level;
use App\Models\StrategicIssues;
use App\Models\Goals;
use App\Models\Tactics;
use Illuminate\Support\Facades\DB;

class CopyPlanControllers extends Controller
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
    
    function index($id){
        $data['year']=Year::all();
        $data['strategic']=DB::table('strategic3_levels')->where('stra3LVID',$id)->first();
        $data['SFA3LV'] = StrategicIssues::with('strategic')->where('stra3LVID',$data['strategic']->stra3LVID)->get();
        $data['goal3LV'] = Goals::with('SFA')->whereIn('SFA3LVID',$data['SFA3LV']->pluck('SFA3LVID'))->get();
        $data['tac3LV'] = Tactics::with('goal')->whereIn('goal3LVID',$data['goal3LV']->pluck('goal3LVID'))->get();

        // dd($data['tac3LV']);

        
        return view('CopyPlan.index',compact('data'));
    }



    function insert(Request $request){
        
        $stra3LVID = $request->stra3LVID;       // stra_ID ที่จะ copy
        $toYearID = $request->to_yearID;   // ปีปลายทางที่ต้องการ copy ไป

    DB::transaction(function () use ($stra3LVID, $toYearID) {
        // 1. ดึงกลยุทธ์ + ความสัมพันธ์ที่เกี่ยวข้อง
        $strategic = Strategic3Level::with('SFA.Goal')->findOrFail($stra3LVID);

        // 2. replicate กลยุทธ์
        $newStrategic = $strategic->replicate();
        $newStrategic->yearID = $toYearID;
        $newStrategic->save();

        // 3. replicate SFA ทั้งหมด
        foreach ($strategic->SFA as $sfa) {
            $newSFA = $sfa->replicate();
            $newSFA->stra3LVID = $newStrategic->stra3LVID;
            $newSFA->save();

            // 4. replicate goal ทั้งหมด
            foreach ($sfa->Goal as $goal) {
                $newGoal = $goal->replicate();
                $newGoal->goal3LVID = Goals::max('goal3LVID') + 1;
                $newGoal->SFA3LVID = $newSFA->SFA3LVID;
                $newGoal->save();
            }
        }
    });


        // $strategic = new Strategic3Level();
        // $strategic->name = $request->input('name');
        // $strategic->yearID = $request->input('yearID');
        // // $strategic->save();

        // // $stra3LVIDs = $strategic->stra3LVID;

        // // dd($stra3LVIDs);
        // $stra3LV_old = $request->input('stra3LVID');
        // $SFA3LV_old = StrategicIssues::where('stra3LVID',$stra3LV_old)->get();
        // // $goal3LV_old = Goals::whereIn('SFA3LVID',$SFA3LV_old->pluck('SFA3LVID'))->get();

        // dd($SFA3LV_old,$goal3LV_old  );

        // if(!empty($SFA3LVName) ){
        //    foreach($SFA3LVName as $index => $SFA){
        //         $SFA3LV = new StrategicIssues();
        //         $SFA3LV->name = $SFA;
        //         $SFA3LV->stra3LVID = $stra3LVIDs;
        //         $SFA3LV->save();
        //    }
        // }

        
        
         
        return redirect('/strategic');
    }
}
