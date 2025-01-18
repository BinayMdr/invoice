<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {   
        if(Auth::check()) return redirect()->route('dashboard');
        if($request->isMethod("POST"))
        {
            $request->validate([
                "email" => "required|email",
                "password" => "required"
            ]);
    
            $user = User::where('email',$request->email)
                            ->where('is_enabled',true)
                            ->first();
    
            $credentials = $request->only("email","password");
            
            if(is_null($user))
            {
                return redirect()->back()->with("error","Invalid credentials");
            }
            else
            {
                if(Auth::attempt($credentials,$request->remember)) return redirect()->back()->with("success","Signed in");
                else return redirect()->back()->with("error","Invalid credentials");
            }
        }
        return view("pages.login")->with('success','Wes');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
