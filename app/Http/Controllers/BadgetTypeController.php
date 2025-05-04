<?php

namespace App\Http\Controllers;

use App\Models\BadgetType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BadgetTypeController extends Controller
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
        $badget_type=DB::table('badget_types')->get();
        return view('BadgetType.index',compact('badget_type'));
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
        $badget_type = new BadgetType();
        $badget_type->name = $request->input('name');
        $badget_type->save();
        return redirect('/BadgetType');
    }

    function delete($id){
        DB::table('badget_types')->where('badID',$id)->delete();
        return redirect('/BadgetType');
    }

    function edit($id){
        $badget_type=DB::table('badget_Types')->where('badID',$id)->first();
        return view('BadgetType.update',compact('badget_type'));
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
        DB::table('badget_types')->where('badID',$id)->update($badget_type);
        return redirect('/BadgetType'); 
    }
}
