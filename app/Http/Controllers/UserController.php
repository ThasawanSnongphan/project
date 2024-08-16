<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function index(){
        $users=DB::table('users')->get();
        return view('Users.index',compact('users'));
    }
    
    function create(){
        return view('Users.create');
    }

    public function insert(Request $request){
        $users = new Users();
        $users->username = $request->input('username');
        $users->email = $request->input('email');
        $users->password = Hash::make($request->input('password'));
        $users->account_type = $request->input('account_type');
        $users->full_prefix_name_th = $request->input('full_prefix_name_th');
        $users->firstname_th = $request->input('firstname_th');
        $users->lastname_th = $request->input('lastname_th');
        $users->firstname_en = $request->input('firstname_en');
        $users->lastname_en = $request->input('lastname_en');
        $users->personnel_type_id = $request->input('personnel_type_id');
        $users->personnel_type_name = $request->input('personnel_type_name');
        $users->position_id = $request->input('position_id');
        $users->position_name = $request->input('position_name');
        $users->position_type_id = $request->input('position_type_id');
        $users->position_type_th = $request->input('position_type_th');
        $users->faculty_code = $request->input('faculty_code');
        $users->faculty_name = $request->input('faculty_name');
        $users->department_code = $request->input('department_code');
        $users->department_name = $request->input('department_name');
        $users->Executive = $request->input('Executive');
        $users->Planning_Analyst = $request->input('Planning_Analyst');
        $users->Department_head = $request->input('Department_head');
        $users->Supply_Analyst = $request->input('Supply_Analyst');
        $users->Responsible = $request->input('Responsible');
        $users->Admin = $request->input('Admin');
        $users->flag = $request->input('flag');
        $users->save();
        return redirect('/users');
    }

    function delete($id){
        DB::table('users')->where('id',$id)->delete();
        return redirect('/users');
    }

    function edit($id){
        $users=DB::table('users')->where('id',$id)->first();
        return view('Users.update',compact('users'));
    }
    function update(Request $request,$id){
        $request->validate(
            [
                'username'=>'required',
                'email'=>'required',
                'password'=>'required',
                'account_type'=>'required',
                'full_prefix_name_th'=>'required',
                'firstname_th'=>'required',
                'lastname_th'=>'required',
                'firstname_en'=>'required',
                'lastname_en'=>'required',
                'personnel_type_id'=>'required',
                'personnel_type_name'=>'required',
                'position_id'=>'required',
                'position_name'=>'required',
                'position_type_id'=>'required',
                'position_type_th'=>'required',
                'faculty_code'=>'required',
                'faculty_name'=>'required',
                'department_code'=>'required',
                'department_name'=>'required',
                'Executive'=>'required',
                'Planning_Analyst'=>'required',
                'Department_head'=>'required',
                'Supply_Analyst'=>'required',
                'Responsible'=>'required',
                'Admin'=>'required',
                'flag'=>'required'
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
                'password'=>$request->password,
                'account_type'=>$request->account_type,
                'full_prefix_name_th'=>$request->full_prefix_name_th,
                'firstname_th'=>$request->firstname_th,
                'lastname_th'=>$request->lastname_th,
                'firstname_en'=>$request->firstname_en,
                'lastname_en'=>$request->lastname_en,
                'personnel_type_id'=>$request->personnel_type_id,
                'personnel_type_name'=>$request->personnel_type_name,
                'position_id'=>$request->position_id,
                'position_name'=>$request->position_name,
                'position_type_id'=>$request->position_type_id,
                'position_type_th'=>$request->position_type_th,
                'faculty_code'=>$request->faculty_code,
                'faculty_name'=>$request->faculty_name,
                'department_code'=>$request->department_code,
                'department_name'=>$request->department_name,
                'Executive'=>$request->Executive,
                'Planning_Analyst'=>$request->Planning_Analyst,
                'Department_head'=>$request->Department_head,
                'Supply_Analyst'=>$request->Supply_Analyst,
                'Responsible'=>$request->Responsible,
                'Admin'=>$request->Admin,
                'flag'=>$request->flag
        ];
        DB::table('users')->where('id',$id)->update($users);
        return redirect('/users'); 
    }
}