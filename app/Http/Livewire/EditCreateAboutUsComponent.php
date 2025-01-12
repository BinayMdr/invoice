<?php

namespace App\Http\Livewire;

use App\Models\AboutUs;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditCreateAboutUsComponent extends Component
{
    use WithFileUploads;
    public $aboutUs;
    public $heading1;
    public $heading2;
    public $heading3;
    public $text1;
    public $text2;
    public $text3;
    public $topBanner;
    public $showLowerBanner = false;
    public $lowerBanner;
    public $quote;
    public $author;
    public $designation;
    public $error;
    public $lowerBannerCopy;

    public function updated($field)
    {
        $this->resetValidation();
    }

    public function mount()
    {
        $this->aboutUs = AboutUs::first();
        $this->heading1 = $this->aboutUs?->heading_1;
        $this->heading2 = $this->aboutUs?->heading_2;
        $this->heading3 = $this->aboutUs?->heading_3;
        $this->text1 = $this->aboutUs?->text_1;
        $this->text2 = $this->aboutUs?->text_2;
        $this->text3 = $this->aboutUs?->text_3;
        $this->showLowerBanner = $this->aboutUs?->show_lower_banner ?? false;
        $this->quote = $this->aboutUs?->quote;
        $this->author = $this->aboutUs?->author;
        $this->designation = $this->aboutUs?->designation;
        $this->lowerBannerCopy = $this->aboutUs?->lower_banner;
    }

    public function render()
    {
        return view('livewire.edit-create-about-us-component');
    }

    public function save()
    {   
        if(\Auth::user()->hasRole('edit-about-us') || \Auth::user()->hasRole('add-about-us'))
        { 
            $validateData = [
                'heading1' => 'required',
                'heading2' => 'required',
                'heading3' => 'required',
                'text1' => 'required',
                'text2' => 'required',
                'text3' => 'required',
                'showLowerBanner' => 'required' 
            ];

            if(is_null($this->aboutUs)) $validateData['topBanner'] = 'required';

            $this->validate($validateData);

            
            if(!is_null($this->topBanner))
            {
                $top_banner_image = 'bg-'.time().'.'.$this->topBanner->extension(); 
                $top_banner_image_path = $this->topBanner->storeAs('public/uploads/about-us',$top_banner_image);
            }
            
            if(!is_null($this->lowerBanner))
            {
                $lower_banner_image = 'bg-'.time().'.'.$this->lowerBanner->extension(); 
                $lower_banner_image_path = $this->lowerBanner->storeAs('public/uploads/about-us',$lower_banner_image);
            }

            $data = [
                'heading_1' => $this->heading1,
                'heading_2' => $this->heading2,
                'heading_3' => $this->heading3,
                'text_1' => $this->text1,
                'text_2' => $this->text2,
                'text_3' => $this->text3,
                'top_banner' => !is_null($this->topBanner) ? str_replace("public/","",$top_banner_image_path) : $this->aboutUs->top_banner,
                'show_lower_banner' => $this->showLowerBanner,
                'author' => $this->author,
                'designation' => $this->designation,
                'quote' => $this->quote,
                'lower_banner' => !is_null($this->lowerBanner) ? str_replace("public/","",$lower_banner_image_path) : $this->lowerBannerCopy,
            ];

            if(is_null($this->aboutUs)) AboutUs::create($data);
            else $this->aboutUs->update($data);


            return redirect()->route('about-us')->with('success','About us updated');
        }
        return back();
    }

    public function removeLowerBannerFromDB()
    {
        $this->lowerBannerCopy = null;
        $this->aboutUs->lower_banner = null;

    }

    public function removeLowerBanner()
    {
        $this->lowerBanner = null;
    }
}
