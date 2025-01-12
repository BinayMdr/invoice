<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        if(!\Auth::user()->hasRole('view-payment-methods')) return back();
        return view('pages.payment-method.index');
    }

    public function create()
    {
        if(!\Auth::user()->hasRole('add-payment-methods')) return back();
        $paymentMethod = null;
        return view('pages.payment-method.edit-create',compact('paymentMethod'));
    }

    public function store(Request $request)
    {
        if(!\Auth::user()->hasRole('add-payment-methods')) return back();
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
        if(!\Auth::user()->hasRole('edit-payment-methods')) return back();
        return view('pages.payment-method.edit-create',compact('paymentMethod'));
    }

    public function update(Request $request,PaymentMethod $paymentMethod)
    {
        if(!\Auth::user()->hasRole('edit-payment-methods')) return back();
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
