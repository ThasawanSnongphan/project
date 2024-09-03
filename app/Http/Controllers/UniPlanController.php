<?php

namespace App\Http\Controllers;

use App\Models\UniPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UniPlanController extends Controller
{
    function index(){
        $plan=DB::table('uni_plans')->get();
        return view('UniPlan.index',compact('plan'));
    }

    function create(){
        return view('Uniplan.create');
    }

    function insert(Request $request ){
        $request->validate(
            [
                'name'=>'required'
            ],
            [
                'name.required'=>'กรุณากรอกแผนงานมหาวิทยาลัย'
            ]
        );
        $plan = new UniPlan();
        $plan->name = $request->input('name');
        $plan->save();
        return redirect('/plan');
    }

    function delete($id){
        DB::table('uni_plans')->where('id',$id)->delete();
        return redirect('/plan');
    }

    function edit($id){
        $plan=DB::table('uni_plans')->where('id',$id)->first();
        return view('UniPlan.update',compact('plan'));
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
        $plan=[
            'name'=>$request->name
        ];
        DB::table('uni_plans')->where('id',$id)->update($plan);
        return redirect('/plan'); 
    }
}
