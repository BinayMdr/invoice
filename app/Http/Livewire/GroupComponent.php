<?php

namespace App\Http\Livewire;

use App\Models\Group;
use Livewire\Component;
use Livewire\WithPagination;

class GroupComponent extends Component
{
    use WithPagination;

    public $search = "";
    public $limit = 10;

    protected $paginationTheme = 'bootstrap';
    
    public function render()
    {   
        $superGroup = Group::where('name','Super Admin')->first();

        $groups = Group::whereNotIn('id',[$superGroup->id]); 

        // $groups = new Group();

        if($this->search != "") 
        {
            $keyword  = $this->search;

            $groups = $groups->where(function($q) use ($keyword){
                $q->where('name','like','%'.$keyword.'%');
            });
        }
        $groups = $groups->orderBy('created_at','desc')
                            ->paginate($this->limit);
        
        return view('livewire.group-component',[
            'groups' => $groups,
            'limit' => $this->limit
        ]);
    }

    public function changeEvent($value)
    {
        $this->limit = $value;
    }
}
