<?php

namespace App\Http\Livewire;

use App\Models\CustomerReview;
use Livewire\Component;
use Livewire\WithPagination;
class CustomerReviewComponent extends Component
{
    use WithPagination;

    public $search = "";
    public $limit = 10;

    protected $paginationTheme = 'bootstrap';
    
    public function render()
    {   
        $customerReviews = new CustomerReview(); 

        if($this->search != "") 
        {
            $keyword  = $this->search;

            $customerReviews = $customerReviews->where(function($q) use ($keyword){
                $q->where('name','like','%'.$keyword.'%');
            });
        }
        $customerReviews = $customerReviews->orderBy('created_at','desc')
                            ->paginate($this->limit);
        
        $start = ($customerReviews->currentPage() - 1) * $this->limit + 1;
        $end = min($customerReviews->currentPage() * $this->limit, $customerReviews->total());

        return view('livewire.customer-review-component',[
            'customerReviews' => $customerReviews,
            'limit' => $this->limit,
            'start' => $start,
            'end' => $end,
            'total' => $customerReviews->total()
        ]);
    }

    public function changeEvent($value)
    {
        $this->limit = $value;
        $this->resetPage();
    }
}
