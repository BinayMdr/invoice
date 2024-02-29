<?php

namespace App\Http\Livewire;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditCreateCategoryComponent extends Component
{
    use WithFileUploads;
    public $categories = [];
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

        if(is_null(Category::first()))
        {
            $this->categories = [];
            $this->categories[0]['id'] = null;
            $this->categories[0]['name'] = '';
            $this->categories[0]['is_enabled'] = false;
        }
        else
        {
            $data = Category::all();

            foreach($data as $count => $d)
            {
                $this->categories[$count]['id'] =  $d->id;
                $this->categories[$count]['name'] = $d->name;
                $this->categories[$count]['is_enabled'] = $d->is_enabled;
            }
        }
    }

    public function render()
    {
        return view('livewire.edit-create-category-component');
    }

    public function addMore()
    {
        $count = count($this->categories);
        $this->categories[$count]['id'] = null;
        $this->categories[$count]['name'] = '';
        $this->categories[$count]['is_enabled'] = false;
    }

    public function updateData($value,$count,$key)
    {
        if( $key == "name") $this->categories[$count][$key] = $value;
        else $this->categories[$count][$key] = !$this->categories[$count][$key];
    }

    public function save()
    {   
        if(\Auth::user()->hasRole('edit-categories') || \Auth::user()->hasRole('add-categories'))
        { 

            foreach($this->categories as $count => $category)
            {
                if($count == 0 && $category['name'] == "")
                {
                    $this->error = 'Please provide at leate one data';
                    return;
                }

                if( is_null($category['id']))
                {
                    if(($category['name']) == "") continue;
                    Category::create(['name' => $category['name'],
                                    'is_enabled' => $category['is_enabled']]);
                }
                else
                {   
                    $c = Category::find($category['id']);
                    $c->update(['name' => $category['name'],
                    'is_enabled' => $category['is_enabled']]);
                }
            }


            return redirect()->route('category')->with('success','Category updated');
        }
        return back();
    }


}
