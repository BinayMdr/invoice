<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function update_password(Request $request)
    {
        $request->validate([
            "old_password" => "required",
            "new_password" => "required",
            "confirm_password" => "required",
        ]);

        if(!\Hash::check($request->old_password,Auth::user()->password)) return redirect()->back()->with("error","Invalid password");
        if($request->old_password === $request->new_password) return redirect()->back()->with("error","New password matches old password");
        if($request->new_password !== $request->confirm_password) return redirect()->back()->with("error","New password and confirm password doesn't matches");
        
        Auth::user()->update([
            'password' => \Hash::make($request->new_password)
        ]);
        
        return redirect()->back()->with("success","Password updated");
    }
}
