<?php

namespace App\Http\Livewire;

use App\Models\InventoryRequest;
use Livewire\Component;
use Livewire\WithPagination;

class InventoryRequestComponent extends Component
{
    use WithPagination;

    public $search = "";
    public $limit = 10;
    public $inventoryRequestStatus = "";
    public $startDate = "";
    public $endDate = "";

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        if($this->search != "" || $this->inventoryRequestStatus != "" || $this->startDate != "" || $this->endDate != "") 
        {   
            $inventoryRequests = new InventoryRequest();
            if(\Auth::user()->type != "admin") $inventoryRequests = $inventoryRequests->where('branch_id',\Auth::user()->branch);
            if($this->search != "") $inventoryRequests = $inventoryRequests->where('invoice_number', 'like', '%' . $this->search . '%');
            if($this->inventoryRequestStatus != "") $inventoryRequests = $inventoryRequests->where('status',$this->inventoryRequestStatus);
            if($this->startDate != "") $inventoryRequests = $inventoryRequests->whereDate('created_at','>=',$this->startDate);
            if($this->endDate != "") $inventoryRequests = $inventoryRequests->whereDate('created_at','<=',$this->endDate);

            $inventoryRequests = $inventoryRequests->orderBy('created_at','desc')->paginate($this->limit);
        }
        else {
            if(\Auth::user()->type != "admin") $inventoryRequests = InventoryRequest::where('branch_id',\Auth::user()->branch)->orderBy('created_at','desc')->paginate($this->limit);
            else $inventoryRequests = InventoryRequest::orderBy('created_at','desc')->paginate($this->limit);
        }
        return view('livewire.inventory-request-component',[
            'inventoryRequests' => $inventoryRequests,
            'limit' => $this->limit
        ]);
    }

    public function changeEvent($value)
    {
        $this->limit = $value;
    }

    public function updateInventoryRequestStatus($name)
    {
        $this->inventoryRequestStatus = $name;
    }

    public function clear()
    {
        $this->inventoryRequestStatus = "";
        $this->startDate = "";
        $this->endDate = "";
    }

}
