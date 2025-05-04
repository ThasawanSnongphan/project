<?php

namespace App\Http\Controllers;

use App\Models\Year;
use App\Models\Strategic3Level;
use App\Models\StrategicIssues;
use App\Models\Goals;
use App\Models\Tactics;
use App\Models\KPIMains;
use App\Models\KPIMainMapTactics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TacticsController extends Controller
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
        $SFA=StrategicIssues::all();
        $goal=Goals::all();
        $tactics=Tactics::with(['goal.SFA.strategic.year', 'KPIMain'])->get();
        $KPIMain=KPIMains::all();
        return view('Strategic3Level.Tactics.index',compact('goal','tactics','SFA','strategic','year','KPIMain'));
    }

    function insert(Request $request){
        $goal = Goals::where('goal3LVID',$request->input('goalID'))->first();
        $KPIMain = KPIMains::where('KPIMain3LVID',$request->input('KPIMainID'))->first();
        $request->validate(
            [
                'name'=>'required'
            ]
        );
        $tactics = new Tactics();
        $tactics->name = $request->input('name');
        $tactics->goal3LVID = $goal->goal3LVID;
        $tactics->save();

        $tactics = $tactics->fresh();

        $KPIMainMap = $request->input('KPIMain');
        if(is_array($KPIMainMap)){
            foreach($KPIMainMap as $index => $KPIMain ){
                $Map = new KPIMainMapTactics();
                $Map->KPIMain3LVID = $KPIMain ?? null;
                $Map->tac3LVID = $tactics->tac3LVID;
                $Map->save();
            }
        }
        return redirect('/tactics');
    }

    function delete($id){
        DB::table('tactics')->where('tac3LVID',$id)->delete();
        return redirect('/tactics');
    }

    function edit($id){
        $tactics=Tactics::with(['goal.SFA.strategic.year', 'KPIMain'])->where('tac3LVID',$id)->first();
        $year=Year::all();
        $strategic=Strategic3Level::all();
        $SFA=StrategicIssues::all();
        $goal=Goals::all();
        $KPIMainMaps=KPIMainMapTactics::all();
        $KPIMainMap = $KPIMainMaps->where('tac3LVID',$tactics->tac3LVID)->first();
      
        $KPIMain=KPIMains::all();
        return view('Strategic3Level.Tactics.update',compact('year','strategic','SFA','goal','tactics','KPIMainMaps','KPIMainMap','KPIMain'));
    }
    function update(Request $request,$id){
        $tactics=[
            'goal3LVID'=>$request->goalID,
            'name'=>$request->name
        ];
        DB::table('tactics')->where('tac3LVID',$id)->update($tactics);

        
        $KPIMainMaps = Db::table('k_p_i_main_map_tactics')->where('tac3LVID',$id)->get();
        $KPIMainIDs =$KPIMainMaps->pluck('KPIMain3LVID')->toArray();
        $KPIMain = $request->KPIMain;
        // dd($KPIMainMaps,$KPIMainIDs,$KPIMain);
        foreach($KPIMain as $index => $kpi){
            if(isset($kpi)){
                $currentKPIMainID = $kpi;
                if(in_array($currentKPIMainID,$KPIMainIDs)){
                    DB::table('k_p_i_main_map_tactics')->updateOrInsert(
                    [
                        'KPIMain3LVID' => $currentKPIMainID,
                        'tac3LVID' => $id
                    ],
                    [
                        'tac3LVID' => $id,
                        'updated_at' => now()
                    ]
                    );
                }else{
                    Db::table('k_p_i_main_map_tactics')->insert(
                        [
                            'KPIMain3LVID' => $kpi,
                            'tac3LVID' => $id,
                            'updated_at' => now(), 
                            'created_at' => now() 
                        ]
                    );
                }
            }else{
                DB::table('k_p_i_main_map_tactics')->insert(
                    [
                        'KPIMain3LVID' => $kpi,
                        'tac3LVID' => $id,
                        'updated_at' => now(), 
                        'created_at' => now() 
                    ]
                );
            }
        }
        $KPIMainMapToDelete = array_diff($KPIMainIDs,$KPIMain);
        if(!empty($KPIMainMapToDelete)){
            DB::table('k_p_i_main_map_tactics')
            ->where('tac3LVID',$id)
            ->whereIn('KPIMain3LVID',$KPIMainMapToDelete)
            ->delete();
        }
        return redirect('/tactics'); 
    }

}