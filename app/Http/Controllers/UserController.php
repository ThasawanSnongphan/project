<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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
        $users=DB::table('users')->get();
        return view('Users.index',compact('users'));
    }
    
    function create(){
        return view('Users.create');
    }

    function insert(Request $request){
       
       
        $users = new User();
        $users->username = $request->input('username');
        $users->email = $request->input('email');
        $users->password = Hash::make($request->input('password'));
        $users->displayname = $request->input('displayname');
        $users->person_key = $request->input('person_key');
       
        $users->position_name = $request->input('position_name');
       
        $users->faculty_name = $request->input('faculty_name');
       
        $users->department_name = $request->input('department_name');
        $users->executive = $request->has('executive') ? true : false;
        $users->Planning_Analyst = $request->has('Planning_Analyst') ? true : false;
        $users->Department_head = $request->has('Department_head') ? true : false;
        $users->Supply_Analyst = $request->has('Supply_Analyst') ? true : false;
        $users->Responsible = $request->has('Responsible') ? true : false;
        $users->Admin = $request->has('Admin') ? true : false;
        $users->flag = $request->has('flag') ? true : false;
        $users->save();
        return redirect('/users');
    }

    function delete($id){
        DB::table('users')->where('userID',$id)->delete();
        return redirect('/users');
    }

    function edit($id){
        $users=DB::table('users')->where('userID',$id)->first();
        return view('Users.update',compact('users'));
    }
    function update(Request $request,$id){
        $request->validate(
            [
                
            ],
            [
                // 'title.required'=>'กรุณากรอกหัวข้อข่าว',
                // 'content.required'=>'กรุณากรอกรายละเอียดข่าว',
                // 'img.nullable'=>'กรุณาใส่รูปภาพ'
            ]
        );
        $users=[
            'username'=>$request->username,
                'email'=>$request->email,
                'displayname' =>$request->displayname,
                'person_key' => $request->person_key,
                // 'password'=>Hash::make($request->input('password')),
                // 'account_type'=>$request->account_type,
                // 'full_prefix_name_th'=>$request->full_prefix_name_th,
                // 'firstname_th'=>$request->firstname_th,
                // 'lastname_th'=>$request->lastname_th,
                // 'firstname_en'=>$request->firstname_en,
                // 'lastname_en'=>$request->lastname_en,
                // 'personnel_type_id'=>$request->personnel_type_id,
                // 'personnel_type_name'=>$request->personnel_type_name,
                // 'position_id'=>$request->position_id,
                'position_name'=>$request->position_name,
                // 'position_type_id'=>$request->position_type_id,
                // 'position_type_th'=>$request->position_type_th,
                // 'faculty_code'=>$request->faculty_code,
                'faculty_name'=>$request->faculty_name,
                // 'department_code'=>$request->department_code,
                'department_name'=>$request->department_name,
                'Executive'=>$request->has('Executive') ? true : false,
                'Planning_Analyst'=>$request->has('Planning_Analyst') ? true : false,
                'Department_head'=>$request->has('Department_head') ? true : false,
                'Supply_Analyst'=>$request->has('Supply_Analyst') ? true : false,
                'Responsible'=>$request->has('Responsible') ? true : false,
                'Admin'=>$request->has('Admin') ? true : false,
                'flag'=>$request->has('flag') ? true : false
        ];
        DB::table('users')->where('userID',$id)->update($users);
        return redirect('/users'); 
    }
}