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


    public function edit(Invoice $invoice)
    {
        return view('pages.invoice.edit-create',compact('invoice'));
    }


    public function download($invoiceId)
    {
        return view('pdf.invoicefile',['invoiceId' => $invoiceId]);
    }
}
