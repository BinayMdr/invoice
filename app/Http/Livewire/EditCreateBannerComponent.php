<?php

namespace App\Http\Livewire;

use App\Models\Banner;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditCreateBannerComponent extends Component
{
    use WithFileUploads;
    public $banner;
    public $name;
    public $order = null;
    public $heading;
    public $text;
    public $buttonText;
    public $buttonLink;
    public $image;
    public $isEnabled = false;
    public $error;
   
    public function updated($field)
    {
        $this->resetValidation();
    }

    public function mount($banner)
    {
        $this->banner = $banner;
        $this->name = $banner?->name;
        $this->order = $banner?->order;
        $this->heading = $banner?->heading;
        $this->text = $banner?->text;
        $this->buttonText = $banner?->button_text;
        $this->buttonLink = $banner?->button_link;
        $this->isEnabled = $banner?->is_enabled;
    }

    public function render()
    {
        return view('livewire.edit-create-banner-component',[
            'banner' => $this->banner
        ]);
    }

    public function save()
    {   
        $this->validate([
            'name' => 'required',
            'image' => 'image'
        ]);

        if( Banner::where('name',$this->name)->get()->count() > 0) 
        {
            $this->error = 'Name already exist';
            return;
        }

        $banner_image = 'bg-'.time().'.'.$this->image->extension(); 
        $banner_image_path = $this->image->storeAs('public/uploads/banner',$banner_image);

        $maxOrder = Banner::orderByDesc('order')->first();

        if($this->order == null )
        {
            if($maxOrder != null) $this->order = $maxOrder->order + 1;
            else $this->order = 1;
        }

        Banner::create([
            'name' => $this->name,
            'image' => str_replace("public/","",$banner_image_path),
            'text' => $this->text,
            'heading' => $this->heading,
            'button_text' => $this->buttonText,
            'button_link' => $this->buttonLink,
            'is_enabled' => $this->isEnabled ?? false,
            'order' => $this?->order
        ]);

        return redirect()->route('banner')->with('success','Banner created');
    }

    public function update()
    {
        $this->validate([
            'name' => 'required'
        ]);

        if( Banner::where('name',$this->name)
                    ->whereNotIn('id',[$this->banner->id])
                    ->get()->count() > 0) 
        {
            $this->error = 'Name already exist';
            return;
        }

        $data = [
            'name' => $this->name,
            'text' => $this->text,
            'heading' => $this->heading,
            'button_text' => $this->buttonText,
            'button_link' => $this->buttonLink,
            'is_enabled' => $this->isEnabled,
            'order' => $this->order
        ];
        if($this->image != null)
        {
            $banner_image = 'bg-'.time().'.'.$this->image->extension(); 
            $banner_image_path = $this->image->storeAs('public/uploads/banner',$banner_image);
            $data['image'] = str_replace("public/","",$banner_image_path);
        }

        $this->banner->update($data);

        return redirect()->route('banner')->with('success','Banner updated');
    }
}
