<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return view('pages.product.index');
    }

    public function create()
    {
        $product = null;
        return view('pages.product.edit-create',compact('product'));
    }

    public function edit(Product $product)
    {
        return view('pages.product.edit-create',compact('product'));
    }
}
