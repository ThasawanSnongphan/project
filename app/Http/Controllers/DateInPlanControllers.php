<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Year;
use App\Models\DateInPlan;
use Illuminate\Support\Facades\DB;

class DateInPlanControllers extends Controller
{
    function index(){
        $data['year'] = Year::all();
        $data['date'] = DateInPlan::with('year')->get();
        // dd($data['date']);
        return view('DateInPlan.index',compact('data'));
    }

    function insert(Request $request){
        $data['date'] = new DateInPlan();
        $data['date']->startDate = $request->input('startDate');
        $data['date']->endDate = $request->input('endDate');
        $data['date']->yearID = $request->input('yearID');
        $data['date']->save();
        return redirect('/dateInPlan');
    }

    function delete($id){
        
        DB::table('date_in_plans')->where('id',$id)->delete();
        return redirect('/dateInPlan');
    }

    function edit($id){
        $data['year'] = Year::all();
        $data['date'] = DateInPlan::find($id);
        return view('DateInPlan.update',compact('data'));
    }
    function update(Request $request,$id){
        $update = [
            'yearID' => $request->input('yearID'),
            'startDate' => $request->input('startDate'),
            'endDate' => $request->input('endDate')
        ];
        DB::table('date_in_plans')->where('id',$id)->update($update);

        return redirect('/dateInPlan');
    }
}
