<?php

namespace App\Http\Livewire;

use App\Models\Team;
use Livewire\Component;
use Livewire\WithFileUploads;
class EditCreateTeamComponent extends Component
{
    use WithFileUploads;
    public $team;
    public $name;
    public $order = null;
    public $designation;
    public $image;
    public $isEnabled = false;
    public $error;
   
    public function updated($field)
    {
        $this->resetValidation();
    }

    public function mount($team)
    {
        $this->team = $team;
        $this->name = $team?->name;
        $this->order = $team?->order;
        $this->designation = $team?->designation;
        $this->isEnabled = $team?->is_enabled;
    }

    public function render()
    {
        return view('livewire.edit-create-team-component',[
            'team' => $this->team
        ]);
    }

    public function save()
    {   
        $this->validate([
            'name' => 'required',
            'image' => 'image',
            'designation' => 'required'
        ]);


        $team_image = 'bg-'.time().'.'.$this->image->extension(); 
        $team_image_path = $this->image->storeAs('public/uploads/team',$team_image);

        $maxOrder = Team::orderByDesc('order')->first();

        if($this->order == null )
        {
            if($maxOrder != null) $this->order = $maxOrder->order + 1;
            else $this->order = 1;
        }
        Team::create([
            'name' => $this->name,
            'image' => str_replace("public/","",$team_image_path),
            'designation' => $this->designation,
            'is_enabled' => $this->isEnabled ?? false,
            'order' => $this->order
        ]);

        return redirect()->route('team')->with('success','Team created');
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'designation' => 'required'
        ]);

    
        $data = [
            'name' => $this->name,
            'designation' => $this->designation,
            'is_enabled' => $this->isEnabled,
            'order' => $this->order
        ];
        if($this->image != null)
        {
            $team_image = 'bg-'.time().'.'.$this->image->extension(); 
            $team_image_path = $this->image->storeAs('public/uploads/team',$team_image);
            $data['image'] = str_replace("public/","",$team_image_path);
        }

        $this->team->update($data);

        return redirect()->route('team')->with('success','Team updated');
    }
}
