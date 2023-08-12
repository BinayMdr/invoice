<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductComponent extends Component
{
    use WithPagination;

    public $search = "";
    public $limit = 10;

    protected $paginationTheme = 'bootstrap';
    
    public function render()
    {
        if($this->search != "") $products = Product::where('name','like','%'.$this->search.'%')->paginate($this->limit);
        else $products = Product::paginate($this->limit);
        return view('livewire.product-component',[
            'products' => $products,
            'limit' => $this->limit
        ]);
    }

    public function changeEvent($value)
    {
        $this->limit = $value;
    }
}
