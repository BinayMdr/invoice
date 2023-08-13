<?php

namespace App\Http\Controllers;

use App\Models\GlobalSetting;
use Illuminate\Http\Request;

class GlobalSettingController extends Controller
{
    public function index()
    {
        return view('pages.global-setting');
    }

    public function update(Request $request)
    {
        foreach($request->except(['_token','_method']) as $value => $data)
        {
            if(is_null(GlobalSetting::where('name',$value)->first()))
            {
                GlobalSetting::create([
                    'name' => $value,
                    'value' => $data
                ]);
            }
            else
            {
                GlobalSetting::where('name',$value)->first()->update([
                    'value' => $data
                ]);
            }
        }

        return redirect()->back()->with('success','Global settings updated');
    }
}
