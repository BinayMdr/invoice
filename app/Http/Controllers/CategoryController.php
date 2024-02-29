<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        if(!\Auth::user()->hasRole('view-categories')) return back();
        return view('pages.category.edit-create');
    }
}
