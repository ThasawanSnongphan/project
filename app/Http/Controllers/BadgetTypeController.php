<?php

namespace App\Http\Controllers;

use App\Models\BadgetType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BadgetTypeController extends Controller
{
    function index(){
        $badget_type=DB::table('badget_types')->get();
        return view('BadgetType.index',compact('badget_type'));
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
        $badget_type = new BadgetType();
        $badget_type->name = $request->input('name');
        $badget_type->save();
        return redirect('/BadgetType');
    }

    function delete($id){
        DB::table('badget_types')->where('id',$id)->delete();
        return redirect('/BadgetType');
    }

    function edit($id){
        $badget_type=DB::table('badget_Types')->where('id',$id)->first();
        return view('badgetType.update',compact('badget_type'));
    }
    function update(Request $request,$id){
        $request->validate(
            [
                'name'=>'required'
            ],
            [
                'name.required'=>'กรุณากรอกประเภทงบประมาณ'
            ]
        );
        $badget_type=[
            'name'=>$request->name
        ];
        DB::table('badget_types')->where('id',$id)->update($badget_type);
        return redirect('/BadgetType'); 
    }
}
