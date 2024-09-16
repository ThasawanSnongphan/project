<?php

namespace App\Http\Controllers;

use App\Models\Strategics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SFAController extends Controller
{
    function index(){
        $strategic=DB::table('strategics')->get();
        return view('SFA.index',compact('strategic'));
    }
}
