<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        return view('pages.payment-method.index');
    }

    public function create()
    {
        $paymentMethod = null;
        return view('pages.payment-method.edit-create',compact('paymentMethod'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        if(PaymentMethod::where('name',$request->name)->get()->count() > 0)  return redirect()->back()->with('error','Payment method name already exist');

        PaymentMethod::create([
            'name' => $request->name,
            'is_enabled' => $request->has('status') ? true : false
        ]);

        return redirect()->route('payment-method')->with('success','Payment method created');
    }

    public function edit(PaymentMethod $paymentMethod)
    {
        return view('pages.payment-method.edit-create',compact('paymentMethod'));
    }

    public function update(Request $request,PaymentMethod $paymentMethod)
    {
        $request->validate([
            'name' => 'required'
        ]);

        if(PaymentMethod::whereNotIn('id',[$paymentMethod->id])->where('name',$request->name)->get()->count() > 0)  return redirect()->back()->with('error','Payment method name already exist');

        $paymentMethod->update([
            'name' => $request->name,
            'is_enabled' => $request->has('status') ? true : false
        ]);

        return redirect()->route('payment-method')->with('success','Payment method updated');
    }
}
