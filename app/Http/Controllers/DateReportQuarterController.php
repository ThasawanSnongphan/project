<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Year;
use App\Models\Quarters;
use App\Models\DateReportQuarter;

class DateReportQuarterController extends Controller
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
        $data['year'] = Year::all();
        $data['quarter'] = Quarters::all();
        $data['date'] = DateReportQuarter::with('year','quarter')->get();
        return view('DateReportQuarter.index',compact('data'));
    }

    function insert(Request $request){
        $date = new DateReportQuarter();
        $date->startDate = $request->input('startDate');
        $date->endDate = $request->input('endDate');
        $date->yearID = $request->input('yearID');
        $date->quarID = $request->input('quarID');
        $date->save();

        return redirect('/dateReportQuarter');
    }

    function edit($id){
        $data['date'] = DateReportQuarter::find($id);
        $data['year'] = Year::all();
        $data['quarter'] = Quarters::all();
        return view('DateReportQuarter.update',compact('data'));
    }

    function update(Request $request,$id){
        $update = [
            'yearID' => $request->input('yearID'),
            'quarID' => $request->input('quarID'),
            'startDate' => $request->input('startDate'),
            'endDate' => $request->input('endDate')
        ];
        DB::table('date_report_quarters')->where('drqID',$id)->update($update);

        return redirect('/dateReportQuarter');
    }

    function delete($id){
        
        DB::table('date_report_quarters')->where('drqID',$id)->delete();
        return redirect('/dateReportQuarter');
    }
}
