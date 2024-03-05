<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        if(!\Auth::user()->hasRole('view-settings')) return back();
        return view('pages.setting.edit-create');
    }
}
