<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        if(!\Auth::user()->hasRole('view-brands')) return back();
        return view('pages.brand.edit-create');
    }
}
