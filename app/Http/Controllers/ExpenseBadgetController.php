<?php

namespace App\Http\Controllers;

use App\Models\UniPlan;
use App\Models\Funds;
use App\Models\ExpenseBadgets;
use App\Models\CostTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenseBadgetController extends Controller
{
    
    public function costTypes()
    {
        return $this->hasMany(CostTypes::class);
    }


    function index(){
        $plan=UniPlan::all();
        $fund=Funds::all();
        $expense=ExpenseBadgets::all();
        return view('ExpenseBadgets.index',compact('expense','fund','plan'));
    }

    function create(){
        return view('ExpenseBadgets.create');
    }

    function insert(Request $request ){
        $fund=Funds::where('fundID',$request->input('fundID'))->first();
        $request->validate(
            [
                'name'=>'required'
            ],
            [
                'name.required'=>'กรุณากรอกงบรายจ่าย'
            ]
        );
        $expense = new ExpenseBadgets();
        $expense->exname = $request->input('name');
        $expense->fundID = $fund->fundID;
        $expense->save();
        return redirect('/Expense');
    }

    function delete($id){
        DB::table('expense_badgets')->where('expID',$id)->delete();
        return redirect('/Expense');
    }

    function edit($id){
        $expanse=DB::table('expense_badgets')->where('expID',$id)->first();
        return view('ExpenseBadgets.update',compact('expanse'));
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
        $expanse=[
            'exname'=>$request->name
        ];
        DB::table('expense_badgets')->where('expID',$id)->update($expanse);
        return redirect('/Expense'); 
        
    }
}
