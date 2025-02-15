<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        if(!\Auth::user()->hasRole('view-banners')) return back();
        return view('pages.banner.index');
    }

    public function create()
    {
        if(!\Auth::user()->hasRole('add-banners')) return back();
        $banner = null;
        return view('pages.banner.edit-create',compact('banner'));
    }

    public function edit(Banner $banner)
    {
        if(!\Auth::user()->hasRole('edit-banners')) return back();
        return view('pages.banner.edit-create',compact('banner'));
    }

    public function destroy(Banner $banner)
    {
        if(\Auth::user()->hasRole('delete-banners'))
        {
            $banner->delete();
            return redirect()->route('banner')->with('success','Banner deleted');
        }
        return back();
    }
}

