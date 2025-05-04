<?php

namespace App\Http\Controllers;

use App\Models\Targets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class TargetController extends Controller
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
        $target=DB::table('targets')->get();
        return view('Targets.index',compact('target'));
    }

    function insert(Request $request ){
        $request->validate(
            [
                'name'=>'required'
            ],
            [
                'name.required'=>'กรุณากรอกกลุ่มเป้าหมาย'
            ]
        );
        $target = new Targets();
        $target->name = $request->input('name');
        $target->save();
        return redirect('/target');
    }

    function delete($id){
        DB::table('targets')->where('tarID',$id)->delete();
        return redirect('/target');
    }

    function edit($id){
        $target=DB::table('targets')->where('tarID',$id)->first();
        return view('Targets.update',compact('target'));
    }
    function update(Request $request,$id){
        $request->validate(
            [
                'name'=>'required'
            ],
            [
                'name.required'=>'กรุณากรอกแผนงานมหาวิทยาลัย'
            ]
        );
        $target=[
            'name'=>$request->name
        ];
        DB::table('targets')->where('tarID',$id)->update($target);
        return redirect('/target'); 
    }
}
