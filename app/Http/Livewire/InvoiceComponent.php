<?php

namespace App\Http\Livewire;

use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class InvoiceComponent extends Component
{
    use WithPagination;

    public $search = "";
    public $limit = 10;
    public $invoiceStatus = "";
    public $startDate = "";
    public $endDate = "";

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        if($this->search != "" || $this->invoiceStatus != "" || $this->startDate != "" || $this->endDate != "") 
        {   
            $invoices = new Invoice();
            if(Auth::user()->type != "admin") $invoices = $invoices->where('branch_id',Auth::user()->branch_id);
            if($this->search != "") $invoices = $invoices->where('invoice_number', 'like', '%' . $this->search . '%');
            if($this->invoiceStatus != "") $invoices = $invoices->where('status',$this->invoiceStatus);
            if($this->startDate != "") $invoices = $invoices->whereDate('created_at','>=',$this->startDate);
            if($this->endDate != "") $invoices = $invoices->whereDate('created_at','<=',$this->endDate);

            $invoices = $invoices->orderBy('created_at','desc')->paginate($this->limit);
        }
        else {
            if(Auth::user()->type != "admin") $invoices = Invoice::where('branch_id',Auth::user()->branch_id)->orderBy('created_at','desc')->paginate($this->limit);
            else $invoices = Invoice::orderBy('created_at','desc')->paginate($this->limit);
        }
        return view('livewire.invoice-component',[
            'invoices' => $invoices,
            'limit' => $this->limit
        ]);
    }

    public function changeEvent($value)
    {
        $this->limit = $value;
    }

    public function updateInvoiceStatus($name)
    {
        $this->invoiceStatus = $name;
    }

    public function clear()
    {
        $this->invoiceStatus = "";
        $this->startDate = "";
        $this->endDate = "";
    }
}
