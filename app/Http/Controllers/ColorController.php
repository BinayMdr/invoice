<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
    {
        if(!\Auth::user()->hasRole('view-colors')) return back();
        return view('pages.color.edit-create');
    }
}
