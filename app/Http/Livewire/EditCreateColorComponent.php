<?php

namespace App\Http\Livewire;

use App\Models\Color;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditCreateColorComponent extends Component
{
    use WithFileUploads;
    public $colors = [];
    public $error;
    
    protected $listeners = ['colorOrderUpdated' => 'updateOrder'];

    public function updated($field)
    {
        $this->resetValidation();
    }

    public function mount()
    {

        if(is_null(Color::first()))
        {
            $this->colors = [];
            $this->colors[0]['id'] = null;
            $this->colors[0]['name'] = '';
            $this->colors[0]['is_enabled'] = false;
        }
        else
        {
            $data = Color::orderBy('order','asc')->get();

            foreach($data as $count => $d)
            {
                $this->colors[$count]['id'] =  $d->id;
                $this->colors[$count]['name'] = $d->name;
                $this->colors[$count]['is_enabled'] = $d->is_enabled;
            }
        }
    }

    public function render()
    {
        return view('livewire.edit-create-color-component');
    }

    public function addMore()
    {
        $count = count($this->colors);
        $this->colors[$count]['id'] = null;
        $this->colors[$count]['name'] = '';
        $this->colors[$count]['is_enabled'] = false;
    }

    public function updateData($value,$count,$key)
    {
        if( $key == "name") $this->colors[$count][$key] = $value;
        else $this->colors[$count][$key] = !$this->colors[$count][$key];
    }

    public function save()
    {   
        if(\Auth::user()->hasRole('edit-colors') || \Auth::user()->hasRole('add-colors'))
        { 

            foreach($this->colors as $count => $color)
            {
                if($count == 0 && $color['name'] == "")
                {
                    $this->error = 'Please provide at leate one data';
                    return;
                }

                if( is_null($color['id']))
                {
                    if(($color['name']) == "") continue;
                    Color::create(['name' => $color['name'],
                                    'is_enabled' => $color['is_enabled'],'order' => $count + 1]);
                }
                else
                {   
                    $c = Color::find($color['id']);
                    $c->update(['name' => $color['name'],
                    'is_enabled' => $color['is_enabled'],'order' => $count + 1]);
                }
            }


            return redirect()->route('color')->with('success','Color updated');
        }
        return back();
    }

    public function updateOrder($newOrder)
    {
        $this->colors = $newOrder;
    }
}
