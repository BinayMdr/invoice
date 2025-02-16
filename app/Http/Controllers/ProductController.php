<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        if(!\Auth::user()->hasRole('view-products')) return back();
        return view('pages.product.index');
    }

    public function create()
    {
        if(!\Auth::user()->hasRole('add-products')) return back();
        $product = null;
        return view('pages.product.edit-create',compact('product'));
    }

    public function edit(Product $product)
    {
        if(!\Auth::user()->hasRole('edit-products')) return back();
        return view('pages.product.edit-create',compact('product'));
    }

    public function destroy(Product $product)
    {
        if(\Auth::user()->hasRole('delete-products'))
        {
            $product->delete();
            return redirect()->route('product')->with('success','Product deleted');
        }
        return back();
    }
}
