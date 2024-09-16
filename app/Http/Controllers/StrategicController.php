<?php

namespace App\Http\Controllers;

use App\Models\Year;
use App\Models\Strategics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StrategicController extends Controller
{
    function index(){
        $year=DB::table('years')->get();
        $strategic=DB::table('strategics')->get();
        return view('Strategics.index',compact('year','strategic'));
    }
    function create(){
        $year = Year::all();
        return view('Strategics.create', compact('year'));
    }
    
    function insert(Request $request){
        $year = Year::where('yearID',$request->input('yearID'))->first();
        $request->validate(
            [
                'name'=>'required'
            ]
        );

        $strategic = new Strategics();
        $strategic->name = $request->input('name');
        $strategic->yearID = $year->yearID;
        $strategic->save();
        return redirect('/strategic');

    }

    function delete($id){
        DB::table('strategics')->where('straID',$id)->delete();
        return redirect('/strategic');
    }

    function edit($id){
        $strategic=DB::table('strategics')->where('straID',$id)->first();
        $year = Year::all(); 
        return view('Strategics.update',compact('strategic','year'));
    }
    function update(Request $request,$id){
        $year = Year::where('yearID',$request->input('yearID'))->first();
        // $request->validate(
        //     [
        //         'name'=>'required'
        //     ],
        //     [
        //         'name.required'=>'กรุณากรอกแผนยุทธศาสตร์'
        //     ]
        // );
        $strategic=[
            'yearID'=>$request->yearID,
            'name'=>$request->name
        ];
        DB::table('strategics')->where('straID',$id)->update($strategic);
        return redirect('/strategic'); 
    }
}
