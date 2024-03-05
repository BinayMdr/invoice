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
    public $tempBannerImage;
    public $topText;
    public $tempFooterImage;
    public $footerHeading;
    public $footerText;
    public $footerPlaceholder;
    public $footerSlogan;
    public $filterTag;
    public $filterProduct;
    public $relatedProduct;
    public $fbLink;
    public $tiktokLink;
    public $pinterestLink;
    public $instaLink;
    public $tempLoadingImage;
    public $chatScript;
    public $error;

    public function mount()
    {
        $this->settings = Setting::get()->pluck('value','key');
        $this->name = $this->settings['name'];
        $this->topText = $this->settings['top-text'];
        $this->footerHeading = $this->settings['footer-heading'];
        $this->footerPlaceholder = $this->settings['footer-placeholder'];
        $this->footerText = $this->settings['footer-text'];
        $this->footerSlogan = $this->settings['footer-slogan'];
        $this->filterTag = $this->settings['filter-tag'];
        $this->filterProduct = $this->settings['filter-product'];
        $this->relatedProduct = $this->settings['related-product'];
        $this->fbLink = $this->settings['fb-link'];
        $this->tiktokLink = $this->settings['tik-tok-link'];
        $this->pinterestLink = $this->settings['pinterest-link'];
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
                'key' => 'top-text'],
                [
                    'value' => $this->topText
                ]
            );

            if($this->tempBannerImage != null)
            {
                $banner_image = 'banner-'.time().'.'.$this->tempBannerImage->extension(); 
                $banner_image_path = $this->tempBannerImage->storeAs('public/uploads/setting',$banner_image);
                Setting::updateOrCreate([
                    'key' => 'banner-image'],
                    [
                        'value' => str_replace("public/","",$banner_image_path)
                    ]
                );
            }

            if($this->tempFooterImage != null)
            {
                $footer_image = 'footer-'.time().'.'.$this->tempFooterImage->extension(); 
                $footer_image_path = $this->tempFooterImage->storeAs('public/uploads/setting',$footer_image);
                Setting::updateOrCreate([
                    'key' => 'footer-image'],
                    [
                        'value' => str_replace("public/","",$footer_image_path)
                    ]
                );
            }

            Setting::updateOrCreate([
                'key' => 'footer-heading'],
                [
                    'value' => $this->footerHeading
                ]
            );

            Setting::updateOrCreate([
                'key' => 'footer-slogan'],
                [
                    'value' => $this->footerSlogan
                ]
            );

            Setting::updateOrCreate([
                'key' => 'footer-placeholder'],
                [
                    'value' => $this->footerPlaceholder
                ]
            );

            Setting::updateOrCreate([
                'key' => 'footer-text'],
                [
                    'value' => $this->footerText
                ]
            );

            Setting::updateOrCreate([
                'key' => 'filter-tag'],
                [
                    'value' => $this->filterTag
                ]
            );

            Setting::updateOrCreate([
                'key' => 'filter-product'],
                [
                    'value' => $this->filterProduct
                ]
            );

            Setting::updateOrCreate([
                'key' => 'related-product'],
                [
                    'value' => $this->relatedProduct
                ]
            );

            
            Setting::updateOrCreate([
                'key' => 'fb-link'],
                [
                    'value' => $this->fbLink
                ]
            );
            

           
            Setting::updateOrCreate([
                'key' => 'tik-tok-link'],
                [
                    'value' => $this->tiktokLink
                ]
            );
            

            
            Setting::updateOrCreate([
                'key' => 'pinterest-link'],
                [
                    'value' => $this->pinterestLink
                ]
            );
            

           
            Setting::updateOrCreate([
                'key' => 'insta-link'],
                [
                    'value' => $this->instaLink
                ]
            );
            

            if($this->tempLoadingImage != null)
            {
                $loading_image = 'loading-'.time().'.'.$this->tempFooterImage->extension(); 
                $loading_image_path = $this->tempFooterImage->storeAs('public/uploads/setting',$loading_image);
                Setting::updateOrCreate([
                    'key' => 'loading-image'],
                    [
                        'value' => str_replace("public/","",$loading_image_path)
                    ]
                );
            }

            if($this->chatScript != null && $this->chatScript != "")
            {
                Setting::updateOrCreate([
                    'key' => 'chat-script'],
                    [
                        'value' => $this->chatScript
                    ]
                );
            }

            return redirect()->route('setting')->with('success','Settings updated');
        }
        return back();
    }
  


}
