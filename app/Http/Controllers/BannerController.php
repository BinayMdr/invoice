<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        return view('pages.banner.index');
    }

    public function create()
    {
        $banner = null;
        return view('pages.banner.edit-create',compact('banner'));
    }

    public function edit(Banner $banner)
    {
        return view('pages.banner.edit-create',compact('banner'));
    }

}
