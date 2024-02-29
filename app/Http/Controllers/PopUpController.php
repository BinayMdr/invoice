<?php

namespace App\Http\Controllers;

use App\Models\PopUp;
use Illuminate\Http\Request;

class PopUpController extends Controller
{
    public function index()
    {
        if(!\Auth::user()->hasRole('view-pop-ups')) return back();
        return view('pages.pop-up.index');
    }

    public function create()
    {
        if(!\Auth::user()->hasRole('add-pop-ups')) return back();
        $popUp = null;
        return view('pages.pop-up.edit-create',compact('popUp'));
    }

    public function edit(PopUp $popUp)
    {
        if(!\Auth::user()->hasRole('edit-pop-ups')) return back();
        return view('pages.pop-up.edit-create',compact('popUp'));
    }
}
