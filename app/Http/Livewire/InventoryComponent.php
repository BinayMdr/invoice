<?php

namespace App\Http\Livewire;

use App\Models\Inventory;
use Livewire\Component;
use Livewire\WithPagination;

class InventoryComponent extends Component
{
    
    use WithPagination;

    public $search = "";
    public $limit = 10;

    protected $paginationTheme = 'bootstrap';
    
    public function render()
    {
        if($this->search != "") $inventories = Inventory::where('name','like','%'.$this->search.'%')->paginate($this->limit);
        else $inventories = Inventory::paginate($this->limit);
        return view('livewire.inventory-component',[
            'inventories' => $inventories,
            'limit' => $this->limit
        ]);
    }

    public function changeEvent($value)
    {
        $this->limit = $value;
    }
}
