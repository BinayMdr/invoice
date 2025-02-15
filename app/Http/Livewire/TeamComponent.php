<?php

namespace App\Http\Livewire;

use App\Models\Team;
use Livewire\Component;
use Livewire\WithPagination;
class TeamComponent extends Component
{ 
    use WithPagination;

    public $search = "";
    public $limit = 10;

    protected $paginationTheme = 'bootstrap';
    
    public function render()
    {   
        $teams = new Team(); 

        if($this->search != "") 
        {
            $keyword  = $this->search;

            $teams = $teams->where(function($q) use ($keyword){
                $q->where('name','like','%'.$keyword.'%');
            });
        }
        $teams = $teams->orderBy('created_at','desc')
                            ->paginate($this->limit);
        
        $start = ($teams->currentPage() - 1) * $this->limit + 1;
        $end = min($teams->currentPage() * $this->limit, $teams->total());

        return view('livewire.team-component',[
            'teams' => $teams,
            'limit' => $this->limit,
            'start' => $start,
            'end' => $end,
            'total' => $teams->total()
        ]);
    }

    public function changeEvent($value)
    {
        $this->limit = $value;
        $this->resetPage();
    }
   
}
