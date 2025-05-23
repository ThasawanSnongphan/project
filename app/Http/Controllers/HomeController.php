<?php

namespace App\Http\Controllers;

use App\Models\Year;
use App\Models\News;
use App\Models\Status;
use App\Models\Projects;
use App\Models\Users;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    
    public function index()
    {
        return view('home');
    }

    public function adminHome()
    {
        return view('/');
    }

    public function projectAll()
    {
        $year = Year::all();
        $projectYear = Projects::with('year')->get();
        $project=Projects::with('status')->whereIn('statusID',[4,8,9,10,11])->get();
        // dd($project);
        $status=Status::all();
        $users = $users=DB::table('users')->get();
        return view('Home.projectAll',compact('users','project','status','year','projectYear'));
    }

    public function news(){
        $data['news'] = News::all();
        return view('Home.News',compact('data'));
    }

    
}
