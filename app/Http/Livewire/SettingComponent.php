<?php

namespace App\Http\Livewire;

use App\Models\Setting;
use Livewire\Component;
use Livewire\WithFileUploads;

class SettingComponent extends Component
{
    use WithFileUploads;
    public $settings;

    public $name;
    public $address;
    public $googleMap;
    public $email;
    public $number;
    public $facebookLink;
    public $tiktokLink;
    public $youtubeLink;
    public $instaLink;
    public $chatScript;
    public $error;
    public $tempBannerImage;

    public function mount()
    {
        $this->settings = Setting::get()->pluck('value','key');
        $this->name = $this->settings['name'];
        $this->address = $this->settings['address'];
        $this->googleMap = $this->settings['google-map'];
        $this->email = $this->settings['email'];
        $this->number = $this->settings['number'];
        $this->facebookLink = $this->settings['facebook-link'];
        $this->tiktokLink = $this->settings['tik-tok-link'];
        $this->youtubeLink = $this->settings['youtube-link'];
        $this->instaLink = $this->settings['insta-link'];
        $this->chatScript = $this->settings['chat-script'];

    }

    public function render()
    {
        return view('livewire.setting-component');
    }

    public function save()
    {
        if(\Auth::user()->hasRole('add-settings') || \Auth::user()->hasRole('edit-settings'))
        {

            Setting::updateOrCreate(
                ['key' => 'name'],
                [
                    'value' => $this->name
                ]
            );

            Setting::updateOrCreate([
                'key' => 'address'],
                [
                    'value' => $this->address
                ]
            );

            Setting::updateOrCreate([
                'key' => 'google-map'],
                [
                    'value' => $this->googleMap
                ]
            );
         
            Setting::updateOrCreate([
                'key' => 'email'],
                [
                    'value' => $this->email
                ]
            );

            Setting::updateOrCreate([
                'key' => 'number'],
                [
                    'value' => $this->number
                ]
            );

            Setting::updateOrCreate([
                'key' => 'facebook-link'],
                [
                    'value' => $this->facebookLink
                ]
            );
            
           
            Setting::updateOrCreate([
                'key' => 'tik-tok-link'],
                [
                    'value' => $this->tiktokLink
                ]
            );
            

            
            Setting::updateOrCreate([
                'key' => 'youtube-link'],
                [
                    'value' => $this->youtubeLink
                ]
            );
            

           
            Setting::updateOrCreate([
                'key' => 'insta-link'],
                [
                    'value' => $this->instaLink
                ]
            );
            

            if($this->tempBannerImage != null)
            {
                $banner_image = 'loading-'.time().'.'.$this->tempBannerImage->extension(); 
                $banner_image_path = $this->tempBannerImage->storeAs('public/uploads/setting',$banner_image);
                Setting::updateOrCreate([
                    'key' => 'banner-image'],
                    [
                        'value' => str_replace("public/","",$banner_image_path)
                    ]
                );
            }

            
            Setting::updateOrCreate([
                'key' => 'chat-script'],
                [
                    'value' => $this->chatScript
                ]
            );
            

            return redirect()->route('setting')->with('success','Settings updated');
        }
        return back();
    }
  


}
