<?php

namespace App\Http\Livewire;

use App\Models\Branch;
use Livewire\Component;
use Livewire\WithPagination;

class BranchComponent extends Component
{
    use WithPagination;

    public $search = "";
    public $limit = 10;

    protected $paginationTheme = 'bootstrap';
    
    public function render()
    {
        if($this->search != "") $branches = Branch::where('name','like','%'.$this->search.'%')->paginate($this->limit);
        else $branches = Branch::paginate($this->limit);
        return view('livewire.branch-component',[
            'branches' => $branches,
            'limit' => $this->limit
        ]);
    }

    public function changeEvent($value)
    {
        $this->limit = $value;
    }
}
