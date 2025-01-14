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
        
        $year=Year::all();
        $strategic=Strategics::all();
        $SFA=StrategicIssues::all();
        $goal=Goals::all();
        $tactics=Tactics::with(['goal.SFA.strategic.year', 'KPIMain'])->get();
        $KPIMain=KPIMains::all();
        return view('Strategic3Level.Tactics.index',compact('goal','tactics','SFA','strategic','year','KPIMain'));
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
        $KPIMainMaps=KPIMainMapTactics::all();
        $KPIMainMap = $KPIMainMaps->where('tacID',$tactics->tacID)->first();
      
        $KPIMain=KPIMains::all();
        return view('Strategic3Level.Tactics.update',compact('year','strategic','SFA','goal','tactics','KPIMainMaps','KPIMainMap','KPIMain'));
    }
    function update(Request $request,$id){
        $tactics=[
            'goalID'=>$request->goalID,
            'name'=>$request->name
        ];
        DB::table('tactics')->where('tacID',$id)->update($tactics);

        
        $KPIMainMaps = Db::table('k_p_i_main_map_tactics')->where('tacID',$id)->get();
        $KPIMainIDs =$KPIMainMaps->pluck('KPIMainID')->toArray();
        $KPIMain = $request->KPIMain;
        // dd($KPIMainMaps,$KPIMainIDs,$KPIMain);
        foreach($KPIMain as $index => $kpi){
            if(isset($kpi)){
                $currentKPIMainID = $kpi;
                if(in_array($currentKPIMainID,$KPIMainIDs)){
                    DB::table('k_p_i_main_map_tactics')->updateOrInsert(
                    [
                        'KPIMainID' => $currentKPIMainID,
                        'tacID' => $id
                    ],
                    [
                        'tacID' => $id,
                        'updated_at' => now()
                    ]
                    );
                }else{
                    Db::table('k_p_i_main_map_tactics')->insert(
                        [
                            'KPIMainID' => $kpi,
                            'tacID' => $id,
                            'updated_at' => now(), 
                            'created_at' => now() 
                        ]
                    );
                }
            }else{
                DB::table('k_p_i_main_map_tactics')->insert(
                    [
                        'KPIMainID' => $kpi,
                        'tacID' => $id,
                        'updated_at' => now(), 
                        'created_at' => now() 
                    ]
                );
            }
        }
        $KPIMainMapToDelete = array_diff($KPIMainIDs,$KPIMain);
        if(!empty($KPIMainMapToDelete)){
            DB::table('k_p_i_main_map_tactics')
            ->where('tacID',$id)
            ->whereIn('KPIMainID',$KPIMainMapToDelete)
            ->delete();
        }
        return redirect('/tactics'); 
    }

}