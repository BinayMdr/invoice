<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerComponent extends Component
{
    use WithPagination;

    public $search = "";
    public $limit = 10;

    protected $paginationTheme = 'bootstrap';
    
    public function render()
    {
        if($this->search != "") $customers = Customer::where('name','like','%'.$this->search.'%')->
                                                    orwhere('phone_number','like','%'.$this->search.'%')
                                                    ->paginate($this->limit);
        else $customers = Customer::paginate($this->limit);
        return view('livewire.customer-component',[
            'customers' => $customers,
            'limit' => $this->limit
        ]);
    }

    public function changeEvent($value)
    {
        $this->limit = $value;
    }
}
