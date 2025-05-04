<?php

namespace App\Http\Controllers;

use App\Models\Year;
use App\Models\Strategic1Level;
use App\Models\Target1Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Target1LevelController extends Controller
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
        $strategic=Strategic1Level::all();
        $target=Target1Level::with(['strategic.year'])->get();
        return view('Strategic1Level.Targets.index',compact('strategic','year','target'));
    }

    function insert(Request $request){
        $strategic = Strategic1Level::where('stra1LVID',$request->input('stra1LVID'))->first();
        $request->validate(
            [
                'name' => 'required'
            ]
        );
        $target = new Target1Level();
        $target->name = $request->input('name');
        $target->stra1LVID = $strategic->stra1LVID;
        $target->save();
        return redirect('/target1LV');
    }

    function edit($id){
        $year = Year::all();
        $strategic = Strategic1Level::all();
        $target = Target1Level::with(['strategic.year'])->where('tar1LVID',$id)->first();
        return view('Strategic1Level.Targets.update',compact('year','strategic','target'));
    }

    function update(Request $request,$id){
        // $strategic = Strategic2Level::where('stra2LVID',$request->input('stra2LVID'))->first();
        $target = [
            'stra1LVID'=>$request->stra1LVID,
            'name' => $request->name
        ];
        DB::table('target1_levels')->where('tar1LVID',$id)->update($target);
        return redirect('/target1LV');
    }

    function delete($id){
        DB::table('target1_levels')->where('tar1LVID',$id)->delete();
        return redirect('/target1LV');
    }
}
