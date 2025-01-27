<?php

namespace App\Http\Controllers;

use App\Models\Year;
use App\Models\Strategic2Level;
use App\Models\StrategicIssues2Level;
use App\Models\KPIMain2Level;
use App\Models\Tactic2Level;
use App\Models\Tactic2LevelMapKPIMain2Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tactics2LevelController extends Controller
{
    function index(){
        $year=Year::all();
        $strategic=Strategic2Level::all();
        $SFA=StrategicIssues2Level::all();
        $tactics=Tactic2Level::with(['SFA.strategic.year','KPIMain'])->get();
        $KPIMain=KPIMain2Level::all();
        return view('Strategic2Level.Tactics.index',compact('tactics','SFA','strategic','year','KPIMain'));
    }

    function insert(Request $request){
        $SFA = StrategicIssues2Level::where('SFA2LVID',$request->input('SFA2LVID'))->first();
        $KPIMain = KPIMain2Level::where('KPIMain2LVID',$request->input('KPIMain2LVID'))->first();
        $request->validate(
            [
                'name' => 'required'
            ]
        );
        $tactics = new Tactic2Level();
        $tactics->name = $request->input('name');
        $tactics->SFA2LVID = $SFA->SFA2LVID;
        $tactics->save();

        $tactics = $tactics->fresh();

        $KPIMainMap = $request->input('KPIMain');
        // dd($KPIMainMap);
        if(is_array($KPIMainMap ) && !empty($KPIMainMap)){
            foreach($KPIMainMap as $index => $KPIMain ){
                $Map = new Tactic2LevelMapKPIMain2Level();
                $Map->KPIMain2LVID = $KPIMain ?? null;
                $Map->tac2LVID = $tactics->tac2LVID;
                $Map->save();
            }
        }
        return redirect('/tactic2LV');
    }

    function edit($id){
        $tactics=Tactic2Level::with(['SFA.strategic.year', 'KPIMain'])->where('tac2LVID',$id)->first();
        $year=Year::all();
        $strategic=Strategic2Level::all();
        $SFA=StrategicIssues2Level::all();
        $KPIMainMaps=Tactic2LevelMapKPIMain2Level::all();
        $KPIMainMap=$KPIMainMaps->where('tac2LVID',$tactics->tac2LVID)->first();
        // dd($KPIMainMap);
        $KPIMain=KPIMain2Level::all();
        return view('Strategic2Level.Tactics.update',compact('year','strategic','SFA','tactics','KPIMainMaps','KPIMain','KPIMainMap'));
    }
    function update(Request $request,$id){
        $tactics=[
            'SFA2LVID'=>$request->SFA2LVID,
            'name'=>$request->name
        ];
        DB::table('tactic2_levels')->where('tac2LVID',$id)->update($tactics);

        $KPIMainMaps = DB::table('tactic2_level_map_k_p_i_main2_levels')->where('tac2LVID',$id)->get();
        $KPIMainIDs = $KPIMainMaps->pluck('KPIMain2LVID')->toArray();
        $KPIMain = $request->KPIMain2LVID;
        // dd($KPIMain);
        foreach ($KPIMain as $index => $item) {
            if(isset($item)){
                $currentKPIMainID = $item;
                if(in_array($currentKPIMainID,$KPIMainIDs)){
                    // dd($currentKPIMainID,$KPIMainIDs);
                    DB::table('tactic2_level_map_k_p_i_main2_levels')->updateOrInsert(
                        [
                            'KPIMain2LVID' => $currentKPIMainID,
                            'tac2LVID' => $id
                        ],
                        [
                            'KPIMain2LVID' => $currentKPIMainID,
                            'tac2LVID' => $id,
                            'updated_at' => now()
                        ]
                    );
                }else{
                    // dd($currentKPIMainID,$KPIMainIDs);
                    DB::table('tactic2_level_map_k_p_i_main2_levels')->insert(
                        [
                            'KPIMain2LVID' => $item,
                            'tac2LVID' => $id,
                            'updated_at' => now(), 
                            'created_at' => now() 
                        ]
                    );
                }
            }else{
                DB::table('tactic2_level_map_k_p_i_main2_levels')->insert(
                    [
                        'KPIMain2LVID' => $item,
                        'tac2LVID' => $id,
                        'updated_at' => now(), 
                        'created_at' => now() 
                    ]
                );
            }
        }
        $KPIMainMapToDelete = array_diff($KPIMainIDs,$KPIMain);
        if(!empty($KPIMainMapToDelete)){
            DB::table('tactic2_level_map_k_p_i_main2_levels')
            ->where('tac2LVID',$id)
            ->whereIn('KPIMain2LVID',$KPIMainMapToDelete)
            ->delete();
        }
        return redirect('/tactic2LV'); 
    }

    function delete($id){
        DB::table('tactic2_levels')->where('tac2LVID',$id)->delete();
        return redirect('/tactic2LV');
    }
}
