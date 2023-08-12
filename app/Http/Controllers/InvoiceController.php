<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceHasProduct;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        return view('pages.invoice.index');
    }

    public function create()
    {
        $invoice = null;
        return view('pages.invoice.edit-create',compact('invoice'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);



        return redirect()->route('branch')->with('success','Invoice created');
    }

    public function edit(Invoice $invoice)
    {
        return view('pages.invoice.edit-create',compact('invoice'));
    }

    public function update(Request $request,Invoice $invoice)
    {
        $request->validate([
            'name' => 'required'
        ]);

        return redirect()->route('invoice')->with('success','Invoice updated');
    }

    public function delete(Invoice $invoice)
    {
        foreach(InvoiceHasProduct::where('invoice_id',$invoice->id)->get() as $ip) $ip->delete();
        $invoice->delete();

        return redirect()->route('invoice')->with('success',"Invoice deleted");
    }
}
