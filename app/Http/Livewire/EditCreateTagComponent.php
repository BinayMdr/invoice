<?php

namespace App\Http\Livewire;

use App\Models\Tag;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditCreateTagComponent extends Component
{
    use WithFileUploads;
    public $tags = [];
    public $error;
    
    public function updated($field)
    {
        $this->resetValidation();
    }

    public function mount()
    {

        if(is_null(Tag::first()))
        {
            $this->tags = [];
            $this->tags[0]['id'] = null;
            $this->tags[0]['name'] = '';
            $this->tags[0]['is_enabled'] = false;
        }
        else
        {
            $data = Tag::all();

            foreach($data as $count => $d)
            {
                $this->tags[$count]['id'] =  $d->id;
                $this->tags[$count]['name'] = $d->name;
                $this->tags[$count]['is_enabled'] = $d->is_enabled;
            }
        }
    }

    public function render()
    {
        return view('livewire.edit-create-tag-component');
    }

    public function addMore()
    {
        $count = count($this->tags);
        $this->tags[$count]['id'] = null;
        $this->tags[$count]['name'] = '';
        $this->tags[$count]['is_enabled'] = false;
    }

    public function updateData($value,$count,$key)
    {
        if( $key == "name") $this->tags[$count][$key] = $value;
        else $this->tags[$count][$key] = !$this->tags[$count][$key];
    }

    public function save()
    {   
        if(\Auth::user()->hasRole('edit-tags') || \Auth::user()->hasRole('add-tags'))
        { 

            foreach($this->tags as $count => $tag)
            {
                if($count == 0 && $tag['name'] == "")
                {
                    $this->error = 'Please provide at leate one data';
                    return;
                }

                if( is_null($tag['id']))
                {
                    if(($tag['name']) == "") continue;
                    Tag::create(['name' => $tag['name'],
                                    'is_enabled' => $tag['is_enabled']]);
                }
                else
                {   
                    $c = Tag::find($tag['id']);
                    $c->update(['name' => $tag['name'],
                    'is_enabled' => $tag['is_enabled']]);
                }
            }


            return redirect()->route('tag')->with('success','Tag updated');
        }
        return back();
    }

}
