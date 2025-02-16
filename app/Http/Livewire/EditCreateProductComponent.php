<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\ProductHasTag;
use Livewire\WithFileUploads;

class EditCreateProductComponent extends Component
{
    use WithFileUploads;
    public $product;
    public $name;
    public $slug;
    public $price;
    public $order;
    public $series;
    public $displayImage;
    public $reference;
    public $image;
    public $images;
    public $description;
    public $isOutOfStock = false;
    public $isEnabled = false;
    public $showInHomePage = false;
    public $error;
    public $tempTag = [];
    protected $listeners = ['updateDescription'];

    public function updated($field)
    {
        $this->resetValidation();
        $this->emit('render-list');    
       
        if($field == "name")
        {
            $this->slug = strtolower(str_replace(' ', '-', trim($this->name)));

        }

    }

    public function mount($product)
    {
        $this->product = $product;
        $this->name = $product?->name;
        $this->slug = $product?->slug;
        $this->price = $product?->price;
        $this->order = $product?->order;
        $this->series = $product?->series;
        $this->reference = $product?->reference;
        $this->description = $product?->description;
        $this->showInHomePage = $product?->show_in_home_page;
        $this->isOutOfStock = $product?->is_out_of_stock;
        $this->isEnabled = $product?->is_enabled;
    }

    public function render()
    {
        return view('livewire.edit-create-product-component',[
            'product' => $this->product
        ]);
    }

    public function save()
    {   
        $this->validate([
            'name' => 'required',
            'slug' => 'required',
            'image' => 'image'

        ]);

        if( Product::where('slug',$this->slug)->get()->count() > 0) 
        {
            $this->error = 'Slug already exist';
            return;
        }

        $display_image = 'bg-'.time().'.'.$this->image->extension(); 
        $display_image_path = $this->image->storeAs('public/uploads/product',$display_image);

        $maxOrder = Product::orderByDesc('order')->first();

        if($this->order == null )
        {
            if($maxOrder != null) $this->order = $maxOrder->order + 1;
            else $this->order = 1;
        }

        $productDetail = Product::create([
            'name' => $this->name,
            'slug' => $this->slug,
            'price' => $this->price,
            'reference' => $this->reference,
            'series' => $this->series,
            'image' => str_replace("public/","",$display_image_path),
            'description' => $this->description,
            'show_in_home_page' => $this->showInHomePage ?? false,
            'is_out_of_stock' => $this->isOutOfStock ?? false,
            'is_enabled' => $this->isEnabled ?? false,
            'order' => $this?->order
        ]);

        return redirect()->route('product')->with('success','Product created');
    }

    public function update()
    {   
        $this->validate([
            'name' => 'required',
            'slug' => 'required'
        ]);

        if( Product::where('slug',$this->slug)->whereNotIn('id',[$this->product->id])->get()->count() > 0) 
        {
            $this->error = 'Slug already exist';
            return;
        }   

        if($this->image != null)
        {
            $display_image = 'bg-'.time().'.'.$this->image->extension(); 
            $display_image_path = $this->image->storeAs('public/uploads/product',$display_image);
        }
        
        
        $this->product->update([
            'name' => $this->name,
            'slug' => $this->slug,
            'price' => $this->price,
            'order' => $this->order,
            'series' => $this->series,
            'image' => is_null($this->image) ? $this->product->image :str_replace("public/","",$display_image_path),
            'description' => $this->description,
            'reference' => $this->reference,
            'is_out_of_stock' => $this->isOutOfStock ?? false,
            'is_enabled' => $this->isEnabled ?? false,
            'show_in_home_page' => $this->showInHomePage
        ]);

        return redirect()->route('product')->with('success','Product updated');
    }

    public function updateDescription($value)
    {
        $this->description = $value;
    }
}
