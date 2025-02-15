<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        if(!\Auth::user()->hasRole('view-teams')) return back();
        return view('pages.team.index');
    }

    public function create()
    {
        if(!\Auth::user()->hasRole('add-teams')) return back();
        $team = null;
        return view('pages.team.edit-create',compact('team'));
    }

    public function edit(Team $team)
    {
        if(!\Auth::user()->hasRole('edit-teams')) return back();
        return view('pages.team.edit-create',compact('team'));
    }

    public function destroy(Team $team)
    {
        if(\Auth::user()->hasRole('delete-teams'))
        {
            $team->delete();
            return redirect()->route('team')->with('success','Team deleted');
        }
        return back();
    }

}
