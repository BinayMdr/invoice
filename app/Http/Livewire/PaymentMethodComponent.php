<?php

namespace App\Http\Livewire;

use App\Models\PaymentMethod;
use Livewire\Component;
use Livewire\WithPagination;

class PaymentMethodComponent extends Component
{
    use WithPagination;

    public $search = "";
    public $limit = 10;

    protected $paginationTheme = 'bootstrap';
    
    public function render()
    {
        if($this->search != "") $paymentMethods = PaymentMethod::where('name','like','%'.$this->search.'%')->paginate($this->limit);
        else $paymentMethods = PaymentMethod::paginate($this->limit);
        return view('livewire.payment-method-component',[
            'paymentMethods' => $paymentMethods,
            'limit' => $this->limit
        ]);
    }

    public function changeEvent($value)
    {
        $this->limit = $value;
    }
}
