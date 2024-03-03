<?php

namespace App\Http\Livewire;

use App\Models\FilterTag;
use App\Models\Tag;
use Livewire\Component;

class EditCreateFilterTagComponent extends Component
{
    public $tags = [];
    public $error;
    
    protected $listeners = ['filterTagUpdated' => 'updateOrder'];

    public function updated($field)
    {
        $this->resetValidation();
    }

    public function mount()
    {
        if(is_null(FilterTag::first()))
        {
            foreach(Tag::get() as $count => $tag)
            {
                $this->tags[$count]['id'] = null;
                $this->tags[$count]['tagId'] = $tag->id;
                $this->tags[$count]['name'] = $tag->name;
            }
        }
        else
        {   
            $tagData = FilterTag::orderBy('order')->get();
            foreach($tagData as $count => $t)
            {
                $this->tags[$count]['id'] = $t->id;
                $this->tags[$count]['tagId'] = $t->tag_id;
                $this->tags[$count]['name'] = Tag::find($t->id)->name;
            }

            $remainingTag = Tag::whereNotIn('id',$tagData->pluck('tag_id')->toArray())->get();

            if(count($remainingTag) > 0)
            {
                $count = count($tagData);
                foreach($remainingTag as $c => $rt)
                {
                    $this->tags[$count + $c]['id'] = null;
                    $this->tags[$count + $c]['tagId'] = $rt->id;
                    $this->tags[$count + $c]['name'] = Tag::find($rt->id)->name;
                } 
            }
        }
    }

    public function render()
    {
        return view('livewire.edit-create-filter-tag-component');
    }

    public function save()
    {   
        if(\Auth::user()->hasRole('edit-filter-tags') || \Auth::user()->hasRole('add-filter-tags'))
        { 
            foreach($this->tags as $count => $tag)
            {
                if( is_null($tag['id']))
                {
                    FilterTag::create(['tag_id' => $tag['tagId'],
                                    'order' => $count + 1]);
                }
                else
                {   
                    $t = FilterTag::find($tag['id']);
                    $t->update(['order' => $count + 1]);
                }
            }


            return redirect()->route('filter-tag')->with('success','Filter tag updated');
        }
        return back();
    }

    public function updateOrder($newOrder)
    {
        $this->tags = $newOrder;
    }
}
