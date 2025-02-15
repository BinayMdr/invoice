<?php

namespace App\Http\Livewire;

use App\Models\CustomerReview;
use Livewire\Component;
use Livewire\WithFileUploads;
class EditCreateCustomerReviewComponent extends Component
{   
    
    use WithFileUploads;
    public $customerReview;
    public $name;
    public $review;
    public $order = null;
    public $designation;
    public $image;
    public $isEnabled = false;
    public $error;
   
    public function updated($field)
    {
        $this->resetValidation();
    }

    public function mount($customerReview)
    {
        $this->customerReview = $customerReview;
        $this->name = $customerReview?->name;
        $this->designation = $customerReview?->designation;
        $this->order = $customerReview?->order;
        $this->review = $customerReview?->review;
        $this->isEnabled = $customerReview?->is_enabled;
    }

    public function render()
    {
        return view('livewire.edit-create-customer-review-component',[
            'customerReview' => $this->customerReview
        ]);
    }

    public function save()
    {   
        $this->validate([
            'name' => 'required',
            'image' => 'image',
            'designation' => 'required',
            'review' => 'required'
        ]);


        $customer_review_image = 'bg-'.time().'.'.$this->image->extension(); 
        $customer_review_image_path = $this->image->storeAs('public/uploads/customer-review',$customer_review_image);

        $maxOrder = CustomerReview::orderByDesc('order')->first();

        if($this->order == null )
        {
            if($maxOrder != null) $this->order = $maxOrder->order + 1;
            else $this->order = 1;
        }
        CustomerReview::create([
            'name' => $this->name,
            'image' => str_replace("public/","",$customer_review_image_path),
            'designation' => $this->designation,
            'is_enabled' => $this->isEnabled ?? false,
            'order' => $this->order,
            'review' => $this->review
        ]);

        return redirect()->route('customer-review')->with('success','Customer review created');
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'designation' => 'required',
            'review' => 'required'
        ]);

    
        $data = [
            'name' => $this->name,
            'designation' => $this->designation,
            'is_enabled' => $this->isEnabled,
            'order' => $this->order,
            'review' => $this->review
        ];
        if($this->image != null)
        {
            $customer_review_image = 'bg-'.time().'.'.$this->image->extension(); 
            $customer_review_image_path = $this->image->storeAs('public/uploads/customer-review',$customer_review_image);
            $data['image'] = str_replace("public/","",$customer_review_image_path);
        }

        $this->customerReview->update($data);

        return redirect()->route('customer-review')->with('success','Customer review updated');
    }
}
