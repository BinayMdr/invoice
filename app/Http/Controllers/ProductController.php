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

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price'=> 'required'
        ]);

        if(Product::where('name',$request->name)->get()->count() > 0)  return redirect()->back()->with('error','Product name already exist');

        if($request->price < 1) return redirect()->back()->with('error','Price must be equal or more than 1');
        
        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'is_enabled' => $request->has('status') ? true : false
        ]);

        return redirect()->route('product')->with('success','Product created');
    }

    public function edit(Product $product)
    {
        return view('pages.product.edit-create',compact('product'));
    }

    public function update(Request $request,Product $product)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required'
        ]);

        if(Product::whereNotIn('id',[$product->id])->where('name',$request->name)->get()->count() > 0)  return redirect()->back()->with('error','Product name already exist');

        if($request->price < 1) return redirect()->back()->with('error','Price must be equal or more than 1');

        $product->update([
            'name' => $request->name,
            'is_enabled' => $request->has('status') ? true : false
        ]);

        return redirect()->route('product')->with('success','Product updated');
    }
}
