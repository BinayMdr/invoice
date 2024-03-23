<?php

namespace App\Http\Livewire;

use App\Models\SaleProduct;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditCreateSaleProductComponent extends Component
{
    use WithFileUploads;
    public $saleProduct;
    public $name;
    public $heading1;
    public $text1;
    public $text2;
    public $text3;
    public $buttonText;
    public $buttonLink;
    public $searchKey;
    public $searchValue;
    public $image;
    public $offerTillDate;
    public $salePrice;
    public $isEnabled = false;
    public $showSearch = false;
    public $error;
   
    public function updated($field)
    {
        $this->resetValidation();
    }

    public function mount($saleProduct)
    {
        $this->saleProduct = $saleProduct;
        $this->name = $saleProduct?->name;
        $this->heading1 = $saleProduct?->heading_1;
        $this->text1 = $saleProduct?->text_1;
        $this->text2 = $saleProduct?->text_2;
        $this->text3 = $saleProduct?->text_3;
        $this->buttonText = $saleProduct?->button_text;
        $this->buttonLink = $saleProduct?->button_link;
        $this->searchKey = $saleProduct?->search_key;
        $this->searchValue = $saleProduct?->search_value;
        $this->offerTillDate = $saleProduct?->offer_till_date;
        $this->salePrice = $saleProduct?->sale_price;
        $this->isEnabled = $saleProduct?->is_enabled;
        $this->showSearch = $saleProduct->show_search;
    }

    public function render()
    {
        return view('livewire.edit-create-sale-product-component',[
            'saleProduct' => $this->saleProduct
        ]);
    }

    public function save()
    {   
        $this->validate([
            'name' => 'required',
            'image' => 'image',
            'offerTillDate' => 'required|date|after:now',
            'salePrice' => 'required|numeric|min:1'
        ]);

        if( SaleProduct::where('name',$this->name)->get()->count() > 0) 
        {
            $this->error = 'Name already exist';
            return;
        }

        $sale_product_image = 'bg-'.time().'.'.$this->image->extension(); 
        $sale_product_image_path = $this->image->storeAs('public/uploads/sale-product',$sale_product_image);

        SaleProduct::create([
            'name' => $this->name,
            'image' => str_replace("public/","",$sale_product_image_path),
            'text_1' => $this->text1,
            'text_2' => $this->text2,
            'text_3' => $this->text3,
            'heading_1' => $this->heading1,
            'button_text' => $this->buttonText,
            'button_link' => $this->buttonLink,
            'search_key' => $this->searchKey,
            'search_value' => $this->searchValue,
            'offer_till_date' => $this->offerTillDate,
            'sale_price' => $this->salePrice,
            'is_enabled' => $this->isEnabled,
            'show_search' => $this->showSearch
        ]);

        return redirect()->route('sale-product')->with('success','Sale Product created');
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'offerTillDate' => 'required|date',
            'salePrice' => 'required|numeric|min:1'
        ]);

        if( SaleProduct::where('name',$this->name)
                    ->whereNotIn('id',[$this->saleProduct->id])
                    ->get()->count() > 0) 
        {
            $this->error = 'Name already exist';
            return;
        }

        $data = [
            'name' => $this->name,
            'text_1' => $this->text1,
            'text_2' => $this->text2,
            'text_3' => $this->text3,
            'heading_1' => $this->heading1,
            'button_text' => $this->buttonText,
            'button_link' => $this->buttonLink,
            'search_key' => $this->searchKey,
            'search_value' => $this->searchValue,
            'offer_till_date' => $this->offerTillDate,
            'sale_price' => $this->salePrice,
            'is_enabled' => $this->isEnabled,
            'show_search' => $this->showSearch
        ];
        if($this->image != null)
        {
            $sale_product_image = 'bg-'.time().'.'.$this->image->extension(); 
            $sale_product_image_path = $this->image->storeAs('public/uploads/sale-product',$sale_product_image);    
            $data['image'] = str_replace("public/","",$sale_product_image_path);
        }

        $this->saleProduct->update($data);

        return redirect()->route('sale-product')->with('success','Sale product updated');
    }
}
