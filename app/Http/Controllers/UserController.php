<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        if(!\Auth::user()->hasRole('view-users')) return back();
        return view('pages.user.index');
    }

    public function create()
    {
        if(!\Auth::user()->hasRole('add-users')) return back();
        $user = null;
        $removeGroup = Group::where('name','Super Admin')->first();
        return view('pages.user.edit-create',compact('user','removeGroup'));
    }

    public function store(Request $request)
    {
        if(!\Auth::user()->hasRole('add-users')) return back();
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
        if(!\Auth::user()->hasRole('edit-users')) return back();
        $removeGroup = Group::where('name','Super Admin')->first();
        return view('pages.user.edit-create',compact('user','removeGroup'));
    }

    public function update(Request $request,User $user)
    {
        if(!\Auth::user()->hasRole('edit-users')) return back();
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

    public function destroy(User $user)
    {
        if(\Auth::user()->hasRole('delete-users'))
        {
            $user->delete();
            return redirect()->route('user')->with('success','User deleted');
        }
        return back();
    }
}
