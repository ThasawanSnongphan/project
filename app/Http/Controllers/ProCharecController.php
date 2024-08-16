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

}
