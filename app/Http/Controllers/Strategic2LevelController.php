<?php

namespace App\Http\Controllers;

use App\Models\Year;
use App\Models\Strategic2Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Strategic2LevelController extends Controller
{
    function index(){
        $year=Year::all();
        $strategic=Strategic2Level::all();
        return view('Strategic2Level.Strategics.index',compact('year','strategic'));
    }

    function insert(Request $request){
        $year = Year::where('yearID',$request->input('yearID'))->first();
        $request->validate(
            [
                'name'=>'required'
            ]
        );

        $strategic = new Strategic2Level();
        $strategic->name = $request->input('name');
        $strategic->yearID = $year->yearID;
        $strategic->save();
        return redirect('/strategic2LV');

    }

    function edit($id){
        $strategic=DB::table('strategic2_levels')->where('stra2LVID',$id)->first();
        
        $year = Year::all(); 
        return view('Strategic2Level.Strategics.update',compact('strategic','year'));
    }

    function update(Request $request,$id){
        $year = Year::where('yearID',$request->input('yearID'))->first();
        
        $strategic=[
            'yearID'=>$request->yearID,
            'name'=>$request->name
        ];
        DB::table('strategic2_levels')->where('stra2LVID',$id)->update($strategic);
        return redirect('/strategic2LV'); 
    }

    function delete($id){
        $strategic = DB::table('strategic2_levels')->where('stra2LVID',$id)->delete();
        return redirect('/strategic2LV');
    }
}
