<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        return view('pages.customer.index');
    }

    public function create()
    {
        $customer = null;
        return view('pages.customer.edit-create',compact('customer'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone_number' => 'required'
        ]);

        if( Customer::where('phone_number',$request->phone_number)->get()->count() > 0) return redirect()->back()->with('error','Phone number already exist');

        Customer::create([
            'name' => $request->name,
            'phone_number' => $request->phone_number
        ]);

        return redirect()->route('customer')->with('success','Customer created');
    }

    public function edit(Customer $customer)
    {
        return view('pages.customer.edit-create',compact('customer'));
    }

    public function update(Request $request,Customer $customer)
    {
        $request->validate([
            'name' => 'required',
            'phone_number' => 'required'
        ]);

        if( Customer::whereNotIn('id',[$customer->id])->where('phone_number',$request->phone_number)->get()->count() > 0) return redirect()->back()->with('error','Phone number already exist');

        $customer->update([
            'name' => $request->name,
            'phone_number' => $request->phone_number
        ]);

        return redirect()->route('customer')->with('success','Customer updated');
    }
}
