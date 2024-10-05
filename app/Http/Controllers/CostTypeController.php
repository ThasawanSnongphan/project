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
        $cost_types->costname = $request->input('name');
        $cost_types->expID = $expanses->expID;
        $cost_types->save();
        return redirect('/cost_type');
    }
    
    function delete($id){
        DB::table('cost_types')->where('id',$id)->delete();
        return redirect('/cost_type');
    }

    function edit($id){
        $cost_types=DB::table('cost_types')->where('id',$id)->first();
        return view('CostTypes.update',compact('cost_types'));
    }
    function update(Request $request,$id){
        $request->validate(
            [
                'costname'=>'required'
            ],
            [
                'costname.required'=>'กรุณากรอกหมวดรายจ่าย'
            ]
        );
        $cost_types=[
            'costname'=>$request->costname
        ];
        DB::table('cost_types')->where('id',$id)->update($cost_types);
        return redirect('/cost_type'); 
    }
}
