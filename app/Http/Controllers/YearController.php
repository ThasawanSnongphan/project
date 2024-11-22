<?php

namespace App\Http\Controllers;

use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class YearController extends Controller
{
    function index(){
        $year=DB::table('years')->get();
        return view('Year.index',compact('year'));
    }

    function create(){
        return view('Year.create');
    }

    function insert(Request $request ){
        $request->validate(
            [
                'name'=>'required'
            ],
            [
                'name.required'=>'กรุณากรอกปีงบประมาณ'
            ]
        );
        $year = new Year();
        $year->name = $request->input('name');
        $year->save();
        return redirect('/year');
    }

    function delete($id){
        DB::table('years')->where('yearID',$id)->delete();
        return redirect('/year');
    }
}
