<?php

namespace App\Http\Livewire;

use App\Models\Banner;
use Livewire\Component;
use Livewire\WithPagination;

class BannerComponent extends Component
{
    use WithPagination;

    public $search = "";
    public $limit = 10;

    protected $paginationTheme = 'bootstrap';
    
    public function render()
    {   
        $banners = new Banner(); 

        if($this->search != "") 
        {
            $keyword  = $this->search;

            $banners = $banners->where(function($q) use ($keyword){
                $q->where('name','like','%'.$keyword.'%');
            });
        }
        $banners = $banners->orderBy('created_at','desc')
                            ->paginate($this->limit);
        
        $start = ($banners->currentPage() - 1) * $this->limit + 1;
        $end = min($banners->currentPage() * $this->limit, $banners->total());

        return view('livewire.banner-component',[
            'banners' => $banners,
            'limit' => $this->limit,
            'start' => $start,
            'end' => $end,
            'total' => $banners->total()
        ]);
    }

    public function changeEvent($value)
    {
        $this->limit = $value;
        $this->resetPage();
    }
}
