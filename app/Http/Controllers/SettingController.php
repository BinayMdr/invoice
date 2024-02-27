<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        if(!\Auth::user()->hasRole('view-settings')) return back();
        return view('pages.setting');
    }

    public function update(Request $request)
    {
        if(\Auth::user()->hasRole('update-settings') || \Auth::user()->hasRole('add-settings'))
        { 
            if(is_null(Setting::where('branch_id',$request->branch_id)->first()))
            {
                $data = $request->except(['_token','sideBarColour','sideNavType']);
                $data['side_bar_colour'] = $request['sideBarColour'];
                $data['side_nav_type'] = $request['sideNavType'];
                Setting::create($data);
            }        
            else
            {
                $setting = Setting::where('branch_id',$request->branch_id)->first();
                $data = $request->except(['_token','sideBarColour','sideNavType']);
                $data['side_bar_colour'] = $request['sideBarColour'];
                $data['side_nav_type'] = $request['sideNavType'];
                $setting->update($data);
            }

            session()->put('branchId',$request->branch_id);

            return redirect()->back()->with('success','Settings updated');
        }
        return back();
    }
}
