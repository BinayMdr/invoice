<?php

namespace App\Http\Livewire;

use App\Models\PopUp;
use Livewire\Component;
use Livewire\WithPagination;

class PopUpComponent extends Component
{
    use WithPagination;

    public $search = "";
    public $limit = 10;

    protected $paginationTheme = 'bootstrap';
    
    public function render()
    {   
        $popUps = new PopUp(); 

        if($this->search != "") 
        {
            $keyword  = $this->search;

            $popUps = $popUps->where(function($q) use ($keyword){
                $q->where('name','like','%'.$keyword.'%');
            });
        }
        $popUps = $popUps->orderBy('created_at','desc')
                            ->paginate($this->limit);
        
        return view('livewire.pop-up-component',[
            'popUps' => $popUps,
            'limit' => $this->limit
        ]);
    }

    public function changeEvent($value)
    {
        $this->limit = $value;
    }
}
