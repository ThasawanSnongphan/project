<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\Year;
use App\Models\Strategic2Level;
use App\Models\StrategicIssues2Level;
use App\Models\KPIMain2Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KPIMain2LevelController extends Controller
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
        $year = Year::all();
        $strategic = Strategic2Level::all();
        $SFA = StrategicIssues2Level::all();
        $KPIMain=KPIMain2Level::with('SFA.strategic.year','director','recorder')->get();
        $user=Users::all();
        return view('Strategic2Level.KPIMain.index',compact('user','year','strategic','SFA','KPIMain'));
    }

    function insert(Request $request){
        $SFA = StrategicIssues2Level::where('SFA2LVID',$request->input('SFA2LVID'))->first();
        $request->validate(
            [
                'name' => 'required'
            ]
        );
        $KPIMain = new KPIMain2Level();
        $KPIMain->name = $request->input('name');
        $KPIMain->count = $request->input('count') ?? null;
        $KPIMain->target = $request->input('target') ?? null;
        $KPIMain->SFA2LVID = $SFA->SFA2LVID;
        $KPIMain->directorID = $request->input('directorID') ?? null;
        $KPIMain->recorderID = $request->input('recorderID') ?? null;
        $KPIMain->save();
        return redirect('/KPIMain2LV');
    }

    function edit($id){
        $year = Year::all();
        $strategic = Strategic2Level::all();
        $SFA = StrategicIssues2Level::all();
        $KPIMain = KPIMain2Level::with(['SFA.strategic.year'])->where('KPIMain2LVID',$id)->first();
        $user = Users::all();
        return view('Strategic2Level.KPIMain.update',compact('year','strategic','SFA','KPIMain','user'));
    }

    function update(Request $request,$id){
        $KPIMain=[
            'name' => $request->name,
            'count' => $request->count,
            'target' => $request->target,
            'SFA2LVID' => $request->SFA2LVID,
            'directorID' => $request->directorID,
            'recorderID' => $request->recorderID
        ];
        DB::table('k_p_i_main2_levels')->where('KPIMain2LVID',$id)->update($KPIMain);
        return redirect('/KPIMain2LV');
    }

    function delete($id){
        DB::table('k_p_i_main2_levels')->where('KPIMain2LVID',$id)->delete();
        return redirect('/KPIMain2LV');
    }
}
