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
        
        $start = ($groups->currentPage() - 1) * $this->limit + 1;
        $end = min($groups->currentPage() * $this->limit, $groups->total());

        return view('livewire.group-component',[
            'groups' => $groups,
            'limit' => $this->limit,
            'start' => $start,
            'end' => $end,
            'total' => $groups->total()
        ]);
    }

    public function changeEvent($value)
    {
        $this->limit = $value;
        $this->resetPage();
    }
}
