<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Year;
use App\Models\Strategic3Level;
use App\Models\StrategicIssues;
use App\Models\Goals;
use App\Models\Tactics;
use App\Models\KPIMains;
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
        $strategic = Strategic3Level::with('SFA.Goal.Tactics', 'SFA.Goal.KPI')->findOrFail($stra3LVID);

        // 2. replicate กลยุทธ์
        $newStrategic = $strategic->replicate();
        $newStrategic->stra3LVID =  Strategic3Level::max('stra3LVID') + 1;
        $newStrategic->yearID = $toYearID;
        $newStrategic->save();

        // เก็บ mapping ID เดิมกับ ID ใหม่
        $oldToNewKPI = [];
        $oldToNewTactics = [];
        // 3. replicate SFA ทั้งหมด
        foreach ($strategic->SFA as $sfa) {
            $newSFA = $sfa->replicate();
            $newSFA->SFA3LVID = StrategicIssues::max('SFA3LVID') + 1;
            $newSFA->stra3LVID = $newStrategic->stra3LVID;
            $newSFA->save();

            // 4. replicate goal ทั้งหมด
            foreach ($sfa->Goal as $goal) {
                $newGoal = $goal->replicate();
                $newGoal->goal3LVID = Goals::max('goal3LVID') + 1;
                $newGoal->SFA3LVID = $newSFA->SFA3LVID;
                $newGoal->save();

                // Copy KPI ก่อน แล้วเก็บ mapping
                foreach ($goal->KPI as $kpi){
                    $newKPI = $kpi->replicate();
                    $newKPI->KPIMain3LVID = KPIMains::max('KPIMain3LVID')+1;
                    $newKPI->goal3LVID = $newGoal->goal3LVID;
                    $newKPI->save();

                     // เก็บ mapping ID
                    $oldToNewKPI[$kpi->KPIMain3LVID] = $newKPI->KPIMain3LVID;
                }

                // Copy Tactics และ map KPIMain3LVID ถ้ามี
                foreach ($goal->Tactics as $tactics){
                    $newTactics = $tactics->replicate();
                    $newTactics->tac3LVID = Tactics::max('tac3LVID') + 1;
                    $newTactics->goal3LVID = $newGoal->goal3LVID;
                    $newTactics->save();

                    // เก็บ mapping ID
                    $oldToNewTactics[$tactics->tac3LVID] = $newTactics->tac3LVID;
                }

                // คัดลอก mapping ของ KPIMainMapTactics
                foreach ($goal->KPI as $kpi) {
                    foreach ($kpi->MapTactics as $map) { // สมมุติว่า KPI มีความสัมพันธ์ชื่อ 'MapTactics'
                        $oldKPIID = $map->KPIMain3LVID;
                        $oldTacID = $map->tac3LVID;

                        if (isset($oldToNewKPI[$oldKPIID]) && isset($oldToNewTactics[$oldTacID])) {
                            DB::table('k_p_i_main_map_tactics')->insert([
                                'KPIMain3LVID' => $oldToNewKPI[$oldKPIID],
                                'tac3LVID' => $oldToNewTactics[$oldTacID],
                                // ใส่ฟิลด์อื่นที่จำเป็น เช่น created_at updated_at
                            ]);
                        }
                    }
                }
                
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
