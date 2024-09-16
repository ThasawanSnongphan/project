<?php

namespace App\Http\Controllers;

use App\Models\ExpenseBadgets;
// use App\Models\CostTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenseBadgetController extends Controller
{
    
    // public function costTypes()
    // {
    //     return $this->hasMany(CostTypes::class);
    // }


    function index(){
        $expense=DB::table('expense_badgets')->get();
        return view('ExpenseBadgets.index',compact('expense'));
    }

    function create(){
        return view('ExpenseBadgets.create');
    }

    function insert(Request $request ){
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
