<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return view('pages.setting');
    }

    public function update(Request $request)
    {
        foreach($request->except(['_token','_method','backgroundColour']) as $value => $data)
        {
            Setting::where('name',$value)->first()->update([
                'value' => $data
            ]);
        }

        return redirect()->back()->with('success','Settings updated');
    }
}
