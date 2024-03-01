<?php

namespace App\Http\Livewire;

use App\Models\Brand;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditCreateBrandComponent extends Component
{
    use WithFileUploads;
    public $brands = [];
    public $error;
    
    public function updated($field)
    {
        $this->resetValidation();
    }

    public function mount()
    {

        if(is_null(Brand::first()))
        {
            $this->brands = [];
            $this->brands[0]['id'] = null;
            $this->brands[0]['name'] = '';
            $this->brands[0]['is_enabled'] = false;
        }
        else
        {
            $data = Brand::all();

            foreach($data as $count => $d)
            {
                $this->brands[$count]['id'] =  $d->id;
                $this->brands[$count]['name'] = $d->name;
                $this->brands[$count]['is_enabled'] = $d->is_enabled;
            }
        }
    }

    public function render()
    {
        return view('livewire.edit-create-brand-component');
    }

    public function addMore()
    {
        $count = count($this->brands);
        $this->brands[$count]['id'] = null;
        $this->brands[$count]['name'] = '';
        $this->brands[$count]['is_enabled'] = false;
    }

    public function updateData($value,$count,$key)
    {
        if( $key == "name") $this->brands[$count][$key] = $value;
        else $this->brands[$count][$key] = !$this->brands[$count][$key];
    }

    public function save()
    {   
        if(\Auth::user()->hasRole('edit-brands') || \Auth::user()->hasRole('add-brands'))
        { 

            foreach($this->brands as $count => $brand)
            {
                if($count == 0 && $brand['name'] == "")
                {
                    $this->error = 'Please provide at leate one data';
                    return;
                }

                if( is_null($brand['id']))
                {
                    if(($brand['name']) == "") continue;
                    Brand::create(['name' => $brand['name'],
                                    'is_enabled' => $brand['is_enabled']]);
                }
                else
                {   
                    $c = Brand::find($brand['id']);
                    $c->update(['name' => $brand['name'],
                    'is_enabled' => $brand['is_enabled']]);
                }
            }


            return redirect()->route('brand')->with('success','Brand updated');
        }
        return back();
    }

}
