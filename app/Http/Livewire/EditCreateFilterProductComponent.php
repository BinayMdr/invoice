<?php

namespace App\Http\Livewire;

use App\Models\FilterProduct;
use App\Models\Product;
use App\Models\ProductHasTag;
use Livewire\Component;

class EditCreateFilterProductComponent extends Component
{
    public $products = [];
    public $tag;
    public $error;
    
    protected $listeners = ['filterProductUpdated' => 'updateOrder'];

    public function updated($field)
    {
        $this->resetValidation();
    }

    public function mount($tag)
    {
        $this->tag = $tag;
        if(is_null(FilterProduct::where('tag_id',$tag->id)->first()))
        {
            $productHasTag = ProductHasTag::where('tag_id',$tag->id)->get();

           
            foreach(Product::whereIn('id',$productHasTag->pluck('product_id')->toArray())->get() as $count => $product)
            {
                $this->products[$count]['id'] = null;
                $this->products[$count]['tagId'] = $tag->id;
                $this->products[$count]['productId'] = $product->id;
                $this->products[$count]['name'] = $product->name;
            }

        }
        else
        {   
            $filterData = FilterProduct::where('tag_id',$tag->id)->orderBy('order')->get();

            foreach($filterData as $count => $fd)
            {
                if(!is_null(ProductHasTag::where('tag_id',$tag->id)->where('product_id',$fd->product_id)->first()))
                {
                    $this->products[$count]['id'] = $fd->id;
                    $this->products[$count]['tagId'] = $fd->tag_id;
                    $this->products[$count]['productId'] = $fd->product_id;
                    $this->products[$count]['name'] = Product::find($fd->product_id)->name;
                }
            }
            
            $productData = $filterData->pluck('product_id')->toArray();

            $remainingProductId = ProductHasTag::where('tag_id',$tag->id)
                                    ->whereNotIn('product_id',$productData)
                                    ->pluck('product_id')->toArray();

            $remainingProduct = Product::whereIn('id',$remainingProductId)->get();

            
            if(count($remainingProduct) > 0)
            {
                $count = count($productData);
                foreach($remainingProduct as $c => $rp)
                {
                    $this->products[$count + $c]['id'] = null;
                    $this->products[$count + $c]['tagId'] = $tag->id;
                    $this->products[$count + $c]['productId'] = $rp->id;
                    $this->products[$count + $c]['name'] = Product::find($rp->id)->name;
                } 
            }

        }
    }

    public function render()
    {
        return view('livewire.edit-create-filter-product-component');
    }

    public function save()
    {   
        if(\Auth::user()->hasRole('edit-filter-tags') || \Auth::user()->hasRole('add-filter-tags'))
        { 
            FilterProduct::where('tag_id',$this->tag->id)?->delete();
            
            foreach($this->products as $count => $product)
            {        
                FilterProduct::create(['tag_id' => $this->tag->id,
                                'product_id' => $product['productId'],
                                'order' => $count + 1]);
                
            }


            return redirect()->route('filter-product', ['tag' => $this->tag->id])->with('success', 'Filter product updated');
        }
        return back();
    }

    public function updateOrder($newOrder)
    {
        $this->products = $newOrder;
    }
}
