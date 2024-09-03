<?php

namespace App\Http\Controllers;

use App\Models\ProjectCharec;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProCharecController extends Controller
{
    function index(){
        $pro_char=DB::table('project_charecs')->get();
        return view('ProjectCharac.index',compact('pro_char'));
    }

    function create(){
        return view('ProjectCharac.create');
    }

    function insert(Request $request ){
        $request->validate(
            [
                'name'=>'required'
            ],
            [
                'name.required'=>'กรุณากรอกลักษณะโครงการ'
            ]
        );
        $pro_char = new ProjectCharec();
        $pro_char->pro_cha_name = $request->input('name');
        $pro_char->save();
        return redirect('/proChar');
    }

    
    function delete($id){
        DB::table('project_charecs')->where('id',$id)->delete();
        return redirect('/proChar');
    }

    function edit($id){
        $pro_char=DB::table('project_charecs')->where('id',$id)->first();
        return view('ProjectCharac.update',compact('pro_char'));
    }
    function update(Request $request,$id){
        $request->validate(
            [
                'name'=>'required'
            ],
            [
                'name.required'=>'กรุณากรอกลักษณะโครงการ'
            ]
        );
        $pro_char=[
            'pro_cha_name'=>$request->name
        ];
        DB::table('project_charecs')->where('id',$id)->update($pro_char);
        return redirect('/ProjectCharac.index'); 
    }


}
