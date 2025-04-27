<?php

namespace App\Http\Controllers;

use App\Models\Year;
use App\Models\Strategic3Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StrategicController extends Controller
{
    
    function index(){
        $year=Year::all();
        $strategic=Strategic3Level::all();
        return view('Strategic3Level.Strategics.index',compact('year','strategic'));
    }
   
    
    function insert(Request $request){
        $year = Year::where('yearID',$request->input('yearID'))->first();
        $request->validate(
            [
                'name'=>'required'
            ]
        );

        $strategic = new Strategic3Level();
        $strategic->name = $request->input('name');
        $strategic->yearID = $year->yearID;
        $strategic->save();
        return redirect('/strategic');

    }

    function delete($id){
        DB::table('strategic3_levels')->where('stra3LVID',$id)->delete();
        return redirect('/strategic');
    }

    function edit($id){
        $strategic=DB::table('strategic3_levels')->where('stra3LVID',$id)->first();
        
        $year = Year::all(); 
        return view('Strategic3Level.Strategics.update',compact('strategic','year'));
    }
    function update(Request $request,$id){
        
        
        $strategic=[
            'yearID' => $request->yearID,
            'name'=>$request->name
        ];
        DB::table('strategic3_levels')->where('stra3LVID',$id)->update($strategic);
        return redirect('/strategic'); 
    }
}
