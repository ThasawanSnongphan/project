<?php

namespace App\Http\Controllers;

use App\Models\ProjectCharec;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProCharecController extends Controller
{
    function index(){
        $pro_char=DB::table('project_charecs')->get();
        return view('ProjectCharac.index',compact('pro_char'));
    }

    function create(){
        return view('ProjectCharac.create');
    }

    function insert(Request $request ){
        $request->validate(
            [
                'name'=>'required'
            ],
            [
                'name.required'=>'กรุณากรอกลักษณะโครงการ'
            ]
        );
        $pro_char = new ProjectCharec();
        $pro_char->pro_cha_name = $request->input('name');
        $pro_char->save();
        return redirect('/proChar');
    }

}
