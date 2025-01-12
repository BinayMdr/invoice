<?php

namespace App\Http\Controllers;

use App\Models\SaleProduct;
use Illuminate\Http\Request;

class SaleProductController extends Controller
{
    public function index()
    {
        if(!\Auth::user()->hasRole('view-sale-products')) return back();
        return view('pages.sale-product.index');
    }

    public function create()
    {
        if(!\Auth::user()->hasRole('add-sale-products')) return back();
        $saleProduct = null;
        return view('pages.sale-product.edit-create',compact('saleProduct'));
    }

    public function edit(SaleProduct $saleProduct)
    {
        if(!\Auth::user()->hasRole('edit-sale-products')) return back();
        return view('pages.sale-product.edit-create',compact('saleProduct'));
    }

}
