<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        if(!\Auth::user()->hasRole('view-tags')) return back();
        return view('pages.tag.edit-create');
    }
}
