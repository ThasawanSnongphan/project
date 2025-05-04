<?php

namespace App\Http\Controllers;

use App\Models\ProjectCharec;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProCharecController extends Controller
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
        $pro_char=DB::table('project_charecs')->get();
        return view('ProjectCharac.index',compact('pro_char'));
    }

    

    function insert(Request $request ){
        
        $pro_char = new ProjectCharec();
        $pro_char->name = $request->input('name');
        $pro_char->save();
        return redirect('/proChar');
    }

    
    function delete($id){
        DB::table('project_charecs')->where('proChaID',$id)->delete();
        return redirect('/proChar');
    }

    function edit($id){
        $pro_char=DB::table('project_charecs')->where('proChaID',$id)->first();
        return view('ProjectCharac.update',compact('pro_char'));
    }
    function update(Request $request,$id){
        
        $pro_char=[
            'name'=>$request->name
        ];
        DB::table('project_charecs')->where('proChaID',$id)->update($pro_char);
        return redirect('/proChar'); 
    }


}
