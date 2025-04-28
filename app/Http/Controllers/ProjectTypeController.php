<?php

namespace App\Http\Controllers;

use App\Models\ProjectType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectTypeController extends Controller
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
        $project_type=DB::table('project_types')->get();
        return view('ProjectType.index',compact('project_type'));
    }

    function insert(Request $request ){
        $request->validate(
            [
                'name'=>'required'
            ],
            [
                'name.required'=>'กรุณากรอกประเภทงบประมาณ'
            ]
        );
        $project_type = new ProjectType();
        $project_type->name = $request->input('name');
        $project_type->save();
        return redirect('/projectType');
    }

    function delete($id){
        DB::table('project_types')->where('proTypeID',$id)->delete();
        return redirect('/projectType');
    }

    function edit($id){
        $project_type=DB::table('project_types')->where('proTypeID',$id)->first();
        return view('projectType.update',compact('project_type'));
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
        $project_type=[
            'name'=>$request->name
        ];
        DB::table('project_types')->where('proTypeID',$id)->update($project_type);
        return redirect('/projectType'); 
    }
}
