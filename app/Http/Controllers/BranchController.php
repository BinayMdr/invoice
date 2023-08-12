<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        return view('pages.branch.index');
    }

    public function create()
    {
        $branch = null;
        return view('pages.branch.edit-create',compact('branch'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]); 
        
        if($request->has('main_branch'))
        {
            if(Branch::where('is_enabled','1')->where('main_branch','1')->get()->count() > 0) return redirect()->back()->with('error','Main branch already exist');
        }
        if(Branch::where('name',$request->name)->get()->count() > 0)  return redirect()->back()->with('error','Branch name already exist');

        Branch::create([
            'name' => $request->name,
            'is_enabled' => $request->has('status') ? true : false
        ]);

        return redirect()->route('branch')->with('success','Branch created');
    }

    public function edit(Branch $branch)
    {
        return view('pages.branch.edit-create',compact('branch'));
    }

    public function update(Request $request,Branch $branch)
    {
        $request->validate([
            'name' => 'required'
        ]);

        if($request->has('main_branch'))
        {
            if(Branch::whereNotIn('id',[$branch->id])->where('is_enabled','1')->where('main_branch','1')->get()->count() > 0) return redirect()->back()->with('error','Main branch already exist');
        }

        if(Branch::whereNotIn('id',[$branch->id])->where('name',$request->name)->get()->count() > 0)  return redirect()->back()->with('error','Branch name already exist');

        $branch->update([
            'name' => $request->name,
            'is_enabled' => $request->has('status') ? true : false
        ]);

        return redirect()->route('branch')->with('success','Branch updated');
    }
}
