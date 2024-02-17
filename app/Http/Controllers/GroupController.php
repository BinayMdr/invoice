<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupHasRole;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index()
    {
        return view('pages.group.index');
    }

    public function create()
    {
        $group = null;
        return view('pages.group.edit-create',compact('group'));
    }

    public function store(Request $request)
    {   
        $request->validate([
            'name' => 'required',
            'roles' => 'required'
        ]);

        if( Group::where('name',$request->name)->get()->count() > 0) return redirect()->back()->with('error','Name already exist');
        
        $group = Group::create([
            'name' => $request->name
        ]);

        foreach($request->roles as $role)
        {
            GroupHasRole::create([
                'group_id' => $group->id,
                'role_id' => $role
            ]);
        }
        return redirect()->route('group')->with('success','Group created');
    }

    public function edit(Group $group)
    {
        return view('pages.group.edit-create',compact('group'));
    }

    public function update(Request $request,Group $group)
    {   
        $request->validate([
            'name' => 'required',
            'roles' => 'required'
        ]);

        if( Group::where('name',$request->name)->whereNotIn('id',[$group->id])
                    ->get()->count() > 0) return redirect()->back()->with('error','Name already exist');
        
        $group->roles()->delete();

        foreach($request->roles as $role)
        {
            GroupHasRole::create([
                'group_id' => $group->id,
                'role_id' => $role
            ]);
        }

        return redirect()->route('group')->with('success','Group updated');
    }
}
