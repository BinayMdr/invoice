<?php

namespace App\Http\Livewire;

use App\Models\FooterMenu;
use Livewire\Component;
use Livewire\WithPagination;

class FooterMenuComponent extends Component
{
    use WithPagination;

    public $search = "";
    public $limit = 10;

    protected $paginationTheme = 'bootstrap';
    
    public function render()
    {   
        $footerMenus = new FooterMenu(); 

        if($this->search != "") 
        {
            $keyword  = $this->search;

            $footerMenus = $footerMenus->where(function($q) use ($keyword){
                $q->where('name','like','%'.$keyword.'%');
            });
        }
        $footerMenus = $footerMenus->orderBy('created_at','desc')
                            ->paginate($this->limit);
        
        return view('livewire.footer-menu-component',[
            'footerMenus' => $footerMenus,
            'limit' => $this->limit
        ]);
    }

    public function changeEvent($value)
    {
        $this->limit = $value;
    }
}
