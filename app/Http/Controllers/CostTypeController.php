<?php

namespace App\Http\Controllers;

use App\Models\CostTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CostTypeController extends Controller
{
    function index(){
        $cost_types=DB::table('cost_types')->get();
        return view('CostTypes.index',compact('cost_types'));
    }

    function create(){
        return view('CostTypes.create');
    }

    function delete($id){
        DB::table('cost_types')->where('id',$id)->delete();
        return redirect('/cost_type');
    }

    function insert(Request $request ){
        $request->validate(
            [
                'name'=>'required'
            ],
            [
                'name.required'=>'กรุณากรอกหมวดรายจ่าย'
            ]
        );
        $cost_types = new CostTypes();
        $cost_types->costname = $request->input('name');
        $cost_types->save();
        return redirect('/cost_type');
    }

    function edit($id){
        $cost_types=DB::table('cost_types')->where('id',$id)->first();
        return view('CostTypes.update',compact('cost_types'));
    }
    function update(Request $request,$id){
        $request->validate(
            [
                'costname'=>'required'
            ],
            [
                'costname.required'=>'กรุณากรอกหมวดรายจ่าย'
            ]
        );
        $cost_types=[
            'costname'=>$request->costname
        ];
        DB::table('cost_types')->where('id',$id)->update($cost_types);
        return redirect('/cost_type'); 
    }
}
