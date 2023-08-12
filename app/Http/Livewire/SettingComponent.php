<?php

namespace App\Http\Livewire;

use App\Models\Branch;
use App\Models\Setting;
use Livewire\Component;

class SettingComponent extends Component
{
    public $branchDetail = [];
    public $name = "";
    public $address = "";
    public $phoneNumber = "";
    public $sideBarColour = "";
    public $sidenavType = "";
    public $taskType = "Create";
    public $branchId = null;

    public function render()
    {
        if(session()->has('branchId')) $this->branchId =  session()->pull('branchId');

        if(!is_null($this->branchId))    $this->branchDetail = Branch::find($this->branchId);
        else $this->branchDetail = Branch::first();
        
        $settings = Setting::where('branch_id',$this->branchDetail->id)->first();
        if(!is_null($settings))
        {
            $this->name = $settings->name;
            $this->address = $settings->address;
            $this->phoneNumber = $settings->number;
            $this->sideBarColour = $settings->side_bar_colour;
            $this->sidenavType = $settings->side_nav_type;
            $this->taskType = "Update";
        }
        else
        {
            $this->name = "";
            $this->address = "";
            $this->phoneNumber = "";
            $this->sideBarColour = "";
            $this->sidenavType = "";
            $this->taskType = "Create";
        }   

        return view('livewire.setting-component',[
            'name' => $this->name,
            'address' => $this->address,
            'phoneNumber' => $this->phoneNumber,
            'sideBarColour' => $this->sideBarColour,
            'sidenavType' => $this->sidenavType,
            'taskType' => $this->taskType,
            'branchDetail' => $this->branchDetail
        ]);
    }

    public function changeEvent($branchId)
    {
        $this->branchId = $branchId;
    }


}
