<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\Year;
use App\Models\Strategic3Level;
use App\Models\StrategicIssues;
use App\Models\Goals;
use App\Models\KPIMainMapProjects;
use App\Models\Tactics;
use App\Models\KPIMains;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KPIMainController extends Controller
{

    function index(){
        $user=Users::all();
        $year = Year::all(); // ดึงข้อมูลปี
        $strategic = Strategic3Level::all(); // ดึงข้อมูลแผนทั้งหมด
        $SFA = StrategicIssues::all();
        $goal = Goals::all();
        $KPIMain = KPIMains::with('goal.SFA.strategic.year', 'director', 'recorder')->get();
        return view('Strategic3Level.KPIMain.index', compact('user', 'year', 'strategic', 'SFA', 'goal', 'KPIMain'));
    }

    function insert(Request $request)
    {
        $goal = Goals::where('goal3LVID', $request->input('goalID'))->first();
        $request->validate(
            [
                'name' => 'required',
                'count' => 'required',
                'target' => 'required'
            ]
        );
        $KPIMain = new KPIMains();
        $KPIMain->name = $request->input('name');
        $KPIMain->count = $request->input('count');
        $KPIMain->target = $request->input('target');
        if (!empty($goal->goal3LVID)) {
            $KPIMain->goal3LVID = $goal->goal3LVID;
        }

        $KPIMain->directorID = $request->input('directorID');
        $KPIMain->recorderID = $request->input('recorderID');
        $KPIMain->save();
        return redirect('/KPIMain');
    }

    function edit($id)
    {
        $year = Year::all(); // ดึงข้อมูลปี
        $strategic = Strategic3Level::all(); // ดึงข้อมูลแผนทั้งหมด
        $SFA = StrategicIssues::all();
        $goal = Goals::all();
        $user = Users::all();

        $KPIMain = KPIMains::with(['goal.SFA.strategic.year'])->where('KPIMain3LVID', $id)->first();
        return view('Strategic3Level.KPIMain.update', compact('year', 'strategic', 'SFA', 'goal', 'KPIMain', 'user'));
    }
    function update(Request $request, $id)
    {
        // $tacID = Tactics::where('tacID',$request->input('tacID'))->first();
        $KPIMain = [
            'goal3LVID' => $request->goalID,
            'name' => $request->name,
            'count' => $request->count,
            'target' => $request->target,
            'directorID' => $request->director,
            'recorderID' => $request->recorder
        ];
        DB::table('k_p_i_mains')->where('KPIMain3LVID', $id)->update($KPIMain);
        return redirect('/KPIMain');
    }
    function delete($id)
    {
        DB::table('k_p_i_mains')->where('KPIMain3LVID', $id)->delete();
        return redirect('/KPIMain');
    }

    function report(Request $request)
    {
        $data['yearAll'] = Year::all();
        $data['selectYearID'] = $request->input('yearID');
        $data['year'] = Year::find($data['selectYearID']);
        $data['kpiMainID'] = KPIMainMapProjects::whereNotNull('proID')
            ->pluck('KPIMain3LVID')
            ->values();

        dd($data);

        return view('KPIMain_report.index', compact('data'));
    }
}
