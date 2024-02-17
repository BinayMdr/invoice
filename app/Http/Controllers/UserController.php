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
            'password' => 'required',
            'confirm_password' => 'required',
            'group_id' => 'required'
        ]);

        if( User::where('email',$request->email)->get()->count() > 0) return redirect()->back()->with('error','Email already exist');
        if($request->password !== $request->confirm_password) return redirect()->back()->with("error","Password and confirm password doesn't matches");
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Hash::make($request->password),
            'group_id' => $request->group_id,
            'is_enabled' => $request->has('status') ? true : false
        ]);

        return redirect()->route('user')->with('success','User created');
    }

    public function edit(User $user)
    {
        return view('pages.user.edit-create',compact('user'));
    }

    public function update(Request $request,User $user)
    {
        $request->validate([
            'group_id' => 'required'
        ]);

        $data = [
            'is_enabled' => $request->has('status') ? true : false,
            'group_id'=> $request->group_id
        ];

        if(!is_null($request->password))
        {
            if($request->password !== $request->confirm_password) return redirect()->back()->with("error","Password and confirm password doesn't matches");
            
            $data['password'] = \Hash::make($request->password);
        } 

        $user->update($data);

        return redirect()->route('user')->with('success','User updated');
    }
}
