<?php

namespace App\Http\Controllers;

use App\Models\FooterMenu;
use Illuminate\Http\Request;

class FooterMenuController extends Controller
{
    public function index()
    {
        if(!\Auth::user()->hasRole('view-footer-menus')) return back();
        return view('pages.footer-menu.index');
    }

    public function create()
    {
        if(!\Auth::user()->hasRole('add-footer-menus')) return back();
        $footerMenu = null;
        return view('pages.footer-menu.edit-create',compact('footerMenu'));
    }

    public function edit(FooterMenu $footerMenu)
    {
        if(!\Auth::user()->hasRole('edit-footer-menus')) return back();
        return view('pages.footer-menu.edit-create',compact('footerMenu'));
    }

}
