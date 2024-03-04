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
    public $discountedPrice;
    public $salePrice;
    public $displayImage;
    public $productImages;
    public $image;
    public $images;
    public $shortDescription;
    public $description;
    public $additionalInformation;
    public $categoryId;
    public $colorId;
    public $brandId;
    public $tags;
    public $isNew = false;
    public $isOutOfStock = false;
    public $isEnabled = false;
    public $error;
    public $tempTag = [];
   
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
        $this->discountedPrice = $product?->discounted_price;
        $this->salePrice = $product?->sale_price;
        $this->displayImage = $product?->display_price;
        $this->productImages = $product?->images;
        $this->shortDescription = $product?->short_description;
        $this->description = $product?->description;
        $this->additionalInformation = $product?->additional_information;
        $this->categoryId = $product?->category_id;
        $this->colorId = $product?->color_id;
        $this->brandId = $product?->brand_id;
        $this->isNew = $product?->is_new;
        $this->isOutOfStock = $product?->is_out_of_stock;
        $this->isEnabled = $product?->is_enabled;
        $this->tags = $product?->tags->pluck('tag_id')->toArray() ?? [];
        $this->tempTag = $this->tags;
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
            'categoryId' => 'required',
            'image' => 'image',
            'images.*' => 'image',

        ]);

        if( Product::where('slug',$this->slug)->get()->count() > 0) 
        {
            $this->error = 'Slug already exist';
            return;
        }

        $display_image = 'bg-'.time().'.'.$this->image->extension(); 
        $display_image_path = $this->image->storeAs('public/uploads/product',$display_image);

        $temImage = '';

        foreach($this->images as $count => $img)
        {   
            $product_image = 'bg-'.time().'-'.$count.'.'.$img->extension(); 
            $product_image_path = $img->storeAs('public/uploads/product',$product_image);

            if($count == 0) $temImage = str_replace("public/","",$product_image_path);
            else $temImage = $temImage .','. str_replace("public/","",$product_image_path);
        }

        $productDetail = Product::create([
            'name' => $this->name,
            'slug' => $this->slug,
            'price' => $this->price,
            'discounted_price' => $this->discountedPrice,
            'sale_price' => $this->salePrice,
            'display_image' => str_replace("public/","",$display_image_path),
            'images' => $temImage,
            'description' => $this->description,
            'short_description' => $this->shortDescription,
            'additional_information' => $this->additionalInformation,
            'category_id' => $this->categoryId,
            'color_id' => $this->colorId ?? false,
            'brand_id' => $this->brandId ?? false,
            'is_new' => $this->isNew ?? false,
            'is_out_of_stock' => $this->isOutOfStock ?? false,
            'is_enabled' => $this->isEnabled ?? false
        ]);

        foreach($this->tags as $tag)
        {
            ProductHasTag::create([
                'product_id' => $productDetail->id,
                'tag_id' => $tag
            ]);
        }

        return redirect()->route('product')->with('success','Product created');
    }

    public function update()
    {   
        $this->validate([
            'name' => 'required',
            'slug' => 'required',
            'categoryId' => 'required',

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
        
        if($this->images != null)
        {
            $temImage = '';
            foreach($this->images as $count => $img)
            {
                $product_image = 'bg-'.time().'-'.$count.'.'.$img->extension();
                $product_image_path = $img->storeAs('public/uploads/product',$product_image);

                if($count == 0) $temImage = str_replace("public/","",$product_image_path);
                else $temImage = $temImage .','. str_replace("public/","",$product_image_path);
            }
        }

        $this->product->update([
            'name' => $this->name,
            'slug' => $this->slug,
            'price' => $this->price,
            'discounted_price' => $this->discountedPrice,
            'sale_price' => $this->salePrice,
            'display_image' => is_null($this->image) ? $this->product->display_image :str_replace("public/","",$display_image_path),
            'images' => is_null($this->image) ? $this->product->images : $temImage,
            'description' => $this->description,
            'short_description' => $this->shortDescription,
            'additional_information' => $this->additionalInformation,
            'category_id' => $this->categoryId,
            'color_id' => $this->colorId ?? false,
            'brand_id' => $this->brandId ?? false,
            'is_new' => $this->isNew ?? false,
            'is_out_of_stock' => $this->isOutOfStock ?? false,
            'is_enabled' => $this->isEnabled ?? false
        ]);

        if(count($this->product->tags) > 0) $this->product->tags()->delete();
        foreach($this->tags as $tag)
        {
            ProductHasTag::create([
                'product_id' => $this->product->id,
                'tag_id' => $tag
            ]);
        }

        return redirect()->route('product')->with('success','Product updated');
    }
}
