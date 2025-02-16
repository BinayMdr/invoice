<?php

namespace App\Http\Livewire;

use App\Models\Message;
use Livewire\Component;
use Livewire\WithPagination;

class MessageComponent extends Component
{
    use WithPagination;

    public $search = "";
    public $limit = 10;

    protected $paginationTheme = 'bootstrap';
    
    public function render()
    {   
        $messages = new Message();

        if($this->search != "") 
        {
            $keyword  = $this->search;

            $messages = $messages->where(function($q) use ($keyword){
                $q->where('name','like','%'.$keyword.'%');
            });
        }

        $messages = $messages->orderBy('created_at','desc')
                            ->paginate($this->limit);
        
        $start = ($messages->currentPage() - 1) * $this->limit + 1;
        $end = min($messages->currentPage() * $this->limit, $messages->total());

        return view('livewire.message-component',[
            'messages' => $messages,
            'limit' => $this->limit,
            'start' => $start,
            'end' => $end,
            'total' => $messages->total()
        ]);
    }

    public function changeEvent($value)
    {
        $this->limit = $value;
        $this->resetPage();
    }

}
