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
            "email" => "required",
            "password" => "required"
        ]);
        $login = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        // if (Auth::guard('web')->attempt($login)) {
        //      return redirect("/");
        // }
        if(Auth::attempt($login)){
            return redirect("/");
        } else {
            // ล็อกอินล้มเหลว
            return redirect()->back()->withErrors([
                'email' => 'Invalid credentials',
                'password' => 'Invalid credentials'
            ]);
        }
    }
}
