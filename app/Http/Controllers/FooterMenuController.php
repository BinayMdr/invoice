<?php

namespace App\Http\Controllers;

use App\Models\FooterMenu;
use Illuminate\Http\Request;

class FooterMenuController extends Controller
{
    public function index()
    {
        return view('pages.footer-menu.index');
    }

    public function create()
    {
        $footerMenu = null;
        return view('pages.footer-menu.edit-create',compact('footerMenu'));
    }

    public function edit(FooterMenu $footerMenu)
    {
        return view('pages.footer-menu.edit-create',compact('footerMenu'));
    }

}
