<?php

namespace App\Http\Controllers;

use App\Models\UniPlan;
use App\Models\Funds;
use App\Models\ExpenseBadgets;
use App\Models\CostTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CostTypeController extends Controller
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
        $fund=Funds::all();
        $cost_types=CostTypes::all();
        $expanses = ExpenseBadgets::all();
        return view('CostTypes.index',compact('cost_types', 'expanses','plan','fund'));
    }

    function create(){
        $expanses = ExpenseBadgets::all();
        return view('CostTypes.create', compact('expanses'));
    }

    

    function insert(Request $request ){
        $expanses = ExpenseBadgets::where('expID', $request->input('expID'))->first();
        $request->validate(
            [
                'name'=>'required'
            ],
            [
                'name.required'=>'กรุณากรอกหมวดรายจ่าย'
            ]
        );
       
        $cost_types = new CostTypes();
        $cost_types->name = $request->input('name');
        $cost_types->expID = $expanses->expID;
        $cost_types->save();
        return redirect('/cost_type');
    }
    
    function delete($id){
        DB::table('cost_types')->where('costID',$id)->delete();
        return redirect('/cost_type');
    }

    function edit($id){
        $plan=UniPlan::all();
        $fund=Funds::all();
        $expanses = ExpenseBadgets::all();
        $cost_types=CostTypes::with('expense.fund.uniplan')->where('costID',$id)->first();
        return view('CostTypes.update',compact('plan','fund','expanses','cost_types'));
    }
    function update(Request $request,$id){
        $request->validate(
            [
                'name'=>'required'
            ],
            [
                'name.required'=>'กรุณากรอกหมวดรายจ่าย'
            ]
        );
        $cost_types=[
            'name'=>$request->name,
            'expID'=>$request->expID

        ];
        DB::table('cost_types')->where('costID',$id)->update($cost_types);
        return redirect('/cost_type'); 
    }
}
