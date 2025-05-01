<?php

namespace App\Http\Controllers;

use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class YearController extends Controller
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
        $year=DB::table('years')->get();
        return view('Year.index',compact('year'));
    }

    function create(){
        return view('Year.create');
    }

    function insert(Request $request ){
        $request->validate(
            [
                'year'=>'unique:years,year'
            ]
        );
        $year = new Year();
        $year->year = $request->input('year');
        $year->save();
        return redirect('/year');
    }

    function delete($id){
        DB::table('years')->where('yearID',$id)->delete();
        return redirect('/year');
    }
}
