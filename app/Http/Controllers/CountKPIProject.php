<?php

namespace App\Http\Controllers;

use App\Models\CountKPIProjects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CountKPIProject extends Controller
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
    
    //
    function index(){
        $countKPI = CountKPIProjects::all();
        return view('CountKPIProject.index',compact('countKPI'));
    }

    function insert(Request $request){
       $request->validate(
        [
            'name' => 'required'
        ]
        );

        $countKPI = new CountKPIProjects();
        $countKPI->name = $request->input('name');
        $countKPI->save();
        return redirect('/countKPI');
    }

    function edit($id){
        $countKPI = DB::table('count_k_p_i_projects')->where('countKPIProID',$id)->first();
        return view('CountKPIProject.update',compact('countKPI'));
    }
    function update(Request $request,$id){
        $countKPI=[
            'name'=>$request->name
        ];
        DB::table('count_k_p_i_projects')->where('countKPIProID',$id)->update($countKPI);
        return redirect('/countKPI'); 
    }

    function delete($id){
        DB::table('count_k_p_i_projects')->where('countKPIProID',$id)->delete();
        return redirect('/countKPI');
   
    }
}
