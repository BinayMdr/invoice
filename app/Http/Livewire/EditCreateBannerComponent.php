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
    public $text;
    public $heading1;
    public $heading2;
    public $buttonText;
    public $buttonLink;
    public $searchKey;
    public $searchValue;
    public $image;
    public $bannerType = "Main Banner";
    public $isEnabled = false;
    public $showSearch = false;
    public $error;
   
    public function updated($field)
    {
        $this->resetValidation();
    }

    public function mount($banner)
    {
        $this->banner = $banner;
        $this->name = $banner?->name;
        $this->text = $banner?->text;
        $this->heading1 = $banner?->heading_1;
        $this->heading2 = $banner?->heading_2;
        $this->buttonText = $banner?->button_text;
        $this->buttonLink = $banner?->button_link;
        $this->searchKey = $banner?->search_key;
        $this->searchValue = $banner?->search_value;
        $this->bannerType = $banner?->banner_type;
        $this->isEnabled = $banner?->is_enabled;
        $this->showSearch = $banner?->show_search;
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

        Banner::create([
            'name' => $this->name,
            'image' => str_replace("public/","",$banner_image_path),
            'text' => $this->text,
            'heading_1' => $this->heading1,
            'heading_2' => $this->heading2,
            'button_text' => $this->buttonText,
            'button_link' => $this->buttonLink,
            'search_key' => $this->searchKey,
            'search_value' => $this->searchValue,
            'banner_type' => $this->bannerType,
            'is_enabled' => $this->isEnabled,
            'show_search' => $this->showSearch
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
            'heading_1' => $this->heading1,
            'heading_2' => $this->heading2,
            'button_text' => $this->buttonText,
            'button_link' => $this->buttonLink,
            'search_key' => $this->searchKey,
            'search_value' => $this->searchValue,
            'banner_type' => $this->bannerType,
            'is_enabled' => $this->isEnabled,
            'show_search' => $this->showSearch
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
