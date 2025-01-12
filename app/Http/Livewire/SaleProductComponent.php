<?php

namespace App\Http\Livewire;

use App\Models\SaleProduct;
use Livewire\Component;
use Livewire\WithPagination;

class SaleProductComponent extends Component
{
    use WithPagination;

    public $search = "";
    public $limit = 10;

    protected $paginationTheme = 'bootstrap';
    
    public function render()
    {   
        $saleProducts = new SaleProduct(); 

        if($this->search != "") 
        {
            $keyword  = $this->search;

            $saleProducts = $saleProducts->where(function($q) use ($keyword){
                $q->where('name','like','%'.$keyword.'%');
            });
        }
        $saleProducts = $saleProducts->orderBy('created_at','desc')
                            ->paginate($this->limit);
        
        return view('livewire.sale-product-component',[
            'saleProducts' => $saleProducts,
            'limit' => $this->limit
        ]);
    }

    public function changeEvent($value)
    {
        $this->limit = $value;
    }
}
