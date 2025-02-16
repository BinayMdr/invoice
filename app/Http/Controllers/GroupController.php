<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupHasRole;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index()
    {
        if(!\Auth::user()->hasRole('view-groups')) return back();
        return view('pages.group.index');
    }

    public function create()
    {
        if(!\Auth::user()->hasRole('add-groups')) return back();
        $group = null;
        return view('pages.group.edit-create',compact('group'));
    }

    public function store(Request $request)
    {   
        if(!\Auth::user()->hasRole('add-groups')) return back();

        $request->validate([
            'name' => 'required',
            'roles' => 'required'
        ], [
            'name.required' => 'The name field is required.',
            'roles.required' => 'The roles field is required.'
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
        if(!\Auth::user()->hasRole('edit-groups')) return back();
        return view('pages.group.edit-create',compact('group'));
    }

    public function update(Request $request,Group $group)
    {   
        if(!\Auth::user()->hasRole('edit-groups')) return back();
        $request->validate([
            'name' => 'required',
            'roles' => 'required'
        ]);

        if( Group::where('name',$request->name)->whereNotIn('id',[$group->id])
                    ->get()->count() > 0) return redirect()->back()->with('error','Name already exist');
        
        $group->roles()->delete();

        $group->update([
            'name' => $request->name
        ]);

        foreach($request->roles as $role)
        {
            GroupHasRole::create([
                'group_id' => $group->id,
                'role_id' => $role
            ]);
        }

        return redirect()->route('group')->with('success','Group updated');
    }

    public function destroy(Group $group)
    {
        if(\Auth::user()->hasRole('delete-groups'))
        {
            if(\App\Models\User::where('group_id',$group->id)->get()->count() > 0) return redirect()->route('group')->with('error','Group is assigned to user');
            $group->delete();
            return redirect()->route('group')->with('success','Group deleted');
        }
        return back();
    }
}
