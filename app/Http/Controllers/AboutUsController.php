<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public function index()
    {
        if(!\Auth::user()->hasRole('view-about-us')) return back();
        $aboutUs = AboutUs::first();
        return view('pages.about-us.edit-create',compact('aboutUs'));
    }

}
