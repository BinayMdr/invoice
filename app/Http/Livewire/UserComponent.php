<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserComponent extends Component
{
    use WithPagination;

    public $search = "";
    public $limit = 10;

    protected $paginationTheme = 'bootstrap';
    
    public function render()
    {   
        $superAdmin = User::where('email','super@admin.com')->first();

        $users = User::whereNotIn('id',[$superAdmin->id]); 

        if($this->search != "") 
        {
            $keyword  = $this->search;

            $users = $users->where(function($q) use ($keyword){
                $q->where('name','like','%'.$keyword.'%')
                    ->orWhere('email','like','%'.$keyword.'%');
            });
        }
        $users = $users->orderBy('created_at','desc')->paginate($this->limit);
        
        $start = ($users->currentPage() - 1) * $this->limit + 1;
        $end = min($users->currentPage() * $this->limit, $users->total());

        return view('livewire.user-component',[
            'users' => $users,
            'limit' => $this->limit,
            'start' => $start,
            'end' => $end,
            'total' => $users->total()
        ]);
    }

    public function changeEvent($value)
    {
        $this->limit = $value;
        $this->resetPage();
    }
}
