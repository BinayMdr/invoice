<?php

namespace App\Http\Controllers;

use App\Models\Certification;

class CertificationController extends Controller
{
    public function index()
    {
        if(!\Auth::user()->hasRole('view-certifications')) return back();
        $certification = Certification::first();
        return view('pages.certification.index',compact('certification'));
    }

}
