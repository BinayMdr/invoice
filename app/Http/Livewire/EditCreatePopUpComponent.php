<?php

namespace App\Http\Livewire;

use App\Models\PopUp;
use Livewire\Component;
use Livewire\WithFileUploads;


class EditCreatePopUpComponent extends Component
{

    use WithFileUploads;
    public $popUp;
    public $name;
    public $link;
    public $searchKey;
    public $searchValue;
    public $image;
    public $order = null;
    public $isEnabled = false;
    public $showSearch = false;
    public $error;
   
    public function updated($field)
    {
        $this->resetValidation();
    }

    public function mount($popUp)
    {
        $this->popUp = $popUp;
        $this->name = $popUp?->name;
        $this->link = $popUp?->link;
        $this->isEnabled = $popUp?->is_enabled;
        $this->order = $popUp?->order;
    }

    public function render()
    {
        return view('livewire.edit-create-pop-up-component',[
            'popUp' => $this->popUp
        ]);
    }


    public function save()
    {   
        $this->validate([
            'name' => 'required',
            'image' => 'image',
            // 'link' => 'required'
        ]);

        if( PopUp::where('name',$this->name)->get()->count() > 0) 
        {
            $this->error = 'Name already exist';
            return;
        }

        $pop_up_image = 'popup-'.time().'.'.$this->image->extension(); 
        $pop_up_image_path = $this->image->storeAs('public/uploads/pop-up',$pop_up_image);

        $maxOrder = PopUp::orderByDesc('order')->first();
        
        if($this->order == null )
        {
            if($maxOrder != null) $this->order = $maxOrder->order + 1;
            else $this->order = 1;
        }

        PopUp::create([
            'name' => $this->name,
            'image' => str_replace("public/","",$pop_up_image_path),
            // 'link' => $this->link,
            'is_enabled' => $this->isEnabled ?? false,
            'order' => $this->order 
        ]);

        return redirect()->route('pop-up')->with('success','Popup created');
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'link' => 'required'
        ]);

        if( PopUp::where('name',$this->name)
                    ->whereNotIn('id',[$this->popUp->id])
                    ->get()->count() > 0) 
        {
            $this->error = 'Name already exist';
            return;
        }

        $data = [
            'name' => $this->name,
            'link' => $this->link,
            'is_enabled' => $this->isEnabled ?? false,
            'order' => $this->order
        ];
        if($this->image != null)
        {
            $pop_up_image = 'popup-'.time().'.'.$this->image->extension(); 
            $pop_up_image_path = $this->image->storeAs('public/uploads/pop-up',$pop_up_image);
            $data['image'] = str_replace("public/","",$pop_up_image_path);
        }

        $this->popUp->update($data);

        return redirect()->route('pop-up')->with('success','Popup updated');
    }
}
