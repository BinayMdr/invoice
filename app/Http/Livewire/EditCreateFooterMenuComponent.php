<?php

namespace App\Http\Livewire;

use App\Models\FooterMenu;
use App\Models\SubFooterMenu;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditCreateFooterMenuComponent extends Component
{
    use WithFileUploads;
    public $footerMenu;
    public $name;
    public $subMenus = [];
    public $error;

    
    public function updated($field)
    {
        $this->resetValidation();
    }

    public function mount($footerMenu)
    {
        $this->footerMenu = $footerMenu;
        $this->name = $footerMenu?->name;
        if(!is_null($footerMenu?->subFooterMenu))
        {
            foreach($footerMenu?->subFooterMenu as $count => $subFooterMenu)
            {
                $this->subMenus[$count]['name'] = $subFooterMenu['name'];
                $this->subMenus[$count]['link'] = $subFooterMenu['link'];
                $this->subMenus[$count]['searchKey'] = $subFooterMenu['search_key'];
                $this->subMenus[$count]['searchValue'] = $subFooterMenu['search_value'];
                $this->subMenus[$count]['showSearch'] = $subFooterMenu['show_search'];
            }
        }

        else $this->subMenus = $footerMenu?->subFooterMenu;
    }

    public function render()
    {
        return view('livewire.edit-create-footer-menu-component',[
            'footerMenu' => $this->footerMenu
        ]);
    }

    public function addSubMenu()
    {
        if(is_null($this->subMenus)) $checkCount = 0; 
        else $checkCount = count($this->subMenus);

        if($checkCount == 0)
        {
            $this->subMenus[0]['name'] = '';
            $this->subMenus[0]['link'] = '';
            $this->subMenus[0]['searchKey'] = '';
            $this->subMenus[0]['searchValue'] = '';
            $this->subMenus[0]['showSearch'] = false;
        }
        else
        {
            $count = 0;
            foreach($this->subMenus as $count => $subMenu)
            {
                $count;
            }
            
            $count = $count + 1;
            $this->subMenus[$count]['name'] = '';
            $this->subMenus[$count]['link'] = '';
            $this->subMenus[$count]['searchKey'] = '';
            $this->subMenus[$count]['searchValue'] = '';
            $this->subMenus[$count]['showSearch'] = false;
        }
    }

    public function updateSubMenu($value,$count,$key)
    {
        if($key == "showSearch")
        {
            $this->subMenus[$count][$key] = !$this->subMenus[$count][$key];
            
        }
        else $this->subMenus[$count][$key] = $value;
    }

    public function deleteSubMenu($count)
    {
        $data = $this->subMenus;

        $this->subMenus = [];
        foreach($data as $c => $d)
        {
            if($c != $count)
            {
                $this->subMenus[$c]['name'] = $d['name'];
                $this->subMenus[$c]['link'] = $d['link'];
                $this->subMenus[$c]['searchKey'] = $d['searchKey'];
                $this->subMenus[$c]['searchValue'] = $d['searchValue'];
                $this->subMenus[$c]['showSearch'] = $d['showSearch'];
            }
        }
    }
    public function save()
    {   
        $this->validate([
            'name' => 'required',
            'subMenus' => 'required'
        ]);

        if( FooterMenu::where('name',$this->name)->get()->count() > 0) 
        {
            $this->error = 'Name already exist';
            return;
        }

        $footerMenuData = FooterMenu::create(['name' => $this->name]);

        foreach($this->subMenus as $subMenu)
        {
            SubFooterMenu::create([
                'footer_menu_id' => $footerMenuData->id,
                'name' => $subMenu['name'],
                'link' => $subMenu['link'],
                'search_key' => $subMenu['searchKey'],
                'search_value' => $subMenu['searchValue'],
                'show_search' => $subMenu['showSearch']
            ]);
        }

        return redirect()->route('footer-menu')->with('success','Footer menu created');
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'subMenus' => 'required'
        ]);

        if( FooterMenu::where('name',$this->name)
                    ->whereNotIn('id',[$this->footerMenu->id])
                    ->get()->count() > 0) 
        {
            $this->error = 'Name already exist';
            return;
        }

        $this->footerMenu->update(['name' => $this->name]);

        
        SubFooterMenu::where('footer_menu_id',$this->footerMenu->id)->delete();

        foreach($this->subMenus as $subMenu)
        {
            SubFooterMenu::create([
                'footer_menu_id' => $this->footerMenu->id,
                'name' => $subMenu['name'],
                'link' => $subMenu['link'],
                'search_key' => $subMenu['searchKey'],
                'search_value' => $subMenu['searchValue'],
                'show_search' => $subMenu['showSearch']
            ]);
        }

        return redirect()->route('footer-menu')->with('success','Footer menu updated');
    }
}
