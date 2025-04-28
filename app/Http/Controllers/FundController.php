<?php

namespace App\Http\Controllers;

use App\Models\UniPlan;
use App\Models\Funds;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FundController extends Controller
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
        $plan=UniPlan::all();
        $fund=DB::table('funds')->get();
        return view('Funds.index',compact('plan','fund'));
    }

    function insert(Request $request){
        $plan = UniPlan::where('planID',$request->input('planID'))->first();
        $request->validate(
            [
                'name'=>'required'
            ]
        );

        $fund = new Funds();
        $fund->name = $request->input('name');
        $fund->planID = $plan->planID;
        $fund->save();
        return redirect('/fund');

    }

    function delete($id){
        DB::table('funds')->where('fundID',$id)->delete();
        return redirect('/fund');
    }

    function edit($id){
        $fund=DB::table('funds')->where('fundID',$id)->first();
        $plan = UniPlan::all(); 
        return view('Funds.update',compact('fund','plan'));
    }
    function update(Request $request,$id){
        $plan = UniPlan::where('planID',$request->input('planID'))->first();
        // $request->validate(
        //     [
        //         'name'=>'required'
        //     ],
        //     [
        //         'name.required'=>'กรุณากรอกแผนยุทธศาสตร์'
        //     ]
        // );
        $fund=[
            'planID'=>$request->planID,
            'name'=>$request->name
        ];
        DB::table('funds')->where('fundID',$id)->update($fund);
        return redirect('/fund'); 
    }
}
