<?php

namespace App\Http\Controllers;

use App\Models\Certification;

class CertificationController extends Controller
{
    public function index()
    {
        // if(!\Auth::user()->hasRole('view-groups')) return back();
        $certification = Certification::first();
        return view('pages.certification.index',compact('certification'));
    }

}
