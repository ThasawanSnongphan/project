<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatusController extends Controller
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
        $status=DB::table('statuses')->get();
        return view('Status.index',compact('status'));
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
        $status = new Status();
        $status->name = $request->input('name');
        $status->save();
        return redirect('/status');
    }

    function delete($id){
        DB::table('statuses')->where('statusID',$id)->delete();
        return redirect('/status');
    }

    function edit($id){
        $status=DB::table('statuses')->where('statusID',$id)->first();
        return view('Status.update',compact('status'));
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
        $status=[
            'name'=>$request->name
        ];
        DB::table('statuses')->where('statusID',$id)->update($status);
        return redirect('/status'); 
    }
}
