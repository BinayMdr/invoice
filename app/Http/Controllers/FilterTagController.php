<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FilterTagController extends Controller
{
    public function index()
    {
        if(!\Auth::user()->hasRole('view-filter-tags')) return back();
        return view('pages.filter-tag.edit-create');
    }
}
