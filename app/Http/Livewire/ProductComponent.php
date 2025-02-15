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
        $products = new Product(); 

        if($this->search != "") 
        {
            $keyword  = $this->search;

            $products = $products->where(function($q) use ($keyword){
                $q->where('name','like','%'.$keyword.'%');
            });
        }
        $products = $products->orderBy('created_at','desc')
                            ->paginate($this->limit);
        
        $start = ($products->currentPage() - 1) * $this->limit + 1;
        $end = min($products->currentPage() * $this->limit, $products->total());

        return view('livewire.product-component',[
            'products' => $products,
            'limit' => $this->limit,
            'start' => $start,
            'end' => $end,
            'total' => $products->total()
        ]);
    }

    public function changeEvent($value)
    {
        $this->limit = $value;
        $this->resetPage();
    }
}