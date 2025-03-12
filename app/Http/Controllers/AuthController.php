<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    function login(){
        return view('login');
    }
   
    function loginPost(Request $request){
        $request->validate([
            "username" => "required",
            "password" => "required"
        ]);
        $login = [
            'username' => $request->input('username'),
            'password' => $request->input('password'),
        ];

        if(Auth::attempt($login)){
            return redirect("/");
        } else {
            // ล็อกอินล้มเหลว
            return redirect()->back()->withErrors([
                'username' => 'Invalid credentials',
                'password' => 'Invalid credentials'
            ]);
        }
    }
}
