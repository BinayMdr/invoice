<?php

namespace App\Http\Livewire;

use App\Models\Certification;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditCreateCertificationComponent extends Component
{   
    use WithFileUploads;

    public $photos = []; 
    public $storedPhotos = []; 
    public $certification = null;
    
    public function mount($certification)
    {
        $this->certification = $certification;
        $this->storedPhotos = Certification::all(); 
    }

    public function updatedPhotos()
    {
        $this->validate([
            'photos.*' => 'image',
        ]);
    }

    public function removePhoto($index)
    {
        if (isset($this->photos[$index])) {
            unset($this->photos[$index]);
        }
        $this->photos = array_values($this->photos); 
    }

    public function removeStoredPhoto($id)
    {
        $storedCertification = Certification::find($id);
        if ($storedCertification && \Storage::disk('public')->exists($storedCertification->image)) {
            \Storage::disk('public')->delete($storedCertification->image);
    
            $storedCertification->delete();
    
            $this->storedPhotos = Certification::where('id', '!=', $id)->get();
        }

        $this->emit('refreshComponent');
    }

    public function update()
    {
        foreach ($this->photos as $photo) {
            $image = 'bg-'.round(microtime(true) * 1000).'.'.$photo->extension(); 
            $image_path = $photo->storeAs('public/uploads/certification',$image);
            Certification::create([
                'image' => str_replace("public/","",$image_path),
            ]);
        }

        if($this->certification) $message = "Certification Updated";
        else $message = "Certification Added";

        return redirect()->route('certification')->with('success',$message);
    }

    public function render()
    {
        return view('livewire.edit-create-certification-component');
    }
}
