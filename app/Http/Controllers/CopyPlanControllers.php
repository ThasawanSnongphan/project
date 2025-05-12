<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Year;
use App\Models\Strategic3Level;
use App\Models\StrategicIssues;
use App\Models\Goals;
use App\Models\Tactics;
use App\Models\KPIMains;

use App\Models\Strategic2Level;
use App\Models\StrategicIssues2Level;
use App\Models\Tactic2Level;
use App\Models\KPIMain2Level;

use App\Models\Strategic1Level;
use App\Models\Target1Level;
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
    
    function index($id,$lv){
        $data['year']=Year::all();
        $data['lv'] = $lv;
        if($lv == 3){
            $data['strategic']=DB::table('strategic3_levels')->where('stra3LVID',$id)->first();
        }elseif($lv == 2){
            $data['strategic']=DB::table('strategic2_levels')->where('stra2LVID',$id)->first();
        }else{
            $data['strategic']=DB::table('strategic1_levels')->where('stra1LVID',$id)->first();
        }
        return view('CopyPlan.index',compact('data'));
    }



    function insert(Request $request){
    if($request->lv == 3){
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
        return redirect('/strategic');
    } elseif($request->lv == 2){
        $stra2LVID = $request->stra2LVID;       // stra_ID ที่จะ copy
        $toYearID = $request->to_yearID;   // ปีปลายทางที่ต้องการ copy ไป
        DB::transaction(function () use ($stra2LVID, $toYearID) {
            // 1. ดึงกลยุทธ์ + ความสัมพันธ์ที่เกี่ยวข้อง
            $strategic = Strategic2Level::with('SFA.Tactics', 'SFA.KPI')->findOrFail($stra2LVID);

            // 2. replicate กลยุทธ์
            $newStrategic = $strategic->replicate();
            $newStrategic->stra2LVID =  Strategic2Level::max('stra2LVID') + 1;
            $newStrategic->yearID = $toYearID;
            $newStrategic->save();

            // เก็บ mapping ID เดิมกับ ID ใหม่
            $oldToNewKPI = [];
            $oldToNewTactics = [];
            // 3. replicate SFA ทั้งหมด
            foreach ($strategic->SFA as $sfa) {
                $newSFA = $sfa->replicate();
                $newSFA->SFA2LVID = StrategicIssues2Level::max('SFA2LVID') + 1;
                $newSFA->stra2LVID = $newStrategic->stra2LVID;
                $newSFA->save();

                    // Copy KPI ก่อน แล้วเก็บ mapping
                    foreach ($sfa->KPI as $kpi){
                        $newKPI = $kpi->replicate();
                        $newKPI->KPIMain2LVID = KPIMain2Level::max('KPIMain2LVID')+1;
                        $newKPI->SFA2LVID = $newSFA->SFA2LVID;
                        $newKPI->save();

                        // เก็บ mapping ID
                        $oldToNewKPI[$kpi->KPIMain2LVID] = $newKPI->KPIMain2LVID;
                    }

                    // Copy Tactics และ map KPIMain3LVID ถ้ามี
                    foreach ($sfa->Tactics as $tactics){
                        $newTactics = $tactics->replicate();
                        $newTactics->tac2LVID = Tactic2Level::max('tac2LVID') + 1;
                        $newTactics->SFA2LVID = $newSFA->SFA2LVID;
                        $newTactics->save();

                        // เก็บ mapping ID
                        $oldToNewTactics[$tactics->tac2LVID] = $newTactics->tac2LVID;
                    }

                    // คัดลอก mapping ของ KPIMainMapTactics
                    foreach ($sfa->KPI as $kpi) {
                        foreach ($kpi->MapTactics as $map) { // สมมุติว่า KPI มีความสัมพันธ์ชื่อ 'MapTactics'
                            $oldKPIID = $map->KPIMain2LVID;
                            $oldTacID = $map->tac2LVID;

                            if (isset($oldToNewKPI[$oldKPIID]) && isset($oldToNewTactics[$oldTacID])) {
                                DB::table('tactic2_level_map_k_p_i_main2_levels')->insert([
                                    'KPIMain2LVID' => $oldToNewKPI[$oldKPIID],
                                    'tac2LVID' => $oldToNewTactics[$oldTacID],
                                    // ใส่ฟิลด์อื่นที่จำเป็น เช่น created_at updated_at
                                ]);
                            }
                        }
                    }
                    
                
            }
        });
        return redirect('/strategic2LV');
    }else{
        $stra1LVID = $request->stra1LVID;       // stra_ID ที่จะ copy
        $toYearID = $request->to_yearID;   // ปีปลายทางที่ต้องการ copy ไป
        DB::transaction(function () use ($stra1LVID, $toYearID) {
            // 1. ดึงกลยุทธ์ + ความสัมพันธ์ที่เกี่ยวข้อง
            $strategic = Strategic1Level::with('Target')->findOrFail($stra1LVID);

            // 2. replicate กลยุทธ์
            $newStrategic = $strategic->replicate();
            $newStrategic->stra1LVID =  Strategic1Level::max('stra1LVID') + 1;
            $newStrategic->yearID = $toYearID;
            $newStrategic->save();

            // 3. replicate SFA ทั้งหมด
            foreach ($strategic->Target as $target) {
                $newtarget = $target->replicate();
                $newtarget->tar1LVID = Target1Level::max('tar1LVID') + 1;
                $newtarget->stra1LVID = $newStrategic->stra1LVID;
                $newtarget->save(); 
            }
        });
        return redirect('/strategic1LV');
    }
         
        
    }
}
