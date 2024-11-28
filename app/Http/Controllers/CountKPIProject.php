<?php

namespace App\Http\Controllers;

use App\Models\CountKPIProjects;
use Illuminate\Http\Request;

class CountKPIProject extends Controller
{
    //
    function index(){
        $countKPI = CountKPIProjects::all();
        return view('CountKPIProject.index',compact('countKPI'));
    }

    function edit($id){

    }

    function delect($id){
        DB::table('count_k_p_i_projects')->where('countKPIProID',$id)->delete();
        return redirect('/countKPI');
   
    }
}
