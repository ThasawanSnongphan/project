<?php

namespace App\Http\Controllers;

use App\Models\UniPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UniPlanController extends Controller
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
        DB::table('uni_plans')->where('planID',$id)->delete();
        return redirect('/plan');
    }

    function edit($id){
        $plan=DB::table('uni_plans')->where('planID',$id)->first();
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
        DB::table('uni_plans')->where('planID',$id)->update($plan);
        return redirect('/plan'); 
    }
}
