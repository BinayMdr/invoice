<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class FilterProductController extends Controller
{
    public function index(Tag $tag)
    {
        if(!\Auth::user()->hasRole('view-filter-tags')) return back();
        return view('pages.filter-product.edit-create',compact('tag'));
    }
}
