<?php

namespace App\Http\Controllers;

use App\Models\SaleProduct;
use Illuminate\Http\Request;

class SaleProductController extends Controller
{
    public function index()
    {
        return view('pages.sale-product.index');
    }

    public function create()
    {
        $saleProduct = null;
        return view('pages.sale-product.edit-create',compact('saleProduct'));
    }

    public function edit(SaleProduct $saleProduct)
    {
        return view('pages.sale-product.edit-create',compact('saleProduct'));
    }

}
