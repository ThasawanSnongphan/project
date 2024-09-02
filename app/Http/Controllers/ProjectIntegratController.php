<?php

namespace App\Http\Controllers;

use App\Models\ProjectIntegrat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectIntegratController extends Controller
{
    function index(){
        $project_integrat=DB::table('project_integrats')->get();
        return view('ProjectIntegrat.index',compact('project_integrat'));
    }

    function insert(Request $request ){
        $request->validate(
            [
                'name'=>'required'
            ],
            [
                'name.required'=>'กรุณากรอกสถานะ'
            ]
        );
        $project_integrat = new ProjectIntegrat();
        $project_integrat->name = $request->input('name');
        $project_integrat->save();
        return redirect('/projectIntegrat');
    }

    function delete($id){
        DB::table('project_integrats')->where('id',$id)->delete();
        return redirect('/projectIntegrat');
    }

    function edit($id){
        $project_integrat=DB::table('project_integrats')->where('id',$id)->first();
        return view('ProjectIntegrat.update',compact('project_integrat'));
    }
    function update(Request $request,$id){
        $request->validate(
            [
                'name'=>'required'
            ],
            [
                'name.required'=>'กรุณากรอกสถานะ'
            ]
        );
        $project_integrat=[
            'name'=>$request->name
        ];
        DB::table('project_integrats')->where('id',$id)->update($project_integrat);
        return redirect('/projectIntegrat'); 
    }
}
