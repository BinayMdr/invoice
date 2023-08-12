<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('pages.user.index');
    }

    public function create()
    {
        $user = null;
        return view('pages.user.edit-create',compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'branch' => 'required',
            'password' => 'required',
            'confirm_password' => 'required'
        ]);

        if( User::where('email',$request->email)->get()->count() > 0) return redirect()->back()->with('error','Email already exist');
        if($request->password !== $request->confirm_password) return redirect()->back()->with("error","Password and confirm password doesn't matches");
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'branch' => $request->branch,
            'password' => \Hash::make($request->password),
            'is_enabled' => $request->has('status') ? true : false,
            'type' => 'user'
        ]);

        return redirect()->route('user')->with('success','User created');
    }

    public function edit(User $user)
    {
        return view('pages.user.edit-create',compact('user'));
    }

    public function update(Request $request,User $user)
    {
        // dd($request->all());
        $request->validate([
            'branch' => 'required'
        ]);

        if(!is_null($request->password))
        {
            if($request->password !== $request->confirm_password) return redirect()->back()->with("error","Password and confirm password doesn't matches");
            $user->update([
                'branch' => $request->branch,
                'password' => \Hash::make($request->password),
                'is_enabled' => $request->has('status') ? true : false
            ]);
        }   
        else
        {
            $user->update([
                'branch' => $request->branch,
                'is_enabled' => $request->has('status') ? true : false
            ]);
        }
        return redirect()->route('customer')->with('success','Customer updated');
    }
}
