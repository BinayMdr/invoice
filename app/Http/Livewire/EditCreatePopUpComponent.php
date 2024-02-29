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
    public $isEnabled = false;
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
        $this->searchKey = $popUp?->search_key;
        $this->searchValue = $popUp?->search_value;
        $this->isEnabled = $popUp?->is_enabled;
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
            'link' => 'required'
        ]);

        if( PopUp::where('name',$this->name)->get()->count() > 0) 
        {
            $this->error = 'Name already exist';
            return;
        }

        $pop_up_image = 'bg-'.time().'.'.$this->image->extension(); 
        $pop_up_image_path = $this->image->storeAs('public/uploads/pop-up',$pop_up_image);

        PopUp::create([
            'name' => $this->name,
            'image' => str_replace("public/","",$pop_up_image_path),
            'link' => $this->link,
            'search_key' => $this->searchKey,
            'search_value' => $this->searchValue,
            'is_enabled' => $this->isEnabled
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
            'search_key' => $this->searchKey,
            'search_value' => $this->searchValue,
            'is_enabled' => $this->isEnabled
        ];
        if($this->image != null)
        {
            $pop_up_image = 'bg-'.time().'.'.$this->image->extension(); 
            $pop_up_image_path = $this->image->storeAs('public/uploads/pop-up',$pop_up_image);
            $data['image'] = str_replace("public/","",$pop_up_image_path);
        }

        $this->popUp->update($data);

        return redirect()->route('pop-up')->with('success','Popup updated');
    }
}
